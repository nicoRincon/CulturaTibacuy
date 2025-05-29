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
    <link rel="stylesheet" href="{{ asset('css/master.css') }}">

    @yield('styles')
</head>
<body>
    <header class="navbar navbar-expand-md navbar-dark bg-primary sticky-top">
        <div class="container-fluid p-0">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Sistema Escolar') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    @yield('nav-left')
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->primer_nombre }} {{ Auth::user()->primer_apellido }}   
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <!-- Opciones de perfil -->
                                <h6 class="dropdown-header">
                                    <i class="fas fa-user-circle"></i> Mi Cuenta
                                </h6>
 
                                <a class="dropdown-item" href="{{ route('usuarios.show', Auth::user()->id_usuario) }}">
                                    <i class="fas fa-user me-2"></i>Mi Perfil
                                </a>
                                
                                <div class="dropdown-divider"></div>
                                
                                <!-- Navegación rápida -->
                                <h6 class="dropdown-header">
                                    <i class="fas fa-bolt"></i> Acceso Rápido
                                </h6>
                                @yield('user-menu-items')
                                
                                @if(Auth::user()->tieneRol('Estudiante'))
                                <a class="dropdown-item" href="{{ route('inscripciones.create') }}">
                                    <i class="fas fa-plus-circle me-2"></i>Nueva Inscripción
                                </a>
                                <a class="dropdown-item" href="{{ route('informes.estudiante') }}">
                                    <i class="fas fa-file-pdf me-2"></i>Mi Informe Académico
                                </a>
                                @endif
                                
                                @if(Auth::user()->tieneRol('Instructor'))
                                <a class="dropdown-item" href="{{ route('cursos.index') }}">
                                    <i class="fas fa-book me-2"></i>Mis Cursos
                                </a>
                                <a class="dropdown-item" href="{{ route('evaluaciones.create') }}">
                                    <i class="fas fa-star me-2"></i>Nueva Evaluación
                                </a>
                                @endif
                                
                                @if(Auth::user()->tieneRol('Administrador'))
                                <a class="dropdown-item" href="{{ route('usuarios.index') }}">
                                    <i class="fas fa-users me-2"></i>Gestión de Usuarios
                                </a>
                                <a class="dropdown-item" href="{{ route('informes.index') }}">
                                    <i class="fas fa-chart-bar me-2"></i>Informes
                                </a>
                                @endif
                                
                                <div class="dropdown-divider"></div>
                                
                                <!-- Logout -->
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>{{ __('Cerrar sesión') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </header>

    <div class="container-fluid p-0">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
            <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @yield('content-wrapper')
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    @yield('scripts')
</body>

<footer class="footer">
    <div class="container text-center">
        <div class="row">
            <div class="col-md-6 text-md-start">
                <span class="text-muted">© {{ date('Y') }} {{ config('app.name', 'Sistema Escolar') }}. Todos los derechos reservados.</span>
            </div>
            <div class="col-md-6 text-md-end">
                @auth
                <small class="text-muted">
                    Conectado como: <strong>{{ Auth::user()->primer_nombre }} {{ Auth::user()->primer_apellido }}</strong> 
                    ({{ Auth::user()->rol->rol }})
                </small>
                @endauth
            </div>
        </div>
    </div>
</footer>
</html>