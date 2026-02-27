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
                        <!-- Tombol untuk memicu modal -->
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#importDataModal">
                            <i class="fa fa-file-excel"></i> Import Data
                        </button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="importDataModal" tabindex="-1" role="dialog" aria-labelledby="importDataModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="importDataModalLabel">Import Data Siswa</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Formulir untuk meng-upload file Excel -->
                                        <form action="{{ route('admin.siswa.import') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="file">Pilih File Excel:</label>
                                                <input type="file" name="file" id="file" class="form-control">
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-upload"></i> Upload dan Import</button>
                                    </div>
                                    </form>
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

    <script>
        $(document).ready(function() {

            // Klik tombol hapus siswa → AJAX cek relasi dulu
            $(document).on('click', '.btn-hapus-siswa', function() {
                var id        = $(this).data('id');
                var nama      = $(this).data('nama');
                var urlRelasi = $(this).data('url-relasi');
                var urlHapus  = $(this).data('url-hapus');

                // Reset modal
                $('#hapusLoading').show();
                $('#hapusContent').hide();
                $('#hapusRelasiWrapper').hide();
                $('#hapusRelasiList').empty();
                $('#btnKonfirmasiHapus').data('url-hapus', urlHapus);

                $('#modalHapusSiswa').modal('show');

                // AJAX cek relasi
                $.ajax({
                    url: urlRelasi,
                    type: 'GET',
                    success: function(data) {
                        $('#hapusLoading').hide();
                        $('#hapusContent').show();

                        if (data.ada_relasi) {
                            $('#hapusPesanUtama').html(
                                '<div class="alert alert-danger"><strong>Peringatan!</strong> Siswa <strong>' + nama + '</strong> memiliki data relasi yang terhubung. ' +
                                'Jika Anda melanjutkan, <u>seluruh data di bawah ini akan dihapus secara permanen</u> dan tidak dapat dikembalikan.</div>'
                            );
                            $('#hapusRelasiWrapper').show();
                            var list = '';
                            $.each(data.relasi, function(i, rel) {
                                list += '<li class="list-group-item d-flex justify-content-between align-items-center">';
                                list += '<span><i class="fa fa-link text-danger mr-2"></i><strong>' + rel.label + '</strong>';
                                if (rel.detail && rel.detail.length > 0) {
                                    list += '<br><small class="text-muted">' + rel.detail.join(', ') + '</small>';
                                }
                                list += '</span>';
                                list += '<span class="badge badge-danger badge-pill">' + rel.jumlah + ' data</span>';
                                list += '</li>';
                            });
                            $('#hapusRelasiList').html(list);
                            $('#btnKonfirmasiHapus').html('<i class="fa fa-trash"></i> Ya, Hapus Semua Data');
                        } else {
                            $('#hapusPesanUtama').html(
                                'Apakah Anda yakin ingin menghapus data siswa <strong>' + nama + '</strong>? Tindakan ini tidak dapat dibatalkan.'
                            );
                            $('#btnKonfirmasiHapus').html('<i class="fa fa-trash"></i> Ya, Hapus');
                        }
                    },
                    error: function() {
                        $('#hapusLoading').hide();
                        $('#hapusContent').show();
                        $('#hapusPesanUtama').html(
                            '<div class="alert alert-danger">Gagal memuat data relasi. Apakah Anda tetap ingin menghapus siswa <strong>' + nama + '</strong>?</div>'
                        );
                        $('#btnKonfirmasiHapus').html('<i class="fa fa-trash"></i> Ya, Hapus');
                    }
                });
            });

            // Klik tombol konfirmasi hapus → submit form DELETE
            $('#btnKonfirmasiHapus').on('click', function() {
                var urlHapus = $(this).data('url-hapus');
                var form = $('#formHapusSiswa');
                form.attr('action', urlHapus);
                $('#modalHapusSiswa').modal('hide');
                form.submit();
            });

            // Notifikasi sukses / error
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
