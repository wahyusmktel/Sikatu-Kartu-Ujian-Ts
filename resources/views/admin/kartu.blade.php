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

@include('admin.partials.ujian_aktif_banner')

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

                        <!-- Tombol Update Data -->
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#updateDataKartuModal">
                            <i class="fa fa-upload"></i> Update Data
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

                        {{-- ================================================================== --}}
                        {{-- MODAL UPDATE DATA (USERNAME & PASSWORD MASSAL) --}}
                        {{-- ================================================================== --}}
                        <div class="modal fade" id="updateDataKartuModal" tabindex="-1" role="dialog"
                            aria-labelledby="updateDataKartuModalLabel" aria-hidden="true"
                            data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">

                                    <div class="modal-header bg-warning text-dark">
                                        <h5 class="modal-title" id="updateDataKartuModalLabel">
                                            <i class="fa fa-upload"></i> Update Username &amp; Password Ujian (Massal)
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                            id="btnCloseUpdateModal">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">

                                        {{-- STEP 1: Panduan & Download Format --}}
                                        <div id="updateStep1">
                                            {{-- Panduan langkah-langkah --}}
                                            <div class="alert alert-info" style="border-radius:8px;">
                                                <p class="mb-2 font-weight-bold"><i class="fa fa-info-circle"></i>
                                                    Panduan Update Data Massal</p>
                                                <ol class="mb-0 pl-3" style="font-size:13px; line-height:2;">
                                                    <li>
                                                        <strong>Download</strong> format Excel dengan menekan tombol
                                                        <em>"Download Format Excel"</em> di bawah.<br>
                                                        <small class="text-muted">File berisi daftar seluruh siswa ujian aktif beserta username &amp; password saat ini.</small>
                                                    </li>
                                                    <li>
                                                        <strong>Buka file</strong> Excel yang sudah didownload.
                                                    </li>
                                                    <li>
                                                        Edit kolom <span class="badge badge-success">Username Ujian</span>
                                                        dan <span class="badge badge-success">Password Ujian</span> sesuai data baru yang diinginkan.
                                                    </li>
                                                    <li>
                                                        <span class="text-danger font-weight-bold">Jangan hapus atau ubah</span> kolom
                                                        <span class="badge badge-secondary">ID (Jangan Diubah)</span> — kolom ini digunakan sistem untuk mengenali data.
                                                    </li>
                                                    <li>
                                                        <strong>Simpan file</strong> Excel (tetap dalam format .xlsx atau .xls).
                                                    </li>
                                                    <li>
                                                        Tekan tombol <em>"Lanjut Import"</em> lalu pilih file yang sudah diedit dan klik <em>"Upload &amp; Update"</em>.
                                                    </li>
                                                </ol>
                                            </div>

                                            <div class="text-center mt-3">
                                                <a href="{{ route('admin.kartu.download_format') }}"
                                                   class="btn btn-success btn-sm" id="btnDownloadFormat">
                                                    <i class="fa fa-download"></i> Download Format Excel
                                                </a>
                                            </div>
                                        </div>

                                        {{-- STEP 2: Upload File --}}
                                        <div id="updateStep2" style="display:none;">
                                            <form id="formUpdateKartu" enctype="multipart/form-data"
                                                action="{{ route('admin.kartu.import_update') }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="fileUpdate" class="font-weight-bold">
                                                        <i class="fa fa-file-excel text-success"></i>
                                                        Pilih File Excel yang sudah diedit:
                                                    </label>
                                                    <div class="custom-file mb-2">
                                                        <input type="file" class="custom-file-input" id="fileUpdate"
                                                            name="file_update" accept=".xlsx,.xls" required>
                                                        <label class="custom-file-label" for="fileUpdate">Pilih
                                                            file...</label>
                                                    </div>
                                                    <small class="form-text text-muted mt-2">
                                                        <i class="fa fa-exclamation-circle text-warning"></i>
                                                        Pastikan file yang diunggah adalah format Excel yang sudah Anda
                                                        download dan edit (kolom ID tidak diubah).
                                                    </small>
                                                </div>
                                            </form>
                                        </div>

                                        {{-- STEP 3: Loading --}}
                                        <div id="updateStep3" style="display:none;">
                                            <div class="text-center py-4">
                                                <i class="fa fa-spinner fa-spin fa-3x text-warning"></i>
                                                <p class="mt-3 font-weight-bold" id="updateStatusText">Memproses
                                                    data...</p>
                                                <small class="text-muted">Mohon tunggu, jangan tutup halaman
                                                    ini.</small>
                                            </div>
                                        </div>

                                    </div>{{-- end modal-body --}}

                                    <div class="modal-footer" id="updateModalFooter">
                                        {{-- Footer Step 1 --}}
                                        <div id="footerStep1">
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                data-dismiss="modal">Batal</button>
                                            <button type="button" class="btn btn-warning btn-sm"
                                                id="btnGoToStep2">
                                                <i class="fa fa-arrow-right"></i> Lanjut Import
                                            </button>
                                        </div>
                                        {{-- Footer Step 2 --}}
                                        <div id="footerStep2" style="display:none;">
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                id="btnBackToStep1"><i class="fa fa-arrow-left"></i> Kembali</button>
                                            <button type="button" class="btn btn-success btn-sm"
                                                id="btnSubmitUpdate">
                                                <i class="fa fa-upload"></i> Upload &amp; Update
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        {{-- END MODAL UPDATE DATA --}}

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
                    $('#excludeSiswa').slideDown();
                } else {
                    $('#excludeSiswa').slideUp();
                }
            });

            // ===== Modal Update Data =====

            // Reset modal saat dibuka
            $('#updateDataKartuModal').on('show.bs.modal', function () {
                $('#updateStep1').show();
                $('#updateStep2').hide();
                $('#updateStep3').hide();
                $('#footerStep1').show();
                $('#footerStep2').hide();
                $('#formUpdateKartu')[0].reset();
                $('.custom-file-label').text('Pilih file...');
            });

            // Update label file input
            $(document).on('change', '#fileUpdate', function () {
                var fileName = $(this).val().split('\\').pop();
                $(this).siblings('.custom-file-label').text(fileName || 'Pilih file...');
            });

            // Tombol Lanjut Import (Step 1 → Step 2)
            $('#btnGoToStep2').on('click', function () {
                $('#updateStep1').hide();
                $('#updateStep2').show();
                $('#footerStep1').hide();
                $('#footerStep2').show();
            });

            // Tombol Kembali (Step 2 → Step 1)
            $('#btnBackToStep1').on('click', function () {
                $('#updateStep2').show();
                $('#updateStep1').show();
                $('#updateStep2').hide();
                $('#footerStep2').hide();
                $('#footerStep1').show();
            });

            // Tombol Upload & Update (submit form)
            $('#btnSubmitUpdate').on('click', function () {
                var fileInput = $('#fileUpdate')[0];
                if (!fileInput.files.length) {
                    alert('Silakan pilih file Excel terlebih dahulu!');
                    return;
                }

                // Tampilkan loading
                $('#updateStep2').hide();
                $('#updateStep3').show();
                $('#footerStep2').hide();
                $('#btnCloseUpdateModal').hide();
                $('#updateStatusText').text('Mengunggah dan memproses data...');

                // Submit form
                $('#formUpdateKartu').submit();
            });
        });
    </script>
    
@endsection
