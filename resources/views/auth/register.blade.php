@extends('layout')

@section('contenido')
<main class="contenedor seccion contenido-centrado">
    <h1>Registrarse</h1>
    @if (session('mensaje'))
        <div class="alerta error">{{ session('mensaje') }}</div>
    @endif
    <form class="formulario" action="{{ route('register.store') }}" method="POST">
        @csrf
        <fieldset>
            <legend>Datos</legend>
            <label for="name">Nombre:</label>
            <input type="text" name="name" placeholder="Tu Nombre" id="name">
            @error('name')
                <div class="alerta error">
                    {{ $message }}
                </div>
            @enderror
            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="Tu Email" id="email">
            @error('email')
                <div class="alerta error">
                    {{ $message }}
                </div>
            @enderror
            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Tu Password" id="password">
            @error('password')
                <div class="alerta error">
                    {{ $message }}
                </div>
            @enderror
            <label for="password_confirmation">Repetir Password:</label>
            <input type="password" name="password_confirmation" placeholder="Repite tu Password" id="password_confirmation">
            @error('password_confirmation')
                <div class="alerta error">
                    {{ $message }}
                </div>
            @enderror
        </fieldset>
        <input type="submit" value="Registrarse" class="boton boton-verde">
        <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}">Iniciar Sesión</a></p>
    </form>
</main>
@endsection