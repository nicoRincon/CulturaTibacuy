<?php

namespace App\Http\Controllers;

use App\Models\ProgramaFormacion;
use App\Models\TipoEscuela;
use App\Models\Escuela;
use App\Models\Ubicacion;
use App\Models\Curso;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProgramaFormacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Administrador')->except(['index', 'show']);
    }
    
    /**
     * Muestra un listado de programas de formación.
     */
    public function index()
    {
        $programas = ProgramaFormacion::with(['tipoEscuela', 'escuela', 'ubicacion', 'curso', 'responsable'])->get();
        return view('programas.index', compact('programas'));
    }
    
    /**
     * Muestra el formulario para crear un nuevo programa de formación.
     */
    public function create()
    {
        $tiposEscuela = TipoEscuela::all();
        $escuelas = Escuela::all();
        $ubicaciones = Ubicacion::all();
        $cursos = Curso::all();
        $responsables = Usuario::whereHas('rol', function($query) {
            $query->where('Rol', 'Instructor')->orWhere('Rol', 'Administrador');
        })->get();
        
        return view('programas.create', compact('tiposEscuela', 'escuelas', 'ubicaciones', 'cursos', 'responsables'));
    }
    
    /**
     * Almacena un nuevo programa de formación en la base de datos.
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
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $programa = ProgramaFormacion::create([
            'Id_Tipo_Escuela' => $request->id_tipo_escuela,
            'Id_Escuela' => $request->id_escuela,
            'Id_Ubicacion' => $request->id_ubicacion,
            'Id_Curso' => $request->id_curso,
            'Id_Usuario' => $request->id_responsable,
        ]);
        
        return redirect()->route('programas.index')->with('success', 'Programa de formación creado exitosamente');
    }
    
    /**
     * Muestra la información de un programa de formación específico.
     */
    public function show($id)
    {
        $programa = ProgramaFormacion::with(['tipoEscuela', 'escuela', 'ubicacion', 'curso', 'responsable'])->findOrFail($id);
        return view('programas.show', compact('programa'));
    }
    
    /**
     * Muestra el formulario para editar un programa de formación existente.
     */
    public function edit($id)
    {
        $programa = ProgramaFormacion::findOrFail($id);
        $tiposEscuela = TipoEscuela::all();
        $escuelas = Escuela::all();
        $ubicaciones = Ubicacion::all();
        $cursos = Curso::all();
        $responsables = Usuario::whereHas('rol', function($query) {
            $query->where('Rol', 'Instructor')->orWhere('Rol', 'Administrador');
        })->get();
        
        return view('programas.edit', compact('programa', 'tiposEscuela', 'escuelas', 'ubicaciones', 'cursos', 'responsables'));
    }
    
    /**
     * Actualiza la información de un programa de formación existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $programa = ProgramaFormacion::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'id_tipo_escuela' => 'required|exists:Tipos_Escuela,Id_Tipo_Escuela',
            'id_escuela' => 'required|exists:Escuelas,Id_Escuela',
            'id_ubicacion' => 'required|exists:Ubicaciones,Id_Ubicacion',
            'id_curso' => 'required|exists:Cursos,Id_Curso',
            'id_responsable' => 'required|exists:Usuarios,Id_Usuario',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $programa->update([
            'Id_Tipo_Escuela' => $request->id_tipo_escuela,
            'Id_Escuela' => $request->id_escuela,
            'Id_Ubicacion' => $request->id_ubicacion,
            'Id_Curso' => $request->id_curso,
            'Id_Usuario' => $request->id_responsable,
        ]);
        
        return redirect()->route('programas.index')->with('success', 'Programa de formación actualizado exitosamente');
    }
    
    /**
     * Elimina un programa de formación de la base de datos.
     */
    public function destroy($id)
    {
        $programa = ProgramaFormacion::findOrFail($id);
        $programa->delete();
        
        return redirect()->route('programas.index')->with('success', 'Programa de formación eliminado exitosamente');
    }
}

    /**
     * Muestra un listado de usuarios.
     */
    public function index()
    {
        $usuarios = Usuario::with(['documento', 'genero', 'rol', 'especialidad', 'contacto', 'lugarNacimiento'])->get();
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
            return redirect()->back()->withErrors($validator)->withInput();
        }

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

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente');
    }

    /**
     * Muestra la información de un usuario específico.
     */
    public function show($id)
    {
        $usuario = Usuario::with(['documento', 'genero', 'rol', 'especialidad', 'contacto', 'lugarNacimiento.pais', 'lugarNacimiento.departamento', 'lugarNacimiento.municipio'])->findOrFail($id);
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     */
    public function edit($id)
    {
        $usuario = Usuario::with(['contacto', 'lugarNacimiento'])->findOrFail($id);
        $documentos = DocumentoIdentificacion::all();
        $generos = Genero::all();
        $roles = Rol::all();
        $especialidades = Especialidad::all();
        $paises = Pais::all();
        $departamentos = Departamento::where('Id_País', $usuario->lugarNacimiento->Id_País)->get();
        $municipios = Municipio::where('Id_Dpto', $usuario->lugarNacimiento->Id_Dpto)->get();
        $estados = Estado::all();
        
        return view('usuarios.edit', compact('usuario', 'documentos', 'generos', 'roles', 'especialidades', 'paises', 'departamentos', 'municipios', 'estados'));
    }

    /**
     * Actualiza la información de un usuario existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'primer_nombre' => 'required|string|max:50',
            'primer_apellido' => 'required|string|max:50',
            'id_documento' => 'required|exists:Documento_de_Identificacion,Id_Documento',
            'num_documento' => 'required|string|max:20|unique:Usuarios,Num_Documento,'.$id.',Id_Usuario',
            'fecha_nacimiento' => 'required|date',
            'id_genero' => 'required|exists:Generos,Id_Genero',
            'id_rol' => 'required|exists:Roles,Id_Rol',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email|max:100|unique:Contactos,Correo,'.$usuario->contacto->Id_Contacto.',Id_Contacto',
            'direccion' => 'required|string|max:150',
            'id_pais' => 'required|exists:País,Id_País',
            'id_departamento' => 'required|exists:Departamentos,Id_Dpto',
            'id_municipio' => 'required|exists:Municipios,Id_Mpio',
            'id_especialidad' => 'required|exists:Especialidades,Id_Especialidad',
            'id_estado' => 'required|exists:Estados,Id_Estado',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Actualizar el contacto
        $usuario->contacto->update([
            'Telefono' => $request->telefono,
            'Correo' => $request->correo,
            'Direccion' => $request->direccion,
        ]);

        // Actualizar el lugar de nacimiento
        $usuario->lugarNacimiento->update([
            'Id_País' => $request->id_pais,
            'Id_Dpto' => $request->id_departamento,
            'Id_Mpio' => $request->id_municipio,
        ]);

        // Actualizar el usuario
        $usuario->update([
            'Primer_Nombre' => $request->primer_nombre,
            'Segundo_Nombre' => $request->segundo_nombre,
            'Primer_Apellido' => $request->primer_apellido,
            'Segundo_Apellido' => $request->segundo_apellido,
            'Id_Documento' => $request->id_documento,
            'Id_Estado' => $request->id_estado,
            'Num_Documento' => $request->num_documento,
            'Fecha_Nacimiento' => $request->fecha_nacimiento,
            'Id_Genero' => $request->id_genero,
            'Id_Rol' => $request->id_rol,
            'Id_Especialidad' => $request->id_especialidad,
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
        $usuario = Usuario::findOrFail($id);
        
        // En lugar de eliminar, marcar como inactivo
        $usuario->update([
            'Id_Estado' => 2, // ID del estado "Inactivo"
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario desactivado exitosamente');
    }
    
    /**
     * Obtiene los departamentos de un país.
     */
    public function getDepartamentos(Request $request)
    {
        $departamentos = Departamento::where('Id_País', $request->id_pais)->get();
        return response()->json($departamentos);
    }
    
    /**
     * Obtiene los municipios de un departamento.
     */
    public function getMunicipios(Request $request)
    {
        $municipios = Municipio::where('Id_Dpto', $request->id_dpto)->get();
        return response()->json($municipios);
    }
}