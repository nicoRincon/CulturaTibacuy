@extends('layouts.dashboard')

@section('title', 'Gestión de Programas de Formación')

@section('actions')
@if(Auth::user()->tieneRol('Administrador'))
<a href="{{ route('programas.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Nuevo Programa
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
                        <th>Escuela</th>
                        <th>Tipo</th>
                        <th>Curso</th>
                        <th>Ubicación</th>
                        <th>Responsable</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($programas as $programa)
                    <tr>
                        <td>{{ $programa->Id_Programa }}</td>
                        <td>{{ $programa->escuela->Nombre }}</td>
                        <td>{{ $programa->tipoEscuela->Tipos_Escuela }}</td>
                        <td>{{ $programa->curso->Curso }}</td>
                        <td>{{ $programa->ubicacion->Ubicación }}</td>
                        <td>{{ $programa->responsable->Primer_Nombre }} {{ $programa->responsable->Primer_Apellido }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('programas.show', $programa->Id_Programa) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if(Auth::user()->tieneRol('Administrador'))
                                <a href="{{ route('programas.edit', $programa->Id_Programa) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $programa->Id_Programa }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                
                                <!-- Modal de eliminación -->
                                <div class="modal fade" id="deleteModal{{ $programa->Id_Programa }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $programa->Id_Programa }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $programa->Id_Programa }}">Confirmar Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Está seguro de que desea eliminar el programa de formación?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('programas.destroy', $programa->Id_Programa) }}" method="POST">
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

