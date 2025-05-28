@extends('layouts.dashboard')

@section('title', 'Informe de Programas de Formación')

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
                        <strong>Escuela:</strong> 
                        @if(request('id_escuela'))
                            {{ App\Models\Escuela::find(request('id_escuela'))->nombre ?? 'Escuela no encontrada' }}
                        @else
                            Todas las escuelas
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-graduation-cap me-2"></i>Programas de Formación
        </h5>
        <span class="badge bg-primary fs-6">{{ $programas->count() }} registros</span>
    </div>
    <div class="card-body">
        @if($programas->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="programasTable">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Escuela</th>
                        <th>Tipo</th>
                        <th>Curso</th>
                        <th>Ubicación</th>
                        <th>Responsable</th>
                        <th>Estado</th>
                        <th>Estudiantes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($programas as $programa)
                    <tr>
                        <td>{{ $programa->id_programa }}</td>
                        <td>
                            <strong>{{ $programa->escuela->nombre ?? 'N/A' }}</strong>
                            @if($programa->escuela->descripcion)
                            <br><small class="text-muted">{{ Str::limit($programa->escuela->descripcion, 40) }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-info">
                                {{ $programa->tipoEscuela->tipos_escuela ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                            {{ $programa->curso->curso ?? 'N/A' }}
                            @if($programa->curso->nivel)
                            <br><small class="text-muted">Nivel: {{ $programa->curso->nivel->nivel }}</small>
                            @endif
                        </td>
                        <td>
                            <i class="fas fa-map-marker-alt text-danger"></i>
                            {{ $programa->ubicacion->ubicacion ?? 'N/A' }}
                        </td>
                        <td>
                            @if($programa->responsable)
                                <strong>{{ $programa->responsable->primer_nombre }} {{ $programa->responsable->primer_apellido }}</strong>
                                <br><small class="text-muted">{{ $programa->responsable->rol->rol ?? '' }}</small>
                            @else
                                <span class="text-muted">Sin responsable</span>
                            @endif
                        </td>
                        <td>
                            @if($programa->curso)
                                @php
                                    $today = now();
                                    $inicio = $programa->curso->fecha_inicio instanceof \Carbon\Carbon ? $programa->curso->fecha_inicio : \Carbon\Carbon::parse($programa->curso->fecha_inicio);
                                    $fin = $programa->curso->fecha_fin instanceof \Carbon\Carbon ? $programa->curso->fecha_fin : \Carbon\Carbon::parse($programa->curso->fecha_fin);
                                @endphp
                                @if($today->lt($inicio))
                                    <span class="badge bg-info">Próximo</span>
                                    <br><small class="text-muted">{{ $inicio->format('d/m/Y') }}</small>
                                @elseif($today->between($inicio, $fin))
                                    <span class="badge bg-success">En Ejecución</span>
                                    <br><small class="text-muted">Hasta {{ $fin->format('d/m/Y') }}</small>
                                @else
                                    <span class="badge bg-secondary">Finalizado</span>
                                    <br><small class="text-muted">{{ $fin->format('d/m/Y') }}</small>
                                @endif
                            @else
                                <span class="badge bg-warning">Sin definir</span>
                            @endif
                        </td>
                        <td>
                            @if($programa->curso)
                                <div class="d-flex align-items-center">
                                    <span class="me-2">{{ $programa->curso->cantidad_alumnos ?? 0 }}/{{ $programa->curso->cupos ?? 0 }}</span>
                                    @php
                                        $cupos = $programa->curso->cupos ?? 0;
                                        $alumnos = $programa->curso->cantidad_alumnos ?? 0;
                                        $porcentaje = $cupos > 0 ? ($alumnos / $cupos) * 100 : 0;
                                    @endphp
                                    <div class="progress" style="width: 50px; height: 6px;">
                                        <div class="progress-bar 
                                            @if($porcentaje >= 100) bg-danger
                                            @elseif($porcentaje >= 80) bg-warning
                                            @else bg-success
                                            @endif" 
                                            style="width: {{ min($porcentaje, 100) }}%">
                                        </div>
                                    </div>
                                </div>
                                <small class="text-muted">{{ round($porcentaje) }}% ocupación</small>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
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
                        <h5 class="text-primary">{{ $programas->count() }}</h5>
                        <small class="text-muted">Total Programas</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h5 class="text-success">{{ $programas->unique('id_escuela')->count() }}</h5>
                        <small class="text-muted">Escuelas Activas</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        @php
                            $programasActivos = $programas->filter(function($programa) {
                                if (!$programa->curso) return false;
                                $today = now();
                                $inicio = $programa->curso->fecha_inicio instanceof \Carbon\Carbon ? $programa->curso->fecha_inicio : \Carbon\Carbon::parse($programa->curso->fecha_inicio);
                                $fin = $programa->curso->fecha_fin instanceof \Carbon\Carbon ? $programa->curso->fecha_fin : \Carbon\Carbon::parse($programa->curso->fecha_fin);
                                return $today->between($inicio, $fin);
                            })->count();
                        @endphp
                        <h5 class="text-warning">{{ $programasActivos }}</h5>
                        <small class="text-muted">En Ejecución</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h5 class="text-info">{{ $programas->sum(function($p) { return $p->curso->cantidad_alumnos ?? 0; }) }}</h5>
                        <small class="text-muted">Total Estudiantes</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Distribución por tipo de escuela -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Distribución por Tipo de Escuela</h6>
                    </div>
                    <div class="card-body">
                        @php
                            $tiposDistribucion = $programas->groupBy(function($programa) {
                                return $programa->tipoEscuela->tipos_escuela ?? 'Sin definir';
                            });
                        @endphp
                        
                        <div class="row">
                            @foreach($tiposDistribucion as $tipo => $programasTipo)
                            <div class="col-md-3 mb-3">
                                <div class="card border">
                                    <div class="card-body text-center">
                                        <h5 class="text-primary">{{ $programasTipo->count() }}</h5>
                                        <small class="text-muted">{{ $tipo }}</small>
                                        <div class="progress mt-2" style="height: 4px;">
                                            <div class="progress-bar bg-primary" 
                                                 style="width: {{ ($programasTipo->count() / $programas->count()) * 100 }}%">
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ round(($programasTipo->count() / $programas->count()) * 100) }}%</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @else
        <div class="text-center py-5">
            <i class="fas fa-graduation-cap fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">No se encontraron programas</h4>
            <p class="text-muted">No hay programas de formación que coincidan con los filtros aplicados.</p>
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
        form.action = '{{ route("informes.programas") }}';
        
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
        
        // Filtro de escuela
        @if(request('id_escuela'))
        const escuelaInput = document.createElement('input');
        escuelaInput.type = 'hidden';
        escuelaInput.name = 'id_escuela';
        escuelaInput.value = '{{ request("id_escuela") }}';
        form.appendChild(escuelaInput);
        @endif
        
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }

    // DataTable para mejor navegación
    $(document).ready(function() {
        $('#programasTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
            },
            responsive: true,
            pageLength: 25,
            order: [[0, 'desc']], // Ordenar por ID descendente
            columnDefs: [
                { targets: [6, 7], orderable: false } // Columnas de estado y estudiantes no ordenables
            ]
        });
    });
</script>

<!-- DataTables CSS y JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
@endsection