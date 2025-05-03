@extends('layouts.dashboard')

@section('title', 'Gestión de Evaluaciones')

@section('actions')
@if(Auth::user()->tieneRol('Administrador') || Auth::user()->tieneRol('Instructor'))
<a href="{{ route('evaluaciones.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Nueva Evaluación
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
                        <th>Estudiante</th>
                        <th>Curso</th>
                        <th>Fecha Evaluación</th>
                        <th>Nota</th>
                        <th>Comentarios</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($evaluaciones as $evaluacion)
                    <tr>
                        <td>{{ $evaluacion->Id_Evaluacion }}</td>
                        <td>{{ $evaluacion->usuario->Primer_Nombre }} {{ $evaluacion->usuario->Primer_Apellido }}</td>
                        <td>{{ $evaluacion->curso->Curso }}</td>
                        <td>{{ $evaluacion->Fecha_Evaluacion->format('d/m/Y') }}</td>
                        <td>{{ number_format($evaluacion->Nota, 2) }}</td>
                        <td>{{ Str::limit($evaluacion->Comentarios, 30) }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('evaluaciones.show', $evaluacion->Id_Evaluacion) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if(Auth::user()->tieneRol('Administrador') || (Auth::user()->tieneRol('Instructor') && $evaluacion->curso->Id_Usuario == Auth::user()->Id_Usuario))
                                <a href="{{ route('evaluaciones.edit', $evaluacion->Id_Evaluacion) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $evaluacion->Id_Evaluacion }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                
                                <!-- Modal de eliminación -->
                                <div class="modal fade" id="deleteModal{{ $evaluacion->Id_Evaluacion }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $evaluacion->Id_Evaluacion }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $evaluacion->Id_Evaluacion }}">Confirmar Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Está seguro de que desea eliminar la evaluación de {{ $evaluacion->usuario->Primer_Nombre }} {{ $evaluacion->usuario->Primer_Apellido }} para el curso {{ $evaluacion->curso->Curso }}?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('evaluaciones.destroy', $evaluacion->Id_Evaluacion) }}" method="POST">
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