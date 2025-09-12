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

            <div class="formulario__group--inline">
                <div class="formulario__field {{ $errors->has('nombre') ? 'formulario__field--error' : '' }}">
                    <input 
                        type="text" 
                        name="nombre" 
                        id="nombre"
                        class="formulario__input"
                        placeholder=" "
                        value="{{ old('nombre') }}"
                        required
                    >
                    <label for="nombre" class="formulario__label formulario__label--floating">Nombre</label>
                    @error('nombre')
                        <div class="formulario__error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="formulario__field {{ $errors->has('apellido') ? 'formulario__field--error' : '' }}">
                    <input 
                        type="text" 
                        name="apellido" 
                        id="apellido"
                        class="formulario__input"
                        placeholder=" "
                        value="{{ old('apellido') }}"
                        required
                    >
                    <label for="apellido" class="formulario__label formulario__label--floating">Apellido</label>
                    @error('apellido')
                        <div class="formulario__error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="formulario__group--inline">
                <div class="formulario__field {{ $errors->has('telefono') ? 'formulario__field--error' : '' }}">
                    <input 
                        type="tel" 
                        name="telefono" 
                        id="telefono"
                        class="formulario__input"
                        placeholder=" "
                        value="{{ old('telefono') }}"
                        required
                    >
                    <label for="telefono" class="formulario__label formulario__label--floating">Teléfono</label>
                    @error('telefono')
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
                    <div class="formulario__help">Mínimo 8 caracteres</div>
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
            <input type="submit" value="Crear Cuenta de Vendedor" class="boton boton-verde">
        </div>
    </form>

    <div class="acciones texto-centrado">
        <a href="{{ route('seller.login') }}" class="enlace">¿Ya tienes cuenta? Inicia Sesión</a>
    </div>
</main>
@endsection
