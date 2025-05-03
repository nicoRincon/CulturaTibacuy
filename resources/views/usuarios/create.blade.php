@extends('layouts.dashboard')

@section('title', 'Crear Usuario')

@section('actions')
<a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Volver
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('usuarios.store') }}" method="POST">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="primer_nombre" class="form-label">Primer Nombre *</label>
                        <input type="text" class="form-control @error('primer_nombre') is-invalid @enderror" id="primer_nombre" name="primer_nombre" value="{{ old('primer_nombre') }}" required>
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
                        <input type="text" class="form-control @error('segundo_nombre') is-invalid @enderror" id="segundo_nombre" name="segundo_nombre" value="{{ old('segundo_nombre') }}">
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
                        <input type="text" class="form-control @error('primer_apellido') is-invalid @enderror" id="primer_apellido" name="primer_apellido" value="{{ old('primer_apellido') }}" required>
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
                        <input type="text" class="form-control @error('segundo_apellido') is-invalid @enderror" id="segundo_apellido" name="segundo_apellido" value="{{ old('segundo_apellido') }}">
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
                        <select class="form-select @error('id_documento') is-invalid @enderror" id="id_documento" name="id_documento" required>
                            <option value="">Seleccione...</option>
                            @foreach($documentos as $documento)
                            <option value="{{ $documento->Id_Documento }}" {{ old('id_documento') == $documento->Id_Documento ? 'selected' : '' }}>
                                {{ $documento->Tipo_Documento }}
                            </option>
                            @endforeach
                        </select>
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
                        <input type="text" class="form-control @error('num_documento') is-invalid @enderror" id="num_documento" name="num_documento" value="{{ old('num_documento') }}" required>
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
                        <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required>
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
                            <option value="{{ $genero->Id_Genero }}" {{ old('id_genero') == $genero->Id_Genero ? 'selected' : '' }}>
                                {{ $genero->Genero }}
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
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="id_pais" class="form-label">País de Nacimiento *</label>
                        <select class="form-select @error('id_pais') is-invalid @enderror" id="id_pais" name="id_pais" required>
                            <option value="">Seleccione...</option>
                            @foreach($paises as $pais)
                            <option value="{{ $pais->Id_País }}" {{ old('id_pais') == $pais->Id_País ? 'selected' : '' }}>
                                {{ $pais->País }}
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
                            <option value="">Seleccione primero un país</option>
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
                            <option value="">Seleccione primero un departamento</option>
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
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_rol" class="form-label">Rol *</label>
                        <select class="form-select @error('id_rol') is-invalid @enderror" id="id_rol" name="id_rol" required>
                            <option value="">Seleccione...</option>
                            @foreach($roles as $rol)
                            <option value="{{ $rol->Id_Rol }}" {{ old('id_rol') == $rol->Id_Rol ? 'selected' : '' }}>
                                {{ $rol->Rol }}
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
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_especialidad" class="form-label">Especialidad *</label>
                        <select class="form-select @error('id_especialidad') is-invalid @enderror" id="id_especialidad" name="id_especialidad" required>
                            <option value="">Seleccione...</option>
                            @foreach($especialidades as $especialidad)
                            <option value="{{ $especialidad->Id_Especialidad }}" {{ old('id_especialidad') == $especialidad->Id_Especialidad ? 'selected' : '' }}>
                                {{ $especialidad->Especialidad }}
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
            </div>
            
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono *</label>
                        <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono') }}" required>
                        @error('telefono')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico *</label>
                        <input type="email" class="form-control @error('correo') is-invalid @enderror" id="correo" name="correo" value="{{ old('correo') }}" required>
                        @error('correo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección *</label>
                        <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ old('direccion') }}" required>
                        @error('direccion')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña *</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Contraseña *</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
            </div>
            
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Guardar</button>
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
                            $('#id_departamento').append('<option value="'+ value.Id_Dpto +'">'+ value.Departamento +'</option>');
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
                            $('#id_municipio').append('<option value="'+ value.Id_Mpio +'">'+ value.Municipio +'</option>');
                        });
                    }
                });
            } else {
                $('#id_municipio').empty();
                $('#id_municipio').append('<option value="">Seleccione primero un departamento</option>');
            }
        });
    });
</script>
@endsection