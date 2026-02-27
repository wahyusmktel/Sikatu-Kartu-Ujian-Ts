@extends('admin.layouts.app')

@section('page-title', 'Edit Data Siswa')

@section('breadcrumbs')
    <li class="nav-home">
        <a href="/admin/dashboard">
            <i class="flaticon-home"></i>
        </a>
    </li>
    <li class="separator">
        <i class="flaticon-right-arrow"></i>
    </li>
    <li class="nav-item">
        <a href="/admin/dashboard">Dashboard</a>
    </li>
    <li class="separator">
        <i class="flaticon-right-arrow"></i>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.siswa') }}">Data Siswa</a>
    </li>
    <li class="separator">
        <i class="flaticon-right-arrow"></i>
    </li>
    <li class="nav-item">
        <a href="#">Edit Siswa</a>
    </li>
@endsection

@section('content')
    <div class="page-category">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Edit Data Siswa: <strong>{{ $siswa->nama }}</strong></div>
                    </div>
                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- ===== DATA PRIBADI ===== --}}
                            <h5 class="mt-2 mb-3"><i class="fa fa-user"></i> Data Pribadi</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                                            value="{{ old('nama', $siswa->nama) }}" required>
                                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="nipd">NIPD</label>
                                        <input type="text" name="nipd" id="nipd" class="form-control"
                                            value="{{ old('nipd', $siswa->nipd) }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="nisn">NISN</label>
                                        <input type="text" name="nisn" id="nisn" class="form-control"
                                            value="{{ old('nisn', $siswa->nisn) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="jk">Jenis Kelamin</label>
                                        <select name="jk" id="jk" class="form-control">
                                            <option value="">-- Pilih --</option>
                                            <option value="Laki-laki" {{ old('jk', $siswa->jk) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jk', $siswa->jk) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tempat_lahir">Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                                            value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tanggal_lahir">Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                                            value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nik">NIK</label>
                                        <input type="text" name="nik" id="nik" class="form-control"
                                            value="{{ old('nik', $siswa->nik) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="agama">Agama</label>
                                        <select name="agama" id="agama" class="form-control">
                                            <option value="">-- Pilih --</option>
                                            @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $ag)
                                                <option value="{{ $ag }}" {{ old('agama', $siswa->agama) == $ag ? 'selected' : '' }}>{{ $ag }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rombel_id">Rombel</label>
                                        <select name="rombel_id" id="rombel_id" class="form-control">
                                            <option value="">-- Pilih Rombel --</option>
                                            @foreach($rombels as $rombel)
                                                <option value="{{ $rombel->id }}" {{ old('rombel_id', $siswa->rombel_id) == $rombel->id ? 'selected' : '' }}>
                                                    {{ $rombel->nama_rombel }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- ===== KONTAK ===== --}}
                            <hr>
                            <h5 class="mt-3 mb-3"><i class="fa fa-phone"></i> Kontak</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="e-mail" id="email" class="form-control @error('e-mail') is-invalid @enderror"
                                            value="{{ old('e-mail', $siswa['e-mail']) }}">
                                        @error('e-mail') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="hp">No. HP</label>
                                        <input type="text" name="hp" id="hp" class="form-control"
                                            value="{{ old('hp', $siswa->hp) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="telepon">Telepon</label>
                                        <input type="text" name="telepon" id="telepon" class="form-control"
                                            value="{{ old('telepon', $siswa->telepon) }}">
                                    </div>
                                </div>
                            </div>

                            {{-- ===== ALAMAT ===== --}}
                            <hr>
                            <h5 class="mt-3 mb-3"><i class="fa fa-map-marker"></i> Alamat</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ old('alamat', $siswa->alamat) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rt">RT</label>
                                        <input type="text" name="rt" id="rt" class="form-control"
                                            value="{{ old('rt', $siswa->rt) }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rw">RW</label>
                                        <input type="text" name="rw" id="rw" class="form-control"
                                            value="{{ old('rw', $siswa->rw) }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="kelurahan">Kelurahan/Desa</label>
                                        <input type="text" name="kelurahan" id="kelurahan" class="form-control"
                                            value="{{ old('kelurahan', $siswa->kelurahan) }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="kecamatan">Kecamatan</label>
                                        <input type="text" name="kecamatan" id="kecamatan" class="form-control"
                                            value="{{ old('kecamatan', $siswa->kecamatan) }}">
                                    </div>
                                </div>
                            </div>

                            {{-- ===== TOMBOL AKSI ===== --}}
                            <hr>
                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('admin.siswa') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            @if(session('success'))
                $.notify({
                    message: '{{ session('success') }}',
                    title: 'Sukses!',
                    icon: 'fa fa-check'
                }, {
                    type: 'success',
                    placement: { from: "top", align: "right" },
                    time: 1000,
                    delay: 5000,
                });
            @endif

            @if(session('error'))
                $.notify({
                    message: '{{ session('error') }}',
                    title: 'Error!',
                    icon: 'fa fa-exclamation-triangle'
                }, {
                    type: 'danger',
                    placement: { from: "top", align: "right" },
                    time: 1000,
                    delay: 5000,
                });
            @endif
        });
    </script>

@endsection
