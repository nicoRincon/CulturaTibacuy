<?php

namespace App\Http\Controllers;

use App\Models\ProgramaFormacion;
use App\Models\TipoEscuela;
use App\Models\Escuela;
use App\Models\Ubicacion;
use App\Models\Curso;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $responsables = User::whereHas('rol', function ($query) {
            $query->where('rol', 'Instructor')->orWhere('rol', 'Administrador');
        })->get();

        return view('programas.create', compact('tiposEscuela', 'escuelas', 'ubicaciones', 'cursos', 'responsables'));
    }

    /**
     * Almacena un nuevo programa de formación en la base de datos.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_tipo_escuela' => 'required|exists:tipos_escuela,id_tipo_escuela',
            'id_escuela' => 'required|exists:escuelas,id_escuela',
            'id_ubicacion' => 'required|exists:ubicaciones,id_ubicacion',
            'id_curso' => 'required|exists:cursos,id_curso',
            'id_responsable' => 'required|exists:usuarios,id_usuario',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ProgramaFormacion::create([
            'id_tipo_escuela' => $request->id_tipo_escuela,
            'id_escuela' => $request->id_escuela,
            'id_ubicacion' => $request->id_ubicacion,
            'id_curso' => $request->id_curso,
            'id_usuario' => $request->id_responsable,
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
        $responsables = User::whereHas('rol', function ($query) {
            $query->where('rol', 'Instructor')->orWhere('rol', 'Administrador');
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
            'id_tipo_escuela' => 'required|exists:tipos_escuela,id_tipo_escuela',
            'id_escuela' => 'required|exists:escuelas,id_escuela',
            'id_ubicacion' => 'required|exists:ubicaciones,id_ubicacion',
            'id_curso' => 'required|exists:cursos,id_curso',
            'id_responsable' => 'required|exists:usuarios,id_usuario',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $programa->update([
            'id_tipo_escuela' => $request->id_tipo_escuela,
            'id_escuela' => $request->id_escuela,
            'id_ubicacion' => $request->id_ubicacion,
            'id_curso' => $request->id_curso,
            'id_usuario' => $request->id_responsable,
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