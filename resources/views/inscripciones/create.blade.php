@extends('layouts.dashboard')

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
            <!-- Formulario para estudiantes - Solo selecciona el curso -->
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Te estás inscribiendo a un nuevo curso.
            </div>
            
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
            
            @elseif(Auth::user()->tieneRol('Instructor'))
            <!-- Formulario para instructores - Selecciona el estudiante para sus cursos -->
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Estás inscribiendo a un estudiante en uno de tus cursos.
            </div>
            
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
                        <label for="id_curso" class="form-label">Mis Cursos *</label>
                        <select class="form-select @error('id_curso') is-invalid @enderror" id="id_curso" name="id_curso" required>
                            <option value="">Seleccione un curso...</option>
                            @foreach($cursos as $curso)
                            <option value="{{ $curso->id_curso }}" {{ old('id_curso') == $curso->id_curso ? 'selected' : '' }}>
                                {{ $curso->curso }} - 
                                Cupos disponibles: {{ $curso->cupos - $curso->cantidad_alumnos }}
                            </option>
                            @endforeach
                        </select>
                        @if(count($cursos) == 0)
                        <small class="text-danger">No tienes cursos asignados como instructor.</small>
                        @endif
                        @error('id_curso')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            
            @else
            <!-- Formulario para administradores - Selecciona cualquier estudiante y cualquier curso -->
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Como administrador, puedes inscribir a cualquier estudiante en cualquier curso.
            </div>
            
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
                <button type="submit" class="btn btn-primary" {{ (Auth::user()->tieneRol('Instructor') && count($cursos) == 0) ? 'disabled' : '' }}>
                    <i class="fas fa-save"></i> {{ Auth::user()->tieneRol('Estudiante') ? 'Inscribirse' : 'Inscribir Estudiante' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Si hay un cambio en el curso, mostramos un mensaje si no hay cupos disponibles
        $('#id_curso').change(function() {
            var selectedOption = $(this).find('option:selected');
            var cuposText = selectedOption.text().split('Cupos disponibles: ')[1];
            
            if (cuposText !== undefined) {
                var cuposDisponibles = parseInt(cuposText);
                
                if (cuposDisponibles <= 0) {
                    alert('¡Atención! Este curso no tiene cupos disponibles. La inscripción se agregará a la lista de espera.');
                }
            }
        });
    });
</script>
@endsection