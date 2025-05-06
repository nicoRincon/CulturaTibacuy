<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Curso;
use App\Models\Inscripcion;
use App\Models\Evaluacion;
use App\Models\Escuela;
use App\Models\ProgramaFormacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Muestra el dashboard según el rol del usuario.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Dashboard para administradores
        if ($user->tieneRol('Administrador')) {
            return $this->adminDashboard();
        }
        
        // Dashboard para instructores
        else if ($user->tieneRol('Instructor')) {
            return $this->instructorDashboard($user);
        }
        
        // Dashboard para estudiantes
        else {
            return $this->estudianteDashboard($user);
        }
    }
    
    /**
     * Dashboard para administradores.
     */
    private function adminDashboard()
    {
        // Estadísticas generales
        $totalUsuarios = User::count();
        $totalCursos = Curso::count();
        $totalInscripciones = Inscripcion::count();
        $totalEscuelas = Escuela::count();
        
        // Cursos por capacidad
        $cursosPorCapacidad = Curso::select('id_curso', 'curso', 'cupos', 'cantidad_alumnos')
            ->orderBy('cantidad_alumnos', 'desc')
            ->take(5)
            ->get();
            
        // Usuarios por rol
        $usuariosPorRol = User::select('roles.rol', DB::raw('count(*) as total'))
            ->join('roles', 'usuarios.id_rol', '=', 'roles.id_rol')
            ->groupBy('roles.rol')
            ->get();
            
        // Programas por escuela
        $programasPorEscuela = ProgramaFormacion::select('escuelas.nombre', DB::raw('count(*) as total'))
            ->join('escuelas', 'programa_de_formación.id_escuela', '=', 'escuelas.id_escuela')
            ->groupBy('escuelas.nombre')
            ->get();
            
        return view('dashboard.admin', compact(
            'totalUsuarios', 
            'totalCursos', 
            'totalInscripciones', 
            'totalEscuelas',
            'cursosPorCapacidad',
            'usuariosPorRol',
            'programasPorEscuela'
        ));
    }
    
    /**
     * Dashboard para instructores.
     */
    private function instructorDashboard($user)
    {
        // Cursos que imparte
        $cursos = Curso::where('id_usuario', $user->id_usuario)->get();
        
        // Inscripciones en sus cursos
        $inscripciones = Inscripcion::whereIn('id_curso', $cursos->pluck('id_curso'))
            ->with(['usuario', 'curso'])
            ->get();
            
        // Evaluaciones recientes
        $evaluacionesRecientes = Evaluacion::whereIn('id_curso', $cursos->pluck('id_curso'))
            ->with(['usuario', 'curso'])
            ->orderBy('fecha_evaluacion', 'desc')
            ->take(5)
            ->get();
            
        // Promedio de evaluaciones por curso
        $promedio_evaluaciones = Evaluacion::select('cursos.curso', DB::raw('avg(evaluaciones.nota) as promedio'))
            ->join('cursos', 'evaluaciones.id_curso', '=', 'cursos.id_curso')
            ->whereIn('evaluaciones.id_curso', $cursos->pluck('id_curso'))
            ->groupBy('cursos.curso')
            ->get();
            
        return view('dashboard.instructor', compact(
            'cursos', 
            'inscripciones', 
            'evaluacionesRecientes', 
            'promedioEvaluaciones'
        ));
    }
    
    /**
     * Dashboard para estudiantes.
     */
    private function estudianteDashboard($user)
    {
        // Inscripciones del estudiante
        $inscripciones = Inscripcion::where('id_usuario', $user->id_usuario)
            ->with('curso')
            ->get();
            
        // Evaluaciones del estudiante
        $evaluaciones = Evaluacion::where('id_usuario', $user->id_usuario)
            ->with('curso')
            ->get();
            
        // Notas finales
        $notasFinales = DB::table('nota_final')
            ->join('cursos', 'nota_final.id_curso', '=', 'cursos.id_curso')
            ->select('cursos.curso', 'nota_final.nota_final')
            ->where('nota_final.id_usuario', $user->id_usuario)
            ->get();
            
        // Cursos disponibles (con cupos)
        $cursosDisponibles = Curso::whereRaw('cupos > cantidad_alumnos')
            ->whereNotIn('id_curso', $inscripciones->pluck('id_curso'))
            ->take(5)
            ->get();
            
        return view('dashboard.estudiante', compact(
            'inscripciones', 
            'evaluaciones', 
            'notasFinales', 
            'cursosDisponibles'
        ));
    }
}