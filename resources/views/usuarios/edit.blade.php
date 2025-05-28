@extends('layouts.dashboard')

@section('title', 'Editar Usuario')

@section('actions')
<a href="{{ Auth::user()->tieneRol('Administrador') ? route('usuarios.index') : route('dashboard') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Volver
</a>
@if(Auth::user()->id_usuario == $usuario->id_usuario)
<a href="{{ route('usuarios.show', $usuario->id_usuario) }}" class="btn btn-info">
    <i class="fas fa-eye"></i> Ver Mi Perfil
</a>
@endif
@endsection

@section('content')
<!-- Información sobre permisos de edición -->
@if(Auth::user()->id_usuario == $usuario->id_usuario && !Auth::user()->tieneRol('Administrador'))
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i>
    <strong>Nota:</strong> Estás editando tu propio perfil. Algunos campos como el rol y estado solo pueden ser modificados por un administrador.
</div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('usuarios.update', $usuario->id_usuario) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="primer_nombre" class="form-label">Primer Nombre *</label>
                        <input type="text" class="form-control @error('primer_nombre') is-invalid @enderror" id="primer_nombre" name="primer_nombre" value="{{ old('primer_nombre', $usuario->primer_nombre) }}" required>
                        @error('primer_nombre')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="segundo_nombre" class="form-label">Segundo Nombre</label>
                        <input type="text" class="form-control @error('segundo_nombre') is-invalid @enderror" id="segundo_nombre" name="segundo_nombre" value="{{ old('segundo_nombre', $usuario->segundo_nombre) }}">
                        @error('segundo_nombre')
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
                        <label for="primer_apellido" class="form-label">Primer Apellido *</label>
                        <input type="text" class="form-control @error('primer_apellido') is-invalid @enderror" id="primer_apellido" name="primer_apellido" value="{{ old('primer_apellido', $usuario->primer_apellido) }}" required>
                        @error('primer_apellido')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="segundo_apellido" class="form-label">Segundo Apellido</label>
                        <input type="text" class="form-control @error('segundo_apellido') is-invalid @enderror" id="segundo_apellido" name="segundo_apellido" value="{{ old('segundo_apellido', $usuario->segundo_apellido) }}">
                        @error('segundo_apellido')
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
                        <label for="id_documento" class="form-label">Tipo de Documento *</label>
                        <select class="form-select @error('id_documento') is-invalid @enderror" id="id_documento" name="id_documento" required 
                            {{ !Auth::user()->tieneRol('Administrador') && Auth::user()->id_usuario != $usuario->id_usuario ? 'disabled' : '' }}>
                            <option value="">Seleccione...</option>
                            @foreach($documentos as $documento)
                            <option value="{{ $documento->id_documento }}" {{ old('id_documento', $usuario->id_documento) == $documento->id_documento ? 'selected' : '' }}>
                                {{ $documento->tipo_documento }}
                            </option>
                            @endforeach
                        </select>
                        @if(!Auth::user()->tieneRol('Administrador') && Auth::user()->id_usuario != $usuario->id_usuario)
                        <input type="hidden" name="id_documento" value="{{ $usuario->id_documento }}">
                        @endif
                        @error('id_documento')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="num_documento" class="form-label">Número de Documento *</label>
                        <input type="text" class="form-control @error('num_documento') is-invalid @enderror" id="num_documento" name="num_documento" value="{{ old('num_documento', $usuario->num_documento) }}" required 
                            {{ !Auth::user()->tieneRol('Administrador') && Auth::user()->id_usuario != $usuario->id_usuario ? 'readonly' : '' }}>
                        @if(!Auth::user()->tieneRol('Administrador') && Auth::user()->id_usuario != $usuario->id_usuario)
                        <input type="hidden" name="num_documento" value="{{ $usuario->num_documento }}">
                        @endif
                        @error('num_documento')
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
                        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento *</label>
                        <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $usuario->fecha_nacimiento instanceof \Carbon\Carbon ? $usuario->fecha_nacimiento->format('Y-m-d') : $usuario->fecha_nacimiento) }}" required>
                        @error('fecha_nacimiento')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_genero" class="form-label">Género *</label>
                        <select class="form-select @error('id_genero') is-invalid @enderror" id="id_genero" name="id_genero" required>
                            <option value="">Seleccione...</option>
                            @foreach($generos as $genero)
                            <option value="{{ $genero->id_genero }}" {{ old('id_genero', $usuario->id_genero) == $genero->id_genero ? 'selected' : '' }}>
                                {{ $genero->genero }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_genero')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-12">
                    <h5>Ubicación</h5>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="id_pais" class="form-label">País *</label>
                        <select class="form-select @error('id_pais') is-invalid @enderror" id="id_pais" name="id_pais" required>
                            @foreach($paises as $pais)
                            <option value="{{ $pais->id_pais }}" {{ old('id_pais', $usuario->lugarNacimiento->id_pais) == $pais->id_pais ? 'selected' : '' }}>
                                {{ $pais->pais }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_pais')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="id_departamento" class="form-label">Departamento de Nacimiento *</label>
                        <select class="form-select @error('id_departamento') is-invalid @enderror" id="id_departamento" name="id_departamento" required>
                            @foreach($departamentos as $departamento)
                            <option value="{{ $departamento->id_dpto }}" {{ old('id_departamento', $usuario->lugarNacimiento->id_dpto) == $departamento->id_dpto ? 'selected' : '' }}>
                                {{ $departamento->departamento }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_departamento')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="id_municipio" class="form-label">Municipio de Nacimiento *</label>
                        <select class="form-select @error('id_municipio') is-invalid @enderror" id="id_municipio" name="id_municipio" required>
                            @foreach($municipios as $municipio)
                            <option value="{{ $municipio->id_mpio }}" {{ old('id_municipio', $usuario->lugarNacimiento->id_mpio) == $municipio->id_mpio ? 'selected' : '' }}>
                                {{ $municipio->municipio }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_municipio')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row mb-3">
                <!-- Solo los administradores pueden cambiar el rol -->
                @if(Auth::user()->tieneRol('Administrador'))
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="id_rol" class="form-label">Rol *</label>
                        <select class="form-select @error('id_rol') is-invalid @enderror" id="id_rol" name="id_rol" required>
                            <option value="">Seleccione...</option>
                            @foreach($roles as $rol)
                            <option value="{{ $rol->id_rol }}" {{ old('id_rol', $usuario->id_rol) == $rol->id_rol ? 'selected' : '' }}>
                                {{ $rol->rol }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_rol')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                @else
                <input type="hidden" name="id_rol" value="{{ $usuario->id_rol }}">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="rol_display" class="form-label">Rol</label>
                        <input type="text" class="form-control" id="rol_display" value="{{ $usuario->rol->rol }}" readonly>
                        <small class="text-muted">Solo un administrador puede cambiar tu rol</small>
                    </div>
                </div>
                @endif
                
                <!-- La especialidad pueden editarla todos -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="id_especialidad" class="form-label">Especialidad *</label>
                        <select class="form-select @error('id_especialidad') is-invalid @enderror" id="id_especialidad" name="id_especialidad" required>
                            <option value="">Seleccione...</option>
                            @foreach($especialidades as $especialidad)
                            <option value="{{ $especialidad->id_especialidad }}" {{ old('id_especialidad', $usuario->id_especialidad) == $especialidad->id_especialidad ? 'selected' : '' }}>
                                {{ $especialidad->especialidad }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_especialidad')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                
                <!-- Solo los administradores pueden cambiar el estado -->
                @if(Auth::user()->tieneRol('Administrador'))
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="id_estado" class="form-label">Estado *</label>
                        <select class="form-select @error('id_estado') is-invalid @enderror" id="id_estado" name="id_estado" required>
                            <option value="">Seleccione...</option>
                            @foreach($estados as $estado)
                            <option value="{{ $estado->id_estado }}" {{ old('id_estado', $usuario->id_estado) == $estado->id_estado ? 'selected' : '' }}>
                                {{ $estado->estado }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_estado')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                @else
                <input type="hidden" name="id_estado" value="{{ $usuario->id_estado }}">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="estado_display" class="form-label">Estado</label>
                        <input type="text" class="form-control" id="estado_display" value="{{ $usuario->estado->estado }}" readonly>
                        <small class="text-muted">Solo un administrador puede cambiar tu estado</small>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Información de Contacto - Todos pueden editarla -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <h5>Información de Contacto</h5>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono *</label>
                        <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono', $usuario->contacto->telefono) }}" required>
                        @error('telefono')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $usuario->contacto->email) }}" required>
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección *</label>
                        <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ old('direccion', $usuario->contacto->direccion) }}" required>
                        @error('direccion')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Cambio de Contraseña -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <h5>Cambiar Contraseña (Opcional)</h5>
                    <p class="text-muted">Si no deseas cambiar tu contraseña, deja estos campos vacíos.</p>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="password" class="form-label">Nueva Contraseña</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                        <small class="form-text text-muted">Mínimo 8 caracteres</small>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <div>
                            @if(Auth::user()->id_usuario == $usuario->id_usuario)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="confirm_changes" required>
                                <label class="form-check-label" for="confirm_changes">
                                    Confirmo que la información ingresada es correcta
                                </label>
                            </div>
                            @endif
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Actualizar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Información adicional para usuarios que editan su propio perfil -->
@if(Auth::user()->id_usuario == $usuario->id_usuario)
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card border-info">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Información Importante</h5>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li><strong>Información Personal:</strong> Puedes actualizar tu nombre, fecha de nacimiento, género y ubicación.</li>
                    <li><strong>Contacto:</strong> Mantén actualizada tu información de contacto para recibir notificaciones importantes.</li>
                    <li><strong>Especialidad:</strong> Puedes cambiar tu especialidad de interés.</li>
                    <li><strong>Contraseña:</strong> Se recomienda cambiar tu contraseña periódicamente por seguridad.</li>
                    <li><strong>Limitaciones:</strong> Solo los administradores pueden cambiar roles y estados de usuarios.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
    // Cargar departamentos al seleccionar país
    $(document).ready(function() {
        $('#id_pais').change(function() {
            var id_pais = $(this).val();
            if(id_pais) {
                $.ajax({
                    url: '/departamentos/' + id_pais,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('#id_departamento').empty();
                        $('#id_departamento').append('<option value="">Seleccione un departamento</option>');
                        $.each(data, function(key, value) {
                            $('#id_departamento').append('<option value="'+ value.id_dpto +'">'+ value.departamento +'</option>');
                        });
                        $('#id_municipio').empty();
                        $('#id_municipio').append('<option value="">Seleccione primero un departamento</option>');
                    }
                });
            } else {
                $('#id_departamento').empty();
                $('#id_departamento').append('<option value="">Seleccione primero un país</option>');
                $('#id_municipio').empty();
                $('#id_municipio').append('<option value="">Seleccione primero un departamento</option>');
            }
        });
        
        // Cargar municipios al seleccionar departamento
        $('#id_departamento').change(function() {
            var id_dpto = $(this).val();
            if(id_dpto) {
                $.ajax({
                    url: '/municipios/' + id_dpto,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('#id_municipio').empty();
                        $('#id_municipio').append('<option value="">Seleccione un municipio</option>');
                        $.each(data, function(key, value) {
                            $('#id_municipio').append('<option value="'+ value.id_mpio +'">'+ value.municipio +'</option>');
                        });
                    }
                });
            } else {
                $('#id_municipio').empty();
                $('#id_municipio').append('<option value="">Seleccione primero un departamento</option>');
            }
        });
        
        // Validación de contraseñas
        $('#password, #password_confirmation').on('keyup', function() {
            var password = $('#password').val();
            var confirmPassword = $('#password_confirmation').val();
            
            if (password && confirmPassword && password !== confirmPassword) {
                $('#password_confirmation').addClass('is-invalid');
                if (!$('#password_confirmation').siblings('.invalid-feedback').length) {
                    $('#password_confirmation').after('<div class="invalid-feedback">Las contraseñas no coinciden</div>');
                }
            } else {
                $('#password_confirmation').removeClass('is-invalid');
                $('#password_confirmation').siblings('.invalid-feedback').remove();
            }
        });
        
        // Validación de longitud de contraseña
        $('#password').on('keyup', function() {
            var password = $(this).val();
            
            if (password.length > 0 && password.length < 8) {
                $(this).addClass('is-invalid');
                if (!$(this).siblings('.invalid-feedback').length) {
                    $(this).after('<div class="invalid-feedback">La contraseña debe tener al menos 8 caracteres</div>');
                }
            } else {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').remove();
            }
        });
    });
</script>
@endsection