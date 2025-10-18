<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function store(Request $request)
    {
        // Logout from both guards
        Auth::logout();
        Auth::guard('seller')->logout();

        // Invalidar la sesión actual
        $request->session()->invalidate();
        
        // Regenerar el token CSRF para prevenir CSRF attacks
        $request->session()->regenerateToken();
        
        // Limpiar la caché de la sesión
        $request->session()->flush();

        return redirect()->route('home')
            ->with('mensaje', 'Sesión cerrada exitosamente')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
