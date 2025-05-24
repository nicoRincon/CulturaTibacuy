<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Curso;
use App\Models\Inscripcion;
use App\Models\Evaluacion;
use App\Models\NotaFinal;
use App\Models\Escuela;
use App\Models\ProgramaFormacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;


class InformeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Muestra la página principal de informes.
     */
    public function index()
    {
        return view('informes.index');
    }
    
    /**
     * Genera informe de usuarios.
     */
    public function usuariosInforme(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo_usuario' => 'required|in:todos,estudiantes,instructores,administradores',
            'estado' => 'required|in:todos,activos,inactivos',
            'formato' => 'required|in:web,pdf,excel',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $query = User::with(['documento', 'genero', 'rol', 'especialidad', 'contacto']);
        
        // Filtro por tipo de usuario (rol)
        if ($request->tipo_usuario != 'todos') {
            $rolMap = [
                'estudiantes' => 'Estudiante',
                'instructores' => 'Instructor',
                'administradores' => 'Administrador',
            ];
            
            $query->whereHas('rol', function($q) use ($rolMap, $request) {
                $q->where('rol', $rolMap[$request->tipo_usuario]);
            });
        }
        
        // Filtro por estado
        if ($request->estado != 'todos') {
            $estadoMap = [
                'activos' => 1, // ID del estado "Activo"
                'inactivos' => 2, // ID del estado "Inactivo"
            ];
            
            $query->where('id_estado', $estadoMap[$request->estado]);
        }
        
        $usuarios = $query->get();
        
        // Generar informe según formato
        if ($request->formato == 'web') {
            return view('informes.usuarios', compact('usuarios'));
        } 
        else if ($request->formato == 'pdf') {
            $pdf = PDF::loadView('informes.usuarios_pdf', compact('usuarios'));
            return $pdf->download('informe_usuarios.pdf');
        } 
        else {
            // Excel - Implementar exportación a Excel
            return redirect()->back()->with('info', 'Exportación a Excel no implementada aún');
        }
    }
    
    /**
     * Genera informe de cursos.
     */
    public function cursosInforme(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'estado_curso' => 'required|in:todos,activos,finalizados,proximos',
            'formato' => 'required|in:web,pdf,excel',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $query = Curso::with(['recurso', 'horario', 'nivel', 'instructor']);
        
        // Filtro por estado del curso
        if ($request->estado_curso != 'todos') {
            $today = now()->format('Y-m-d');
            
            if ($request->estado_curso == 'activos') {
                $query->where('fecha_inicio', '<=', $today)
                      ->where('fecha_fin', '>=', $today);
            } 
            else if ($request->estado_curso == 'finalizados') {
                $query->where('fecha_fin', '<', $today);
            } 
            else if ($request->estado_curso == 'proximos') {
                $query->where('fecha_inicio', '>', $today);
            }
        }
        
        $cursos = $query->get();
        
        // Generar informe según formato
        if ($request->formato == 'web') {
            return view('informes.cursos', compact('cursos'));
        } 
        else if ($request->formato == 'pdf') {
            $pdf = PDF::loadView('informes.cursos_pdf', compact('cursos'));
            return $pdf->download('informe_cursos.pdf');
        } 
        else {
            // Excel - Implementar exportación a Excel
            return redirect()->back()->with('info', 'Exportación a Excel no implementada aún');
        }
    }
    
    /**
     * Genera informe de inscripciones.
     */
    public function inscripcionesInforme(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_curso' => 'nullable|exists:cursos,id_curso',
            'fecha_desde' => 'nullable|date',
            'fecha_hasta' => 'nullable|date|after_or_equal:fecha_desde',
            'formato' => 'required|in:web,pdf,excel',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $query = Inscripcion::with(['curso', 'usuario']);
        
        // Filtro por curso
        if ($request->filled('id_curso')) {
            $query->where('id_curso', $request->id_curso);
        }
        
        // Filtro por fecha
        if ($request->filled('fecha_desde')) {
            $query->where('Fecha_Inscripcion', '>=', $request->fecha_desde);
        }
        
        if ($request->filled('fecha_hasta')) {
            $query->where('Fecha_Inscripcion', '<=', $request->fecha_hasta);
        }
        
        $inscripciones = $query->get();
        
        // Generar informe según formato
        if ($request->formato == 'web') {
            return view('informes.inscripciones', compact('inscripciones'));
        } 
        else if ($request->formato == 'pdf') {
            $pdf = PDF::loadView('informes.inscripciones_pdf', compact('inscripciones'));
            return $pdf->download('informe_inscripciones.pdf');
        } 
        else {
            // Excel - Implementar exportación a Excel
            return redirect()->back()->with('info', 'Exportación a Excel no implementada aún');
        }
    }
    
    /**
     * Genera informe de evaluaciones.
     */
    public function evaluacionesInforme(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_curso' => 'nullable|exists:cursos,id_curso',
            'fecha_desde' => 'nullable|date',
            'fecha_hasta' => 'nullable|date|after_or_equal:fecha_desde',
            'formato' => 'required|in:web,pdf,excel',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $query = Evaluacion::with(['curso', 'usuario']);
        
        // Filtro por curso
        if ($request->filled('id_curso')) {
            $query->where('id_curso', $request->id_curso);
        }
        
        // Filtro por fecha
        if ($request->filled('fecha_desde')) {
            $query->where('fecha_evaluacion', '>=', $request->fecha_desde);
        }
        
        if ($request->filled('fecha_hasta')) {
            $query->where('fecha_evaluacion', '<=', $request->fecha_hasta);
        }
        
        $evaluaciones = $query->get();
        
        // Generar informe según formato
        if ($request->formato == 'web') {
            return view('informes.evaluaciones', compact('evaluaciones'));
        } 
        else if ($request->formato == 'pdf') {
            $pdf = PDF::loadView('informes.evaluaciones_pdf', compact('evaluaciones'));
            return $pdf->download('informe_evaluaciones.pdf');
        } 
        else {
            // Excel - Implementar exportación a Excel
            return redirect()->back()->with('info', 'Exportación a Excel no implementada aún');
        }
    }
    
    /**
     * Genera informe para un estudiante.
     */
    public function estudianteInforme()
    {
        $user = Auth::user();
        
        // Obtener inscripciones del estudiante
        $inscripciones = Inscripcion::where('id_usuario', $user->id_usuario)
            ->with('curso')
            ->get();
            
        // Obtener evaluaciones del estudiante
        $evaluaciones = Evaluacion::where('id_usuario', $user->id_usuario)
            ->with('curso')
            ->get();
            
        // Obtener notas finales
        $notasFinales = DB::table('nota_final')
            ->join('cursos', 'nota_final.id_curso', '=', 'cursos.id_curso')
            ->select('cursos.curso', 'nota_final.nota_final')
            ->where('nota_final.id_usuario', $user->id_usuario)
            ->get();
            
        $pdf = PDF::loadView('informes.estudiante_pdf', compact('user', 'inscripciones', 'evaluaciones', 'notasFinales'));
        return $pdf->download('mi_informe_academico.pdf');
    }
    
    /**
     * Genera informe de programas por escuela.
     */
    public function programasInforme(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_escuela' => 'nullable|exists:escuelas,id_escuela',
            'formato' => 'required|in:web,pdf,excel',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $query = ProgramaFormacion::with(['tipoEscuela', 'escuela', 'ubicacion', 'curso', 'responsable']);
        
        // Filtro por escuela
        if ($request->filled('id_escuela')) {
            $query->where('id_escuela', $request->id_escuela);
        }
        
        $programas = $query->get();
        
        // Generar informe según formato
        if ($request->formato == 'web') {
            return view('informes.programas', compact('programas'));
        } 
        else if ($request->formato == 'pdf') {
            $pdf = PDF::loadView('informes.programas_pdf', compact('programas'));
            return $pdf->download('informe_programas.pdf');
        } 
        else {
            // Excel - Implementar exportación a Excel
            return redirect()->back()->with('info', 'Exportación a Excel no implementada aún');
        }
    }
}