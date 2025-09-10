@extends('layout')

@section('contenido')

<main class="contenedor seccion">
    <h1>Administrador de Vendedores</h1>
    <a href="{{ route('vendedores.create') }}" class="boton boton-verde">Nuevo Vendedor</a>

    @if (session('exito'))
        <p class="alerta exito">{{ session('exito') }}</p>
    @endif

    <h2>Vendedores</h2>
    <table class="propiedades">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vendedores as $vendedor)
                <tr>
                    <td>{{ $vendedor->id }}</td>
                    <td>{{ $vendedor->nombre }}</td>
                    <td>{{ $vendedor->apellido }}</td>
                    <td>{{ $vendedor->email }}</td>
                    <td>{{ $vendedor->telefono }}</td>
                    <td>
                        <a href="{{ route('vendedores.edit', $vendedor->id) }}" class="boton-amarillo-block">Actualizar</a>
                        <form action="{{ route('vendedores.destroy', $vendedor->id) }}" method="POST" class="w-100">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="boton-rojo-block" value="Eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este vendedor?')">
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</main>

@endsection
