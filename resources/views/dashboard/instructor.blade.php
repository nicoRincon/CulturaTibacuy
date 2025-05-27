@extends('layouts.dashboard')

@section('title', 'Dashboard - Instructor')

@section('content')
<div class="container">
    <!-- Botón de Mi Perfil -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="text-center">Dashboard - Instructor</h1>
                <div class="d-flex gap-2">
                    <a href="{{ route('usuarios.show', Auth::user()->id_usuario) }}" class="btn btn-outline-primary">
                        <i class="fas fa-user"></i> Ver Mi Perfil
                    </a>
                    <a href="{{ route('usuarios.edit', Auth::user()->id_usuario) }}" class="btn btn-primary">
                        <i class="fas fa-user-edit"></i> Editar Mi Perfil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Información personal del usuario -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <div class="avatar-placeholder bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 24px;">
                                {{ substr(Auth::user()->primer_nombre, 0, 1) }}{{ substr(Auth::user()->primer_apellido, 0, 1) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4 class="mb-1">{{ Auth::user()->primer_nombre }} {{ Auth::user()->primer_apellido }}</h4>
                            <p class="text-muted mb-1">{{ Auth::user()->rol->rol }} - {{ Auth::user()->especialidad->especialidad }}</p>
                            <p class="text-muted mb-0">{{ Auth::user()->contacto->email }}</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <small class="text-muted">Cursos que imparto:</small><br>
                            <h5 class="text-success">{{ $cursos->count() }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mt-5">Cursos que Imparte</h2>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Curso</th>
                <th>Capacidad</th>
                <th>Alumnos Inscritos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cursos as $curso)
            <tr>
                <td>{{ $curso->curso }}</td>
                <td>{{ $curso->cupos }}</td>
                <td>{{ $curso->cantidad_alumnos }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="mt-5">Inscripciones en tus Cursos</h2>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Estudiante</th>
                <th>Curso</th>
                <th>Fecha de Inscripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inscripciones as $inscripcion)
            <tr>
                <td>{{ $inscripcion->usuario->primer_nombre}}</td>
                <td>{{ $inscripcion->curso->curso }}</td>
                <td>{{ $inscripcion->fecha_inscripcion instanceof \Carbon\Carbon ? $inscripcion->fecha_inscripcion->format('d/m/Y') : $inscripcion->fecha_inscripcion }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="mt-5">Evaluaciones Recientes</h2>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Estudiante</th>
                <th>Curso</th>
                <th>Nota</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($evaluacionesRecientes as $evaluacion)
            <tr>
                <td>{{ $evaluacion->usuario->primer_nombre }}</td>
                <td>{{ $evaluacion->curso->curso }}</td>
                <td>{{ $evaluacion->nota }}</td>
                <td>{{ $evaluacion->fecha_evaluacion instanceof \Carbon\Carbon ? $evaluacion->fecha_evaluacion->format('d/m/Y') : $evaluacion->fecha_evaluacion }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="mt-5">Promedio de Evaluaciones por Curso</h2>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Curso</th>
                <th>Promedio</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($promedio_evaluaciones as $promedio)
            <tr>
                <td>{{ $promedio->curso }}</td>
                <td>{{ number_format($promedio->promedio, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection