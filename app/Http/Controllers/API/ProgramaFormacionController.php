<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProgramaFormacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProgramaFormacionController extends Controller
{
    /**
     * Obtiene todos los programas de formación.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Filtros opcionales
        $query = ProgramaFormacion::with(['tipoEscuela', 'escuela', 'ubicacion', 'curso', 'responsable']);
        
        // Filtrar por escuela
        if ($request->has('escuela') && $request->escuela) {
            $query->where('id_escuela', $request->escuela);
        }
        
        // Filtrar por tipo de escuela
        if ($request->has('tipo') && $request->tipo) {
            $query->where('id_tipo_escuela', $request->tipo);
        }
        
        $programas = $query->get();
        
        return response()->json([
            'programas' => $programas
        ]);
    }

    /**
     * Crea un nuevo programa de formación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_tipo_escuela' => 'required|exists:tipos_escuela,id_tipo_escuela',
            'id_escuela' => 'required|exists:escuelas,id_escuela',
            'id_ubicacion' => 'required|exists:ubicaciones,id_ubicacion',
            'id_curso' => 'required|exists:cursos,id_curso',
            'id_responsable' => 'required|exists:usuarios,id_usuario',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        try {
            $programa = ProgramaFormacion::create([
                'id_tipo_escuela' => $request->id_tipo_escuela,
                'id_escuela' => $request->id_escuela,
                'id_ubicacion' => $request->id_ubicacion,
                'id_curso' => $request->id_curso,
                'id_usuario' => $request->id_responsable,
            ]);
            
            return response()->json([
                'message' => 'Programa de formación creado exitosamente',
                'programa' => $programa
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el programa de formación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene un programa de formación específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $programa = ProgramaFormacion::with(['tipoEscuela', 'escuela', 'ubicacion', 'curso', 'responsable'])->findOrFail($id);
            
            return response()->json([
                'programa' => $programa
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Programa de formación no encontrado'
            ], 404);
        }
    }

    /**
     * Actualiza un programa de formación existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $programa = ProgramaFormacion::findOrFail($id);
            
            $validator = Validator::make($request->all(), [
                'id_tipo_escuela' => 'required|exists:tipos_escuela,id_tipo_escuela',
                'id_escuela' => 'required|exists:escuelas,id_escuela',
                'id_ubicacion' => 'required|exists:ubicaciones,id_ubicacion',
                'id_curso' => 'required|exists:cursos,id_curso',
                'id_responsable' => 'required|exists:usuarios,id_usuario',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $programa->update([
                'id_tipo_escuela' => $request->id_tipo_escuela,
                'id_escuela' => $request->id_escuela,
                'id_ubicacion' => $request->id_ubicacion,
                'id_curso' => $request->id_curso,
                'id_usuario' => $request->id_responsable,
            ]);
            
            return response()->json([
                'message' => 'Programa de formación actualizado exitosamente',
                'programa' => $programa
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el programa de formación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina un programa de formación.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $programa = ProgramaFormacion::findOrFail($id);
            $programa->delete();
            
            return response()->json([
                'message' => 'Programa de formación eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el programa de formación',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
