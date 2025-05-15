<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Contacto;
use App\Models\LugarNacimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;

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
        $credentials = [
            'num_documento' => $request->num_documento,
            'password' => $request->password
        ];
        
        if (!Auth::attempt($credentials)) {
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