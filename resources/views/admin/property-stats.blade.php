@extends('layout')

@section('titulo')
    Estadísticas de Propiedades
@endsection

@section('contenido')
<div class="contenedor seccion">
    <div class="encabezado-stats">
        <div>
            <h1>📊 Estadísticas de Propiedades</h1>
            <p class="descripcion">Análisis detallado del inventario de propiedades</p>
        </div>
        <div class="acciones-encabezado">
            <a href="{{ route('admin.stats') }}" class="boton boton-azul">Estadísticas Generales</a>
            <a href="{{ route('admin') }}" class="boton boton-verde">Ver Propiedades</a>
        </div>
    </div>

    <!-- Estadísticas Generales -->
    <div class="metricas-principales">
        <div class="metrica">
            <div class="metrica-icono">🏠</div>
            <div class="metrica-info">
                <span class="metrica-numero">{{ $stats['total_properties'] }}</span>
                <span class="metrica-label">Total Propiedades</span>
            </div>
        </div>
        <div class="metrica">
            <div class="metrica-icono">💰</div>
            <div class="metrica-info">
                <span class="metrica-numero">${{ number_format($stats['avg_price'], 0, ',', '.') }}</span>
                <span class="metrica-label">Precio Promedio</span>
            </div>
        </div>
        <div class="metrica">
            <div class="metrica-icono">📈</div>
            <div class="metrica-info">
                <span class="metrica-numero">${{ number_format($stats['max_price'], 0, ',', '.') }}</span>
                <span class="metrica-label">Precio Máximo</span>
            </div>
        </div>
        <div class="metrica">
            <div class="metrica-icono">📉</div>
            <div class="metrica-info">
                <span class="metrica-numero">${{ number_format($stats['min_price'], 0, ',', '.') }}</span>
                <span class="metrica-label">Precio Mínimo</span>
            </div>
        </div>
    </div>

    <!-- Estadísticas de Características -->
    <div class="metricas-hoy">
        <h2>🏗️ Características Promedio</h2>
        <div class="metricas-principales">
            <div class="metrica">
                <div class="metrica-icono">🛏️</div>
                <div class="metrica-info">
                    <span class="metrica-numero">{{ number_format($stats['avg_bedrooms'], 1) }}</span>
                    <span class="metrica-label">Habitaciones</span>
                </div>
            </div>
            <div class="metrica">
                <div class="metrica-icono">🚿</div>
                <div class="metrica-info">
                    <span class="metrica-numero">{{ number_format($stats['avg_bathrooms'], 1) }}</span>
                    <span class="metrica-label">Baños</span>
                </div>
            </div>
            <div class="metrica">
                <div class="metrica-icono">🚗</div>
                <div class="metrica-info">
                    <span class="metrica-numero">{{ number_format($stats['avg_parking'], 1) }}</span>
                    <span class="metrica-label">Estacionamientos</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gráficas -->
{{-- <div class="charts-container">
    <h2>📊 Análisis Visual</h2>

    <!-- Gráfica de Rangos de Precio -->
    <div class="chart-box">
        <h3>Propiedades por Rango de Precio</h3>
        <canvas id="priceRangeChart"></canvas>
    </div>

    <!-- Gráfica de Habitaciones -->
    <div class="chart-box">
        <h3>Distribución por Habitaciones</h3>
        <canvas id="bedroomChart"></canvas>
    </div>

    <!-- Gráfica de Baños -->
    <div class="chart-box">
        <h3>Distribución por Baños</h3>
        <canvas id="bathroomChart"></canvas>
    </div>

    <!-- Gráfica de Estacionamiento -->
    <div class="chart-box">
        <h3>Distribución por Estacionamientos</h3>
        <canvas id="parkingChart"></canvas>
    </div>

    <!-- Gráfica Mensual -->
    <div class="chart-box">
        <h3>Propiedades Creadas por Mes</h3>
        <canvas id="monthlyChart"></canvas>
    </div>
</div> --}}

<!-- Tabla de Vendedores -->
<div class="contenedor seccion">
    <h2>🏆 Top Vendedores por Propiedades</h2>
    <div class="tabla-responsive">
        <table class="tabla-propiedades">
            <thead>
                <tr>
                    <th>Vendedor</th>
                    <th>Cantidad</th>
                    <th>Precio Promedio</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sellerStats as $seller)
                <tr>
                    <td>{{ $seller['seller_name'] }}</td>
                    <td>{{ $seller['count'] }}</td>
                    <td>${{ number_format($seller['avg_price'], 0, ',', '.') }}</td>
                    <td>${{ number_format($seller['total_value'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Gráfica de rangos de precio
    const priceRangeCtx = document.getElementById('priceRangeChart').getContext('2d');
    const priceRangeData = {
        labels: ['0-100k', '100k-200k', '200k-300k', '300k-500k', '500k+'],
        datasets: [{
            label: 'Propiedades',
            data: [
                {{ $priceRanges['0-100000'] }},
                {{ $priceRanges['100001-200000'] }},
                {{ $priceRanges['200001-300000'] }},
                {{ $priceRanges['300001-500000'] }},
                {{ $priceRanges['500001+'] }}
            ],
            backgroundColor: [
                'rgba(75, 192, 192, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(255, 99, 132, 0.7)',
                'rgba(153, 102, 255, 0.7)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
        }]
    };

    new Chart(priceRangeCtx, {
        type: 'bar',
        data: priceRangeData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });

    // Gráfica de habitaciones
    const bedroomCtx = document.getElementById('bedroomChart').getContext('2d');
    const bedroomData = {
        labels: [{{ collect($bedroomStats)->keys()->map(fn($k) => "'$k'")->join(',') }}],
        datasets: [{
            label: 'Propiedades',
            data: [{{ collect($bedroomStats)->values()->join(',') }}],
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    };

    new Chart(bedroomCtx, {
        type: 'bar',
        data: bedroomData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });

    // Gráfica de baños
    const bathroomCtx = document.getElementById('bathroomChart').getContext('2d');
    const bathroomData = {
        labels: [{{ collect($bathroomStats)->keys()->map(fn($k) => "'$k'")->join(',') }}],
        datasets: [{
            label: 'Propiedades',
            data: [{{ collect($bathroomStats)->values()->join(',') }}],
            backgroundColor: 'rgba(255, 206, 86, 0.7)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 1
        }]
    };

    new Chart(bathroomCtx, {
        type: 'bar',
        data: bathroomData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });

    // Gráfica de estacionamiento
    const parkingCtx = document.getElementById('parkingChart').getContext('2d');
    const parkingData = {
        labels: [{{ collect($parkingStats)->keys()->map(fn($k) => "'$k'")->join(',') }}],
        datasets: [{
            label: 'Propiedades',
            data: [{{ collect($parkingStats)->values()->join(',') }}],
            backgroundColor: 'rgba(75, 192, 192, 0.7)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    };

    new Chart(parkingCtx, {
        type: 'bar',
        data: parkingData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });

    // Gráfica mensual
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyData = {
        labels: [{{ collect($monthlyStats)->pluck('month')->map(fn($m) => "'$m'")->join(',') }}],
        datasets: [{
            label: 'Propiedades Creadas',
            data: [{{ collect($monthlyStats)->pluck('count')->join(',') }}],
            backgroundColor: 'rgba(255, 99, 132, 0.7)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    };

    new Chart(monthlyCtx, {
        type: 'line',
        data: monthlyData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
});
</script>
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
    font-size: 2rem;
    font-weight: bold;
    color: #2c5aa0;
    line-height: 1;
}

.dark-mode .metrica-numero {
    color: #3498db;
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

.charts-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
    gap: 2rem;
    margin: 3rem 0;
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

.tabla-responsive {
    overflow-x: auto;
    margin-top: 2rem;
}

.tabla-propiedades {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.dark-mode .tabla-propiedades {
    background: #34495e;
}

.tabla-propiedades th,
.tabla-propiedades td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.dark-mode .tabla-propiedades th,
.dark-mode .tabla-propiedades td {
    border-bottom-color: #4a6174;
}

.tabla-propiedades th {
    background: #f8f9fa;
    font-weight: 600;
    color: #333;
}

.dark-mode .tabla-propiedades th {
    background: #2c3e50;
    color: #ecf0f1;
}

.tabla-propiedades tbody tr:hover {
    background: #f8f9fa;
}

.dark-mode .tabla-propiedades tbody tr:hover {
    background: #2c3e50;
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

    .metrica {
        flex-direction: column;
        text-align: center;
    }

    .metrica-icono {
        font-size: 2rem;
    }
}

@media (max-width: 480px) {
    .metricas-principales {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
