@extends('layout')

@section('title', 'Administración de Propiedades')

@section('contenido')

<main class="contenedor section">
    <div class="admin-panel">
        <div class="admin-panel__header">
            @if(Auth::guard('seller')->check())
                <h1>Mis Propiedades</h1>
                <p>Gestiona tus propiedades en venta</p>
            @else
                <h1>Panel de Administración</h1>
                <p>Gestiona propiedades y vendedores</p>
            @endif
        </div>
        
        @if(!Auth::guard('seller')->check())
        <div class="admin-panel__actions">
            <a href="{{ route('admin.create') }}" class="btn btn--primary">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nueva Propiedad
            </a>
            <a href="{{ route('vendedores.create') }}" class="btn btn--secondary">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Nuevo Vendedor
            </a>
        </div>
        @endif

        <div class="admin-panel__content">
            @if (session('exito'))
                <div class="alerta exito">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('exito') }}
                </div>
            @endif

            <!-- Stats Cards -->
            @if(!Auth::guard('seller')->check())
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card__icon">🏠</div>
                    <div class="stat-card__number">{{ $propiedades->count() }}</div>
                    <p class="stat-card__label">Propiedades</p>
                </div>
                <div class="stat-card">
                    <div class="stat-card__icon">👥</div>
                    <div class="stat-card__number">{{ $vendedores->count() }}</div>
                    <p class="stat-card__label">Vendedores</p>
                </div>
                <div class="stat-card">
                    <div class="stat-card__icon">💰</div>
                    <div class="stat-card__number">Q.{{ number_format($propiedades->avg('precio'), 0) }}</div>
                    <p class="stat-card__label">Precio Promedio</p>
                </div>
                <div class="stat-card">
                    <div class="stat-card__icon">📈</div>
                    <div class="stat-card__number">{{ $propiedades->where('created_at', '>=', now()->subDays(30))->count() }}</div>
                    <p class="stat-card__label">Este Mes</p>
                </div>
            </div>
            @endif

            <!-- Tabla de Propiedades -->
            <div class="table-container">
                <div class="table-header">
                    <h2>Propiedades</h2>
                    <div class="table-stats">{{ $propiedades->count() }} propiedades encontradas</div>
                </div>
                
                <div class="table-responsive">
                    <table class="propiedades">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Imagen</th>
                                <th>Título</th>
                                <th>Precio</th>
                                <th>Características</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($propiedades as $propiedad)
                                <tr>
                                    <td><span class="badge badge--primary">#{{ $propiedad->id }}</span></td>
                                    <td>
                                        <img src="{{ asset('storage/propiedades') . '/' .$propiedad->imagen}}" 
                                             alt="{{ $propiedad->titulo }}" 
                                             class="imagen-tabla"
                                             loading="lazy">
                                    </td>
                                    <td>
                                        <div class="property-title">
                                            <strong>{{ Str::limit($propiedad->titulo, 30) }}</strong>
                                            <small>{{ Str::limit($propiedad->descripcion, 50) }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="price-tag">Q.{{ number_format($propiedad->precio, 0, '.', ',') }}</span>
                                    </td>
                                    <td>
                                        <div class="property-features">
                                            <span class="feature">🛏️ {{ $propiedad->habitaciones }}</span>
                                            <span class="feature">🚿 {{ $propiedad->wc }}</span>
                                            <span class="feature">🚗 {{ $propiedad->estacionamiento }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="{{ route('propiedad', $propiedad->id) }}" 
                                               class="btn btn--outline-primary btn--sm" 
                                               title="Ver propiedad">
                                                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.edit', $propiedad->id )}}" 
                                               class="btn btn--outline-secondary btn--sm"
                                               title="Editar propiedad">
                                                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.destroy', $propiedad->id )}}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn--outline-danger btn--sm"
                                                        title="Eliminar propiedad"
                                                        onclick="return confirm('¿Estás seguro de eliminar esta propiedad?')">
                                                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8">
                                        <div class="empty-state">
                                            <svg class="empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                            <h3>No hay propiedades</h3>
                                            <p>Agrega tu primera propiedad para comenzar</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if(!Auth::guard('seller')->check())
            <!-- Tabla de Vendedores -->
            <div class="table-container">
                <div class="table-header">
                    <h2>Vendedores</h2>
                    <div class="table-stats">{{ $vendedores->count() }} vendedores registrados</div>
                </div>
                
                <div class="table-responsive">
                    <table class="propiedades">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Propiedades</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($vendedores as $vendedor)
                                <tr>
                                    <td><span class="badge badge--secondary">#{{ $vendedor->id }}</span></td>
                                    <td>
                                        <div class="seller-info">
                                            <div class="seller-avatar">{{ substr($vendedor->nombre, 0, 1) }}</div>
                                            <strong>{{ $vendedor->nombre }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $vendedor->email ?? 'No especificado' }}</td>
                                    <td>{{ $vendedor->telefono }}</td>
                                    <td>
                                        <span class="badge badge--accent">{{ $vendedor->propiedades_count ?? 0 }}</span>
                                    </td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="{{ route('vendedores.edit', $vendedor->id )}}" 
                                               class="btn btn--outline-secondary btn--sm"
                                               title="Editar vendedor">
                                                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('vendedores.destroy', $vendedor->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn--outline-danger btn--sm"
                                                        title="Eliminar vendedor"
                                                        onclick="return confirm('¿Estás seguro de eliminar este vendedor?')">
                                                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8">
                                        <div class="empty-state">
                                            <svg class="empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <h3>No hay vendedores</h3>
                                            <p>Agrega el primer vendedor para comenzar</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</main>

@endsection

@push('styles')
<style>
.badge {
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.badge--primary {
    background-color: #dbeafe;
    color: #1e40af;
}

.badge--secondary {
    background-color: #fef3c7;
    color: #92400e;
}

.badge--accent {
    background-color: #d1fae5;
    color: #065f46;
}

.property-title {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.property-title small {
    color: #6b7280;
    font-size: 0.875rem;
}

.price-tag {
    font-weight: 700;
    color: #10b981;
    font-size: 1.125rem;
}

.property-features {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.feature {
    font-size: 0.875rem;
    color: #6b7280;
}

.seller-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.seller-avatar {
    width: 2rem;
    height: 2rem;
    background: linear-gradient(135deg, #f59e0b, #fbbf24);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 0.875rem;
}

.empty-state {
    padding: 3rem 1rem;
    text-align: center;
}

.empty-state__icon {
    width: 4rem;
    height: 4rem;
    margin: 0 auto 1rem;
    color: #9ca3af;
}

.empty-state h3 {
    color: #374151;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #6b7280;
    margin: 0;
}

.table-responsive {
    overflow-x: auto;
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .admin-panel__actions {
        flex-direction: column;
    }
    
    .table-actions {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .table-actions .btn {
        width: 100%;
    }
}
</style>
@endpush