<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminSiswa;


class SiswaDashboardController extends Controller
{
    public function show()
    {
        $totalSiswa = AdminSiswa::count();
        
        return view('siswa.dashboard', compact('totalSiswa'));
    }
    
}
