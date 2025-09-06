@extends('layout')

@section('contenido')

<main class="contenedor seccion contenido-centrado">
    <h1>Guía para la decoración de tu hogar</h1>
    <picture>
        <img loading="lazy" src="{{ asset('img/destacada2.jpg') }}" alt="Imagen de la propiedad">
    </picture>
    <p class="informacion-meta">Escrito el <span>20/10/2024</span> por: <span>Admin</span></p>
    <div class="resumen-propiedad">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam posuere tellus massa, sit amet condimentum diam ultricies nec. Duis id condimentum felis, eget aliquet turpis. Fusce porta enim sed rutrum iaculis. Duis fringilla, nunc in lobortis commodo, elit mi lacinia eros, ac dignissim nibh elit ac ante. Mauris sit amet vehicula metus. Etiam tincidunt quis libero ut finibus. Morbi vestibulum nisl massa, ut vestibulum massa rhoncus non. Duis faucibus nec sem vitae molestie.
            Etiam a lobortis tellus. Nam fermentum leo porttitor sagittis tincidunt. Integer commodo aliquet mi, vitae maximus lectus laoreet in. Duis eu luctus tellus. Fusce sit amet accumsan odio, et lobortis justo. Donec pellentesque sit amet turpis sit amet venenatis. Integer et nisi ac dolor interdum tempor.
        </p>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Natus culpa repudiandae quaerat harum, doloremque quae eius. Minus magnam quos consectetur asperiores totam ipsam commodi, magni ullam velit! Tempora, facilis sit.</p>
    </div>
</main>

@endsection