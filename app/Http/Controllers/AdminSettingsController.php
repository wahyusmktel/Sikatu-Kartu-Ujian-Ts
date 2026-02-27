<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminSettings;

class AdminSettingsController extends Controller
{

    public function index() 
    {
        $setting = AdminSettings::where('status', true)->first();
        
        return view('admin.layouts.app', ['setting' => $setting]);
    }
    
    public function edit()
    {
        $settings = AdminSettings::where('status', true)->first();

        if (!$settings) {
            $settings = new AdminSettings();
        }

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        // Mencari data dengan status true
        $settings = AdminSettings::where('status', true)->first();

        // Validasi data yang masuk
        $data = $request->validate([
            'nama_sekolah'   => 'required|string|max:255',
            'nama_kepsek'    => 'required|string|max:255',
            'no_hp_sekolah'  => 'required|string|max:15',
            'no_hp_cs'       => 'required|string|max:15',
            'no_hp_admin'    => 'required|string|max:15',
            'email_sekolah'  => 'required|email|max:255',
            'logo_sekolah'   => 'sometimes|image|max:2048', 
            'npsn'           => 'required|string|max:50',
            'alamat_sekolah' => 'required|string|max:500',
        ]);

        // Jika ada file logo yang diunggah, simpan dan update path
        if ($request->hasFile('logo_sekolah')) {
            // Simpan file ke direktori yang diinginkan
            $path = $request->file('logo_sekolah')->store('logos', 'public');
            $data['logo_sekolah'] = $path;
        }

        // Update atau buat data settings
        if ($settings) {
            $settings->update($data);
        } else {
            $data['status'] = true;
            AdminSettings::create($data);
        }

        return redirect()->back()->with('success', 'Settings berhasil diperbarui.');
    }
}
