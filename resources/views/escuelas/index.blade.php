@extends('layouts.dashboard')

@section('title', 'Gestión de Escuelas')

@section('actions')
@if(Auth::user()->tieneRol('Administrador'))
<a href="{{ route('escuelas.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Nueva Escuela
</a>
@endif
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($escuelas as $escuela)
                    <tr>
                        <td>{{ $escuela->id_escuela }}</td>
                        <td>{{ $escuela->nombre }}</td>
                        <td>{{ Str::limit($escuela->descripcion, 50) }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('escuelas.show', $escuela->id_escuela) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if(Auth::user()->tieneRol('Administrador'))
                                <a href="{{ route('escuelas.edit', $escuela->id_escuela) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $escuela->id_escuela }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                
                                <!-- Modal de eliminación -->
                                <div class="modal fade" id="deleteModal{{ $escuela->id_escuela }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $escuela->id_escuela }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $escuela->id_escuela }}">Confirmar Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Está seguro de que desea eliminar la escuela {{ $escuela->nombre }}?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('escuelas.destroy', $escuela->id_escuela) }}" method="POST">
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