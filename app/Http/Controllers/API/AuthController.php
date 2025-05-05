<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Contacto;
use App\Models\LugarNacimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class AuthController extends Controller
{
    use HasApiTokens,Notifiable;
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
            'segundo_apellido' => 'nullable|string|max:50',
            'segundo_nombre' => 'nullable|string|max:50',
            'id_documento' => 'required|exists:documentos_identificacion,id_documento',
            'num_documento' => 'required|string|max:20|unique:usuarios,Num_Documento',
            'fecha_nacimiento' => 'required|date',
            'id_genero' => 'required|exists:Generos,Id_Genero',
            'id_rol' => 'required|exists:Roles,Id_Rol',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email|max:100|unique:contactos,correo',
            'direccion' => 'required|string|max:150',
            'id_pais' => 'required|exists:paises,id_pais',
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
                'Telefono' => $request->telefono,
                'Correo' => $request->correo,
                'Direccion' => $request->direccion,
            ]);

            // Crear el lugar de nacimiento
            $lugarNacimiento = LugarNacimiento::create([
                'Id_Pais' => $request->id_pais,
                'Id_Dpto' => $request->id_departamento,
                'Id_Mpio' => $request->id_municipio,
            ]);

            // Crear el usuario
            $usuario = Usuario::create([
                'Primer_Nombre' => $request->primer_nombre,
                'Segundo_Nombre' => $request->segundo_nombre,
                'Primer_Apellido' => $request->primer_apellido,
                'Segundo_Apellido' => $request->segundo_apellido,
                'Id_Documento' => $request->id_documento,
                'Id_Estado' => 1, // Activo por defecto
                'Num_Documento' => $request->num_documento,
                'Fecha_Nacimiento' => $request->fecha_nacimiento,
                'Id_L_Nacimiento' => $lugarNacimiento->Id_L_Nacimiento,
                'Id_Genero' => $request->id_genero,
                'Id_Rol' => $request->id_rol,
                'Id_Contacto' => $contacto->Id_Contacto,
                'Id_Especialidad' => $request->id_especialidad,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'message' => 'Usuario registrado exitosamente',
                'user' => $usuario
            ], 201);
        } catch (\Exception $e) {
            \Log::error('Error al registrar el usuario: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            return response()->json([
                'message' => 'Ocurrió un error inesperado al registrar el usuario. Por favor, inténtelo de nuevo más tarde.'
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
            if ($user->Id_Estado != 1) {
                return response()->json([
                    'message' => 'Usuario inactivo'
                ], 401);
            }
            
            $token = $user->createToken('auth_token')->plainTextToken;
            
            return response()->json([
                'data' => [
                    'message' => 'Inicio de sesión exitoso',
                    'user' => $user,
                    'token' => $token
                ]
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
        
        return response()->json([
            'user' => [
                'data' => $user,
                'relations' => [
                    'documento' => $user->documento,
                    'genero' => $user->genero,
                    'rol' => $user->rol,
                    'especialidad' => $user->especialidad,
                    'contacto' => $user->contacto,
                    'lugarNacimiento' => [
                        'pais' => $user->lugarNacimiento->pais ?? null,
                        'departamento' => $user->lugarNacimiento->departamento ?? null,
                        'municipio' => $user->lugarNacimiento->municipio ?? null,
                    ],
                ],
            ],
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