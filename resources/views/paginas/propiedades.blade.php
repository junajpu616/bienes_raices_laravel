@extends('layout')

@section('contenido')

<main class="contenedor seccion">
    <h2>Casas y Depas en Venta</h2>
    <x-listado :propiedades="$propiedades"/>
</main>

@endsection