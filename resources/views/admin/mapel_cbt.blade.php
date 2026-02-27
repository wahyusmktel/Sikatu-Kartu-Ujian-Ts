@extends('admin.layouts.app')

@section('page-title', 'Mapel CBT')

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
        <a href="/admin/mapel_cbt">Data Mapel CBT</a>
    </li>
@endsection

@section('content')

@include('admin.partials.ujian_aktif_banner')

<div class="row mb-3">
    <div class="col-12">
        <div style="background:linear-gradient(135deg,#fffbeb,#fef3c7);border:1.5px solid #fcd34d;border-left:5px solid #d97706;border-radius:10px;padding:10px 18px;display:flex;align-items:center;gap:14px;">
            <div style="width:36px;height:36px;border-radius:50%;background:#d97706;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas fa-book" style="color:#fff;font-size:15px;"></i>
            </div>
            <div>
                <div style="font-size:11px;color:#92400e;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">Panduan Import Mata Pelajaran ke Moodle</div>
                <div style="font-size:13px;color:#78350f;font-weight:500;">
                    Anda dapat langsung <strong>mengimpor data mata pelajaran</strong> dari CSV halaman ini untuk <strong>membuat course ujian di Moodle</strong>.
                    Klik tombol <span style="background:#d97706;color:#fff;border-radius:4px;padding:1px 7px;font-size:11px;font-weight:600;">Ekspor ke CSV</span> lalu upload melalui menu <em>Site Administration → Courses → Upload Courses</em> di Moodle.
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="page-category">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="pull-left">
                            <!-- Tombol untuk memunculkan modal -->
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahMapelModal"><i class="
                                fas fa-plus-square"></i> Tambah Mapel CBT</button>
                            <a href="{{ route('admin.mapel_cbt.export') }}" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i> Ekspor ke CSV</a>
                            <!-- Modal -->
                            <div class="modal fade" id="tambahMapelModal" tabindex="-1" role="dialog" aria-labelledby="tambahMapelLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="tambahMapelLabel">Tambah Mapel CBT</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <form action="{{ route('admin.tambah_mapel_cbt') }}" method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                            <label for="category">Category</label>
                                            <input type="text" class="form-control" id="category" name="category" placeholder="Contoh: 54, 23, 12">
                                            </div>
                                            <div class="form-group">
                                                <label for="format">Format</label>
                                                <select class="form-control" id="format" name="format">
                                                    <option value="singleactivity">singleactivity</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                            <label for="fullname">Fullname</label>
                                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Pendidikan Agama Islam">
                                            </div>
                                            {{-- <div class="form-group">
                                                <label for="id_rombel">Pilih Rombel</label>
                                                <select name="id_rombel" id="id_rombel" class="form-control">
                                                    @foreach($rombels as $rombel)
                                                        <option value="{{ $rombel->id }}">{{ $rombel->nama_rombel }}</option>
                                                    @endforeach
                                                </select>
                                            </div> --}}
                                            <div class="form-group">
                                                <label class="form-label">Pilih Rombel</label>
                                                <div class="selectgroup selectgroup-pills">
                                                    @foreach($rombels as $rombel)
                                                        <label class="selectgroup-item">
                                                            <input type="checkbox" name="id_rombel[]" value="{{ $rombel->id }}" class="selectgroup-input">
                                                            <span class="selectgroup-button">{{ $rombel->nama_rombel }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pull-right">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="collapse" id="search-nav">
                                    <form class="navbar-form nav-search mr-md-3" action="{{ route('admin.mapel_cbt') }}" method="GET">
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
                                    <th>Nama Rombel</th>
                                    <th>Tingkat Rombel</th>
                                    <th>Wali Kelas</th>
                                    <th>Shortname</th>
                                    <th>Format</th>
                                    <th>Fullname</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse($mapels as $mapel)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $mapel->rombel->nama_rombel }}</td>
                                    <td>{{ $mapel->rombel->tingkat_rombel }}</td>
                                    <td>{{ $mapel->rombel->wali_kelas }}</td>
                                    <td>{{ $mapel->shortname }}</td>
                                    <td>{{ $mapel->format }}</td>
                                    <td>{{ $mapel->fullname }}</td>
                                    <td>
                                        <!-- Tombol Detail -->
                                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal-{{ $mapel->id }}"><i class="fa fa-eye"></i> Detail</button>
                                        @foreach($mapels as $mapel)
                                        <!-- Modal Detail Mapel CBT -->
                                        <div class="modal fade" id="detailModal-{{ $mapel->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel-{{ $mapel->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="detailModalLabel-{{ $mapel->id }}">Detail Mapel CBT: {{ $mapel->shortname }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Shortname: {{ $mapel->shortname }}<br>
                                                        Format: {{ $mapel->format }}<br>
                                                        Fullname: {{ $mapel->fullname }}<br>
                                                        Rombel: {{ $mapel->rombel->nama_rombel ?? 'N/A' }}<br>
                                                        Status: {{ $mapel->status ? 'Aktif' : 'Tidak Aktif' }}<br>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8">Data mapel_cbt tidak ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- Paginasi -->
                        {{ $mapels->appends(['cari' => $cari])->links('vendor.pagination.custom') }}
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