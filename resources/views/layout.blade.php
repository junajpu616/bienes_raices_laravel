<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bienes Raices Migración</title>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body>
    <header class="header {{ $inicio ? 'inicio' : ''}}">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('img/logo.svg') }}" alt="Logotipo de Bienes Raices">
                </a>
                <div class="mobile-menu">
                    <img src="{{ asset('img/barras.svg') }}" alt="icono menu responsive">
                </div>
                <div class="derecha">
                    <img src="{{ asset('img/dark-mode.svg') }}" alt="Icono Dark Mode" class="dark-mode-boton">
                    <nav class="navegacion">
                        <a href="{{ route('nosotros') }}">Nosotros</a>
                        <a href="{{ route('propiedades') }}">Anuncios</a>
                        <a href="{{ route('blog') }}">Blog</a>
                        <a href="{{ route('contacto') }}">Contacto</a>                      
                        @auth
                            <a href="{{ route('admin') }}">CRUD</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <input type="submit" value="Cerrar Sesión" style="color: white; margin: 1rem; font-size: 1.8rem;">
                            </form>
                        @endauth
                        @guest
                            <a href="{{ route('login') }}">Iniciar Sesión</a>
                        @endguest
                    </nav>
                </div>
            </div> <!-- Fin Barra -->
            @if ($inicio)
                <h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>
            @endif
        </div>
    </header>

    @yield('contenido')

    <footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                <a href="{{ route('nosotros') }}">Nosotros</a>
                <a href="{{ route('propiedades') }}">Anuncios</a>
                <a href="{{ route('blog') }}">Blog</a>
                <a href="{{ route('contacto') }}">Contacto</a>
            </nav>
        </div>
        <p class="copyright">Todos los derechos reservados 2021 &copy;</p>
    </footer>
</body>

</html>