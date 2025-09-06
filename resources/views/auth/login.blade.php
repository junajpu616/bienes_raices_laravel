@extends('layout')

@section('contenido')
<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesión</h1>
    @if (session('mensaje'))
        <div class="alerta error">{{ session('mensaje') }}</div>
    @endif
    <form class="formulario" action="{{ route('login') }}" method="POST">
        @csrf
        <fieldset>
            <legend>Email y Password</legend>
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
        </fieldset>
        <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
    </form>
</main>
@endsection