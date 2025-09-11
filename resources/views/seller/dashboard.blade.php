@extends('layout')

@section('contenido')
<main class="contenedor seccion">

    <div class="dashboard-header">
        <h2>Bienvenido, {{ $seller->nombre }} {{ $seller->apellido }}</h2>
    </div>

    @if(session('exito'))
        <div class="alerta exito">
            {{ session('exito') }}
        </div>
    @endif

    <div class="dashboard-actions">
        <a href="{{ route('seller.properties.create') }}" class="boton boton-verde">Crear Nueva Propiedad</a>
        <a href="{{ route('seller.properties.index') }}" class="boton boton-azul">Ver Mis Propiedades</a>
    </div>

    <div class="propiedades-vendedor">
        <h3>Mis Propiedades</h3>

        @if($properties->count() > 0)
            <div class="contenedor-anuncios">
                @foreach($properties as $propiedad)
                    <div class="anuncio">
                        <picture>
                            <img src="{{ asset('storage/propiedades') . '/' .$propiedad->imagen}}" alt="Imagen Propiedad" class="imagen-tabla">
                        </picture>

                        <div class="contenido-anuncio">
                            <h3>{{ $propiedad->titulo }}</h3>
                            <p>{{ $propiedad->descripcion }}</p>
                            <p class="precio">${{ number_format($propiedad->precio) }}</p>

                            <ul class="iconos-caracteristicas">
                                <li>
                                    <img class="icono" loading="lazy" src="{{ asset('img/icono_dormitorio.svg') }}" alt="icono habitaciones">
                                    <p>{{ $propiedad->habitaciones }}</p>
                                </li>
                                <li>
                                    <img class="icono" loading="lazy" src="{{ asset('img/icono_wc.svg') }}" alt="icono wc">
                                    <p>{{ $propiedad->wc }}</p>
                                </li>
                                <li>
                                    <img class="icono" loading="lazy" src="{{ asset('img/icono_estacionamiento.svg') }}" alt="icono estacionamiento">
                                    <p>{{ $propiedad->estacionamiento }}</p>
                                </li>
                            </ul>

                            <div class="acciones-propiedad">
                                <a href="{{ route('seller.properties.edit', $propiedad) }}" class="boton-amarillo-block">Editar</a>
                                <form method="POST" action="{{ route('seller.properties.destroy', $propiedad) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="boton-rojo-block" onclick="return confirm('¿Estás seguro de eliminar esta propiedad?')">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No tienes propiedades registradas aún.</p>
        @endif
    </div>
</main>
@endsection
