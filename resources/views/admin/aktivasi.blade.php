@extends('admin.layouts.app')

@section('page-title', 'Aktivasi Kartu Ujian')

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
        <a href="/admin/aktivasi_kartu/">Aktivasi Kartu Ujian</a>
    </li>
@endsection

@section('content')
    <div class="page-category">
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="flaticon-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Aktivasi</p>
                                    <h4 class="card-title">{{ $totalAktivasi }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-danger bubble-shadow-small">
                                    <i class="flaticon-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Belum Aktivasi</p>
                                    <h4 class="card-title">{{ $totalBelumAktivasi }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-file-excel"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    {{-- <p class="card-category">Total Belum Aktivasi</p> --}}
                                    <h4 class="card-title"><a href="{{ route('aktivasi.export') }}">Export Data Aktivasi</a></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-warning bubble-shadow-small">
                                    <i class="fas fa-file-excel"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    {{-- <p class="card-category">Total Belum Aktivasi</p> --}}
                                    <h4 class="card-title"><a href="{{ route('belumaktivasi.export') }}">Export Belum Aktivasi</a></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <a href="{{ route('aktivasi.export') }}">Export Data Aktivasi</a>
            <a href="{{ route('belumaktivasi.export') }}">Export Data Belum Aktivasi</a> --}}
            

        </div>
        @include('admin.partials.ujian_aktif_banner')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                     <div class="card-header">
                        <div class="pull-left d-flex align-items-end flex-wrap" style="gap:12px;">

                            {{-- Filter Aktivasi --}}
                            <div class="form-group mb-0">
                                <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:4px;">
                                    <i class="fa fa-toggle-on"></i> Filter Aktivasi
                                </label>
                                <form action="{{ route('admin.aktivasi') }}" method="GET" id="formStatusFilter">
                                    <input type="hidden" name="rombel_filter" value="{{ $rombelFilter ?? '' }}">
                                    <input type="hidden" name="cari" value="{{ $cari ?? '' }}">
                                    <select id="filterAktivasi" name="status_filter" class="form-control form-control-sm"
                                        style="border-radius:8px;min-width:170px;" onchange="this.form.submit()">
                                        <option value="">— Semua Status —</option>
                                        <option value="true"  {{ ($statusFilter ?? '') == 'true'  ? 'selected' : '' }}>✅ Sudah Aktivasi</option>
                                        <option value="false" {{ ($statusFilter ?? '') == 'false' ? 'selected' : '' }}>❌ Belum Aktivasi</option>
                                    </select>
                                </form>
                            </div>

                            {{-- Filter Kelas --}}
                            <div class="form-group mb-0">
                                <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:4px;">
                                    <i class="fa fa-users"></i> Filter Kelas
                                </label>
                                <form action="{{ route('admin.aktivasi') }}" method="GET" id="formRombelFilter">
                                    <input type="hidden" name="status_filter" value="{{ $statusFilter ?? '' }}">
                                    <input type="hidden" name="cari" value="{{ $cari ?? '' }}">
                                    <select name="rombel_filter" class="form-control form-control-sm"
                                        style="border-radius:8px;min-width:180px;" onchange="this.form.submit()">
                                        <option value="">— Semua Kelas —</option>
                                        @foreach($rombels as $rombel)
                                            <option value="{{ $rombel->id }}" {{ ($rombelFilter ?? '') == $rombel->id ? 'selected' : '' }}>
                                                {{ $rombel->nama_rombel }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>

                            {{-- Tombol Reset Filter --}}
                            @if($statusFilter || $rombelFilter)
                            <div class="form-group mb-0" style="align-self:flex-end;">
                                <a href="{{ route('admin.aktivasi') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;height:31px;line-height:1.4;">
                                    <i class="fa fa-times"></i> Reset
                                </a>
                            </div>
                            @endif

                        </div>
                         
                                               
                        <div class="pull-right">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="collapse" id="search-nav">
                                    <form class="navbar-form nav-search mr-md-3" action="{{ route('admin.aktivasi') }}" method="GET">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button type="submit" class="btn btn-search pr-1">
                                                    <i class="fa fa-search search-icon"></i>
                                                </button>
                                            </div>
                                            <input type="text" name="cari" value="{{ $cari ?? '' }}" placeholder="Search ..." class="form-control">
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
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    {{-- <th>Username Ujian</th>
                                    <th>Password Ujian</th> --}}
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = ($kartuUjians->currentPage() - 1) * $kartuUjians->perPage() + 1; @endphp
                                @forelse($kartuUjians as $kartu)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $kartu->ujian->nama_ujian }} {{ $kartu->ujian->semester }} Tahun Pelajaran {{ $kartu->ujian->tahun_pelajaran }}</td>
                                    <td>{{ $kartu->siswa->nama }}</td>
                                    <td>{{ $kartu->siswa->rombel_saat_ini }}</td>
                                    {{-- <td>{{ $kartu->username_ujian }}</td>
                                    <td>{{ $kartu->password_ujian }}</td> --}}
                                    <td>
                                        @if($kartu->aktivasiKartu)
                                            @if($kartu->aktivasiKartu->status_aktivasi)
                                                <span class="badge badge-success">Sudah Aktivasi</span>
                                            @else
                                                <span class="badge badge-danger">Belum Aktivasi</span>
                                            @endif
                                        @else
                                            <span class="badge badge-danger">Belum Aktivasi</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- <input type="checkbox" data-toggle="toggle" data-onstyle="primary" data-offstyle="danger" data-on="ON" data-off="OFF" class="status-toggle" data-id="{{ $kartu->id }}" data-id-kartu="{{ $kartu->id }}" data-id-ujian="{{ $kartu->id_ujian }}" data-id-siswa="{{ $kartu->id_siswa }}" {{ $kartu->status ? 'checked' : '' }}> --}}
                                        <!-- Tombol Detail -->
                                        @php
                                            $statusAktivasi = optional($kartu->aktivasiKartu)->status_aktivasi ?? false;
                                        @endphp
                                        <input type="checkbox" data-toggle="toggle" data-onstyle="primary" data-offstyle="danger" data-on="ON" data-off="OFF" class="status-toggle" data-id="{{ $kartu->id }}" data-id-kartu="{{ $kartu->id }}" data-id-ujian="{{ $kartu->id_ujian }}" data-id-siswa="{{ $kartu->id_siswa }}" {{ $statusAktivasi ? 'checked' : '' }}>

                                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal-{{ $kartu->id }}"><i class="fa fa-eye"></i> Detail</button>
                                        {{-- <a href="{{ route('kartu.cetak', $kartu->id) }}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-print"></i> Cetak</a> --}}
                                        @php
                                            $isActivated = $kartu->aktivasiKartu && $kartu->aktivasiKartu->status_aktivasi;
                                        @endphp

                                        @if($isActivated)
                                            <a href="{{ route('kartu.cetak', $kartu->id) }}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-print"></i> Cetak</a>
                                        @else
                                            <button class="btn btn-primary btn-sm" disabled><i class="fa fa-print"></i> Cetak</button>
                                        @endif
                                        <!-- Modal Detail Kartu Ujian -->
                                        <div class="modal fade" id="detailModal-{{ $kartu->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel-{{ $kartu->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="detailModalLabel-{{ $kartu->id }}">Detail Kartu Ujian: {{ $kartu->siswa->nama }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Nama Ujian: {{ $kartu->ujian->nama_ujian }}<br>
                                                        Nama Siswa: {{ $kartu->siswa->nama }}<br>
                                                        Username Ujian: {{ $kartu->username_ujian }}<br>
                                                        Password Ujian: {{ $kartu->password_ujian }}<br>
                                                        Status Data: 
                                                        @if($kartu->aktivasiKartu)
                                                            @if($kartu->aktivasiKartu->status_aktivasi)
                                                                <span class="badge badge-success">Sudah Aktivasi</span>
                                                            @else
                                                                <span class="badge badge-danger">Belum Aktivasi</span>
                                                            @endif
                                                        @else
                                                            <span class="badge badge-danger">Belum Aktivasi</span>
                                                        @endif
                                                        <!-- Anda dapat menambahkan detail lainnya sesuai kebutuhan -->
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
                                    <td colspan="7">Belum ada data kartu ujian didalam ujian aktif.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- Paginasi -->
                        {{-- {{ $kartuUjians->appends(['cari' => $cari])->links('vendor.pagination.custom') }} --}}
                        {{ $kartuUjians->appends(['cari' => $cari, 'status_filter' => $statusFilter, 'rombel_filter' => $rombelFilter])->links('vendor.pagination.custom') }}                         
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

    <script>
        $(document).ready(function() {
            $('.status-toggle').change(function(e) {
                let kartuId = $(this).data('id-kartu');
                let ujianId = $(this).data('id-ujian');
                let siswaId = $(this).data('id-siswa');
                let status = $(this).prop('checked');
                let currentElement = $(this);  // Simpan referensi elemen saat ini

                // Konfirmasi SweetAlert
                swal({
                    title: status ? "Konfirmasi Aktivasi" : "Konfirmasi Non-Aktivasi",
                    text: status ? "Apakah Anda ingin mengaktifkan kartu ujian?" : "Apakah Anda yakin akan menonaktifkan kartu ujian?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willChange) => {
                    if (willChange) {
                        $.ajax({
                            url: '/admin/aktivasi_kartu', // Sesuaikan dengan URL endpoint Anda
                            method: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id_kartu": kartuId,
                                "id_ujian": ujianId,
                                "id_siswa": siswaId,
                                "status_aktivasi": status
                            },
                            success: function(response) {
                                if (response.success) {
                                    let message = 'Kartu ujian berhasil diaktifkan.';
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
                                } else {
                                    $.notify({
                                        // message: response.message || 'Terjadi kesalahan saat mengupdate status.',
                                        message: response.message || 'Kartu Ujian Berhasil di non-aktifkan.',
                                        title: 'Sukses!',
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
                                }
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
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
