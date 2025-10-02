@extends('layout')

@section('titulo')
    Historial de {{ ucfirst($model) }} #{{ $modelInstance->id }}
@endsection

@section('contenido')
<div class="contenedor seccion">
    <div class="encabezado-historial">
        <div>
            <h1>📋 Historial de {{ class_basename($modelInstance) }}</h1>
            <p class="subtitulo">
                Registro #{{ $modelInstance->id }} - 
                @if($modelInstance instanceof App\Models\Property)
                    "{{ $modelInstance->titulo }}"
                @elseif($modelInstance instanceof App\Models\Seller)
                    "{{ $modelInstance->nombre }} {{ $modelInstance->apellido }}"
                @elseif($modelInstance instanceof App\Models\User)
                    "{{ $modelInstance->name }}"
                @endif
            </p>
        </div>
        <div class="acciones-encabezado">
            <a href="{{ route('audits.index') }}" class="boton boton-gris">← Volver a Auditoría</a>
        </div>
    </div>

    <!-- Información actual del registro -->
    <div class="info-actual">
        <h3>📊 Estado Actual</h3>
        <div class="datos-actuales">
            @if($modelInstance instanceof App\Models\Property)
                <div class="dato">
                    <label>Título:</label>
                    <span>{{ $modelInstance->titulo }}</span>
                </div>
                <div class="dato">
                    <label>Precio:</label>
                    <span>${{ number_format($modelInstance->precio) }}</span>
                </div>
                <div class="dato">
                    <label>Habitaciones:</label>
                    <span>{{ $modelInstance->habitaciones }}</span>
                </div>
                <div class="dato">
                    <label>Vendedor:</label>
                    <span>{{ $modelInstance->vendedor->nombre ?? 'N/A' }} {{ $modelInstance->vendedor->apellido ?? '' }}</span>
                </div>
            @elseif($modelInstance instanceof App\Models\Seller)
                <div class="dato">
                    <label>Nombre:</label>
                    <span>{{ $modelInstance->nombre }} {{ $modelInstance->apellido }}</span>
                </div>
                <div class="dato">
                    <label>Email:</label>
                    <span>{{ $modelInstance->email }}</span>
                </div>
                <div class="dato">
                    <label>Teléfono:</label>
                    <span>{{ $modelInstance->telefono }}</span>
                </div>
                <div class="dato">
                    <label>Es Admin:</label>
                    <span>{{ $modelInstance->is_admin ? 'Sí' : 'No' }}</span>
                </div>
            @elseif($modelInstance instanceof App\Models\User)
                <div class="dato">
                    <label>Nombre:</label>
                    <span>{{ $modelInstance->name }}</span>
                </div>
                <div class="dato">
                    <label>Email:</label>
                    <span>{{ $modelInstance->email }}</span>
                </div>
                <div class="dato">
                    <label>Es Admin:</label>
                    <span>{{ $modelInstance->is_admin ? 'Sí' : 'No' }}</span>
                </div>
            @endif
            <div class="dato">
                <label>Creado:</label>
                <span>{{ $modelInstance->created_at->format('d/m/Y H:i:s') }}</span>
            </div>
            <div class="dato">
                <label>Actualizado:</label>
                <span>{{ $modelInstance->updated_at->format('d/m/Y H:i:s') }}</span>
            </div>
        </div>
    </div>

    <!-- Línea de tiempo de cambios -->
    <div class="timeline-auditoria">
        <h3>⏰ Línea de Tiempo de Cambios</h3>
        
        @if($audits->count() > 0)
            <div class="timeline">
                @foreach($audits as $audit)
                    <div class="timeline-item timeline-{{ $audit->event }}">
                        <div class="timeline-marker">
                            @if($audit->event == 'created')
                                ✅
                            @elseif($audit->event == 'updated')
                                ✏️
                            @elseif($audit->event == 'deleted')
                                🗑️
                            @endif
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <h4>
                                    @if($audit->event == 'created')
                                        Registro Creado
                                    @elseif($audit->event == 'updated')
                                        Registro Modificado
                                    @elseif($audit->event == 'deleted')
                                        Registro Eliminado
                                    @endif
                                </h4>
                                <div class="timeline-meta">
                                    <span class="fecha">{{ $audit->created_at->format('d/m/Y H:i:s') }}</span>
                                    <span class="usuario">por {{ $audit->user_name ?? 'Sistema' }}</span>
                                    <span class="ip">desde {{ $audit->ip_address }}</span>
                                </div>
                            </div>
                            
                            @php
                                $changes = $audit->getChanges();
                            @endphp
                            
                            @if(count($changes) > 0)
                                <div class="timeline-cambios">
                                    @if($audit->event == 'created')
                                        <h5>Datos iniciales:</h5>
                                        <ul class="lista-cambios-detalle">
                                            @foreach($changes as $field => $value)
                                                <li>
                                                    <span class="campo">{{ $field }}</span>: 
                                                    <span class="valor-nuevo">{{ $value }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @elseif($audit->event == 'deleted')
                                        <h5>Datos antes de eliminar:</h5>
                                        <ul class="lista-cambios-detalle">
                                            @foreach($changes as $field => $value)
                                                <li>
                                                    <span class="campo">{{ $field }}</span>: 
                                                    <span class="valor-eliminado">{{ $value }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <h5>Campos modificados:</h5>
                                        <ul class="lista-cambios-detalle">
                                            @foreach($changes as $field => $change)
                                                <li>
                                                    <span class="campo">{{ $field }}</span>:
                                                    @if(is_array($change))
                                                        <div class="comparacion">
                                                            <span class="valor-anterior">{{ $change['old'] ?? 'null' }}</span>
                                                            <span class="flecha">→</span>
                                                            <span class="valor-nuevo">{{ $change['new'] ?? 'null' }}</span>
                                                        </div>
                                                    @else
                                                        <span class="valor-nuevo">{{ $change }}</span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="sin-historial">
                <p>📭 No hay historial disponible para este registro.</p>
            </div>
        @endif
    </div>

    <!-- Estadísticas del registro -->
    <div class="estadisticas-registro">
        <h3>📈 Estadísticas</h3>
        <div class="stats-grid">
            <div class="stat-item">
                <span class="stat-numero">{{ $audits->count() }}</span>
                <span class="stat-label">Total Cambios</span>
            </div>
            <div class="stat-item">
                <span class="stat-numero">{{ $audits->where('event', 'updated')->count() }}</span>
                <span class="stat-label">Modificaciones</span>
            </div>
            <div class="stat-item">
                <span class="stat-numero">{{ $audits->unique('user_name')->count() }}</span>
                <span class="stat-label">Usuarios Distintos</span>
            </div>
            <div class="stat-item">
                <span class="stat-numero">{{ $audits->first() ? $audits->first()->created_at->diffForHumans() : 'N/A' }}</span>
                <span class="stat-label">Último Cambio</span>
            </div>
        </div>
    </div>
</div>

<style>
.encabezado-historial {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #eee;
    transition: all 0.3s ease;
}

.dark-mode .encabezado-historial {
    border-bottom-color: #4a6174;
}

.dark-mode .encabezado-historial h1 {
    color: #ecf0f1;
}

.subtitulo {
    color: #666;
    font-size: 1.1rem;
    margin: 0.5rem 0;
}

.dark-mode .subtitulo {
    color: #bdc3c7;
}

.info-actual {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    margin-bottom: 2rem;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.dark-mode .info-actual {
    background: #2c3e50;
    border-color: #34495e;
}

.dark-mode .info-actual h3 {
    color: #ecf0f1;
}

.datos-actuales {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.dato {
    display: flex;
    flex-direction: column;
}

.dato label {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.25rem;
}

.dato span {
    color: #666;
    padding: 0.5rem;
    background: white;
    border-radius: 4px;
    border: 1px solid #ddd;
    transition: all 0.3s ease;
}

.dark-mode .dato label {
    color: #ecf0f1;
}

.dark-mode .dato span {
    color: #bdc3c7;
    background: #34495e;
    border-color: #4a6174;
}

.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 1rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #ddd;
    transition: all 0.3s ease;
}

.dark-mode .timeline::before {
    background: #4a6174;
}

.dark-mode .timeline-auditoria h3 {
    color: #ecf0f1;
}

.timeline-item {
    position: relative;
    margin-bottom: 2rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border: 1px solid transparent;
    transition: all 0.3s ease;
}

.dark-mode .timeline-item {
    background: #34495e;
    border-color: #4a6174;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
}

.timeline-marker {
    position: absolute;
    left: -2.5rem;
    top: 1rem;
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    background: white;
    border: 3px solid #ddd;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    transition: all 0.3s ease;
}

.dark-mode .timeline-marker {
    background: #2c3e50;
    border-color: #4a6174;
}

.timeline-created .timeline-marker { border-color: #28a745; }
.timeline-updated .timeline-marker { border-color: #ffc107; }
.timeline-deleted .timeline-marker { border-color: #dc3545; }

.timeline-content {
    padding: 1.5rem;
}

.timeline-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.timeline-header h4 {
    margin: 0;
    color: #333;
}

.dark-mode .timeline-header h4 {
    color: #ecf0f1;
}

.timeline-meta {
    text-align: right;
    font-size: 0.9rem;
    color: #666;
}

.dark-mode .timeline-meta {
    color: #bdc3c7;
}

.timeline-meta span {
    display: block;
    margin-bottom: 0.25rem;
}

.lista-cambios-detalle {
    margin: 0;
    padding: 0;
    list-style: none;
}

.lista-cambios-detalle li {
    padding: 0.5rem 0;
    border-bottom: 1px solid #eee;
}

.dark-mode .lista-cambios-detalle li {
    border-bottom-color: #4a6174;
}

.lista-cambios-detalle li:last-child {
    border-bottom: none;
}

.campo {
    font-weight: 600;
    color: #333;
}

.dark-mode .campo {
    color: #ecf0f1;
}

.dark-mode .timeline-cambios h5 {
    color: #ecf0f1;
}

.comparacion {
    margin-top: 0.25rem;
}

.valor-anterior {
    color: #dc3545;
    text-decoration: line-through;
    background: #f8d7da;
    padding: 0.2rem 0.4rem;
    border-radius: 3px;
}

.valor-nuevo {
    color: #28a745;
    background: #d4edda;
    padding: 0.2rem 0.4rem;
    border-radius: 3px;
    font-weight: 500;
}

.valor-eliminado {
    color: #dc3545;
    background: #f8d7da;
    padding: 0.2rem 0.4rem;
    border-radius: 3px;
}

.dark-mode .valor-anterior {
    color: #e74c3c;
    background: rgba(231, 76, 60, 0.2);
}

.dark-mode .valor-nuevo {
    color: #27ae60;
    background: rgba(39, 174, 96, 0.2);
}

.dark-mode .valor-eliminado {
    color: #e74c3c;
    background: rgba(231, 76, 60, 0.2);
}

.flecha {
    margin: 0 0.5rem;
    color: #666;
    font-weight: bold;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.stat-item {
    background: white;
    padding: 1rem;
    text-align: center;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border: 1px solid transparent;
    transition: all 0.3s ease;
}

.dark-mode .stat-item {
    background: #34495e;
    border-color: #4a6174;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
}

.stat-numero {
    display: block;
    font-size: 1.5rem;
    font-weight: bold;
    color: #2c5aa0;
}

.stat-label {
    color: #666;
    font-size: 0.9rem;
}

.dark-mode .stat-label {
    color: #bdc3c7;
}

.dark-mode .estadisticas-registro h3 {
    color: #ecf0f1;
}

.sin-historial {
    text-align: center;
    padding: 2rem;
    color: #666;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.dark-mode .sin-historial {
    color: #bdc3c7;
    background: #2c3e50;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
}

/* Mejoras adicionales para dark mode */
.dark-mode .flecha {
    color: #95a5a6;
}

.dark-mode .comparacion {
    background: rgba(52, 73, 94, 0.3);
    padding: 0.5rem;
    border-radius: 4px;
    margin: 0.25rem 0;
}

/* Responsive para dark mode */
@media (max-width: 768px) {
    .dark-mode .encabezado-historial {
        flex-direction: column;
        gap: 1rem;
    }
    
    .dark-mode .datos-actuales {
        grid-template-columns: 1fr;
    }
    
    .dark-mode .timeline {
        padding-left: 1rem;
    }
    
    .dark-mode .timeline-marker {
        left: -1.5rem;
        width: 1.5rem;
        height: 1.5rem;
    }
}
</style>
@endsection