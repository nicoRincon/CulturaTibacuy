@extends('layouts.dashboard')

@section('title', 'Crear Escuela')

@section('actions')
<a href="{{ route('escuelas.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Volver
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('escuelas.store') }}" method="POST">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de la Escuela *</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                        @error('nombre')
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
                        <label for="descripcion" class="form-label">Descripción *</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion') }}</textarea>
                        <small class="form-text text-muted">Describa los objetivos y características principales de la escuela.</small>
                        @error('descripcion')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Escuela
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Información adicional sobre escuelas -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle"></i> Información sobre Escuelas
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>¿Qué es una Escuela?</h6>
                        <p class="text-muted">
                            Las escuelas son unidades organizativas que agrupan diferentes programas de formación 
                            relacionados con una disciplina específica (música, danza, teatro, artes plásticas, etc.).
                        </p>
                        <h6>Ejemplos de Escuelas</h6>
                        <ul class="text-muted">
                            <li>Escuela de Música</li>
                            <li>Escuela de Danza</li>
                            <li>Escuela de Teatro</li>
                            <li>Escuela de Artes Plásticas</li>
                            <li>Escuela de Deportes</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Funciones de las Escuelas</h6>
                        <ul class="text-muted">
                            <li>Organizar y estructurar los programas de formación</li>
                            <li>Definir los objetivos educativos por área</li>
                            <li>Facilitar la gestión administrativa</li>
                            <li>Promover la identidad cultural de cada disciplina</li>
                        </ul>
                        <div class="alert alert-info mt-3">
                            <small>
                                <i class="fas fa-lightbulb"></i>
                                <strong>Consejo:</strong> Una buena descripción debe incluir los objetivos, 
                                metodología y población objetivo de la escuela.
                            </small>
                        </div>
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
        // Validación en tiempo real del nombre
        $('#nombre').on('input', function() {
            var nombre = $(this).val().trim();
            if (nombre.length < 3) {
                $(this).addClass('is-invalid');
                if (!$(this).siblings('.invalid-feedback').length) {
                    $(this).after('<div class="invalid-feedback">El nombre debe tener al menos 3 caracteres.</div>');
                }
            } else {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').remove();
            }
        });
        
        // Validación en tiempo real de la descripción
        $('#descripcion').on('input', function() {
            var descripcion = $(this).val().trim();
            if (descripcion.length < 10) {
                $(this).addClass('is-invalid');
                if (!$(this).siblings('.invalid-feedback').length) {
                    $(this).after('<div class="invalid-feedback">La descripción debe tener al menos 10 caracteres.</div>');
                }
            } else {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').remove();
            }
        });
        
        // Contador de caracteres para la descripción
        $('#descripcion').on('input', function() {
            var maxLength = 255;
            var currentLength = $(this).val().length;
            var remaining = maxLength - currentLength;
            
            if (!$(this).siblings('.char-counter').length) {
                $(this).after('<small class="char-counter text-muted"></small>');
            }
            
            $(this).siblings('.char-counter').text('Caracteres restantes: ' + remaining);
            
            if (remaining < 0) {
                $(this).addClass('is-invalid');
                $(this).siblings('.char-counter').removeClass('text-muted').addClass('text-danger');
            } else {
                $(this).removeClass('is-invalid');
                $(this).siblings('.char-counter').removeClass('text-danger').addClass('text-muted');
            }
        });
    });
</script>
@endsection