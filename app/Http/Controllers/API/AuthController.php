<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Inicia sesión y genera un token de acceso.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'num_documento' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Intentar autenticar al usuario
        if (!Auth::attempt(['num_documento' => $request->num_documento, 'password' => $request->password])) {
            return response()->json([
                'message' => 'Credenciales inválidas'
            ], 401);
        }

        $user = Auth::user();
        
        // Verificar si el usuario está activo
        if ($user->id_estado != 1) {
            return response()->json([
                'message' => 'Usuario inactivo'
            ], 401);
        }

        // Revocar tokens antiguos y crear uno nuevo
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * Obtiene la información del usuario autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function user(Request $request)
    {
        $user = $request->user();
        
        // Cargar relaciones necesarias
        $user->load(['documento', 'genero', 'rol', 'especialidad', 'contacto', 'lugarNacimiento.pais', 'lugarNacimiento.departamento', 'lugarNacimiento.municipio']);
        
        return response()->json([
            'usuario' => $user
        ]);
    }

    /**
     * Cierra la sesión y revoca el token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        try {
            // Revocar el token actual
            $request->user()->currentAccessToken()->delete();
            
            return response()->json([
                'message' => 'Sesión cerrada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al cerrar sesión',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}