@extends('layouts.master')

@section('title', 'Registro')

@section('styles')
<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        margin: 0;
    }
    
    .bg-image {
        background-image: url('https://images.unsplash.com/photo-1519389950473-47ba0277781c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    
    .card {
        backdrop-filter: blur(30px);
        background: rgba(255, 255, 255, 0.95) !important;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .shadow-5-strong {
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
    }
    
    .form-outline {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .form-outline input,
    .form-outline select {
        border: 2px solid #e0e6ed;
        border-radius: 0.375rem;
        transition: all 0.3s ease;
        width: 100%;
        padding: 12px 16px;
        font-size: 16px;
        background: white;
    }
    
    .form-outline input:focus,
    .form-outline select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        outline: none;
    }
    
    .form-outline input.is-invalid,
    .form-outline select.is-invalid {
        border-color: #dc3545;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 0.5rem;
        padding: 12px 30px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }
    
    .btn-outline-primary {
        border: 2px solid #667eea;
        color: #667eea;
        border-radius: 0.5rem;
        padding: 10px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-outline-primary:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        transform: translateY(-2px);
    }
    
    .btn-link {
        color: #667eea;
        transition: all 0.3s ease;
    }
    
    .btn-link:hover {
        color: #764ba2;
        transform: scale(1.05);
    }
    
    .navbar {
        background: transparent !important;
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .navbar-brand {
        color: white !important;
        font-weight: bold;
        font-size: 1.5rem;
    }
    
    .nav-link {
        color: white !important;
    }
    
    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }
    
    .invalid-feedback {
        display: block;
        margin-top: 0.25rem;
    }
    
    .alert {
        border-radius: 0.5rem;
        border: none;
    }
    
    .form-label {
        position: absolute;
        top: 50%;
        left: 16px;
        transform: translateY(-50%);
        transition: all 0.3s ease;
        pointer-events: none;
        color: #6c757d;
        background: white;
        padding: 0 5px;
        font-size: 16px;
    }
    
    .form-label.active,
    .form-outline input:focus + .form-label,
    .form-outline input:valid + .form-label,
    .form-outline input:not(:placeholder-shown) + .form-label,
    .form-outline select:focus + .form-label,
    .form-outline select:valid + .form-label {
        top: 0;
        font-size: 0.75rem;
        color: #667eea;
        transform: translateY(-50%);
    }
    
    .form-section {
        background: rgba(102, 126, 234, 0.05);
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border-left: 4px solid #667eea;
    }
    
    .section-title {
        color: #667eea;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }
    
    .section-title i {
        margin-right: 0.5rem;
    }
    
    @keyframes ripple {
        0% {
            transform: scale(0);
            opacity: 1;
        }
        100% {
            transform: scale(20);
            opacity: 0;
        }
    }
    
    /* Responsivo */
    @media (max-width: 768px) {
        .card {
            margin: -50px 1rem 0 1rem !important;
        }
        
        .bg-image {
            height: 200px !important;
        }
    }
</style>
@endsection

@section('content-wrapper')
<!-- Section: Design Block -->
<section class="text-center">
    <!-- Background image -->
    <div class="p-5 bg-image" style="height: 300px;"></div>
    <!-- Background image -->
    
    <div class="card mx-4 mx-md-5 shadow-5-strong bg-body-tertiary" style="margin-top: -100px;">
        <div class="card-body py-5 px-md-5">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-10">
                    <h2 class="fw-bold mb-5 text-primary">
                        <i class="fas fa-user-plus me-2"></i>
                        Crear Cuenta
                    </h2>
                    
                    <!-- Mostrar errores de validación -->
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <h6><i class="fas fa-exclamation-triangle me-2"></i>Por favor corrige los siguientes errores:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <!-- Información Personal -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="fas fa-user"></i>
                                Información Personal
                            </h5>
                            
                            <div class="row">
                                <!-- Primer Nombre -->
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input 
                                            type="text" 
                                            id="primer_nombre" 
                                            name="primer_nombre"
                                            class="form-control @error('primer_nombre') is-invalid @enderror" 
                                            value="{{ old('primer_nombre') }}" 
                                            required 
                                            autocomplete="primer_nombre" 
                                            autofocus
                                            placeholder=" "
                                        />
                                        <label class="form-label" for="primer_nombre">
                                            <i class="fas fa-user me-1"></i>
                                            Primer Nombre *
                                        </label>
                                        @error('primer_nombre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Segundo Nombre -->
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input 
                                            type="text" 
                                            id="segundo_nombre" 
                                            name="segundo_nombre"
                                            class="form-control @error('segundo_nombre') is-invalid @enderror" 
                                            value="{{ old('segundo_nombre') }}"
                                            autocomplete="segundo_nombre"
                                            placeholder=" "
                                        />
                                        <label class="form-label" for="segundo_nombre">
                                            <i class="fas fa-user me-1"></i>
                                            Segundo Nombre
                                        </label>
                                        @error('segundo_nombre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <!-- Primer Apellido -->
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input 
                                            type="text" 
                                            id="primer_apellido" 
                                            name="primer_apellido"
                                            class="form-control @error('primer_apellido') is-invalid @enderror" 
                                            value="{{ old('primer_apellido') }}" 
                                            required 
                                            autocomplete="primer_apellido"
                                            placeholder=" "
                                        />
                                        <label class="form-label" for="primer_apellido">
                                            <i class="fas fa-user me-1"></i>
                                            Primer Apellido *
                                        </label>
                                        @error('primer_apellido')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Segundo Apellido -->
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input 
                                            type="text" 
                                            id="segundo_apellido" 
                                            name="segundo_apellido"
                                            class="form-control @error('segundo_apellido') is-invalid @enderror" 
                                            value="{{ old('segundo_apellido') }}"
                                            autocomplete="segundo_apellido"
                                            placeholder=" "
                                        />
                                        <label class="form-label" for="segundo_apellido">
                                            <i class="fas fa-user me-1"></i>
                                            Segundo Apellido
                                        </label>
                                        @error('segundo_apellido')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Fecha de Nacimiento -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input 
                                            type="date" 
                                            id="fecha_nacimiento" 
                                            name="fecha_nacimiento"
                                            class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                                            value="{{ old('fecha_nacimiento') }}"
                                            required
                                            max="{{ date('Y-m-d', strtotime('-13 years')) }}"
                                        />
                                        <label class="form-label active" for="fecha_nacimiento">
                                            <i class="fas fa-calendar me-1"></i>
                                            Fecha de Nacimiento *
                                        </label>
                                        @error('fecha_nacimiento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información de Identificación -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="fas fa-id-card"></i>
                                Documento de Identidad
                            </h5>
                            
                            <div class="row">
                                <!-- Tipo de Documento -->
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <select 
                                            id="tipo_documento" 
                                            name="tipo_documento"
                                            class="form-control @error('tipo_documento') is-invalid @enderror" 
                                            required
                                        >
                                            <option value="">Seleccionar...</option>
                                            <option value="CC" {{ old('tipo_documento') == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                                            <option value="TI" {{ old('tipo_documento') == 'TI' ? 'selected' : '' }}>Tarjeta de Identidad</option>
                                            <option value="CE" {{ old('tipo_documento') == 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
                                            <option value="PA" {{ old('tipo_documento') == 'PA' ? 'selected' : '' }}>Pasaporte</option>
                                        </select>
                                        <label class="form-label" for="tipo_documento">
                                            <i class="fas fa-id-card me-1"></i>
                                            Tipo de Documento *
                                        </label>
                                        @error('tipo_documento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Número de Documento -->
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input 
                                            type="text" 
                                            id="num_documento" 
                                            name="num_documento"
                                            class="form-control @error('num_documento') is-invalid @enderror" 
                                            value="{{ old('num_documento') }}" 
                                            required 
                                            autocomplete="num_documento"
                                            placeholder=" "
                                        />
                                        <label class="form-label" for="num_documento">
                                            <i class="fas fa-hashtag me-1"></i>
                                            Número de Documento *
                                        </label>
                                        @error('num_documento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información de Contacto -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="fas fa-address-book"></i>
                                Información de Contacto
                            </h5>
                            
                            <div class="row">
                                <!-- Email -->
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input 
                                            type="email" 
                                            id="email" 
                                            name="email"
                                            class="form-control @error('email') is-invalid @enderror" 
                                            value="{{ old('email') }}" 
                                            required 
                                            autocomplete="email"
                                            placeholder=" "
                                        />
                                        <label class="form-label" for="email">
                                            <i class="fas fa-envelope me-1"></i>
                                            Correo Electrónico *
                                        </label>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Teléfono -->
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input 
                                            type="tel" 
                                            id="telefono" 
                                            name="telefono"
                                            class="form-control @error('telefono') is-invalid @enderror" 
                                            value="{{ old('telefono') }}" 
                                            required
                                            pattern="[0-9]{10}"
                                            placeholder=" "
                                        />
                                        <label class="form-label" for="telefono">
                                            <i class="fas fa-phone me-1"></i>
                                            Teléfono *
                                        </label>
                                        @error('telefono')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Formato: 3001234567 (10 dígitos)</small>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Dirección -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-outline">
                                        <input 
                                            type="text" 
                                            id="direccion" 
                                            name="direccion"
                                            class="form-control @error('direccion') is-invalid @enderror" 
                                            value="{{ old('direccion') }}" 
                                            required
                                            placeholder=" "
                                        />
                                        <label class="form-label" for="direccion">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            Dirección *
                                        </label>
                                        @error('direccion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información de Seguridad -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="fas fa-lock"></i>
                                Información de Seguridad
                            </h5>
                            
                            <div class="row">
                                <!-- Password -->
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input 
                                            type="password" 
                                            id="password" 
                                            name="password"
                                            class="form-control @error('password') is-invalid @enderror" 
                                            required 
                                            autocomplete="new-password"
                                            placeholder=" "
                                            minlength="8"
                                        />
                                        <label class="form-label" for="password">
                                            <i class="fas fa-lock me-1"></i>
                                            Contraseña *
                                        </label>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Mínimo 8 caracteres</small>
                                    </div>
                                </div>
                                
                                <!-- Confirm Password -->
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input 
                                            type="password" 
                                            id="password_confirmation" 
                                            name="password_confirmation"
                                            class="form-control" 
                                            required 
                                            autocomplete="new-password"
                                            placeholder=" "
                                            minlength="8"
                                        />
                                        <label class="form-label" for="password_confirmation">
                                            <i class="fas fa-lock me-1"></i>
                                            Confirmar Contraseña *
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Términos y Condiciones -->
                        <div class="form-check d-flex justify-content-center mb-4">
                            <input 
                                class="form-check-input me-2" 
                                type="checkbox" 
                                value="" 
                                id="terminos" 
                                required
                            />
                            <label class="form-check-label" for="terminos">
                                Acepto los 
                                <a href="#" class="text-primary">términos y condiciones</a> 
                                y la 
                                <a href="#" class="text-primary">política de privacidad</a>
                            </label>
                        </div>
                        
                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-block mb-4 w-100">
                            <i class="fas fa-user-plus me-2"></i>
                            Crear Cuenta
                        </button>
                        
                        <!-- Login link -->
                        <div class="text-center">
                            <div class="mt-3 pt-3 border-top">
                                <p class="mb-0">¿Ya tienes una cuenta?</p>
                                <a href="{{ route('login') }}" class="btn btn-outline-primary mt-2">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    Iniciar Sesión
                                </a>
                            </div>
                        </div>
                        
                        <!-- Información adicional -->
                        <div class="text-center mt-4">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Al registrarte, formarás parte de la comunidad cultural de Tibacuy
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Información sobre las escuelas disponibles -->
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">
                    <div class="card-body p-4">
                        <h4 class="text-center mb-4 text-primary">
                            <i class="fas fa-graduation-cap me-2"></i>
                            Escuelas Disponibles
                        </h4>
                        <div class="row text-center">
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="p-3">
                                    <i class="fas fa-music fa-3x text-primary mb-3"></i>
                                    <h6 class="fw-bold">Música</h6>
                                    <small class="text-muted">Piano, guitarra, canto</small>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="p-3">
                                    <i class="fas fa-masks-theater fa-3x text-primary mb-3"></i>
                                    <h6 class="fw-bold">Teatro</h6>
                                    <small class="text-muted">Actuación y expresión</small>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="p-3">
                                    <i class="fas fa-palette fa-3x text-primary mb-3"></i>
                                    <h6 class="fw-bold">Artes Plásticas</h6>
                                    <small class="text-muted">Pintura y dibujo</small>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="p-3">
                                    <i class="fas fa-running fa-3x text-primary mb-3"></i>
                                    <h6 class="fw-bold">Danza</h6>
                                    <small class="text-muted">Folclor y bailes modernos</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Section: Design Block -->
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Animación de entrada para los elementos
    $('.card').hide().fadeIn(1000);
    
    // Efecto de floating labels mejorado
    function updateFloatingLabel($input) {
        const $label = $input.siblings('label');
        const hasValue = $input.val() !== '' && $input.val() !== null;
        const isFocused = $input.is(':focus');
        const isSelect = $input.is('select');
        const isDate = $input.attr('type') === 'date';
        
        if (isFocused || hasValue || isSelect || isDate) {
            $label.addClass('active');
        } else {
            $label.removeClass('active');
        }
    }
    
    // Aplicar floating labels a todos los campos
    $('.form-outline input, .form-outline select').on('focus blur input change', function() {
        updateFloatingLabel($(this));
    });
    
    // Inicializar labels para campos con valor
    $('.form-outline input, .form-outline select').each(function() {
        updateFloatingLabel($(this));
    });
    
    // Validación en tiempo real del teléfono
    $('#telefono').on('input', function() {
        let value = $(this).val().replace(/\D/g, ''); // Solo números
        if (value.length > 10) {
            value = value.substring(0, 10);
        }
        $(this).val(value);
        
        // Validación visual
        if (value.length === 10) {
            $(this).removeClass('is-invalid').addClass('is-valid');
        } else {
            $(this).removeClass('is-valid');
        }
    });
    
    // Validación de coincidencia de contraseñas
    $('#password, #password_confirmation').on('input', function() {
        const password = $('#password').val();
        const confirmation = $('#password_confirmation').val();
        
        if (confirmation !== '' && password !== confirmation) {
            $('#password_confirmation').removeClass('is-valid').addClass('is-invalid');
            $('#password_confirmation').siblings('.invalid-feedback').remove();
            $('#password_confirmation').after('<div class="invalid-feedback">Las contraseñas no coinciden</div>');
        } else if (confirmation !== '' && password === confirmation) {
            $('#password_confirmation').removeClass('is-invalid').addClass('is-valid');
            $('#password_confirmation').siblings('.invalid-feedback').remove();
        }
    });
    
    // Validación de fortaleza de contraseña
    $('#password').on('input', function() {
        const password = $(this).val();
        const $feedback = $(this).siblings('.password-strength');
        
        if ($feedback.length === 0) {
            $(this).after('<small class="password-strength text-muted"></small>');
        }
        
        let strength = 0;
        let message = '';
        
        if (password.length >= 8) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;
        
        switch (strength) {
            case 0:
            case 1:
                message = '<span class="text-danger">Muy débil</span>';
                break;
            case 2:
                message = '<span class="text-warning">Débil</span>';
                break;
            case 3:
                message = '<span class="text-info">Regular</span>';
                break;
            case 4:
                message = '<span class="text-success">Fuerte</span>';
                break;
            case 5:
                message = '<span class="text-success">Muy fuerte</span>';
                break;
        }
        
        $('.password-strength').html('Fortaleza: ' + message);
    });
    
    // Validación del formato de email
    $('#email').on('blur', function() {
        const email = $(this).val();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email !== '' && !emailRegex.test(email)) {
            $(this).removeClass('is-valid').addClass('is-invalid');
            $(this).siblings('.invalid-feedback').remove();
            $(this).after('<div class="invalid-feedback">Por favor ingresa un email válido</div>');
        } else if (email !== '') {
            $(this).removeClass('is-invalid').addClass('is-valid');
            $(this).siblings('.invalid-feedback').remove();
        }
    });
    
    // Efecto de ripple en botones
    $('.btn').on('click', function(e) {
        const $btn = $(this);
        const $ripple = $('<span class="ripple"></span>');
        
        $btn.prepend($ripple);
        
        $ripple.css({
            position: 'absolute',
            border-radius: '50%',
            background: 'rgba(255, 255, 255, 0.6)',
            width: '20px',
            height: '20px',
            left: e.pageX - $btn.offset().left - 10,
            top: e.pageY - $btn.offset().top - 10,
            animation: 'ripple 0.6s ease-out'
        });
        
        setTimeout(() => $ripple.remove(), 600);
    });
});

// Animación de ripple
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        0% {
            transform: scale(0);
            opacity: 1;
        }
        100% {
            transform: scale(20);
            opacity: 0;
        }
    }
    
    .form-label {
        position: absolute;
        top: 50%;
        left: 12px;
        transform: translateY(-50%);
        transition: all 0.3s ease;
        pointer-events: none;
        color: #6c757d;
        background: white;
        padding: 0 5px;
    }
    
    .form-label.active,
    .form-outline input:focus + .form-label {
        top: 0;
        font-size: 0.75rem;
        color: #667eea;
        transform: translateY(-50%);
    }
`;
document.head.appendChild(style);
</script>
@endsection
