<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Curso;
use App\Models\Inscripcion;
use App\Models\Evaluacion;
use App\Models\NotaFinal;
use App\Models\Escuela;
use App\Models\ProgramaFormacion;
use App\Exports\UsuariosExport;
use App\Exports\CursosExport;
use App\Exports\InscripcionesExport;
use App\Exports\EvaluacionesExport;
use App\Exports\ProgramasExport;
use App\Exports\EstudianteExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Facades\Excel;

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
        else if ($request->formato == 'excel') {
            $filename = 'informe_usuarios_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
            return Excel::download(
                new UsuariosExport($request->tipo_usuario, $request->estado),
                $filename
            );
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
        else if ($request->formato == 'excel') {
            $filename = 'informe_cursos_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
            return Excel::download(
                new CursosExport($request->estado_curso),
                $filename
            );
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
            $query->where('fecha_inscripcion', '>=', $request->fecha_desde);
        }
        
        if ($request->filled('fecha_hasta')) {
            $query->where('fecha_inscripcion', '<=', $request->fecha_hasta);
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
        else if ($request->formato == 'excel') {
            $filename = 'informe_inscripciones_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
            return Excel::download(
                new InscripcionesExport($request->id_curso, $request->fecha_desde, $request->fecha_hasta),
                $filename
            );
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
        else if ($request->formato == 'excel') {
            $filename = 'informe_evaluaciones_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
            return Excel::download(
                new EvaluacionesExport($request->id_curso, $request->fecha_desde, $request->fecha_hasta),
                $filename
            );
        }
    }
    
    /**
     * Genera informe para un estudiante en PDF.
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
     * Genera informe académico completo para estudiante en Excel.
     */
    public function estudianteInformeExcel()
    {
        $user = Auth::user();
        
        if (!$user->tieneRol('Estudiante')) {
            return redirect()->back()->with('error', 'Esta función es solo para estudiantes.');
        }
        
        $filename = 'informe_academico_' . str_replace(' ', '_', $user->primer_nombre . '_' . $user->primer_apellido) . '_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new EstudianteExport($user->id_usuario), $filename);
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
        else if ($request->formato == 'excel') {
            $filename = 'informe_programas_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
            return Excel::download(
                new ProgramasExport($request->id_escuela),
                $filename
            );
        }
    }
    
    /**
     * Informe consolidado de estadísticas generales (BONUS)
     */
    public function estadisticasGenerales(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'formato' => 'required|in:web,pdf,excel',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Recopilar estadísticas generales
        $estadisticas = [
            'total_usuarios' => User::count(),
            'total_estudiantes' => User::whereHas('rol', function($q) { $q->where('rol', 'Estudiante'); })->count(),
            'total_instructores' => User::whereHas('rol', function($q) { $q->where('rol', 'Instructor'); })->count(),
            'total_cursos' => Curso::count(),
            'total_inscripciones' => Inscripcion::count(),
            'total_evaluaciones' => Evaluacion::count(),
            'promedio_general' => Evaluacion::avg('nota'),
            'cursos_activos' => Curso::where('fecha_inicio', '<=', now())
                                   ->where('fecha_fin', '>=', now())
                                   ->count(),
            'cursos_completos' => Curso::whereRaw('cupos <= cantidad_alumnos')->count(),
            'ocupacion_promedio' => Curso::selectRaw('AVG(cantidad_alumnos / cupos * 100) as promedio')
                                        ->where('cupos', '>', 0)
                                        ->first()->promedio ?? 0,
        ];
        
        if ($request->formato == 'web') {
            return view('informes.estadisticas', compact('estadisticas'));
        } 
        else if ($request->formato == 'pdf') {
            $pdf = PDF::loadView('informes.estadisticas_pdf', compact('estadisticas'));
            return $pdf->download('estadisticas_generales.pdf');
        } 
        else if ($request->formato == 'excel') {
            $filename = 'estadisticas_generales_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
            return Excel::download(new EstadisticasExport($estadisticas), $filename);
        }
    }
}