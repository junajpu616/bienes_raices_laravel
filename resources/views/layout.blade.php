<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Encuentra la casa de tus sueños con nosotros. Propiedades exclusivas de lujo.">
    <meta name="keywords" content="bienes raices, propiedades, casas, departamentos, venta">

    <title>@yield('title', 'Bienes Raices - Encuentra tu hogar perfecto')</title>

    <!-- Preload critical resources -->
    <link rel="preload" href="{{ asset('img/header.jpg') }}" as="image">
    
    <!-- Prevent dark mode flicker -->
    <script>
        (function() {
            const darkModeGuardado = localStorage.getItem('darkMode');
            const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
            
            if (darkModeGuardado === 'enabled' || (darkModeGuardado === null && prefiereDarkMode.matches)) {
                document.documentElement.classList.add('dark-mode');
            }
        })();
    </script>
    
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @endif
    
    @stack('styles')
</head>

<body>
    <!-- Skip to content for accessibility -->
    <a href="#main-content" class="sr-only">Saltar al contenido principal</a>
    
    <header class="header {{ isset($inicio) && $inicio ? 'inicio' : '' }}">
        <nav class="navbar {{ isset($inicio) && $inicio ? '' : 'navbar--scrolled' }}">
            <div class="contenedor">
                <div class="barra">
                    <a href="{{ route('home') }}" aria-label="Ir al inicio">
                        <img src="{{ asset('img/logo.svg') }}" alt="Logotipo de Bienes Raices" width="120" height="40">
                    </a>
                    
                    <button class="mobile-menu" aria-label="Abrir menú de navegación" aria-expanded="false">
                        <img src="{{ asset('img/barras.svg') }}" alt="Menú hamburguesa">
                    </button>
                    
                    <div class="derecha">
                        <button class="theme-toggle" aria-label="Cambiar modo oscuro" title="Cambiar modo oscuro">
                            <div class="theme-toggle-track">
                                <div class="theme-toggle-thumb">
                                    <svg class="sun-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2.25a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-1.5 0V3a.75.75 0 0 1 .75-.75ZM7.5 12a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM18.894 6.166a.75.75 0 0 0-1.06-1.06l-1.591 1.59a.75.75 0 1 0 1.06 1.061l1.591-1.59ZM21.75 12a.75.75 0 0 1-.75.75h-2.25a.75.75 0 0 1 0-1.5H21a.75.75 0 0 1 .75.75ZM17.834 18.894a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 1 0-1.061 1.06l1.59 1.591ZM12 18a.75.75 0 0 1 .75.75V21a.75.75 0 0 1-1.5 0v-2.25A.75.75 0 0 1 12 18ZM7.758 17.303a.75.75 0 0 0-1.061-1.06l-1.591 1.59a.75.75 0 0 0 1.06 1.061l1.591-1.59ZM6 12a.75.75 0 0 1-.75.75H3a.75.75 0 0 1 0-1.5h2.25A.75.75 0 0 1 6 12ZM6.697 7.757a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 0 0-1.061 1.06l1.59 1.591Z"/>
                                    </svg>
                                    <svg class="moon-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9.528 1.718a.75.75 0 0 1 .162.819A8.97 8.97 0 0 0 9 6a9 9 0 0 0 9 9 8.97 8.97 0 0 0 3.463-.69.75.75 0 0 1 .981.98 10.503 10.503 0 0 1-9.694 6.46c-5.799 0-10.5-4.7-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 0 1 .818.162Z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                        </button>
                        
                        <nav class="navegacion" role="navigation" aria-label="Navegación principal">
                            <a href="{{ route('nosotros') }}" class="{{ request()->routeIs('nosotros') ? 'active' : '' }}">Nosotros</a>
                            <a href="{{ route('propiedades') }}" class="{{ request()->routeIs('propiedades') ? 'active' : '' }}">Propiedades</a>
                            <a href="{{ route('blog') }}" class="{{ request()->routeIs('blog') ? 'active' : '' }}">Blog</a>
                            <a href="{{ route('contacto') }}" class="{{ request()->routeIs('contacto') ? 'active' : '' }}">Contacto</a>
                            
                            @auth
                                @if(auth()->user()->is_admin)
                                    <div class="nav-dropdown">
                                        <a href="#" class="dropdown-toggle">Admin</a>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('admin') }}">Dashboard</a>
                                            <a href="{{ route('admin.create') }}">Nueva Propiedad</a>
                                            <a href="{{ route('vendedores.index') }}">Vendedores</a>
                                        </div>
                                    </div>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <input type="submit" value="Cerrar Sesión">
                                    </form>
                                @endif
                            @endauth
                            
                            @if(Auth::guard('seller')->check())
                                <div class="user-indicator">
                                    <div class="avatar">{{ substr(Auth::guard('seller')->user()->nombre, 0, 1) }}</div>
                                    <span class="user-name">{{ Auth::guard('seller')->user()->nombre }}</span>
                                </div>
                                <div class="nav-dropdown">
                                    <a href="#" class="dropdown-toggle">Mi Cuenta</a>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('seller.dashboard') }}">Dashboard</a>
                                        <a href="{{ route('seller.properties.index') }}">Mis Propiedades</a>
                                        <a href="{{ route('seller.properties.create') }}">Nueva Propiedad</a>
                                    </div>
                                </div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <input type="submit" value="Cerrar Sesión">
                                </form>
                            @endif
                            
                            @guest
                                @if(!Auth::guard('seller')->check())
                                    <a href="{{ route('seller.login') }}" class="btn btn--outline-primary btn--sm">Iniciar Sesión</a>
                                    <a href="{{ route('seller.register') }}" class="btn btn--primary btn--sm">Registrarse</a>
                                @endif                                
                            @endguest
                        </nav>
                    </div>
                </div>
            </div>
        </nav>
        
        @if (isset($inicio) && $inicio)
            <div class="contenedor contenido-header">
                <div class="hero-content">
                    <h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>
                    <p>Encuentra la propiedad de tus sueños con nosotros</p>
                    <div class="flex gap-md">
                        <a href="{{ route('propiedades') }}" class="btn btn--secondary btn--lg">Ver Propiedades</a>
                        <a href="{{ route('contacto') }}" class="btn btn--outline-secondary btn--lg">Contactar</a>
                    </div>
                </div>
            </div>
        @endif
    </header>

    <main id="main-content">
        @yield('contenido')
    </main>

    <footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <div class="footer__content">
                <div class="footer__section">
                    <h3>Bienes Raices</h3>
                    <p>Tu hogar perfecto te está esperando. Encuentra las mejores propiedades con nosotros.</p>
                    <div class="footer__social">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                
                <div class="footer__section">
                    <h4>Enlaces</h4>
                    <nav class="footer__nav">
                        <a href="{{ route('nosotros') }}">Nosotros</a>
                        <a href="{{ route('propiedades') }}">Propiedades</a>
                        <a href="{{ route('blog') }}">Blog</a>
                        <a href="{{ route('contacto') }}">Contacto</a>
                    </nav>
                </div>
                
                <div class="footer__section">
                    <h4>Contacto</h4>
                    <div class="footer__contact">
                        <p><i class="fas fa-phone"></i> +502 1234-5678</p>
                        <p><i class="fas fa-envelope"></i> info@bienesraices.com</p>
                        <p><i class="fas fa-map-marker-alt"></i> Guatemala, Guatemala</p>
                    </div>
                </div>
            </div>
            
            <div class="footer__bottom">
                <p class="copyright">© {{ date('Y') }} Bienes Raices. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
    
    @stack('scripts')
</body>

</html>
