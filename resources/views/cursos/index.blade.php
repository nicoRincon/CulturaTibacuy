@extends('layouts.dashboard')

@section('title', 'Gestión de Cursos')

@section('actions')
@if(Auth::user()->tieneRol('Administrador') || Auth::user()->tieneRol('Instructor'))
<a href="{{ route('cursos.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Nuevo Curso
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
                        <th>Curso</th>
                        <th>Instructor</th>
                        <th>Nivel</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Cupos</th>
                        <th>Disponibles</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cursos as $curso)
                    <tr>
                        <td>{{ $curso->id_curso }}</td>
                        <td>{{ $curso->curso }}</td>
                        <td>{{ $curso->instructor->primer_nombre }} {{ $curso->instructor->primer_apellido }}</td>
                        <td>{{ $curso->nivel->nivel }}</td>
                        <td>{{ $curso->fecha_inicio->format('d/m/Y') }}</td>
                        <td>{{ $curso->fecha_fin->format('d/m/Y') }}</td>
                        <td>{{ $curso->cupos }}</td>
                        <td>{{ $curso->cupos - $curso->cantidad_alumnos }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('cursos.show', $curso->id_curso) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if(Auth::user()->tieneRol('Administrador') || (Auth::user()->tieneRol('Instructor') && $curso->id_usuario == Auth::user()->id_usuario))
                                <a href="{{ route('cursos.edit', $curso->id_curso) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $curso->id_curso }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                
                                <!-- Modal de eliminación -->
                                <div class="modal fade" id="deleteModal{{ $curso->id_curso }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $curso->id_curso }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $curso->id_curso }}">Confirmar Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Está seguro de que desea eliminar el curso {{ $curso->curso }}?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('cursos.destroy', $curso->id_curso) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                @if(Auth::user()->tieneRol('Estudiante'))
                                <form action="{{ route('inscripciones.store') }}" method="POST" class="ms-1">
                                    @csrf
                                    <input type="hidden" name="id_curso" value="{{ $curso->id_curso }}">
                                    <button type="submit" class="btn btn-sm btn-success" {{ $curso->Cupos - $curso->cantidad_alumnos <= 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-user-plus"></i>
                                    </button>
                                </form>
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