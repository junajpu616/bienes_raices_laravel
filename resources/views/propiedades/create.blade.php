@extends('layout')

@section('contenido')

<main class="contenedor seccion">
    <h1>Crear</h1>
    <a href="{{ route('admin') }}" class="boton boton-verde">Volver</a>
    <form action="{{ route('admin.create') }}" class="formulario" method="POST" enctype="multipart/form-data">
        @csrf
        <x-formulario-propiedad />
        <input type="submit" class="boton boton-verde" value="Crear Propiedad">
    </form>
</main>

@endsection