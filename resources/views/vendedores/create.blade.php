@extends('layout')

@section('contenido')

    <main class="contenedor seccion">
        <h1>Crear Vendedor</h1>
        <a href="{{ route('admin') }}" class="boton boton-verde">Volver</a>
        <form class="formulario" method="POST" action="{{ route('vendedores.create')}}">
            @csrf
            <x-formulario-vendedor />
            <input type="submit" value="Crear Vendedor" class="boton boton-verde">
        </form>
    </main>

@endsection