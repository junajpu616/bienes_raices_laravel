<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function adminIndex()
    {
        // Allow admins from both guards
        $isWebAdmin = Auth::check() && Auth::user()->is_admin;
        $isSellerAdmin = Auth::guard('seller')->check() && Auth::guard('seller')->user()->is_admin;
        
        if (!$isWebAdmin && !$isSellerAdmin) {
            abort(403, 'Acceso denegado. Se requieren permisos de administrador.');
        }

        $vendedores = Seller::all();

        return view('vendedores.index', [
            'vendedores' => $vendedores,
            'inicio' => false
        ]);
    }

    public function destroy(Seller $vendedor)
    {
        // Allow admins from both guards
        $isWebAdmin = Auth::check() && Auth::user()->is_admin;
        $isSellerAdmin = Auth::guard('seller')->check() && Auth::guard('seller')->user()->is_admin;
        
        if (!$isWebAdmin && !$isSellerAdmin) {
            abort(403, 'Acceso denegado. Se requieren permisos de administrador.');
        }

        $vendedor->delete();

        return redirect()->route('vendedores.index')->with('exito', '¡Vendedor Eliminado Exitosamente!');
    }
}
