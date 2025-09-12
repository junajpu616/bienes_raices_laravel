<fieldset>
    <legend>Información General</legend>
    
    <div class="formulario__field">
        <label for="titulo" class="formulario__label formulario__label--required">Título:</label>
        <input type="text" id="titulo" name="propiedad[titulo]" placeholder="Título de la Propiedad" 
               value="{{ old('propiedad.titulo', $propiedad->titulo) }}" 
               class="formulario__input {{ $errors->has('propiedad.titulo') ? 'formulario__input--error' : '' }}" required>
        @error('propiedad.titulo')
            <div class="formulario__error">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="formulario__field">
        <label for="precio" class="formulario__label formulario__label--required">Precio:</label>
        <input type="number" id="precio" name="propiedad[precio]" placeholder="Precio en Quetzales" 
               value="{{ old('propiedad.precio', $propiedad->precio) }}" 
               class="formulario__input {{ $errors->has('propiedad.precio') ? 'formulario__input--error' : '' }}" required>
        <div class="formulario__help">Ingrese el precio sin comas ni símbolos</div>
        @error('propiedad.precio')
            <div class="formulario__error">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="formulario__field">
        <label for="imagen" class="formulario__label">Imagen:</label>
        <input type="file" id="imagen" name="propiedad[imagen]" accept="image/jpeg, image/png" 
               class="formulario__input {{ $errors->has('propiedad.imagen') ? 'formulario__input--error' : '' }}">
        <div class="formulario__help">Formatos permitidos: JPG, PNG. Tamaño máximo: 2MB</div>
        @if($propiedad->imagen)
            <img src="{{ asset('storage/propiedades' . '/' . $propiedad->imagen) }}" alt="Imagen Propiedad" class="imagen-small rounded-lg shadow-md mt-md">
        @endif
        @error('propiedad.imagen')
            <div class="formulario__error">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="formulario__field">
        <label for="descripcion" class="formulario__label formulario__label--required">Descripción:</label>
        <textarea name="propiedad[descripcion]" id="descripcion" placeholder="Describe las características principales de la propiedad..." 
                  class="formulario__textarea {{ $errors->has('propiedad.descripcion') ? 'formulario__input--error' : '' }}" required>{{ old('propiedad.descripcion', $propiedad->descripcion) }}</textarea>
        <div class="formulario__help">Mínimo 50 caracteres, máximo 500 caracteres</div>
        @error('propiedad.descripcion')
            <div class="formulario__error">{{ $message }}</div>
        @enderror
    </div>
</fieldset>

<fieldset>
    <legend>Características de la Propiedad</legend>
    
    <div class="formulario__group--triple">
        <div class="formulario__field">
            <label for="habitaciones" class="formulario__label formulario__label--required">Habitaciones:</label>
            <input type="number" name="propiedad[habitaciones]" id="habitaciones" placeholder="Ej: 3" 
                   min="1" max="20" value="{{ old('propiedad.habitaciones', $propiedad->habitaciones) }}" 
                   class="formulario__input {{ $errors->has('propiedad.habitaciones') ? 'formulario__input--error' : '' }}" required>
            @error('propiedad.habitaciones')
                <div class="formulario__error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="formulario__field">
            <label for="wc" class="formulario__label formulario__label--required">Baños:</label>
            <input type="number" name="propiedad[wc]" id="wc" placeholder="Ej: 2" 
                   min="1" max="10" value="{{ old('propiedad.wc', $propiedad->wc) }}" 
                   class="formulario__input {{ $errors->has('propiedad.wc') ? 'formulario__input--error' : '' }}" required>
            @error('propiedad.wc')
                <div class="formulario__error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="formulario__field">
            <label for="estacionamiento" class="formulario__label formulario__label--required">Estacionamientos:</label>
            <input type="number" name="propiedad[estacionamiento]" id="estacionamiento" placeholder="Ej: 2" 
                   min="0" max="10" value="{{ old('propiedad.estacionamiento', $propiedad->estacionamiento) }}" 
                   class="formulario__input {{ $errors->has('propiedad.estacionamiento') ? 'formulario__input--error' : '' }}" required>
            @error('propiedad.estacionamiento')
                <div class="formulario__error">{{ $message }}</div>
            @enderror
        </div>
    </div>
</fieldset>

@if(!Auth::guard('seller')->check())
<fieldset>
    <legend>Información del Vendedor</legend>
    
    <div class="formulario__field">
        <label for="vendedor" class="formulario__label formulario__label--required">Vendedor Asignado:</label>
        <select name="propiedad[vendedorId]" id="vendedor" 
                class="formulario__select {{ $errors->has('propiedad.vendedorId') ? 'formulario__input--error' : '' }}" required>
            <option selected disabled value="">-- Seleccione un vendedor --</option>
            @foreach($vendedores as $vendedor)
                <option value="{{ $vendedor->id }}" {{ (old('propiedad.vendedorId', $propiedad->seller_id) == $vendedor->id) ? 'selected' : '' }}>
                    {{ $vendedor->nombre }} {{ $vendedor->apellido }} - {{ $vendedor->telefono }}
                </option>
            @endforeach
        </select>
        <div class="formulario__help">Seleccione el vendedor responsable de esta propiedad</div>
        @error('propiedad.vendedorId')
            <div class="formulario__error">{{ $message }}</div>
        @enderror
    </div>
</fieldset>
@endif
