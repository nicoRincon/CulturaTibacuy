<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Evaluacion;
use App\Models\NotaFinal;
use App\Models\Inscripcion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class EvaluacionController extends Controller
{
    /**
     * Obtiene todas las evaluaciones del usuario o todas las que tiene permiso para ver.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        
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
        
        return response()->json([
            'evaluaciones' => $evaluaciones
        ]);
    }

    /**
     * Crea una nueva evaluación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Solo instructores y administradores pueden crear evaluaciones
        if (!($user->tieneRol('Instructor') || $user->tieneRol('Administrador'))) {
            return response()->json([
                'message' => 'No tienes permiso para crear evaluaciones'
            ], 403);
        }
        
        $validator = Validator::make($request->all(), [
            'id_curso' => 'required|exists:cursos,id_curso',
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'nota' => 'required|numeric|min:0|max:5',
            'comentarios' => 'nullable|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        try {
            // Verificar si el estudiante está inscrito en el curso
            $inscripcion = Inscripcion::where('id_usuario', $request->id_usuario)
                ->where('id_curso', $request->id_curso)
                ->first();
                
            if (!$inscripcion) {
                return response()->json([
                    'message' => 'El estudiante no está inscrito en este curso'
                ], 422);
            }
            
            // Si es instructor, verificar que el curso le pertenezca
            if ($user->tieneRol('Instructor')) {
                $esMiCurso = $user->cursos()->where('id_curso', $request->id_curso)->exists();
                
                if (!$esMiCurso) {
                    return response()->json([
                        'message' => 'No tienes permiso para evaluar este curso'
                    ], 403);
                }
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
            
            return response()->json([
                'message' => 'Evaluación registrada exitosamente',
                'evaluacion' => $evaluacion,
                'nota_final' => $notaFinal
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar la evaluación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene una evaluación específica.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $evaluacion = Evaluacion::with(['curso', 'usuario'])->findOrFail($id);
            
            // Verificar permisos
            $user = Auth::user();
            if (!($user->tieneRol('Administrador') || 
                  ($user->tieneRol('Instructor') && $evaluacion->curso->id_usuario == $user->id_usuario) ||
                  ($user->tieneRol('Estudiante') && $evaluacion->id_usuario == $user->id_usuario))) {
                return response()->json([
                    'message' => 'No tienes permiso para ver esta evaluación'
                ], 403);
            }
            
            return response()->json([
                'evaluacion' => $evaluacion
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Evaluación no encontrada'
            ], 404);
        }
    }

    /**
     * Actualiza una evaluación existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $evaluacion = Evaluacion::findOrFail($id);
            
            // Verificar permisos
            $user = Auth::user();
            if (!($user->tieneRol('Administrador') || 
                  ($user->tieneRol('Instructor') && $evaluacion->curso->id_usuario == $user->id_usuario))) {
                return response()->json([
                    'message' => 'No tienes permiso para actualizar esta evaluación'
                ], 403);
            }
            
            $validator = Validator::make($request->all(), [
                'nota' => 'required|numeric|min:0|max:5',
                'comentarios' => 'nullable|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
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
            
            return response()->json([
                'message' => 'Evaluación actualizada exitosamente',
                'evaluacion' => $evaluacion,
                'nota_final' => $notaFinal
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la evaluación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina una evaluación.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $evaluacion = Evaluacion::findOrFail($id);
            
            // Verificar permisos
            $user = Auth::user();
            if (!($user->tieneRol('Administrador') || 
                  ($user->tieneRol('Instructor') && $evaluacion->curso->id_usuario == $user->id_usuario))) {
                return response()->json([
                    'message' => 'No tienes permiso para eliminar esta evaluación'
                ], 403);
            }
            
            $id_usuario = $evaluacion->id_usuario;
            $id_curso = $evaluacion->id_curso;
            
            // Eliminar la evaluación
            $evaluacion->delete();
            
            // Actualizar la nota final
            $notaFinal = NotaFinal::updateOrCreate(
                ['id_usuario' => $id_usuario, 'id_curso' => $id_curso],
                ['nota_final' => $this->calcularNotaFinal($id_usuario, $id_curso)]
            );
            
            return response()->json([
                'message' => 'Evaluación eliminada exitosamente',
                'nota_final' => $notaFinal
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la evaluación',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Calcula la nota final de un estudiante en un curso.
     *
     * @param  int  $id_usuario
     * @param  int  $id_curso
     * @return float
     */
    private function calcularNotaFinal($id_usuario, $id_curso)
    {
        $evaluaciones = Evaluacion::where('id_usuario', $id_usuario)
            ->where('id_curso', $id_curso)
            ->get();
            
        if ($evaluaciones->isEmpty()) {
            return 0;
        }
        
        return $evaluaciones->avg('nota');
    }
}
