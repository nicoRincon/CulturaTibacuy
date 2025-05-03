@extends('layouts.dashboard')

@section('title', 'Crear Evaluación')

@section('actions')
<a href="{{ route('evaluaciones.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Volver
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('evaluaciones.store') }}" method="POST">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_curso" class="form-label">Curso *</label>
                        <select class="form-select @error('id_curso') is-invalid @enderror" id="id_curso" name="id_curso" required>
                            <option value="">Seleccione...</option>
                            @foreach($cursos as $curso)
                            <option value="{{ $curso->Id_Curso }}" {{ old('id_curso') == $curso->Id_Curso ? 'selected' : '' }}>
                                {{ $curso->Curso }}
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
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_usuario" class="form-label">Estudiante *</label>
                        <select class="form-select @error('id_usuario') is-invalid @enderror" id="id_usuario" name="id_usuario" required>
                            <option value="">Seleccione primero un curso</option>
                        </select>
                        @error('id_usuario')
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
                        <label for="nota" class="form-label">Nota (0-5) *</label>
                        <input type="number" class="form-control @error('nota') is-invalid @enderror" id="nota" name="nota" value="{{ old('nota') }}" min="0" max="5" step="0.1" required>
                        @error('nota')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="comentarios" class="form-label">Comentarios</label>
                <textarea class="form-control @error('comentarios') is-invalid @enderror" id="comentarios" name="comentarios" rows="3">{{ old('comentarios') }}</textarea>
                @error('comentarios')
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

@section('scripts')
<script>
    // Cargar estudiantes al seleccionar curso
    $(document).ready(function() {
        $('#id_curso').change(function() {
            var id_curso = $(this).val();
            if(id_curso) {
                $.ajax({
                    url: '/estudiantes/' + id_curso,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('#id_usuario').empty();
                        $('#id_usuario').append('<option value="">Seleccione un estudiante</option>');
                        $.each(data, function(key, value) {
                            $('#id_usuario').append('<option value="'+ value.id +'">'+ value.nombre +' ('+ value.documento +')</option>');
                        });
                    }
                });
            } else {
                $('#id_usuario').empty();
                $('#id_usuario').append('<option value="">Seleccione primero un curso</option>');
            }
        });
    });
</script>
@endsection