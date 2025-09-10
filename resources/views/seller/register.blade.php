@extends('layout')

@section('contenido')
<main class="contenedor seccion contenido-centrado">
    <h1>Registro de Vendedor</h1>

    @if($errors->any())
        <div class="alerta error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('seller.register') }}" class="formulario">
        @csrf

        <fieldset>
            <legend>Información Personal</legend>

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" placeholder="Tu Nombre" value="{{ old('nombre') }}" required>

            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" id="apellido" placeholder="Tu Apellido" value="{{ old('apellido') }}" required>

            <label for="telefono">Teléfono:</label>
            <input type="tel" name="telefono" id="telefono" placeholder="Tu Teléfono" value="{{ old('telefono') }}" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Tu Email" value="{{ old('email') }}" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Tu Password" required>

            <label for="password_confirmation">Confirmar Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirma Tu Password" required>
        </fieldset>

        <input type="submit" value="Crear Cuenta" class="boton boton-verde">
    </form>

    <div class="acciones">
        <a href="{{ route('seller.login') }}">¿Ya tienes cuenta? Inicia Sesión</a>
    </div>
</main>
@endsection
