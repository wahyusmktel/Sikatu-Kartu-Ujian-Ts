@extends('admin.layouts.app')

@section('page-title', 'Generated CBT Susulan')

@section('breadcrumbs')
    <li class="nav-home">
        <a href="/admin/dashboard"><i class="flaticon-home"></i></a>
    </li>
    <li class="separator"><i class="flaticon-right-arrow"></i></li>
    <li class="nav-item"><a href="/admin/generated_cbt_susulan">Generated CBT Susulan</a></li>
@endsection

@section('content')

@include('admin.partials.ujian_aktif_banner')

<div class="row mb-3">
    <div class="col-12">
        <div style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);border:1.5px solid #86efac;border-left:5px solid #16a34a;border-radius:10px;padding:10px 18px;display:flex;align-items:center;gap:14px;">
            <div style="width:36px;height:36px;border-radius:50%;background:#16a34a;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas fa-file-import" style="color:#fff;font-size:15px;"></i>
            </div>
            <div>
                <div style="font-size:11px;color:#15803d;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">Panduan Import Moodle — Susulan</div>
                <div style="font-size:13px;color:#14532d;font-weight:500;">
                    Anda dapat langsung <strong>mengimpor data CSV</strong> dari halaman ini ke <strong>Moodle</strong> sebagai <strong>peserta ujian susulan</strong>.
                    Klik tombol <span style="background:#16a34a;color:#fff;border-radius:4px;padding:1px 7px;font-size:11px;font-weight:600;">Export CSV</span> lalu upload file tersebut melalui menu <em>Site Administration → Users → Upload Users</em> di Moodle.
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .cbt-card { border-radius:16px; box-shadow:0 4px 24px rgba(0,0,0,.08); border:none; overflow:hidden; }
    .cbt-card .card-header {
        background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 60%, #415a77 100%);
        border-bottom:none; padding:16px 22px;
    }
    .cbt-header-title { color:#fff; font-size:16px; font-weight:700; margin:0; }
    .cbt-header-title small { color:rgba(255,255,255,.5); font-size:12px; font-weight:400; }
    .stat-pill {
        display:inline-flex; align-items:center; gap:5px;
        background:rgba(255,255,255,.12); color:#fff;
        border-radius:20px; padding:4px 12px; font-size:12px; font-weight:600;
    }
    .btn-generate {
        background:linear-gradient(135deg,#f7971e,#ffd200); color:#1a1a1a; border:none;
        border-radius:8px; padding:6px 16px; font-size:13px; font-weight:700;
        box-shadow:0 4px 12px rgba(247,151,30,.35); transition:all .2s;
        display:inline-block; text-decoration:none;
    }
    .btn-generate:hover { color:#1a1a1a; transform:translateY(-1px); box-shadow:0 6px 18px rgba(247,151,30,.5); }
    .btn-export {
        background:linear-gradient(135deg,#11998e,#38ef7d); color:#fff; border:none;
        border-radius:8px; padding:6px 16px; font-size:13px; font-weight:600;
        box-shadow:0 4px 12px rgba(17,153,142,.3); transition:all .2s;
        display:inline-block; text-decoration:none;
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
    .cbt-table tbody tr:hover { background:#fffbf0; }
    .cbt-table tbody td { padding:11px 14px; font-size:13px; color:#374151; vertical-align:middle; }

    .no-badge {
        display:inline-flex; align-items:center; justify-content:center;
        width:28px; height:28px; border-radius:50%;
        background:#fef3c7; color:#d97706; font-size:12px; font-weight:700;
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
        background:linear-gradient(135deg,#fef3c7,#fde68a);
        color:#92400e; border-radius:5px; padding:3px 9px; font-size:11px; font-weight:700;
    }
    .ruang-badge.empty { background:#f1f5f9; color:#94a3b8; }
    .susulan-tag {
        display:inline-flex; align-items:center; gap:3px;
        background:linear-gradient(135deg,#fee2e2,#fecaca);
        color:#dc2626; border-radius:5px; padding:2px 7px; font-size:10px; font-weight:700;
    }
    .btn-detail {
        background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe;
        border-radius:6px; padding:4px 10px; font-size:12px; font-weight:600; transition:all .2s;
    }
    .btn-detail:hover { background:#2563eb; color:#fff; border-color:#2563eb; }

    /* Modal */
    .modal-modern .modal-content { border-radius:14px; border:none; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,.15); }
    .modal-modern .modal-header { background:linear-gradient(135deg,#0d1b2a,#415a77); color:#fff; border:none; }
    .modal-modern .modal-header .close, .modal-modern .modal-header .close span { color:#fff; opacity:.7; }
    .modal-modern .modal-title { font-weight:700; font-size:15px; }
    .detail-table th { width:130px; color:#64748b; font-size:12px; font-weight:600; background:#f8faff; }
    .detail-table td { font-size:13px; }

    /* Generate modal */
    .ruang-input-box {
        background:linear-gradient(135deg,#fffbf0,#fef3c7);
        border:1.5px solid #fde68a; border-radius:10px; padding:14px;
    }
    .ruang-input-box label { font-size:12px; font-weight:700; color:#92400e; margin-bottom:6px; }

    .table-scroll { max-height:360px; overflow-y:auto; border:1px solid #e8edf5; border-radius:10px; }
    .table-scroll thead th { position:sticky; top:0; z-index:2; background:#f8faff; }

    .empty-state { padding:60px 20px; text-align:center; color:#94a3b8; }
    .empty-state i { font-size:40px; margin-bottom:12px; opacity:.4; display:block; }

    /* Select2 in modal */
    .select2-container { width:100% !important; }
    .select2-container--bootstrap .select2-selection { border-radius:8px; }
</style>

<div class="page-category">
<div class="row">
<div class="col-12">
<div class="card cbt-card">

    {{-- HEADER --}}
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap" style="gap:10px;">
        <div>
            <p class="cbt-header-title">
                <i class="fas fa-user-clock mr-2"></i> Generated CBT Susulan
                <br><small>Data user ujian susulan — satu ruang untuk semua peserta</small>
            </p>
        </div>
        <div class="d-flex align-items-center flex-wrap" style="gap:8px;">
            <span class="stat-pill"><i class="fa fa-user"></i> {{ $users->total() }} siswa</span>
            <form class="d-flex" action="{{ route('admin.generated_cbt_susulan') }}" method="GET" style="gap:0;">
                <input type="text" name="cari" class="form-control form-control-sm"
                    style="border-radius:8px 0 0 8px;border:1.5px solid rgba(255,255,255,.2);background:rgba(255,255,255,.1);color:#fff;width:180px;font-size:13px;"
                    placeholder="Cari siswa / username..." value="{{ $cari ?? '' }}">
                <button type="submit" style="background:rgba(255,255,255,.15);color:#fff;border:1.5px solid rgba(255,255,255,.2);border-left:none;border-radius:0 8px 8px 0;padding:0 12px;">
                    <i class="fa fa-search"></i>
                </button>
            </form>
            <button type="button" class="btn-generate" data-toggle="modal" data-target="#generateModal">
                <i class="fas fa-user-plus"></i> Generate Susulan
            </button>
            <a href="{{ route('admin.export_cbt_csv_susulan') }}" class="btn-export">
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
                        <td>
                            <span class="no-badge">{{ $no++ }}</span>
                        </td>
                        <td><span class="user-chip">{{ sprintf('%05s', $user->kartuUjian->username_ujian) }}</span></td>
                        <td><span class="pass-chip">{{ sprintf('%05s', $user->kartuUjian->password_ujian) }}</span></td>
                        <td>
                            <div class="name-main">{{ $user->siswa->nama }}</div>
                            <div class="name-email">{{ $user->siswa['e-mail'] ?? '-' }}</div>
                        </td>
                        <td>
                            <span class="rombel-badge">{{ optional($user->siswa->rombel)->nama_rombel ?? '-' }}</span>
                        </td>
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
                                <strong>Belum ada data CBT Susulan</strong><br>
                                <small>Klik <strong>Generate Susulan</strong> untuk menambahkan peserta ujian susulan.</small>
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

{{-- ===== MODAL DETAIL (di luar table) ===== --}}
@foreach($users as $user)
@php $ruang = $user->address ?? '-'; @endphp
<div class="modal fade modal-modern" id="detailModal-{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">
                    <i class="fa fa-id-card mr-2"></i>{{ $user->siswa->nama }}
                    <span class="susulan-tag ml-2"><i class="fa fa-clock"></i> Susulan</span>
                </h6>
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
                    @for($c = 1; $c <= 30; $c++)
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

{{-- ===== MODAL GENERATE SUSULAN ===== --}}
<div class="modal fade modal-modern" id="generateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="fas fa-user-clock mr-2"></i>Generate CBT Susulan</h6>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('admin.generated_cbt_post_susulan') }}" method="POST"
                onsubmit="return confirm('Yakin akan generate data CBT Susulan untuk siswa yang dipilih?');">
                @csrf
                <div class="modal-body">
                    <p class="text-muted small mb-3">
                        <i class="fa fa-info-circle text-warning"></i>
                        Ujian susulan biasanya digabung dalam <strong>satu ruang</strong>. Masukkan nama ruang dan pilih siswa peserta susulan.
                    </p>

                    {{-- Input Ruang (satu input untuk semua) --}}
                    <div class="ruang-input-box mb-3">
                        <label><i class="fa fa-map-marker"></i> Nama Ruang Ujian Susulan</label>
                        <input type="text" class="form-control form-control-sm" name="address"
                            placeholder="cth: Ruang Lab Komputer 1 / Ruang Susulan"
                            style="border-radius:8px;border:1.5px solid #fde68a;font-weight:600;" required>
                        <small class="text-muted">Semua peserta susulan yang dipilih akan mendapat nama ruang ini.</small>
                    </div>

                    {{-- Pilih Siswa --}}
                    <div class="form-group mb-0">
                        <label class="font-weight-bold" style="font-size:13px;">
                            <i class="fa fa-users text-primary"></i> Pilih Peserta Susulan
                        </label>
                        <select id="selectSiswa" name="siswa_ids[]" class="form-control" multiple="multiple" required>
                            <option value=""> </option>
                            @foreach($allSiswa as $siswa)
                                <option value="{{ $siswa->id }}">
                                    {{ $siswa->nama }}
                                    @if($siswa->nipd) ({{ $siswa->nipd }}) @endif
                                    @if($siswa->rombel) — {{ $siswa->rombel->nama_rombel }} @endif
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Gunakan Select2 untuk mencari siswa dengan cepat.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-generate" style="padding:6px 18px;font-size:13px;">
                        <i class="fas fa-user-plus"></i> Generate Susulan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    // Select2 untuk pilih siswa
    $('#selectSiswa').select2({
        theme: 'bootstrap',
        width: '100%',
        placeholder: 'Cari dan pilih siswa peserta susulan...',
        allowClear: true,
        dropdownParent: $('#generateModal'),
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
