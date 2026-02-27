@extends('admin.layouts.app')

@section('page-title', 'Settings')

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
        <a href="/admin/settings/">Settings</a>
    </li>
@endsection

@section('content')
    <div class="page-category">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                                    
                    </div>
                    <div class="card-body">
                        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="nama_sekolah">Nama Sekolah:</label>
                                <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" value="{{ $settings->nama_sekolah }}" required>
                            </div>

                            <div class="form-group">
                                <label for="nama_kepsek">Nama Kepsek:</label>
                                <input type="text" class="form-control" id="nama_kepsek" name="nama_kepsek" value="{{ $settings->nama_kepsek }}" required>
                            </div>
                    
                            <div class="form-group">
                                <label for="no_hp_sekolah">No HP Sekolah:</label>
                                <input type="text" class="form-control" id="no_hp_sekolah" name="no_hp_sekolah" value="{{ $settings->no_hp_sekolah }}" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_hp_cs">WA Customer Service:</label>
                                        <input type="text" class="form-control" id="no_hp_cs" name="no_hp_cs" value="{{ $settings->no_hp_cs }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_hp_admin">WA Pelayanan Administrasi:</label>
                                        <input type="text" class="form-control" id="no_hp_admin" name="no_hp_admin" value="{{ $settings->no_hp_admin }}" required>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="form-group">
                                <label for="email_sekolah">Email Sekolah:</label>
                                <input type="email" class="form-control" id="email_sekolah" name="email_sekolah" value="{{ $settings->email_sekolah }}" required>
                            </div>
                    
                            <div class="form-group">
                                <label for="npsn">NPSN:</label>
                                <input type="text" class="form-control" id="npsn" name="npsn" value="{{ $settings->npsn }}" required>
                            </div>
                    
                            <div class="form-group">
                                <label for="alamat_sekolah">Alamat Sekolah:</label>
                                <textarea class="form-control" id="alamat_sekolah" name="alamat_sekolah" required>{{ $settings->alamat_sekolah }}</textarea>
                            </div>
                    
                            <div class="form-group">
                                <label for="logo_sekolah">Logo Sekolah:</label><br>
                                @if($settings->logo_sekolah)
                                    <img src="{{ asset('storage/' . $settings->logo_sekolah) }}" width="100" alt="Logo Sekolah" class="mb-2"><br>
                                @endif
                                <input type="file" id="logo_sekolah" name="logo_sekolah">
                                <small class="text-muted d-block">Biarkan kosong jika tidak ingin mengganti logo</small>
                            </div>
                    
                            <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Cek jika ada pesan sukses dari session
            @if(session('success'))
                $.notify({
                    // Isi konten notifikasi
                    message: '{{ session('success') }}',
                    title: 'Sukses!',
                    icon: 'fa fa-check'
                }, {
                    type: 'success',
                    placement: {
                        from: "top",
                        align: "right"
                    },
                    time: 1000,
                    delay: 5000,
                });
            @endif

            // Cek jika ada pesan error dari session
            @if(session('error'))
                $.notify({
                    // Isi konten notifikasi
                    message: '{{ session('error') }}',
                    title: 'Error!',
                    icon: 'fa fa-exclamation-triangle'
                }, {
                    type: 'danger',
                    placement: {
                        from: "top",
                        align: "right"
                    },
                    time: 1000,
                    delay: 5000,
                });
            @endif
        });

    </script>
    
@endsection
