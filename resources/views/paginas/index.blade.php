@extends('layout')

@section('title', 'Inicio - Bienes Raices')

@section('contenido')

<section class="section">
    <div class="contenedor">
        <h2>Más Sobre Nosotros</h2>
        <x-iconos />
    </div>
</section>

<section class="section bg-gray">
    <div class="contenedor">
        <div class="section__header">
            <h2>Propiedades Destacadas</h2>
            <p>Descubre las mejores propiedades disponibles</p>
        </div>
        
        <x-listado :propiedades="$propiedades"/>
        
        <div class="alinear-derecha mt-xl">
            <a href="{{ route('propiedades') }}" class="btn btn--primary btn--lg">
                Ver Todas las Propiedades
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<section class="hero-cta">
    <div class="contenedor">
        <div class="hero-cta__content">
            <h2>Encuentra la casa de tus sueños</h2>
            <p>Llena el formulario de contacto y un asesor se pondrá en contacto contigo a la brevedad.</p>
            <a href="{{ route('contacto') }}" class="btn btn--secondary btn--lg">
                Contactános Ahora
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<section class="section seccion-inferior">
    <div class="contenedor">
        <div class="blog-testimonials">
            <section class="blog-section">
                <div class="section__header">
                    <h3>Nuestro Blog</h3>
                    <p>Consejos y tendencias inmobiliarias</p>
                </div>
                
                <div class="blog-grid">
                    <article class="blog-card">
                        <div class="blog-card__image">
                            <img loading="lazy" src="{{ asset('img/blog1.jpg') }}" alt="Terraza en el techo">
                        </div>
                        <div class="blog-card__content">
                            <div class="blog-card__meta">
                                <time datetime="2024-10-20">20 Oct 2024</time>
                                <span>Por Admin</span>
                            </div>
                            <h4>
                                <a href="{{ route('entrada') }}">Terraza en el techo de tu casa</a>
                            </h4>
                            <p>Consejos para construir una terraza en el techo de tu casa con los mejores materiales y ahorrando dinero</p>
                            <a href="{{ route('entrada') }}" class="btn btn--outline-primary btn--sm">Leer más</a>
                        </div>
                    </article>
                    
                    <article class="blog-card">
                        <div class="blog-card__image">
                            <img loading="lazy" src="{{ asset('img/blog2.jpg') }}" alt="Decoración del hogar">
                        </div>
                        <div class="blog-card__content">
                            <div class="blog-card__meta">
                                <time datetime="2024-10-20">20 Oct 2024</time>
                                <span>Por Admin</span>
                            </div>
                            <h4>
                                <a href="{{ route('entrada') }}">Guía para la decoración de tu hogar</a>
                            </h4>
                            <p>Maximiza el espacio en tu hogar con esta guía, aprende a combinar muebles y colores para darle vida a tu espacio</p>
                            <a href="{{ route('entrada') }}" class="btn btn--outline-primary btn--sm">Leer más</a>
                        </div>
                    </article>
                </div>
            </section>

            <section class="testimonials-section">
                <div class="section__header">
                    <h3>Testimoniales</h3>
                    <p>Lo que dicen nuestros clientes</p>
                </div>
                
                <div class="testimonials">
                    <div class="testimonial-card">
                        <div class="testimonial-card__quote">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-10zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z"/>
                            </svg>
                        </div>
                        <blockquote>
                            El personal se comportó de una excelente forma, muy buena atención y la casa que me ofrecieron cumple con todas mis expectativas
                        </blockquote>
                        <div class="testimonial-card__author">
                            <div class="author-avatar">JC</div>
                            <div class="author-info">
                                <cite>Junajpu Conos</cite>
                                <span>Cliente satisfecho</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="testimonial-card">
                        <div class="testimonial-card__quote">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-10zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z"/>
                            </svg>
                        </div>
                        <blockquote>
                            Excelente servicio, encontré la casa perfecta para mi familia. El proceso fue rápido y sin complicaciones.
                        </blockquote>
                        <div class="testimonial-card__author">
                            <div class="author-avatar">MR</div>
                            <div class="author-info">
                                <cite>María Rodríguez</cite>
                                <span>Propietaria</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>

@endsection