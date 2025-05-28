@extends('layouts.dashboard')

@section('title', 'Informe de Usuarios')

@section('actions')
<a href="{{ route('informes.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Volver
</a>
<div class="btn-group" role="group">
    <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown">
        <i class="fas fa-download"></i> Exportar
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#" onclick="exportarInforme('pdf')">
            <i class="fas fa-file-pdf text-danger"></i> Descargar PDF
        </a></li>
        <li><a class="dropdown-item" href="#" onclick="exportarInforme('excel')">
            <i class="fas fa-file-excel text-success"></i> Descargar Excel
        </a></li>
    </ul>
</div>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-filter me-2"></i>Filtros Aplicados
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Tipo de Usuario:</strong> 
                        @switch(request('tipo_usuario'))
                            @case('estudiantes')
                                <span class="badge bg-primary">Estudiantes</span>
                                @break
                            @case('instructores')
                                <span class="badge bg-success">Instructores</span>
                                @break
                            @case('administradores')
                                <span class="badge bg-danger">Administradores</span>
                                @break
                            @default
                                <span class="badge bg-secondary">Todos los tipos</span>
                        @endswitch
                    </div>
                    <div class="col-md-6">
                        <strong>Estado:</strong> 
                        @switch(request('estado'))
                            @case('activos')
                                <span class="badge bg-success">Usuarios Activos</span>
                                @break
                            @case('inactivos')
                                <span class="badge bg-warning">Usuarios Inactivos</span>
                                @break
                            @default
                                <span class="badge bg-info">Todos los estados</span>
                        @endswitch
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-users me-2"></i>Usuarios Registrados
        </h5>
        <span class="badge bg-primary fs-6">{{ $usuarios->count() }} registros</span>
    </div>
    <div class="card-body">
        @if($usuarios->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="usuariosTable">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Documento</th>
                        <th>Rol</th>
                        <th>Especialidad</th>
                        <th>Contacto</th>
                        <th>Estado</th>
                        <th>Registro</th>
                        <th>Actividad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id_usuario }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-size: 12px;">
                                    {{ substr($usuario->primer_nombre, 0, 1) }}{{ substr($usuario->primer_apellido, 0, 1) }}
                                </div>
                                <div>
                                    <strong>{{ $usuario->primer_nombre }} {{ $usuario->primer_apellido }}</strong>
                                    @if($usuario->segundo_nombre || $usuario->segundo_apellido)
                                    <br><small class="text-muted">{{ $usuario->segundo_nombre }} {{ $usuario->segundo_apellido }}</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ $usuario->documento->tipo_documento ?? 'N/A' }}
                            </span>
                            <br>{{ $usuario->num_documento }}
                        </td>
                        <td>
                            <span class="badge 
                                @switch($usuario->rol->rol ?? '')
                                    @case('Administrador') bg-danger @break
                                    @case('Instructor') bg-success @break
                                    @case('Estudiante') bg-primary @break
                                    @default bg-secondary
                                @endswitch">
                                {{ $usuario->rol->rol ?? 'Sin rol' }}
                            </span>
                        </td>
                        <td>
                            <small class="text-muted">{{ $usuario->especialidad->especialidad ?? 'N/A' }}</small>
                        </td>
                        <td>
                            <small>
                                <i class="fas fa-envelope text-primary"></i> {{ $usuario->contacto->email ?? 'N/A' }}<br>
                                <i class="fas fa-phone text-success"></i> {{ $usuario->contacto->telefono ?? 'N/A' }}
                            </small>
                        </td>
                        <td>
                            @if($usuario->id_estado == 1)
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle"></i> Activo
                                </span>
                            @else
                                <span class="badge bg-warning">
                                    <i class="fas fa-pause-circle"></i> Inactivo
                                </span>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ $usuario->created_at instanceof \Carbon\Carbon ? $usuario->created_at->format('d/m/Y') : $usuario->created_at }}
                            </small>
                        </td>
                        <td>
                            @if($usuario->rol->rol == 'Estudiante')
                                @php
                                    $inscripciones = $usuario->inscripciones->count();
                                    $evaluaciones = $usuario->evaluaciones->count();
                                @endphp
                                <small>
                                    <i class="fas fa-graduation-cap text-info"></i> {{ $inscripciones }} cursos<br>
                                    <i class="fas fa-star text-warning"></i> {{ $evaluaciones }} evaluaciones
                                </small>
                            @elseif($usuario->rol->rol == 'Instructor')
                                @php
                                    $cursosImpartidos = $usuario->cursos->count();
                                    $estudiantesTotales = $usuario->cursos->sum('cantidad_alumnos');
                                @endphp
                                <small>
                                    <i class="fas fa-chalkboard-teacher text-success"></i> {{ $cursosImpartidos }} cursos<br>
                                    <i class="fas fa-users text-primary"></i> {{ $estudiantesTotales }} estudiantes
                                </small>
                            @else
                                <small class="text-muted">
                                    <i class="fas fa-user-shield text-danger"></i> Administrador
                                </small>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Estadísticas resumidas -->
        <div class="row mt-4">
            <div class="col-md-2">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h5 class="text-primary">{{ $usuarios->count() }}</h5>
                        <small class="text-muted">Total Usuarios</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h5 class="text-success">{{ $usuarios->where('id_estado', 1)->count() }}</h5>
                        <small class="text-muted">Activos</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h5 class="text-warning">{{ $usuarios->where('id_estado', '!=', 1)->count() }}</h5>
                        <small class="text-muted">Inactivos</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        @php
                            $estudiantesCount = $usuarios->filter(function($usuario) {
                                return $usuario->rol->rol == 'Estudiante';
                            })->count();
                        @endphp
                        <h5 class="text-info">{{ $estudiantesCount }}</h5>
                        <small class="text-muted">Estudiantes</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        @php
                            $instructoresCount = $usuarios->filter(function($usuario) {
                                return $usuario->rol->rol == 'Instructor';
                            })->count();
                        @endphp
                        <h5 class="text-success">{{ $instructoresCount }}</h5>
                        <small class="text-muted">Instructores</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        @php
                            $administradoresCount = $usuarios->filter(function($usuario) {
                                return $usuario->rol->rol == 'Administrador';
                            })->count();
                        @endphp
                        <h5 class="text-danger">{{ $administradoresCount }}</h5>
                        <small class="text-muted">Administradores</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico de distribución por roles -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Distribución por Roles</h6>
                    </div>
                    <div class="card-body">
                        @php
                            $total = $usuarios->count();
                            $rolesDistribucion = $usuarios->groupBy(function($usuario) {
                                return $usuario->rol->rol ?? 'Sin rol';
                            });
                        @endphp
                        
                        @foreach($rolesDistribucion as $rol => $usuariosRol)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">{{ $rol }}</span>
                                <span>{{ $usuariosRol->count() }} ({{ round(($usuariosRol->count() / $total) * 100) }}%)</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar 
                                    @switch($rol)
                                        @case('Administrador') bg-danger @break
                                        @case('Instructor') bg-success @break
                                        @case('Estudiante') bg-primary @break
                                        @default bg-secondary
                                    @endswitch" 
                                    style="width: {{ ($usuariosRol->count() / $total) * 100 }}%">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Especialidades más Populares</h6>
                    </div>
                    <div class="card-body">
                        @php
                            $especialidadesDistribucion = $usuarios->groupBy(function($usuario) {
                                return $usuario->especialidad->especialidad ?? 'Sin especialidad';
                            })->sortByDesc(function($grupo) {
                                return $grupo->count();
                            })->take(5);
                        @endphp
                        
                        @foreach($especialidadesDistribucion as $especialidad => $usuariosEsp)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">{{ $especialidad }}</span>
                                <span>{{ $usuariosEsp->count() }}</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-info" 
                                    style="width: {{ ($usuariosEsp->count() / $total) * 100 }}%">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Información demográfica -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Información Demográfica</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <h6>Distribución por Género</h6>
                                @php
                                    $generosDistribucion = $usuarios->groupBy(function($usuario) {
                                        return $usuario->genero->genero ?? 'No especificado';
                                    });
                                @endphp
                                @foreach($generosDistribucion as $genero => $usuariosGenero)
                                <div class="mb-2">
                                    <small><strong>{{ $genero }}:</strong> {{ $usuariosGenero->count() }}</small>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-primary" 
                                            style="width: {{ ($usuariosGenero->count() / $total) * 100 }}%">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="col-md-3">
                                <h6>Tipos de Documento</h6>
                                @php
                                    $documentosDistribucion = $usuarios->groupBy(function($usuario) {
                                        return $usuario->documento->tipo_documento ?? 'No especificado';
                                    });
                                @endphp
                                @foreach($documentosDistribucion as $tipoDoc => $usuariosDoc)
                                <div class="mb-2">
                                    <small><strong>{{ $tipoDoc }}:</strong> {{ $usuariosDoc->count() }}</small>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-secondary" 
                                            style="width: {{ ($usuariosDoc->count() / $total) * 100 }}%">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="col-md-3">
                                <h6>Registros por Mes</h6>
                                @php
                                    $registrosPorMes = $usuarios->groupBy(function($usuario) {
                                        return $usuario->created_at instanceof \Carbon\Carbon ? 
                                            $usuario->created_at->format('Y-m') : 
                                            \Carbon\Carbon::parse($usuario->created_at)->format('Y-m');
                                    })->sortKeys()->take(6);
                                @endphp
                                @foreach($registrosPorMes as $mes => $usuariosMes)
                                <div class="mb-2">
                                    <small><strong>{{ \Carbon\Carbon::parse($mes)->format('M Y') }}:</strong> {{ $usuariosMes->count() }}</small>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-success" 
                                            style="width: {{ ($usuariosMes->count() / $total) * 100 }}%">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="col-md-3">
                                <h6>Estados del Sistema</h6>
                                <div class="mb-2">
                                    <small><strong>Activos:</strong> {{ $usuarios->where('id_estado', 1)->count() }}</small>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-success" 
                                            style="width: {{ ($usuarios->where('id_estado', 1)->count() / $total) * 100 }}%">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <small><strong>Inactivos:</strong> {{ $usuarios->where('id_estado', '!=', 1)->count() }}</small>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-warning" 
                                            style="width: {{ ($usuarios->where('id_estado', '!=', 1)->count() / $total) * 100 }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @else
        <div class="text-center py-5">
            <i class="fas fa-users fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">No se encontraron usuarios</h4>
            <p class="text-muted">No hay usuarios que coincidan con los filtros aplicados.</p>
            <a href="{{ route('informes.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Volver a Informes
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Función para exportar con los mismos filtros
    function exportarInforme(formato) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("informes.usuarios") }}';
        
        // Token CSRF
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Formato
        const formatoInput = document.createElement('input');
        formatoInput.type = 'hidden';
        formatoInput.name = 'formato';
        formatoInput.value = formato;
        form.appendChild(formatoInput);
        
        // Filtros actuales
        const tipoUsuarioInput = document.createElement('input');
        tipoUsuarioInput.type = 'hidden';
        tipoUsuarioInput.name = 'tipo_usuario';
        tipoUsuarioInput.value = '{{ request("tipo_usuario") ?? "todos" }}';
        form.appendChild(tipoUsuarioInput);
        
        const estadoInput = document.createElement('input');
        estadoInput.type = 'hidden';
        estadoInput.name = 'estado';
        estadoInput.value = '{{ request("estado") ?? "todos" }}';
        form.appendChild(estadoInput);
        
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }

    // DataTable para mejor navegación
    $(document).ready(function() {
        $('#usuariosTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
            },
            responsive: true,
            pageLength: 25,
            order: [[0, 'desc']], // Ordenar por ID descendente
            columnDefs: [
                { targets: [5, 8], orderable: false } // Columnas de contacto y actividad no ordenables
            ]
        });
    });
</script>

<!-- DataTables CSS y JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
@endsection