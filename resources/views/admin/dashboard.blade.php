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
    <!-- Konten halaman dashboard Anda -->
    <p>Ini adalah konten dashboard.</p>
@endsection
