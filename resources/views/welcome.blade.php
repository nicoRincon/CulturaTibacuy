@extends('layouts.master')

@section('title', 'Bienvenido')

<style>
        /* ===============================================
    VARIABLES CSS - Colores de Tibacuy
    =============================================== */
    :root {
        /* Colores principales más suaves */
        --primary-blue: #6fa8dc;
        --primary-gold: #ffd966;
        --primary-red: #ea9999;
        --forest-green: #93c47d;
        --mountain-brown: #b45f06;
        
        /* Colores secundarios */
        --soft-blue: #e1ecf7;
        --soft-gold: #fff2cc;
        --soft-green: #d9ead3;
        --soft-red: #f4cccc;
        
        /* Neutros */
        --text-dark: #434343;
        --text-medium: #666666;
        --text-light: #999999;
        --bg-white: #ffffff;
        --bg-light: #f8f9fa;
        
        /* Sombras suaves */
        --shadow-light: 0 2px 10px rgba(0,0,0,0.1);
        --shadow-medium: 0 4px 20px rgba(0,0,0,0.15);
        
        /* Transiciones */
        --transition: all 0.3s ease;
    }

    /* ===============================================
    RESET Y BASE
    =============================================== */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        line-height: 1.6;
        color: var(--text-dark);
        background-color: var(--bg-white);
    }

    html {
        scroll-behavior: smooth;
    }

    /* ===============================================
    UTILIDADES
    =============================================== */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .section-title {
        font-family: 'Nunito', sans-serif;
        font-size: 2.5rem;
        font-weight: 600;
        color: var(--forest-green);
        text-align: center;
        margin-bottom: 3rem;
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: var(--primary-gold);
        border-radius: 3px;
    }

    /* ===============================================
    BOTONES
    =============================================== */
    .btn {
        display: inline-block;
        padding: 12px 30px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 500;
        font-size: 1rem;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        text-align: center;
    }

    .btn-primary {
        background: var(--primary-blue);
        color: white;
    }

    .btn-primary:hover {
        background: #5d96c9;
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .btn-secondary {
        background: transparent;
        color: var(--primary-blue);
        border: 2px solid var(--primary-blue);
    }

    .btn-secondary:hover {
        background: var(--primary-blue);
        color: white;
    }

    .btn-cta {
        background: var(--primary-gold);
        color: var(--text-dark);
        font-size: 1.1rem;
        padding: 15px 40px;
    }

    .btn-cta:hover {
        background: #e6c65a;
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .btn i {
        margin-right: 8px;
    }

    /* ===============================================
    HERO SECTION
    =============================================== */
    .hero-section {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, var(--soft-blue) 0%, var(--soft-green) 100%);
    }

    .hero-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><defs><linearGradient id="mountain" x1="0%" y1="0%" x2="0%" y2="100%"><stop offset="0%" style="stop-color:%2393c47d;stop-opacity:0.3" /><stop offset="100%" style="stop-color:%236fa8dc;stop-opacity:0.2" /></linearGradient></defs><path d="M0,600 L0,400 L300,200 L600,100 L900,200 L1200,400 L1200,600 Z" fill="url(%23mountain)"/></svg>');
        background-size: cover;
        background-position: center;
        opacity: 0.6;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 800px;
        padding: 0 20px;
    }

    .hero-title {
        font-family: 'Nunito', sans-serif;
        font-size: 4rem;
        font-weight: 700;
        color: var(--forest-green);
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(255,255,255,0.5);
    }

    .hero-subtitle {
        font-size: 1.3rem;
        color: var(--text-medium);
        margin-bottom: 1.5rem;
        font-weight: 400;
    }

    .hero-description {
        font-size: 1.1rem;
        color: var(--text-medium);
        margin-bottom: 2.5rem;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    .hero-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .scroll-hint {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        color: var(--primary-blue);
        font-size: 1.5rem;
        animation: bounce 2s infinite;
        cursor: pointer;
    }

    /* ===============================================
    CULTURE SECTION
    =============================================== */
    .culture-section {
        padding: 80px 0;
        background: var(--bg-white);
    }

    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 50px;
    }

    .card {
        background: var(--bg-white);
        border-radius: 15px;
        padding: 40px 30px;
        text-align: center;
        transition: var(--transition);
        box-shadow: var(--shadow-light);
        border: 1px solid var(--soft-blue);
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-medium);
        border-color: var(--primary-blue);
    }

    .card-icon {
        font-size: 2.5rem;
        color: var(--primary-blue);
        margin-bottom: 20px;
    }

    .card h3 {
        font-family: 'Nunito', sans-serif;
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--forest-green);
        margin-bottom: 15px;
    }

    .card p {
        color: var(--text-medium);
        line-height: 1.6;
    }

    /* ===============================================
    HISTORY SECTION
    =============================================== */
    .history-section {
        padding: 80px 0;
        background: var(--soft-green);
    }

    .history-content {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 50px;
        align-items: center;
    }

    .history-text h2 {
        font-family: 'Nunito', sans-serif;
        font-size: 2.2rem;
        font-weight: 600;
        color: var(--forest-green);
        margin-bottom: 25px;
    }

    .history-text p {
        font-size: 1.1rem;
        color: var(--text-dark);
        margin-bottom: 20px;
        line-height: 1.7;
    }

    .history-visual {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .mountain-graphic {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-blue), var(--forest-green));
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-medium);
    }

    .mountain-graphic i {
        font-size: 4rem;
        color: white;
    }

    /* ===============================================
    NEWS SECTION
    =============================================== */
    .news-section {
        padding: 80px 0;
        background: var(--bg-light);
    }

    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 50px;
    }

    .news-card {
        background: var(--bg-white);
        border-radius: 15px;
        padding: 25px;
        transition: var(--transition);
        box-shadow: var(--shadow-light);
        position: relative;
        overflow: hidden;
    }

    .news-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-medium);
    }

    .news-tag {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .news-tag.culture {
        background: var(--soft-red);
        color: var(--primary-red);
    }

    .news-tag.sports {
        background: var(--soft-blue);
        color: var(--primary-blue);
    }

    .news-tag.economy {
        background: var(--soft-gold);
        color: var(--mountain-brown);
    }

    .news-card h3 {
        font-family: 'Nunito', sans-serif;
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 12px;
    }

    .news-card p {
        color: var(--text-medium);
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .news-date {
        font-size: 0.9rem;
        color: var(--text-light);
        font-weight: 500;
    }

    /* ===============================================
    CTA SECTION
    =============================================== */
    .cta-section {
        padding: 80px 0;
        background: linear-gradient(135deg, var(--primary-blue), var(--forest-green));
        color: white;
    }

    .cta-content {
        text-align: center;
        max-width: 600px;
        margin: 0 auto;
    }

    .cta-content h2 {
        font-family: 'Nunito', sans-serif;
        font-size: 2.2rem;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .cta-content p {
        font-size: 1.1rem;
        margin-bottom: 40px;
        opacity: 0.9;
    }

    /* ===============================================
    ANIMATIONS
    =============================================== */
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0) translateX(-50%);
        }
        40% {
            transform: translateY(-10px) translateX(-50%);
        }
        60% {
            transform: translateY(-5px) translateX(-50%);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeInUp 0.8s ease-out;
    }

    /* ===============================================
    RESPONSIVE DESIGN
    =============================================== */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 3rem;
        }
        
        .section-title {
            font-size: 2rem;
        }
        
        .hero-buttons {
            flex-direction: column;
            align-items: center;
        }
        
        .btn {
            min-width: 200px;
        }
        
        .cards-grid,
        .news-grid {
            grid-template-columns: 1fr;
        }
        
        .history-content {
            grid-template-columns: 1fr;
            gap: 30px;
            text-align: center;
        }
        
        .container {
            padding: 0 15px;
        }
    }

    @media (max-width: 480px) {
        .hero-title {
            font-size: 2.5rem;
        }
        
        .hero-content {
            padding: 0 15px;
        }
        
        .card,
        .news-card {
            padding: 25px 20px;
        }
        
        .mountain-graphic {
            width: 150px;
            height: 150px;
        }
        
        .mountain-graphic i {
            font-size: 3rem;
        }
    }

</style>

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