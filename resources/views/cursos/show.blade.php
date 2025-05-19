@extends('layouts.dashboard')

@section('title', 'Detalles del Curso')

@section('actions')
<a href="{{ route('cursos.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Volver
</a>
@if(Auth::user()->tieneRol('Administrador') || (Auth::user()->tieneRol('Instructor') && $curso->id_usuario == Auth::user()->id_usuario))
<a href="{{ route('cursos.edit', $curso->id_curso) }}" class="btn btn-warning">
    <i class="fas fa-edit"></i> Editar
</a>
@endif
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h3 class="mb-3">{{ $curso->curso }}</h3>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card bg-light h-100">
                    <div class="card-body">
                        <h5 class="card-title">Información General</h5>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Nivel:</th>
                                    <td>{{ $curso->nivel->nivel }}</td>
                                </tr>
                                <tr>
                                    <th>Instructor:</th>
                                    <td>{{ $curso->instructor->primer_nombre }} {{ $curso->instructor->primer_apellido }}</td>
                                </tr>
                                <tr>
                                    <th>Recurso:</th>
                                    <td>{{ $curso->recurso->recurso }}</td>
                                </tr>
                                <tr>
                                    <th>Objetivo:</th>
                                    <td>{{ $curso->objetivo }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-light h-100">
                    <div class="card-body">
                        <h5 class="card-title">Horario y Capacidad</h5>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Horario:</th>
                                    <td>{{ $curso->horario->dia }} de {{ $curso->horario->hora_inicio }} a {{ $curso->horario->hora_fin }}</td>
                                </tr>
                                <tr>
                                    <th>Fecha de Inicio:</th>
                                    <td>{{ $curso->fecha_inicio instanceof \Carbon\Carbon ? $curso->fecha_inicio->format('d/m/Y') : $curso->fecha_inicio }}</td>
                                </tr>
                                <tr>
                                    <th>Fecha de Fin:</th>
                                    <td>{{ $curso->fecha_fin instanceof \Carbon\Carbon ? $curso->fecha_fin->format('d/m/Y') : $curso->fecha_fin }}</td>
                                </tr>
                                <tr>
                                    <th>Cupos:</th>
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <span>{{ $curso->cantidad_alumnos }} / {{ $curso->cupos }}</span>
                                            <span>
                                                @if($curso->cantidad_alumnos < $curso->cupos)
                                                    <span class="badge bg-success">Disponible</span>
                                                @else
                                                    <span class="badge bg-danger">Completo</span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="progress mt-2">
                                            <div class="progress-bar {{ $curso->cantidad_alumnos < $curso->cupos ? 'bg-success' : 'bg-danger' }}" role="progressbar" style="width: {{ ($curso->cantidad_alumnos / $curso->cupos) * 100 }}%" aria-valuenow="{{ $curso->cantidad_alumnos }}" aria-valuemin="0" aria-valuemax="{{ $curso->cupos }}"></div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Estudiantes Inscritos</h5>
                        <span class="badge bg-primary">{{ $curso->inscripciones->count() }}</span>
                    </div>
                    <div class="card-body">
                        @if($curso->inscripciones->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Documento</th>
                                        <th>Fecha de Inscripción</th>
                                        @if(Auth::user()->tieneRol('Administrador') || Auth::user()->tieneRol('Instructor'))
                                        <th>Acciones</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($curso->inscripciones as $inscripcion)
                                    <tr>
                                        <td>{{ $inscripcion->usuario->primer_nombre }} {{ $inscripcion->usuario->primer_apellido }}</td>
                                        <td>{{ $inscripcion->usuario->documento->tipo_documento }}: {{ $inscripcion->usuario->num_documento }}</td>
                                        <td>{{ $inscripcion->fecha_inscripcion instanceof \Carbon\Carbon ? $inscripcion->fecha_inscripcion->format('d/m/Y') : $inscripcion->fecha_inscripcion }}</td>
                                        @if(Auth::user()->tieneRol('Administrador') || Auth::user()->tieneRol('Instructor'))
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('usuarios.show', $inscripcion->usuario->id_usuario) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('evaluaciones.create') }}?id_curso={{ $curso->id_curso }}&id_usuario={{ $inscripcion->usuario->id_usuario }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-star"></i> Evaluar
                                                </a>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p>No hay estudiantes inscritos en este curso.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if(Auth::user()->tieneRol('Administrador') || Auth::user()->tieneRol('Instructor'))
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Evaluaciones Registradas</h5>
                        <span class="badge bg-primary">{{ $curso->evaluaciones->count() }}</span>
                    </div>
                    <div class="card-body">
                        @if($curso->evaluaciones->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Estudiante</th>
                                        <th>Fecha de Evaluación</th>
                                        <th>Nota</th>
                                        <th>Comentarios</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($curso->evaluaciones as $evaluacion)
                                    <tr>
                                        <td>{{ $evaluacion->usuario->primer_nombre }} {{ $evaluacion->usuario->primer_apellido }}</td>
                                        <td>{{ $evaluacion->fecha_evaluacion instanceof \Carbon\Carbon ? $evaluacion->fecha_evaluacion->format('d/m/Y') : $evaluacion->fecha_evaluacion }}</td>
                                        <td>
                                            <span class="badge {{ $evaluacion->nota >= 3.0 ? 'bg-success' : 'bg-danger' }}">
                                                {{ number_format($evaluacion->nota, 1) }}
                                            </span>
                                        </td>
                                        <td>{{ Str::limit($evaluacion->comentarios, 30) }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('evaluaciones.show', $evaluacion->id_evaluacion) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('evaluaciones.edit', $evaluacion->id_evaluacion) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p>No hay evaluaciones registradas para este curso.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas de Evaluaciones -->
        @if($curso->evaluaciones->count() > 0)
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Estadísticas de Evaluaciones</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6>Promedio General</h6>
                                        <h3 class="{{ $curso->evaluaciones->avg('nota') >= 3.0 ? 'text-success' : 'text-danger' }}">
                                            {{ number_format($curso->evaluaciones->avg('nota'), 1) }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6>Nota más Alta</h6>
                                        <h3 class="text-success">
                                            {{ number_format($curso->evaluaciones->max('nota'), 1) }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6>Nota más Baja</h6>
                                        <h3 class="{{ $curso->evaluaciones->min('nota') >= 3.0 ? 'text-success' : 'text-danger' }}">
                                            {{ number_format($curso->evaluaciones->min('nota'), 1) }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6>Aprobados</h6>
                                        <h3 class="text-success">
                                            {{ $curso->evaluaciones->filter(function($evaluacion) { return $evaluacion->nota >= 3.0; })->count() }} / {{ $curso->evaluaciones->count() }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endif

        <!-- Acciones Disponibles -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex flex-wrap justify-content-end gap-2">
                    @if(Auth::user()->tieneRol('Estudiante') && $curso->cantidad_alumnos < $curso->cupos)
                        @php
                            $yaInscrito = $curso->inscripciones->where('id_usuario', Auth::user()->id_usuario)->count() > 0;
                        @endphp
                        
                        @if(!$yaInscrito)
                        <form action="{{ route('inscripciones.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_curso" value="{{ $curso->id_curso }}">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-user-plus"></i> Inscribirse
                            </button>
                        </form>
                        @endif
                    @endif
                    
                    @if(Auth::user()->tieneRol('Administrador') || Auth::user()->tieneRol('Instructor'))
                    <a href="{{ route('evaluaciones.create') }}?id_curso={{ $curso->id_curso }}" class="btn btn-primary">
                        <i class="fas fa-star"></i> Nueva Evaluación
                    </a>
                    @endif
                    
                    @if(Auth::user()->tieneRol('Administrador'))
                    <a href="{{ route('programas.create') }}?id_curso={{ $curso->id_curso }}" class="btn btn-info">
                        <i class="fas fa-graduation-cap"></i> Crear Programa con este Curso
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection