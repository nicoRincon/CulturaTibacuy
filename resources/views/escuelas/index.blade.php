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
                        <td>{{ $escuela->Id_Escuela }}</td>
                        <td>{{ $escuela->Nombre }}</td>
                        <td>{{ Str::limit($escuela->Descripcion, 50) }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('escuelas.show', $escuela->Id_Escuela) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if(Auth::user()->tieneRol('Administrador'))
                                <a href="{{ route('escuelas.edit', $escuela->Id_Escuela) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $escuela->Id_Escuela }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                
                                <!-- Modal de eliminación -->
                                <div class="modal fade" id="deleteModal{{ $escuela->Id_Escuela }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $escuela->Id_Escuela }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $escuela->Id_Escuela }}">Confirmar Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Está seguro de que desea eliminar la escuela {{ $escuela->Nombre }}?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('escuelas.destroy', $escuela->Id_Escuela) }}" method="POST">
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