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
            <legend>Datos Personales</legend>
            
            <div class="formulario__field {{ $errors->has('name') ? 'formulario__field--error' : '' }}">
                <input 
                    type="text" 
                    name="name" 
                    id="name"
                    class="formulario__input"
                    placeholder=" "
                    value="{{ old('name') }}"
                    required
                >
                <label for="name" class="formulario__label formulario__label--floating">Nombre</label>
                @error('name')
                    <div class="formulario__error">{{ $message }}</div>
                @enderror
            </div>
            
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
            
            <div class="formulario__group--inline">
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
                
                <div class="formulario__field {{ $errors->has('password_confirmation') ? 'formulario__field--error' : '' }}">
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation"
                        class="formulario__input"
                        placeholder=" "
                        required
                    >
                    <label for="password_confirmation" class="formulario__label formulario__label--floating">Confirmar Password</label>
                    @error('password_confirmation')
                        <div class="formulario__error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </fieldset>
        
        <div class="formulario__actions">
            <input type="submit" value="Registrarse" class="boton boton-verde">
        </div>
        
        <p class="texto-centrado">¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="enlace">Iniciar Sesión</a></p>
    </form>
</main>
@endsection