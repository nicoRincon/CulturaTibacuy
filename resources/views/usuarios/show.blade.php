@extends('layouts.dashboard')

@section('title', Auth::user()->id_usuario == $usuario->id_usuario ? 'Mi Perfil' : 'Detalles del Usuario')

@section('actions')
<a href="{{ Auth::user()->tieneRol('Administrador') && Auth::user()->id_usuario != $usuario->id_usuario ? route('usuarios.index') : route('dashboard') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Volver
</a>
@if(Auth::user()->tieneRol('Administrador') || Auth::user()->id_usuario == $usuario->id_usuario)
<a href="{{ route('usuarios.edit', $usuario->id_usuario) }}" class="btn btn-warning">
    <i class="fas fa-edit"></i> {{ Auth::user()->id_usuario == $usuario->id_usuario ? 'Editar Mi Perfil' : 'Editar' }}
</a>
@endif
@endsection

@section('content')
<!-- Header del perfil -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-white py-4">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        <div class="user-avatar mx-auto d-flex align-items-center justify-content-center rounded-circle text-white fw-bold" 
                             style="width: 100px; height: 100px; font-size: 32px; background: rgba(255,255,255,0.2); border: 3px solid rgba(255,255,255,0.3);">
                            {{ substr($usuario->primer_nombre, 0, 1) }}{{ substr($usuario->primer_apellido, 0, 1) }}
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h2 class="mb-1">{{ $usuario->primer_nombre }} {{ $usuario->segundo_nombre }} {{ $usuario->primer_apellido }} {{ $usuario->segundo_apellido }}</h2>
                        <p class="mb-1 opacity-75">
                            <i class="fas fa-user-tag me-2"></i>{{ $usuario->rol->rol }}
                            @if($usuario->especialidad)
                            <span class="ms-3"><i class="fas fa-star me-2"></i>{{ $usuario->especialidad->especialidad }}</span>
                            @endif
                        </p>
                        <p class="mb-0 opacity-75">
                            <i class="fas fa-envelope me-2"></i>{{ $usuario->contacto->email }}
                            <span class="ms-3"><i class="fas fa-phone me-2"></i>{{ $usuario->contacto->telefono }}</span>
                        </p>
                    </div>
                    <div class="col-md-3 text-end">
                        <div class="mb-2">
                            @if($usuario->id_estado == 1)
                            <span class="badge bg-success bg-opacity-75 px-3 py-2">
                                <i class="fas fa-check-circle me-1"></i>Activo
                            </span>
                            @else
                            <span class="badge bg-danger bg-opacity-75 px-3 py-2">
                                <i class="fas fa-times-circle me-1"></i>Inactivo
                            </span>
                            @endif
                        </div>
                        <p class="mb-0 small opacity-75">
                            Miembro desde<br>
                            <strong>{{ $usuario->created_at instanceof \Carbon\Carbon ? $usuario->created_at->format('M Y') : date('M Y', strtotime($usuario->created_at)) }}</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Información Personal -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Información Personal</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <th width="40%">Nombre Completo:</th>
                            <td>{{ $usuario->primer_nombre }} {{ $usuario->segundo_nombre }} {{ $usuario->primer_apellido }} {{ $usuario->segundo_apellido }}</td>
                        </tr>
                        <tr>
                            <th>Documento:</th>
                            <td>
                                <span class="badge bg-light text-dark">{{ $usuario->documento->tipo_documento }}</span>
                                {{ $usuario->num_documento }}
                            </td>
                        </tr>
                        <tr>
                            <th>Fecha de Nacimiento:</th>
                            <td>
                                {{ $usuario->fecha_nacimiento instanceof \Carbon\Carbon ? $usuario->fecha_nacimiento->format('d/m/Y') : $usuario->fecha_nacimiento }}
                                <small class="text-muted">
                                    ({{ $usuario->fecha_nacimiento instanceof \Carbon\Carbon ? \Carbon\Carbon::parse($usuario->fecha_nacimiento)->age : \Carbon\Carbon::parse($usuario->fecha_nacimiento)->age }} años)
                                </small>
                            </td>
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
        </div>
    </div>

    <!-- Información de Contacto y Sistema -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-address-card me-2"></i>Contacto y Sistema</h5>
            </div>
            <div class="card-body">
                <h6 class="text-muted mb-3">Información de Contacto</h6>
                <table class="table table-borderless mb-4">
                    <tbody>
                        <tr>
                            <th width="40%">Teléfono:</th>
                            <td>
                                <a href="tel:{{ $usuario->contacto->telefono }}" class="text-decoration-none">
                                    <i class="fas fa-phone text-success me-1"></i>{{ $usuario->contacto->telefono }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>Correo Electrónico:</th>
                            <td>
                                <a href="mailto:{{ $usuario->contacto->email }}" class="text-decoration-none">
                                    <i class="fas fa-envelope text-primary me-1"></i>{{ $usuario->contacto->email }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>Dirección:</th>
                            <td>
                                <i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $usuario->contacto->direccion }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <h6 class="text-muted mb-3">Información del Sistema</h6>
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <th width="40%">Rol:</th>
                            <td>
                                <span class="badge bg-primary">{{ $usuario->rol->rol }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Especialidad:</th>
                            <td>
                                <span class="badge bg-warning text-dark">{{ $usuario->especialidad->especialidad }}</span>
                            </td>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Información específica por rol -->
@if($usuario->tieneRol('Instructor'))
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-chalkboard-teacher me-2"></i>Información de Instructor</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-primary">{{ $usuario->cursos->count() }}</h3>
                            <p class="text-muted">Cursos que Imparte</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-success">{{ $usuario->cursos->sum('cantidad_alumnos') }}</h3>
                            <p class="text-muted">Estudiantes Totales</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-warning">{{ $usuario->cursos->sum('cupos') - $usuario->cursos->sum('cantidad_alumnos') }}</h3>
                            <p class="text-muted">Cupos Disponibles</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            @php
                                $evaluacionesCreadas = App\Models\Evaluacion::whereHas('curso', function($query) use ($usuario) {
                                    $query->where('id_usuario', $usuario->id_usuario);
                                })->count();
                            @endphp
                            <h3 class="text-info">{{ $evaluacionesCreadas }}</h3>
                            <p class="text-muted">Evaluaciones Creadas</p>
                        </div>
                    </div>
                </div>

                @if($usuario->cursos->count() > 0)
                <h6 class="mb-3">Cursos que Imparte</h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Curso</th>
                                <th>Nivel</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Alumnos</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuario->cursos as $curso)
                            <tr>
                                <td>{{ $curso->curso }}</td>
                                <td><span class="badge bg-secondary">{{ $curso->nivel->nivel }}</span></td>
                                <td>{{ $curso->fecha_inicio instanceof \Carbon\Carbon ? $curso->fecha_inicio->format('d/m/Y') : $curso->fecha_inicio }}</td>
                                <td>{{ $curso->fecha_fin instanceof \Carbon\Carbon ? $curso->fecha_fin->format('d/m/Y') : $curso->fecha_fin }}</td>
                                <td>{{ $curso->cantidad_alumnos }} / {{ $curso->cupos }}</td>
                                <td>
                                    @php
                                        $hoy = now();
                                        $inicio = $curso->fecha_inicio instanceof \Carbon\Carbon ? $curso->fecha_inicio : \Carbon\Carbon::parse($curso->fecha_inicio);
                                        $fin = $curso->fecha_fin instanceof \Carbon\Carbon ? $curso->fecha_fin : \Carbon\Carbon::parse($curso->fecha_fin);
                                    @endphp
                                    @if($hoy->lt($inicio))
                                        <span class="badge bg-info">Próximo</span>
                                    @elseif($hoy->between($inicio, $fin))
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-secondary">Finalizado</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>Este instructor no tiene cursos asignados actualmente.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

@if($usuario->tieneRol('Estudiante'))
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-user-graduate me-2"></i>Información Académica</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-primary">{{ $usuario->inscripciones->count() }}</h3>
                            <p class="text-muted">Cursos Inscritos</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-success">{{ $usuario->evaluaciones->count() }}</h3>
                            <p class="text-muted">Evaluaciones</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            @php
                                $promedioGeneral = $usuario->evaluaciones->avg('nota');
                            @endphp
                            <h3 class="text-{{ $promedioGeneral >= 3.0 ? 'success' : 'danger' }}">
                                {{ $promedioGeneral ? number_format($promedioGeneral, 1) : 'N/A' }}
                            </h3>
                            <p class="text-muted">Promedio General</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-info">{{ $usuario->notasFinales->count() }}</h3>
                            <p class="text-muted">Cursos Completados</p>
                        </div>
                    </div>
                </div>

                @if($usuario->inscripciones->count() > 0)
                <h6 class="mb-3">Cursos Inscritos</h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Curso</th>
                                <th>Instructor</th>
                                <th>Fecha Inscripción</th>
                                <th>Evaluaciones</th>
                                <th>Promedio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuario->inscripciones as $inscripcion)
                            <tr>
                                <td>{{ $inscripcion->curso->curso }}</td>
                                <td>{{ $inscripcion->curso->instructor->primer_nombre }} {{ $inscripcion->curso->instructor->primer_apellido }}</td>
                                <td>{{ $inscripcion->fecha_inscripcion instanceof \Carbon\Carbon ? $inscripcion->fecha_inscripcion->format('d/m/Y') : $inscripcion->fecha_inscripcion }}</td>
                                <td>
                                    @php
                                        $evaluacionesCurso = $usuario->evaluaciones->where('id_curso', $inscripcion->curso->id_curso);
                                    @endphp
                                    <span class="badge bg-info">{{ $evaluacionesCurso->count() }}</span>
                                </td>
                                <td>
                                    @if($evaluacionesCurso->count() > 0)
                                        @php $promedio = $evaluacionesCurso->avg('nota'); @endphp
                                        <span class="badge bg-{{ $promedio >= 3.0 ? 'success' : 'danger' }}">
                                            {{ number_format($promedio, 1) }}
                                        </span>
                                    @else
                                        <span class="text-muted">Sin evaluar</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>Este estudiante no tiene inscripciones actualmente.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

@if($usuario->tieneRol('Administrador'))
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="fas fa-user-shield me-2"></i>Información de Administrador</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center">
                            @php $totalUsuarios = App\Models\User::count(); @endphp
                            <h3 class="text-primary">{{ $totalUsuarios }}</h3>
                            <p class="text-muted">Total Usuarios</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            @php $totalCursos = App\Models\Curso::count(); @endphp
                            <h3 class="text-success">{{ $totalCursos }}</h3>
                            <p class="text-muted">Total Cursos</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            @php $totalInscripciones = App\Models\Inscripcion::count(); @endphp
                            <h3 class="text-warning">{{ $totalInscripciones }}</h3>
                            <p class="text-muted">Total Inscripciones</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            @php $totalEscuelas = App\Models\Escuela::count(); @endphp
                            <h3 class="text-info">{{ $totalEscuelas }}</h3>
                            <p class="text-muted">Total Escuelas</p>
                        </div>
                    </div>
                </div>
                <div class="alert alert-info mt-3">
                    <i class="fas fa-shield-alt me-2"></i>
                    <strong>Permisos de Administrador:</strong> Acceso completo a todas las funcionalidades del sistema.
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Acciones disponibles -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Acciones Disponibles</h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    @if(Auth::user()->tieneRol('Administrador') || Auth::user()->id_usuario == $usuario->id_usuario)
                    <a href="{{ route('usuarios.edit', $usuario->id_usuario) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> {{ Auth::user()->id_usuario == $usuario->id_usuario ? 'Editar Mi Perfil' : 'Editar Usuario' }}
                    </a>
                    @endif
                    
                    @if($usuario->tieneRol('Estudiante') && Auth::user()->tieneRol('Administrador'))
                    <a href="{{ route('inscripciones.create') }}?id_usuario={{ $usuario->id_usuario }}" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> Nueva Inscripción
                    </a>
                    @endif
                    
                    @if($usuario->tieneRol('Estudiante') && (Auth::user()->tieneRol('Instructor') || Auth::user()->tieneRol('Administrador')))
                    <a href="{{ route('evaluaciones.create') }}?id_usuario={{ $usuario->id_usuario }}" class="btn btn-primary">
                        <i class="fas fa-star"></i> Nueva Evaluación
                    </a>
                    @endif
                    
                    @if($usuario->tieneRol('Instructor') && Auth::user()->tieneRol('Administrador'))
                    <a href="{{ route('cursos.create') }}?id_instructor={{ $usuario->id_usuario }}" class="btn btn-info">
                        <i class="fas fa-book"></i> Asignar Curso
                    </a>
                    @endif

                    @if(Auth::user()->id_usuario == $usuario->id_usuario && $usuario->tieneRol('Estudiante'))
                    <a href="{{ route('informes.estudiante') }}" class="btn btn-secondary">
                        <i class="fas fa-file-pdf"></i> Mi Informe Académico
                    </a>
                    @endif

                    @if(Auth::user()->tieneRol('Administrador') && $usuario->id_estado == 1)
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deactivateModal">
                        <i class="fas fa-user-times"></i> Desactivar Usuario
                    </button>
                    @elseif(Auth::user()->tieneRol('Administrador') && $usuario->id_estado == 2)
                    <form action="{{ route('usuarios.update', $usuario->id_usuario) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id_estado" value="1">
                        <button type="submit" class="btn btn-outline-success">
                            <i class="fas fa-user-check"></i> Activar Usuario
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de desactivación -->
@if(Auth::user()->tieneRol('Administrador') && $usuario->id_estado == 1)
<div class="modal fade" id="deactivateModal" tabindex="-1" aria-labelledby="deactivateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deactivateModalLabel">Confirmar Desactivación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Está seguro de que desea desactivar al usuario {{ $usuario->primer_nombre }} {{ $usuario->primer_apellido }}?
                <br><br>
                <strong>Esta acción:</strong>
                <ul>
                    <li>Impedirá que el usuario acceda al sistema</li>
                    <li>No eliminará sus datos ni registros</li>
                    <li>Puede ser revertida en cualquier momento</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('usuarios.update', $usuario->id_usuario) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_estado" value="2">
                    <button type="submit" class="btn btn-danger">Desactivar Usuario</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('styles')
<style>
    .bg-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }
    
    .card {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: none;
        border-radius: 10px;
    }
    
    .user-avatar {
        background: rgba(255,255,255,0.2) !important;
        border: 3px solid rgba(255,255,255,0.3) !important;
    }
    
    .table th {
        font-weight: 600;
        color: #495057;
    }
    
    .badge {
        font-size: 0.875em;
    }
    
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    
    .btn {
        border-radius: 8px;
    }
    
    .alert {
        border-radius: 8px;
    }
</style>
@endsection