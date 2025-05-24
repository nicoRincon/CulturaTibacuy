@extends('layouts.dashboard')

@section('title', 'Crear Programa de Formación')

@section('actions')
<a href="{{ route('programas.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Volver
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('programas.store') }}" method="POST">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_tipo_escuela" class="form-label">Tipo de Escuela *</label>
                        <select class="form-select @error('id_tipo_escuela') is-invalid @enderror" id="id_tipo_escuela" name="id_tipo_escuela" required>
                            <option value="">Seleccione...</option>
                            @foreach($tiposEscuela as $tipo)
                            <option value="{{ $tipo->id_tipo_escuela }}" {{ old('id_tipo_escuela') == $tipo->id_tipo_escuela ? 'selected' : '' }}>
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
                            <option value="{{ $escuela->id_escuela }}" {{ old('id_escuela') == $escuela->id_escuela ? 'selected' : '' }}>
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
                            <option value="{{ $ubicacion->id_ubicacion }}" {{ old('id_ubicacion') == $ubicacion->id_ubicacion ? 'selected' : '' }}>
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
                            <option value="{{ $curso->id_curso }}" {{ old('id_curso') == $curso->id_curso ? 'selected' : '' }}>
                                {{ $curso->curso }} - {{ $curso->instructor->primer_nombre }} {{ $curso->instructor->primer_apellido }}
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
                            <option value="{{ $responsable->id_usuario }}" {{ old('id_responsable') == $responsable->id_usuario ? 'selected' : '' }}>
                                {{ $responsable->primer_nombre }} {{ $responsable->primer_apellido }} 
                                ({{ $responsable->rol->rol }}) - 
                                {{ $responsable->especialidad->especialidad }}
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
                    <i class="fas fa-save"></i> Crear Programa
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Información sobre el programa seleccionado -->
<div class="row mt-4" id="curso-info" style="display: none;">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle"></i> Información del Curso Seleccionado
                </h5>
            </div>
            <div class="card-body" id="curso-details">
                <!-- Se llenará dinámicamente con JavaScript -->
            </div>
        </div>
    </div>
</div>

<!-- Información adicional sobre programas de formación -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-graduation-cap"></i> Acerca de los Programas de Formación
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h6>¿Qué es un Programa de Formación?</h6>
                        <p class="text-muted">
                            Un programa de formación es la estructura organizativa que conecta una escuela, 
                            un curso específico, una ubicación y un responsable para ofrecer formación cultural 
                            a la comunidad.
                        </p>
                    </div>
                    <div class="col-md-4">
                        <h6>Tipos de Escuela</h6>
                        <ul class="text-muted">
                            <li><strong>Formal:</strong> Programas estructurados con certificación</li>
                            <li><strong>No Formal:</strong> Programas flexibles sin certificación</li>
                            <li><strong>Taller Corto:</strong> Actividades de corta duración</li>
                            <li><strong>Semillero:</strong> Programas para niños y jóvenes</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h6>Elementos Clave</h6>
                        <ul class="text-muted">
                            <li><strong>Escuela:</strong> Área disciplinaria (música, danza, etc.)</li>
                            <li><strong>Curso:</strong> Actividad específica a desarrollar</li>
                            <li><strong>Ubicación:</strong> Lugar donde se realizará</li>
                            <li><strong>Responsable:</strong> Instructor o coordinador a cargo</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Mostrar información básica del curso seleccionado
        $('#id_curso').change(function() {
            var cursoId = $(this).val();
            var cursoText = $(this).find('option:selected').text();
            
            if (cursoId && cursoText) {
                var html = `
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Curso seleccionado:</strong> ${cursoText}
                            </div>
                        </div>
                    </div>
                `;
                
                $('#curso-details').html(html);
                $('#curso-info').show();
            } else {
                $('#curso-info').hide();
            }
        });
        
        // Validación de dependencias
        $('#id_escuela').change(function() {
            var escuela = $(this).val();
            if (escuela) {
                console.log('Escuela seleccionada:', escuela);
            }
        });
        
        // Validación antes del envío
        $('form').submit(function(e) {
            var isValid = true;
            var errors = [];
            
            // Validar que todos los campos requeridos estén llenos
            $('select[required]').each(function() {
                if (!$(this).val()) {
                    isValid = false;
                    errors.push('El campo ' + $(this).prev('label').text() + ' es obligatorio');
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Por favor complete todos los campos obligatorios:\n' + errors.join('\n'));
                return false;
            }
            
            return true;
        });
        
        // Resetear validación cuando se cambia un campo
        $('select').change(function() {
            $(this).removeClass('is-invalid');
        });
        
        // Mejorar la experiencia de usuario
        $('select').on('focus', function() {
            $(this).removeClass('is-invalid');
        });
    });
</script>
@endsection