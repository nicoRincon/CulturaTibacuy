@extends('layouts.dashboard')

@section('title', 'Editar Usuario')

@section('actions')
<a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Volver
</a>
@endsection

@section('content')
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
                        <select class="form-select @error('id_documento') is-invalid @enderror" id="id_documento" name="id_documento" required {{ !Auth::user()->tieneRol('Administrador') && Auth::user()->id_usuario != $usuario->id_usuario ? 'disabled' : '' }}>
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
                        <input type="text" class="form-control @error('num_documento') is-invalid @enderror" id="num_documento" name="num_documento" value="{{ old('num_documento', $usuario->num_documento) }}" required {{ !Auth::user()->tieneRol('Administrador') && Auth::user()->id_usuario != $usuario->id_usuario ? 'readonly' : '' }}>
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
                        <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $usuario->fecha_nacimiento instanceof \Carbon\Carbon ? $usuario->fecha_nacimiento->format('Y-m-d') : $usuario->fecha_nacimiento) }}" required {{ !Auth::user()->tieneRol('Administrador') && Auth::user()->id_usuario != $usuario->id_usuario ? 'readonly' : '' }}>
                        @if(!Auth::user()->tieneRol('Administrador') && Auth::user()->id_usuario != $usuario->id_usuario)
                        <input type="hidden" name="fecha_nacimiento" value="{{ $usuario->fecha_nacimiento instanceof \Carbon\Carbon ? $usuario->fecha_nacimiento->format('Y-m-d') : $usuario->fecha_nacimiento }}">
                        @endif
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
                        <select class="form-select @error('id_genero') is-invalid @enderror" id="id_genero" name="id_genero" required {{ !Auth::user()->tieneRol('Administrador') && Auth::user()->id_usuario != $usuario->id_usuario ? 'disabled' : '' }}>
                            <option value="">Seleccione...</option>
                            @foreach($generos as $genero)
                            <option value="{{ $genero->id_genero }}" {{ old('id_genero', $usuario->id_genero) == $genero->id_genero ? 'selected' : '' }}>
                                {{ $genero->genero }}
                            </option>
                            @endforeach
                        </select>
                        @if(!Auth::user()->tieneRol('Administrador') && Auth::user()->id_usuario != $usuario->id_usuario)
                        <input type="hidden" name="id_genero" value="{{ $usuario->id_genero }}">
                        @endif
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
                        <select class="form-select @error('id_pais') is-invalid @enderror" id="id_pais" name="id_pais" required {{ !Auth::user()->tieneRol('Administrador') && Auth::user()->id_usuario != $usuario->id_usuario ? 'disabled' : '' }}>
                            @foreach($paises as $pais)
                            <option value="{{ $pais->id_pais }}" {{ old('id_pais', $usuario->lugarNacimiento->id_pais) == $pais->id_pais ? 'selected' : '' }}>
                                {{ $pais->pais }}
                            </option>
                            @endforeach
                        </select>
                        @if(!Auth::user()->tieneRol('Administrador') && Auth::user()->id_usuario != $usuario->id_usuario)
                        <input type="hidden" name="id_pais" value="{{ $usuario->lugarNacimiento->id_pais }}">
                        @endif
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
                        <select class="form-select @error('id_departamento') is-invalid @enderror" id="id_departamento" name="id_departamento" required {{ !Auth::user()->tieneRol('Administrador') && Auth::user()->id_usuario != $usuario->id_usuario ? 'disabled' : '' }}>
                            @foreach($departamentos as $departamento)
                            <option value="{{ $departamento->id_dpto }}" {{ old('id_departamento', $usuario->lugarNacimiento->id_dpto) == $departamento->id_dpto ? 'selected' : '' }}>
                                {{ $departamento->departamento }}
                            </option>
                            @endforeach
                        </select>
                        @if(!Auth::user()->tieneRol('Administrador') && Auth::user()->id_usuario != $usuario->id_usuario)
                        <input type="hidden" name="id_departamento" value="{{ $usuario->lugarNacimiento->id_dpto }}">
                        @endif
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
                        <select class="form-select @error('id_municipio') is-invalid @enderror" id="id_municipio" name="id_municipio" required {{ !Auth::user()->tieneRol('Administrador') && Auth::user()->id_usuario != $usuario->id_usuario ? 'disabled' : '' }}>
                            @foreach($municipios as $municipio)
                            <option value="{{ $municipio->id_mpio }}" {{ old('id_municipio', $usuario->lugarNacimiento->id_mpio) == $municipio->id_mpio ? 'selected' : '' }}>
                                {{ $municipio->municipio }}
                            </option>
                            @endforeach
                        </select>
                        @if(!Auth::user()->tieneRol('Administrador') && Auth::user()->id_usuario != $usuario->id_usuario)
                        <input type="hidden" name="id_municipio" value="{{ $usuario->lugarNacimiento->id_mpio }}">
                        @endif
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
                @endif
                
                <!-- La especialidad solo se muestra para docentes o administradores -->
                @if(Auth::user()->tieneRol('Administrador') || $usuario->tieneRol('Instructor'))
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="id_especialidad" class="form-label">Especialidad *</label>
                        <select class="form-select @error('id_especialidad') is-invalid @enderror" id="id_especialidad" name="id_especialidad" required {{ !Auth::user()->tieneRol('Administrador') && $usuario->id_usuario != Auth::user()->id_usuario ? 'disabled' : '' }}>
                            <option value="">Seleccione...</option>
                            @foreach($especialidades as $especialidad)
                            <option value="{{ $especialidad->id_especialidad }}" {{ old('id_especialidad', $usuario->id_especialidad) == $especialidad->id_especialidad ? 'selected' : '' }}>
                                {{ $especialidad->especialidad }}
                            </option>
                            @endforeach
                        </select>
                        @if(!Auth::user()->tieneRol('Administrador') && $usuario->id_usuario != Auth::user()->id_usuario)
                        <input type="hidden" name="id_especialidad" value="{{ $usuario->id_especialidad }}">
                        @endif
                        @error('id_especialidad')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                @else
                <input type="hidden" name="id_especialidad" value="{{ $usuario->id_especialidad }}">
                @endif
                
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
                @endif
            </div>
            
            <div class="row mb-3">
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
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="password" class="form-label">Nueva Contraseña</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                        <small class="form-text text-muted">Dejar en blanco para mantener la contraseña actual</small>
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
            
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>
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
        
        // Mostrar/ocultar especialidad basado en el rol
        $('#id_rol').change(function() {
            var rolId = $(this).val();
            // Obtener el texto del rol seleccionado
            var rolText = $('#id_rol option:selected').text().trim();
            
            if (rolText === 'Instructor') {
                $('.especialidad-container').show();
                $('#id_especialidad').prop('required', true);
            } else {
                $('.especialidad-container').hide();
                $('#id_especialidad').prop('required', false);
            }
        });
        
        // Trigger para el cambio inicial
        $('#id_rol').trigger('change');
    });
</script>
@endsection