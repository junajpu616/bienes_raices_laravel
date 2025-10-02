@extends('layout')

@section('titulo')
    Estadísticas de Auditoría
@endsection

@section('contenido')
<div class="contenedor seccion">
    <div class="encabezado-stats">
        <div>
            <h1>📊 Estadísticas de Auditoría</h1>
            <p class="descripcion">Resumen de actividad del sistema</p>
        </div>
        <div class="acciones-encabezado">
            <a href="{{ route('audits.index') }}" class="boton boton-azul">Ver Auditorías</a>
        </div>
    </div>

    <!-- Métricas principales -->
    <div class="metricas-principales">
        <div class="metrica">
            <div class="metrica-icono">📈</div>
            <div class="metrica-info">
                <span class="metrica-numero">{{ $stats['total_events'] }}</span>
                <span class="metrica-label">Total Eventos</span>
            </div>
        </div>
        <div class="metrica">
            <div class="metrica-icono">📅</div>
            <div class="metrica-info">
                <span class="metrica-numero">{{ $stats['events_today'] }}</span>
                <span class="metrica-label">Hoy</span>
            </div>
        </div>
        <div class="metrica">
            <div class="metrica-icono">📋</div>
            <div class="metrica-info">
                <span class="metrica-numero">{{ $stats['events_this_week'] }}</span>
                <span class="metrica-label">Esta Semana</span>
            </div>
        </div>
        <div class="metrica">
            <div class="metrica-icono">🗓️</div>
            <div class="metrica-info">
                <span class="metrica-numero">{{ $stats['events_this_month'] }}</span>
                <span class="metrica-label">Este Mes</span>
            </div>
        </div>
    </div>

    <div class="stats-grid">
        <!-- Eventos por tipo -->
        <div class="stat-card">
            <h3>📊 Eventos por Tipo</h3>
            <div class="chart-container">
                @foreach($stats['by_event'] as $event => $count)
                    <div class="bar-item">
                        <div class="bar-label">
                            @if($event == 'created')
                                ✅ Creaciones
                            @elseif($event == 'updated')
                                ✏️ Modificaciones
                            @elseif($event == 'deleted')
                                🗑️ Eliminaciones
                            @endif
                        </div>
                        <div class="bar-container">
                            <div class="bar bar-{{ $event }}" style="width: {{ $stats['total_events'] > 0 ? ($count / $stats['total_events']) * 100 : 0 }}%"></div>
                            <span class="bar-value">{{ $count }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Eventos por modelo -->
        <div class="stat-card">
            <h3>🏠 Eventos por Modelo</h3>
            <div class="chart-container">
                @foreach($stats['by_model'] as $model => $count)
                    <div class="bar-item">
                        <div class="bar-label">
                            @if($model == 'Property')
                                🏠 Propiedades
                            @elseif($model == 'Seller')
                                👨‍💼 Vendedores
                            @elseif($model == 'User')
                                👤 Usuarios
                            @else
                                {{ $model }}
                            @endif
                        </div>
                        <div class="bar-container">
                            <div class="bar bar-model" style="width: {{ $stats['total_events'] > 0 ? ($count / $stats['total_events']) * 100 : 0 }}%"></div>
                            <span class="bar-value">{{ $count }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Usuarios más activos -->
        <div class="stat-card">
            <h3>👥 Usuarios Más Activos</h3>
            <div class="users-list">
                @forelse($stats['top_users'] as $user)
                    <div class="user-item">
                        <div class="user-info">
                            <span class="user-name">{{ $user->user_name }}</span>
                            <small class="user-type">{{ class_basename($user->user_type) }}</small>
                        </div>
                        <span class="user-count">{{ $user->count }} eventos</span>
                    </div>
                @empty
                    <p class="sin-datos">No hay datos de usuarios disponibles</p>
                @endforelse
            </div>
        </div>

        <!-- Actividad reciente -->
        <div class="stat-card">
            <h3>⚡ Actividad Reciente</h3>
            <div class="activity-list">
                @forelse($stats['recent_activity'] as $activity)
                    <div class="activity-item">
                        <div class="activity-icon">
                            @if($activity->event == 'created')
                                ✅
                            @elseif($activity->event == 'updated')
                                ✏️
                            @elseif($activity->event == 'deleted')
                                🗑️
                            @endif
                        </div>
                        <div class="activity-content">
                            <div class="activity-description">
                                <strong>{{ $activity->user_name ?? 'Sistema' }}</strong>
                                @if($activity->event == 'created')
                                    creó
                                @elseif($activity->event == 'updated')
                                    modificó
                                @elseif($activity->event == 'deleted')
                                    eliminó
                                @endif
                                {{ class_basename($activity->auditable_type) }} #{{ $activity->auditable_id }}
                            </div>
                            <div class="activity-time">{{ $activity->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="activity-action">
                            @if($activity->auditable)
                                <a href="{{ route('audits.show', [
                                    'model' => strtolower(class_basename($activity->auditable_type)), 
                                    'id' => $activity->auditable_id
                                ]) }}" class="boton boton-pequeno boton-azul">
                                    Ver
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="sin-datos">No hay actividad reciente</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
.encabezado-stats {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #eee;
    transition: all 0.3s ease;
}

.dark-mode .encabezado-stats {
    border-bottom-color: #4a6174;
}

.dark-mode .encabezado-stats h1 {
    color: #ecf0f1;
}

.dark-mode .descripcion {
    color: #bdc3c7;
}

.metricas-principales {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.metrica {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.metrica:hover {
    transform: translateY(-2px);
}

.dark-mode .metrica {
    background: #34495e;
    border-color: #4a6174;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

.dark-mode .metrica:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.4);
    border-color: #3498db;
}

.metrica-icono {
    font-size: 2.5rem;
    opacity: 0.8;
}

.metrica-numero {
    display: block;
    font-size: 2.5rem;
    font-weight: bold;
    color: #2c5aa0;
    line-height: 1;
}

.metrica-label {
    color: #666;
    font-size: 0.9rem;
    font-weight: 500;
}

.dark-mode .metrica-label {
    color: #bdc3c7;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
}

.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    border: 1px solid transparent;
    transition: all 0.3s ease;
}

.dark-mode .stat-card {
    background: #2c3e50;
    border-color: #34495e;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

.stat-card h3 {
    margin: 0 0 1.5rem 0;
    color: #333;
    font-size: 1.2rem;
}

.dark-mode .stat-card h3 {
    color: #ecf0f1;
}

.chart-container {
    space-y: 1rem;
}

.bar-item {
    margin-bottom: 1rem;
}

.bar-label {
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: #333;
}

.dark-mode .bar-label {
    color: #ecf0f1;
}

.bar-container {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.bar {
    height: 24px;
    border-radius: 12px;
    min-width: 20px;
    position: relative;
    transition: width 0.3s ease;
}

.bar-created { background: linear-gradient(90deg, #28a745, #34ce57); }
.bar-updated { background: linear-gradient(90deg, #ffc107, #ffcd39); }
.bar-deleted { background: linear-gradient(90deg, #dc3545, #e74c3c); }
.bar-model { background: linear-gradient(90deg, #2c5aa0, #3d6bb3); }

.bar-value {
    font-weight: 600;
    color: #333;
    min-width: 30px;
}

.dark-mode .bar-value {
    color: #ecf0f1;
}

.users-list {
    max-height: 300px;
    overflow-y: auto;
}

.user-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #eee;
    transition: all 0.3s ease;
}

.dark-mode .user-item {
    border-bottom-color: #4a6174;
}

.dark-mode .user-item:hover {
    background: rgba(52, 152, 219, 0.1);
    padding-left: 0.5rem;
    border-radius: 4px;
}

.user-item:last-child {
    border-bottom: none;
}

.user-name {
    font-weight: 500;
    color: #333;
}

.user-type {
    color: #666;
    margin-left: 0.5rem;
}

.dark-mode .user-name {
    color: #ecf0f1;
}

.dark-mode .user-type {
    color: #bdc3c7;
}

.user-count {
    color: #2c5aa0;
    font-weight: 600;
}

.activity-list {
    max-height: 400px;
    overflow-y: auto;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid #eee;
    transition: all 0.3s ease;
}

.dark-mode .activity-item {
    border-bottom-color: #4a6174;
}

.dark-mode .activity-item:hover {
    background: rgba(52, 152, 219, 0.1);
    padding-left: 0.5rem;
    border-radius: 4px;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    font-size: 1.2rem;
    width: 30px;
    text-align: center;
}

.activity-content {
    flex: 1;
}

.activity-description {
    font-size: 0.95rem;
    color: #333;
    margin-bottom: 0.25rem;
}

.activity-time {
    font-size: 0.8rem;
    color: #666;
}

.dark-mode .activity-description {
    color: #ecf0f1;
}

.dark-mode .activity-time {
    color: #bdc3c7;
}

.sin-datos {
    text-align: center;
    color: #666;
    padding: 2rem;
    font-style: italic;
}

.dark-mode .sin-datos {
    color: #95a5a6;
}

.boton-pequeno {
    padding: 0.25rem 0.75rem;
    font-size: 0.8rem;
}

/* Mejoras adicionales para dark mode */
.dark-mode .users-list {
    background: rgba(52, 73, 94, 0.2);
    border-radius: 8px;
    padding: 1rem;
    margin-top: 0.5rem;
}

.dark-mode .activity-list {
    background: rgba(52, 73, 94, 0.2);
    border-radius: 8px;
    padding: 1rem;
    margin-top: 0.5rem;
}

.dark-mode .chart-container {
    background: rgba(52, 73, 94, 0.2);
    border-radius: 8px;
    padding: 1rem;
    margin-top: 0.5rem;
}

/* Efectos de hover mejorados para dark mode */
.dark-mode .stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.4);
    border-color: #3498db;
}

/* Scrollbars personalizados para dark mode */
.dark-mode .users-list::-webkit-scrollbar,
.dark-mode .activity-list::-webkit-scrollbar {
    width: 8px;
}

.dark-mode .users-list::-webkit-scrollbar-track,
.dark-mode .activity-list::-webkit-scrollbar-track {
    background: #34495e;
    border-radius: 4px;
}

.dark-mode .users-list::-webkit-scrollbar-thumb,
.dark-mode .activity-list::-webkit-scrollbar-thumb {
    background: #4a6174;
    border-radius: 4px;
}

.dark-mode .users-list::-webkit-scrollbar-thumb:hover,
.dark-mode .activity-list::-webkit-scrollbar-thumb:hover {
    background: #3498db;
}

/* Animaciones mejoradas */
.dark-mode .bar {
    position: relative;
    overflow: hidden;
}

.dark-mode .bar::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    100% {
        left: 100%;
    }
}

/* Responsive para dark mode */
@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .metricas-principales {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .encabezado-stats {
        flex-direction: column;
        gap: 1rem;
    }
    
    .dark-mode .metrica {
        padding: 1.5rem;
    }
    
    .dark-mode .stat-card {
        padding: 1rem;
    }
    
    .dark-mode .activity-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .dark-mode .activity-action {
        width: 100%;
        text-align: right;
    }
}

@media (max-width: 480px) {
    .dark-mode .metricas-principales {
        grid-template-columns: 1fr;
    }
    
    .dark-mode .metrica {
        flex-direction: column;
        text-align: center;
    }
    
    .dark-mode .metrica-icono {
        font-size: 2rem;
    }
}
</style>
@endsection