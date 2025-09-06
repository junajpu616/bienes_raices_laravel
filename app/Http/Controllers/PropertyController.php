<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function index(Request $request)
    {

        $propiedades = Property::all();
        $vendedores = Seller::all();

        $resultado = $request->query('resultado');

        return view('propiedades.index', [
            'inicio' => false,
            'propiedades' => $propiedades,
            'vendedores' => $vendedores,
            'resultado' => $resultado
        ]);
    }

    public function create()
    {
        return view('propiedades.create', [
            'inicio' => false            
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'propiedad.titulo' => 'required|string|max:255',
            'propiedad.precio' => 'required|numeric',
            'propiedad.imagen' => 'required|image|mimes:png,jpg',
            'propiedad.descripcion' => 'required|string',
            'propiedad.habitaciones' => 'required|min:1|max:9',
            'propiedad.wc' => 'required|min:1|max:9',
            'propiedad.estacionamiento' => 'required|min:1|max:9',
            'propiedad.vendedorId' => 'required|exists:sellers,id'
        ]);

        $propiedadesData = [
            'titulo' => $validated['propiedad']['titulo'],
            'precio' => $validated['propiedad']['precio'],
            'imagen' => $validated['propiedad']['imagen'],
            'descripcion' => $validated['propiedad']['descripcion'],
            'habitaciones' => $validated['propiedad']['habitaciones'],
            'wc' => $validated['propiedad']['wc'],
            'estacionamiento' => $validated['propiedad']['estacionamiento'],
            'seller_id' => $validated['propiedad']['vendedorId'],
        ];

        // Manejo de la imagen
        if($request->hasFile('propiedad.imagen')) {
            $rutaCompleta = $request->file('propiedad.imagen')->store('propiedades', 'public');
            $propiedadesData['imagen'] = basename($rutaCompleta);
        }

        Property::create($propiedadesData);

        return redirect()->route('admin')->with('exito', '¡Propiedad Creada Exitosamente!');

    }

    public function edit(Property $propiedad)
    {
        return view('propiedades.edit', [
            'propiedad' => $propiedad,
            'inicio' => false
        ]);
    }

    public function update(Request $request, Property $propiedad)
    {
        $validated = $request->validate([
            'propiedad.titulo' => 'required|string|max:255',
            'propiedad.precio' => 'required|numeric',
            'propiedad.descripcion' => 'required|string',
            'propiedad.habitaciones' => 'required|min:1|max:9',
            'propiedad.wc' => 'required|min:1|max:9',
            'propiedad.estacionamiento' => 'required|min:1|max:9',
            'propiedad.vendedorId' => 'required|exists:sellers,id'
        ]);

        $propiedadesData = [
            'titulo' => $validated['propiedad']['titulo'],
            'precio' => $validated['propiedad']['precio'],
            'descripcion' => $validated['propiedad']['descripcion'],
            'habitaciones' => $validated['propiedad']['habitaciones'],
            'wc' => $validated['propiedad']['wc'],
            'estacionamiento' => $validated['propiedad']['estacionamiento'],
            'seller_id' => $validated['propiedad']['vendedorId'],
        ];

        // Manejo de la imagen
        if($request->hasFile('propiedad.imagen')) {

            if ($propiedad->imagen && Storage::disk('public')->exists('propiedades/' . $propiedad->imagen)) {
                Storage::disk('public')->delete('propiedades/'. $propiedad->imagen);
            }

            $rutaCompleta = $request->file('propiedad.imagen')->store('propiedades', 'public');
            $propiedadesData['imagen'] = basename($rutaCompleta);
        }

        $propiedad->update($propiedadesData);

        return redirect()->route('admin')->with('exito', '¡Propiedad Actualizada Exitosamente!');
    }

    public function destroy(Property $propiedad)
    {
        $propiedad->delete();
        return redirect()->route('admin')->with('exito', '¡Propiedad Eliminada Exitosamente!');
    }
}
