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

class AuthController extends Controller
{
    /**
     * Registra un nuevo usuario en el sistema.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'primer_nombre' => 'required|string|max:50',
            'primer_apellido' => 'required|string|max:50',
            'id_documento' => 'required|exists:documento_de_identificacion,id_documento',
            'num_documento' => 'required|string|max:20|unique:usuarios,num_documento',
            'fecha_nacimiento' => 'required|date',
            'id_genero' => 'required|exists:generos,id_genero',
            'id_rol' => 'required|exists:roles,id_rol',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:100|unique:contactos,email',
            'direccion' => 'required|string|max:150',
            'id_pais' => 'required|exists:pais,id_pais',
            'id_departamento' => 'required|exists:departamentos,id_dpto',
            'id_municipio' => 'required|exists:municipios,id_mpio',
            'id_especialidad' => 'required|exists:especialidades,id_especialidad',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Crear el contacto
            $contacto = Contacto::create([
                'telefono' => $request->telefono,
                'email' => $request->email,
                'direccion' => $request->direccion,
            ]);

            // Crear el lugar de nacimiento
            $lugarNacimiento = LugarNacimiento::create([
                'id_pais' => $request->id_pais,
                'id_dpto' => $request->id_departamento,
                'id_mpio' => $request->id_municipio,
            ]);

            // Crear el usuario
            $usuario = User::create([
                'primer_nombre' => $request->primer_nombre,
                'segundo_nombre' => $request->segundo_nombre,
                'primer_apellido' => $request->primer_apellido,
                'segundo_apellido' => $request->segundo_apellido,
                'id_documento' => $request->id_documento,
                'id_estado' => 1, // Activo por defecto
                'num_documento' => $request->num_documento,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'id_lugar_nacimiento' => $lugarNacimiento->id_lugar_nacimiento,
                'id_genero' => $request->id_genero,
                'id_rol' => $request->id_rol,
                'id_contacto' => $contacto->id_contacto,
                'id_especialidad' => $request->id_especialidad,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'message' => 'Usuario registrado exitosamente',
                'user' => $usuario
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar el usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

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
        if (Auth::attempt(['num_documento' => $request->num_documento, 'password' => $request->password])) {
            $user = Auth::user();
            
            // Verificar si el usuario está activo
            if ($user->id_estado != 1) {
                return response()->json([
                    'message' => 'Usuario inactivo'
                ], 401);
            }
            
            $token = $user->createToken('auth_token')->plainTextToken;
            
            return response()->json([
                'message' => 'Inicio de sesión exitoso',
                'user' => $user,
                'token' => $token
            ]);
        }
        
        return response()->json([
            'message' => 'Credenciales inválidas'
        ], 401);
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
            'user' => $user
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
        $request->user()->tokens()->delete();
        
        return response()->json([
            'message' => 'Sesión cerrada exitosamente'
        ]);
    }
}