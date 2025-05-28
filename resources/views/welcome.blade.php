@extends('layouts.app')

@section('title', 'Bienvenido')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/welcome.css') }}">

@section('content-wrapper')
<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-bg"></div>
    <div class="hero-content">
        <h1 class="hero-title">Tibacuy</h1>
        <p class="hero-subtitle">Jefe Oficial de la Montaña Sagrada</p>
        <p class="hero-description">
            Un rincón mágico donde la naturaleza y la cultura se encuentran
        </p>
        <div class="hero-buttons">
            <a href="#cultura" class="btn btn-primary">Descubrir</a>
            @guest
                <a href="{{ route('login') }}" class="btn btn-secondary">Ingresar</a>
            @else
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Dashboard</a>
            @endguest
        </div>
    </div>
    
    <div class="scroll-hint">
        <i class="fas fa-chevron-down"></i>
    </div>
</section>

<!-- Cultura Section -->
<section id="cultura" class="culture-section">
    <div class="container">
        <h2 class="section-title">Lo que nos hace especiales</h2>
        
        <div class="cards-grid">
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-mountain"></i>
                </div>
                <h3>Cerro Quininí</h3>
                <p>Nuestra montaña sagrada donde los antepasados dejaron su huella</p>
            </div>
            
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-paint-brush"></i>
                </div>
                <h3>Arte Ancestral</h3>
                <p>Petroglifos y arte rupestre que cuenta historias milenarias</p>
            </div>
            
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-coffee"></i>
                </div>
                <h3>Café de Altura</h3>
                <p>El mejor café cultivado con amor en nuestras montañas</p>
            </div>
        </div>
    </div>
</section>

<!-- Historia Section -->
<section class="history-section">
    <div class="container">
        <div class="history-content">
            <div class="history-text">
                <h2>Nuestra Historia</h2>
                <p>
                    "Tibacuy" significa "jefe oficial" en lengua muisca. 
                    Somos herederos de los Panches y Muiscas, culturas que 
                    veneraban el Cerro Quininí como la "Montaña de la Luna".
                </p>
                <p>
                    Hoy seguimos honrando esa herencia mientras construimos 
                    un futuro lleno de oportunidades culturales y educativas.
                </p>
            </div>
            <div class="history-visual">
                <div class="mountain-graphic">
                    <i class="fas fa-mountain"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Programas Section -->
<section class="news-section">
    <div class="container">
        <h2 class="section-title">Nuestros Programas</h2>
        
        <div class="news-grid">
            <article class="news-card">
                <div class="news-tag culture">Música</div>
                <h3>Escuela de Música</h3>
                <p>Aprende instrumentos tradicionales y contemporáneos con instructores especializados</p>
                <span class="news-date">
                    <i class="fas fa-music"></i> Inscripciones Abiertas
                </span>
            </article>
            
            <article class="news-card">
                <div class="news-tag sports">Danza</div>
                <h3>Escuela de Danza</h3>
                <p>Descubre el arte del movimiento con danza folclórica y contemporánea</p>
                <span class="news-date">
                    <i class="fas fa-dancer"></i> Clases Disponibles
                </span>
            </article>
            
            <article class="news-card">
                <div class="news-tag economy">Teatro</div>
                <h3>Escuela de Teatro</h3>
                <p>Desarrolla tus habilidades dramáticas y expresión corporal</p>
                <span class="news-date">
                    <i class="fas fa-theater-masks"></i> Nuevos Grupos
                </span>
            </article>
            
            <article class="news-card">
                <div class="news-tag culture">Arte</div>
                <h3>Artes Plásticas</h3>
                <p>Explora tu creatividad a través del dibujo, pintura y escultura</p>
                <span class="news-date">
                    <i class="fas fa-palette"></i> Talleres Libres
                </span>
            </article>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2>¿Listo para ser parte de nuestra comunidad cultural?</h2>
            <p>Únete a nuestros programas de formación artística y cultural</p>
            @guest
                <a href="{{ route('login') }}" class="btn btn-cta">
                    <i class="fas fa-sign-in-alt"></i>
                    Comenzar Ahora
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="btn btn-cta">
                    <i class="fas fa-tachometer-alt"></i>
                    Ir al Dashboard
                </a>
            @endguest
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('js/main.js') }}"></script>
@endsection