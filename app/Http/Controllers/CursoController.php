<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Recurso;
use App\Models\Horario;
use App\Models\Nivel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class CursoController extends Controller
{
// En app/Http/Controllers/CursoController.php
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Muestra un listado de cursos.
     */
    public function index()
    {
        $cursos = Curso::with(['recurso', 'horario', 'nivel', 'instructor'])->get();
        return view('cursos.index', compact('cursos'));
    }
    
    /**
     * Muestra el formulario para crear un nuevo curso.
     */
    public function create()
    {
        $recursos = Recurso::all();
        $horarios = Horario::all();
        $niveles = Nivel::all();
        $instructores = User::whereHas('rol', function($query) {
            $query->where('rol', 'instructor');
        })->get();
        
        return view('cursos.create', compact('recursos', 'horarios', 'niveles', 'instructores'));
    }
    
    /**
     * Almacena un nuevo curso en la base de datos.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'curso' => 'required|string|max:100',
                'id_recurso' => 'required|exists:recursos,id_recurso',
                'id_horario' => 'required|exists:horarios,id_horario',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after:fecha_inicio',
                'objetivo' => 'required|string|max:255',
                'id_nivel' => 'required|exists:niveles,id_nivel',
                'cupos' => 'required|integer|min:1',
                'id_instructor' => 'required|exists:usuarios,id_usuario',
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $curso = Curso::create([
                'curso' => $request->curso,
                'id_recurso' => $request->id_recurso,
                'id_horario' => $request->id_horario,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'objetivo' => $request->objetivo,
                'id_nivel' => $request->id_nivel,
                'cupos' => $request->cupos,
                'cantidad_alumnos' => 0,
                'id_usuario' => $request->id_instructor,
            ]);
            
            return redirect()->route('cursos.index')->with('success', 'Curso creado exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al crear curso: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al crear el curso. Por favor, inténtalo nuevamente.');
        }
    }
    
    /**
     * Muestra la información de un curso específico.
     */
    public function show($id)
    {
        $curso = Curso::with(['recurso', 'horario', 'nivel', 'instructor', 'inscripciones.usuario', 'evaluaciones.usuario'])->findOrFail($id);
        return view('cursos.show', compact('curso'));
    }
    
    /**
     * Muestra el formulario para editar un curso existente.
     */
    public function edit($id)
    {
        $curso = Curso::findOrFail($id);
        $recursos = Recurso::all();
        $horarios = Horario::all();
        $niveles = Nivel::all();
        $instructores = User::whereHas('rol', function($query) {
            $query->where('rol', 'instructor');
        })->get();
        
        return view('cursos.edit', compact('curso', 'recursos', 'horarios', 'niveles', 'instructores'));
    }
    
    /**
     * Actualiza la información de un curso existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $curso = Curso::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'curso' => 'required|string|max:100',
            'id_recurso' => 'required|exists:recursos,id_recurso',
            'id_horario' => 'required|exists:horarios,id_horario',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'objetivo' => 'required|string|max:255',
            'id_nivel' => 'required|exists:niveles,id_nivel',
            'cupos' => 'required|integer|min:' . $curso->cantidad_alumnos,
            'id_instructor' => 'required|exists:usuarios,id_usuario',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $curso->update([
            'curso' => $request->curso,
            'id_recurso' => $request->id_recurso,
            'id_horario' => $request->id_horario,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'objetivo' => $request->objetivo,
            'id_nivel' => $request->id_nivel,
            'cupos' => $request->cupos,
            'id_usuario' => $request->id_instructor,
        ]);
        
        return redirect()->route('cursos.index')->with('success', 'Curso actualizado exitosamente');
    }
    
    /**
     * Elimina un curso de la base de datos.
     */
    public function destroy($id)
    {
        $curso = Curso::findOrFail($id);
        
        if ($curso->cantidad_alumnos > 0) {
            return redirect()->route('cursos.index')->with('error', 'No se puede eliminar un curso con estudiantes inscritos');
        }
        
        $curso->delete();
        
        return redirect()->route('cursos.index')->with('success', 'Curso eliminado exitosamente');
    }
}
