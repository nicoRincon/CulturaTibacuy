@extends('layouts.dashboard')

@section('title', 'Dashboard - Estudiante')

@section('content')
<div class="container">
    <!-- Botón de Mi Perfil -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="text-center">Dashboard - Estudiante</h1>
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
                            <div class="avatar-placeholder bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 24px;">
                                {{ substr(Auth::user()->primer_nombre, 0, 1) }}{{ substr(Auth::user()->primer_apellido, 0, 1) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4 class="mb-1">{{ Auth::user()->primer_nombre }} {{ Auth::user()->primer_apellido }}</h4>
                            <p class="text-muted mb-1">{{ Auth::user()->rol->rol }} - {{ Auth::user()->especialidad->especialidad }}</p>
                            <p class="text-muted mb-0">{{ Auth::user()->contacto->email }}</p>
                            <p class="text-muted mb-0">{{ Auth::user()->documento->tipo_documento }}: {{ Auth::user()->num_documento }}</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="row text-center">
                                <div class="col-6">
                                    <small class="text-muted">Cursos Inscritos</small><br>
                                    <h5 class="text-primary">{{ $inscripciones->count() }}</h5>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Evaluaciones</small><br>
                                    <h5 class="text-success">{{ $evaluaciones->count() }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos rápidos -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bolt"></i> Accesos Rápidos</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('inscripciones.create') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-plus-circle"></i><br>
                                Nueva Inscripción
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('cursos.index') }}" class="btn btn-outline-success w-100">
                                <i class="fas fa-book"></i><br>
                                Ver Cursos
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('evaluaciones.index') }}" class="btn btn-outline-warning w-100">
                                <i class="fas fa-star"></i><br>
                                Mis Evaluaciones
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('informes.estudiante') }}" class="btn btn-outline-info w-100">
                                <i class="fas fa-file-pdf"></i><br>
                                Informe Académico
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mt-5">Mis Inscripciones</h2>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Curso</th>
                <th>Fecha de Inscripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inscripciones as $inscripcion)
            <tr>
                <td>{{ $inscripcion->curso->curso }}</td>
                <td>{{ $inscripcion->fecha_inscripcion instanceof \Carbon\Carbon ? $inscripcion->fecha_inscripcion->format('d/m/Y') : $inscripcion->fecha_inscripcion }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="mt-5">Mis Evaluaciones</h2>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Curso</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($evaluaciones as $evaluacion)
            <tr>
                <td>{{ $evaluacion->curso->curso }}</td>
                <td>
                    <span class="badge {{ $evaluacion->nota >= 3.0 ? 'bg-success' : 'bg-danger' }}">
                        {{ $evaluacion->nota }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="mt-5">Notas Finales</h2>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Curso</th>
                <th>Nota Final</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notasFinales as $notaFinal)
            <tr>
                <td>{{ $notaFinal->curso }}</td>
                <td>
                    <span class="badge {{ $notaFinal->nota_final >= 3.0 ? 'bg-success' : 'bg-danger' }}">
                        {{ $notaFinal->nota_final }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="mt-5">Cursos Disponibles</h2>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Curso</th>
                <th>Cupos Disponibles</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cursosDisponibles as $curso)
            <tr>
                <td>{{ $curso->curso }}</td>
                <td>{{ $curso->cupos - $curso->cantidad_alumnos }}</td>
                <td>
                    <form action="{{ route('inscripciones.store') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="id_curso" value="{{ $curso->id_curso }}">
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fas fa-user-plus"></i> Inscribirme
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection