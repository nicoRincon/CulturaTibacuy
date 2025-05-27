@extends('layouts.app')

@section('title', 'Iniciar Sesión')

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
    }
    
    .form-outline input {
        border: 2px solid #e0e6ed;
        border-radius: 0.375rem;
        transition: all 0.3s ease;
    }
    
    .form-outline input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
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
    
    .btn-link {
        color: #667eea;
        transition: all 0.3s ease;
    }
    
    .btn-link:hover {
        color: #764ba2;
        transform: scale(1.1);
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
    }
    
    .alert {
        border-radius: 0.5rem;
        border: none;
    }
</style>
@endsection

@section('content') 
<!-- Section: Design Block -->
<section class="text-center">
    <!-- Background image -->
    <div class="p-5 bg-image" style="height: 300px;"></div>
    <!-- Background image -->
    
    <div class="card mx-4 mx-md-5 shadow-5-strong bg-body-tertiary" style="margin-top: -100px;">
        <div class="card-body py-5 px-md-5">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-5 text-primary">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Iniciar Sesión
                    </h2>
                    
                    <!-- Mostrar errores de validación -->
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <!-- Document Number input -->
                        <div class="form-outline mb-4">
                            <input 
                                type="text" 
                                id="num_documento" 
                                name="num_documento"
                                class="form-control @error('num_documento') is-invalid @enderror" 
                                value="{{ old('num_documento') }}" 
                                required 
                                autocomplete="num_documento" 
                                autofocus
                            />
                            <label class="form-label" for="num_documento">
                                <i class="fas fa-id-card me-1"></i>
                                Número de Documento
                            </label>
                            @error('num_documento')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <input 
                                type="password" 
                                id="password" 
                                name="password"
                                class="form-control @error('password') is-invalid @enderror" 
                                required 
                                autocomplete="current-password"
                            />
                            <label class="form-label" for="password">
                                <i class="fas fa-lock me-1"></i>
                                Contraseña
                            </label>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <!-- Remember Me Checkbox -->
                        <div class="form-check d-flex justify-content-center mb-4">
                            <input 
                                class="form-check-input me-2" 
                                type="checkbox" 
                                name="remember" 
                                id="remember"
                                {{ old('remember') ? 'checked' : '' }}
                            />
                            <label class="form-check-label" for="remember">
                                Recordarme
                            </label>
                        </div>
                        
                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-block mb-4 w-100">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Iniciar Sesión
                        </button>
                        
                        <!-- Links adicionales -->
                        <div class="text-center">
                            @if (Route::has('password.request'))
                                <p class="mb-2">
                                    <a href="{{ route('password.request') }}" class="btn btn-link p-0">
                                        <i class="fas fa-question-circle me-1"></i>
                                        ¿Olvidaste tu contraseña?
                                    </a>
                                </p>
                            @endif
                            
                            @if (Route::has('register'))
                                <div class="mt-3 pt-3 border-top">
                                    <p class="mb-0">¿No tienes una cuenta?</p>
                                    <a href="{{ route('register') }}" class="btn btn-outline-primary mt-2">
                                        <i class="fas fa-user-plus me-2"></i>
                                        Registrarse
                                    </a>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Información adicional -->
                        <div class="text-center mt-4">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Sistema de Gestión Cultural - Tibacuy
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Información adicional sobre el sistema -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">
                    <div class="card-body p-4">
                        <div class="row text-center">
                            <div class="col-md-4 mb-3">
                                <div class="p-3">
                                    <i class="fas fa-music fa-3x text-primary mb-3"></i>
                                    <h5 class="fw-bold">Escuela de Música</h5>
                                    <p class="text-muted mb-0">Formación musical para todas las edades</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="p-3">
                                    <i class="fas fa-masks-theater fa-3x text-primary mb-3"></i>
                                    <h5 class="fw-bold">Artes Escénicas</h5>
                                    <p class="text-muted mb-0">Teatro, danza y expresión corporal</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="p-3">
                                    <i class="fas fa-palette fa-3x text-primary mb-3"></i>
                                    <h5 class="fw-bold">Artes Plásticas</h5>
                                    <p class="text-muted mb-0">Pintura, dibujo y manualidades</p>
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
    
    // Efecto de floating labels
    $('.form-outline input').on('focus blur', function(e) {
        const $this = $(this);
        const $label = $this.siblings('label');
        
        if (e.type === 'focus' || $this.val() !== '') {
            $label.addClass('active');
        } else {
            $label.removeClass('active');
        }
    });
    
    // Inicializar labels para campos con valor
    $('.form-outline input').each(function() {
        if ($(this).val() !== '') {
            $(this).siblings('label').addClass('active');
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