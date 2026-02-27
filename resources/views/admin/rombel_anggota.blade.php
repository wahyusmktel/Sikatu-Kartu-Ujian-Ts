@extends('admin.layouts.app')

@section('page-title', 'Anggota Rombel — ' . $rombel->nama_rombel)

@section('breadcrumbs')
    <li class="nav-home">
        <a href="/admin/dashboard"><i class="flaticon-home"></i></a>
    </li>
    <li class="separator"><i class="flaticon-right-arrow"></i></li>
    <li class="nav-item"><a href="{{ route('admin.rombel') }}">Rombel</a></li>
    <li class="separator"><i class="flaticon-right-arrow"></i></li>
    <li class="nav-item">{{ $rombel->nama_rombel }}</li>
@endsection

@section('content')
<div class="page-category">

    {{-- Info Rombel --}}
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card border-left-primary" style="border-left: 4px solid #007bff;">
                <div class="card-body py-2 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small">Rombel</span>
                        <h5 class="mb-0 font-weight-bold">{{ $rombel->nama_rombel }}</h5>
                        <small class="text-muted">
                            Tingkat: <strong>{{ $rombel->tingkat_rombel }}</strong> &nbsp;|&nbsp;
                            Wali Kelas: <strong>{{ $rombel->wali_kelas ?? '-' }}</strong> &nbsp;|&nbsp;
                            Total Anggota: <span class="badge badge-primary" id="totalAnggota">{{ $anggota->total() }}</span>
                        </small>
                    </div>
                    <a href="{{ route('admin.rombel') }}" class="btn btn-secondary btn-sm">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        {{-- ============================================ --}}
        {{-- KOLOM KIRI: Anggota Rombel Saat Ini         --}}
        {{-- ============================================ --}}
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-success text-white d-flex align-items-center justify-content-between">
                    <span><i class="fa fa-users"></i> <strong>Anggota Rombel</strong></span>
                    <span class="badge badge-light" id="badgeAnggota">{{ $anggota->total() }} siswa</span>
                </div>
                <div class="card-body p-2">

                    {{-- Pencarian anggota --}}
                    <form method="GET" action="{{ route('admin.rombel.anggota', $rombel->id) }}" class="mb-2" id="formCariAnggota">
                        <input type="hidden" name="cari_tambah" value="{{ $cariTambah }}">
                        <div class="input-group input-group-sm">
                            <input type="text" name="cari_anggota" class="form-control" placeholder="Cari nama / NIPD / NISN..." value="{{ $cariAnggota }}">
                            <div class="input-group-append">
                                <button class="btn btn-success" type="submit"><i class="fa fa-search"></i></button>
                                @if($cariAnggota)
                                    <a href="{{ route('admin.rombel.anggota', $rombel->id) }}?cari_tambah={{ $cariTambah }}" class="btn btn-outline-secondary">
                                        <i class="fa fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    {{-- Tabel anggota --}}
                    <div class="table-responsive" id="tabelAnggota">
                        <table class="table table-sm table-bordered table-striped mb-1">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Nama</th>
                                    <th>NIPD</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="bodyAnggota">
                                @forelse($anggota as $i => $siswa)
                                <tr id="row-anggota-{{ $siswa->id }}">
                                    <td>{{ $anggota->firstItem() + $i }}</td>
                                    <td>
                                        <span class="font-weight-bold">{{ $siswa->nama }}</span><br>
                                        <small class="text-muted">NISN: {{ $siswa->nisn ?? '-' }}</small>
                                    </td>
                                    <td><small>{{ $siswa->nipd ?? '-' }}</small></td>
                                    <td>
                                        <button type="button"
                                            class="btn btn-danger btn-xs btn-keluarkan"
                                            data-id="{{ $siswa->id }}"
                                            data-nama="{{ $siswa->nama }}"
                                            data-url="{{ route('admin.rombel.keluarkan_siswa', $siswa->id) }}"
                                            title="Keluarkan dari rombel">
                                            <i class="fa fa-sign-out"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr id="rowEmptyAnggota">
                                    <td colspan="4" class="text-center text-muted py-3">
                                        <i class="fa fa-inbox fa-2x"></i><br>Belum ada anggota di rombel ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginasi anggota --}}
                    <div class="d-flex justify-content-center">
                        {{ $anggota->appends(['cari_anggota' => $cariAnggota, 'cari_tambah' => $cariTambah])->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================ --}}
        {{-- KOLOM KANAN: Siswa Belum Punya Rombel       --}}
        {{-- ============================================ --}}
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-warning text-dark d-flex align-items-center justify-content-between">
                    <span><i class="fa fa-user-plus"></i> <strong>Siswa Tanpa Rombel</strong></span>
                    <span class="badge badge-dark" id="badgeTanpaRombel">{{ $tanpaRombel->total() }} siswa</span>
                </div>
                <div class="card-body p-2">

                    {{-- Pencarian siswa tanpa rombel --}}
                    <form method="GET" action="{{ route('admin.rombel.anggota', $rombel->id) }}" class="mb-2" id="formCariTambah">
                        <input type="hidden" name="cari_anggota" value="{{ $cariAnggota }}">
                        <div class="input-group input-group-sm">
                            <input type="text" name="cari_tambah" class="form-control" placeholder="Cari nama / NIPD / NISN..." value="{{ $cariTambah }}">
                            <div class="input-group-append">
                                <button class="btn btn-warning" type="submit"><i class="fa fa-search"></i></button>
                                @if($cariTambah)
                                    <a href="{{ route('admin.rombel.anggota', $rombel->id) }}?cari_anggota={{ $cariAnggota }}" class="btn btn-outline-secondary">
                                        <i class="fa fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    {{-- Tabel siswa tanpa rombel --}}
                    <div class="table-responsive" id="tabelTanpaRombel">
                        <table class="table table-sm table-bordered table-striped mb-1">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Nama</th>
                                    <th>NIPD</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="bodyTanpaRombel">
                                @forelse($tanpaRombel as $i => $siswa)
                                <tr id="row-tanpa-{{ $siswa->id }}">
                                    <td>{{ $tanpaRombel->firstItem() + $i }}</td>
                                    <td>
                                        <span class="font-weight-bold">{{ $siswa->nama }}</span><br>
                                        <small class="text-muted">NISN: {{ $siswa->nisn ?? '-' }}</small>
                                    </td>
                                    <td><small>{{ $siswa->nipd ?? '-' }}</small></td>
                                    <td>
                                        <button type="button"
                                            class="btn btn-success btn-xs btn-tambah-siswa"
                                            data-id="{{ $siswa->id }}"
                                            data-nama="{{ $siswa->nama }}"
                                            data-url="{{ route('admin.rombel.tambah_siswa', $rombel->id) }}"
                                            title="Tambahkan ke rombel ini">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr id="rowEmptyTanpa">
                                    <td colspan="4" class="text-center text-muted py-3">
                                        <i class="fa fa-check-circle fa-2x text-success"></i><br>Semua siswa sudah memiliki rombel.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginasi siswa tanpa rombel --}}
                    <div class="d-flex justify-content-center">
                        {{ $tanpaRombel->appends(['cari_anggota' => $cariAnggota, 'cari_tambah' => $cariTambah])->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- end .row --}}
</div>

{{-- Toast Notifikasi (muncul di pojok kanan bawah) --}}
<div id="toastWrapper" style="position:fixed; bottom:20px; right:20px; z-index:9999; min-width:280px;"></div>

<style>
    .btn-xs { padding: 2px 7px; font-size: 12px; }
    .toast-msg { padding: 10px 16px; border-radius: 8px; color: #fff; margin-top: 8px;
        box-shadow: 0 4px 14px rgba(0,0,0,.15); animation: slideIn .3s ease; }
    .toast-success { background: #28a745; }
    .toast-danger  { background: #dc3545; }
    @keyframes slideIn { from { opacity:0; transform:translateX(40px); } to { opacity:1; transform:translateX(0); } }
</style>

<script>
$(document).ready(function () {

    var CSRF = '{{ csrf_token() }}';
    var rombelId = '{{ $rombel->id }}';

    // Tampilkan toast notifikasi
    function showToast(msg, type) {
        var cls = type === 'success' ? 'toast-success' : 'toast-danger';
        var ico = type === 'success' ? 'fa-check-circle' : 'fa-times-circle';
        var el  = $('<div class="toast-msg ' + cls + '"><i class="fa ' + ico + '"></i> ' + msg + '</div>');
        $('#toastWrapper').append(el);
        setTimeout(function () { el.fadeOut(400, function () { el.remove(); }); }, 4000);
    }

    // ===== TOMBOL TAMBAH SISWA KE ROMBEL =====
    $(document).on('click', '.btn-tambah-siswa', function () {
        var btn    = $(this);
        var idSiswa = btn.data('id');
        var nama   = btn.data('nama');
        var url    = btn.data('url');

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

        $.ajax({
            url: url,
            type: 'POST',
            data: { _token: CSRF, id_siswa: idSiswa },
            success: function (res) {
                showToast(res.message, 'success');

                // Hapus dari kolom kanan
                $('#row-tanpa-' + idSiswa).fadeOut(300, function () {
                    $(this).remove();
                    if ($('#bodyTanpaRombel tr:visible').length === 0) {
                        $('#bodyTanpaRombel').html(
                            '<tr><td colspan="4" class="text-center text-muted py-3">' +
                            '<i class="fa fa-check-circle fa-2x text-success"></i><br>Semua siswa sudah memiliki rombel.</td></tr>'
                        );
                    }
                });

                // Tambah baris ke kolom kiri
                $('#rowEmptyAnggota').remove();
                var no = $('#bodyAnggota tr').length + 1;
                var newRow = '<tr id="row-anggota-' + idSiswa + '">' +
                    '<td>' + no + '</td>' +
                    '<td><span class="font-weight-bold">' + nama + '</span></td>' +
                    '<td><small>—</small></td>' +
                    '<td><button type="button" class="btn btn-danger btn-xs btn-keluarkan" ' +
                    'data-id="' + idSiswa + '" data-nama="' + nama + '" ' +
                    'data-url="/admin/rombel/keluarkan-siswa/' + idSiswa + '" title="Keluarkan dari rombel">' +
                    '<i class="fa fa-sign-out"></i></button></td></tr>';
                $('#bodyAnggota').append(newRow);

                // Update counter
                var tot = parseInt($('#badgeAnggota').text()) + 1;
                $('#badgeAnggota').text(tot + ' siswa');
                $('#totalAnggota').text(tot);
            },
            error: function () {
                btn.prop('disabled', false).html('<i class="fa fa-plus"></i>');
                showToast('Gagal menambahkan siswa.', 'danger');
            }
        });
    });

    // ===== TOMBOL KELUARKAN SISWA DARI ROMBEL =====
    $(document).on('click', '.btn-keluarkan', function () {
        var btn     = $(this);
        var idSiswa = btn.data('id');
        var nama    = btn.data('nama');
        var url     = btn.data('url');

        if (!confirm('Keluarkan ' + nama + ' dari rombel ini?')) return;

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

        $.ajax({
            url: url,
            type: 'POST',
            data: { _token: CSRF },
            success: function (res) {
                showToast(res.message, 'success');

                // Hapus dari kolom kiri
                $('#row-anggota-' + idSiswa).fadeOut(300, function () {
                    $(this).remove();
                    if ($('#bodyAnggota tr:visible').length === 0) {
                        $('#bodyAnggota').html(
                            '<tr id="rowEmptyAnggota"><td colspan="4" class="text-center text-muted py-3">' +
                            '<i class="fa fa-inbox fa-2x"></i><br>Belum ada anggota di rombel ini.</td></tr>'
                        );
                    }
                });

                // Tambah ke kolom kanan
                $('#rowEmptyTanpa').remove();
                var no = $('#bodyTanpaRombel tr').length + 1;
                var newRow = '<tr id="row-tanpa-' + idSiswa + '">' +
                    '<td>' + no + '</td>' +
                    '<td><span class="font-weight-bold">' + nama + '</span></td>' +
                    '<td><small>—</small></td>' +
                    '<td><button type="button" class="btn btn-success btn-xs btn-tambah-siswa" ' +
                    'data-id="' + idSiswa + '" data-nama="' + nama + '" ' +
                    'data-url="/admin/rombel/' + rombelId + '/tambah-siswa" title="Tambahkan ke rombel ini">' +
                    '<i class="fa fa-plus"></i></button></td></tr>';
                $('#bodyTanpaRombel').append(newRow);

                // Update counter
                var tot = Math.max(0, parseInt($('#badgeAnggota').text()) - 1);
                $('#badgeAnggota').text(tot + ' siswa');
                $('#totalAnggota').text(tot);
            },
            error: function () {
                btn.prop('disabled', false).html('<i class="fa fa-sign-out"></i>');
                showToast('Gagal mengeluarkan siswa.', 'danger');
            }
        });
    });

});
</script>

@endsection
