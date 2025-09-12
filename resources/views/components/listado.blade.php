<div class="contenedor-anuncios">
    @foreach ($propiedades as $propiedad)
    <div class="anuncio">
        <div class="anuncio__image">
            <img loading="lazy" src="{{ asset('storage/propiedades') . '/' . $propiedad->imagen }}" alt="{{ $propiedad->titulo }}">
            <div class="anuncio__badge">En Venta</div>
        </div>
        
        <div class="contenido-anuncio">
            <h3>{{ $propiedad->titulo }}</h3>
            <p>{{ Str::limit($propiedad->descripcion, 100) }}</p>
            
            <div class="precio">{{ number_format($propiedad->precio, 0, '.', ',') }}</div>
            
            <ul class="iconos-caracteristicas">
                <li>
                    <img loading="lazy" class="icono" src="{{ asset('img/icono_wc.svg') }}" alt="Baños">                    
                    <p>{{ $propiedad->wc }} {{ $propiedad->wc == 1 ? 'Baño' : 'Baños' }}</p>
                </li>
                <li>
                    <img loading="lazy" class="icono" src="{{ asset('img/icono_estacionamiento.svg') }}" alt="Estacionamiento">
                    <p>{{ $propiedad->estacionamiento }} {{ $propiedad->estacionamiento == 1 ? 'Auto' : 'Autos' }}</p>
                </li>
                <li>
                    <img loading="lazy" class="icono" src="{{ asset('img/icono_dormitorio.svg') }}" alt="Habitaciones">
                    <p>{{ $propiedad->habitaciones }} {{ $propiedad->habitaciones == 1 ? 'Habitación' : 'Habitaciones' }}</p>
                </li>
            </ul>
            
            <a href="{{ route('propiedad', $propiedad->id) }}" class="btn btn--secondary btn--block">
                Ver Propiedad
            </a>
        </div>
    </div>
    @endforeach
</div>