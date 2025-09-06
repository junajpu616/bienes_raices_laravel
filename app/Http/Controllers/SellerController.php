<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function create()
    {
        return view('vendedores.create', [
            'inicio' => false
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendedor.nombre' => 'required|string|max:30',
            'vendedor.apellido' => 'required|string|max:30',
            'vendedor.telefono' => 'required|numeric'
        ]);

        $vendedoresData = [
            'nombre' => $validated['vendedor']['nombre'],
            'apellido' => $validated['vendedor']['apellido'],
            'telefono' => $validated['vendedor']['telefono']
        ];

        Seller::create($vendedoresData);

        return redirect()->route('admin')->with('exito', '¡Vendedor Creado Exitosamente!');
    }

    public function edit(Seller $vendedor)
    {
        return view('vendedores.edit', [
            'vendedor' => $vendedor,
            'inicio' => false
        ]);
    }
}
