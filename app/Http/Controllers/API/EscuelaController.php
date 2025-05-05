<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Escuela;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class EscuelaController extends Controller
{
    /**
     * Obtiene todas las escuelas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $escuelas = Escuela::all();
        
        return response()->json([
            'escuelas' => $escuelas
        ]);
    }

    /**
     * Crea una nueva escuela.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        try {
            $escuela = Escuela::create([
                'Nombre' => $request->nombre,
                'Descripcion' => $request->descripcion,
            ]);
            
            return response()->json([
                'message' => 'Escuela creada exitosamente',
                'escuela' => $escuela
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear la escuela',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene una escuela específica.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $escuela = Escuela::with('programas.curso')->findOrFail($id);
            
            return response()->json([
                'escuela' => $escuela
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Escuela no encontrada'
            ], 404);
        }
    }

    /**
     * Actualiza una escuela existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $escuela = Escuela::findOrFail($id);
            
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:100',
                'descripcion' => 'required|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $escuela->update([
                'Nombre' => $request->nombre,
                'Descripcion' => $request->descripcion,
            ]);
            
            return response()->json([
                'message' => 'Escuela actualizada exitosamente',
                'escuela' => $escuela
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la escuela',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina una escuela.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $escuela = Escuela::findOrFail($id);
            
            // Verificar si tiene programas asociados
            if ($escuela->programas()->count() > 0) {
                return response()->json([
                    'message' => 'No se puede eliminar una escuela con programas asociados'
                ], 422);
            }
            
            $escuela->delete();
            
            return response()->json([
                'message' => 'Escuela eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la escuela',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}