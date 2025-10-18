document.addEventListener('DOMContentLoaded', function(){
    eventListeners();
    darkMode();
    eliminarNotificacion();
    initScrollEffects();
});

function darkMode() {
    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
    const botonDarkMode = document.querySelector('.theme-toggle');
    
    // Comprobar si hay preferencia guardada en localStorage
    const darkModeGuardado = localStorage.getItem('darkMode');
    
    // Aplicar modo inicial - sincronizar html y body
    if (darkModeGuardado === 'enabled') {
        document.documentElement.classList.add('dark-mode');
        document.body.classList.add('dark-mode');
    } else if (darkModeGuardado === 'disabled') {
        document.documentElement.classList.remove('dark-mode');
        document.body.classList.remove('dark-mode');
    } else if (prefiereDarkMode.matches) {
        document.documentElement.classList.add('dark-mode');
        document.body.classList.add('dark-mode');
    } else {
        document.documentElement.classList.remove('dark-mode');
        document.body.classList.remove('dark-mode');
    }

    // Escuchar cambios en la preferencia del sistema
    prefiereDarkMode.addEventListener('change', function() {
        if (!localStorage.getItem('darkMode')) {
            if (prefiereDarkMode.matches) {
                document.documentElement.classList.add('dark-mode');
                document.body.classList.add('dark-mode');
            } else {
                document.documentElement.classList.remove('dark-mode');
                document.body.classList.remove('dark-mode');
            }
        }
    });

    // Toggle manual del dark mode
    if (botonDarkMode) {
        botonDarkMode.addEventListener('click', function() {
            const isDarkMode = document.body.classList.toggle('dark-mode');
            document.documentElement.classList.toggle('dark-mode', isDarkMode);
            
            // Guardar preferencia en localStorage
            localStorage.setItem('darkMode', isDarkMode ? 'enabled' : 'disabled');
            
            // Animación del botón (opcional)
            const track = botonDarkMode.querySelector('.theme-toggle-track');
            if (track) {
                track.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    track.style.transform = 'scale(1)';
                }, 150);
            }
        });
    }
}

function initScrollEffects() {
    const navbar = document.querySelector('.navbar');
    
    if (navbar && !navbar.classList.contains('navbar--scrolled')) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 100) {
                navbar.classList.add('navbar--scrolled');
            } else {
                navbar.classList.remove('navbar--scrolled');
            }
        });
    }
}

function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');

    if (mobileMenu) {
        mobileMenu.addEventListener('click', navegacionResponsive);
    }

    // Muestra campos condicionales
    const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]"]');
    metodoContacto.forEach(input => input.addEventListener('click', mostrarMetodosContacto));
    
    // Cerrar dropdown al hacer click fuera
    document.addEventListener('click', function(e) {
        const dropdowns = document.querySelectorAll('.nav-dropdown');
        dropdowns.forEach(dropdown => {
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });
    });
    
    // Cerrar menú mobile con botón de cerrar
    const closeMobileBtn = document.getElementById('closeMobileMenu');
    if (closeMobileBtn) {
        closeMobileBtn.addEventListener('click', cerrarMenuMobile);
    }
    
    // Cerrar menú mobile al hacer clic en overlay
    const mobileOverlay = document.getElementById('mobileOverlay');
    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', cerrarMenuMobile);
    }
    
    // Cerrar menú mobile al hacer clic en un enlace
    const mobileNavLinks = document.querySelectorAll('.mobile-nav .navegacion a');
    mobileNavLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Solo cerrar si no es un dropdown toggle
            if (!link.classList.contains('dropdown-toggle')) {
                cerrarMenuMobile();
            }
        });
    });
    
    // Manejar dropdowns en el menú mobile
    const mobileDropdowns = document.querySelectorAll('.mobile-nav .nav-dropdown');
    mobileDropdowns.forEach(dropdown => {
        const toggle = dropdown.querySelector('.dropdown-toggle');
        if (toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                dropdown.classList.toggle('open');
            });
        }
    });
    
    // Mejorar experiencia táctil en dispositivos móviles
    if ('ontouchstart' in window) {
        // Agregar clases específicas para dispositivos táctiles
        document.body.classList.add('touch-device');
        
        // Mejorar el feedback táctil en botones
        const touchButtons = document.querySelectorAll('.mobile-menu, .theme-toggle');
        touchButtons.forEach(button => {
            button.addEventListener('touchstart', function() {
                this.classList.add('touching');
            });
            
            button.addEventListener('touchend', function() {
                this.classList.remove('touching');
            });
            
            button.addEventListener('touchcancel', function() {
                this.classList.remove('touching');
            });
        });
    }
}

function navegacionResponsive(){
    const mobileNav = document.getElementById('mobileNav');
    const mobileOverlay = document.getElementById('mobileOverlay');
    const mobileMenu = document.querySelector('.mobile-menu');

    if (mobileNav && mobileOverlay && mobileMenu) {
        // Toggle clases
        mobileNav.classList.toggle('show');
        mobileOverlay.classList.toggle('show');
        mobileMenu.classList.toggle('active');
        
        // Actualizar aria-expanded y aria-label
        const isExpanded = mobileNav.classList.contains('show');
        mobileMenu.setAttribute('aria-expanded', isExpanded);
        mobileMenu.setAttribute('aria-label', isExpanded ? 'Cerrar menú de navegación' : 'Abrir menú de navegación');
        
        // Prevenir scroll en body cuando el menú está abierto
        if (isExpanded) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    }
}

function cerrarMenuMobile() {
    const mobileNav = document.getElementById('mobileNav');
    const mobileOverlay = document.getElementById('mobileOverlay');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (mobileNav && mobileOverlay && mobileMenu) {
        mobileNav.classList.remove('show');
        mobileOverlay.classList.remove('show');
        mobileMenu.classList.remove('active');
        mobileMenu.setAttribute('aria-expanded', 'false');
        mobileMenu.setAttribute('aria-label', 'Abrir menú de navegación');
        document.body.style.overflow = '';
    }
}

function eliminarNotificacion() {
    const notificaciones = document.querySelectorAll('.alerta');
    notificaciones.forEach(notificacion => {
        // Agregar animación de entrada
        notificacion.style.opacity = '0';
        notificacion.style.transform = 'translateY(-20px)';
        
        setTimeout(() => {
            notificacion.style.opacity = '1';
            notificacion.style.transform = 'translateY(0)';
            notificacion.style.transition = 'all 0.3s ease';
        }, 100);
        
        // Elimina la notificación después de 5 segundos con animación
        setTimeout(() => {
            notificacion.style.opacity = '0';
            notificacion.style.transform = 'translateY(-20px)';
            
            setTimeout(() => {
                if (notificacion.parentNode) {
                    notificacion.remove();
                }
            }, 300);
        }, 5000);
    });
}

function mostrarMetodosContacto(e) {
    const contactoDiv = document.querySelector('#contacto');
    if (contactoDiv) {
        if (e.target.value === 'telefono') {
            contactoDiv.innerHTML = `
            <div class="formulario__field">
                <label for="telefono" class="formulario__label formulario__label--required" style="padding: 0 0 5rem 0;">Número de Teléfono:</label>
                <br>
                <input type="tel" placeholder="Tu Teléfono" id="telefono" name="contacto[telefono]" class="formulario__input" required>
            </div>
            <p class="formulario__help" style="margin: 0 0 5rem 0;">Elija la fecha y la hora para la llamada</p>
            <div class="formulario__group--inline">
                <div class="formulario__field">
                    <label for="fecha" class="formulario__label formulario__label--required" style="padding: 0 0 7rem 0;">Fecha:</label>
                    <input type="date" id="fecha" name="contacto[fecha]" class="formulario__input" required>
                </div>
                <div class="formulario__field">
                    <label for="hora" class="formulario__label formulario__label--required" style="padding: 0 0 7rem 0;">Hora:</label>
                    <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]" class="formulario__input" required>
                </div>
            </div>
            `;
        } else {
            contactoDiv.innerHTML = `
            <div class="formulario__field">
                <label for="email" class="formulario__label formulario__label--required" style="padding: 0 0 7rem 0;">Email:</label>
                <input type="email" placeholder="Tu Email" id="email" name="contacto[email]" class="formulario__input" required>
            </div>
            `;
        }
    }
}