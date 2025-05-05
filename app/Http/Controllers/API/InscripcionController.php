<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Inscripcion;
use App\Models\Curso;
use App\Models\ListaEspera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class InscripcionController extends Controller
{
    /**
     * Obtiene todas las inscripciones del usuario o todas si es administrador/instructor.
     *
     * @return \Illuminate\Http\Response
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
        
        return response()->json([
            'inscripciones' => $inscripciones
        ]);
    }

    /**
     * Crea una nueva inscripción.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        try {
            $curso = Curso::findOrFail($request->id_curso);
            
            // Verificar si ya está inscrito
            $inscripcionExistente = Inscripcion::where('Id_Usuario', $id_usuario)
                ->where('Id_Curso', $request->id_curso)
                ->first();
                
            if ($inscripcionExistente) {
                return response()->json([
                    'message' => 'El estudiante ya está inscrito en este curso'
                ], 422);
            }
            
            // Verificar si el curso tiene cupos disponibles
            if ($curso->Cantidad_Alumnos >= $curso->Cupos) {
                // Verificar si ya está en lista de espera
                $listaEsperaExistente = ListaEspera::where('Id_Usuario', $id_usuario)
                    ->where('Id_Curso', $request->id_curso)
                    ->first();
                    
                if ($listaEsperaExistente) {
                    return response()->json([
                        'message' => 'El estudiante ya está en lista de espera para este curso'
                    ], 422);
                }
                
                // Agregar a lista de espera
                $listaEspera = ListaEspera::create([
                    'Id_Usuario' => $id_usuario,
                    'Id_Curso' => $request->id_curso,
                    'Fecha_Solicitud' => now(),
                ]);
                
                return response()->json([
                    'message' => 'El curso está lleno. El estudiante ha sido agregado a la lista de espera',
                    'lista_espera' => $listaEspera
                ], 201);
            }
            
            // Verificar si el estudiante tiene más de 2 inscripciones activas (solo para roles estudiante)
            if ($user->tieneRol('Estudiante')) {
                $inscripcionesActivas = Inscripcion::where('Id_Usuario', $id_usuario)->count();
                
                if ($inscripcionesActivas >= 2) {
                    return response()->json([
                        'message' => 'No puedes inscribirte a más de 2 cursos a la vez'
                    ], 422);
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
            
            return response()->json([
                'message' => 'Inscripción realizada exitosamente',
                'inscripcion' => $inscripcion
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al realizar la inscripción',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina una inscripción.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $inscripcion = Inscripcion::findOrFail($id);
            $curso = $inscripcion->curso;
            
            // Verificar permisos
            $user = Auth::user();
            if (!($user->tieneRol('Administrador') || $user->tieneRol('Instructor') || 
                ($user->tieneRol('Estudiante') && $inscripcion->Id_Usuario == $user->Id_Usuario))) {
                return response()->json([
                    'message' => 'No tienes permiso para eliminar esta inscripción'
                ], 403);
            }
            
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
                $nuevaInscripcion = Inscripcion::create([
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
                
                return response()->json([
                    'message' => 'Inscripción cancelada exitosamente. Un estudiante de la lista de espera ha sido inscrito automáticamente',
                    'nueva_inscripcion' => $nuevaInscripcion
                ]);
            }
            
            return response()->json([
                'message' => 'Inscripción cancelada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al cancelar la inscripción',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
