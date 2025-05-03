<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
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
        $totalUsuarios = Usuario::count();
        $totalCursos = Curso::count();
        $totalInscripciones = Inscripcion::count();
        $totalEscuelas = Escuela::count();
        
        // Cursos por capacidad
        $cursosPorCapacidad = Curso::select('Id_Curso', 'Curso', 'Cupos', 'Cantidad_Alumnos')
            ->orderBy('Cantidad_Alumnos', 'desc')
            ->take(5)
            ->get();
            
        // Usuarios por rol
        $usuariosPorRol = Usuario::select('roles.Rol', DB::raw('count(*) as total'))
            ->join('Roles', 'Usuarios.Id_Rol', '=', 'Roles.Id_Rol')
            ->groupBy('roles.Rol')
            ->get();
            
        // Programas por escuela
        $programasPorEscuela = ProgramaFormacion::select('escuelas.Nombre', DB::raw('count(*) as total'))
            ->join('Escuelas', 'Programa_De_formación.Id_Escuela', '=', 'Escuelas.Id_Escuela')
            ->groupBy('escuelas.Nombre')
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
        $cursos = Curso::where('Id_Usuario', $user->Id_Usuario)->get();
        
        // Inscripciones en sus cursos
        $inscripciones = Inscripcion::whereIn('Id_Curso', $cursos->pluck('Id_Curso'))
            ->with(['usuario', 'curso'])
            ->get();
            
        // Evaluaciones recientes
        $evaluacionesRecientes = Evaluacion::whereIn('Id_Curso', $cursos->pluck('Id_Curso'))
            ->with(['usuario', 'curso'])
            ->orderBy('Fecha_Evaluacion', 'desc')
            ->take(5)
            ->get();
            
        // Promedio de evaluaciones por curso
        $promedioEvaluaciones = Evaluacion::select('cursos.Curso', DB::raw('avg(Evaluaciones.Nota) as promedio'))
            ->join('Cursos', 'Evaluaciones.Id_Curso', '=', 'Cursos.Id_Curso')
            ->whereIn('Evaluaciones.Id_Curso', $cursos->pluck('Id_Curso'))
            ->groupBy('cursos.Curso')
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
        $inscripciones = Inscripcion::where('Id_Usuario', $user->Id_Usuario)
            ->with('curso')
            ->get();
            
        // Evaluaciones del estudiante
        $evaluaciones = Evaluacion::where('Id_Usuario', $user->Id_Usuario)
            ->with('curso')
            ->get();
            
        // Notas finales
        $notasFinales = DB::table('Nota_Final')
            ->join('Cursos', 'Nota_Final.Id_Curso', '=', 'Cursos.Id_Curso')
            ->select('Cursos.Curso', 'Nota_Final.Nota_Final')
            ->where('Nota_Final.Id_Usuario', $user->Id_Usuario)
            ->get();
            
        // Cursos disponibles (con cupos)
        $cursosDisponibles = Curso::whereRaw('Cupos > Cantidad_Alumnos')
            ->whereNotIn('Id_Curso', $inscripciones->pluck('Id_Curso'))
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