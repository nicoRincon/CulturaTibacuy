@extends('layouts.dashboard')

@section('title', 'Informe de Evaluaciones')

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
                    <div class="col-md-4">
                        <strong>Curso:</strong> 
                        @if(request('id_curso'))
                            {{ App\Models\Curso::find(request('id_curso'))->curso ?? 'Curso no encontrado' }}
                        @else
                            Todos los cursos
                        @endif
                    </div>
                    <div class="col-md-4">
                        <strong>Fecha desde:</strong> 
                        {{ request('fecha_desde') ? \Carbon\Carbon::parse(request('fecha_desde'))->format('d/m/Y') : 'Sin filtro' }}
                    </div>
                    <div class="col-md-4">
                        <strong>Fecha hasta:</strong> 
                        {{ request('fecha_hasta') ? \Carbon\Carbon::parse(request('fecha_hasta'))->format('d/m/Y') : 'Sin filtro' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-star me-2"></i>Evaluaciones Registradas
        </h5>
        <span class="badge bg-primary fs-6">{{ $evaluaciones->count() }} registros</span>
    </div>
    <div class="card-body">
        @if($evaluaciones->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="evaluacionesTable">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Estudiante</th>
                        <th>Curso</th>
                        <th>Instructor</th>
                        <th>Fecha Evaluación</th>
                        <th>Nota</th>
                        <th>Estado</th>
                        <th>Comentarios</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($evaluaciones as $evaluacion)
                    <tr>
                        <td>{{ $evaluacion->id_evaluacion }}</td>
                        <td>
                            <strong>{{ $evaluacion->usuario->primer_nombre }} {{ $evaluacion->usuario->primer_apellido }}</strong>
                            <br><small class="text-muted">{{ $evaluacion->usuario->num_documento }}</small>
                        </td>
                        <td>{{ $evaluacion->curso->curso }}</td>
                        <td>{{ $evaluacion->curso->instructor->primer_nombre ?? '' }} {{ $evaluacion->curso->instructor->primer_apellido ?? '' }}</td>
                        <td>{{ $evaluacion->fecha_evaluacion instanceof \Carbon\Carbon ? $evaluacion->fecha_evaluacion->format('d/m/Y') : $evaluacion->fecha_evaluacion }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="badge fs-6 me-2 
                                    @if($evaluacion->nota >= 4.5) bg-success
                                    @elseif($evaluacion->nota >= 4.0) bg-primary
                                    @elseif($evaluacion->nota >= 3.5) bg-info
                                    @elseif($evaluacion->nota >= 3.0) bg-warning
                                    @else bg-danger
                                    @endif">
                                    {{ number_format($evaluacion->nota, 1) }}
                                </span>
                                <small class="text-muted">
                                    @if($evaluacion->nota >= 4.5) Excelente
                                    @elseif($evaluacion->nota >= 4.0) Sobresaliente
                                    @elseif($evaluacion->nota >= 3.5) Bueno
                                    @elseif($evaluacion->nota >= 3.0) Aceptable
                                    @else Insuficiente
                                    @endif
                                </small>
                            </div>
                        </td>
                        <td>
                            @if($evaluacion->nota >= 3.0)
                                <span class="badge bg-success">
                                    <i class="fas fa-check"></i> Aprobado
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="fas fa-times"></i> Reprobado
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($evaluacion->comentarios)
                                <span class="d-inline-block text-truncate" style="max-width: 200px;" title="{{ $evaluacion->comentarios }}">
                                    {{ $evaluacion->comentarios }}
                                </span>
                            @else
                                <span class="text-muted">Sin comentarios</span>
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
                        <h5 class="text-primary">{{ $evaluaciones->count() }}</h5>
                        <small class="text-muted">Total Evaluaciones</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h5 class="text-success">{{ $evaluaciones->where('nota', '>=', 3.0)->count() }}</h5>
                        <small class="text-muted">Aprobados</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h5 class="text-danger">{{ $evaluaciones->where('nota', '<', 3.0)->count() }}</h5>
                        <small class="text-muted">Reprobados</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h5 class="text-info">{{ number_format($evaluaciones->avg('nota'), 1) }}</h5>
                        <small class="text-muted">Promedio General</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h5 class="text-warning">{{ number_format($evaluaciones->max('nota'), 1) }}</h5>
                        <small class="text-muted">Nota Máxima</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h5 class="text-secondary">{{ number_format($evaluaciones->min('nota'), 1) }}</h5>
                        <small class="text-muted">Nota Mínima</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico de distribución de notas -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Distribución de Calificaciones</h6>
                    </div>
                    <div class="card-body">
                        @php
                            $excelentes = $evaluaciones->where('nota', '>=', 4.5)->count();
                            $sobresalientes = $evaluaciones->where('nota', '>=', 4.0)->where('nota', '<', 4.5)->count();
                            $buenos = $evaluaciones->where('nota', '>=', 3.5)->where('nota', '<', 4.0)->count();
                            $aceptables = $evaluaciones->where('nota', '>=', 3.0)->where('nota', '<', 3.5)->count();
                            $insuficientes = $evaluaciones->where('nota', '<', 3.0)->count();
                            $total = $evaluaciones->count();
                        @endphp
                        
                        <div class="row">
                            <div class="col-md-2">
                                <div class="text-center">
                                    <div class="progress mb-2" style="height: 60px;">
                                        <div class="progress-bar bg-success" style="width: 100%; writing-mode: tb-rl;">
                                            {{ $excelentes }}
                                        </div>
                                    </div>
                                    <small>Excelente<br>(4.5-5.0)</small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <div class="progress mb-2" style="height: 60px;">
                                        <div class="progress-bar bg-primary" style="width: 100%; writing-mode: tb-rl;">
                                            {{ $sobresalientes }}
                                        </div>
                                    </div>
                                    <small>Sobresaliente<br>(4.0-4.4)</small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <div class="progress mb-2" style="height: 60px;">
                                        <div class="progress-bar bg-info" style="width: 100%; writing-mode: tb-rl;">
                                            {{ $buenos }}
                                        </div>
                                    </div>
                                    <small>Bueno<br>(3.5-3.9)</small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <div class="progress mb-2" style="height: 60px;">
                                        <div class="progress-bar bg-warning" style="width: 100%; writing-mode: tb-rl;">
                                            {{ $aceptables }}
                                        </div>
                                    </div>
                                    <small>Aceptable<br>(3.0-3.4)</small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <div class="progress mb-2" style="height: 60px;">
                                        <div class="progress-bar bg-danger" style="width: 100%; writing-mode: tb-rl;">
                                            {{ $insuficientes }}
                                        </div>
                                    </div>
                                    <small>Insuficiente<br>(0.0-2.9)</small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="text-primary">{{ round(($evaluaciones->where('nota', '>=', 3.0)->count() / $total) * 100) }}%</h5>
                                    <small>Tasa de Aprobación</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @else
        <div class="text-center py-5">
            <i class="fas fa-star fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">No se encontraron evaluaciones</h4>
            <p class="text-muted">No hay evaluaciones que coincidan con los filtros aplicados.</p>
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
        form.action = '{{ route("informes.evaluaciones") }}';
        
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
        @if(request('id_curso'))
        const cursoInput = document.createElement('input');
        cursoInput.type = 'hidden';
        cursoInput.name = 'id_curso';
        cursoInput.value = '{{ request("id_curso") }}';
        form.appendChild(cursoInput);
        @endif
        
        @if(request('fecha_desde'))
        const fechaDesdeInput = document.createElement('input');
        fechaDesdeInput.type = 'hidden';
        fechaDesdeInput.name = 'fecha_desde';
        fechaDesdeInput.value = '{{ request("fecha_desde") }}';
        form.appendChild(fechaDesdeInput);
        @endif
        
        @if(request('fecha_hasta'))
        const fechaHastaInput = document.createElement('input');
        fechaHastaInput.type = 'hidden';
        fechaHastaInput.name = 'fecha_hasta';
        fechaHastaInput.value = '{{ request("fecha_hasta") }}';
        form.appendChild(fechaHastaInput);
        @endif
        
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }

    // DataTable para mejor navegación
    $(document).ready(function() {
        $('#evaluacionesTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
            },
            responsive: true,
            pageLength: 25,
            order: [[4, 'desc']], // Ordenar por fecha de evaluación descendente
            columnDefs: [
                { targets: [7], orderable: false } // Columna de comentarios no ordenable
            ]
        });
    });
</script>

<!-- DataTables CSS y JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
@endsection