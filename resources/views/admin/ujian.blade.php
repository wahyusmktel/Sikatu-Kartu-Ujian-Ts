@extends('admin.layouts.app')

@section('page-title', 'Data Ujian')

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
        <a href="/admin/ujian">Data Ujian</a>
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
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahUjianModal">
                            <i class="fa fa-plus"></i> Tambah Data
                        </button>
                        </div>
                        <!-- Modal Tambah Data Ujian -->
                        <div class="modal fade" id="tambahUjianModal" tabindex="-1" role="dialog" aria-labelledby="tambahUjianModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="tambahUjianModalLabel">Tambah Data Ujian</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.ujian.store') }}" method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="nama_ujian">Nama Ujian</label>
                                                <input type="text" class="form-control" id="nama_ujian" name="nama_ujian" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="kode_ujian">Kode Ujian</label>
                                                <input type="text" class="form-control" id="kode_ujian" name="kode_ujian" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="tahun_pelajaran">Tahun Pelajaran</label>
                                                <input type="text" class="form-control" id="tahun_pelajaran" name="tahun_pelajaran" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="semester">Semester</label>
                                                <select class="form-control" id="semester" name="semester" required>
                                                    <option value="1">Semester 1</option>
                                                    <option value="2">Semester 2</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="link_ujian">Link Ujian</label>
                                                <input type="text" class="form-control" id="link_ujian" name="link_ujian" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="tgl_mulai">Tanggal Mulai</label>
                                                <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="tgl_akhir">Tanggal Akhir</label>
                                                <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
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
                                    <th>Nama Ujian</th>
                                    <th>Tahun Pelajaran</th>
                                    <th>Semester</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = ($ujian->currentPage() - 1) * $ujian->perPage() + 1; @endphp
                                @forelse($ujian as $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data->nama_ujian }}</td>
                                    <td>{{ $data->tahun_pelajaran }}</td>
                                    <td>{{ $data->semester }}</td>
                                    <td>
                                        @if($data->status)
                                            <input type="checkbox" checked data-toggle="toggle" data-onstyle="primary" data-offstyle="danger" data-on="ON" data-off="OFF" class="status-toggle" data-id="{{ $data->id }}">
                                        @else
                                            <input type="checkbox" data-toggle="toggle" data-onstyle="primary" data-offstyle="danger" data-on="ON" data-off="OFF" class="status-toggle" data-id="{{ $data->id }}">
                                        @endif
                                    </td>                                    
                                    <td>
                                        <!-- Tombol Detail -->
                                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal-{{ $data->id }}"><i class="fa fa-eye"></i> Detail</button>

                                        @if($data->status)
                                            {{-- Ujian AKTIF: tombol disabled + tooltip --}}
                                            <button class="btn btn-warning btn-sm" disabled title="Ujian sedang aktif, tidak dapat diedit">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm" disabled title="Ujian sedang aktif, tidak dapat dihapus">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        @else
                                            {{-- Ujian TIDAK AKTIF: tombol aktif --}}
                                            <button type="button" class="btn btn-warning btn-sm btn-edit-ujian"
                                                data-id="{{ $data->id }}"
                                                data-url="{{ route('admin.ujian.edit', $data->id) }}">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm btn-hapus-ujian"
                                                data-id="{{ $data->id }}"
                                                data-nama="{{ $data->nama_ujian }}"
                                                data-url="{{ route('admin.ujian.destroy', $data->id) }}">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        @endif

                                        <!-- Modal Detail Ujian -->
                                        <div class="modal fade" id="detailModal-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel-{{ $data->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="detailModalLabel-{{ $data->id }}">Detail Ujian: {{ $data->nama_ujian }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Nama Ujian: {{ $data->nama_ujian }}<br>
                                                        Tahun Pelajaran: {{ $data->tahun_pelajaran }}<br>
                                                        Semester: {{ $data->semester }}<br>
                                                        Link Ujian: {{ $data->link_ujian }}<br>
                                                        Tanggal Mulai: {{ $data->tgl_mulai }}<br>
                                                        Tanggal Akhir: {{ $data->tgl_akhir }}<br>
                                                        Status: {{ $data->status ? 'Aktif' : 'Tidak Aktif' }}<br>
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
                                    <td colspan="9">Data ujian tidak ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Ujian (global) -->
    <div class="modal fade" id="editUjianModal" tabindex="-1" role="dialog" aria-labelledby="editUjianModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUjianModalLabel"><i class="fa fa-edit"></i> Edit Data Ujian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEditUjian" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body" id="editUjianBody">
                        <div id="editLoadingSpinner" class="text-center py-3">
                            <i class="fa fa-spinner fa-spin fa-2x"></i><br>Memuat data...
                        </div>
                        <div id="editFormContent" style="display:none;">
                            <div class="form-group">
                                <label>Nama Ujian</label>
                                <input type="text" name="nama_ujian" id="edit_nama_ujian" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Kode Ujian</label>
                                <input type="text" name="kode_ujian" id="edit_kode_ujian" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Tahun Pelajaran</label>
                                <input type="text" name="tahun_pelajaran" id="edit_tahun_pelajaran" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Semester</label>
                                <select name="semester" id="edit_semester" class="form-control" required>
                                    <option value="1">Semester 1</option>
                                    <option value="2">Semester 2</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Link Ujian</label>
                                <input type="url" name="link_ujian" id="edit_link_ujian" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Mulai</label>
                                <input type="date" name="tgl_mulai" id="edit_tgl_mulai" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Akhir</label>
                                <input type="date" name="tgl_akhir" id="edit_tgl_akhir" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpanEdit"><i class="fa fa-save"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Form tersembunyi untuk DELETE ujian -->
    <form id="formHapusUjian" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        $(document).ready(function() {

            // ===== TOMBOL EDIT UJIAN =====
            $(document).on('click', '.btn-edit-ujian', function() {
                var url = $(this).data('url');
                var id  = $(this).data('id');

                // Reset modal
                $('#editLoadingSpinner').show();
                $('#editFormContent').hide();
                $('#formEditUjian').attr('action', '/admin/ujian/' + id);
                $('#editUjianModal').modal('show');

                // AJAX ambil data ujian
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        $('#editLoadingSpinner').hide();
                        $('#editFormContent').show();

                        $('#edit_nama_ujian').val(data.nama_ujian);
                        $('#edit_kode_ujian').val(data.kode_ujian);
                        $('#edit_tahun_pelajaran').val(data.tahun_pelajaran);
                        $('#edit_semester').val(data.semester);
                        $('#edit_link_ujian').val(data.link_ujian);
                        $('#edit_tgl_mulai').val(data.tgl_mulai);
                        $('#edit_tgl_akhir').val(data.tgl_akhir);
                    },
                    error: function(xhr) {
                        $('#editUjianModal').modal('hide');
                        var msg = (xhr.responseJSON && xhr.responseJSON.error)
                            ? xhr.responseJSON.error
                            : 'Gagal memuat data ujian.';
                        $.notify({ message: msg, title: 'Error!', icon: 'fa fa-exclamation-triangle' }, {
                            type: 'danger',
                            placement: { from: "top", align: "right" },
                            time: 1000, delay: 5000,
                        });
                    }
                });
            });

            // ===== TOMBOL HAPUS UJIAN =====
            $(document).on('click', '.btn-hapus-ujian', function() {
                var url  = $(this).data('url');
                var nama = $(this).data('nama');

                if (confirm('Apakah Anda yakin ingin menghapus ujian "' + nama + '"? Tindakan ini tidak dapat dibatalkan.')) {
                    $('#formHapusUjian').attr('action', url);
                    $('#formHapusUjian').submit();
                }
            });

            // ===== NOTIFIKASI SUKSES / ERROR =====
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


    <!-- Script Aktif -->
    <script>
        $(document).ready(function() {
            $('.status-toggle').change(function(e) {
                let ujianId = $(this).data('id');
                let status = $(this).prop('checked');
                let currentElement = $(this);  // Simpan referensi elemen saat ini

                // Konfirmasi SweetAlert
                swal({
                    title: status ? "Konfirmasi Aktivasi" : "Konfirmasi Non-Aktivasi",
                    text: status ? "Apakah Anda ingin mengaktifkan ujian?" : "Apakah Anda yakin akan menonaktifkan ujian?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willChange) => {
                    if (willChange) {
                        $.ajax({
                            url: '/admin/ujian/update-status/' + ujianId,
                            method: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "status": status
                            },
                            success: function(response) {
                                if (response.success) {

                                    // Pilih pesan berdasarkan status
                                    let message = status ? 'Ujian berhasil diaktifkan.' : 'Ujian berhasil dinonaktifkan.';

                                    $.notify({
                                        message: message,
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
                                    setTimeout(function() {
                                        location.reload();
                                    }, 2000);
                                } else {
                                    $.notify({
                                        message: 'Terjadi kesalahan saat mengupdate status.',
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
                                    setTimeout(function() {
                                        location.reload();
                                    }, 2000);
                                }
                            }
                        });
                    } else {
                        // Jika pengguna membatalkan, kembalikan toggle ke posisi awal
                        currentElement.prop('checked', !status);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                });
            });
        });
    </script>
    
@endsection
