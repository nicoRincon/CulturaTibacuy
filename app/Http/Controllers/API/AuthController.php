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
            'id_documento' => 'required|exists:Documento_de_Identificacion,Id_Documento',
            'num_documento' => 'required|string|max:20|unique:Usuarios,Num_Documento',
            'fecha_nacimiento' => 'required|date',
            'id_genero' => 'required|exists:Generos,Id_Genero',
            'id_rol' => 'required|exists:Roles,Id_Rol',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email|max:100|unique:Contactos,Correo',
            'direccion' => 'required|string|max:150',
            'id_pais' => 'required|exists:País,Id_País',
            'id_departamento' => 'required|exists:Departamentos,Id_Dpto',
            'id_municipio' => 'required|exists:Municipios,Id_Mpio',
            'id_especialidad' => 'required|exists:Especialidades,Id_Especialidad',
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
                'Id_País' => $request->id_pais,
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
        if (Auth::attempt(['Num_Documento' => $request->num_documento, 'password' => $request->password])) {
            $user = Auth::user();
            
            // Verificar si el usuario está activo
            if ($user->Id_Estado != 1) {
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