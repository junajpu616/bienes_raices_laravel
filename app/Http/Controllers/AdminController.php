<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function adminIndex()
    {
        // Only allow if not authenticated as seller (admin)
        if (Auth::guard('seller')->check()) {
            abort(403, 'Unauthorized');
        }

        $vendedores = Seller::all();

        return view('vendedores.index', [
            'vendedores' => $vendedores,
            'inicio' => false
        ]);
    }

    public function destroy(Seller $vendedor)
    {
        // Only allow if not authenticated as seller (admin)
        if (Auth::guard('seller')->check()) {
            abort(403, 'Unauthorized');
        }

        $vendedor->delete();

        return redirect()->route('vendedores.index')->with('exito', '¡Vendedor Eliminado Exitosamente!');
    }
}
