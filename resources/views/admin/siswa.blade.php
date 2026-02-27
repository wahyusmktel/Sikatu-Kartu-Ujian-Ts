@extends('admin.layouts.app')

@section('page-title', 'Data Siswa')

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
        <a href="/admin/siswa/">Data Siswa</a>
    </li>
@endsection

@section('content')
    <div class="page-category">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="pull-left">
                        <!-- Tombol Import -->
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#importDataModal">
                            <i class="fa fa-file-excel"></i> Import Data
                        </button>
                        </div>
                        <!-- Modal Import (AJAX + Progress) -->
                        <div class="modal fade" id="importDataModal" tabindex="-1" role="dialog" aria-labelledby="importDataModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="importDataModalLabel"><i class="fa fa-file-excel text-success"></i> Import Data Siswa</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnCloseImportModal">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        {{-- STEP 1: Pilih File --}}
                                        <div id="importStep1">
                                            <p class="text-muted mb-3"><i class="fa fa-info-circle"></i> Pilih file Excel (.xlsx / .xls) yang berisi data siswa.</p>
                                            <form id="formImportSiswa" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="fileImport">Pilih File Excel:</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="fileImport" name="file" accept=".xlsx,.xls" required>
                                                        <label class="custom-file-label" for="fileImport">Pilih file...</label>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        {{-- STEP 2: Progress Animasi --}}
                                        <div id="importStep2" style="display:none;">
                                            <div class="text-center mb-3">
                                                <i class="fa fa-spinner fa-spin fa-2x text-primary"></i>
                                                <p class="mt-2 mb-1 font-weight-bold" id="importStatusText">Memproses data...</p>
                                                <small class="text-muted" id="importSubText">Mohon tunggu, jangan tutup halaman ini.</small>
                                            </div>
                                            <div class="progress" style="height: 28px; border-radius: 14px; overflow: hidden;">
                                                <div id="importProgressBar"
                                                    class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                                    role="progressbar"
                                                    style="width: 0%; font-size: 14px; font-weight: bold; transition: width 0.4s ease;"
                                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                    0%
                                                </div>
                                            </div>
                                            <p class="text-center mt-2 text-muted" id="importProgressNote"></p>
                                        </div>

                                        {{-- STEP 3: Hasil Error --}}
                                        <div id="importStep3Error" style="display:none;">
                                            <div class="alert alert-danger">
                                                <i class="fa fa-times-circle"></i> <strong>Import Gagal!</strong>
                                                <p id="importErrorMsg" class="mb-0 mt-1"></p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer" id="importModalFooter">
                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                                        <button type="button" class="btn btn-success btn-sm" id="btnStartImport">
                                            <i class="fa fa-upload"></i> Upload &amp; Import
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pull-right">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="collapse" id="search-nav">
                                <form class="navbar-form nav-search mr-md-3" action="{{ route('admin.siswa') }}" method="GET">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="submit" class="btn btn-search pr-1">
                                                <i class="fa fa-search search-icon"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="cari" placeholder="Search ..." class="form-control">
                                    </div>
                                </form>
                            </div>
                        </div>
                        </div>                
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIPD</th>
                                    <th>NISN</th>
                                    <th>Email</th>
                                    <th>NIK</th>
                                    <th>Aksi</th>
                                    <!-- Anda dapat menambahkan kolom lain sesuai kebutuhan -->
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = ($siswa->currentPage() - 1) * $siswa->perPage() + 1; @endphp
                                @forelse($siswa as $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data->nama }}</td>
                                    <td>{{ $data->nipd }}</td>
                                    <td>{{ $data->nisn }}</td>
                                    <td>{{ $data['e-mail'] }}</td> <!-- Pastikan nama kolom di database e_mail bukan e-mail -->
                                    <td>{{ $data->nik }}</td>
                                    <td>
                                        <!-- Tombol Detail -->
                                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal-{{ $data->id }}"><i class="fa fa-eye"></i> Detail</button>
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('admin.siswa.edit', $data->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <!-- Tombol Hapus (memicu AJAX cek relasi) -->
                                        <button type="button" class="btn btn-danger btn-sm btn-hapus-siswa"
                                            data-id="{{ $data->id }}"
                                            data-nama="{{ $data->nama }}"
                                            data-url-relasi="{{ route('admin.siswa.relasi', $data->id) }}"
                                            data-url-hapus="{{ route('admin.siswa.destroy', $data->id) }}">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                        <!-- Modal Detail Siswa -->
                                        <div class="modal fade" id="detailModal-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel-{{ $data->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="detailModalLabel-{{ $data->id }}">Detail Siswa: {{ $data->nama }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Nama: {{ $data->nama }}<br>
                                                        NIPD: {{ $data->nipd }}<br>
                                                        NISN: {{ $data->nisn }}<br>
                                                        Email: {{ $data['e-mail'] }}<br>
                                                        NIK: {{ $data->nik }}<br>
                                                        <!-- Tambahkan detail lainnya sesuai kebutuhan -->
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7">Data siswa tidak ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- Paginasi -->
                        {{ $siswa->appends(['cari' => $cari])->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Siswa (global, 1 modal dipakai ulang) -->
    <div class="modal fade" id="modalHapusSiswa" tabindex="-1" role="dialog" aria-labelledby="modalHapusSiswaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalHapusSiswaLabel"><i class="fa fa-exclamation-triangle"></i> Konfirmasi Hapus Data Siswa</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalHapusBody">
                    <div id="hapusLoading" class="text-center py-3">
                        <i class="fa fa-spinner fa-spin fa-2x"></i><br>Memuat data relasi...
                    </div>
                    <div id="hapusContent" style="display:none;">
                        <p id="hapusPesanUtama" class="mb-3"></p>
                        <div id="hapusRelasiWrapper" style="display:none;">
                            <div class="alert alert-warning">
                                <strong><i class="fa fa-exclamation-circle"></i> Data berikut akan ikut terhapus secara permanen:</strong>
                            </div>
                            <ul id="hapusRelasiList" class="list-group mb-3"></ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                    <button type="button" class="btn btn-danger" id="btnKonfirmasiHapus"><i class="fa fa-trash"></i> Ya, Hapus Semua</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Form tersembunyi untuk submit DELETE -->
    <form id="formHapusSiswa" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    <!-- Modal Preview Hasil Import -->
    <div class="modal fade" id="importPreviewModal" tabindex="-1" role="dialog" aria-labelledby="importPreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="importPreviewModalLabel">
                        <i class="fa fa-check-circle"></i> Import Berhasil!
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="alert alert-success d-flex align-items-center" style="border-radius:12px;">
                                <i class="fa fa-users fa-2x mr-3"></i>
                                <div>
                                    <strong id="importSuccessMsg"></strong><br>
                                    <small class="text-muted">Berikut adalah 10 data terakhir yang berhasil diimport:</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-striped" id="importPreviewTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>NIPD</th>
                                    <th>NISN</th>
                                    <th>JK</th>
                                    <th>Rombel</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody id="importPreviewBody"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="location.reload()">
                        <i class="fa fa-refresh"></i> Refresh Halaman
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {

            // ===== Update label custom file input =====
            $(document).on('change', '#fileImport', function () {
                var fileName = $(this).val().split('\\').pop();
                $(this).siblings('.custom-file-label').text(fileName || 'Pilih file...');
            });

            // ===== Reset modal import saat dibuka =====
            $('#importDataModal').on('show.bs.modal', function () {
                $('#importStep1').show();
                $('#importStep2').hide();
                $('#importStep3Error').hide();
                $('#importModalFooter').show();
                $('#btnStartImport').show().prop('disabled', false);
                $('#formImportSiswa')[0].reset();
                $('.custom-file-label').text('Pilih file...');
                setProgress(0, '');
            });

            // ===== Animasi progress bar =====
            var progressInterval = null;
            function setProgress(pct, note) {
                $('#importProgressBar')
                    .css('width', pct + '%')
                    .attr('aria-valuenow', pct)
                    .text(pct + '%');
                if (note) $('#importProgressNote').text(note);
            }

            function startFakeProgress() {
                var pct = 5;
                setProgress(pct, 'Membaca file Excel...');
                var steps = [
                    { target: 20, note: 'Membaca dan memvalidasi data...', delay: 600 },
                    { target: 45, note: 'Menyimpan data siswa ke database...', delay: 800 },
                    { target: 65, note: 'Memproses relasi rombel...', delay: 700 },
                    { target: 82, note: 'Menyimpan data tersisa...', delay: 900 },
                    { target: 92, note: 'Hampir selesai...', delay: 500 },
                ];
                var i = 0;
                function runStep() {
                    if (i >= steps.length) return;
                    var step = steps[i++];
                    setTimeout(function () {
                        setProgress(step.target, step.note);
                        runStep();
                    }, step.delay);
                }
                runStep();
            }

            // ===== Klik tombol Upload & Import =====
            $('#btnStartImport').on('click', function () {
                var fileInput = $('#fileImport')[0];
                if (!fileInput.files.length) {
                    alert('Silakan pilih file Excel terlebih dahulu!');
                    return;
                }

                var formData = new FormData($('#formImportSiswa')[0]);

                // Tampilkan step progress
                $('#importStep1').hide();
                $('#importStep3Error').hide();
                $('#importStep2').show();
                $('#btnStartImport').hide();
                $('#btnCloseImportModal').hide();
                $('[data-dismiss="modal"]').first().hide();
                $('#importModalFooter').hide();

                $('#importStatusText').text('Mengunggah file...');
                $('#importSubText').text('Mohon tunggu, jangan tutup halaman ini.');
                startFakeProgress();

                $.ajax({
                    url: '{{ route("admin.siswa.import") }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        // Progress 100%
                        setProgress(100, 'Import selesai!');
                        $('#importProgressBar')
                            .removeClass('bg-primary')
                            .addClass('bg-success')
                            .removeClass('progress-bar-animated');
                        $('#importStatusText').text('✅ Import Berhasil!');
                        $('#importSubText').text('');

                        setTimeout(function () {
                            // Tutup modal import
                            $('#importDataModal').modal('hide');

                            // Isi preview table
                            var tbody = $('#importPreviewBody').empty();
                            if (res.preview && res.preview.length > 0) {
                                $.each(res.preview, function (i, s) {
                                    tbody.append(
                                        '<tr>' +
                                        '<td>' + (i + 1) + '</td>' +
                                        '<td>' + (s.nama || '-') + '</td>' +
                                        '<td>' + (s.nipd || '-') + '</td>' +
                                        '<td>' + (s.nisn || '-') + '</td>' +
                                        '<td>' + (s.jk || '-') + '</td>' +
                                        '<td>' + (s.rombel_saat_ini || '-') + '</td>' +
                                        '<td>' + (s.email || '-') + '</td>' +
                                        '</tr>'
                                    );
                                });
                            } else {
                                tbody.append('<tr><td colspan="7" class="text-center">Tidak ada data preview.</td></tr>');
                            }

                            $('#importSuccessMsg').text(res.message || 'Import berhasil!');
                            $('#importPreviewModal').modal('show');
                        }, 800);
                    },
                    error: function (xhr) {
                        setProgress(100, '');
                        $('#importProgressBar').removeClass('bg-primary').addClass('bg-danger').removeClass('progress-bar-animated');
                        $('#importStep2').hide();
                        $('#importStep3Error').show();
                        $('#importModalFooter').show();
                        $('#btnStartImport').show().prop('disabled', false);
                        $('#btnCloseImportModal').show();

                        var errMsg = 'Terjadi kesalahan saat mengimpor data.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errMsg = xhr.responseJSON.message;
                        }
                        $('#importErrorMsg').text(errMsg);
                    }
                });
            });

            // ===== Tombol hapus siswa (AJAX cek relasi) =====
            $(document).on('click', '.btn-hapus-siswa', function () {
                var id        = $(this).data('id');
                var nama      = $(this).data('nama');
                var urlRelasi = $(this).data('url-relasi');
                var urlHapus  = $(this).data('url-hapus');

                $('#hapusLoading').show();
                $('#hapusContent').hide();
                $('#hapusRelasiWrapper').hide();
                $('#hapusRelasiList').empty();
                $('#btnKonfirmasiHapus').data('url-hapus', urlHapus);
                $('#modalHapusSiswa').modal('show');

                $.ajax({
                    url: urlRelasi,
                    type: 'GET',
                    success: function (data) {
                        $('#hapusLoading').hide();
                        $('#hapusContent').show();
                        if (data.ada_relasi) {
                            $('#hapusPesanUtama').html(
                                '<div class="alert alert-danger"><strong>Peringatan!</strong> Siswa <strong>' + nama + '</strong> memiliki data relasi. Seluruh data berikut akan dihapus permanen.</div>'
                            );
                            $('#hapusRelasiWrapper').show();
                            var list = '';
                            $.each(data.relasi, function (i, rel) {
                                list += '<li class="list-group-item d-flex justify-content-between align-items-center">';
                                list += '<span><i class="fa fa-link text-danger mr-2"></i><strong>' + rel.label + '</strong>';
                                if (rel.detail && rel.detail.length > 0) {
                                    list += '<br><small class="text-muted">' + rel.detail.join(', ') + '</small>';
                                }
                                list += '</span><span class="badge badge-danger badge-pill">' + rel.jumlah + ' data</span></li>';
                            });
                            $('#hapusRelasiList').html(list);
                            $('#btnKonfirmasiHapus').html('<i class="fa fa-trash"></i> Ya, Hapus Semua Data');
                        } else {
                            $('#hapusPesanUtama').html('Apakah Anda yakin ingin menghapus data siswa <strong>' + nama + '</strong>? Tindakan ini tidak dapat dibatalkan.');
                            $('#btnKonfirmasiHapus').html('<i class="fa fa-trash"></i> Ya, Hapus');
                        }
                    },
                    error: function () {
                        $('#hapusLoading').hide();
                        $('#hapusContent').show();
                        $('#hapusPesanUtama').html('<div class="alert alert-danger">Gagal memuat data relasi.</div>');
                        $('#btnKonfirmasiHapus').html('<i class="fa fa-trash"></i> Ya, Hapus');
                    }
                });
            });

            $('#btnKonfirmasiHapus').on('click', function () {
                var urlHapus = $(this).data('url-hapus');
                $('#formHapusSiswa').attr('action', urlHapus);
                $('#modalHapusSiswa').modal('hide');
                $('#formHapusSiswa').submit();
            });

            // ===== Notifikasi sukses / error dari session =====
            @if(session('success'))
                $.notify({
                    message: '{{ session('success') }}',
                    title: 'Sukses!',
                    icon: 'fa fa-check'
                }, {
                    type: 'success',
                    placement: { from: "top", align: "right" },
                    time: 1000, delay: 5000,
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
                    time: 1000, delay: 5000,
                });
            @endif
        });
    </script>

@endsection
