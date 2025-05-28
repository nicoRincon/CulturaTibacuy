// ===============================================
// TIBACUY - JavaScript Principal
// ===============================================

// Esperar a que el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    console.log('🏔️ Bienvenido a Tibacuy!');
    
    // Inicializar todas las funciones
    initScrollEffects();
    initAnimations();
    initSmoothScroll();
    showWelcomeMessage();
});

// ===============================================
// EFECTOS DE SCROLL
// ===============================================
function initScrollEffects() {
    const scrollHint = document.querySelector('.scroll-hint');
    
    // Ocultar el indicador de scroll al hacer scroll
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        
        if (scrolled > 100 && scrollHint) {
            scrollHint.style.opacity = '0';
        } else if (scrollHint) {
            scrollHint.style.opacity = '1';
        }
    });
    
    // Click en el indicador de scroll
    if (scrollHint) {
        scrollHint.addEventListener('click', function() {
            scrollToSection('cultura');
        });
    }
}

// ===============================================
// ANIMACIONES AL HACER SCROLL
// ===============================================
function initAnimations() {
    // Configurar el Observer para animaciones
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, observerOptions);

    // Observar elementos que queremos animar
    const elementsToAnimate = document.querySelectorAll('.card, .news-card, .history-text, .cta-content');
    
    elementsToAnimate.forEach(function(element) {
        observer.observe(element);
    });
}

// ===============================================
// SCROLL SUAVE
// ===============================================
function initSmoothScroll() {
    // Botón "Descubrir" en el hero
    const discoverBtn = document.querySelector('a[href="#cultura"]');
    
    if (discoverBtn) {
        discoverBtn.addEventListener('click', function(e) {
            e.preventDefault();
            scrollToSection('cultura');
        });
    }
}

// Función para hacer scroll suave a una sección
function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    
    if (section) {
        const headerHeight = 0; // Ajustar si tienes header fijo
        const sectionTop = section.offsetTop - headerHeight;
        
        window.scrollTo({
            top: sectionTop,
            behavior: 'smooth'
        });
    }
}

// ===============================================
// EFECTOS INTERACTIVOS EN CARDS
// ===============================================
function initCardEffects() {
    const cards = document.querySelectorAll('.card, .news-card');
    
    cards.forEach(function(card, index) {
        // Efecto de delay en hover para que se vea más dinámico
        card.style.transitionDelay = (index * 0.1) + 's';
        
        // Agregar un efecto sutil de inclinación
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) rotate(1deg)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) rotate(0deg)';
        });
    });
}

// ===============================================
// MENSAJE DE BIENVENIDA
// ===============================================
function showWelcomeMessage() {
    // Mostrar un mensaje casual en la consola
    const messages = [
        '¡Hey! 👋 Gracias por visitar Tibacuy',
        '🏔️ ¿Sabías que nuestro cerro es sagrado?',
        '☕ Nuestro café es el mejor de la región',
        '🎨 Los petroglifos tienen más de 500 años'
    ];
    
    const randomMessage = messages[Math.floor(Math.random() * messages.length)];
    console.log(randomMessage);
}

// ===============================================
// UTILIDADES
// ===============================================

// Función para detectar si un elemento está visible
function isElementVisible(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

// Función para agregar clase con delay
function addClassWithDelay(element, className, delay = 0) {
    setTimeout(function() {
        element.classList.add(className);
    }, delay);
}

// ===============================================
// EFECTOS ADICIONALES (OPCIONALES)
// ===============================================

// Efecto de partículas suave en el hero (opcional)
function initParticleEffect() {
    // Este efecto es opcional y más avanzado
    // Por ahora lo dejamos comentado para mantener simplicidad
    
    /*
    const hero = document.querySelector('.hero-section');
    
    if (hero) {
        // Crear partículas flotantes muy sutiles
        for (let i = 0; i < 5; i++) {
            createFloatingParticle(hero, i);
        }
    }
    */
}

// ===============================================
// MANEJO DE ERRORES
// ===============================================
window.addEventListener('error', function(e) {
    console.log('Oops, algo salió mal, pero no te preocupes! 😊');
});

// ===============================================
// RESPONSIVE HELPERS
// ===============================================
function isMobileDevice() {
    return window.innerWidth <= 768;
}

// Ajustar efectos según el dispositivo
window.addEventListener('resize', function() {
    // Resetear algunos efectos en mobile para mejor performance
    if (isMobileDevice()) {
        // Desactivar algunos efectos complejos en mobile
        const cards = document.querySelectorAll('.card, .news-card');
        cards.forEach(function(card) {
            card.style.transition = 'transform 0.2s ease';
        });
    }
});

// ===============================================
// INICIALIZACIÓN FINAL
// ===============================================

// Mensaje final cuando todo está cargado
window.addEventListener('load', function() {
    console.log('✅ Todo listo! Disfruta explorando Tibacuy');
    
    // Opcional: Inicializar efectos adicionales después de que todo cargue
    setTimeout(function() {
        initCardEffects();
    }, 500);
});