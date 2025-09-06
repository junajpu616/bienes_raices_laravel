<fieldset>
    <legend>Información General</legend>
    <label for="nombre">Nombre:</label>
    <input type="text" id="titulo" name="vendedor[nombre]" placeholder="Nombre Vendedor" value="{{ old('vendedor.nombre', $vendedor->nombre)}}">
    @error('vendedor.nombre')
        <div class="alerta error">{{ $message }}</div>
    @enderror
    <label for="nombre">Apellido:</label>
    <input type="text" id="apellido" name="vendedor[apellido]" placeholder="Apellido Vendedor" value="{{ old('vendedor.apellido', $vendedor->apellido)}}">
    @error('vendedor.apellido')
        <div class="alerta error">{{ $message }}</div>
    @enderror
</fieldset>
<fieldset>
    <legend>Información Extra</legend>
    <label for="telefono">Teléfono:</label>
    <input type="text" id="telefono" name="vendedor[telefono]" placeholder="Teléfono Vendedor" value="{{ old('vendedor.telefono', $vendedor->telefono)}}">
    @error('vendedor.telefono')
        <div class="alerta error">{{ $message }}</div>
    @enderror
</fieldset>