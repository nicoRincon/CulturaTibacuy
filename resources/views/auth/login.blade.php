@extends('layouts.master')

@section('title', 'Iniciar Sesión')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/login.css') }}">

@section('content-wrapper')
<!-- Background image -->
<div class="bg-image"></div>

<!-- Login Card -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card mt-5 fade-in" style="margin-top: -100px !important;">
                <div class="card-body p-5">
                    <h2 class="fw-bold mb-4 text-center" style="color: var(--primary-blue);">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Iniciar Sesión
                    </h2>
                    
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
                        <div class="form-outline">
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
                        <div class="form-outline">
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
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Iniciar Sesión
                            </button>
                        </div>
                        
                        <!-- Links adicionales -->
                        <div class="text-center">
                            @if (Route::has('password.request'))
                                <p class="mb-3">
                                    <a href="{{ route('password.request') }}" class="btn btn-link p-0" style="color: var(--primary-blue);">
                                        <i class="fas fa-question-circle me-1"></i>
                                        ¿Olvidaste tu contraseña?
                                    </a>
                                </p>
                            @endif
                            
                            @if (Route::has('register'))
                                <div class="mt-4 pt-3 border-top">
                                    <p class="mb-2">¿No tienes una cuenta?</p>
                                    <a href="{{ route('register') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-user-plus me-2"></i>
                                        Registrarse
                                    </a>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="container mt-5">
    <div class="row justify-content-center">
        @foreach([
            ['icon' => 'fas fa-music', 'title' => 'Escuela de Música', 'desc' => 'Formación musical para todas las edades'],
            ['icon' => 'fas fa-masks-theater', 'title' => 'Artes Escénicas', 'desc' => 'Teatro, danza y expresión corporal'],
            ['icon' => 'fas fa-palette', 'title' => 'Artes Plásticas', 'desc' => 'Pintura, dibujo y manualidades']
        ] as $feature)
        <div class="col-md-4 mb-4">
            <div class="feature-card fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                <div class="feature-icon">
                    <i class="{{ $feature['icon'] }}"></i>
                </div>
                <h4 style="color: var(--primary-blue);">{{ $feature['title'] }}</h4>
                <p class="text-muted">{{ $feature['desc'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Inicializar labels
    $('.form-outline input').each(function() {
        if ($(this).val() !== '') {
            $(this).siblings('label').addClass('active');
        }
    });
    
    // Animación de labels flotantes
    $('.form-outline input').on('focus blur', function(e) {
        const $this = $(this);
        const $label = $this.siblings('label');
        
        if (e.type === 'focus' || $this.val() !== '') {
            $label.addClass('active');
        } else {
            $label.removeClass('active');
        }
    });
});
</script>
@endsection