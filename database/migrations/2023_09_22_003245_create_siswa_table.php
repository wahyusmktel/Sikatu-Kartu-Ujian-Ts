<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(Str::uuid());
            $table->string('nama')->nullable();
            $table->string('nipd')->nullable();
            $table->string('jk')->nullable();
            $table->string('nisn')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nik')->nullable();
            $table->string('agama')->nullable();
            $table->text('alamat')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('dusun')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('jenis_tinggal')->nullable();
            $table->string('alat_transportasi')->nullable();
            $table->string('telepon')->nullable();
            $table->string('hp')->nullable();
            $table->string('e-mail')->unique();
            $table->string('skhun')->nullable();
            $table->string('penerima_kps')->nullable();
            $table->string('no_kps')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->year('tahun_lahir_ayah')->nullable();
            $table->string('jenjang_pendidikan_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->unsignedBigInteger('penghasilan_ayah')->nullable();
            $table->string('nik_ayah')->unique()->nullable();
            $table->string('nama_ibu')->nullable();
            $table->year('tahun_lahir_ibu')->nullable();
            $table->string('jenjang_pendidikan_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->unsignedBigInteger('penghasilan_ibu')->nullable();
            $table->string('nik_ibu')->unique();
            $table->string('nama_wali')->nullable();
            $table->year('tahun_lahir_wali')->nullable();
            $table->string('jenjang_pendidikan_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->unsignedBigInteger('penghasilan_wali')->nullable();
            $table->string('nik_wali')->unique()->nullable();
            $table->string('rombel_saat_ini')->nullable();
            $table->string('no_peserta_ujian_nasional')->nullable();
            $table->string('no_seri_ijazah')->nullable();
            $table->string('penerima_kip')->nullable();
            $table->string('nomor_kip')->nullable();
            $table->string('nama_di_kip')->nullable();
            $table->string('nomor_kks')->nullable();
            $table->string('no_registrasi_akta_lahir')->nullable();
            $table->string('bank')->nullable();
            $table->string('nomor_rekening_bank')->nullable();
            $table->string('rekening_atas_nama')->nullable();
            $table->boolean('layak_pip')->nullable();
            $table->text('alasan_layak_pip')->nullable();
            $table->string('kebutuhan_khusus')->nullable();
            $table->string('sekolah_asal')->nullable();
            $table->integer('anak_ke-berapa')->nullable();
            $table->decimal('lintang', 10, 7)->nullable();
            $table->decimal('bujur', 10, 7)->nullable();
            $table->string('no_kk')->nullable();
            $table->unsignedTinyInteger('berat_badan')->nullable(); // in kg
            $table->unsignedTinyInteger('tinggi_badan')->nullable(); // in cm
            $table->unsignedTinyInteger('lingkar_kepala')->nullable(); // in cm
            $table->integer('jml_saudara')->nullable();
            $table->decimal('jarak_rumah', 5, 2)->nullable(); // in km
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siswa');
    }
}
