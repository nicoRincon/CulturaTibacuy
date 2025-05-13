@extends('layouts.app')

@section('title', 'Crear Inscripción')

@section('actions')
<a href="{{ route('inscripciones.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Volver
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('inscripciones.store') }}" method="POST">
            @csrf
            
            @if(Auth::user()->tieneRol('Estudiante'))
            <!-- Formulario para estudiantes -->
            <div class="mb-3">
                <label for="id_curso" class="form-label">Curso *</label>
                <select class="form-select @error('id_curso') is-invalid @enderror" id="id_curso" name="id_curso" required>
                    <option value="">Seleccione un curso...</option>
                    @foreach($cursos as $curso)
                    <option value="{{ $curso->id_curso }}" {{ old('id_curso') == $curso->id_curso ? 'selected' : '' }}>
                        {{ $curso->curso }} - 
                        Instructor: {{ $curso->instructor->primer_nombre }} {{ $curso->instructor->primer_apellido }} - 
                        Cupos disponibles: {{ $curso->cupos - $curso->cantidad_alumnos }}
                    </option>
                    @endforeach
                </select>
                @error('id_curso')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            
            @else
            <!-- Formulario para administradores e instructores -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_usuario" class="form-label">Estudiante *</label>
                        <select class="form-select @error('id_usuario') is-invalid @enderror" id="id_usuario" name="id_usuario" required>
                            <option value="">Seleccione un estudiante...</option>
                            @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id_usuario }}" {{ old('id_usuario') == $usuario->id_usuario ? 'selected' : '' }}>
                                {{ $usuario->primer_nombre }} {{ $usuario->primer_apellido }} - 
                                {{ $usuario->num_documento }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_usuario')
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
                            <option value="">Seleccione un curso...</option>
                            @foreach($cursos as $curso)
                            <option value="{{ $curso->id_curso }}" {{ old('id_curso') == $curso->id_curso ? 'selected' : '' }}>
                                {{ $curso->curso }} - 
                                Instructor: {{ $curso->instructor->primer_nombre }} {{ $curso->instructor->primer_apellido }} - 
                                Cupos disponibles: {{ $curso->cupos - $curso->cantidad_alumnos }}
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
            @endif
            
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Inscribir</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Aquí puedes agregar cualquier inicialización de JavaScript si es necesario
    });
</script>
@endsection