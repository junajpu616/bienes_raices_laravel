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
            
            <div class="formulario__field {{ $errors->has('email') ? 'formulario__field--error' : '' }}">
                <input 
                    type="email" 
                    name="email" 
                    id="email"
                    class="formulario__input"
                    placeholder=" "
                    value="{{ old('email') }}"
                    required
                >
                <label for="email" class="formulario__label formulario__label--floating">Email</label>
                @error('email')
                    <div class="formulario__error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="formulario__field {{ $errors->has('password') ? 'formulario__field--error' : '' }}">
                <input 
                    type="password" 
                    name="password" 
                    id="password"
                    class="formulario__input"
                    placeholder=" "
                    required
                >
                <label for="password" class="formulario__label formulario__label--floating">Password</label>
                @error('password')
                    <div class="formulario__error">{{ $message }}</div>
                @enderror
            </div>
        </fieldset>
        
        <div class="formulario__actions">
            <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
        </div>
        
        <p class="texto-centrado">¿No tienes una cuenta? <a href="{{ route('register') }}" class="enlace">Registrate</a></p>
    </form>
</main>
@endsection