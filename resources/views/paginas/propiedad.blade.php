@extends('layout')

@section('contenido')

<main class="contenedor seccion contenido-centrado">
    <h1>{{ $propiedad->titulo }}</h1>
    <picture>
        <img loading="lazy" src="../imagenes/{{ $propiedad->imagen }}" alt="Imagen de la propiedad">
    </picture>
    <div class="resumen-propiedad">
        <p class="precio">Q.{{ $propiedad->precio; }}</p>
        <ul class="iconos-caracteristicas">
            <li>
                <img loading="lazy" class="icono" src="{{ asset('img/icono_wc.svg') }}" alt="iconos wc">
                <p>{{ $propiedad->wc }}</p>
            </li>
            <li>
                <img loading="lazy" class="icono" src="{{ asset('img/icono_estacionamiento.svg') }}" alt="iconos estacionamiento">
                <p>{{ $propiedad->estacionamiento }}</p>
            </li>
            <li>
                <img loading="lazy" class="icono" src="{{ asset('img/icono_dormitorio.svg') }}" alt="iconos dormitorio">
                <p>{{ $propiedad->habitaciones }}</p>
            </li>
        </ul>
        <p class="descripcion">
            {{ $propiedad->descripcion }}
        </p>
    </div>
</main>

@endsection