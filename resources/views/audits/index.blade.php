@extends('layout')

@section('titulo')
    Auditoría del Sistema
@endsection

@section('contenido')
<div class="contenedor seccion">
    <h1>🔍 Auditoría del Sistema</h1>
    <p class="descripcion">Historial completo de cambios en el sistema</p>

    <!-- Filtros -->
    <div class="filtros-auditoria">
        <form method="GET" action="{{ route('audits.index') }}" class="formulario-filtros">
            <div class="campo-grupo">
                <div class="campo">
                    <label for="model">Modelo:</label>
                    <select name="model" id="model">
                        <option value="">Todos los modelos</option>
                        <option value="App\Models\Property" {{ request('model') == 'App\Models\Property' ? 'selected' : '' }}>Propiedades</option>
                        <option value="App\Models\Seller" {{ request('model') == 'App\Models\Seller' ? 'selected' : '' }}>Vendedores</option>
                        <option value="App\Models\User" {{ request('model') == 'App\Models\User' ? 'selected' : '' }}>Usuarios</option>
                    </select>
                </div>

                <div class="campo">
                    <label for="event">Evento:</label>
                    <select name="event" id="event">
                        <option value="">Todos los eventos</option>
                        <option value="created" {{ request('event') == 'created' ? 'selected' : '' }}>Creación</option>
                        <option value="updated" {{ request('event') == 'updated' ? 'selected' : '' }}>Modificación</option>
                        <option value="deleted" {{ request('event') == 'deleted' ? 'selected' : '' }}>Eliminación</option>
                    </select>
                </div>

                <div class="campo">
                    <label for="date_from">Desde:</label>
                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}">
                </div>

                <div class="campo">
                    <label for="date_to">Hasta:</label>
                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}">
                </div>

                <div class="campo">
                    <button type="submit" class="boton boton-verde">Filtrar</button>
                    <a href="{{ route('audits.index') }}" class="boton boton-gris">Limpiar</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="estadisticas-auditoria">
        <div class="estadistica">
            <span class="numero">{{ $audits->total() }}</span>
            <span class="label">Total Eventos</span>
        </div>
        <div class="estadistica">
            <span class="numero">{{ $audits->where('event', 'created')->count() }}</span>
            <span class="label">Creaciones</span>
        </div>
        <div class="estadistica">
            <span class="numero">{{ $audits->where('event', 'updated')->count() }}</span>
            <span class="label">Modificaciones</span>
        </div>
        <div class="estadistica">
            <span class="numero">{{ $audits->where('event', 'deleted')->count() }}</span>
            <span class="label">Eliminaciones</span>
        </div>
    </div>

    <!-- Lista de auditorías -->
    <div class="contenedor-tabla">
        @if($audits->count() > 0)
            <table class="tabla-auditoria">
                <thead>
                    <tr>
                        <th>Fecha/Hora</th>
                        <th>Evento</th>
                        <th>Modelo</th>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>IP</th>
                        <th>Cambios</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($audits as $audit)
                        <tr class="fila-{{ $audit->event }}">
                            <td class="fecha">
                                {{ $audit->created_at->format('d/m/Y H:i:s') }}
                            </td>
                            <td>
                                <span class="badge badge-{{ $audit->event }}">
                                    @if($audit->event == 'created')
                                        ✅ Creado
                                    @elseif($audit->event == 'updated')
                                        ✏️ Modificado
                                    @elseif($audit->event == 'deleted')
                                        🗑️ Eliminado
                                    @endif
                                </span>
                            </td>
                            <td class="modelo">
                                {{ class_basename($audit->auditable_type) }}
                            </td>
                            <td class="record-id">
                                <code>#{{ $audit->auditable_id }}</code>
                            </td>
                            <td class="usuario">
                                {{ $audit->user_name ?? 'Sistema' }}
                                @if($audit->user_type)
                                    <small>({{ class_basename($audit->user_type) }})</small>
                                @endif
                            </td>
                            <td class="ip">
                                <code>{{ $audit->ip_address }}</code>
                            </td>
                            <td class="cambios">
                                @php
                                    $changes = $audit->getChanges();
                                @endphp
                                @if(count($changes) > 0)
                                    <details>
                                        <summary>{{ count($changes) }} campos</summary>
                                        <ul class="lista-cambios">
                                            @foreach($changes as $field => $change)
                                                <li>
                                                    <strong>{{ $field }}:</strong>
                                                    @if(is_array($change))
                                                        <span class="cambio-antes">{{ $change['old'] ?? 'null' }}</span>
                                                        →
                                                        <span class="cambio-despues">{{ $change['new'] ?? 'null' }}</span>
                                                    @else
                                                        {{ $change }}
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </details>
                                @else
                                    <span class="sin-cambios">Sin detalles</span>
                                @endif
                            </td>
                            <td class="acciones">
                                @if($audit->auditable)
                                    <a href="{{ route('audits.show', [
                                        'model' => strtolower(class_basename($audit->auditable_type)), 
                                        'id' => $audit->auditable_id
                                    ]) }}" class="boton boton-pequeno boton-azul">
                                        Ver Historial
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Paginación -->
            <div class="paginacion">
                {{ $audits->links() }}
            </div>
        @else
            <div class="sin-resultados">
                <h3>📋 No hay auditorías que mostrar</h3>
                <p>No se encontraron registros con los filtros aplicados.</p>
            </div>
        @endif
    </div>
</div>

<style>
.filtros-auditoria {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    margin-bottom: 2rem;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.dark-mode .filtros-auditoria {
    background: #2c3e50;
    border-color: #34495e;
    color: #ecf0f1;
}

.formulario-filtros .campo-grupo {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    align-items: end;
}

.formulario-filtros .campo {
    min-width: 150px;
}

.formulario-filtros .campo label {
    color: #333;
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: block;
}

.dark-mode .formulario-filtros .campo label {
    color: #ecf0f1;
}

.formulario-filtros select,
.formulario-filtros input[type="date"] {
    background: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 0.5rem;
    color: #333;
    transition: all 0.3s ease;
}

.dark-mode .formulario-filtros select,
.dark-mode .formulario-filtros input[type="date"] {
    background: #34495e;
    border-color: #4a6174;
    color: #ecf0f1;
}

.dark-mode .formulario-filtros select:focus,
.dark-mode .formulario-filtros input[type="date"]:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
}

.estadisticas-auditoria {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.estadistica {
    background: white;
    padding: 1.5rem;
    text-align: center;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border: 1px solid transparent;
    transition: all 0.3s ease;
}

.dark-mode .estadistica {
    background: #34495e;
    border-color: #4a6174;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
}

.estadistica .numero {
    display: block;
    font-size: 2rem;
    font-weight: bold;
    color: #2c5aa0;
}

.estadistica .label {
    color: #666;
    font-size: 0.9rem;
}

.dark-mode .estadistica .label {
    color: #bdc3c7;
}

.tabla-auditoria {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.dark-mode .tabla-auditoria {
    background: #2c3e50;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
}

.tabla-auditoria th,
.tabla-auditoria td {
    padding: 0.75rem;
    text-align: left;
    border-bottom: 1px solid #eee;
    color: #333;
    transition: all 0.3s ease;
}

.tabla-auditoria th {
    background: #f8f9fa;
    font-weight: 600;
}

.dark-mode .tabla-auditoria th,
.dark-mode .tabla-auditoria td {
    border-bottom-color: #4a6174;
    color: #ecf0f1;
}

.dark-mode .tabla-auditoria th {
    background: #34495e;
}

.dark-mode .tabla-auditoria tr:hover {
    background: rgba(52, 152, 219, 0.1);
}

.tabla-auditoria .fecha {
    font-family: monospace;
    font-size: 0.9rem;
}

.badge {
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: 500;
}

.badge-created { background: #d4edda; color: #155724; }
.badge-updated { background: #fff3cd; color: #856404; }
.badge-deleted { background: #f8d7da; color: #721c24; }

.dark-mode .badge-created { background: #27ae60; color: white; }
.dark-mode .badge-updated { background: #f39c12; color: white; }
.dark-mode .badge-deleted { background: #e74c3c; color: white; }

.lista-cambios {
    margin: 0;
    padding-left: 1rem;
    font-size: 0.9rem;
}

.cambio-antes {
    color: #dc3545;
    text-decoration: line-through;
}

.cambio-despues {
    color: #28a745;
    font-weight: 500;
}

.sin-resultados {
    text-align: center;
    padding: 3rem;
    color: #666;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.dark-mode .sin-resultados {
    color: #bdc3c7;
    background: #2c3e50;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
}

.dark-mode .sin-resultados h3 {
    color: #ecf0f1;
}

.record-id code,
.ip code {
    background: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 3px;
    font-size: 0.85rem;
    color: #495057;
    border: 1px solid #e9ecef;
}

.dark-mode .record-id code,
.dark-mode .ip code {
    background: #34495e;
    color: #ecf0f1;
    border-color: #4a6174;
}

.boton-pequeno {
    padding: 0.25rem 0.5rem;
    font-size: 0.8rem;
}

/* Estilos adicionales para dark mode */
.dark-mode .contenido-auditoria {
    background: #1a252f;
}

.dark-mode .descripcion {
    color: #bdc3c7;
}

.dark-mode .lista-cambios {
    color: #ecf0f1;
}

.dark-mode .lista-cambios li {
    border-bottom-color: #4a6174;
}

.dark-mode .cambio-antes {
    background: rgba(231, 76, 60, 0.2);
    color: #e74c3c;
}

.dark-mode .cambio-despues {
    background: rgba(39, 174, 96, 0.2);
    color: #27ae60;
}

.dark-mode .sin-cambios {
    color: #95a5a6;
}

/* Mejoras en la paginación para dark mode */
.dark-mode .paginacion a,
.dark-mode .paginacion span {
    background: #34495e;
    color: #ecf0f1;
    border-color: #4a6174;
}

.dark-mode .paginacion a:hover {
    background: #3498db;
    border-color: #2980b9;
}

/* Responsive adjustments for dark mode */
@media (max-width: 768px) {
    .dark-mode .filtros-auditoria {
        background: #2c3e50;
    }
    
    .dark-mode .estadisticas-auditoria {
        background: transparent;
    }
}
</style>
@endsection