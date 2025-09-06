@extends('layout')

@section('contenido')

<main class="contenedor seccion contenido-centrado">
    <h1>Nuestro Blog</h1>
    <article class="entrada-blog">
        <div class="imagen">
            <picture>
                <img loading="lazy" src="{{ asset('img/blog1.jpg') }}" alt="Texto Entrada Blog">
            </picture>
        </div>
        <div class="texto-entrada">
            <a href="{{ route('entrada') }}">
                <h4>Terreza en el techo de tu casa</h4>
                <p>Escrito el: <span>20/10/2024</span> por: <span>Admin</span> </p>
                <p>Consejos para construir una terraza en el techo de tu casa con los mejores
                    materiales y ahorrando dinero
                </p>
            </a>
        </div>
    </article>
    <article class="entrada-blog">
        <div class="imagen">
            <picture>
                <img loading="lazy" src="{{ asset('img/blog2.jpg') }}" alt="Texto Entrada Blog">
            </picture>
        </div>
        <div class="texto-entrada">
            <a href="{{ route('entrada') }}">
                <h4>Guía para la decoración de tu hogar</h4>
                <p>Escrito el: <span>20/10/2024</span> por: <span>Admin</span> </p>
                <p>Maximiza el espacio en tu hogar con esta guía, aprende a combinar muebles y
                    colores para darle vida a tu espacio
                </p>
            </a>
        </div>
    </article>
    <article class="entrada-blog">
        <div class="imagen">
            <picture>
                <img loading="lazy" src="{{ asset('img/blog3.jpg') }}" alt="Texto Entrada Blog">
            </picture>
        </div>
        <div class="texto-entrada">
            <a href="{{ route('entrada') }}">
                <h4>Terreza en el techo de tu casa</h4>
                <p>Escrito el: <span>20/10/2024</span> por: <span>Admin</span> </p>
                <p>Consejos para construir una terraza en el techo de tu casa con los mejores
                    materiales y ahorrando dinero
                </p>
            </a>
        </div>
    </article>
    <article class="entrada-blog">
        <div class="imagen">
            <picture>
                <img loading="lazy" src="{{ asset('img/blog2.jpg')}}" alt="Texto Entrada Blog">
            </picture>
        </div>
        <div class="texto-entrada">
            <a href="{{ route('entrada') }}">
                <h4>Guía para la decoración de tu hogar</h4>
                <p>Escrito el: <span>20/10/2024</span> por: <span>Admin</span> </p>
                <p>Maximiza el espacio en tu hogar con esta guía, aprende a combinar muebles y
                    colores para darle vida a tu espacio
                </p>
            </a>
        </div>
    </article>
</main>

@endsection