@extends('layout')

@section('titulo')
    Estadísticas del Sistema
@endsection

@section('contenido')
<div class="contenedor seccion">
    <div class="encabezado-stats">
        <div>
            <h1>📊 Estadísticas del Sistema</h1>
            <p class="descripcion">Resumen general del panel de administración</p>
        </div>
        <div class="acciones-encabezado">
            <a href="{{ route('vendedores.index') }}" class="boton boton-azul">Ver Vendedores</a>
            <a href="{{ route('admin.propertyStats') }}" class="boton boton-amarillo-block">Estadísticas de Propiedades</a>
            <a href="{{ route('audits.stats') }}" class="boton boton-verde">Auditorías</a>
        </div>
    </div>

    <!-- Métricas principales -->
    <div class="metricas-principales">
        <div class="metrica">
            <div class="metrica-icono">🏠</div>
            <div class="metrica-info">
                <span class="metrica-numero">{{ $stats['total_properties'] }}</span>
                <span class="metrica-label">Total Propiedades</span>
            </div>
        </div>
        <div class="metrica">
            <div class="metrica-icono">👨‍💼</div>
            <div class="metrica-info">
                <span class="metrica-numero">{{ $stats['total_sellers'] }}</span>
                <span class="metrica-label">Total Vendedores</span>
            </div>
        </div>
        <div class="metrica">
            <div class="metrica-icono">👤</div>
            <div class="metrica-info">
                <span class="metrica-numero">{{ $stats['total_users'] }}</span>
                <span class="metrica-label">Total Usuarios</span>
            </div>
        </div>
        <div class="metrica">
            <div class="metrica-icono">📋</div>
            <div class="metrica-info">
                <span class="metrica-numero">{{ $stats['total_audits'] }}</span>
                <span class="metrica-label">Total Auditorías</span>
            </div>
        </div>
    </div>

    <!-- Métricas de hoy -->
    <div class="metricas-hoy">
        <h2>📅 Actividad de Hoy</h2>
        <div class="metricas-principales">
            <div class="metrica">
                <div class="metrica-icono">🏠</div>
                <div class="metrica-info">
                    <span class="metrica-numero">{{ $stats['properties_today'] }}</span>
                    <span class="metrica-label">Propiedades Creadas</span>
                </div>
            </div>
            <div class="metrica">
                <div class="metrica-icono">👨‍💼</div>
                <div class="metrica-info">
                    <span class="metrica-numero">{{ $stats['sellers_today'] }}</span>
                    <span class="metrica-label">Vendedores Registrados</span>
                </div>
            </div>
            <div class="metrica">
                <div class="metrica-icono">👤</div>
                <div class="metrica-info">
                    <span class="metrica-numero">{{ $stats['users_today'] }}</span>
                    <span class="metrica-label">Usuarios Registrados</span>
                </div>
            </div>
            <div class="metrica">
                <div class="metrica-icono">📋</div>
                <div class="metrica-info">
                    <span class="metrica-numero">{{ $stats['audits_today'] }}</span>
                    <span class="metrica-label">Eventos de Auditoría</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="export-excel" style="margin-top: 2rem; text-align: center;">
    <a href="{{ route('admin.exportExcel') }}" class="boton boton-verde" style="padding: 0.75rem 1.5rem; font-size: 1.1rem; border-radius: 8px; display: inline-block;">Exportar Todo a Excel</a>
</div>

<div class="charts-container" style="margin-top: 3rem;">
    <h2>Gráficas de Estadísticas</h2>
    <div class="chart-box">
        <h3>Estadísticas Totales</h3>
        <canvas id="chartTotal" width="400" height="200"></canvas>
    </div>
    <div class="chart-box">
        <h3>Actividad de Hoy</h3>
        <canvas id="chartToday" width="400" height="200"></canvas>
    </div>
</div>

@push('scripts')
    @include('admin.stats-scripts')
@endpush

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

.metricas-hoy {
    margin-top: 3rem;
}

.metricas-hoy h2 {
    text-align: center;
    margin-bottom: 2rem;
    color: #333;
    font-size: 1.5rem;
}

.dark-mode .metricas-hoy h2 {
    color: #ecf0f1;
}

.acciones-encabezado {
    display: flex;
    gap: 1rem;
}

.boton-verde {
    background-color: #28a745;
    color: white;
}

.boton-verde:hover {
    background-color: #218838;
}

.boton-naranja {
    background-color: #fd7e14;
    color: white;
}

.boton-naranja:hover {
    background-color: #e8680f;
}

.charts-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.charts-container h2 {
    grid-column: 1 / -1;
    text-align: center;
    margin-bottom: 2rem;
    color: #333;
    font-size: 1.5rem;
}

.dark-mode .charts-container h2 {
    color: #ecf0f1;
}

.chart-box {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    border: 1px solid transparent;
    transition: all 0.3s ease;
}

.chart-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

.dark-mode .chart-box {
    background: #34495e;
    border-color: #4a6174;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

.dark-mode .chart-box:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.4);
    border-color: #3498db;
}

.chart-box h3 {
    text-align: center;
    margin-bottom: 1rem;
    color: #333;
    font-size: 1.2rem;
    font-weight: 600;
}

.dark-mode .chart-box h3 {
    color: #ecf0f1;
}

.chart-box canvas {
    max-width: 100%;
    height: auto !important;
    width: 100% !important;
}

/* Responsive */
@media (max-width: 768px) {
    .metricas-principales {
        grid-template-columns: repeat(2, 1fr);
    }

    .encabezado-stats {
        flex-direction: column;
        gap: 1rem;
    }

    .acciones-encabezado {
        flex-direction: column;
        width: 100%;
    }

    .acciones-encabezado .boton {
        width: 100%;
        text-align: center;
    }

    .charts-container {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
}

@media (max-width: 480px) {
    .metricas-principales {
        grid-template-columns: 1fr;
    }

    .metrica {
        flex-direction: column;
        text-align: center;
    }

    .metrica-icono {
        font-size: 2rem;
    }
}
</style>
@endsection
