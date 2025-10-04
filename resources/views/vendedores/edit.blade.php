@extends('layout')

@section('contenido')

<main class="contenedor seccion">
    <h1>Actualizar Vendedor(a)</h1>
    <a href="{{ route('admin') }}" class="boton boton-verde">Volver</a>
    <form class="formulario" method="POST" action="{{ route('vendedores.update', $vendedor) }}">
        @csrf
        @method('PUT')
        <x-formulario-vendedor :vendedor="$vendedor"/>
        <input type="submit" value="Guardar Cambios" class="boton boton-verde">
    </form>
</main>

@endsection