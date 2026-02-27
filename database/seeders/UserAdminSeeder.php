<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('user_admin')->insert([
            'id' => Str::uuid(),
            'nama' => 'Admin Sample',
            'username' => 'adminsample',
            'password' => Hash::make('password123'),  // Harap ganti dengan password yang lebih aman pada produksi
            'email' => 'adminsample@example.com',
            'status' => true,
            'created_by' => Str::uuid(),  // Contoh UUID, Anda mungkin ingin mengubah ini sesuai dengan logika Anda
            'updated_by' => Str::uuid(),  // Contoh UUID, Anda mungkin ingin mengubah ini sesuai dengan logika Anda
        ]);
    }
}
