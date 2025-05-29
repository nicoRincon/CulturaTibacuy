@extends('layouts.master')

@section('title', 'Iniciar Sesión')

@section('styles')
<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --primary-blue: #667eea;
    --primary-purple: #764ba2;
    --glass-bg: rgba(255, 255, 255, 0.95);
    --glass-border: rgba(255, 255, 255, 0.2);
}

body {
    margin: 0;
    min-height: 100vh;
    background: var(--primary-gradient);
    font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Fondo animado */
.bg-image {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--primary-gradient);
    z-index: -2;
}

.bg-image::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.1) 0%, transparent 50%);
    animation: float 20s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    33% { transform: translateY(-20px) rotate(1deg); }
    66% { transform: translateY(10px) rotate(-1deg); }
}

/* Login Container */
.login-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
}

.login-card {
    background: var(--glass-bg);
    backdrop-filter: blur(20px);
    border: 1px solid var(--glass-border);
    border-radius: 24px;
    box-shadow: 
        0 8px 32px rgba(0, 0, 0, 0.1),
        0 2px 16px rgba(0, 0, 0, 0.05);
    padding: 3rem;
    width: 100%;
    max-width: 440px;
    position: relative;
    overflow: hidden;
    animation: slideUp 0.8s ease-out;
}

.login-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--primary-gradient);
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Header */
.login-header {
    text-align: center;
    margin-bottom: 2.5rem;
}

.login-title {
    font-size: 2rem;
    font-weight: 700;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.login-subtitle {
    color: #6b7280;
    font-size: 0.95rem;
    margin: 0;
}

/* Form Styles */
.form-group {
    margin-bottom: 1.5rem;
    position: relative;
}

.form-control {
    width: 100%;
    padding: 1rem 1rem 1rem 3rem;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 1rem;
    background: #fff;
    transition: all 0.3s ease;
    outline: none;
}

.form-control:focus {
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    transform: translateY(-2px);
}

.form-control.is-invalid {
    border-color: #ef4444;
    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
}

.form-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 1.1rem;
    transition: color 0.3s ease;
}

.form-control:focus + .form-icon {
    color: var(--primary-blue);
}

.form-label {
    position: absolute;
    left: 3rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 1rem;
    pointer-events: none;
    transition: all 0.3s ease;
    background: white;
    padding: 0 0.5rem;
}

.form-control:focus + .form-icon + .form-label,
.form-control:not(:placeholder-shown) + .form-icon + .form-label {
    top: 0;
    left: 2.5rem;
    font-size: 0.8rem;
    color: var(--primary-blue);
    font-weight: 500;
}

/* Checkbox */
.form-check {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 2rem;
}

.form-check-input {
    width: 1.2rem;
    height: 1.2rem;
    margin-right: 0.75rem;
    accent-color: var(--primary-blue);
}

.form-check-label {
    color: #6b7280;
    font-size: 0.9rem;
    cursor: pointer;
}

/* Buttons */
.btn-primary {
    width: 100%;
    padding: 1rem;
    background: var(--primary-gradient);
    border: none;
    border-radius: 12px;
    color: white;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.btn-primary:active {
    transform: translateY(0);
}

.btn-link {
    color: var(--primary-blue);
    text-decoration: none;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    padding: 0.5rem;
    border-radius: 8px;
}

.btn-link:hover {
    color: var(--primary-purple);
    background: rgba(102, 126, 234, 0.05);
}

.btn-outline-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border: 2px solid var(--primary-blue);
    color: var(--primary-blue);
    text-decoration: none;
    border-radius: 12px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: var(--primary-gradient);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

/* Error Messages */
.alert-danger {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.2);
    color: #dc2626;
    padding: 1rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
}

.invalid-feedback {
    color: #ef4444;
    font-size: 0.8rem;
    margin-top: 0.5rem;
    margin-left: 3rem;
}

/* Links Section */
.links-section {
    text-align: center;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    padding-top: 1.5rem;
    margin-top: 1.5rem;
}

/* Features Section */
.features-section {
    margin-top: 4rem;
    padding: 2rem 0;
}

.feature-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.4s ease;
    height: 100%;
}

.feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.feature-icon {
    width: 4rem;
    height: 4rem;
    background: var(--primary-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 1.5rem;
}

.feature-card h4 {
    color: #1f2937;
    font-weight: 600;
    margin-bottom: 1rem;
}

.feature-card p {
    color: #6b7280;
    margin: 0;
    line-height: 1.6;
}

/* Responsive */
@media (max-width: 768px) {
    .login-card {
        padding: 2rem 1.5rem;
        margin: 1rem;
        border-radius: 20px;
    }
    
    .login-title {
        font-size: 1.75rem;
    }
    
    .features-section {
        margin-top: 2rem;
    }
    
    .feature-card {
        margin-bottom: 1.5rem;
    }
}

/* Loading animation */
.btn-primary.loading::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    border: 2px solid transparent;
    border-top: 2px solid white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
}

@keyframes spin {
    0% { transform: translateY(-50%) rotate(0deg); }
    100% { transform: translateY(-50%) rotate(360deg); }
}
</style>
@endsection

@section('content-wrapper')
<!-- Background -->
<div class="bg-image"></div>

<!-- Login Container -->
<div class="login-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="login-card">
                    <!-- Header -->
                    <div class="login-header">
                        <h1 class="login-title">
                            <i class="fas fa-mountain"></i>
                            Bienvenido a Tibacuy
                        </h1>
                        <p class="login-subtitle">Ingresa a tu cuenta para continuar</p>
                    </div>
                    
                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0" style="list-style: none; padding: 0;">
                                @foreach ($errors->all() as $error)
                                    <li><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf
                        
                        <!-- Document Number -->
                        <div class="form-group">
                            <input 
                                type="text" 
                                id="num_documento" 
                                name="num_documento"
                                class="form-control @error('num_documento') is-invalid @enderror" 
                                value="{{ old('num_documento') }}" 
                                required 
                                autocomplete="num_documento" 
                                autofocus
                                placeholder=" "
                            />
                            <i class="fas fa-id-card form-icon"></i>
                            <label class="form-label" for="num_documento">Número de Documento</label>
                            @error('num_documento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Password -->
                        <div class="form-group">
                            <input 
                                type="password" 
                                id="password" 
                                name="password"
                                class="form-control @error('password') is-invalid @enderror" 
                                required 
                                autocomplete="current-password"
                                placeholder=" "
                            />
                            <i class="fas fa-lock form-icon"></i>
                            <label class="form-label" for="password">Contraseña</label>
                            <button type="button" class="btn-toggle-password" onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Remember Me -->
                        <div class="form-check">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                name="remember" 
                                id="remember"
                                {{ old('remember') ? 'checked' : '' }}
                            />
                            <label class="form-check-label" for="remember">
                                Mantener sesión iniciada
                            </label>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="btn-primary" id="loginBtn">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Iniciar Sesión
                        </button>
                        
                        <!-- Links -->
                        <div class="links-section">
                            @if (Route::has('password.request'))
                                <p>
                                    <a href="{{ route('password.request') }}" class="btn-link">
                                        <i class="fas fa-key me-1"></i>
                                        ¿Olvidaste tu contraseña?
                                    </a>
                                </p>
                            @endif
                            
                            @if (Route::has('register'))
                                <div class="mt-3">
                                    <p class="mb-3" style="color: #6b7280;">¿No tienes una cuenta?</p>
                                    <a href="{{ route('register') }}" class="btn-outline-primary">
                                        <i class="fas fa-user-plus"></i>
                                        Crear Cuenta Nueva
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
<div class="features-section">
    <div class="container">
        <div class="row">
            @foreach([
                ['icon' => 'fas fa-music', 'title' => 'Escuela de Música', 'desc' => 'Aprende piano, guitarra, canto y más instrumentos con profesores especializados'],
                ['icon' => 'fas fa-masks-theater', 'title' => 'Artes Escénicas', 'desc' => 'Teatro, danza folclórica y expresión corporal para todas las edades'],
                ['icon' => 'fas fa-palette', 'title' => 'Artes Plásticas', 'desc' => 'Pintura, dibujo, escultura y manualidades en un ambiente creativo']
            ] as $feature)
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="{{ $feature['icon'] }}"></i>
                    </div>
                    <h4>{{ $feature['title'] }}</h4>
                    <p>{{ $feature['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejo de labels flotantes
    const inputs = document.querySelectorAll('.form-control');
    
    inputs.forEach(input => {
        // Verificar si el input ya tiene valor al cargar
        if (input.value !== '') {
            input.nextElementSibling.nextElementSibling.classList.add('active');
        }
        
        // Eventos focus y blur
        input.addEventListener('focus', function() {
            this.nextElementSibling.nextElementSibling.classList.add('active');
        });
        
        input.addEventListener('blur', function() {
            if (this.value === '') {
                this.nextElementSibling.nextElementSibling.classList.remove('active');
            }
        });
        
        // Evento input para actualizar en tiempo real
        input.addEventListener('input', function() {
            if (this.value !== '') {
                this.nextElementSibling.nextElementSibling.classList.add('active');
            }
        });
    });
    
    // Manejo del formulario de login
    const loginForm = document.getElementById('loginForm');
    const loginBtn = document.getElementById('loginBtn');
    
    loginForm.addEventListener('submit', function() {
        loginBtn.classList.add('loading');
        loginBtn.disabled = true;
        loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Iniciando sesión...';
    });
    
    // Animación de entrada para las cards
    const featureCards = document.querySelectorAll('.feature-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 200);
            }
        });
    });
    
    featureCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s ease';
        observer.observe(card);
    });
});

// Función para mostrar/ocultar contraseña
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
</script>

<style>
.btn-toggle-password {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #9ca3af;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 4px;
    transition: color 0.3s ease;
}

.btn-toggle-password:hover {
    color: var(--primary-blue);
}

.form-group {
    position: relative;
}
</style>
@endsection