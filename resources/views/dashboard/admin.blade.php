@extends('layouts.dashboard')

@section('title', 'Dashboard Administrador')

@section('content')
<div class="container-fluid">
    <!-- Header del Dashboard -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="dashboard-title">
                            <i class="fas fa-user-shield text-primary me-2"></i>
                            Panel de Administración
                        </h1>
                        <p class="dashboard-subtitle text-muted">Gestión completa del sistema educativo</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('usuarios.show', Auth::user()->id_usuario) }}" class="btn btn-outline-primary">
                            <i class="fas fa-user"></i> Mi Perfil
                        </a>
                        <a href="{{ route('usuarios.edit', Auth::user()->id_usuario) }}" class="btn btn-primary">
                            <i class="fas fa-user-edit"></i> Editar Perfil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjetas de Estadísticas Principales -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="stats-number">{{ $totalUsuarios }}</h3>
                            <p class="stats-label">Total Usuarios</p>
                            <small class="stats-change text-success">
                                <i class="fas fa-arrow-up"></i> Activos
                            </small>
                        </div>
                        <div class="stats-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="stats-number">{{ $totalCursos }}</h3>
                            <p class="stats-label">Total Cursos</p>
                            <small class="stats-change text-info">
                                <i class="fas fa-book"></i> Programados
                            </small>
                        </div>
                        <div class="stats-icon bg-success">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="stats-number">{{ $totalInscripciones }}</h3>
                            <p class="stats-label">Inscripciones</p>
                            <small class="stats-change text-warning">
                                <i class="fas fa-clipboard-list"></i> Registradas
                            </small>
                        </div>
                        <div class="stats-icon bg-warning">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="stats-number">{{ $totalEscuelas }}</h3>
                            <p class="stats-label">Escuelas</p>
                            <small class="stats-change text-danger">
                                <i class="fas fa-school"></i> Disponibles
                            </small>
                        </div>
                        <div class="stats-icon bg-danger">
                            <i class="fas fa-building"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos Rápidos -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card quick-actions-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt text-warning me-2"></i>
                        Accesos Rápidos
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="{{ route('usuarios.create') }}" class="quick-action-btn">
                                <div class="quick-action-icon bg-primary">
                                    <i class="fas fa-user-plus text-white"></i>
                                </div>
                                <span class="quick-action-text">Nuevo Usuario</span>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="{{ route('cursos.create') }}" class="quick-action-btn">
                                <div class="quick-action-icon bg-success">
                                    <i class="fas fa-plus text-white"></i>
                                </div>
                                <span class="quick-action-text">Nuevo Curso</span>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="{{ route('escuelas.create') }}" class="quick-action-btn">
                                <div class="quick-action-icon bg-info">
                                    <i class="fas fa-school text-white"></i>
                                </div>
                                <span class="quick-action-text">Nueva Escuela</span>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="{{ route('programas.create') }}" class="quick-action-btn">
                                <div class="quick-action-icon bg-warning">
                                    <i class="fas fa-graduation-cap text-white"></i>
                                </div>
                                <span class="quick-action-text">Nuevo Programa</span>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="{{ route('informes.index') }}" class="quick-action-btn">
                                <div class="quick-action-icon bg-secondary">
                                    <i class="fas fa-chart-bar text-white"></i>
                                </div>
                                <span class="quick-action-text">Informes</span>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="{{ route('usuarios.index') }}" class="quick-action-btn">
                                <div class="quick-action-icon bg-dark">
                                    <i class="fas fa-users text-white"></i>
                                </div>
                                <span class="quick-action-text">Gestionar Usuarios</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos y Tablas -->
    <div class="row">
        <!-- Cursos por Capacidad -->
        <div class="col-lg-6 mb-4">
            <div class="card chart-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar text-primary me-2"></i>
                        Cursos por Capacidad
                    </h5>
                    <a href="{{ route('cursos.index') }}" class="btn btn-sm btn-outline-primary">Ver Todos</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Curso</th>
                                    <th>Capacidad</th>
                                    <th>Ocupación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cursosPorCapacidad as $curso)
                                <tr>
                                    <td>
                                        <strong>{{ Str::limit($curso->curso, 20) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $curso->cupos }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                <div class="progress-bar {{ $curso->cantidad_alumnos >= $curso->cupos * 0.8 ? 'bg-danger' : ($curso->cantidad_alumnos >= $curso->cupos * 0.6 ? 'bg-warning' : 'bg-success') }}" 
                                                     style="width: {{ $curso->cupos > 0 ? ($curso->cantidad_alumnos / $curso->cupos) * 100 : 0 }}%">
                                                </div>
                                            </div>
                                            <small class="text-muted">{{ $curso->cantidad_alumnos }}/{{ $curso->cupos }}</small>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Usuarios por Rol -->
        <div class="col-lg-6 mb-4">
            <div class="card chart-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users text-success me-2"></i>
                        Usuarios por Rol
                    </h5>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-sm btn-outline-success">Gestionar</a>
                </div>
                <div class="card-body">
                    @foreach ($usuariosPorRol as $rol)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="role-icon me-3">
                                @if($rol->rol == 'Administrador')
                                    <i class="fas fa-user-shield text-danger"></i>
                                @elseif($rol->rol == 'Instructor')
                                    <i class="fas fa-chalkboard-teacher text-warning"></i>
                                @else
                                    <i class="fas fa-user-graduate text-info"></i>
                                @endif
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $rol->rol }}</h6>
                                <small class="text-muted">Usuarios registrados</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <h5 class="mb-0">{{ $rol->total }}</h5>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Programas por Escuela -->
        <div class="col-12">
            <div class="card chart-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-graduation-cap text-info me-2"></i>
                        Programas por Escuela
                    </h5>
                    <a href="{{ route('programas.index') }}" class="btn btn-sm btn-outline-info">Ver Programas</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($programasPorEscuela as $escuela)
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="program-card">
                                <div class="program-header">
                                    <h6 class="program-title">{{ Str::limit($escuela->nombre, 25) }}</h6>
                                    <span class="program-count">{{ $escuela->total }}</span>
                                </div>
                                <div class="program-footer">
                                    <small class="text-muted">Programas activos</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos específicos para el dashboard de administrador */
.dashboard-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 1rem;
}

.dashboard-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.dashboard-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
}

.stats-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
    border: none;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
}

.stats-card-body {
    padding: 1.5rem;
}

.stats-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: #2d3748;
}

.stats-label {
    font-size: 0.9rem;
    color: #718096;
    margin-bottom: 0.5rem;
}

.stats-change {
    font-size: 0.8rem;
    font-weight: 600;
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.quick-actions-card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
}

.quick-action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-decoration: none;
    color: #4a5568;
    padding: 1rem;
    border-radius: 12px;
    transition: all 0.2s ease;
}

.quick-action-btn:hover {
    color: #2d3748;
    background-color: #f7fafc;
    transform: translateY(-2px);
}

.quick-action-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 0.5rem;
    font-size: 1.2rem;
}

.quick-action-text {
    font-size: 0.85rem;
    font-weight: 600;
    text-align: center;
}

.chart-card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
    height: 100%;
}

.program-card {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1rem;
    border-left: 4px solid #667eea;
}

.program-header {
    display: flex;
    justify-content: between;
    align-items: flex-start;
}

.program-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
    flex-grow: 1;
}

.program-count {
    background: #667eea;
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
}

.role-icon {
    font-size: 1.5rem;
}

@media (max-width: 768px) {
    .dashboard-header {
        padding: 1.5rem;
    }
    
    .dashboard-title {
        font-size: 1.5rem;
    }
    
    .stats-number {
        font-size: 2rem;
    }
    
    .quick-action-text {
        font-size: 0.8rem;
    }
}
</style>
@endsection