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
                        <td>{{ $curso->Id_Curso }}</td>
                        <td>{{ $curso->Curso }}</td>
                        <td>{{ $curso->instructor->Primer_Nombre }} {{ $curso->instructor->Primer_Apellido }}</td>
                        <td>{{ $curso->nivel->Nivel }}</td>
                        <td>{{ $curso->Fecha_Inicio->format('d/m/Y') }}</td>
                        <td>{{ $curso->Fecha_Fin->format('d/m/Y') }}</td>
                        <td>{{ $curso->Cupos }}</td>
                        <td>{{ $curso->Cupos - $curso->Cantidad_Alumnos }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('cursos.show', $curso->Id_Curso) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if(Auth::user()->tieneRol('Administrador') || (Auth::user()->tieneRol('Instructor') && $curso->Id_Usuario == Auth::user()->Id_Usuario))
                                <a href="{{ route('cursos.edit', $curso->Id_Curso) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $curso->Id_Curso }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                
                                <!-- Modal de eliminación -->
                                <div class="modal fade" id="deleteModal{{ $curso->Id_Curso }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $curso->Id_Curso }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $curso->Id_Curso }}">Confirmar Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Está seguro de que desea eliminar el curso {{ $curso->Curso }}?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('cursos.destroy', $curso->Id_Curso) }}" method="POST">
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
                                    <input type="hidden" name="id_curso" value="{{ $curso->Id_Curso }}">
                                    <button type="submit" class="btn btn-sm btn-success" {{ $curso->Cupos - $curso->Cantidad_Alumnos <= 0 ? 'disabled' : '' }}>
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