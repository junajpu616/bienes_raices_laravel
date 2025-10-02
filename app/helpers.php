<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('is_admin')) {
    /**
     * Verificar si el usuario actual es administrador
     * Funciona para ambos guards (web y seller)
     */
    function is_admin(): bool
    {
        // Verificar admin web
        if (Auth::check() && Auth::user()->is_admin) {
            return true;
        }
        
        // Verificar admin seller
        if (Auth::guard('seller')->check() && Auth::guard('seller')->user()->is_admin) {
            return true;
        }
        
        return false;
    }
}