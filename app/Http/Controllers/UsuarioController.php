<?php

namespace App\Http\Controllers;

use App\Models\DocumentoIdentificacion;
use App\Models\Genero;
use App\Models\Rol;
use App\Models\Contacto;
use App\Models\Especialidad;
use App\Models\LugarNacimiento;
use App\Models\Pais;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Estado;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra un listado de usuarios.
     */
    public function index()
    {
        $usuarios = User::with(['documento', 'genero', 'rol', 'especialidad', 'contacto', 'lugarNacimiento'])->get();
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        $documentos = DocumentoIdentificacion::all();
        $generos = Genero::all();
        $roles = Rol::all();
        $especialidades = Especialidad::all();
        $paises = Pais::all();
        $estados = Estado::all();
        
        return view('usuarios.create', compact('documentos', 'generos', 'roles', 'especialidades', 'paises', 'estados'));
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
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
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Crear el contacto
        $contacto = Contacto::create([
            'telefono' => $request->telefono,
            'email' => $request->email,
            'direccion' => $request->direccion,
        ]);

        // Crear el lugar de nacimiento
        $lugar_nacimiento = LugarNacimiento::create([
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
            'id_lugar_nacimiento' => $lugar_nacimiento->id_lugar_nacimiento,
            'id_genero' => $request->id_genero,
            'id_rol' => $request->id_rol,
            'id_contacto' => $contacto->id_contacto,
            'id_especialidad' => $request->id_especialidad,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente');
    }

    /**
     * Muestra la información de un usuario específico.
     */
    public function show($id)
    {
        $usuario = User::with(['documento', 'genero', 'rol', 'especialidad', 'contacto', 'lugarNacimiento.pais', 'lugarNacimiento.departamento', 'lugarNacimiento.municipio'])->findOrFail($id);
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     */
    public function edit($id)
    {
        $usuario = User::with(['contacto', 'lugarNacimiento'])->findOrFail($id);
        $documentos = DocumentoIdentificacion::all();
        $generos = Genero::all();
        $roles = Rol::all();
        $especialidades = Especialidad::all();
        $paises = Pais::all();
        $departamentos = Departamento::where('id_pais', $usuario->lugarNacimiento->id_pais)->get();
        $municipios = Municipio::where('id_dpto', $usuario->lugarNacimiento->id_dpto)->get();
        $estados = Estado::all();
        
        return view('usuarios.edit', compact('usuario', 'documentos', 'generos', 'roles', 'especialidades', 'paises', 'departamentos', 'municipios', 'estados'));
    }

    /**
     * Actualiza la información de un usuario existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'primer_nombre' => 'required|string|max:50',
            'primer_apellido' => 'required|string|max:50',
            'id_documento' => 'required|exists:documento_de_identificacion,id_documento',
            'num_documento' => 'required|string|max:20|unique:usuarios,num_documento,'.$id.',id_usuario',
            'fecha_nacimiento' => 'required|date',
            'id_genero' => 'required|exists:generos,id_genero',
            'id_rol' => 'required|exists:roles,id_rol',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:100|unique:contactos,email,'.$usuario->contacto->id_contacto.',id_contacto',
            'direccion' => 'required|string|max:150',
            'id_pais' => 'required|exists:pais,id_pais',
            'id_departamento' => 'required|exists:departamentos,id_dpto',
            'id_municipio' => 'required|exists:municipios,id_mpio',
            'id_especialidad' => 'required|exists:especialidades,id_especialidad',
            'id_estado' => 'required|exists:estados,id_estado',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Actualizar el contacto
        $usuario->contacto->update([
            'telefono' => $request->telefono,
            'email' => $request->email,
            'direccion' => $request->direccion,
        ]);

        // Actualizar el lugar de nacimiento
        $usuario->lugarNacimiento->update([
            'id_pais' => $request->id_pais,
            'id_dpto' => $request->id_departamento,
            'id_mpio' => $request->id_municipio,
        ]);

        // Actualizar el usuario
        $usuario->update([
            'primer_nombre' => $request->primer_nombre,
            'segundo_nombre' => $request->segundo_nombre,
            'primer_apellido' => $request->primer_apellido,
            'segundo_apellido' => $request->segundo_apellido,
            'id_documento' => $request->id_documento,
            'id_estado' => $request->id_estado,
            'num_documento' => $request->num_documento,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'id_genero' => $request->id_genero,
            'id_rol' => $request->id_rol,
            'id_especialidad' => $request->id_especialidad,
        ]);

        // Actualizar la contraseña si se proporcionó una nueva
        if ($request->filled('password')) {
            $usuario->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente');
    }

    /**
     * Elimina un usuario de la base de datos.
     */
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        
        // En lugar de eliminar, marcar como inactivo
        $usuario->update([
            'id_estado' => 2, // ID del estado "Inactivo"
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario desactivado exitosamente');
    }
    
    /**
     * Obtiene los departamentos de un país.
     */
    public function getDepartamentos(Request $request)
    {
        $departamentos = Departamento::where('id_pais', $request->id_pais)->get();
        return response()->json($departamentos);
    }
    
    /**
     * Obtiene los municipios de un departamento.
     */
    public function getMunicipios(Request $request)
    {
        $municipios = Municipio::where('id_dpto', $request->id_dpto)->get();
        return response()->json($municipios);
    }

    public function buscarPorEmail($email)
    {
        $usuario = User::whereHas('contacto', function($query) use ($email) {
            $query->where('email', $email);
        })->first();
    
        return $usuario;
    }    
}