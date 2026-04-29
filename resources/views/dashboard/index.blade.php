@extends('layouts.app')

@section('title', 'Dashboard — AdminPanel')

@section('content')
<main class="page-content">
    <nav class="breadcrumb" aria-label="Breadcrumb">
        <div class="breadcrumb-item"><a href="#">Home</a></div>
        <div class="breadcrumb-sep"><i class="fa-solid fa-chevron-right"></i></div>
        <div class="breadcrumb-item active">Dashboard</div>
    </nav>

    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-header-title">Dashboard</h1>
            <p class="page-header-subtitle">Selamat datang kembali, {{ auth()->user()->name }}. Berikut ringkasan hari ini.</p>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-icon blue"><i class="fa-solid fa-users"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Total Pengguna</div>
                <div class="stat-card-value">12,483</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon green"><i class="fa-solid fa-circle-dollar-to-slot"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Pendapatan</div>
                <div class="stat-card-value">Rp 284 Jt</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon yellow"><i class="fa-solid fa-bag-shopping"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Total Pesanan</div>
                <div class="stat-card-value">3,291</div>
            </div>
        </div>
    </div>
</main>
@endsection
