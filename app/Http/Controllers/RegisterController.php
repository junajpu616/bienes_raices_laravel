<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register', [
            'inicio' => false
        ]);
    }

    public function store(Request $request)
    {        
        // Validar
        $validated = $request->validate([
            'name' => 'required|string|max:30',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required'
        ]);
        

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'])
            ]);
        
            return redirect()->route('admin')->with('exito', '¡Registro Exitoso!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors([
                'email' => 'El correo electrónico ya está en uso.'
            ]);
        }
    }
}
