<div class="seller-menu">
    <h2>Panel de Vendedor</h2>
    <nav class="menu-navegacion">
        <a href="{{ route('seller.dashboard') }}" class="menu-item {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
            <i class="icono-dashboard"></i> Dashboard
        </a>
        <a href="{{ route('seller.properties.index') }}" class="menu-item {{ request()->routeIs('seller.properties.*') ? 'active' : '' }}">
            <i class="icono-propiedades"></i> Mis Propiedades
        </a>
        <a href="{{ route('seller.properties.create') }}" class="menu-item {{ request()->routeIs('seller.properties.create') ? 'active' : '' }}">
            <i class="icono-crear"></i> Crear Propiedad
        </a>
        <form action="{{ route('seller.logout') }}" method="POST" class="menu-logout">
            @csrf
            <button type="submit" class="menu-item logout-btn">
                <i class="icono-logout"></i> Cerrar Sesión
            </button>
        </form>
    </nav>
</div>
