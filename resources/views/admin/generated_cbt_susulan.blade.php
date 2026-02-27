@extends('admin.layouts.app')

@section('page-title', 'Generated CBT Susulan')

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
        <a href="/admin/generated_cbt_susulan">Generated CBT User Susulan</a>
    </li>
@endsection

@section('content')

    <div class="page-category">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="pull-left">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#generateModal">
                               <i class="fas fa-user-plus"></i> Generated User Susulan
                            </button>
                            <a href="{{ route('admin.export_cbt_csv_susulan') }}" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i> Export ke CSV</a>
                            <!-- Modal -->
                            <div class="modal fade" id="generateModal" tabindex="-1" role="dialog" aria-labelledby="generateModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="generateModalLabel">Generate CBT</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.generated_cbt_post_susulan') }}" method="POST" onsubmit="return confirmUpdate();">
                                                @csrf

                                                <div class="form-group">
                                                    <label for="address">Ruang</label>
                                                    <input type="text" class="form-control" id="address" name="address" placeholder="Masukan Kode Ruang">
                                                </div>

                                                <div class="form-group">
                                                    <label>Pilih Siswa</label>
                                                    <div class="select2-input">
                                                        <select id="multiple" name="siswa_ids[]" class="form-control" multiple="multiple">
                                                            <option value="">&nbsp;</option>
                                                            @foreach($allSiswa as $siswa)
                                                                <option value="{{ $siswa->id }}">{{ $siswa->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Generate</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pull-right">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="collapse" id="search-nav">
                                    <form class="navbar-form nav-search mr-md-3" action="{{ route('admin.generated_cbt_susulan') }}" method="GET">
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
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = ($users->currentPage() - 1) * $users->perPage() + 1;
                                @endphp
                                @foreach($users as $user)
                                    @php
                                        $names = explode(' ', $user->siswa->nama, 2);
                                        $firstname = $names[0];
                                        $lastname = isset($names[1]) ? $names[1] : $firstname;
                                    @endphp
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ sprintf('%05s', $user->kartuUjian->username_ujian) }}</td>
                                        <td>{{ sprintf('%05s', $user->kartuUjian->password_ujian) }}</td>
                                        <td>{{ $firstname }}</td>
                                        <td>{{ $lastname }}</td>
                                        <td>{{ $user->siswa['e-mail'] }}</td>
                                        <td>{{ $user->siswa->rombel->nama_rombel }}</td>
                                        <td>
                                            <!-- Tombol Detail -->
                                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal-{{ $user->id }}"><i class="fa fa-eye"></i> Detail</button>
                                        </td>
                                        @foreach($users as $user)
                                            <!-- Modal untuk user -->
                                            <div class="modal fade" id="detailModal-{{ $user->id }}" tabindex="-1" aria-labelledby="detailModalLabel-{{ $user->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="detailModalLabel-{{ $user->id }}">User Details</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Username: {{ $user->kartuUjian->username_ujian }} <br>
                                                            Password: {{ $user->kartuUjian->password_ujian }} <br>
                                                            Firstname: {{ explode(' ', $user->siswa->nama)[0] }} <br>
                                                            Lastname: {{ explode(' ', $user->siswa->nama)[1] ?? '' }} <br>
                                                            Email: {{ $user->siswa['e-mail'] }} <br>
                                                            Department: {{ $user->siswa->rombel->nama_rombel }} <br>
                                                            Address: {{ $user->address }} <br>
                                                            Course1: {{ $user->course1 }} <br>
                                                            Course2: {{ $user->course2 }} <br>
                                                            Course3: {{ $user->course3 }} <br>
                                                            Course4: {{ $user->course4 }} <br>
                                                            Course5: {{ $user->course5 }} <br>
                                                            Course6: {{ $user->course6 }} <br>
                                                            Course7: {{ $user->course7 }} <br>
                                                            Course8: {{ $user->course8 }} <br>
                                                            Course9: {{ $user->course9 }} <br>
                                                            Course10: {{ $user->course10 }} <br>
                                                            Course11: {{ $user->course11 }} <br>
                                                            Course12: {{ $user->course12 }} <br>
                                                            Course13: {{ $user->course13 }} <br>
                                                            Course14: {{ $user->course14 }} <br>
                                                            Course15: {{ $user->course15 }} <br>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Paginasi -->
                        {{ $users->appends(['cari' => $cari])->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#multiple').select2({
                theme: "bootstrap",
                width: '100%',
                placeholder: "Pilih Siswa",
            });

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
        function confirmUpdate() {
            return confirm("Apakah Anda yakin akan memperbaharui data?");
        }
    </script>



@endsection
