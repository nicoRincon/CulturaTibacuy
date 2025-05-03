<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistema Escolar') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        .sidebar {
            min-height: calc(100vh - 56px);
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }
        
        .sidebar-link {
            color: #333;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .sidebar-link:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }
        
        .sidebar-link.active {
            background-color: rgba(0, 0, 0, 0.1);
            font-weight: bold;
        }
        
        .content {
            padding: 20px;
        }
        
        .card-dashboard {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        
        .card-dashboard:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <header class="navbar navbar-expand-md navbar-dark bg-primary sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                {{ config('app.name', 'Sistema Escolar') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->Primer_Nombre }} {{ Auth::user()->Primer_Apellido }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('home') }}">
                                <i class="fas fa-home me-2"></i>{{ __('Inicio') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>{{ __('Cerrar sesión') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
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
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('title')</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        @yield('actions')
                    </div>
                </div>

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    @yield('scripts')
</body>
</html>