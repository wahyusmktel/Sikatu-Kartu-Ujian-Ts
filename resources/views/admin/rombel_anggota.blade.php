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
        <div class="col-12">
            <div class="card mb-0" style="border-left:4px solid #007bff;">
                <div class="card-body py-2 d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted">Rombel</small>
                        <h5 class="mb-0 font-weight-bold">{{ $rombel->nama_rombel }}</h5>
                        <small class="text-muted">
                            Tingkat: <strong>{{ $rombel->tingkat_rombel }}</strong> &nbsp;|&nbsp;
                            Wali Kelas: <strong>{{ $rombel->wali_kelas ?? '-' }}</strong> &nbsp;|&nbsp;
                            Total Anggota: <strong id="totalAnggota">{{ $anggota->total() }}</strong> siswa
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

        {{-- ======================================================= --}}
        {{-- KOLOM KIRI: Anggota Rombel Saat Ini                     --}}
        {{-- ======================================================= --}}
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-success text-white d-flex align-items-center justify-content-between">
                    <span><i class="fa fa-users"></i> <strong>Anggota Rombel</strong></span>
                    <span class="badge badge-light text-success" id="badgeAnggota">{{ $anggota->total() }} siswa</span>
                </div>
                <div class="card-body p-2">

                    {{-- Pencarian --}}
                    <form method="GET" action="{{ route('admin.rombel.anggota', $rombel->id) }}" class="mb-2">
                        <input type="hidden" name="cari_tambah" value="{{ $cariTambah }}">
                        <div class="input-group input-group-sm">
                            <input type="text" name="cari_anggota" class="form-control" placeholder="Cari nama / NIPD / NISN..." value="{{ $cariAnggota }}">
                            <div class="input-group-append">
                                <button class="btn btn-success" type="submit"><i class="fa fa-search"></i></button>
                                @if($cariAnggota)
                                    <a href="{{ route('admin.rombel.anggota', $rombel->id) }}?cari_tambah={{ $cariTambah }}" class="btn btn-outline-secondary"><i class="fa fa-times"></i></a>
                                @endif
                            </div>
                        </div>
                    </form>

                    {{-- Bulk action bar anggota --}}
                    <div class="d-flex align-items-center mb-2" id="bulkBarAnggota" style="display:none!important;">
                        <button class="btn btn-sm btn-danger" id="btnBulkKeluarkan" disabled>
                            <i class="fa fa-sign-out"></i> Keluarkan Terpilih (<span id="cntAnggota">0</span>)
                        </button>
                        <button class="btn btn-sm btn-link text-danger ml-2" id="btnClearAnggota">Batal pilih</button>
                    </div>

                    {{-- Tabel anggota --}}
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover mb-1">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="32px">
                                        <input type="checkbox" id="checkAllAnggota" title="Pilih semua">
                                    </th>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>NIPD</th>
                                    <th width="50px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="bodyAnggota">
                                @forelse($anggota as $i => $siswa)
                                <tr id="row-anggota-{{ $siswa->id }}">
                                    <td><input type="checkbox" class="chk-anggota" value="{{ $siswa->id }}"></td>
                                    <td>{{ $anggota->firstItem() + $i }}</td>
                                    <td>
                                        <strong>{{ $siswa->nama }}</strong><br>
                                        <small class="text-muted">NISN: {{ $siswa->nisn ?? '-' }}</small>
                                    </td>
                                    <td><small>{{ $siswa->nipd ?? '-' }}</small></td>
                                    <td>
                                        <button type="button"
                                            class="btn btn-danger btn-sm btn-keluarkan"
                                            data-id="{{ $siswa->id }}"
                                            data-nama="{{ $siswa->nama }}"
                                            title="Keluarkan dari rombel">
                                            <i class="fa fa-sign-out"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr id="rowEmptyAnggota">
                                    <td colspan="5" class="text-center text-muted py-3">
                                        <i class="fa fa-inbox fa-2x"></i><br>Belum ada anggota.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginasi --}}
                    {{ $anggota->appends(['cari_anggota' => $cariAnggota, 'cari_tambah' => $cariTambah])->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>

        {{-- ======================================================= --}}
        {{-- KOLOM KANAN: Siswa Tanpa Rombel                         --}}
        {{-- ======================================================= --}}
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-warning text-dark d-flex align-items-center justify-content-between">
                    <span><i class="fa fa-user-plus"></i> <strong>Siswa Tanpa Rombel</strong></span>
                    <span class="badge badge-dark" id="badgeTanpa">{{ $tanpaRombel->total() }} siswa</span>
                </div>
                <div class="card-body p-2">

                    {{-- Pencarian --}}
                    <form method="GET" action="{{ route('admin.rombel.anggota', $rombel->id) }}" class="mb-2">
                        <input type="hidden" name="cari_anggota" value="{{ $cariAnggota }}">
                        <div class="input-group input-group-sm">
                            <input type="text" name="cari_tambah" class="form-control" placeholder="Cari nama / NIPD / NISN..." value="{{ $cariTambah }}">
                            <div class="input-group-append">
                                <button class="btn btn-warning" type="submit"><i class="fa fa-search"></i></button>
                                @if($cariTambah)
                                    <a href="{{ route('admin.rombel.anggota', $rombel->id) }}?cari_anggota={{ $cariAnggota }}" class="btn btn-outline-secondary"><i class="fa fa-times"></i></a>
                                @endif
                            </div>
                        </div>
                    </form>

                    {{-- Bulk action bar tambah --}}
                    <div class="d-flex align-items-center mb-2" id="bulkBarTambah" style="display:none!important;">
                        <button class="btn btn-sm btn-success" id="btnBulkTambah" disabled>
                            <i class="fa fa-plus"></i> Tambah Terpilih (<span id="cntTambah">0</span>)
                        </button>
                        <button class="btn btn-sm btn-link text-secondary ml-2" id="btnClearTambah">Batal pilih</button>
                    </div>

                    {{-- Tabel siswa tanpa rombel --}}
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover mb-1">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="32px">
                                        <input type="checkbox" id="checkAllTambah" title="Pilih semua">
                                    </th>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>NIPD</th>
                                    <th width="50px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="bodyTanpa">
                                @forelse($tanpaRombel as $i => $siswa)
                                <tr id="row-tanpa-{{ $siswa->id }}">
                                    <td><input type="checkbox" class="chk-tambah" value="{{ $siswa->id }}"></td>
                                    <td>{{ $tanpaRombel->firstItem() + $i }}</td>
                                    <td>
                                        <strong>{{ $siswa->nama }}</strong><br>
                                        <small class="text-muted">NISN: {{ $siswa->nisn ?? '-' }}</small>
                                    </td>
                                    <td><small>{{ $siswa->nipd ?? '-' }}</small></td>
                                    <td>
                                        <button type="button"
                                            class="btn btn-success btn-sm btn-tambah-siswa"
                                            data-id="{{ $siswa->id }}"
                                            data-nama="{{ $siswa->nama }}"
                                            title="Tambahkan ke rombel ini">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr id="rowEmptyTanpa">
                                    <td colspan="5" class="text-center text-muted py-3">
                                        <i class="fa fa-check-circle fa-2x text-success"></i><br>Semua siswa sudah punya rombel.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginasi --}}
                    {{ $tanpaRombel->appends(['cari_anggota' => $cariAnggota, 'cari_tambah' => $cariTambah])->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>

    </div>{{-- end .row --}}
</div>

{{-- Toast notifikasi pojok kanan bawah --}}
<div id="toastWrapper" style="position:fixed;bottom:20px;right:20px;z-index:9999;min-width:280px;"></div>

<style>
    .table-hover tbody tr:hover { background:#f0f7ff; cursor:default; }
    .toast-msg { padding:10px 16px; border-radius:8px; color:#fff; margin-top:8px;
        box-shadow:0 4px 14px rgba(0,0,0,.18); animation:slideIn .3s ease; }
    .toast-success { background:#28a745; }
    .toast-danger  { background:#dc3545; }
    .toast-warning { background:#ffc107; color:#212529; }
    @keyframes slideIn { from {opacity:0;transform:translateX(40px);} to {opacity:1;transform:translateX(0);} }
    #bulkBarAnggota, #bulkBarTambah { transition: all .2s; }
</style>

<script>
$(document).ready(function () {

    var CSRF          = '{{ csrf_token() }}';
    var ROMBEL_ID     = '{{ $rombel->id }}';
    var URL_TAMBAH    = '{{ route("admin.rombel.tambah_siswa", $rombel->id) }}';
    var URL_KELUARKAN_BASE = '/admin/rombel/keluarkan-siswa/';
    var URL_BULK_TAMBAH    = '{{ route("admin.rombel.bulk_tambah", $rombel->id) }}';
    var URL_BULK_KELUARKAN = '{{ route("admin.rombel.bulk_keluarkan") }}';

    // ---------- TOAST ----------
    function showToast(msg, type) {
        type = type || 'success';
        var cls = 'toast-' + type;
        var ico = type === 'success' ? 'fa-check-circle' : (type === 'danger' ? 'fa-times-circle' : 'fa-exclamation-triangle');
        var el  = $('<div class="toast-msg ' + cls + '"><i class="fa ' + ico + ' mr-1"></i>' + msg + '</div>');
        $('#toastWrapper').append(el);
        setTimeout(function () { el.fadeOut(400, function () { el.remove(); }); }, 4000);
    }

    // ---------- UPDATE COUNTER BADGE ----------
    function updateBadgeAnggota(delta) {
        var cur = parseInt($('#totalAnggota').text()) + delta;
        cur = Math.max(0, cur);
        $('#totalAnggota').text(cur);
        $('#badgeAnggota').text(cur + ' siswa');
    }

    // ---------- HELPERS DOM ----------
    function addToAnggota(id, nama) {
        $('#rowEmptyAnggota').remove();
        var no = $('#bodyAnggota tr').length + 1;
        $('#bodyAnggota').append(
            '<tr id="row-anggota-' + id + '">' +
            '<td><input type="checkbox" class="chk-anggota" value="' + id + '"></td>' +
            '<td>' + no + '</td>' +
            '<td><strong>' + nama + '</strong></td>' +
            '<td><small>—</small></td>' +
            '<td><button type="button" class="btn btn-danger btn-sm btn-keluarkan" data-id="' + id + '" data-nama="' + nama + '" title="Keluarkan dari rombel"><i class="fa fa-sign-out"></i></button></td>' +
            '</tr>'
        );
        updateBadgeAnggota(+1);
    }

    function removeFromAnggota(id) {
        $('#row-anggota-' + id).fadeOut(250, function () {
            $(this).remove();
            if ($('#bodyAnggota tr:visible').length === 0) {
                $('#bodyAnggota').html('<tr id="rowEmptyAnggota"><td colspan="5" class="text-center text-muted py-3"><i class="fa fa-inbox fa-2x"></i><br>Belum ada anggota.</td></tr>');
            }
        });
        updateBadgeAnggota(-1);
    }

    function addToTanpa(id, nama) {
        $('#rowEmptyTanpa').remove();
        var no = $('#bodyTanpa tr').length + 1;
        $('#bodyTanpa').append(
            '<tr id="row-tanpa-' + id + '">' +
            '<td><input type="checkbox" class="chk-tambah" value="' + id + '"></td>' +
            '<td>' + no + '</td>' +
            '<td><strong>' + nama + '</strong></td>' +
            '<td><small>—</small></td>' +
            '<td><button type="button" class="btn btn-success btn-sm btn-tambah-siswa" data-id="' + id + '" data-nama="' + nama + '" title="Tambahkan ke rombel ini"><i class="fa fa-plus"></i></button></td>' +
            '</tr>'
        );
    }

    function removeFromTanpa(id) {
        $('#row-tanpa-' + id).fadeOut(250, function () {
            $(this).remove();
            if ($('#bodyTanpa tr:visible').length === 0) {
                $('#bodyTanpa').html('<tr id="rowEmptyTanpa"><td colspan="5" class="text-center text-muted py-3"><i class="fa fa-check-circle fa-2x text-success"></i><br>Semua siswa sudah punya rombel.</td></tr>');
            }
        });
    }

    // ---------- CHECK ALL ANGGOTA ----------
    $('#checkAllAnggota').on('change', function () {
        $('.chk-anggota').prop('checked', this.checked);
        updateBulkBarAnggota();
    });
    $(document).on('change', '.chk-anggota', function () {
        if (!this.checked) $('#checkAllAnggota').prop('checked', false);
        else if ($('.chk-anggota:not(:checked)').length === 0) $('#checkAllAnggota').prop('checked', true);
        updateBulkBarAnggota();
    });
    function updateBulkBarAnggota() {
        var cnt = $('.chk-anggota:checked').length;
        $('#cntAnggota').text(cnt);
        if (cnt > 0) {
            $('#bulkBarAnggota').css('display', 'flex');
            $('#btnBulkKeluarkan').prop('disabled', false);
        } else {
            $('#bulkBarAnggota').css('display', 'none!important');
            $('#btnBulkKeluarkan').prop('disabled', true);
        }
    }
    $('#btnClearAnggota').on('click', function () {
        $('.chk-anggota, #checkAllAnggota').prop('checked', false);
        updateBulkBarAnggota();
    });

    // ---------- CHECK ALL TAMBAH ----------
    $('#checkAllTambah').on('change', function () {
        $('.chk-tambah').prop('checked', this.checked);
        updateBulkBarTambah();
    });
    $(document).on('change', '.chk-tambah', function () {
        if (!this.checked) $('#checkAllTambah').prop('checked', false);
        else if ($('.chk-tambah:not(:checked)').length === 0) $('#checkAllTambah').prop('checked', true);
        updateBulkBarTambah();
    });
    function updateBulkBarTambah() {
        var cnt = $('.chk-tambah:checked').length;
        $('#cntTambah').text(cnt);
        if (cnt > 0) {
            $('#bulkBarTambah').css('display', 'flex');
            $('#btnBulkTambah').prop('disabled', false);
        } else {
            $('#bulkBarTambah').css('display', 'none!important');
            $('#btnBulkTambah').prop('disabled', true);
        }
    }
    $('#btnClearTambah').on('click', function () {
        $('.chk-tambah, #checkAllTambah').prop('checked', false);
        updateBulkBarTambah();
    });

    // ---------- SINGLE: TAMBAH SISWA ----------
    $(document).on('click', '.btn-tambah-siswa', function () {
        var btn    = $(this);
        var id     = btn.data('id');
        var nama   = btn.data('nama');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

        $.post(URL_TAMBAH, { _token: CSRF, id_siswa: id }, function (res) {
            showToast(res.message, 'success');
            removeFromTanpa(id);
            addToAnggota(id, nama);
        }).fail(function () {
            btn.prop('disabled', false).html('<i class="fa fa-plus"></i>');
            showToast('Gagal menambahkan siswa.', 'danger');
        });
    });

    // ---------- BULK: TAMBAH SISWA ----------
    $('#btnBulkTambah').on('click', function () {
        var ids   = $('.chk-tambah:checked').map(function () { return this.value; }).get();
        var nama_arr = [];
        $.each(ids, function (i, id) {
            nama_arr.push({ id: id, nama: $('#row-tanpa-' + id + ' strong').first().text() });
        });
        if (!ids.length) { showToast('Pilih minimal 1 siswa.', 'warning'); return; }

        $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Memproses...');

        $.post(URL_BULK_TAMBAH, { _token: CSRF, ids: ids }, function (res) {
            showToast(res.message, 'success');
            $.each(nama_arr, function (i, s) { removeFromTanpa(s.id); addToAnggota(s.id, s.nama); });
            $('.chk-tambah, #checkAllTambah').prop('checked', false);
            updateBulkBarTambah();
        }).fail(function () {
            showToast('Gagal bulk tambah.', 'danger');
        }).always(function () {
            $('#btnBulkTambah').prop('disabled', false).html('<i class="fa fa-plus"></i> Tambah Terpilih (<span id="cntTambah">0</span>)');
        });
    });

    // ---------- SINGLE: KELUARKAN SISWA ----------
    $(document).on('click', '.btn-keluarkan', function () {
        var btn  = $(this);
        var id   = btn.data('id');
        var nama = btn.data('nama');
        if (!confirm('Keluarkan ' + nama + ' dari rombel ini?')) return;
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

        $.post(URL_KELUARKAN_BASE + id, { _token: CSRF }, function (res) {
            showToast(res.message, 'success');
            removeFromAnggota(id);
            addToTanpa(id, nama);
        }).fail(function () {
            btn.prop('disabled', false).html('<i class="fa fa-sign-out"></i>');
            showToast('Gagal mengeluarkan siswa.', 'danger');
        });
    });

    // ---------- BULK: KELUARKAN SISWA ----------
    $('#btnBulkKeluarkan').on('click', function () {
        var ids      = $('.chk-anggota:checked').map(function () { return this.value; }).get();
        var nama_arr = [];
        $.each(ids, function (i, id) {
            nama_arr.push({ id: id, nama: $('#row-anggota-' + id + ' strong').first().text() });
        });
        if (!ids.length) { showToast('Pilih minimal 1 siswa.', 'warning'); return; }

        if (!confirm('Keluarkan ' + ids.length + ' siswa terpilih dari rombel ini?')) return;

        $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Memproses...');

        $.post(URL_BULK_KELUARKAN, { _token: CSRF, ids: ids }, function (res) {
            showToast(res.message, 'success');
            $.each(nama_arr, function (i, s) { removeFromAnggota(s.id); addToTanpa(s.id, s.nama); });
            $('.chk-anggota, #checkAllAnggota').prop('checked', false);
            updateBulkBarAnggota();
        }).fail(function () {
            showToast('Gagal bulk keluarkan.', 'danger');
        }).always(function () {
            $('#btnBulkKeluarkan').prop('disabled', false).html('<i class="fa fa-sign-out"></i> Keluarkan Terpilih (<span id="cntAnggota">0</span>)');
        });
    });

});
</script>

@endsection
