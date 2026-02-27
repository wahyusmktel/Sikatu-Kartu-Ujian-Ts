@extends('admin.layouts.app')

@section('page-title', 'Generated CBT')

@section('breadcrumbs')
    <li class="nav-home">
        <a href="/admin/dashboard"><i class="flaticon-home"></i></a>
    </li>
    <li class="separator"><i class="flaticon-right-arrow"></i></li>
    <li class="nav-item"><a href="/admin/generated_cbt">Generated CBT User</a></li>
@endsection

@section('content')

@include('admin.partials.ujian_aktif_banner')

<style>
    .cbt-card { border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,.08); border: none; overflow: hidden; }
    .cbt-card .card-header {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 60%, #0f3460 100%);
        border-bottom: none; padding: 16px 22px;
    }
    .cbt-header-title { color: #fff; font-size: 16px; font-weight: 700; margin: 0; }
    .cbt-header-title small { color: rgba(255,255,255,.5); font-size: 12px; font-weight: 400; }
    .stat-pill {
        display:inline-flex; align-items:center; gap:5px;
        background:rgba(255,255,255,.12); color:#fff;
        border-radius:20px; padding:4px 12px; font-size:12px; font-weight:600;
    }
    .btn-generate {
        background: linear-gradient(135deg,#667eea,#764ba2); color:#fff; border:none;
        border-radius:8px; padding:6px 16px; font-size:13px; font-weight:600;
        box-shadow:0 4px 12px rgba(102,126,234,.35); transition:all .2s;
    }
    .btn-generate:hover { color:#fff; transform:translateY(-1px); box-shadow:0 6px 18px rgba(102,126,234,.5); }
    .btn-export {
        background: linear-gradient(135deg,#11998e,#38ef7d); color:#fff; border:none;
        border-radius:8px; padding:6px 16px; font-size:13px; font-weight:600;
        box-shadow:0 4px 12px rgba(17,153,142,.3); transition:all .2s;
    }
    .btn-export:hover { color:#fff; transform:translateY(-1px); }

    /* Table */
    .cbt-table { width:100%; border-collapse:collapse; }
    .cbt-table thead tr { background:#f8faff; }
    .cbt-table thead th {
        font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.6px;
        color:#64748b; border-bottom:2px solid #e8edf5; padding:11px 14px; white-space:nowrap;
    }
    .cbt-table tbody tr { border-bottom:1px solid #f1f5fb; transition:background .15s; }
    .cbt-table tbody tr:last-child { border-bottom:none; }
    .cbt-table tbody tr:hover { background:#f5f8ff; }
    .cbt-table tbody td { padding:11px 14px; font-size:13px; color:#374151; vertical-align:middle; }

    .no-badge {
        display:inline-flex; align-items:center; justify-content:center;
        width:28px; height:28px; border-radius:50%;
        background:#ede9fe; color:#6d28d9; font-size:12px; font-weight:700;
    }
    .user-chip {
        background:#f1f5f9; border-radius:6px; padding:3px 8px;
        font-family:'Courier New',monospace; font-size:13px; font-weight:700; color:#0f172a;
    }
    .pass-chip {
        background:#fff7ed; border-radius:6px; padding:3px 8px;
        font-family:'Courier New',monospace; font-size:13px; font-weight:700; color:#c2410c;
    }
    .name-main { font-weight:600; color:#1e293b; }
    .name-email { font-size:11px; color:#94a3b8; margin-top:1px; }
    .rombel-badge {
        display:inline-block; background:linear-gradient(135deg,#e0e7ff,#c7d2fe);
        color:#3730a3; border-radius:5px; padding:2px 8px; font-size:11px; font-weight:700;
    }
    .ruang-badge {
        display:inline-flex; align-items:center; gap:4px;
        background:linear-gradient(135deg,#d1fae5,#a7f3d0);
        color:#065f46; border-radius:5px; padding:3px 9px; font-size:11px; font-weight:700;
    }
    .ruang-badge.empty { background:#f1f5f9; color:#94a3b8; }
    .btn-detail {
        background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe;
        border-radius:6px; padding:4px 10px; font-size:12px; font-weight:600; transition:all .2s;
    }
    .btn-detail:hover { background:#2563eb; color:#fff; border-color:#2563eb; }

    /* Modal */
    .modal-modern .modal-content { border-radius:14px; border:none; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,.15); }
    .modal-modern .modal-header { background:linear-gradient(135deg,#1a1a2e,#0f3460); color:#fff; border:none; }
    .modal-modern .modal-header .close, .modal-modern .modal-header .close span { color:#fff; opacity:.7; }
    .modal-modern .modal-title { font-weight:700; font-size:15px; }
    .detail-table th { width:130px; color:#64748b; font-size:12px; font-weight:600; background:#f8faff; }
    .detail-table td { font-size:13px; }

    /* Generate modal */
    .global-fill-bar { background:#f8faff; border:1.5px dashed #c7d2fe; border-radius:10px; padding:12px 14px; margin-bottom:14px; }
    .global-fill-bar label { font-size:12px; font-weight:700; color:#6d28d9; margin-bottom:6px; }
    .rombel-input-table thead th { font-size:11px; color:#64748b; font-weight:700; text-transform:uppercase; letter-spacing:.5px; background:#f8faff; }
    .rombel-input-table td { font-size:13px; vertical-align:middle; padding:8px 12px; }
    .table-scroll { max-height:380px; overflow-y:auto; border:1px solid #e8edf5; border-radius:10px; }
    .table-scroll thead th { position:sticky; top:0; z-index:2; }

    .empty-state { padding:60px 20px; text-align:center; color:#94a3b8; }
    .empty-state i { font-size:40px; margin-bottom:12px; opacity:.4; display:block; }
</style>

<div class="page-category">
<div class="row">
<div class="col-12">
<div class="card cbt-card">

    {{-- HEADER --}}
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap" style="gap:10px;">
        <div>
            <p class="cbt-header-title">
                <i class="fas fa-users-cog mr-2"></i> Generated CBT User
                <br><small>Data user untuk login ke sistem CBT ujian aktif</small>
            </p>
        </div>
        <div class="d-flex align-items-center flex-wrap" style="gap:8px;">
            <span class="stat-pill"><i class="fa fa-user"></i> {{ $users->total() }} siswa</span>
            <form class="d-flex" action="{{ route('admin.generated_cbt') }}" method="GET" style="gap:0;">
                <input type="text" name="cari" class="form-control form-control-sm"
                    style="border-radius:8px 0 0 8px;border:1.5px solid rgba(255,255,255,.2);background:rgba(255,255,255,.1);color:#fff;width:180px;font-size:13px;"
                    placeholder="Cari siswa / username..." value="{{ $cari ?? '' }}">
                <button type="submit" style="background:rgba(255,255,255,.15);color:#fff;border:1.5px solid rgba(255,255,255,.2);border-left:none;border-radius:0 8px 8px 0;padding:0 12px;">
                    <i class="fa fa-search"></i>
                </button>
            </form>
            <button type="button" class="btn-generate" data-toggle="modal" data-target="#generateModal">
                <i class="fas fa-user-plus"></i> Generate
            </button>
            <a href="{{ route('admin.export_cbt_csv') }}" class="btn-export" style="text-decoration:none;display:inline-block;">
                <i class="fas fa-file-excel"></i> Export CSV
            </a>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="cbt-table">
                <thead>
                    <tr>
                        <th style="width:50px">#</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Nama Siswa</th>
                        <th>Rombel</th>
                        <th>Ruang</th>
                        <th style="width:80px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = ($users->currentPage() - 1) * $users->perPage() + 1; @endphp
                    @forelse($users as $user)
                    @php $ruang = $user->address ?? '-'; @endphp
                    <tr>
                        <td><span class="no-badge">{{ $no++ }}</span></td>
                        <td><span class="user-chip">{{ sprintf('%05s', $user->kartuUjian->username_ujian) }}</span></td>
                        <td><span class="pass-chip">{{ sprintf('%05s', $user->kartuUjian->password_ujian) }}</span></td>
                        <td>
                            <div class="name-main">{{ $user->siswa->nama }}</div>
                            <div class="name-email">{{ $user->siswa['e-mail'] ?? '-' }}</div>
                        </td>
                        <td><span class="rombel-badge">{{ optional($user->siswa->rombel)->nama_rombel ?? '-' }}</span></td>
                        <td>
                            @if($ruang && $ruang !== '-')
                                <span class="ruang-badge"><i class="fa fa-map-marker"></i> {{ $ruang }}</span>
                            @else
                                <span class="ruang-badge empty">-</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn-detail" data-toggle="modal" data-target="#detailModal-{{ $user->id }}">
                                <i class="fa fa-eye"></i> Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-user-slash"></i>
                                <strong>Belum ada data CBT</strong><br>
                                <small>Klik tombol <strong>Generate</strong> untuk membuat data user CBT.</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-3 py-2">
            {{ $users->appends(['cari' => $cari])->links('vendor.pagination.custom') }}
        </div>
    </div>
</div>
</div>
</div>
</div>

{{-- ===== SEMUA MODAL DETAIL (di luar card/table) ===== --}}
@foreach($users as $user)
@php $ruang = $user->address ?? '-'; @endphp
<div class="modal fade modal-modern" id="detailModal-{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="fa fa-id-card mr-2"></i>{{ $user->siswa->nama }}</h6>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body p-0">
                <table class="table table-sm detail-table mb-0">
                    <tbody>
                        <tr><th>Username</th><td><span class="user-chip">{{ $user->kartuUjian->username_ujian }}</span></td></tr>
                        <tr><th>Password</th><td><span class="pass-chip">{{ $user->kartuUjian->password_ujian }}</span></td></tr>
                        <tr><th>Nama</th><td><strong>{{ $user->siswa->nama }}</strong></td></tr>
                        <tr><th>Email</th><td>{{ $user->siswa['e-mail'] ?? '-' }}</td></tr>
                        <tr><th>Rombel</th><td><span class="rombel-badge">{{ optional($user->siswa->rombel)->nama_rombel ?? '-' }}</span></td></tr>
                        <tr><th>Ruang</th><td>
                            @if($ruang && $ruang !== '-')
                                <span class="ruang-badge"><i class="fa fa-map-marker"></i> {{ $ruang }}</span>
                            @else <span class="text-muted">-</span>
                            @endif
                        </td></tr>
                    </tbody>
                </table>
                <div class="px-3 pb-3 pt-2">
                    <p class="text-muted mb-1" style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">Mata Pelajaran</p>
                    @for($c = 1; $c <= 15; $c++)
                        @if($user->{'course'.$c})
                            <div style="font-size:12px;color:#475569;padding:2px 0;">
                                <span style="color:#94a3b8;">{{ $c }}.</span> {{ $user->{'course'.$c} }}
                            </div>
                        @endif
                    @endfor
                </div>
            </div>
            <div class="modal-footer" style="border-top:1px solid #f1f5f9;">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

{{-- ===== MODAL GENERATE CBT ===== --}}
<div class="modal fade modal-modern" id="generateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="fas fa-cogs mr-2"></i>Generate CBT — Atur Ruang per Rombel</h6>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('admin.generated_cbt_post') }}" method="POST"
                onsubmit="return confirm('Yakin akan melakukan generate / update data CBT?');">
                @csrf
                <div class="modal-body">
                    <p class="text-muted small mb-3">
                        <i class="fa fa-info-circle text-primary"></i>
                        Tentukan nama ruang untuk setiap rombel. Siswa mendapat nama ruang sesuai rombel-nya.
                        Rombel yang tidak diisi diberi nilai <code>-</code>.
                    </p>

                    <div class="global-fill-bar">
                        <label><i class="fa fa-magic"></i> Isi Semua Ruang Sekaligus</label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" id="inputRuangGlobal" placeholder="Ketik nama ruang...">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary btn-sm" id="btnIsiSemua">Isi Semua</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="btnResetSemua">Reset</button>
                            </div>
                        </div>
                    </div>

                    <div class="table-scroll">
                        <table class="table table-sm rombel-input-table mb-0">
                            <thead>
                                <tr>
                                    <th width="90">Tingkat</th>
                                    <th>Nama Rombel</th>
                                    <th width="220">Nama Ruang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rombels as $rombel)
                                <tr>
                                    <td class="text-center">
                                        <span class="badge badge-secondary">{{ $rombel->tingkat_rombel }}</span>
                                    </td>
                                    <td>{{ $rombel->nama_rombel }}</td>
                                    <td>
                                        <input type="text"
                                            class="form-control form-control-sm input-ruang"
                                            name="ruang[{{ $rombel->id }}]"
                                            placeholder="cth: Ruang 101"
                                            style="border-radius:6px;">
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        <i class="fa fa-exclamation-triangle text-warning"></i> Belum ada rombel aktif.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-generate" style="padding:6px 18px;font-size:13px;">
                        <i class="fas fa-user-plus"></i> Generate
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#btnIsiSemua').on('click', function () {
        var val = $('#inputRuangGlobal').val().trim();
        if (!val) { alert('Ketik nama ruang terlebih dahulu.'); return; }
        $('.input-ruang').val(val);
    });
    $('#btnResetSemua').on('click', function () {
        $('.input-ruang, #inputRuangGlobal').val('');
    });

    @if(session('success'))
        $.notify({ message: '{{ session('success') }}', title: 'Sukses!', icon: 'fa fa-check' },
            { type: 'success', placement: { from: "top", align: "right" }, time: 1000, delay: 6000 });
    @endif
    @if(session('error'))
        $.notify({ message: '{{ session('error') }}', title: 'Error!', icon: 'fa fa-times-circle' },
            { type: 'danger', placement: { from: "top", align: "right" }, time: 1000, delay: 6000 });
    @endif
});
</script>

@endsection
