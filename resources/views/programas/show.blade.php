@extends('layouts.dashboard')

@section('title', 'Detalles del Programa de Formación')

@section('actions')
<a href="{{ route('programas.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Volver
</a>
@if(Auth::user()->tieneRol('Administrador'))
<a href="{{ route('programas.edit', $programa->id_programa) }}" class="btn btn-warning">
    <i class="fas fa-edit"></i> Editar
</a>
@endif
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h3 class="mb-4">
                    <i class="fas fa-graduation-cap text-primary"></i>
                    Programa de Formación #{{ $programa->id_programa }}
                </h3>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card bg-light h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-school"></i> Información de la Escuela
                        </h5>
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <th>Escuela:</th>
                                    <td>{{ $programa->escuela->nombre ?? 'Sin escuela asignada' }}</td>
                                </tr>
                                <tr>
                                    <th>Tipo de Escuela:</th>
                                    <td>
                                        <span class="badge bg-primary">
                                            {{ $programa->tipoEscuela->tipos_escuela ?? 'Sin tipo asignado' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Descripción:</th>
                                    <td>{{ $programa->escuela->descripcion ?? 'Sin descripción' }}</td>
                                </tr>
                                <tr>
                                    <th>Ubicación:</th>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-danger"></i>
                                        {{ $programa->ubicacion->ubicacion ?? 'Sin ubicación asignada' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-light h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-book"></i> Información del Curso
                        </h5>
                        @if($programa->curso)
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <th>Curso:</th>
                                    <td>{{ $programa->curso->curso }}</td>
                                </tr>
                                <tr>
                                    <th>Objetivo:</th>
                                    <td>{{ $programa->curso->objetivo ?? 'Sin objetivo definido' }}</td>
                                </tr>
                                <tr>
                                    <th>Nivel:</th>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $programa->curso->nivel->nivel ?? 'Sin nivel' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Fechas:</th>
                                    <td>
                                        <small>
                                            <strong>Inicio:</strong> 
                                            {{ $programa->curso->fecha_inicio ? \Carbon\Carbon::parse($programa->curso->fecha_inicio)->format('d/m/Y') : 'No definida' }}
                                            <br>
                                            <strong>Fin:</strong> 
                                            {{ $programa->curso->fecha_fin ? \Carbon\Carbon::parse($programa->curso->fecha_fin)->format('d/m/Y') : 'No definida' }}
                                        </small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Capacidad:</th>
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <span>{{ $programa->curso->cantidad_alumnos ?? 0 }} / {{ $programa->curso->cupos ?? 'N/A' }}</span>
                                            <span>
                                                @if($programa->curso && $programa->curso->cupos)
                                                    @php
                                                        $porcentaje = ($programa->curso->cantidad_alumnos / $programa->curso->cupos) * 100;
                                                    @endphp
                                                    @if($porcentaje < 50)
                                                        <span class="badge bg-success">{{ round($porcentaje) }}%</span>
                                                    @elseif($porcentaje < 80)
                                                        <span class="badge bg-warning">{{ round($porcentaje) }}%</span>
                                                    @else
                                                        <span class="badge bg-danger">{{ round($porcentaje) }}%</span>
                                                    @endif
                                                @endif
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @else
                        <p class="text-muted">No hay curso asignado a este programa</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-user-tie"></i> Responsable del Programa
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($programa->responsable)
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <th>Nombre Completo:</th>
                                            <td>
                                                {{ $programa->responsable->primer_nombre ?? '' }} 
                                                {{ $programa->responsable->segundo_nombre ?? '' }}
                                                {{ $programa->responsable->primer_apellido ?? '' }} 
                                                {{ $programa->responsable->segundo_apellido ?? '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Documento:</th>
                                            <td>
                                                {{ $programa->responsable->documento->tipo_documento ?? 'N/A' }}: 
                                                {{ $programa->responsable->num_documento ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <th>Rol:</th>
                                            <td>
                                                <span class="badge bg-success">
                                                    {{ $programa->responsable->rol->rol ?? 'Sin rol' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Especialidad:</th>
                                            <td>{{ $programa->responsable->especialidad->especialidad ?? 'Sin especialidad' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Contacto:</th>
                                            <td>
                                                @if($programa->responsable->contacto)
                                                <small>
                                                    <i class="fas fa-envelope"></i> {{ $programa->responsable->contacto->email ?? 'Sin email' }}<br>
                                                    <i class="fas fa-phone"></i> {{ $programa->responsable->contacto->telefono ?? 'Sin teléfono' }}
                                                </small>
                                                @else
                                                Sin información de contacto
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            No hay responsable asignado a este programa de formación.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($programa->curso && $programa->curso->inscripciones && $programa->curso->inscripciones->count() > 0)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-users"></i> Estudiantes Inscritos
                        </h5>
                        <span class="badge bg-primary">{{ $programa->curso->inscripciones->count() }}</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Documento</th>
                                        <th>Fecha Inscripción</th>
                                        <th>Contacto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($programa->curso->inscripciones as $inscripcion)
                                    <tr>
                                        <td>
                                            {{ $inscripcion->usuario->primer_nombre ?? '' }} 
                                            {{ $inscripcion->usuario->primer_apellido ?? '' }}
                                        </td>
                                        <td>{{ $inscripcion->usuario->num_documento ?? 'N/A' }}</td>
                                        <td>
                                            {{ $inscripcion->fecha_inscripcion ? \Carbon\Carbon::parse($inscripcion->fecha_inscripcion)->format('d/m/Y') : 'N/A' }}
                                        </td>
                                        <td>
                                            @if($inscripcion->usuario->contacto)
                                            <small>{{ $inscripcion->usuario->contacto->telefono ?? 'Sin teléfono' }}</small>
                                            @else
                                            Sin contacto
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Acciones disponibles -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex flex-wrap justify-content-end gap-2">
                    @if(Auth::user()->tieneRol('Administrador'))
                    <form action="{{ route('programas.destroy', $programa->id_programa) }}" method="POST" onsubmit="return confirm('¿Está seguro de que desea eliminar este programa de formación?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Eliminar Programa
                        </button>
                    </form>
                    @endif
                    
                    @if($programa->curso)
                    <a href="{{ route('cursos.show', $programa->curso->id_curso) }}" class="btn btn-info">
                        <i class="fas fa-book"></i> Ver Curso Completo
                    </a>
                    @endif
                    
                    @if($programa->escuela)
                    <a href="{{ route('escuelas.show', $programa->escuela->id_escuela) }}" class="btn btn-secondary">
                        <i class="fas fa-school"></i> Ver Escuela
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection