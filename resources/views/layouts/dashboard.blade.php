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