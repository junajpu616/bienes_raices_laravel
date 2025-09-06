<?php

namespace App\View\Components;

use App\Models\Property;
use App\Models\Seller;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormularioPropiedad extends Component
{
    public $propiedad;
    public $vendedores;
    /**
     * Create a new component instance.
     */
    public function __construct($propiedad = null, $vendedores = null)
    {
        $this->propiedad = $propiedad ?? new Property();
        $this->vendedores = $vendedores ?? Seller::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.formulario-propiedad');
    }
}
