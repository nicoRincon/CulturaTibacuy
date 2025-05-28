@extends('layouts.dashboard')

@section('title', 'Informe de Inscripciones')

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
            <i class="fas fa-clipboard-list me-2"></i>Inscripciones Registradas
        </h5>
        <span class="badge bg-primary fs-6">{{ $inscripciones->count() }} registros</span>
    </div>
    <div class="card-body">
        @if($inscripciones->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="inscripcionesTable">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Estudiante</th>
                        <th>Documento</th>
                        <th>Curso</th>
                        <th>Instructor</th>
                        <th>Fecha Inscripción</th>
                        <th>Estado del Curso</th>
                        <th>Contacto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inscripciones as $inscripcion)
                    <tr>
                        <td>{{ $inscripcion->id_inscripcion }}</td>
                        <td>
                            <strong>{{ $inscripcion->usuario->primer_nombre }} {{ $inscripcion->usuario->primer_apellido }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ $inscripcion->usuario->documento->tipo_documento ?? 'N/A' }}
                            </span>
                            {{ $inscripcion->usuario->num_documento }}
                        </td>
                        <td>{{ $inscripcion->curso->curso }}</td>
                        <td>{{ $inscripcion->curso->instructor->primer_nombre ?? '' }} {{ $inscripcion->curso->instructor->primer_apellido ?? '' }}</td>
                        <td>{{ $inscripcion->fecha_inscripcion instanceof \Carbon\Carbon ? $inscripcion->fecha_inscripcion->format('d/m/Y') : $inscripcion->fecha_inscripcion }}</td>
                        <td>
                            @php
                                $today = now();
                                $inicio = $inscripcion->curso->fecha_inicio instanceof \Carbon\Carbon ? $inscripcion->curso->fecha_inicio : \Carbon\Carbon::parse($inscripcion->curso->fecha_inicio);
                                $fin = $inscripcion->curso->fecha_fin instanceof \Carbon\Carbon ? $inscripcion->curso->fecha_fin : \Carbon\Carbon::parse($inscripcion->curso->fecha_fin);
                            @endphp
                            @if($today->lt($inicio))
                                <span class="badge bg-info">Próximo</span>
                            @elseif($today->between($inicio, $fin))
                                <span class="badge bg-success">En Curso</span>
                            @else
                                <span class="badge bg-secondary">Finalizado</span>
                            @endif
                        </td>
                        <td>
                            <small>
                                <i class="fas fa-envelope"></i> {{ $inscripcion->usuario->contacto->email ?? 'N/A' }}<br>
                                <i class="fas fa-phone"></i> {{ $inscripcion->usuario->contacto->telefono ?? 'N/A' }}
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
                        <h5 class="text-primary">{{ $inscripciones->count() }}</h5>
                        <small class="text-muted">Total Inscripciones</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h5 class="text-success">{{ $inscripciones->unique('id_curso')->count() }}</h5>
                        <small class="text-muted">Cursos Diferentes</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h5 class="text-warning">{{ $inscripciones->unique('id_usuario')->count() }}</h5>
                        <small class="text-muted">Estudiantes Únicos</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        @php
                            $cursosActivos = $inscripciones->filter(function($inscripcion) {
                                $today = now();
                                $inicio = $inscripcion->curso->fecha_inicio instanceof \Carbon\Carbon ? $inscripcion->curso->fecha_inicio : \Carbon\Carbon::parse($inscripcion->curso->fecha_inicio);
                                $fin = $inscripcion->curso->fecha_fin instanceof \Carbon\Carbon ? $inscripcion->curso->fecha_fin : \Carbon\Carbon::parse($inscripcion->curso->fecha_fin);
                                return $today->between($inicio, $fin);
                            })->count();
                        @endphp
                        <h5 class="text-info">{{ $cursosActivos }}</h5>
                        <small class="text-muted">Cursos Activos</small>
                    </div>
                </div>
            </div>
        </div>

        @else
        <div class="text-center py-5">
            <i class="fas fa-clipboard-list fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">No se encontraron inscripciones</h4>
            <p class="text-muted">No hay inscripciones que coincidan con los filtros aplicados.</p>
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
        form.action = '{{ route("informes.inscripciones") }}';
        
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
        $('#inscripcionesTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
            },
            responsive: true,
            pageLength: 25,
            order: [[5, 'desc']], // Ordenar por fecha de inscripción descendente
            columnDefs: [
                { targets: [7], orderable: false } // Columna de contacto no ordenable
            ]
        });
    });
</script>

<!-- DataTables CSS y JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
@endsection