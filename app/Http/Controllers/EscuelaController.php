<?php

namespace App\Http\Controllers;

use App\Models\Escuela;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class EscuelaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Administrador')->except(['index', 'show']);
    }
    
    /**
     * Muestra un listado de escuelas.
     */
    public function index()
    {
        $escuelas = Escuela::all();
        return view('escuelas.index', compact('escuelas'));
    }
    
    /**
     * Muestra el formulario para crear una nueva escuela.
     */
    public function create()
    {
        return view('escuelas.create');
    }
    
    /**
     * Almacena una nueva escuela en la base de datos.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $escuela = Escuela::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);
        
        return redirect()->route('escuelas.index')->with('success', 'Escuela creada exitosamente');
    }
    
    /**
     * Muestra la información de una escuela específica.
     */
    public function show($id)
    {
        $escuela = Escuela::with('programas.curso')->findOrFail($id);
        return view('escuelas.show', compact('escuela'));
    }
    
    /**
     * Muestra el formulario para editar una escuela existente.
     */
    public function edit($id)
    {
        $escuela = Escuela::findOrFail($id);
        return view('escuelas.edit', compact('escuela'));
    }
    
    /**
     * Actualiza la información de una escuela existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $escuela = Escuela::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $escuela->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);
        
        return redirect()->route('escuelas.index')->with('success', 'Escuela actualizada exitosamente');
    }
    
    /**
     * Elimina una escuela de la base de datos.
     */
    public function destroy($id)
    {
        $escuela = Escuela::findOrFail($id);
        
        // Verificar si tiene programas asociados
        if ($escuela->programas()->count() > 0) {
            return redirect()->route('escuelas.index')->with('error', 'No se puede eliminar una escuela con programas asociados');
        }
        
        $escuela->delete();
        
        return redirect()->route('escuelas.index')->with('success', 'Escuela eliminada exitosamente');
    }
}