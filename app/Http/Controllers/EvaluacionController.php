<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\NotaFinal;
use App\Models\Curso;
use App\Models\Usuario;
use App\Models\Inscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        
        // Si es estudiante, mostrar solo sus evaluaciones
        if ($user->tieneRol('Estudiante')) {
            $evaluaciones = Evaluacion::with(['curso', 'usuario'])
                ->where('Id_Usuario', $user->Id_Usuario)
                ->get();
        } 
        // Si es instructor, mostrar las evaluaciones de sus cursos
        else if ($user->tieneRol('Instructor')) {
            $evaluaciones = Evaluacion::with(['curso', 'usuario'])
                ->whereHas('curso', function($query) use ($user) {
                    $query->where('Id_Usuario', $user->Id_Usuario);
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
        $user = Auth::user();
        
        // Solo instructores y administradores pueden crear evaluaciones
        if (!($user->tieneRol('Instructor') || $user->tieneRol('Administrador'))) {
            return redirect()->route('evaluaciones.index')->with('error', 'No tienes permiso para crear evaluaciones');
        }
        
        // Si es instructor, mostrar solo sus cursos
        if ($user->tieneRol('Instructor')) {
            $cursos = Curso::where('Id_Usuario', $user->Id_Usuario)->get();
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
            ->where('Id_Curso', $request->id_curso)
            ->get()
            ->map(function ($inscripcion) {
                return [
                    'id' => $inscripcion->usuario->Id_Usuario,
                    'nombre' => $inscripcion->usuario->Primer_Nombre . ' ' . $inscripcion->usuario->Primer_Apellido,
                    'documento' => $inscripcion->usuario->Num_Documento,
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
            'id_curso' => 'required|exists:Cursos,Id_Curso',
            'id_usuario' => 'required|exists:Usuarios,Id_Usuario',
            'nota' => 'required|numeric|min:0|max:5',
            'comentarios' => 'nullable|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Verificar si el estudiante está inscrito en el curso
        $inscripcion = Inscripcion::where('Id_Usuario', $request->id_usuario)
            ->where('Id_Curso', $request->id_curso)
            ->first();
            
        if (!$inscripcion) {
            return redirect()->back()->with('error', 'El estudiante no está inscrito en este curso');
        }
        
        // Crear la evaluación
        $evaluacion = Evaluacion::create([
            'Id_Usuario' => $request->id_usuario,
            'Id_Curso' => $request->id_curso,
            'Fecha_Evaluacion' => now(),
            'Nota' => $request->nota,
            'Comentarios' => $request->comentarios,
        ]);
        
        // Actualizar o crear la nota final
        $notaFinal = NotaFinal::updateOrCreate(
            ['Id_Usuario' => $request->id_usuario, 'Id_Curso' => $request->id_curso],
            ['Nota_Final' => $this->calcularNotaFinal($request->id_usuario, $request->id_curso)]
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
        $user = Auth::user();
        
        // Solo el instructor del curso o un administrador puede editar la evaluación
        if (!($user->tieneRol('Administrador') || ($user->tieneRol('Instructor') && $evaluacion->curso->Id_Usuario == $user->Id_Usuario))) {
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
            'Nota' => $request->nota,
            'Comentarios' => $request->comentarios,
            'Fecha_Evaluacion' => now(),
        ]);
        
        // Actualizar la nota final
        $notaFinal = NotaFinal::updateOrCreate(
            ['Id_Usuario' => $evaluacion->Id_Usuario, 'Id_Curso' => $evaluacion->Id_Curso],
            ['Nota_Final' => $this->calcularNotaFinal($evaluacion->Id_Usuario, $evaluacion->Id_Curso)]
        );
        
        return redirect()->route('evaluaciones.index')->with('success', 'Evaluación actualizada exitosamente');
    }
    
    /**
     * Elimina una evaluación de la base de datos.
     */
    public function destroy($id)
    {
        $evaluacion = Evaluacion::findOrFail($id);
        $id_usuario = $evaluacion->Id_Usuario;
        $id_curso = $evaluacion->Id_Curso;
        
        // Eliminar la evaluación
        $evaluacion->delete();
        
        // Actualizar la nota final
        $notaFinal = NotaFinal::updateOrCreate(
            ['Id_Usuario' => $id_usuario, 'Id_Curso' => $id_curso],
            ['Nota_Final' => $this->calcularNotaFinal($id_usuario, $id_curso)]
        );
        
        return redirect()->route('evaluaciones.index')->with('success', 'Evaluación eliminada exitosamente');
    }
    
    /**
     * Calcula la nota final de un estudiante en un curso.
     */
    private function calcularNotaFinal($id_usuario, $id_curso)
    {
        $evaluaciones = Evaluacion::where('Id_Usuario', $id_usuario)
            ->where('Id_Curso', $id_curso)
            ->get();
            
        if ($evaluaciones->isEmpty()) {
            return 0;
        }
        
        return $evaluaciones->avg('Nota');
    }
}