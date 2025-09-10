<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        // Check if seller is authenticated
        if (Auth::guard('seller')->check()) {
            $seller = Auth::guard('seller')->user();
            $propiedades = $seller->properties;
            $vendedores = [$seller]; // Only current seller
        } else {
            // Admin view - show all
            $propiedades = Property::all();
            $vendedores = Seller::all();
        }

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
        $rules = [
            'propiedad.titulo' => 'required|string|max:255',
            'propiedad.precio' => 'required|numeric',
            'propiedad.imagen' => 'required|image|mimes:png,jpg',
            'propiedad.descripcion' => 'required|string',
            'propiedad.habitaciones' => 'required|min:1|max:9',
            'propiedad.wc' => 'required|min:1|max:9',
            'propiedad.estacionamiento' => 'required|min:1|max:9',
        ];

        // Only require vendedorId if not authenticated as seller
        if (!Auth::guard('seller')->check()) {
            $rules['propiedad.vendedorId'] = 'required|exists:sellers,id';
        }

        $validated = $request->validate($rules);

        $propiedadesData = [
            'titulo' => $validated['propiedad']['titulo'],
            'precio' => $validated['propiedad']['precio'],
            'imagen' => $validated['propiedad']['imagen'],
            'descripcion' => $validated['propiedad']['descripcion'],
            'habitaciones' => $validated['propiedad']['habitaciones'],
            'wc' => $validated['propiedad']['wc'],
            'estacionamiento' => $validated['propiedad']['estacionamiento'],
        ];

        // Set seller_id based on authentication
        if (Auth::guard('seller')->check()) {
            $propiedadesData['seller_id'] = Auth::guard('seller')->id();
        } else {
            $propiedadesData['seller_id'] = $validated['propiedad']['vendedorId'];
        }

        // Manejo de la imagen
        if($request->hasFile('propiedad.imagen')) {
            $rutaCompleta = $request->file('propiedad.imagen')->store('propiedades', 'public');
            $propiedadesData['imagen'] = basename($rutaCompleta);
        }

        Property::create($propiedadesData);

        if (Auth::guard('seller')->check()) {
            return redirect()->route('seller.dashboard')->with('exito', '¡Propiedad Creada Exitosamente!');
        }

        return redirect()->route('admin')->with('exito', '¡Propiedad Creada Exitosamente!');

    }

    public function edit(Property $propiedad)
    {
        // Check if seller owns this property
        if (Auth::guard('seller')->check()) {
            $seller = Auth::guard('seller')->user();
            if ($propiedad->seller_id !== $seller->id) {
                abort(403, 'Unauthorized');
            }
        }

        return view('propiedades.edit', [
            'propiedad' => $propiedad,
            'inicio' => false
        ]);
    }

    public function update(Request $request, Property $propiedad)
    {
        // Check if seller owns this property
        if (Auth::guard('seller')->check()) {
            $seller = Auth::guard('seller')->user();
            if ($propiedad->seller_id !== $seller->id) {
                abort(403, 'Unauthorized');
            }
        }

        $rules = [
            'propiedad.titulo' => 'required|string|max:255',
            'propiedad.precio' => 'required|numeric',
            'propiedad.descripcion' => 'required|string',
            'propiedad.habitaciones' => 'required|min:1|max:9',
            'propiedad.wc' => 'required|min:1|max:9',
            'propiedad.estacionamiento' => 'required|min:1|max:9',
        ];

        // Only require vendedorId if not authenticated as seller
        if (!Auth::guard('seller')->check()) {
            $rules['propiedad.vendedorId'] = 'required|exists:sellers,id';
        }

        $validated = $request->validate($rules);

        $propiedadesData = [
            'titulo' => $validated['propiedad']['titulo'],
            'precio' => $validated['propiedad']['precio'],
            'descripcion' => $validated['propiedad']['descripcion'],
            'habitaciones' => $validated['propiedad']['habitaciones'],
            'wc' => $validated['propiedad']['wc'],
            'estacionamiento' => $validated['propiedad']['estacionamiento'],
        ];

        // Set seller_id based on authentication
        if (Auth::guard('seller')->check()) {
            $propiedadesData['seller_id'] = Auth::guard('seller')->id();
        } else {
            $propiedadesData['seller_id'] = $validated['propiedad']['vendedorId'];
        }

        // Manejo de la imagen
        if($request->hasFile('propiedad.imagen')) {

            if ($propiedad->imagen && Storage::disk('public')->exists('propiedades/' . $propiedad->imagen)) {
                Storage::disk('public')->delete('propiedades/'. $propiedad->imagen);
            }

            $rutaCompleta = $request->file('propiedad.imagen')->store('propiedades', 'public');
            $propiedadesData['imagen'] = basename($rutaCompleta);
        }

        $propiedad->update($propiedadesData);

        if (Auth::guard('seller')->check()) {
            return redirect()->route('seller.dashboard')->with('exito', '¡Propiedad Actualizada Exitosamente!');
        }

        return redirect()->route('admin')->with('exito', '¡Propiedad Actualizada Exitosamente!');
    }

    public function destroy(Property $propiedad)
    {
        // Check if seller owns this property
        if (Auth::guard('seller')->check()) {
            $seller = Auth::guard('seller')->user();
            if ($propiedad->seller_id !== $seller->id) {
                abort(403, 'Unauthorized');
            }
        }

        $propiedad->delete();

        if (Auth::guard('seller')->check()) {
            return redirect()->route('seller.dashboard')->with('exito', '¡Propiedad Eliminada Exitosamente!');
        }

        return redirect()->route('admin')->with('exito', '¡Propiedad Eliminada Exitosamente!');
    }
}
