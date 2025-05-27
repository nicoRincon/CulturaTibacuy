@extends('layouts.master')

@section('user-menu-items')
<a class="dropdown-item" href="{{ url('/') }}">
    <i class="fas fa-home me-2"></i>{{ __('Inicio') }}
</a>
@endsection

@section('content-wrapper')
<div class="row">
    <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
            <!-- Widget de información del usuario -->
            <div class="card mb-3 border-0 bg-primary text-white">
                <div class="card-body text-center py-3">
                    <div class="user-avatar mx-auto mb-2" style="width: 60px; height: 60px; font-size: 18px; background: rgba(255,255,255,0.2);">
                        {{ substr(Auth::user()->primer_nombre, 0, 1) }}{{ substr(Auth::user()->primer_apellido, 0, 1) }}
                    </div>
                    <h6 class="card-title mb-1">{{ Auth::user()->primer_nombre }}</h6>
                    <small class="opacity-75">{{ Auth::user()->rol->rol }}</small>
                    <div class="mt-2">
                        <a href="{{ route('usuarios.show', Auth::user()->id_usuario) }}" class="btn btn-sm btn-outline-light me-1" title="Ver Perfil">
                            <i class="fas fa-user"></i>
                        </a>
                        <a href="{{ route('usuarios.edit', Auth::user()->id_usuario) }}" class="btn btn-sm btn-outline-light" title="Editar Perfil">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Menú de navegación -->
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Dashboard
                    </a>
                </li>
                
                @if(Auth::user()->tieneRol('Administrador'))
                <li class="nav-item">
                    <a class="nav-link sidebar-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}" href="{{ route('usuarios.index') }}">
                        <i class="fas fa-users me-2"></i>
                        Usuarios
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link sidebar-link {{ request()->routeIs('escuelas.*') ? 'active' : '' }}" href="{{ route('escuelas.index') }}">
                        <i class="fas fa-school me-2"></i>
                        Escuelas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link sidebar-link {{ request()->routeIs('programas.*') ? 'active' : '' }}" href="{{ route('programas.index') }}">
                        <i class="fas fa-graduation-cap me-2"></i>
                        Programas de Formación
                    </a>
                </li>
                @endif
                
                @if(Auth::user()->tieneRol('Administrador') || Auth::user()->tieneRol('Instructor'))
                <li class="nav-item">
                    <a class="nav-link sidebar-link {{ request()->routeIs('cursos.*') ? 'active' : '' }}" href="{{ route('cursos.index') }}">
                        <i class="fas fa-book me-2"></i>
                        Cursos
                    </a>
                </li>
                @endif
                
                <li class="nav-item">
                    <a class="nav-link sidebar-link {{ request()->routeIs('inscripciones.*') ? 'active' : '' }}" href="{{ route('inscripciones.index') }}">
                        <i class="fas fa-clipboard-list me-2"></i>
                        Inscripciones
                    </a>
                </li>
                
                @if(Auth::user()->tieneRol('Administrador') || Auth::user()->tieneRol('Instructor'))
                <li class="nav-item">
                    <a class="nav-link sidebar-link {{ request()->routeIs('evaluaciones.*') ? 'active' : '' }}" href="{{ route('evaluaciones.index') }}">
                        <i class="fas fa-star me-2"></i>
                        Evaluaciones
                    </a>
                </li>
                @endif
                
                <li class="nav-item">
                    <a class="nav-link sidebar-link {{ request()->routeIs('informes.*') ? 'active' : '' }}" href="{{ route('informes.index') }}">
                        <i class="fas fa-chart-bar me-2"></i>
                        Informes
                    </a>
                </li>

                <!-- Separador y acciones rápidas -->
                <hr class="my-3">
                <li class="nav-item">
                    <h6 class="text-muted px-3 mb-2">
                        <i class="fas fa-bolt me-1"></i>Acciones Rápidas
                    </h6>
                </li>

                @if(Auth::user()->tieneRol('Estudiante'))
                <li class="nav-item">
                    <a class="nav-link sidebar-link text-success" href="{{ route('inscripciones.create') }}">
                        <i class="fas fa-plus-circle me-2"></i>
                        Nueva Inscripción
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link sidebar-link text-info" href="{{ route('informes.estudiante') }}">
                        <i class="fas fa-file-pdf me-2"></i>
                        Mi Informe
                    </a>
                </li>
                @endif

                @if(Auth::user()->tieneRol('Instructor'))
                <li class="nav-item">
                    <a class="nav-link sidebar-link text-success" href="{{ route('evaluaciones.create') }}">
                        <i class="fas fa-star me-2"></i>
                        Nueva Evaluación
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link sidebar-link text-warning" href="{{ route('cursos.create') }}">
                        <i class="fas fa-plus me-2"></i>
                        Nuevo Curso
                    </a>
                </li>
                @endif

                @if(Auth::user()->tieneRol('Administrador'))
                <li class="nav-item">
                    <a class="nav-link sidebar-link text-success" href="{{ route('usuarios.create') }}">
                        <i class="fas fa-user-plus me-2"></i>
                        Nuevo Usuario
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link sidebar-link text-info" href="{{ route('escuelas.create') }}">
                        <i class="fas fa-school me-2"></i>
                        Nueva Escuela
                    </a>
                </li>
                @endif
            </ul>

            <!-- Widget de estadísticas personales -->
            <div class="mt-4">
                <div class="card border-0 bg-light">
                    <div class="card-body p-3">
                        <h6 class="card-title text-muted mb-3">
                            <i class="fas fa-chart-pie me-1"></i>Mi Resumen
                        </h6>
                        
                        @if(Auth::user()->tieneRol('Estudiante'))
                        <div class="d-flex justify-content-between mb-2">
                            <small class="text-muted">Cursos Inscritos:</small>
                            <span class="badge bg-primary">{{ Auth::user()->inscripciones->count() }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <small class="text-muted">Evaluaciones:</small>
                            <span class="badge bg-success">{{ Auth::user()->evaluaciones->count() }}</span>
                        </div>
                        @endif

                        @if(Auth::user()->tieneRol('Instructor'))
                        <div class="d-flex justify-content-between mb-2">
                            <small class="text-muted">Cursos que imparto:</small>
                            <span class="badge bg-primary">{{ Auth::user()->cursos->count() }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <small class="text-muted">Estudiantes totales:</small>
                            <span class="badge bg-success">{{ Auth::user()->cursos->sum('cantidad_alumnos') }}</span>
                        </div>
                        @endif

                        @if(Auth::user()->tieneRol('Administrador'))
                        <div class="d-flex justify-content-between mb-2">
                            <small class="text-muted">Usuarios activos:</small>
                            <span class="badge bg-primary">{{ App\Models\User::where('id_estado', 1)->count() }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <small class="text-muted">Cursos activos:</small>
                            <span class="badge bg-success">{{ App\Models\Curso::count() }}</span>
                        </div>
                        @endif

                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Último acceso:</small>
                            <small class="text-muted">{{ now()->format('d/m H:i') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">@yield('title')</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                @yield('actions')
            </div>
        </div>

        @yield('content')
    </main>
</div>
@endsection