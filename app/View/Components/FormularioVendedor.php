<?php

namespace App\View\Components;

use App\Models\Seller;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormularioVendedor extends Component
{
    public $vendedor;
    /**
     * Create a new component instance.
     */
    public function __construct($vendedor = null)
    {
        $this->vendedor = $vendedor ?? new Seller();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.formulario-vendedor');
    }
}
