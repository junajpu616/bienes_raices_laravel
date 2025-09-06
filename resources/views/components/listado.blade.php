<div class="contenedor-anuncios">
    @foreach ($propiedades as $propiedad)
    <div class="anuncio">
        <picture>
            <img loading="lazy" src="{{ asset('storage/propiedades') . '/' . $propiedad->imagen }}" alt="anuncio">
        </picture>
        <div class="contenido-anuncio">
            <h3>{{ $propiedad->titulo }}</h3>
            <p>{{ $propiedad->descripcion }}</p>
            <p class="precio">Q.{{ $propiedad->precio }}</p>
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
            <a href="{{ route('propiedad', $propiedad->id) }}" class="boton-amarillo-block">
                Ver Propiedad
            </a>
        </div> <!--contenido-anuncio-->
    </div> <!--anuncio-->
    @endforeach
</div> <!--contenedor-anuncios-->