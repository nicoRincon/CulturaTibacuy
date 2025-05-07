<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class CursoController extends Controller
{
    /**
     * Obtiene todos los cursos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Filtros opcionales
        $query = Curso::with(['recurso', 'horario', 'nivel', 'instructor']);
        
        // Filtrar por disponibilidad
        if ($request->has('disponibles') && $request->disponibles) {
            $query->whereRaw('Cupos > cantidad_alumnos');
        }
        
        // Filtrar por nivel
        if ($request->has('nivel') && $request->nivel) {
            $query->where('Id_Nivel', $request->nivel);
        }
        
        // Filtrar por instructor
        if ($request->has('instructor') && $request->instructor) {
            $query->where('id_usuario', $request->instructor);
        }
        
        $cursos = $query->get();
        
        return response()->json([
            'cursos' => $cursos
        ]);
    }

    /**
     * Almacena un nuevo curso.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        try {
            $curso = Curso::create([
                'curso' => $request->curso,
                'id_recurso' => $request->id_recurso,
                'id_horario' => $request->id_horario,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'objetivo' => $request->objetivo,
                'id_nivel' => $request->id_nivel,
                'cupos' => $request->cupos,
                'cantidad_alumnos' => 0, // Inicialmente sin alumnos
                'id_usuario' => $request->id_instructor,
            ]);
            
            return response()->json([
                'message' => 'Curso creado exitosamente',
                'curso' => $curso
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el curso',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene un curso específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $curso = Curso::with(['recurso', 'horario', 'nivel', 'instructor', 'inscripciones.usuario', 'evaluaciones.usuario'])->findOrFail($id);
            
            return response()->json([
                'curso' => $curso
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Curso no encontrado'
            ], 404);
        }
    }

    /**
     * Actualiza un curso existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $curso = Curso::findOrFail($id);
            
            $validator = Validator::make($request->all(), [
                'curso' => 'required|string|max:100',
                'id_recurso' => 'required|exists:recursos,id_recurso',
                'id_horario' => 'required|exists:horarios,id_horario',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after:fecha_inicio',
                'objetivo' => 'required|string|max:255',
                'id_nivel' => 'required|exists:niveles,id_nivel',
                'cupos' => 'required|integer|min:' . $curso->Cantidad_Alumnos,
                'id_instructor' => 'required|exists:usuarios,id_usuario',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
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
            
            return response()->json([
                'message' => 'Curso actualizado exitosamente',
                'curso' => $curso
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el curso',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina un curso.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $curso = Curso::findOrFail($id);
            
            // Verificar si hay estudiantes inscritos
            if ($curso->Cantidad_Alumnos > 0) {
                return response()->json([
                    'message' => 'No se puede eliminar un curso con estudiantes inscritos'
                ], 422);
            }
            
            $curso->delete();
            
            return response()->json([
                'message' => 'Curso eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el curso',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
