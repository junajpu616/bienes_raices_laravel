@extends('layout')

@section('contenido')
<main class="contenedor seccion">
    <h1>Conoce Sobre Nosotros</h1>
    <div class="contenido-nosotros">
        <div class="imagen">
            <picture>
                {{-- <source srcset="build/img/nosotros.webp" type="image/webp">
                <source srcset="build/img/nosotros.jpg" type="image/jpg"> --}}
                <img loading="lazy" src="{{ asset('img/nosotros.jpg') }}" alt="Imagen Nosotros">
            </picture>
        </div>
        <div class="texto-nosotros">
            <blockquote>
                25 Años de Experiencia
            </blockquote>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam posuere tellus massa, sit amet condimentum diam ultricies nec. Duis id condimentum felis, eget aliquet turpis. Fusce porta enim sed rutrum iaculis. Duis fringilla, nunc in lobortis commodo, elit mi lacinia eros, ac dignissim nibh elit ac ante. Mauris sit amet vehicula metus. Etiam tincidunt quis libero ut finibus. Morbi vestibulum nisl massa, ut vestibulum massa rhoncus non. Duis faucibus nec sem vitae molestie.
                Etiam a lobortis tellus. Nam fermentum leo porttitor sagittis tincidunt. Integer commodo aliquet mi, vitae maximus lectus laoreet in. Duis eu luctus tellus. Fusce sit amet accumsan odio, et lobortis justo. Donec pellentesque sit amet turpis sit amet venenatis. Integer et nisi ac dolor interdum tempor.
            </p>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Natus culpa repudiandae quaerat harum, doloremque quae eius. Minus magnam quos consectetur asperiores totam ipsam commodi, magni ullam velit! Tempora, facilis sit.</p>
        </div>
    </div>
</main>

<section class="contenedor seccion">
    <h1>Más Sobre Nosotros</h1>
    <x-iconos />
</section>

@endsection