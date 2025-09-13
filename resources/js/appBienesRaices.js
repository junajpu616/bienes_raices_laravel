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
}

function navegacionResponsive(){
    const navegacion = document.querySelector('.navegacion');
    const mobileMenu = document.querySelector('.mobile-menu');
    const derecha = document.querySelector('.derecha');

    if (navegacion) {
        navegacion.classList.toggle('mostrar');
        derecha.classList.toggle('active');
        
        // Actualizar aria-expanded
        const isExpanded = navegacion.classList.contains('mostrar');
        mobileMenu.setAttribute('aria-expanded', isExpanded);
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