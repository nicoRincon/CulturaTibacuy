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