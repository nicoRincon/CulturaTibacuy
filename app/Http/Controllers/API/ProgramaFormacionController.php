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
            $query->where('Id_Escuela', $request->escuela);
        }
        
        // Filtrar por tipo de escuela
        if ($request->has('tipo') && $request->tipo) {
            $query->where('Id_Tipo_Escuela', $request->tipo);
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
            'id_tipo_escuela' => 'required|exists:Tipos_Escuela,Id_Tipo_Escuela',
            'id_escuela' => 'required|exists:Escuelas,Id_Escuela',
            'id_ubicacion' => 'required|exists:Ubicaciones,Id_Ubicacion',
            'id_curso' => 'required|exists:Cursos,Id_Curso',
            'id_responsable' => 'required|exists:Usuarios,Id_Usuario',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        try {
            $programa = ProgramaFormacion::create([
                'Id_Tipo_Escuela' => $request->id_tipo_escuela,
                'Id_Escuela' => $request->id_escuela,
                'Id_Ubicacion' => $request->id_ubicacion,
                'Id_Curso' => $request->id_curso,
                'Id_Usuario' => $request->id_responsable,
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
                'id_tipo_escuela' => 'required|exists:Tipos_Escuela,Id_Tipo_Escuela',
                'id_escuela' => 'required|exists:Escuelas,Id_Escuela',
                'id_ubicacion' => 'required|exists:Ubicaciones,Id_Ubicacion',
                'id_curso' => 'required|exists:Cursos,Id_Curso',
                'id_responsable' => 'required|exists:Usuarios,Id_Usuario',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $programa->update([
                'Id_Tipo_Escuela' => $request->id_tipo_escuela,
                'Id_Escuela' => $request->id_escuela,
                'Id_Ubicacion' => $request->id_ubicacion,
                'Id_Curso' => $request->id_curso,
                'Id_Usuario' => $request->id_responsable,
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
