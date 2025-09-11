<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function store()
    {
        // Logout from both guards
        Auth::logout();
        Auth::guard('seller')->logout();

        return redirect()->route('home');
    }
}
