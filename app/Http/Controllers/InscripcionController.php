<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Curso;
use App\Models\Usuario;
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
                ->where('Id_Usuario', $user->Id_Usuario)
                ->get();
        } 
        // Si es instructor, mostrar las inscripciones a sus cursos
        else if ($user->tieneRol('Instructor')) {
            $inscripciones = Inscripcion::with(['curso', 'usuario'])
                ->whereHas('curso', function($query) use ($user) {
                    $query->where('Id_Usuario', $user->Id_Usuario);
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
            $cursosInscritos = Inscripcion::where('Id_Usuario', $user->Id_Usuario)
                ->pluck('Id_Curso')
                ->toArray();
            
            // Obtener los cursos disponibles (con cupos y que no esté inscrito)
            $cursos = Curso::whereRaw('Cupos > Cantidad_Alumnos')
                ->whereNotIn('Id_Curso', $cursosInscritos)
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
                'id_curso' => 'required|exists:Cursos,Id_Curso',
            ]);
            
            $id_usuario = $user->Id_Usuario;
        } 
        // Validación para administradores e instructores
        else {
            $validator = Validator::make($request->all(), [
                'id_usuario' => 'required|exists:Usuarios,Id_Usuario',
                'id_curso' => 'required|exists:Cursos,Id_Curso',
            ]);
            
            $id_usuario = $request->id_usuario;
        }
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $curso = Curso::findOrFail($request->id_curso);
        
        // Verificar si ya está inscrito
        $inscripcionExistente = Inscripcion::where('Id_Usuario', $id_usuario)
            ->where('Id_Curso', $request->id_curso)
            ->first();
            
        if ($inscripcionExistente) {
            return redirect()->back()->with('error', 'El estudiante ya está inscrito en este curso');
        }
        
        // Verificar si el curso tiene cupos disponibles
        if ($curso->Cantidad_Alumnos >= $curso->Cupos) {
            // Verificar si ya está en lista de espera
            $listaEsperaExistente = ListaEspera::where('Id_Usuario', $id_usuario)
                ->where('Id_Curso', $request->id_curso)
                ->first();
                
            if ($listaEsperaExistente) {
                return redirect()->back()->with('error', 'El estudiante ya está en lista de espera para este curso');
            }
            
            // Agregar a lista de espera
            ListaEspera::create([
                'Id_Usuario' => $id_usuario,
                'Id_Curso' => $request->id_curso,
                'Fecha_Solicitud' => now(),
            ]);
            
            return redirect()->route('inscripciones.index')->with('warning', 'El curso está lleno. El estudiante ha sido agregado a la lista de espera');
        }
        
        // Verificar si el estudiante tiene más de 2 inscripciones activas (solo para roles estudiante)
        if ($user->tieneRol('Estudiante')) {
            $inscripcionesActivas = Inscripcion::where('Id_Usuario', $id_usuario)->count();
            
            if ($inscripcionesActivas >= 2) {
                return redirect()->back()->with('error', 'No puedes inscribirte a más de 2 cursos a la vez');
            }
        }
        
        // Crear la inscripción
        $inscripcion = Inscripcion::create([
            'Id_Usuario' => $id_usuario,
            'Id_Curso' => $request->id_curso,
            'Fecha_Inscripcion' => now(),
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
        $listaEspera = ListaEspera::where('Id_Curso', $curso->Id_Curso)
            ->orderBy('Fecha_Solicitud', 'asc')
            ->first();
            
        if ($listaEspera) {
            // Inscribir al primer estudiante de la lista de espera
            Inscripcion::create([
                'Id_Usuario' => $listaEspera->Id_Usuario,
                'Id_Curso' => $listaEspera->Id_Curso,
                'Fecha_Inscripcion' => now(),
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
