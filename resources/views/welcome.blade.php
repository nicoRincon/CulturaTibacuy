@extends('layouts.app')

@section('title', 'Bienvenido')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
<style>
/* Estilos adicionales para la sección de noticias */
.news-banner {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 60px 0;
    position: relative;
    overflow: hidden;
}

.news-banner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.08)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.news-banner-content {
    position: relative;
    z-index: 2;
}

.news-ticker {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 25px;
    margin-top: 30px;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.news-item {
    display: flex;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.news-item:last-child {
    border-bottom: none;
}

.news-item:hover {
    transform: translateX(10px);
    background: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    padding-left: 15px;
    margin: 0 -15px;
}

.news-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    font-size: 20px;
    flex-shrink: 0;
}

.news-content h4 {
    margin: 0 0 8px 0;
    font-size: 1.1rem;
    font-weight: 600;
}

.news-content p {
    margin: 0;
    opacity: 0.9;
    font-size: 0.9rem;
    line-height: 1.4;
}

.news-date {
    font-size: 0.8rem;
    opacity: 0.7;
    margin-left: auto;
    flex-shrink: 0;
}

.breaking-badge {
    background: #ff4757;
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: bold;
    text-transform: uppercase;
    margin-right: 10px;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.news-header {
    text-align: center;
    margin-bottom: 30px;
}

.news-header h2 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 15px;
}

.news-header p {
    font-size: 1.1rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
}

@media (max-width: 768px) {
    .news-banner {
        padding: 40px 0;
    }
    
    .news-header h2 {
        font-size: 2rem;
    }
    
    .news-item {
        flex-direction: column;
        align-items: flex-start;
        text-align: left;
    }
    
    .news-icon {
        margin-bottom: 15px;
        margin-right: 0;
    }
    
    .news-date {
        margin-left: 0;
        margin-top: 10px;
    }
}
</style>
@endsection

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

<section class="news-banner">
    <div class="container">
        <div class="news-banner-content">
            <div class="news-header">
                <h2>🗞️ Últimas Noticias</h2>
                <p>Mantente al día con las novedades de nuestra comunidad cultural</p>
            </div>
            
            <div class="news-ticker">
                <div class="news-item">
                    <div class="news-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="news-content">
                        <div class="d-flex align-items-center">
                            <span class="breaking-badge">Nuevo</span>
                            <h4>¡Inscripciones Abiertas para el 2025!</h4>
                        </div>
                        <p>Ya están disponibles las inscripciones para todos nuestros programas culturales del próximo año. Cupos limitados.</p>
                    </div>
                    <div class="news-date">
                        <i class="fas fa-calendar"></i> Hoy
                    </div>
                </div>
                
                <div class="news-item">
                    <div class="news-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="news-content">
                        <h4>Festival de Talentos 2024 - Gran Éxito</h4>
                        <p>Más de 200 participantes demostraron sus habilidades en música, danza y teatro. ¡Felicitaciones a todos!</p>
                    </div>
                    <div class="news-date">
                        <i class="fas fa-calendar"></i> 3 días
                    </div>
                </div>
                
                <div class="news-item">
                    <div class="news-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="news-content">
                        <h4>Nuevos Instructores se Unen al Equipo</h4>
                        <p>Damos la bienvenida a 5 nuevos profesores especializados en artes plásticas y música tradicional.</p>
                    </div>
                    <div class="news-date">
                        <i class="fas fa-calendar"></i> 1 semana
                    </div>
                </div>
                
                <div class="news-item">
                    <div class="news-icon">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <div class="news-content">
                        <h4>Exposición de Arte Local en el Cerro Quininí</h4>
                        <p>Los trabajos de nuestros estudiantes de artes plásticas serán exhibidos junto a los petroglifos ancestrales.</p>
                    </div>
                    <div class="news-date">
                        <i class="fas fa-calendar"></i> 2 semanas
                    </div>
                </div>
            </div>
        </div>
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
<script>
// JavaScript adicional para la sección de noticias
document.addEventListener('DOMContentLoaded', function() {
    // Animación de entrada para las noticias
    const newsItems = document.querySelectorAll('.news-item');
    
    newsItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        item.style.transition = 'all 0.6s ease';
        
        setTimeout(() => {
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }, index * 200);
    });
    
    // Efecto de hover mejorado
    newsItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(10px) scale(1.02)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0) scale(1)';
        });
    });
});
</script>
@endsection