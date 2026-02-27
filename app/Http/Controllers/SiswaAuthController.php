<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use App\Models\SiswaAuth;



class SiswaAuthController extends Controller
{
    public function show()
    {
        // Jika siswa sudah login
        if (Auth::guard('siswa')->check()) {
            return redirect('/siswa/dashboard');
        }
        
        return view('siswa.auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $siswa = SiswaAuth::where('nipd', $credentials['username'])->first();

        // Cek login manual pakai nipd & password
        if ($siswa && Hash::check($credentials['password'], $siswa->password)) {
            Auth::guard('siswa')->login($siswa);
            $request->session()->regenerate();

            return redirect()->intended('/siswa/dashboard');
        }

        return back()->with('error', 'NIPD atau Password salah.');
    }

    public function redirectToGoogle()
    {
        // metode tanpa memilih akun
        // return Socialite::driver('google')->redirect();

        //metode pemilihan akun
        return Socialite::driver('google')->with(['prompt' => 'select_account'])->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        // Simpan data ke dalam session
        session([
            'avatar' => $user->avatar,
            'name' => $user->getName(),
            'email' => $user->getEmail()
        ]);

        // Menggunakan model di awal fungsi
        $siswa = SiswaAuth::where('e-mail', $user->getEmail())->first();  // Perhatikan bahwa kita menggunakan 'email', bukan 'e-mail'.
        

        if (!$siswa) {
            return redirect('/siswa/login')->with('error', 'Email Anda tidak terdaftar di sistem kami.');
        }

        Auth::guard('siswa')->login($siswa);

        return redirect('/siswa/dashboard');
    }

    public function logout()
    {
        // Melakukan logout dari guard siswa
        Auth::guard('siswa')->logout();

        // Mengarahkan kembali ke halaman /siswa/login setelah logout
        return redirect('/siswa/login');
    }


}