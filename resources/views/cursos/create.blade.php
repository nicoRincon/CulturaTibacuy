@extends('layouts.dashboard')

@section('title', 'Crear Curso')

@section('actions')
<a href="{{ route('cursos.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Volver
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('cursos.store') }}" method="POST">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="curso" class="form-label">Nombre del Curso *</label>
                        <input type="text" class="form-control @error('curso') is-invalid @enderror" id="curso" name="curso" value="{{ old('curso') }}" required>
                        @error('curso')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_nivel" class="form-label">Nivel *</label>
                        <select class="form-select @error('id_nivel') is-invalid @enderror" id="id_nivel" name="id_nivel" required>
                            <option value="">Seleccione...</option>
                            @foreach($niveles as $nivel)
                     d       <option value="{{ $nivel->id_nivel }}" {{ old('id_nivel') == $nivel->id_nivel ? 'selected' : '' }}>
                                {{ $nivel->nivel }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_nivel')
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
                        <label for="id_recurso" class="form-label">Recurso *</label>
                        <select class="form-select @error('id_recurso') is-invalid @enderror" id="id_recurso" name="id_recurso" required>
                            <option value="">Seleccione...</option>
                            @foreach($recursos as $recurso)
                            <option value="{{ $recurso->id_recurso }}" {{ old('id_recurso') == $recurso->id_recurso ? 'selected' : '' }}>
                                {{ $recurso->recurso }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_recurso')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_horario" class="form-label">Horario *</label>
                        <select class="form-select @error('id_horario') is-invalid @enderror" id="id_horario" name="id_horario" required>
                            <option value="">Seleccione...</option>
                            @foreach($horarios as $horario)
                            <option value="{{ $horario->id_horario }}" {{ old('id_horario') == $horario->id_horario ? 'selected' : '' }}>
                                {{ $horario->dia }} - {{ $horario->hora_inicio }} a {{ $horario->hora_fin }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_horario')
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
                        <label for="fecha_inicio" class="form-label">Fecha de Inicio *</label>
                        <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required>
                        @error('fecha_inicio')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fecha_fin" class="form-label">Fecha de Fin *</label>
                        <input type="date" class="form-control @error('fecha_fin') is-invalid @enderror" id="fecha_fin" name="fecha_fin" value="{{ old('fecha_fin') }}" required>
                        @error('fecha_fin')
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
                        <label for="cupos" class="form-label">Cupos *</label>
                        <input type="number" class="form-control @error('cupos') is-invalid @enderror" id="cupos" name="cupos" value="{{ old('cupos') }}" min="1" required>
                        @error('cupos')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_instructor" class="form-label">Instructor *</label>
                        <select class="form-select @error('id_instructor') is-invalid @enderror" id="id_instructor" name="id_instructor" required>
                            <option value="">Seleccione...</option>
                            @foreach($instructores as $instructor)
                            <option value="{{ $instructor->id_usuario }}" {{ old('id_instructor') == $instructor->id_usuario ? 'selected' : '' }}>
                                {{ $instructor->primer_nombre }} {{ $instructor->primer_apellido }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_instructor')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="objetivo" class="form-label">Objetivo del Curso *</label>
                <textarea class="form-control @error('objetivo') is-invalid @enderror" id="objetivo" name="objetivo" rows="3" required>{{ old('objetivo') }}</textarea>
                @error('objetivo')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection