@extends('layouts.dashboard')

@section('title', 'Gestión de Usuarios')

@section('actions')
<a href="{{ route('usuarios.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Nuevo Usuario
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
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Rol</th>
                        <th>Correo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->Id_Usuario }}</td>
                        <td>{{ $usuario->Primer_Nombre }} {{ $usuario->Primer_Apellido }}</td>
                        <td>{{ $usuario->documento->Tipo_Documento }}: {{ $usuario->Num_Documento }}</td>
                        <td>{{ $usuario->rol->Rol }}</td>
                        <td>{{ $usuario->contacto->Correo }}</td>
                        <td>
                            @if($usuario->Id_Estado == 1)
                            <span class="badge bg-success">Activo</span>
                            @else
                            <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('usuarios.show', $usuario->Id_Usuario) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('usuarios.edit', $usuario->Id_Usuario) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $usuario->Id_Usuario }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            
                            <!-- Modal de eliminación -->
                            <div class="modal fade" id="deleteModal{{ $usuario->Id_Usuario }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $usuario->Id_Usuario }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $usuario->Id_Usuario }}">Confirmar Eliminación</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Está seguro de que desea eliminar al usuario {{ $usuario->Primer_Nombre }} {{ $usuario->Primer_Apellido }}?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('usuarios.destroy', $usuario->Id_Usuario) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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