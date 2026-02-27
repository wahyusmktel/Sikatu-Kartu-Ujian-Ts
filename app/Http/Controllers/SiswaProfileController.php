<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaProfileController extends Controller
{
    public function index()
    {
        // Ambil data siswa yang sedang login (jika diperlukan)
        $siswa = auth()->guard('siswa')->user();

        // Render view siswa.profile dan kirim data siswa ke view (jika diperlukan)
        return view('siswa.profile', ['siswa' => $siswa]);
    }
}
