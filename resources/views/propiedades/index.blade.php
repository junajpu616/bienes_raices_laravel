@extends('layout')


@section('contenido')

<main class="contenedor seccion">
    <h1>Administrador de Bienes Raices</h1>
    
    @if (session('exito'))
        <p class="alerta exito">{{ session('exito') }}</p>
    @endif

    <a href="{{ route('admin.create') }}" class="boton boton-verde">Nueva Propiedad</a>
    <a href="{{ route('vendedores.create' )}}" class="boton boton-amarillo">Nuevo Vendedor</a>

    <h2>Propiedades</h2>
    <table class="propiedades">
        <thead>
            <tr>
                <th>Id</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($propiedades as $propiedad)
                <tr>
                    <td>{{ $propiedad->id }}</td>
                    <td>{{ $propiedad->titulo }}</td>
                    <td><img src="{{ asset('storage/propiedades') . '/' .$propiedad->imagen}}" alt="Imagen Propiedad" class="imagen-tabla"></td>
                    <td>Q. {{ $propiedad->precio }}</td>
                    <td>
                        <a href="{{ route('admin.edit', $propiedad->id )}}" class="boton-amarillo-block">Actualizar</a>
                        <form action="{{ route('admin.destroy', $propiedad->id )}}" method="POST" class="w-100">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h2>Vendedores</h2>
    <table class="propiedades">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
             @foreach ($vendedores as $vendedor)
                 <tr>
                    <td>{{ $vendedor->id }}</td>
                    <td>{{ $vendedor->nombre }}</td>
                    <td>{{ $vendedor->telefono }}</td>
                    <td>
                        <a href="{{ route('vendedores.edit', $vendedor->id )}}" class="boton-amarillo-block">Actualizar</a>
                        <form action="" method="POST" class="w-100">
                            @csrf
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                    </td>
                 </tr>
             @endforeach
        </tbody>
    </table>
</main>


@endsection