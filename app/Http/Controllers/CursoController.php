<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Recurso;
use App\Models\Horario;
use App\Models\Nivel;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CursoController extends Controller
{
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
        // Solo obtener usuarios con el rol "Instructor"
        $instructores = Usuario::whereHas('rol', function($query) {
            $query->where('Rol', 'Instructor');
        })->get();
        
        return view('cursos.create', compact('recursos', 'horarios', 'niveles', 'instructores'));
    }
    
    /**
     * Almacena un nuevo curso en la base de datos.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'curso' => 'required|string|max:100',
            'id_recurso' => 'required|exists:Recursos,Id_Recurso',
            'id_horario' => 'required|exists:Horarios,Id_Horario',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'objetivo' => 'required|string|max:255',
            'id_nivel' => 'required|exists:Niveles,Id_Nivel',
            'cupos' => 'required|integer|min:1',
            'id_instructor' => 'required|exists:Usuarios,Id_Usuario',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $curso = Curso::create([
            'Curso' => $request->curso,
            'Id_Recurso' => $request->id_recurso,
            'Id_Horario' => $request->id_horario,
            'Fecha_Inicio' => $request->fecha_inicio,
            'Fecha_Fin' => $request->fecha_fin,
            'Objetivo' => $request->objetivo,
            'Id_Nivel' => $request->id_nivel,
            'Cupos' => $request->cupos,
            'Cantidad_Alumnos' => 0, // Inicialmente sin alumnos
            'Id_Usuario' => $request->id_instructor,
        ]);
        
        return redirect()->route('cursos.index')->with('success', 'Curso creado exitosamente');
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
        $instructores = Usuario::whereHas('rol', function($query) {
            $query->where('Rol', 'Instructor');
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
            'id_recurso' => 'required|exists:Recursos,Id_Recurso',
            'id_horario' => 'required|exists:Horarios,Id_Horario',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'objetivo' => 'required|string|max:255',
            'id_nivel' => 'required|exists:Niveles,Id_Nivel',
            'cupos' => 'required|integer|min:' . $curso->Cantidad_Alumnos,
            'id_instructor' => 'required|exists:Usuarios,Id_Usuario',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $curso->update([
            'Curso' => $request->curso,
            'Id_Recurso' => $request->id_recurso,
            'Id_Horario' => $request->id_horario,
            'Fecha_Inicio' => $request->fecha_inicio,
            'Fecha_Fin' => $request->fecha_fin,
            'Objetivo' => $request->objetivo,
            'Id_Nivel' => $request->id_nivel,
            'Cupos' => $request->cupos,
            'Id_Usuario' => $request->id_instructor,
        ]);
        
        return redirect()->route('cursos.index')->with('success', 'Curso actualizado exitosamente');
    }
    
    /**
     * Elimina un curso de la base de datos.
     */
    public function destroy($id)
    {
        $curso = Curso::findOrFail($id);
        
        // Verificar si hay estudiantes inscritos
        if ($curso->Cantidad_Alumnos > 0) {
            return redirect()->route('cursos.index')->with('error', 'No se puede eliminar un curso con estudiantes inscritos');
        }
        
        $curso->delete();
        
        return redirect()->route('cursos.index')->with('success', 'Curso eliminado exitosamente');
    }
}