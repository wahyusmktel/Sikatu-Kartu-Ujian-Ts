<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;



class AdminAuthController extends Controller
{
    public function show()
    {
        return view('admin.auth.login');
    }

    public function authenticate(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
    
        // Menentukan apakah pengguna ingin diingat atau tidak
        $remember = $request->has('remember');
    
        // Mencoba untuk mengotentikasi pengguna
        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password], $remember)) {
            return redirect()->intended('/admin/dashboard');
        }

        return redirect()->back()->with('error', 'Invalid login credentials.');
    }    

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
    
}