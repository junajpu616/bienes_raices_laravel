<fieldset>
    <legend>Información General</legend>
    <label for="titulo">Titulo:</label>
    <input type="text" id="titulo" name="propiedad[titulo]" placeholder="Titulo Propiedad" value="{{ old('propiedad.titulo', $propiedad->titulo) }}">
    @error('propiedad.titulo')
        <div class="alerta error">{{ $message }}</div>
    @enderror
    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="propiedad[precio]" placeholder="Precio Propiedad" value="{{ old('propiedad.precio', $propiedad->precio) }}">
    @error('propiedad.precio')
        <div class="alerta error">{{ $message }}</div>
    @enderror
    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" name="propiedad[imagen]" accept="image/jpeg, image/png">
    @if($propiedad->imagen)
        <img src="{{ asset('storage/propiedades' . '/' . $propiedad->imagen) }}" alt="Imagen Propiedad" class="imagen-small">
    @endif
    @error('propiedad.imagen')
        <div class="alerta error">{{ $message }}</div>
    @enderror
    
    <label for="descripcion">Descripción:</label>
    <textarea name="propiedad[descripcion]" id="descripcion">{{ old('propiedad.descripcion', $propiedad->descripcion) }}</textarea>
    @error('propiedad.descripcion')
        <div class="alerta error">{{ $message }}</div>
    @enderror
</fieldset>

<fieldset>
    <legend>Información Propiedad</legend>
    <label for="habitaciones">Habitaciones:</label>
    <input type="number" name="propiedad[habitaciones]" id="habitaciones" placeholder="Ej: 3" min="1" max="9" value="{{ old('propiedad.habitaciones', $propiedad->habitaciones) }}">
    @error('propiedad.habitaciones')
        <div class="alerta error">{{ $message }}</div>
    @enderror
    <label for="wc">Baños:</label>
    <input type="number" name="propiedad[wc]" id="wc" placeholder="Ej: 3" min="1" max="9" value="{{ old('propiedad.wc', $propiedad->wc) }}">
    @error('propiedad.wc')
        <div class="alerta error">{{ $message }}</div>
    @enderror
    <label for="estacionamiento">Estacionamiento:</label>
    <input type="number" name="propiedad[estacionamiento]" id="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="{{ old('propiedad.estacionamiento', $propiedad->estacionamiento) }}">
    @error('propiedad.estacionamiento')
        <div class="alerta error">{{ $message }}</div>
    @enderror
</fieldset>

@if(!Auth::guard('seller')->check())
<fieldset>
    <legend>Vendedor</legend>
    <label for="vendedor">Vendedor</label>
    <select name="propiedad[vendedorId]" id="vendedor">
        <option selected disabled value="">-- Seleccione --</option>
        @foreach($vendedores as $vendedor)
            <option value="{{ $vendedor->id }}" {{ (old('propiedad.vendedorId', $propiedad->seller_id) == $vendedor->id) ? 'selected' : '' }}>
                {{ $vendedor->nombre }} {{ $vendedor->apellido }}
            </option>
        @endforeach
    </select>
    @error('propiedad.vendedorId')
        <div class="alerta error">{{ $message }}</div>
    @enderror
</fieldset>
@endif
