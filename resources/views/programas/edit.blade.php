@extends('layouts.dashboard')

@section('title', 'Editar Programa de Formación')

@section('actions')
<a href="{{ route('programas.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Volver
</a>
<a href="{{ route('programas.show', $programa->id_programa) }}" class="btn btn-info">
    <i class="fas fa-eye"></i> Ver Detalles
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('programas.update', $programa->id_programa) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_tipo_escuela" class="form-label">Tipo de Escuela *</label>
                        <select class="form-select @error('id_tipo_escuela') is-invalid @enderror" id="id_tipo_escuela" name="id_tipo_escuela" required>
                            <option value="">Seleccione...</option>
                            @foreach($tiposEscuela as $tipo)
                            <option value="{{ $tipo->id_tipo_escuela }}" {{ old('id_tipo_escuela', $programa->id_tipo_escuela) == $tipo->id_tipo_escuela ? 'selected' : '' }}>
                                {{ $tipo->tipos_escuela }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_tipo_escuela')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_escuela" class="form-label">Escuela *</label>
                        <select class="form-select @error('id_escuela') is-invalid @enderror" id="id_escuela" name="id_escuela" required>
                            <option value="">Seleccione...</option>
                            @foreach($escuelas as $escuela)
                            <option value="{{ $escuela->id_escuela }}" {{ old('id_escuela', $programa->id_escuela) == $escuela->id_escuela ? 'selected' : '' }}>
                                {{ $escuela->nombre }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_escuela')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_ubicacion" class="form-label">Ubicación *</label>
                        <select class="form-select @error('id_ubicacion') is-invalid @enderror" id="id_ubicacion" name="id_ubicacion" required>
                            <option value="">Seleccione...</option>
                            @foreach($ubicaciones as $ubicacion)
                            <option value="{{ $ubicacion->id_ubicacion }}" {{ old('id_ubicacion', $programa->id_ubicacion) == $ubicacion->id_ubicacion ? 'selected' : '' }}>
                                {{ $ubicacion->ubicacion }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_ubicacion')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_curso" class="form-label">Curso *</label>
                        <select class="form-select @error('id_curso') is-invalid @enderror" id="id_curso" name="id_curso" required>
                            <option value="">Seleccione...</option>
                            @foreach($cursos as $curso)
                            <option value="{{ $curso->id_curso }}" {{ old('id_curso', $programa->id_curso) == $curso->id_curso ? 'selected' : '' }}>
                                {{ $curso->curso }} - {{ $curso->instructor->primer_nombre ?? 'Sin instructor' }} {{ $curso->instructor->primer_apellido ?? '' }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_curso')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="id_responsable" class="form-label">Responsable del Programa *</label>
                        <select class="form-select @error('id_responsable') is-invalid @enderror" id="id_responsable" name="id_responsable" required>
                            <option value="">Seleccione...</option>
                            @foreach($responsables as $responsable)
                            <option value="{{ $responsable->id_usuario }}" {{ old('id_responsable', $programa->id_usuario) == $responsable->id_usuario ? 'selected' : '' }}>
                                {{ $responsable->primer_nombre }} {{ $responsable->primer_apellido }} 
                                ({{ $responsable->rol->rol ?? 'Sin rol' }}) - 
                                {{ $responsable->especialidad->especialidad ?? 'Sin especialidad' }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_responsable')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar Programa
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Información del programa actual -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle"></i> Información Actual del Programa
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Escuela:</strong> {{ $programa->escuela->nombre ?? 'Sin escuela' }}<br>
                        <strong>Tipo:</strong> {{ $programa->tipoEscuela->tipos_escuela ?? 'Sin tipo' }}<br>
                        <strong>Ubicación:</strong> {{ $programa->ubicacion->ubicacion ?? 'Sin ubicación' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Curso:</strong> {{ $programa->curso->curso ?? 'Sin curso' }}<br>
                        <strong>Responsable:</strong> 
                        @if($programa->responsable)
                            {{ $programa->responsable->primer_nombre }} {{ $programa->responsable->primer_apellido }}
                        @else
                            Sin responsable
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection