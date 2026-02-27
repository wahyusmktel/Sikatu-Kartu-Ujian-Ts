@extends('siswa.layouts.app')

@section('page-title', 'Profile')

@section('breadcrumbs')
    <li class="nav-home">
        <a href="/siswa/dashboard">
            <i class="flaticon-home"></i>
        </a>
    </li>
    <li class="separator">
        <i class="flaticon-right-arrow"></i>
    </li>
    <li class="nav-item">
        <a href="/siswa/profile">Profile</a>
    </li>
@endsection

@section('content')
    <div class="page-category">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Profil Siswa</div>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <!-- Kolom Pertama -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" class="form-control" id="nama" value="{{ auth('siswa')->user()->nama }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nipd">NIPD</label>
                                        <input type="text" class="form-control" id="nipd" value="{{ auth('siswa')->user()->nipd }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="jk">Jenis Kelamin</label>
                                        <input type="text" class="form-control" id="jk" value="{{ auth('siswa')->user()->jk }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nisn">NISN</label>
                                        <input type="text" class="form-control" id="nisn" value="{{ auth('siswa')->user()->nisn }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="tempat_lahir">Tempat Lahir</label>
                                        <input type="text" class="form-control" id="tempat_lahir" value="{{ auth('siswa')->user()->tempat_lahir }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal_lahir">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tanggal_lahir" value="{{ auth('siswa')->user()->tanggal_lahir }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nik">NIK</label>
                                        <input type="text" class="form-control" id="nik" value="{{ auth('siswa')->user()->nik }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="agama">Agama</label>
                                        <input type="text" class="form-control" id="agama" value="{{ auth('siswa')->user()->agama }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <input type="text" class="form-control" id="alamat" value="{{ auth('siswa')->user()->alamat }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="rt">RT</label>
                                        <input type="text" class="form-control" id="rt" value="{{ auth('siswa')->user()->rt }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="rw">RW</label>
                                        <input type="text" class="form-control" id="rw" value="{{ auth('siswa')->user()->rw }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="penerima_kps">Penerima KPS</label>
                                        <input type="text" class="form-control" id="penerima_kps" value="{{ auth('siswa')->user()->penerima_kps }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_kps">No KPS</label>
                                        <input type="text" class="form-control" id="no_kps" value="{{ auth('siswa')->user()->no_kps }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_ayah">Nama Ayah</label>
                                        <input type="text" class="form-control" id="nama_ayah" value="{{ auth('siswa')->user()->nama_ayah }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="tahun_lahir_ayah">Tahun Lahir Ayah</label>
                                        <input type="text" class="form-control" id="tahun_lahir_ayah" value="{{ auth('siswa')->user()->tahun_lahir_ayah }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="jenjang_pendidikan_ayah">Jenjang Pendidikan Ayah</label>
                                        <input type="text" class="form-control" id="jenjang_pendidikan_ayah" value="{{ auth('siswa')->user()->jenjang_pendidikan_ayah }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="pekerjaan_ayah">Pekerjaan Ayah</label>
                                        <input type="text" class="form-control" id="pekerjaan_ayah" value="{{ auth('siswa')->user()->pekerjaan_ayah }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="penghasilan_ayah">Penghasilan Ayah</label>
                                        <input type="text" class="form-control" id="penghasilan_ayah" value="{{ auth('siswa')->user()->penghasilan_ayah }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nik_ayah">NIK Ayah</label>
                                        <input type="text" class="form-control" id="nik_ayah" value="{{ auth('siswa')->user()->nik_ayah }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_ibu">Nama Ibu</label>
                                        <input type="text" class="form-control" id="nama_ibu" value="{{ auth('siswa')->user()->nama_ibu }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="tahun_lahir_ibu">Tahun Lahir Ibu</label>
                                        <input type="text" class="form-control" id="tahun_lahir_ibu" value="{{ auth('siswa')->user()->tahun_lahir_ibu }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="rombel_saat_ini">Rombel Saat Ini</label>
                                        <input type="text" class="form-control" id="rombel_saat_ini" value="{{ auth('siswa')->user()->rombel_saat_ini }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_peserta_ujian_nasional">No. Peserta Ujian Nasional</label>
                                        <input type="text" class="form-control" id="no_peserta_ujian_nasional" value="{{ auth('siswa')->user()->no_peserta_ujian_nasional }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_seri_ijazah">No. Seri Ijazah</label>
                                        <input type="text" class="form-control" id="no_seri_ijazah" value="{{ auth('siswa')->user()->no_seri_ijazah }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="penerima_kip">Penerima KIP</label>
                                        <input type="text" class="form-control" id="penerima_kip" value="{{ auth('siswa')->user()->penerima_kip }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nomor_kip">Nomor KIP</label>
                                        <input type="text" class="form-control" id="nomor_kip" value="{{ auth('siswa')->user()->nomor_kip }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_di_kip">Nama di KIP</label>
                                        <input type="text" class="form-control" id="nama_di_kip" value="{{ auth('siswa')->user()->nama_di_kip }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nomor_kks">Nomor KKS</label>
                                        <input type="text" class="form-control" id="nomor_kks" value="{{ auth('siswa')->user()->nomor_kks }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_registrasi_akta_lahir">No. Registrasi Akta Lahir</label>
                                        <input type="text" class="form-control" id="no_registrasi_akta_lahir" value="{{ auth('siswa')->user()->no_registrasi_akta_lahir }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="bank">Bank</label>
                                        <input type="text" class="form-control" id="bank" value="{{ auth('siswa')->user()->bank }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nomor_rekening_bank">Nomor Rekening Bank</label>
                                        <input type="text" class="form-control" id="nomor_rekening_bank" value="{{ auth('siswa')->user()->nomor_rekening_bank }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="rekening_atas_nama">Rekening Atas Nama</label>
                                        <input type="text" class="form-control" id="rekening_atas_nama" value="{{ auth('siswa')->user()->rekening_atas_nama }}" readonly>
                                    </div>
                                </div>
                        
                                <!-- Kolom Kedua -->
                                <div class="col-md-6">
                                    
                                    <div class="form-group">
                                        <label for="dusun">Dusun</label>
                                        <input type="text" class="form-control" id="dusun" value="{{ auth('siswa')->user()->dusun }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="kelurahan">Kelurahan</label>
                                        <input type="text" class="form-control" id="kelurahan" value="{{ auth('siswa')->user()->kelurahan }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="kecamatan">Kecamatan</label>
                                        <input type="text" class="form-control" id="kecamatan" value="{{ auth('siswa')->user()->kecamatan }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="kode_pos">Kode Pos</label>
                                        <input type="text" class="form-control" id="kode_pos" value="{{ auth('siswa')->user()->kode_pos }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="jenis_tinggal">Jenis Tinggal</label>
                                        <input type="text" class="form-control" id="jenis_tinggal" value="{{ auth('siswa')->user()->jenis_tinggal }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="alat_transportasi">Alat Transportasi</label>
                                        <input type="text" class="form-control" id="alat_transportasi" value="{{ auth('siswa')->user()->alat_transportasi }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="telepon">Telepon</label>
                                        <input type="text" class="form-control" id="telepon" value="{{ auth('siswa')->user()->telepon }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="hp">HP</label>
                                        <input type="text" class="form-control" id="hp" value="{{ auth('siswa')->user()->hp }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="e-mail">E-Mail</label>
                                        <input type="email" class="form-control" id="e-mail" value="{{ auth('siswa')->user()['e-mail'] }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="skhun">SKHUN</label>
                                        <input type="text" class="form-control" id="skhun" value="{{ auth('siswa')->user()->skhun }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="jenjang_pendidikan_ibu">Jenjang Pendidikan Ibu</label>
                                        <input type="text" class="form-control" id="jenjang_pendidikan_ibu" value="{{ auth('siswa')->user()->jenjang_pendidikan_ibu }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="pekerjaan_ibu">Pekerjaan Ibu</label>
                                        <input type="text" class="form-control" id="pekerjaan_ibu" value="{{ auth('siswa')->user()->pekerjaan_ibu }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="penghasilan_ibu">Penghasilan Ibu</label>
                                        <input type="text" class="form-control" id="penghasilan_ibu" value="{{ auth('siswa')->user()->penghasilan_ibu }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nik_ibu">NIK Ibu</label>
                                        <input type="text" class="form-control" id="nik_ibu" value="{{ auth('siswa')->user()->nik_ibu }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_wali">Nama Wali</label>
                                        <input type="text" class="form-control" id="nama_wali" value="{{ auth('siswa')->user()->nama_wali }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="tahun_lahir_wali">Tahun Lahir Wali</label>
                                        <input type="text" class="form-control" id="tahun_lahir_wali" value="{{ auth('siswa')->user()->tahun_lahir_wali }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="jenjang_pendidikan_wali">Jenjang Pendidikan Wali</label>
                                        <input type="text" class="form-control" id="jenjang_pendidikan_wali" value="{{ auth('siswa')->user()->jenjang_pendidikan_wali }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="pekerjaan_wali">Pekerjaan Wali</label>
                                        <input type="text" class="form-control" id="pekerjaan_wali" value="{{ auth('siswa')->user()->pekerjaan_wali }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="penghasilan_wali">Penghasilan Wali</label>
                                        <input type="text" class="form-control" id="penghasilan_wali" value="{{ auth('siswa')->user()->penghasilan_wali }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nik_wali">NIK Wali</label>
                                        <input type="text" class="form-control" id="nik_wali" value="{{ auth('siswa')->user()->nik_wali }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="layak_pip">Layak PIP</label>
                                        <input type="text" class="form-control" id="layak_pip" value="{{ auth('siswa')->user()->layak_pip }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="alasan_layak_pip">Alasan Layak PIP</label>
                                        <input type="text" class="form-control" id="alasan_layak_pip" value="{{ auth('siswa')->user()->alasan_layak_pip }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="kebutuhan_khusus">Kebutuhan Khusus</label>
                                        <input type="text" class="form-control" id="kebutuhan_khusus" value="{{ auth('siswa')->user()->kebutuhan_khusus }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="sekolah_asal">Sekolah Asal</label>
                                        <input type="text" class="form-control" id="sekolah_asal" value="{{ auth('siswa')->user()->sekolah_asal }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="anak_ke-berapa">Anak Ke-berapa</label>
                                        <input type="text" class="form-control" id="anak_ke-berapa" value="{{ auth('siswa')->user()->anak_ke_berapa }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="lintang">Lintang</label>
                                        <input type="text" class="form-control" id="lintang" value="{{ auth('siswa')->user()->lintang }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="bujur">Bujur</label>
                                        <input type="text" class="form-control" id="bujur" value="{{ auth('siswa')->user()->bujur }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_kk">No. KK</label>
                                        <input type="text" class="form-control" id="no_kk" value="{{ auth('siswa')->user()->no_kk }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="berat_badan">Berat Badan</label>
                                        <input type="text" class="form-control" id="berat_badan" value="{{ auth('siswa')->user()->berat_badan }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="tinggi_badan">Tinggi Badan</label>
                                        <input type="text" class="form-control" id="tinggi_badan" value="{{ auth('siswa')->user()->tinggi_badan }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="lingkar_kepala">Lingkar Kepala</label>
                                        <input type="text" class="form-control" id="lingkar_kepala" value="{{ auth('siswa')->user()->lingkar_kepala }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="jml_saudara">Jumlah Saudara</label>
                                        <input type="text" class="form-control" id="jml_saudara" value="{{ auth('siswa')->user()->jml_saudara }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="jarak_rumah">Jarak dari Rumah ke Sekolah</label>
                                        <input type="text" class="form-control" id="jarak_rumah" value="{{ auth('siswa')->user()->jarak_rumah }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
