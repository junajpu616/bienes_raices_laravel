<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            'inicio' => false
        ]);
    }

    public function store(Request $request)
    {
        // Validar
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        // Try to authenticate as admin (web guard)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin');
        }

        // Try to authenticate as seller (seller guard)
        if (Auth::guard('seller')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/seller/dashboard');
        }

        return back()->with('mensaje', 'Credenciales Incorrectas');
    }
}
