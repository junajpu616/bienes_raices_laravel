<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si es admin desde el guard web
        $isWebAdmin = Auth::check() && Auth::user()->is_admin;
        
        // Verificar si es admin desde el guard seller
        $isSellerAdmin = Auth::guard('seller')->check() && Auth::guard('seller')->user()->is_admin;
        
        if (!$isWebAdmin && !$isSellerAdmin) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Acceso denegado',
                    'message' => 'Se requieren permisos de administrador'
                ], 403);
            }
            
            return redirect()->route('login')->with('error', 'Se requieren permisos de administrador');
        }

        return $next($request);
    }
}