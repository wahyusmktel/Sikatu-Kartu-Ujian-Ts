<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', 'App\Http\Controllers\SiswaAuthController@show')->name('siswa.login');

Route::get('/admin/login', 'App\Http\Controllers\AdminAuthController@show')->name('admin.login')->middleware('admin.redirect');
Route::post('/admin/login', 'App\Http\Controllers\AdminAuthController@authenticate')->name('admin.login.submit');

Route::get('/admin', 'App\Http\Controllers\AdminAuthController@show')->name('admin.login')->middleware('admin.redirect');

Route::get('/siswa/login', 'App\Http\Controllers\SiswaAuthController@show')->name('siswa.login');
Route::post('/siswa/login', 'App\Http\Controllers\SiswaAuthController@authenticate')->name('siswa.login.submit');

Route::get('/redirect/google', 'App\Http\Controllers\SiswaAuthController@redirectToGoogle')->name('redirect.google');
Route::get('/callback/google', 'App\Http\Controllers\SiswaAuthController@handleGoogleCallback');


Route::group(['middleware' => 'siswa'], function () {
    // Daftarkan semua route yang hanya bisa diakses oleh siswa di sini
    Route::get('/siswa/logout', 'App\Http\Controllers\SiswaAuthController@logout');
    Route::get('/siswa/dashboard', 'App\Http\Controllers\SiswaDashboardController@show')->name('siswa.dashboard');
    Route::get('/siswa', 'App\Http\Controllers\SiswaDashboardController@show')->name('siswa.dashboard');
    Route::get('/siswa/profile', 'App\Http\Controllers\SiswaProfileController@index')->name('siswa.profile');
    Route::get('/siswa/kartu', 'App\Http\Controllers\SiswaKartuController@index')->name('siswa.kartu');
    Route::get('/siswa/kartu_ujian/cetak/{id}', 'App\Http\Controllers\KartuUjianController@cetak')->name('kartu.cetak_siswa');
});

// Untuk dashboard dan halaman lain yang memerlukan autentikasi
Route::group(['middleware' => 'admin.auth'], function () {
    Route::get('/admin/logout', 'App\Http\Controllers\AdminAuthController@logout')->name('admin.logout');
    Route::get('/admin/dashboard', 'App\Http\Controllers\AdminDashboardController@show')->name('admin.dashboard');

    //Data Siswa
    Route::post('/admin/siswa/import', 'App\Http\Controllers\AdminSiswaController@importExcel')->name('admin.siswa.import');
    Route::get('/admin/siswa', 'App\Http\Controllers\AdminSiswaController@index')->name('admin.siswa');
    Route::get('/admin/siswa/{id}/edit', 'App\Http\Controllers\AdminSiswaController@edit')->name('admin.siswa.edit');
    Route::get('/admin/siswa/{id}/relasi', 'App\Http\Controllers\AdminSiswaController@cekRelasi')->name('admin.siswa.relasi');
    Route::put('/admin/siswa/{id}', 'App\Http\Controllers\AdminSiswaController@update')->name('admin.siswa.update');
    Route::delete('/admin/siswa/{id}', 'App\Http\Controllers\AdminSiswaController@destroy')->name('admin.siswa.destroy');

    //Data Ujian
    Route::get('/admin/ujian', 'App\Http\Controllers\AdminUjianController@index')->name('admin.ujian.index');
    Route::post('/admin/ujian', 'App\Http\Controllers\AdminUjianController@store')->name('admin.ujian.store');
    Route::post('/admin/ujian/update-status/{id}', 'App\Http\Controllers\AdminUjianController@updateStatus')->name('admin.ujian.updateStatus');
    Route::get('/admin/ujian/{id}/edit', 'App\Http\Controllers\AdminUjianController@edit')->name('admin.ujian.edit');
    Route::put('/admin/ujian/{id}', 'App\Http\Controllers\AdminUjianController@update')->name('admin.ujian.update');
    Route::delete('/admin/ujian/{id}', 'App\Http\Controllers\AdminUjianController@destroy')->name('admin.ujian.destroy');

    //Genereted Kartu
    Route::get('/admin/generated_kartu', 'App\Http\Controllers\AdminGeneratedKartuController@index')->name('admin.kartu');
    Route::post('/admin/generated_kartu', 'App\Http\Controllers\AdminGeneratedKartuController@generate')->name('admin.generate');

    //Aktivasi Kartu
    Route::get('/admin/aktivasi_kartu', 'App\Http\Controllers\AdminAktivasiKartuController@index')->name('admin.aktivasi');
    Route::post('/admin/aktivasi_kartu', 'App\Http\Controllers\AdminAktivasiKartuController@insert')->name('admin.aktivasi');
    Route::get('/admin/kartu_ujian/cetak/{id}', 'App\Http\Controllers\KartuUjianController@cetak')->name('kartu.cetak');
    Route::get('/admin/aktivasi_kartu/export', 'App\Http\Controllers\AdminAktivasiKartuController@exportSiswaAktivasi')->name('aktivasi.export');
    Route::get('/admin/aktivasi_kartu/export_belum_aktivasi', 'App\Http\Controllers\AdminAktivasiKartuController@exportSiswaBelumAktivasi')->name('belumaktivasi.export');

    //Generated CBT User
    Route::get('/admin/generated_cbt', 'App\Http\Controllers\AdminGeneratedCbtController@index')->name('admin.generated_cbt');
    Route::post('/admin/generated_cbt', 'App\Http\Controllers\AdminGeneratedCbtController@generateUserCbt')->name('admin.generated_cbt_post');
    Route::delete('/admin/generated_cbt/{id}', 'App\Http\Controllers\AdminGeneratedCbtController@destroy')->name('admin.generated_cbt.destroy');
    Route::get('/admin/export-cbt-csv', 'App\Http\Controllers\AdminGeneratedCbtController@exportToCSV')->name('admin.export_cbt_csv');

    //Generated CBT User Susulan
    Route::get('/admin/generated_cbt_susulan', 'App\Http\Controllers\AdminGeneratedCbtSusulanController@index')->name('admin.generated_cbt_susulan');
    Route::post('/admin/generated_cbt_susulan', 'App\Http\Controllers\AdminGeneratedCbtSusulanController@generateUserCbtSusulan')->name('admin.generated_cbt_post_susulan');
    Route::delete('/admin/generated_cbt_susulan/{id}', 'App\Http\Controllers\AdminGeneratedCbtSusulanController@destroy')->name('admin.generated_cbt_susulan.destroy');
    Route::get('/admin/export-cbt-csv_susulan', 'App\Http\Controllers\AdminGeneratedCbtSusulanController@exportToCSV')->name('admin.export_cbt_csv_susulan');

    // Mapel CBT
    Route::get('/admin/mapel_cbt', 'App\Http\Controllers\AdminMapelCbtController@index')->name('admin.mapel_cbt');
    Route::post('/admin/mapel_cbt', 'App\Http\Controllers\AdminMapelCbtController@store')->name('admin.tambah_mapel_cbt');
    //Export ke csv
    Route::get('/admin/mapel_cbt/export', 'App\Http\Controllers\AdminMapelCbtController@exportToCSV')->name('admin.mapel_cbt.export');

    // Rombel
    Route::get('/admin/rombel', 'App\Http\Controllers\AdminRombelController@index')->name('admin.rombel');
    Route::post('/admin/rombel', 'App\Http\Controllers\AdminRombelController@store')->name('admin.tambah_rombel');
    Route::get('/admin/rombel/{id}/anggota', 'App\Http\Controllers\AdminRombelController@anggota')->name('admin.rombel.anggota');
    Route::post('/admin/rombel/{id}/tambah-siswa', 'App\Http\Controllers\AdminRombelController@tambahSiswa')->name('admin.rombel.tambah_siswa');
    Route::post('/admin/rombel/keluarkan-siswa/{id_siswa}', 'App\Http\Controllers\AdminRombelController@keluarkanSiswa')->name('admin.rombel.keluarkan_siswa');
    Route::put('/admin/rombel/{id}', 'App\Http\Controllers\AdminRombelController@update')->name('admin.rombel.update');
    Route::post('/admin/rombel/{id}/bulk-tambah', 'App\Http\Controllers\AdminRombelController@bulkTambahSiswa')->name('admin.rombel.bulk_tambah');
    Route::post('/admin/rombel/bulk-keluarkan', 'App\Http\Controllers\AdminRombelController@bulkKeluarkanSiswa')->name('admin.rombel.bulk_keluarkan');


    //Admin Szettings
    Route::post('/admin/settings/', 'App\Http\Controllers\AdminSettingsController@update')->name('settings.update');
    Route::get('/admin/settings/', 'App\Http\Controllers\AdminSettingsController@edit')->name('settings.edit');
    Route::get('/admin', 'App\Http\Controllers\AdminSettingsController@index')->name('settings');

    //Server
    Route::get('/admin/server/monitoring', 'App\Http\Controllers\MonitoringServerController@index')->name('admin.server.monitoring');
    Route::get('/admin/server/cpu-usage', 'App\Http\Controllers\MonitoringServerController@cpuUsage')->name('admin.server.cpuUsage');
    Route::get('/admin/server/ram-usage', 'App\Http\Controllers\MonitoringServerController@ramUsage')->name('admin.server.ramUsage');
    Route::get('/admin/server/network-stats', 'App\Http\Controllers\MonitoringServerController@networkStats')->name('admin.server.networkStats');


});

