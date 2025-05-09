<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\AuthController;
use App\Models\Evaluacion;
use App\Models\NotaFinal;
use App\Models\Curso;
use App\Models\Inscripcion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class EvaluacionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Muestra un listado de evaluaciones.
     */
    public function index()
    {
        $user = User::user();
        
        // Si es estudiante, mostrar solo sus evaluaciones
        if ($user->tieneRol('Estudiante')) {
            $evaluaciones = Evaluacion::with(['curso', 'usuario'])
                ->where('id_usuario', $user->id_usuario)
                ->get();
        } 
        // Si es instructor, mostrar las evaluaciones de sus cursos
        else if ($user->tieneRol('Instructor')) {
            $evaluaciones = Evaluacion::with(['curso', 'usuario'])
                ->whereHas('curso', function($query) use ($user) {
                    $query->where('id_usuario', $user->id_usuario);
                })
                ->get();
        } 
        // Si es administrador, mostrar todas las evaluaciones
        else {
            $evaluaciones = Evaluacion::with(['curso', 'usuario'])->get();
        }
        
        return view('evaluaciones.index', compact('evaluaciones'));
    }
    
    /**
     * Muestra el formulario para crear una nueva evaluación.
     */
    public function create()
    {
        $user = User::user();
        
        // Solo instructores y administradores pueden crear evaluaciones
        if (!($user->tieneRol('Instructor') || $user->tieneRol('Administrador'))) {
            return redirect()->route('evaluaciones.index')->with('error', 'No tienes permiso para crear evaluaciones');
        }
        
        // Si es instructor, mostrar solo sus cursos
        if ($user->tieneRol('Instructor')) {
            $cursos = Curso::where('id_usuario', $user->id_usuario)->get();
        } else {
            $cursos = Curso::all();
        }
        
        return view('evaluaciones.create', compact('cursos'));
    }
    
    /**
     * Obtiene los estudiantes inscritos en un curso.
     */
    public function getEstudiantes(Request $request)
    {
        $estudiantes = Inscripcion::with('usuario')
            ->where('id_curso', $request->id_curso)
            ->get()
            ->map(function ($inscripcion) {
                return [
                    'id' => $inscripcion->usuario->id_usuario,
                    'nombre' => $inscripcion->usuario->primer_nombre . ' ' . $inscripcion->usuario->primer_apellido,
                    'documento' => $inscripcion->usuario->num_documento,
                ];
            });
            
        return response()->json($estudiantes);
    }
    
    /**
     * Almacena una nueva evaluación en la base de datos.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_curso' => 'required|exists:Cursos,id_curso',
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'nota' => 'required|numeric|min:0|max:5',
            'comentarios' => 'nullable|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Verificar si el estudiante está inscrito en el curso
        $inscripcion = Inscripcion::where('id_usuario', $request->id_usuario)
            ->where('id_curso', $request->id_curso)
            ->first();
            
        if (!$inscripcion) {
            return redirect()->back()->with('error', 'El estudiante no está inscrito en este curso');
        }
        
        // Crear la evaluación
        $evaluacion = Evaluacion::create([
            'id_usuario' => $request->id_usuario,
            'id_curso' => $request->id_curso,
            'fecha_evaluacion' => now(),
            'nota' => $request->nota,
            'comentarios' => $request->comentarios,
        ]);
        
        // Actualizar o crear la nota final
        $notaFinal = NotaFinal::updateOrCreate(
            ['id_usuario' => $request->id_usuario, 'id_curso' => $request->id_curso],
            ['nota_final' => $this->calcularNotaFinal($request->id_usuario, $request->id_curso)]
        );
        
        return redirect()->route('evaluaciones.index')->with('success', 'Evaluación registrada exitosamente');
    }
    
    /**
     * Muestra la información de una evaluación específica.
     */
    public function show($id)
    {
        $evaluacion = Evaluacion::with(['curso', 'usuario'])->findOrFail($id);
        return view('evaluaciones.show', compact('evaluacion'));
    }
    
    /**
     * Muestra el formulario para editar una evaluación existente.
     */
    public function edit($id)
    {
        $evaluacion = Evaluacion::findOrFail($id);
        $user = User::user();
        
        // Solo el instructor del curso o un administrador puede editar la evaluación
        if (!($user->tieneRol('Administrador') || ($user->tieneRol('Instructor') && $evaluacion->curso->id_usuario == $user->id_usuario))) {
            return redirect()->route('evaluaciones.index')->with('error', 'No tienes permiso para editar esta evaluación');
        }
        
        return view('evaluaciones.edit', compact('evaluacion'));
    }
    
    /**
     * Actualiza la información de una evaluación existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $evaluacion = Evaluacion::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'nota' => 'required|numeric|min:0|max:5',
            'comentarios' => 'nullable|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Actualizar la evaluación
        $evaluacion->update([
            'nota' => $request->nota,
            'comentarios' => $request->comentarios,
            'fecha_evaluacion' => now(),
        ]);
        
        // Actualizar la nota final
        $notaFinal = NotaFinal::updateOrCreate(
            ['id_usuario' => $evaluacion->id_usuario, 'id_curso' => $evaluacion->id_curso],
            ['nota_final' => $this->calcularNotaFinal($evaluacion->id_usuario, $evaluacion->id_curso)]
        );
        
        return redirect()->route('evaluaciones.index')->with('success', 'Evaluación actualizada exitosamente');
    }
    
    /**
     * Elimina una evaluación de la base de datos.
     */
    public function destroy($id)
    {
        $evaluacion = Evaluacion::findOrFail($id);
        $id_usuario = $evaluacion->id_usuario;
        $id_curso = $evaluacion->id_curso;
        
        // Eliminar la evaluación
        $evaluacion->delete();
        
        // Actualizar la nota final
        $notaFinal = NotaFinal::updateOrCreate(
            ['id_usuario' => $id_usuario, 'id_curso' => $id_curso],
            ['nota_final' => $this->calcularNotaFinal($id_usuario, $id_curso)]
        );
        
        return redirect()->route('evaluaciones.index')->with('success', 'Evaluación eliminada exitosamente');
    }
    
    /**
     * Calcula la nota final de un estudiante en un curso.
     */
    private function calcularNotaFinal($id_usuario, $id_curso)
    {
        $evaluaciones = Evaluacion::where('id_usuario', $id_usuario)
            ->where('id_curso', $id_curso)
            ->get();
            
        if ($evaluaciones->isEmpty()) {
            return 0;
        }
        
        return $evaluaciones->avg('Nota');
    }
}