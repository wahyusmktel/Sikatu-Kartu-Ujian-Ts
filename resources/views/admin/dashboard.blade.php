@extends('admin.layouts.app')

@section('page-title', 'Dashboard')

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
@endsection

@section('content')
<div class="row">
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body ">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="col col-stats ml-3 ml-sm-0">
                        <div class="numbers">
                            <p class="card-category">Total Siswa</p>
                            <h4 class="card-title">{{ number_format($totalSiswa) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-info bubble-shadow-small">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                    </div>
                    <div class="col col-stats ml-3 ml-sm-0">
                        <div class="numbers">
                            <p class="card-category">Total Rombel</p>
                            <h4 class="card-title">{{ number_format($totalRombel) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-success bubble-shadow-small">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </div>
                    <div class="col col-stats ml-3 ml-sm-0">
                        <div class="numbers">
                            <p class="card-category">Ujian Aktif</p>
                            <h4 class="card-title">{{ number_format($totalUjian) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-secondary bubble-shadow-small">
                            <i class="fas fa-id-card"></i>
                        </div>
                    </div>
                    <div class="col col-stats ml-3 ml-sm-0">
                        <div class="numbers">
                            <p class="card-category">Kartu Aktif</p>
                            <h4 class="card-title">{{ number_format($totalAktivasi) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-warning bubble-shadow-small">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                    <div class="col col-stats ml-3 ml-sm-0">
                        <div class="numbers">
                            <p class="card-category">Total Mapel CBT</p>
                            <h4 class="card-title">{{ number_format($totalMapel) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-danger bubble-shadow-small">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                    <div class="col col-stats ml-3 ml-sm-0">
                        <div class="numbers">
                            <p class="card-category">Generated CBT Users</p>
                            <h4 class="card-title">{{ number_format($totalCbtUser) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Core Workflow Guide -->
<div class="row">
    <div class="col-md-12">
        <div class="card card-round">
            <div class="card-header bg-gradient-red py-3">
                <div class="card-head-row">
                    <div class="card-title text-white">
                        <i class="fas fa-rocket mr-2"></i> Panduan Langkah Penggunaan Aplikasi
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-muted mb-4" style="font-size: 13px;">Ikuti langkah-langkah di bawah ini untuk memulai operasional ujian dengan benar dan terstruktur.</p>
                    </div>
                </div>
                <div class="row workflow-steps">
                    <!-- Step 1 -->
                    <div class="col-md-3 mb-4">
                        <div class="step-item text-center p-3 border rounded h-100">
                            <div class="step-number bg-danger text-white rounded-circle mx-auto mb-2" style="width: 30px; height: 30px; line-height: 30px;">1</div>
                            <i class="fas fa-file-excel fa-2x text-success mb-2"></i>
                            <h6 class="font-weight-bold">Import Siswa</h6>
                            <p class="text-muted small mb-0">Master Data <i class="fas fa-chevron-right mx-1"></i> Data Siswa</p>
                        </div>
                    </div>
                    <!-- Step 2 -->
                    <div class="col-md-3 mb-4">
                        <div class="step-item text-center p-3 border rounded h-100">
                            <div class="step-number bg-danger text-white rounded-circle mx-auto mb-2" style="width: 30px; height: 30px; line-height: 30px;">2</div>
                            <i class="fas fa-chalkboard-teacher fa-2x text-primary mb-2"></i>
                            <h6 class="font-weight-bold">Cek Rombel</h6>
                            <p class="text-muted small mb-0">Master Data <i class="fas fa-chevron-right mx-1"></i> Data Rombel</p>
                        </div>
                    </div>
                    <!-- Step 3 -->
                    <div class="col-md-3 mb-4">
                        <div class="step-item text-center p-3 border rounded h-100">
                            <div class="step-number bg-danger text-white rounded-circle mx-auto mb-2" style="width: 30px; height: 30px; line-height: 30px;">3</div>
                            <i class="fas fa-clipboard-check fa-2x text-info mb-2"></i>
                            <h6 class="font-weight-bold">Tambah Ujian</h6>
                            <p class="text-muted small mb-0">Master Data <i class="fas fa-chevron-right mx-1"></i> Data Ujian</p>
                        </div>
                    </div>
                    <!-- Step 4 -->
                    <div class="col-md-3 mb-4">
                        <div class="step-item text-center p-3 border rounded h-100">
                            <div class="step-number bg-danger text-white rounded-circle mx-auto mb-2" style="width: 30px; height: 30px; line-height: 30px;">4</div>
                            <i class="fas fa-toggle-on fa-2x text-success mb-2"></i>
                            <h6 class="font-weight-bold">Aktivasi Ujian</h6>
                            <p class="text-muted small mb-0">Aktifkan data ujian di halaman Data Ujian</p>
                        </div>
                    </div>
                    <!-- Step 5 -->
                    <div class="col-md-3 mb-4">
                        <div class="step-item text-center p-3 border rounded h-100">
                            <div class="step-number bg-danger text-white rounded-circle mx-auto mb-2" style="width: 30px; height: 30px; line-height: 30px;">5</div>
                            <i class="fas fa-id-card fa-2x text-warning mb-2"></i>
                            <h6 class="font-weight-bold">Generated Kartu</h6>
                            <p class="text-muted small mb-0">Ujian Sekolah <i class="fas fa-chevron-right mx-1"></i> Generated Kartu</p>
                        </div>
                    </div>
                    <!-- Step 6 (Optional) -->
                    <div class="col-md-3 mb-4">
                        <div class="step-item text-center p-3 border border-dashed rounded h-100">
                            <div class="step-number bg-secondary text-white rounded-circle mx-auto mb-2" style="width: 30px; height: 30px; line-height: 30px;">6</div>
                            <i class="fas fa-code fa-2x text-muted mb-2"></i>
                            <h6 class="font-weight-bold">Mapel CBT <small>(Optional)</small></h6>
                            <p class="text-muted small mb-0">Ujian Sekolah <i class="fas fa-chevron-right mx-1"></i> Data Mapel CBT</p>
                        </div>
                    </div>
                    <!-- Step 7 -->
                    <div class="col-md-3 mb-4">
                        <div class="step-item text-center p-3 border rounded h-100">
                            <div class="step-number bg-danger text-white rounded-circle mx-auto mb-2" style="width: 30px; height: 30px; line-height: 30px;">7</div>
                            <i class="fas fa-users-cog fa-2x text-primary mb-2"></i>
                            <h6 class="font-weight-bold">Generated Peserta</h6>
                            <p class="text-muted small mb-0">Ujian Sekolah <i class="fas fa-chevron-right mx-1"></i> Generated CBT</p>
                        </div>
                    </div>
                    <!-- Step 8 -->
                    <div class="col-md-3 mb-4">
                        <div class="step-item text-center p-3 border rounded h-100">
                            <div class="step-number bg-danger text-white rounded-circle mx-auto mb-2" style="width: 30px; height: 30px; line-height: 30px;">8</div>
                            <i class="fas fa-user-plus fa-2x text-info mb-2"></i>
                            <h6 class="font-weight-bold">Peserta Susulan</h6>
                            <p class="text-muted small mb-0">Ujian Sekolah <i class="fas fa-chevron-right mx-1"></i> Generated CBT Susulan</p>
                        </div>
                    </div>
                    <!-- Step 9 -->
                    <div class="col-md-6 mb-4">
                        <div class="step-item text-center p-3 border rounded h-100 bg-light">
                            <div class="step-number bg-danger text-white rounded-circle mx-auto mb-2" style="width: 30px; height: 30px; line-height: 30px;">9</div>
                            <i class="fas fa-id-badge fa-2x text-danger mb-2"></i>
                            <h6 class="font-weight-bold">Aktivasi Kartu Ujian</h6>
                            <p class="text-muted small mb-0">Aktivasi Kartu Ujian <i class="fas fa-chevron-right mx-1"></i> Aktifkan kartu peserta</p>
                        </div>
                    </div>
                    <!-- Step 10 -->
                    <div class="col-md-6 mb-4">
                        <div class="step-item text-center p-3 border rounded h-100 bg-light">
                            <div class="step-number bg-dark text-white rounded-circle mx-auto mb-2" style="width: 30px; height: 30px; line-height: 30px;">10</div>
                            <i class="fas fa-cog fa-2x text-dark mb-2"></i>
                            <h6 class="font-weight-bold">Pengaturan Aplikasi</h6>
                            <p class="text-muted small mb-0">Menu Settings <i class="fas fa-chevron-right mx-1"></i> Kustomisasi Aplikasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-red {
        background: linear-gradient(135deg, #da251d 0%, #a81c16 100%) !important;
    }
    .step-item {
        transition: all 0.3s ease;
        background: white;
    }
    .step-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        border-color: #da251d !important;
        cursor: help;
    }
    .border-dashed {
        border-style: dashed !important;
    }
    .workflow-steps h6 {
        font-size: 14px;
        margin-top: 10px;
    }
</style>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Siswa per Tingkat</div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="tingkatChart" style="width: 50%; height: 50%"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Statistik Aktivasi Kartu</div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="aktivasiChart" style="width: 50%; height: 50%"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Tingkat Chart (Pie)
        var ctxTingkat = document.getElementById('tingkatChart').getContext('2d');
        var tingkatChart = new Chart(ctxTingkat, {
            type: 'pie',
            data: {
                datasets: [{
                    data: {!! json_encode($tingkatData) !!},
                    backgroundColor :["#1d7af3","#f3545d","#fdaf4b","#59d05d", "#177dff"],
                    borderWidth: 0
                }],
                labels: {!! json_encode($tingkatLabels) !!}
            },
            options : {
                responsive: true, 
                maintainAspectRatio: false,
                legend: {
                    position : 'bottom',
                    labels : {
                        fontColor: 'rgb(154, 154, 154)',
                        fontSize: 11,
                        usePointStyle : true,
                        padding: 20
                    }
                },
                pieceLabel: {
                    render: 'value',
                    fontColor: 'white',
                    fontSize: 14,
                },
                tooltips: false,
                layout: {
                    padding: {
                        left: 20,
                        right: 20,
                        top: 20,
                        bottom: 20
                    }
                }
            }
        });

        // Aktivasi Chart (Bar)
        var ctxAktivasi = document.getElementById('aktivasiChart').getContext('2d');
        var aktivasiChart = new Chart(ctxAktivasi, {
            type: 'bar',
            data: {
                labels: ["Aktif", "Belum Aktif"],
                datasets: [{
                    label: "Jumlah Siswa",
                    backgroundColor: ["#59d05d", "#f3545d"],
                    borderColor: ["#59d05d", "#f3545d"],
                    data: [{{ $aktivasiOn }}, {{ $aktivasiOff }}],
                }],
            },
            options: {
                responsive: true, 
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    });
</script>
@endsection
