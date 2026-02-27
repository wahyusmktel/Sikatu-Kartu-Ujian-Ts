{{-- Banner Info Ujian Aktif --}}
{{-- Usage: @include('admin.partials.ujian_aktif_banner') --}}
<div class="row mb-3">
    <div class="col-12">
        @if(isset($ujianAktif) && $ujianAktif)
        <div style="
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            border: 1.5px solid #38bdf8;
            border-left: 5px solid #0284c7;
            border-radius: 10px;
            padding: 10px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        ">
            <div class="d-flex align-items-center" style="gap:12px;">
                <div style="
                    width:38px; height:38px; border-radius:50%;
                    background: #0284c7;
                    display:flex; align-items:center; justify-content:center;
                    flex-shrink:0;
                ">
                    <i class="fa fa-university" style="color:#fff; font-size:16px;"></i>
                </div>
                <div>
                    <div style="font-size:11px; color:#0369a1; font-weight:700; text-transform:uppercase; letter-spacing:.5px;">
                        Ujian Aktif Saat Ini
                    </div>
                    <div style="font-size:15px; font-weight:700; color:#0c4a6e; line-height:1.3;">
                        {{ $ujianAktif->nama_ujian }}
                        @if($ujianAktif->kode_ujian)
                            <span style="font-size:11px; background:#0284c7; color:#fff; border-radius:4px; padding:1px 7px; margin-left:6px; font-weight:600;">
                                {{ $ujianAktif->kode_ujian }}
                            </span>
                        @endif
                    </div>
                    <div style="font-size:12px; color:#0369a1;">
                        @if($ujianAktif->tahun_pelajaran)
                            Tahun Pelajaran: <strong>{{ $ujianAktif->tahun_pelajaran }}</strong> &nbsp;|&nbsp;
                        @endif
                        Data yang ditampilkan adalah milik ujian ini.
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.ujian.index') }}" style="
                background: #0284c7; color: #fff; border:none;
                border-radius: 7px; padding: 6px 14px;
                font-size: 12px; font-weight: 600;
                text-decoration: none; white-space:nowrap;
                display:inline-flex; align-items:center; gap:5px;
            ">
                <i class="fa fa-cog"></i> Atur Ujian
            </a>
        </div>
        @else
        <div style="
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            border: 1.5px solid #f87171;
            border-left: 5px solid #dc2626;
            border-radius: 10px;
            padding: 10px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        ">
            <div class="d-flex align-items-center" style="gap:12px;">
                <div style="width:38px; height:38px; border-radius:50%; background:#dc2626; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fa fa-exclamation-triangle" style="color:#fff; font-size:16px;"></i>
                </div>
                <div>
                    <div style="font-size:11px; color:#b91c1c; font-weight:700; text-transform:uppercase; letter-spacing:.5px;">Tidak Ada Ujian Aktif</div>
                    <div style="font-size:14px; font-weight:600; color:#7f1d1d;">
                        Belum ada ujian yang diaktifkan. Data tidak akan tampil.
                    </div>
                    <div style="font-size:12px; color:#b91c1c;">
                        Aktifkan ujian terlebih dahulu melalui menu <strong>Master Data &rarr; Data Ujian</strong>.
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.ujian.index') }}" style="
                background: #dc2626; color: #fff; border:none;
                border-radius: 7px; padding: 6px 14px;
                font-size: 12px; font-weight: 600;
                text-decoration: none; white-space:nowrap;
                display:inline-flex; align-items:center; gap:5px;
            ">
                <i class="fa fa-cog"></i> Aktifkan Ujian
            </a>
        </div>
        @endif
    </div>
</div>
