<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Curso;
use App\Models\User;
use App\Models\ListaEspera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class InscripcionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Muestra un listado de inscripciones.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Si es estudiante, mostrar solo sus inscripciones
        if ($user->tieneRol('Estudiante')) {
            $inscripciones = Inscripcion::with(['curso', 'usuario'])
                ->where('id_usuario', $user->id_usuario)
                ->get();
        } 
        // Si es instructor, mostrar las inscripciones a sus cursos
        else if ($user->tieneRol('Instructor')) {
            $inscripciones = Inscripcion::with(['curso', 'usuario'])
                ->whereHas('curso', function($query) use ($user) {
                    $query->where('id_usuario', $user->id_usuario);
                })
                ->get();
        } 
        // Si es administrador, mostrar todas las inscripciones
        else {
            $inscripciones = Inscripcion::with(['curso', 'usuario'])->get();
        }
        
        return view('inscripciones.index', compact('inscripciones'));
    }
    
    /**
     * Muestra el formulario para inscribirse a un curso.
     */
    public function create()
    {
        $user = Auth::user();
        
        // Si es estudiante, solo mostrar cursos disponibles
        if ($user->tieneRol('Estudiante')) {
            // Obtener los cursos a los que ya está inscrito
            $cursosInscritos = Inscripcion::where('id_usuario', $user->id_usuario)
                ->pluck('id_curso')
                ->toArray();
            
            // Obtener los cursos disponibles (con cupos y que no esté inscrito)
            $cursos = Curso::whereRaw('cupos > cantidad_alumnos')
                ->whereNotIn('id_curso', $cursosInscritos)
                ->get();
                
            return view('inscripciones.create', compact('cursos'));
        } 
        // Si es administrador o instructor, mostrar todos los cursos y usuarios
        else {
            $cursos = Curso::all();
            $usuarios = Usuario::whereHas('rol', function($query) {
                $query->where('Rol', 'Estudiante');
            })->get();
            
            return view('inscripciones.create', compact('cursos', 'usuarios'));
        }
    }
    
    /**
     * Almacena una nueva inscripción en la base de datos.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Validación para estudiantes
        if ($user->tieneRol('Estudiante')) {
            $validator = Validator::make($request->all(), [
                'id_curso' => 'required|exists:cursos,id_curso',
            ]);
            
            $id_usuario = $user->id_usuario;
        } 
        // Validación para administradores e instructores
        else {
            $validator = Validator::make($request->all(), [
                'id_usuario' => 'required|exists:usuarios,id_usuario',
                'id_curso' => 'required|exists:cursos,id_curso',
            ]);
            
            $id_usuario = $request->id_usuario;
        }
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $curso = Curso::findOrFail($request->id_curso);
        
        // Verificar si ya está inscrito
        $inscripcionExistente = Inscripcion::where('id_usuario', $id_usuario)
            ->where('id_curso', $request->id_curso)
            ->first();
            
        if ($inscripcionExistente) {
            return redirect()->back()->with('error', 'El estudiante ya está inscrito en este curso');
        }
        
        // Verificar si el curso tiene cupos disponibles
        if ($curso->Cantidad_Alumnos >= $curso->Cupos) {
            // Verificar si ya está en lista de espera
            $listaEsperaExistente = ListaEspera::where('id_usuario', $id_usuario)
                ->where('id_curso', $request->id_curso)
                ->first();
                
            if ($listaEsperaExistente) {
                return redirect()->back()->with('error', 'El estudiante ya está en lista de espera para este curso');
            }
            
            // Agregar a lista de espera
            ListaEspera::create([
                'id_usuario' => $id_usuario,
                'id_curso' => $request->id_curso,
                'fecha_solicitud' => now(),
            ]);
            
            return redirect()->route('inscripciones.index')->with('warning', 'El curso está lleno. El estudiante ha sido agregado a la lista de espera');
        }
        
        // Verificar si el estudiante tiene más de 2 inscripciones activas (solo para roles estudiante)
        if ($user->tieneRol('Estudiante')) {
            $inscripcionesActivas = Inscripcion::where('id_usuario', $id_usuario)->count();
            
            if ($inscripcionesActivas >= 2) {
                return redirect()->back()->with('error', 'No puedes inscribirte a más de 2 cursos a la vez');
            }
        }
        
        // Crear la inscripción
        $inscripcion = Inscripcion::create([
            'id_usuario' => $id_usuario,
            'id_curso' => $request->id_curso,
            'fecha_inscripcion' => now(),
        ]);
        
        // Actualizar cantidad de alumnos en el curso
        $curso->update([
            'Cantidad_Alumnos' => $curso->Cantidad_Alumnos + 1,
        ]);
        
        return redirect()->route('inscripciones.index')->with('success', 'Inscripción realizada exitosamente');
    }
    
    /**
     * Elimina una inscripción de la base de datos.
     */
    public function destroy($id)
    {
        $inscripcion = Inscripcion::findOrFail($id);
        $curso = $inscripcion->curso;
        
        // Eliminar la inscripción
        $inscripcion->delete();
        
        // Actualizar cantidad de alumnos en el curso
        $curso->update([
            'Cantidad_Alumnos' => $curso->Cantidad_Alumnos - 1,
        ]);
        
        // Verificar si hay estudiantes en lista de espera
        $listaEspera = ListaEspera::where('id_curso', $curso->id_curso)
            ->orderBy('fecha_solicitud', 'asc')
            ->first();
            
        if ($listaEspera) {
            // Inscribir al primer estudiante de la lista de espera
            Inscripcion::create([
                'id_usuario' => $listaEspera->id_usuario,
                'id_curso' => $listaEspera->id_curso,
                'fecha_inscripcion' => now(),
            ]);
            
            // Actualizar cantidad de alumnos en el curso
            $curso->update([
                'Cantidad_Alumnos' => $curso->Cantidad_Alumnos + 1,
            ]);
            
            // Eliminar de la lista de espera
            $listaEspera->delete();
        }
        
        return redirect()->route('inscripciones.index')->with('success', 'Inscripción cancelada exitosamente');
    }
}
