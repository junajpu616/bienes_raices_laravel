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
            <label for="nombre">Nombre:</label>
            <input type="text" placeholder="Tu Nombre" id="nombre" name="contacto[nombre]" required value="{{ old('contacto.nombre')}}">
            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" name="contacto[mensaje]" required>
                {{ old('contacto.mensaje' )}}
            </textarea>
            @error('contacto.nombre')
                <p class="alerta error">{{ $message }}</p>
            @enderror
            @error('contacto.mensaje')
                <p class="alerta error">{{ $message }}</p>
            @enderror
        </fieldset>
        <fieldset>
            <legend>Información Sobre la Propiedad</legend>
            <label for="opciones">Vende o Compra:</label>
            <select name="contacto[tipo]" id="opciones" required>
                <option value="" disabled selected>--Seleccione--</option>
                <option value="Compra"
                    {{ old('contacto.tipo') == 'Compra' ? 'selected' : ''}}>
                    Compra
                </option>
                <option value="Vende"
                    {{ old('contacto.tipo') == 'Vende' ? 'selected' : ''}}>
                    Vende
                </option>
            </select>
            <label for="presupuesto">Presupuesto:</label>
            <input type="number" placeholder="Tu Presupuesto o Precio" id="presupuesto" name="contacto[precio]" min="1" required value="{{ old('contacto.precio') }}">
            @error('contacto.tipo')
                <p class="alerta error">{{ $message }}</p>
            @enderror
            @error('contacto.precio')
                <p class="alerta error">{{ $message }}</p>
            @enderror
        </fieldset>
        <fieldset>
            <legend>Contacto</legend>
            <p>¿Cómo desea ser contactado?</p>
            <div class="forma-contacto">
                <label for="contactar-telefono">Télefono</label>
                <input name="contacto[contacto]" type="radio" value="telefono" id="contactar-telefono" required {{ old('contacto.contacto') == 'telefono' ? 'checked' : ''}}>
                <label for="contactar-email">Email</label>
                <input name="contacto[contacto]" type="radio" value="email" id="contactar-email" required {{ old('contacto.contacto') == 'email' ? 'checked': ''}}>
            </div>
            <div id="contacto"></div>
            @error('contacto.contacto')
                <p class="alerta error">{{ $message }}</p>
            @enderror
            @error('contacto.telefono')
                <p class="alerta error">{{ $message }}</p>
            @enderror
            @error('contacto.email')
                <p class="alerta error">{{ $message }}</p>
            @enderror
        </fieldset>
        <input type="submit" value="Enviar" class="boton-verde">
    </form>
</main>

@endsection