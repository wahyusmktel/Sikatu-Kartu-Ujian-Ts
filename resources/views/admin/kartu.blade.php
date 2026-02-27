@extends('admin.layouts.app')

@section('page-title', 'Generated Kartu Ujian')

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
        <a href="/admin/generated_katu/">Generated Kartu Ujian</a>
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
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#generateKartuUjianModal">
                            <i class="fa fa-credit-card"></i> Generated Kartu Ujian
                        </button>
                        
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="generateKartuUjianModal" tabindex="-1" role="dialog" aria-labelledby="generateKartuUjianModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="generateKartuUjianModalLabel">Generated Kartu Ujian</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.generate') }}" method="post">
                                            @csrf
                                            @if($ujianAktif)
                                                <div class="form-group">
                                                    <label for="id_ujian">Data Ujian Aktif:</label>
                                                    <input type="text" name="nama_ujian" id="nama_ujian" value="{{ $ujianAktif->nama_ujian }}" readonly class="form-control">
                                                    <input type="hidden" name="id_ujian" value="{{ $ujianAktif->id }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Opsion:</label><br>
                                                    <input type="radio" name="siswa_option" value="all_siswa" checked> Pilih Semua Siswa
                                                    <input type="radio" name="siswa_option" value="exclude_siswa"> Kecualikan Siswa

                                                </div>
                                                <div class="form-group" id="excludeSiswa" style="display: none;">
                                                    <label for="exclude_siswa">Pilih Siswa yang Dikecualikan:</label>
                                                    <!-- Anda bisa menggunakan library select2 atau yang lainnya untuk membuat multi select ini menjadi lebih user-friendly -->
                                                    <div class="select2-input select2-warning">
                                                        <select id="exclude_siswa" name="siswa_exclude[]" class="form-control" multiple="multiple" style="width: 100%;">
                                                            @foreach($semuaSiswa as $siswa)
                                                                <option value="{{ $siswa->id }}">{{ $siswa->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    Silahkan aktifkan ujian terlebih dahulu sebelum melakukan generated kartu ujian.
                                                </div>
                                            @endif
                                    </div>
                                    <div class="modal-footer">
                                        @if($ujianAktif)
                                            <button type="submit" class="btn btn-success btn-sm">Generate Kartu Ujian</button>
                                        @endif
                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>                        
                        <div class="pull-right">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="collapse" id="search-nav">
                                    <form class="navbar-form nav-search mr-md-3" action="{{ route('admin.kartu') }}" method="GET">
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
                                    <th>Username Ujian</th>
                                    <th>Password Ujian</th>
                                    {{-- <th>Status</th> --}}
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
                                    <td>{{ $kartu->username_ujian }}</td>
                                    <td>{{ $kartu->password_ujian }}</td>
                                    {{-- <td>
                                        @if($kartu->status)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-danger">Non-Aktif</span>
                                        @endif
                                    </td> --}}
                                    <td>
                                        
                                            <!-- Tombol Detail -->
                                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal-{{ $kartu->id }}"><i class="fa fa-eye"></i> Detail</button>
                                            
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
                                                            {{-- Status: 
                                                            @if($kartu->status)
                                                                <span class="badge badge-success">Aktif</span>
                                                            @else
                                                                <span class="badge badge-danger">Non-Aktif</span>
                                                            @endif --}}
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
                        {{ $kartuUjians->appends(['cari' => $cari])->links('vendor.pagination.custom') }}                               
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
            // Event listener saat radio button berubah
            $("input[name='siswa_option']").change(function() {
                if ($(this).val() == 'exclude_siswa') {
                    // Jika opsi "Kecualikan Siswa" dipilih, tampilkan formnya
                    $('#excludeSiswa').slideDown();
                } else {
                    // Jika opsi lain dipilih, sembunyikan formnya
                    $('#excludeSiswa').slideUp();
                }
            });
        });
    </script>
    
@endsection
