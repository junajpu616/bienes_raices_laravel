@extends('layout')

@section('contenido')
<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesión como Vendedor</h1>

    @if(session('success'))
        <div class="alerta exito">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alerta error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('seller.login') }}" class="formulario">
        @csrf

        <fieldset>
            <legend>Información de Acceso</legend>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Tu Email" value="{{ old('email') }}" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Tu Password" required>
        </fieldset>

        <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
    </form>

    <div class="acciones">
        <a href="{{ route('seller.register') }}">¿No tienes cuenta? Regístrate</a>
    </div>
</main>
@endsection
