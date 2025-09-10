@extends('layout')

@section('contenido')
    <main class="contenedor seccion">
        @if(Auth::guard('seller')->check())
            @include('components.seller-menu')
        @endif
        <h1>Actualizar Propiedad</h1>
        @if(Auth::guard('seller')->check())
            <a href="{{ route('seller.dashboard') }}" class="boton boton-verde">Volver al Dashboard</a>
        @else
            <a href="/admin" class="boton boton-verde">Volver</a>
        @endif
        <form class="formulario" method="POST" action="{{ Auth::guard('seller')->check() ? route('seller.properties.update', $propiedad) : route('admin.update', $propiedad->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <x-formulario-propiedad :propiedad="$propiedad"/>
            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>
    </main>
@endsection
