@extends('layouts.dashboard')

@section('title', 'Informe de Cursos')

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
                    <div class="col-md-12">
                        <strong>Estado del Curso:</strong> 
                        @switch(request('estado_curso'))
                            @case('activos')
                                <span class="badge bg-success">Cursos Activos</span>
                                @break
                            @case('finalizados')
                                <span class="badge bg-secondary">Cursos Finalizados</span>
                                @break
                            @case('proximos')
                                <span class="badge bg-info">Cursos Próximos</span>
                                @break
                            @default
                                <span class="badge bg-primary">Todos los Cursos</span>
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
            <i class="fas fa-book me-2"></i>Cursos Registrados
        </h5>
        <span class="badge bg-primary fs-6">{{ $cursos->count() }} registros</span>
    </div>
    <div class="card-body">
        @if($cursos->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="cursosTable">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Curso</th>
                        <th>Instructor</th>
                        <th>Nivel</th>
                        <th>Fechas</th>
                        <th>Ocupación</th>
                        <th>Estado</th>
                        <th>Recurso/Horario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cursos as $curso)
                    <tr>
                        <td>{{ $curso->id_curso }}</td>
                        <td>
                            <strong>{{ $curso->curso }}</strong>
                            <br><small class="text-muted">{{ Str::limit($curso->objetivo, 50) }}</small>
                        </td>
                        <td>{{ $curso->instructor->primer_nombre ?? '' }} {{ $curso->instructor->primer_apellido ?? '' }}</td>
                        <td>
                            <span class="badge bg-info">{{ $curso->nivel->nivel ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <small>
                                <strong>Inicio:</strong> {{ $curso->fecha_inicio instanceof \Carbon\Carbon ? $curso->fecha_inicio->format('d/m/Y') : $curso->fecha_inicio }}<br>
                                <strong>Fin:</strong> {{ $curso->fecha_fin instanceof \Carbon\Carbon ? $curso->fecha_fin->format('d/m/Y') : $curso->fecha_fin }}
                            </small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="me-2">{{ $curso->cantidad_alumnos }}/{{ $curso->cupos }}</span>
                                @php
                                    $porcentaje = $curso->cupos > 0 ? ($curso->cantidad_alumnos / $curso->cupos) * 100 : 0;
                                @endphp
                                <div class="progress" style="width: 60px; height: 8px;">
                                    <div class="progress-bar 
                                        @if($porcentaje >= 100) bg-danger
                                        @elseif($porcentaje >= 80) bg-warning
                                        @else bg-success
                                        @endif" 
                                        style="width: {{ min($porcentaje, 100) }}%">
                                    </div>
                                </div>
                                <small class="ms-1">{{ round($porcentaje) }}%</small>
                            </div>
                        </td>
                        <td>
                            @php
                                $today = now();
                                $inicio = $curso->fecha_inicio instanceof \Carbon\Carbon ? $curso->fecha_inicio : \Carbon\Carbon::parse($curso->fecha_inicio);
                                $fin = $curso->fecha_fin instanceof \Carbon\Carbon ? $curso->fecha_fin : \Carbon\Carbon::parse($curso->fecha_fin);
                            @endphp
                            @if($today->lt($inicio))
                                <span class="badge bg-info">Próximo</span>
                            @elseif($today->between($inicio, $fin))
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-secondary">Finalizado</span>
                            @endif
                        </td>
                        <td>
                            <small>
                                <strong>Recurso:</strong> {{ $curso->recurso->recurso ?? 'N/A' }}<br>
                                <strong>Horario:</strong> {{ $curso->horario->dia ?? 'N/A' }} 
                                {{ $curso->horario->hora_inicio ?? '' }}-{{ $curso->horario->hora_fin ?? '' }}
                            </small>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Estadísticas resumidas -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h5 class="text-primary">{{ $cursos->count() }}</h5>
                        <small class="text-muted">Total Cursos</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        @php
                            $cursosActivos = $cursos->filter(function($curso) {
                                $today = now();
                                $inicio = $curso->fecha_inicio instanceof \Carbon\Carbon ? $curso->fecha_inicio : \Carbon\Carbon::parse($curso->fecha_inicio);
                                $fin = $curso->fecha_fin instanceof \Carbon\Carbon ? $curso->fecha_fin : \Carbon\Carbon::parse($curso->fecha_fin);
                                return $today->between($inicio, $fin);
                            })->count();
                        @endphp
                        <h5 class="text-success">{{ $cursosActivos }}</h5>
                        <small class="text-muted">Cursos Activos</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h5 class="text-warning">{{ $cursos->sum('cantidad_alumnos') }}</h5>
                        <small class="text-muted">Total Estudiantes</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        @php
                            $ocupacionPromedio = $cursos->where('cupos', '>', 0)->avg(function($curso) {
                                return ($curso->cantidad_alumnos / $curso->cupos) * 100;
                            });
                        @endphp
                        <h5 class="text-info">{{ round($ocupacionPromedio ?? 0) }}%</h5>
                        <small class="text-muted">Ocupación Promedio</small>
                    </div>
                </div>
            </div>
        </div>

        @else
        <div class="text-center py-5">
            <i class="fas fa-book fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">No se encontraron cursos</h4>
            <p class="text-muted">No hay cursos que coincidan con los filtros aplicados.</p>
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
        form.action = '{{ route("informes.cursos") }}';
        
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
        
        // Estado del curso
        const estadoInput = document.createElement('input');
        estadoInput.type = 'hidden';
        estadoInput.name = 'estado_curso';
        estadoInput.value = '{{ request("estado_curso") ?? "todos" }}';
        form.appendChild(estadoInput);
        
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }

    // DataTable para mejor navegación
    $(document).ready(function() {
        $('#cursosTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
            },
            responsive: true,
            pageLength: 25,
            order: [[4, 'desc']], // Ordenar por fecha de inicio descendente
            columnDefs: [
                { targets: [5, 7], orderable: false } // Columnas de ocupación y recurso/horario no ordenables
            ]
        });
    });
</script>

<!-- DataTables CSS y JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
@endsection