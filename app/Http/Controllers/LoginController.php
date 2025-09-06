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

        // Autenticar
        if(!Auth::attempt($request->only('email', 'password')))
        {
            return back()->with('mensaje', 'Credenciales Incorrectas');
        }

        return redirect()->route('admin');
    }
}
