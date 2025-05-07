@extends('layouts.dashboard')

@section('title', 'Gestión de Inscripciones')

@section('actions')
<a href="{{ route('inscripciones.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Nueva Inscripción
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Estudiante</th>
                        <th>Curso</th>
                        <th>Fecha de Inscripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inscripciones as $inscripcion)
                    <tr>
                        <td>{{ $inscripcion->id_inscripcion }}</td>
                        <td>{{ $inscripcion->usuario->primer_nombre }} {{ $inscripcion->usuario->primer_apellido }}</td>
                        <td>{{ $inscripcion->curso->curso }}</td>
                        <td>{{ $inscripcion->fecha_inscripcion->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                @if(Auth::user()->tieneRol('Estudiante') && $inscripcion->id_usuario == Auth::user()->id_usuario)
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $inscripcion->id_inscripcion }}">
                                    <i class="fas fa-trash"></i> Cancelar
                                </button>
                                
                                <!-- Modal de cancelación -->
                                <div class="modal fade" id="deleteModal{{ $inscripcion->id_inscripcion }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $inscripcion->id_inscripcion }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $inscripcion->id_inscripcion }}">Confirmar Cancelación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Está seguro de que desea cancelar su inscripción al curso {{ $inscripcion->curso->curso }}?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('inscripciones.destroy', $inscripcion->id_inscripcion) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Confirmar Cancelación</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                @if(Auth::user()->tieneRol('Administrador') || (Auth::user()->tieneRol('Instructor') && $inscripcion->curso->id_usuario == Auth::user()->id_usuario))
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $inscripcion->id_inscripcion }}">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                                
                                <!-- Modal de eliminación -->
                                <div class="modal fade" id="deleteModal{{ $inscripcion->id_inscripcion }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $inscripcion->id_inscripcion }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $inscripcion->id_inscripcion }}">Confirmar Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Está seguro de que desea eliminar la inscripción de {{ $inscripcion->usuario->primer_nombre }} {{ $inscripcion->usuario->primer_apellido }} al curso {{ $inscripcion->curso->curso }}?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('inscripciones.destroy', $inscripcion->id_inscripcion) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection