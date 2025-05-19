@extends('layouts.dashboard')

@section('title', 'Detalles de la Evaluación')

@section('actions')
<a href="{{ route('evaluaciones.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Volver
</a>
@if(Auth::user()->tieneRol('Administrador') || (Auth::user()->tieneRol('Instructor') && $evaluacion->curso->id_usuario == Auth::user()->id_usuario))
<a href="{{ route('evaluaciones.edit', $evaluacion->id_evaluacion) }}" class="btn btn-warning">
    <i class="fas fa-edit"></i> Editar
</a>
@endif
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h3 class="mb-3">Evaluación de {{ $evaluacion->usuario->primer_nombre }} {{ $evaluacion->usuario->primer_apellido }}</h3>
                <h5 class="text-muted">Curso: {{ $evaluacion->curso->curso }}</h5>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card bg-light h-100">
                    <div class="card-body">
                        <h5 class="card-title">Información de la Evaluación</h5>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Estudiante:</th>
                                    <td>{{ $evaluacion->usuario->primer_nombre }} {{ $evaluacion->usuario->primer_apellido }}</td>
                                </tr>
                                <tr>
                                    <th>Documento:</th>
                                    <td>{{ $evaluacion->usuario->documento->tipo_documento }}: {{ $evaluacion->usuario->num_documento }}</td>
                                </tr>
                                <tr>
                                    <th>Curso:</th>
                                    <td>{{ $evaluacion->curso->curso }}</td>
                                </tr>
                                <tr>
                                    <th>Nivel del curso:</th>
                                    <td>{{ $evaluacion->curso->nivel->nivel }}</td>
                                </tr>
                                <tr>
                                    <th>Instructor:</th>
                                    <td>{{ $evaluacion->curso->instructor->primer_nombre }} {{ $evaluacion->curso->instructor->primer_apellido }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-light h-100">
                    <div class="card-body">
                        <h5 class="card-title">Detalles de la Calificación</h5>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Fecha de Evaluación:</th>
                                    <td>{{ $evaluacion->fecha_evaluacion instanceof \Carbon\Carbon ? $evaluacion->fecha_evaluacion->format('d/m/Y') : $evaluacion->fecha_evaluacion }}</td>
                                </tr>
                                <tr>
                                    <th>Nota:</th>
                                    <td>
                                        <h3 class="{{ $evaluacion->nota >= 3.0 ? 'text-success' : 'text-danger' }}">
                                            {{ number_format($evaluacion->nota, 1) }}
                                        </h3>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Estado:</th>
                                    <td>
                                        @if($evaluacion->nota >= 3.0)
                                        <span class="badge bg-success">Aprobado</span>
                                        @else
                                        <span class="badge bg-danger">Reprobado</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Fecha de Registro:</th>
                                    <td>{{ $evaluacion->created_at instanceof \Carbon\Carbon ? $evaluacion->created_at->format('d/m/Y H:i') : $evaluacion->created_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5 class="card-title">Comentarios del instructor</h5>
                        <div class="p-3 bg-white rounded">
                            @if($evaluacion->comentarios)
                                <p class="mb-0">{{ $evaluacion->comentarios }}</p>
                            @else
                                <p class="mb-0 text-muted">No hay comentarios registrados para esta evaluación.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @php
            // Obtener el promedio general del curso
            $promedioCurso = $evaluacion->curso->evaluaciones->avg('nota');
            
            // Obtener el promedio del estudiante en este curso
            $promedioEstudiante = $evaluacion->curso->evaluaciones
                ->where('id_usuario', $evaluacion->id_usuario)
                ->avg('nota');
            
            // Obtener la posición del estudiante en el curso
            $evaluacionesCurso = $evaluacion->curso->evaluaciones
                ->groupBy('id_usuario')
                ->map(function ($grupo) {
                    return $grupo->avg('nota');
                })
                ->sort()
                ->reverse()
                ->values();
            
            $posicion = $evaluacionesCurso->search(function ($valor, $clave) use ($promedioEstudiante) {
                return abs($valor - $promedioEstudiante) < 0.001;
            }) + 1;
            
            $totalEstudiantes = $evaluacionesCurso->count();
        @endphp

        @if(Auth::user()->tieneRol('Administrador') || Auth::user()->tieneRol('Instructor') || Auth::user()->id_usuario == $evaluacion->id_usuario)
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Análisis Comparativo</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6>Promedio del Estudiante</h6>
                                        <h3 class="{{ $promedioEstudiante >= 3.0 ? 'text-success' : 'text-danger' }}">
                                            {{ number_format($promedioEstudiante, 1) }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6>Promedio del Curso</h6>
                                        <h3 class="{{ $promedioCurso >= 3.0 ? 'text-success' : 'text-danger' }}">
                                            {{ number_format($promedioCurso, 1) }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6>Posición en el Curso</h6>
                                        <h3>
                                            {{ $posicion }} / {{ $totalEstudiantes }}
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

        <!-- Acciones Disponibles -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex flex-wrap justify-content-end gap-2">
                    @if(Auth::user()->tieneRol('Administrador') || (Auth::user()->tieneRol('Instructor') && $evaluacion->curso->id_usuario == Auth::user()->id_usuario))
                    <form action="{{ route('evaluaciones.destroy', $evaluacion->id_evaluacion) }}" method="POST" onsubmit="return confirm('¿Está seguro de que desea eliminar esta evaluación?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Eliminar Evaluación
                        </button>
                    </form>
                    @endif
                    
                    <a href="{{ route('evaluaciones.create') }}?id_curso={{ $evaluacion->curso->id_curso }}&id_usuario={{ $evaluacion->usuario->id_usuario }}" class="btn btn-primary">
                        <i class="fas fa-star"></i> Nueva Evaluación para este Estudiante
                    </a>
                    
                    <a href="{{ route('cursos.show', $evaluacion->curso->id_curso) }}" class="btn btn-info">
                        <i class="fas fa-book"></i> Ver Curso
                    </a>
                    
                    <a href="{{ route('usuarios.show', $evaluacion->usuario->id_usuario) }}" class="btn btn-secondary">
                        <i class="fas fa-user"></i> Ver Perfil del Estudiante
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection