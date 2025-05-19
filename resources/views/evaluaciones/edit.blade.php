@extends('layouts.dashboard')

@section('title', 'Editar Evaluación')

@section('actions')
<a href="{{ route('evaluaciones.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Volver
</a>
<a href="{{ route('evaluaciones.show', $evaluacion->id_evaluacion) }}" class="btn btn-info">
    <i class="fas fa-eye"></i> Ver Detalles
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="mb-4">Evaluación de {{ $evaluacion->usuario->primer_nombre }} {{ $evaluacion->usuario->primer_apellido }} en {{ $evaluacion->curso->curso }}</h5>
        
        <form action="{{ route('evaluaciones.update', $evaluacion->id_evaluacion) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_curso" class="form-label">Curso</label>
                        <input type="text" class="form-control" value="{{ $evaluacion->curso->curso }}" readonly>
                        <input type="hidden" name="id_curso" value="{{ $evaluacion->id_curso }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_usuario" class="form-label">Estudiante</label>
                        <input type="text" class="form-control" value="{{ $evaluacion->usuario->primer_nombre }} {{ $evaluacion->usuario->primer_apellido }}" readonly>
                        <input type="hidden" name="id_usuario" value="{{ $evaluacion->id_usuario }}">
                    </div>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nota" class="form-label">Nota (0-5) *</label>
                        <input type="number" class="form-control @error('nota') is-invalid @enderror" id="nota" name="nota" value="{{ old('nota', $evaluacion->nota) }}" min="0" max="5" step="0.1" required>
                        @error('nota')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fecha_evaluacion" class="form-label">Fecha de Evaluación *</label>
                        <input type="date" class="form-control @error('fecha_evaluacion') is-invalid @enderror" id="fecha_evaluacion" name="fecha_evaluacion" value="{{ old('fecha_evaluacion', $evaluacion->fecha_evaluacion instanceof \Carbon\Carbon ? $evaluacion->fecha_evaluacion->format('Y-m-d') : $evaluacion->fecha_evaluacion) }}" required>
                        @error('fecha_evaluacion')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="comentarios" class="form-label">Comentarios</label>
                <textarea class="form-control @error('comentarios') is-invalid @enderror" id="comentarios" name="comentarios" rows="4">{{ old('comentarios', $evaluacion->comentarios) }}</textarea>
                @error('comentarios')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Actualizar Evaluación</button>
            </div>
        </form>
    </div>
</div>

<!-- Información adicional sobre el estudiante y el curso -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Información del Estudiante</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Nombre completo:</th>
                            <td>{{ $evaluacion->usuario->primer_nombre }} {{ $evaluacion->usuario->segundo_nombre }} {{ $evaluacion->usuario->primer_apellido }} {{ $evaluacion->usuario->segundo_apellido }}</td>
                        </tr>
                        <tr>
                            <th>Documento:</th>
                            <td>{{ $evaluacion->usuario->documento->tipo_documento }}: {{ $evaluacion->usuario->num_documento }}</td>
                        </tr>
                        <tr>
                            <th>Otras evaluaciones:</th>
                            <td>
                                @php
                                $otrasEvaluaciones = $evaluacion->usuario->evaluaciones()
                                    ->where('id_curso', $evaluacion->id_curso)
                                    ->where('id_evaluacion', '!=', $evaluacion->id_evaluacion)
                                    ->get();
                                @endphp
                                
                                @if($otrasEvaluaciones->count() > 0)
                                    <ul class="list-group">
                                    @foreach($otrasEvaluaciones as $otra)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $otra->fecha_evaluacion instanceof \Carbon\Carbon ? $otra->fecha_evaluacion->format('d/m/Y') : $otra->fecha_evaluacion }}
                                            <span class="badge {{ $otra->nota >= 3.0 ? 'bg-success' : 'bg-danger' }} rounded-pill">{{ number_format($otra->nota, 1) }}</span>
                                        </li>
                                    @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">No hay otras evaluaciones para este curso</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Información del Curso</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Curso:</th>
                            <td>{{ $evaluacion->curso->curso }}</td>
                        </tr>
                        <tr>
                            <th>Nivel:</th>
                            <td>{{ $evaluacion->curso->nivel->nivel }}</td>
                        </tr>
                        <tr>
                            <th>Promedio del curso:</th>
                            <td>
                                @php
                                $promedio = $evaluacion->curso->evaluaciones->avg('nota');
                                @endphp
                                <span class="badge {{ $promedio >= 3.0 ? 'bg-success' : 'bg-danger' }} rounded-pill">{{ number_format($promedio, 1) }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Validación para asegurarse de que la nota esté en el rango correcto
    $(document).ready(function() {
        $('#nota').on('input', function() {
            var nota = parseFloat($(this).val());
            if (nota < 0) {
                $(this).val(0);
            } else if (nota > 5) {
                $(this).val(5);
            }
        });
    });
</script>
@endsection