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
                        <td>{{ $inscripcion->Id_Inscripcion }}</td>
                        <td>{{ $inscripcion->usuario->Primer_Nombre }} {{ $inscripcion->usuario->Primer_Apellido }}</td>
                        <td>{{ $inscripcion->curso->Curso }}</td>
                        <td>{{ $inscripcion->Fecha_Inscripcion->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                @if(Auth::user()->tieneRol('Estudiante') && $inscripcion->Id_Usuario == Auth::user()->Id_Usuario)
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $inscripcion->Id_Inscripcion }}">
                                    <i class="fas fa-trash"></i> Cancelar
                                </button>
                                
                                <!-- Modal de cancelación -->
                                <div class="modal fade" id="deleteModal{{ $inscripcion->Id_Inscripcion }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $inscripcion->Id_Inscripcion }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $inscripcion->Id_Inscripcion }}">Confirmar Cancelación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Está seguro de que desea cancelar su inscripción al curso {{ $inscripcion->curso->Curso }}?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('inscripciones.destroy', $inscripcion->Id_Inscripcion) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Confirmar Cancelación</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                @if(Auth::user()->tieneRol('Administrador') || (Auth::user()->tieneRol('Instructor') && $inscripcion->curso->Id_Usuario == Auth::user()->Id_Usuario))
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $inscripcion->Id_Inscripcion }}">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                                
                                <!-- Modal de eliminación -->
                                <div class="modal fade" id="deleteModal{{ $inscripcion->Id_Inscripcion }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $inscripcion->Id_Inscripcion }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $inscripcion->Id_Inscripcion }}">Confirmar Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Está seguro de que desea eliminar la inscripción de {{ $inscripcion->usuario->Primer_Nombre }} {{ $inscripcion->usuario->Primer_Apellido }} al curso {{ $inscripcion->curso->Curso }}?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('inscripciones.destroy', $inscripcion->Id_Inscripcion) }}" method="POST">
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