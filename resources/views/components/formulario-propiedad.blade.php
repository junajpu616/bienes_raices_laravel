<fieldset>
    <legend>Información General</legend>
    
    <div class="formulario__field {{ $errors->has('propiedad.titulo') ? 'formulario__field--error' : '' }}">
        <input 
            type="text" 
            id="titulo" 
            name="propiedad[titulo]" 
            placeholder=""
            value="{{ old('propiedad.titulo', $propiedad->titulo ?? '') }}" 
            class="formulario__input" 
            required
        >
        <label for="titulo" class="formulario__label formulario__label--floating">Título de la Propiedad</label>
        @error('propiedad.titulo')
            <div class="formulario__error">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="formulario__field {{ $errors->has('propiedad.precio') ? 'formulario__field--error' : '' }}">
        <input 
            type="number" 
            id="precio" 
            name="propiedad[precio]" 
            placeholder=""
            value="{{ old('propiedad.precio', $propiedad->precio ?? '') }}" 
            class="formulario__input" 
            required
        >
        <label for="precio" class="formulario__label formulario__label--floating">Precio (Quetzales)</label>
        <div class="formulario__help">Ingrese el precio sin comas ni símbolos</div>
        @error('propiedad.precio')
            <div class="formulario__error">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="formulario__field {{ $errors->has('propiedad.imagen') ? 'formulario__field--error' : '' }}">
        <input 
            type="file" 
            id="imagen" 
            name="propiedad[imagen]" 
            accept="image/jpeg, image/png" 
            class="formulario__input formulario__input--file"
        >
        <label for="imagen" class="formulario__label">Imagen de la Propiedad</label>
        <div class="formulario__help">Formatos permitidos: JPG, PNG. Tamaño máximo: 2MB</div>
        @if(isset($propiedad->imagen) && $propiedad->imagen)
            <img src="{{ asset('storage/propiedades' . '/' . $propiedad->imagen) }}" alt="Imagen Propiedad" class="imagen-small rounded-lg shadow-md mt-md">
        @endif
        @error('propiedad.imagen')
            <div class="formulario__error">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="formulario__field {{ $errors->has('propiedad.descripcion') ? 'formulario__field--error' : '' }}">
        <textarea 
            name="propiedad[descripcion]" 
            id="descripcion" 
            placeholder=""
            class="formulario__textarea" 
            required
        >{{ old('propiedad.descripcion', $propiedad->descripcion ?? '') }}</textarea>
        <label for="descripcion" class="formulario__label formulario__label--floating">Descripción de la Propiedad</label>
        <div class="formulario__help">Mínimo 50 caracteres, máximo 500 caracteres</div>
        @error('propiedad.descripcion')
            <div class="formulario__error">{{ $message }}</div>
        @enderror
    </div>
</fieldset>

<fieldset>
    <legend>Características</legend>
    
    <div class="formulario__field {{ $errors->has('propiedad.habitaciones') ? 'formulario__field--error' : '' }}">
        <input 
            type="number" 
            id="habitaciones" 
            name="propiedad[habitaciones]" 
            placeholder=""
            value="{{ old('propiedad.habitaciones', $propiedad->habitaciones ?? '') }}" 
            class="formulario__input" 
            min="1" 
            max="10" 
            required
        >
        <label for="habitaciones" class="formulario__label formulario__label--floating">Número de Habitaciones</label>
        @error('propiedad.habitaciones')
            <div class="formulario__error">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="formulario__field {{ $errors->has('propiedad.wc') ? 'formulario__field--error' : '' }}">
        <input 
            type="number" 
            id="wc" 
            name="propiedad[wc]" 
            placeholder=""
            value="{{ old('propiedad.wc', $propiedad->wc ?? '') }}" 
            class="formulario__input" 
            min="1" 
            max="5" 
            required
        >
        <label for="wc" class="formulario__label formulario__label--floating">Número de Baños</label>
        @error('propiedad.wc')
            <div class="formulario__error">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="formulario__field {{ $errors->has('propiedad.estacionamiento') ? 'formulario__field--error' : '' }}">
        <input 
            type="number" 
            id="estacionamiento" 
            name="propiedad[estacionamiento]" 
            placeholder=""
            value="{{ old('propiedad.estacionamiento', $propiedad->estacionamiento ?? '') }}" 
            class="formulario__input" 
            min="0" 
            max="5" 
            required
        >
        <label for="estacionamiento" class="formulario__label formulario__label--floating">Espacios de Estacionamiento</label>
        @error('propiedad.estacionamiento')
            <div class="formulario__error">{{ $message }}</div>
        @enderror
    </div>
</fieldset>

@if(!Auth::guard('seller')->check())
<fieldset>
    <legend>Información del Vendedor</legend>
    
    <div class="formulario__field {{ $errors->has('propiedad.vendedorId') ? 'formulario__field--error' : '' }}">
        <select name="propiedad[vendedorId]" id="vendedor" class="formulario__select" required>
            <option value="">-- Seleccione un vendedor --</option>
            @foreach($vendedores as $vendedor)
                <option value="{{ $vendedor->id }}" {{ (old('propiedad.vendedorId', $propiedad->seller_id ?? '') == $vendedor->id) ? 'selected' : '' }}>
                    {{ $vendedor->nombre }} {{ $vendedor->apellido }} - {{ $vendedor->telefono }}
                </option>
            @endforeach
        </select>
        <label for="vendedor" class="formulario__label">Vendedor Responsable</label>
        <div class="formulario__help">Seleccione el vendedor responsable de esta propiedad</div>
        @error('propiedad.vendedorId')
            <div class="formulario__error">{{ $message }}</div>
        @enderror
    </div>
</fieldset>
@endif
