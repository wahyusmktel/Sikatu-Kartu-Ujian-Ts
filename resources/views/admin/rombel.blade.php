@extends('admin.layouts.app')

@section('page-title', 'Rombel')

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
        <a href="/admin/rombel">Rombel</a>
    </li>
@endsection

@section('content')
  <div class="page-category">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="pull-left">
                      <!-- Tombol Tambah Rombel -->
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahRombelModal">
                        Tambah Rombel
                      </button>
                      <!-- Modal Tambah Rombel -->
                      <div class="modal fade" id="tambahRombelModal" tabindex="-1" role="dialog" aria-labelledby="tambahRombelModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="tambahRombelModalLabel">Tambah Rombel</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form action="{{ route('admin.tambah_rombel') }}" method="post">
                                @csrf
                                <div class="form-group">
                                  <label for="nama_rombel">Nama Rombel</label>
                                  <input type="text" class="form-control" id="nama_rombel" name="nama_rombel" required>
                                </div>
                                <div class="form-group">
                                  <label for="tingkat_rombel">Tingkat Rombel</label>
                                  <select class="form-control" id="tingkat_rombel" name="tingkat_rombel" required>
                                    <option value="X">X</option>
                                    <option value="XI">XI</option>
                                    <option value="XII">XII</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label for="wali_kelas">Wali Kelas</label>
                                  <input type="text" class="form-control" id="wali_kelas" name="wali_kelas">
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                  <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="pull-right">
                      <div class="d-flex justify-content-between align-items-center">
                          <div class="collapse" id="search-nav">
                              <form class="navbar-form nav-search mr-md-3" action="{{ route('admin.rombel') }}" method="GET">
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
                              <th>Status</th>
                              <th>Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                          @php $no = 1; @endphp
                          @forelse($rombels as $rombel)
                          <tr>
                              <td>{{ $no++ }}</td>
                              <td>{{ $rombel->nama_rombel }}</td>
                              <td>{{ $rombel->tingkat_rombel }}</td>
                              <td>{{ $rombel->wali_kelas }}</td>
                              <td>{{ $rombel->status ? 'Aktif' : 'Tidak Aktif' }}</td>
                              <td>
                                  <!-- Tombol Detail -->
                                  <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal-{{ $rombel->id }}"><i class="fa fa-eye"></i> Detail</button>
              
                                  <!-- Modal Detail Rombel -->
                                  <div class="modal fade" id="detailModal-{{ $rombel->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel-{{ $rombel->id }}" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title" id="detailModalLabel-{{ $rombel->id }}">Detail Rombel: {{ $rombel->nama_rombel }}</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                  </button>
                                              </div>
                                              <div class="modal-body">
                                                  Nama Rombel: {{ $rombel->nama_rombel }}<br>
                                                  Tingkat Rombel: {{ $rombel->tingkat_rombel }}<br>
                                                  Wali Kelas: {{ $rombel->wali_kelas }}<br>
                                                  Status: {{ $rombel->status ? 'Aktif' : 'Tidak Aktif' }}<br>
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
                              <td colspan="6">Data rombel tidak ditemukan.</td>
                          </tr>
                          @endforelse
                      </tbody>
                  </table>
                  <!-- Paginasi -->
                  {{ $rombels->appends(['cari' => $cari])->links('vendor.pagination.custom') }}
              </div>              
            </div>
        </div>
    </div>
  </div>
@endsection
