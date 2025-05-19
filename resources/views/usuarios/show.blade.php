@extends('layouts.dashboard')

@section('title', 'Detalles del Usuario')

@section('actions')
<a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Volver
</a>
<a href="{{ route('usuarios.edit', $usuario->id_usuario) }}" class="btn btn-warning">
    <i class="fas fa-edit"></i> Editar
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h4>Información Personal</h4>
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Nombre Completo:</th>
                            <td>{{ $usuario->primer_nombre }} {{ $usuario->segundo_nombre }} {{ $usuario->primer_apellido }} {{ $usuario->segundo_apellido }}</td>
                        </tr>
                        <tr>
                            <th>Documento:</th>
                            <td>{{ $usuario->documento->tipo_documento }}: {{ $usuario->num_documento }}</td>
                        </tr>
                        <tr>
                            <th>Fecha de Nacimiento:</th>
                            <td>{{ $usuario->fecha_nacimiento instanceof \Carbon\Carbon ? $usuario->fecha_nacimiento->format('d/m/Y') : $usuario->fecha_nacimiento }}</td>
                        </tr>
                        <tr>
                            <th>Lugar de Nacimiento:</th>
                            <td>
                                {{ $usuario->lugarNacimiento->municipio->municipio }}, 
                                {{ $usuario->lugarNacimiento->departamento->departamento }}, 
                                {{ $usuario->lugarNacimiento->pais->pais }}
                            </td>
                        </tr>
                        <tr>
                            <th>Género:</th>
                            <td>{{ $usuario->genero->genero }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-6">
                <h4>Información de Contacto</h4>
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Teléfono:</th>
                            <td>{{ $usuario->contacto->telefono }}</td>
                        </tr>
                        <tr>
                            <th>Correo Electrónico:</th>
                            <td>{{ $usuario->contacto->email }}</td>
                        </tr>
                        <tr>
                            <th>Dirección:</th>
                            <td>{{ $usuario->contacto->direccion }}</td>
                        </tr>
                    </tbody>
                </table>

                <h4 class="mt-4">Información del Sistema</h4>
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Rol:</th>
                            <td>{{ $usuario->rol->rol }}</td>
                        </tr>
                        <tr>
                            <th>Especialidad:</th>
                            <td>{{ $usuario->especialidad->especialidad }}</td>
                        </tr>
                        <tr>
                            <th>Estado:</th>
                            <td>
                                @if($usuario->id_estado == 1)
                                <span class="badge bg-success">Activo</span>
                                @else
                                <span class="badge bg-danger">Inactivo</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Fecha de Registro:</th>
                            <td>{{ $usuario->created_at instanceof \Carbon\Carbon ? $usuario->created_at->format('d/m/Y H:i') : $usuario->created_at }}</td>
                        </tr>
                        <tr>
                            <th>Última Actualización:</th>
                            <td>{{ $usuario->updated_at instanceof \Carbon\Carbon ? $usuario->updated_at->format('d/m/Y H:i') : $usuario->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        @if($usuario->tieneRol('Instructor'))
        <div class="row mt-4">
            <div class="col-12">
                <h4>Cursos que Imparte</h4>
                @if($usuario->cursos->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Alumnos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuario->cursos as $curso)
                        <tr>
                            <td>{{ $curso->curso }}</td>
                            <td>{{ $curso->fecha_inicio instanceof \Carbon\Carbon ? $curso->fecha_inicio->format('d/m/Y') : $curso->fecha_inicio }}</td>
                            <td>{{ $curso->fecha_fin instanceof \Carbon\Carbon ? $curso->fecha_fin->format('d/m/Y') : $curso->fecha_fin }}</td>
                            <td>{{ $curso->cantidad_alumnos }} / {{ $curso->cupos }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p>No imparte ningún curso actualmente.</p>
                @endif
            </div>
        </div>
        @endif

        @if($usuario->tieneRol('Estudiante'))
        <div class="row mt-4">
            <div class="col-12">
                <h4>Cursos Inscritos</h4>
                @if($usuario->inscripciones->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Fecha Inscripción</th>
                            <th>Instructor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuario->inscripciones as $inscripcion)
                        <tr>
                            <td>{{ $inscripcion->curso->curso }}</td>
                            <td>{{ $inscripcion->fecha_inscripcion instanceof \Carbon\Carbon ? $inscripcion->fecha_inscripcion->format('d/m/Y') : $inscripcion->fecha_inscripcion }}</td>
                            <td>{{ $inscripcion->curso->instructor->primer_nombre }} {{ $inscripcion->curso->instructor->primer_apellido }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p>No está inscrito en ningún curso actualmente.</p>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection