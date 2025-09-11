@extends('layout')

@section('contenido')

<main class="contenedor seccion">
    <h1>Crear Propiedad</h1>
    @if(Auth::guard('seller')->check())
        <a href="{{ route('seller.dashboard') }}" class="boton boton-verde">Volver al Dashboard</a>
    @else
        <a href="{{ route('admin') }}" class="boton boton-verde">Volver</a>
    @endif
    <form action="{{ Auth::guard('seller')->check() ? route('seller.properties.store') : route('admin.create') }}" class="formulario" method="POST" enctype="multipart/form-data">
        @csrf
        <x-formulario-propiedad />
        <input type="submit" class="boton boton-verde" value="Crear Propiedad">
    </form>
</main>

@endsection
