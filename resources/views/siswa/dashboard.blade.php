@extends('siswa.layouts.app')

@section('page-title', 'Dashboard')

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
        <a href="/siswa/dashboard">Dashboard</a>
    </li>
@endsection

@section('content')
    <!-- Konten halaman dashboard Anda -->
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
                                <p class="card-category">Total Siswa Aktif</p>
                                <h4 class="card-title">{{ $totalSiswa }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
