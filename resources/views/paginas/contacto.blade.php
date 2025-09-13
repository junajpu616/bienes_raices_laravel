@extends('layout')

@section('contenido')

<main class="contenedor seccion">
    <h1>Contacto</h1>

    @if (session('mensaje'))
        <p class="alerta exito">{{ session('mensaje') }}</p>
    @endif
    <picture>
        <img src="{{ asset('img/destacada3.jpg') }}" alt="Imagen de Contacto">
    </picture>
    <h2>Llene el formulario de Contacto</h2>
    <form class="formulario" action="{{ route('contacto') }}" method="POST" novalidate>
        @csrf
        <fieldset>
            <legend>Información Personal</legend>
            
            <div class="formulario__field {{ $errors->has('contacto.nombre') ? 'formulario__field--error' : '' }}">
                <input 
                    type="text" 
                    id="nombre" 
                    name="contacto[nombre]" 
                    class="formulario__input"
                    placeholder=""
                    value="{{ old('contacto.nombre') }}"
                    required
                >
                <label for="nombre" class="formulario__label formulario__label--floating">Nombre</label>
                @error('contacto.nombre')
                    <div class="formulario__error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="formulario__field {{ $errors->has('contacto.mensaje') ? 'formulario__field--error' : '' }}">
                <textarea 
                    id="mensaje" 
                    name="contacto[mensaje]" 
                    class="formulario__textarea"
                    placeholder=""
                    required
                >{{ old('contacto.mensaje') }}</textarea>
                <label for="mensaje" class="formulario__label formulario__label--floating">Mensaje</label>
                @error('contacto.mensaje')
                    <div class="formulario__error">{{ $message }}</div>
                @enderror
            </div>
        </fieldset>
        
        <fieldset>
            <legend>Información Sobre la Propiedad</legend>
            
            <div class="formulario__field {{ $errors->has('contacto.tipo') ? 'formulario__field--error' : '' }}">
                <select name="contacto[tipo]" id="opciones" class="formulario__select" required>
                    <option value="">--Seleccione--</option>
                    <option value="Compra" {{ old('contacto.tipo') == 'Compra' ? 'selected' : '' }}>
                        Compra
                    </option>
                    <option value="Vende" {{ old('contacto.tipo') == 'Vende' ? 'selected' : '' }}>
                        Vende
                    </option>
                </select>
                <label for="opciones" class="formulario__label formulario__label--floating">Vende o Compra</label>
                @error('contacto.tipo')
                    <div class="formulario__error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="formulario__field {{ $errors->has('contacto.precio') ? 'formulario__field--error' : '' }}">
                <input 
                    type="number" 
                    id="presupuesto" 
                    name="contacto[precio]" 
                    class="formulario__input"
                    placeholder=""
                    min="1"
                    value="{{ old('contacto.precio') }}"
                    required
                >
                <label for="presupuesto" class="formulario__label formulario__label--floating">Presupuesto</label>
                @error('contacto.precio')
                    <div class="formulario__error">{{ $message }}</div>
                @enderror
            </div>
        </fieldset>
        <fieldset>
            <legend>Contacto</legend>
            <div class="formulario__field">
                <p class="formulario__question">¿Cómo desea ser contactado?</p>
                <div class="formulario__radio-group">
                    <div class="formulario__radio-item">
                        <input 
                            name="contacto[contacto]" 
                            type="radio" 
                            value="telefono" 
                            id="contactar-telefono" 
                            class="formulario__radio"
                            {{ old('contacto.contacto') == 'telefono' ? 'checked' : '' }}
                            required
                        >
                        <label for="contactar-telefono" class="formulario__radio-label">Teléfono</label>
                    </div>
                    <div class="formulario__radio-item">
                        <input 
                            name="contacto[contacto]" 
                            type="radio" 
                            value="email" 
                            id="contactar-email" 
                            class="formulario__radio"
                            {{ old('contacto.contacto') == 'email' ? 'checked' : '' }}
                            required
                        >
                        <label for="contactar-email" class="formulario__radio-label">Email</label>
                    </div>
                </div>
                
                @error('contacto.contacto')
                    <div class="formulario__error">{{ $message }}</div>
                @enderror
                @error('contacto.telefono')
                    <div class="formulario__error">{{ $message }}</div>
                @enderror
                @error('contacto.email')
                    <div class="formulario__error">{{ $message }}</div>
                @enderror
            </div>
            <div id="contacto"></div>
        </fieldset>
        
        <div class="formulario__actions">
            <input type="submit" value="Enviar" class="boton boton-verde">
        </div>
    </form>
</main>

@endsection