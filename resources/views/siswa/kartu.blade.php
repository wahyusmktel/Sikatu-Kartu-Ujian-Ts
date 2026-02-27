@extends('siswa.layouts.app')

@section('page-title', 'Kartu Ujian')

@section('breadcrumbs')
    <li class="nav-home">
        <a href="/siswa/dashboard">
            <i class="flaticon-home"></i>
        </a>
    </li>
    <li class="separator">
        <i class="flaticon-right-arrow"></i>
    </li>
    <li class="nav-item">
        <a href="/siswa/kartu">Kartu Ujian</a>
    </li>
@endsection

@section('content')
    <div class="page-category">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                        
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Ujian</th>
                                    <th>Tanggal Download Kartu</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = ($kartuUjians->currentPage() - 1) * $kartuUjians->perPage() + 1; @endphp
                                @forelse($kartuUjians as $kartu)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $kartu->ujian->nama_ujian }}</td>
                                    <td>{{ $kartu->tgl_download_kartu }}</td>
                                    <td>
                                        @if($kartu->ujian->status)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-danger">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('kartu.cetak_siswa', $kartu->id_kartu) }}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-print"></i> Cetak</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    {{-- <td colspan="5">Belum ada data kartu ujian untuk ujian yang aktif. Silahkan Hubungi admin <a href="https://wa.me/6282372605566?text=Hai%2C%20Nama%20saya%20{{ $kartu->siswa->nama }}%20dari%20kelas%20{{ $kartu->siswa->rombel_saat_ini }}%20ingin%20melakukan%20aktivasi%20kartu%20ujian%20pada%20{{ $kartu->ujian->nama_ujian }}.%20Terimakasih.">Klik Disini</a></td> --}}
                                    <td colspan="5">
                                        Belum ada data kartu ujian untuk ujian yang aktif. 
                                        @php
                                            $adminWA = $setting->no_hp_admin ?? '6282372605566';
                                            $cleanWA = preg_replace('/[^0-9]/', '', $adminWA);
                                            // Handle leading 0 to 62 if needed
                                            if (strpos($cleanWA, '0') === 0) {
                                                $cleanWA = '62' . substr($cleanWA, 1);
                                            }
                                        @endphp
                                        @if($lastKartuForSiswa)
                                            Silahkan Hubungi admin <a href="https://wa.me/{{ $cleanWA }}?text=Hai%2C%20Nama%20saya%20{{ $lastKartuForSiswa->siswa->nama }}%20dari%20kelas%20{{ $lastKartuForSiswa->siswa->rombel_saat_ini }}%20ingin%20melakukan%20aktivasi%20kartu%20ujian%20pada%20{{ $lastKartuForSiswa->ujian->nama_ujian }}.%20Terimakasih.">Klik Disini</a>
                                        @else
                                            Silahkan Hubungi admin <a href="https://wa.me/{{ $cleanWA }}">Klik Disini</a> untuk informasi lebih lanjut.
                                        @endif
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        </div>
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
@endsection
