@extends('layout')

@section('contenido')
    <main class="contenedor seccion">
        <h1>Actualizar Propiedad</h1>        
        <a href="/admin" class="boton boton-verde">Volver</a>
        <form class="formulario" method="POST" action="{{ route('admin.update', $propiedad->id )}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <x-formulario-propiedad :propiedad="$propiedad"/>
            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>
    </main>
@endsection