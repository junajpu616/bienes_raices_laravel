<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SellerController extends Controller
{
    public function index()
    {
        return view('seller.login', [
            'inicio' => false
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('seller')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/seller/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('seller')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/seller/login');
    }

    public function create()
    {
        return view('seller.register', [
            'inicio' => false        
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:30',
            'apellido' => 'required|string|max:30',
            'telefono' => 'required|numeric',
            'email' => 'required|email|unique:sellers',
            'password' => 'required|min:8|confirmed'
        ]);

        $sellerData = [
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'telefono' => $validated['telefono'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ];

        Seller::create($sellerData);

        return redirect('/seller/login')->with('success', 'Registration successful! Please login.');
    }

    public function dashboard()
    {
        $seller = Auth::guard('seller')->user();
        $properties = $seller->properties;

        return view('seller.dashboard', [
            'seller' => $seller,
            'properties' => $properties,
            'inicio' => false
        ]);
    }

    public function edit(Seller $vendedor)
    {
        return view('vendedores.edit', [
            'vendedor' => $vendedor,
            'inicio' => false
        ]);
    }

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
