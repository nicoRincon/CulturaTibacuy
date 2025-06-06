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
        @if($programas->count() > 0)
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
                        <td>{{ $programa->id_programa }}</td>
                        <td>{{ $programa->escuela->nombre ?? 'Sin escuela' }}</td>
                        <td>{{ $programa->tipoEscuela->tipos_escuela ?? 'Sin tipo asignado' }}</td>
                        <td>{{ $programa->curso->curso ?? 'Sin curso' }}</td>
                        <td>{{ $programa->ubicacion->ubicacion ?? 'Sin ubicación' }}</td>
                        <td>
                            @if($programa->responsable)
                                {{ $programa->responsable->primer_nombre ?? '' }} {{ $programa->responsable->primer_apellido ?? '' }}
                            @else
                                Sin responsable
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('programas.show', $programa->id_programa) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if(Auth::user()->tieneRol('Administrador'))
                                <a href="{{ route('programas.edit', $programa->id_programa) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $programa->id_programa }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                
                                <!-- Modal de eliminación -->
                                <div class="modal fade" id="deleteModal{{ $programa->id_programa }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $programa->id_programa }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $programa->id_programa }}">Confirmar Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Está seguro de que desea eliminar el programa de formación?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('programas.destroy', $programa->id_programa) }}" method="POST">
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
        @else
        <div class="text-center py-5">
            <i class="fas fa-graduation-cap fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">No hay programas de formación registrados</h4>
            <p class="text-muted">Comienza creando tu primer programa de formación</p>
            @if(Auth::user()->tieneRol('Administrador'))
            <a href="{{ route('programas.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Crear Primer Programa
            </a>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection