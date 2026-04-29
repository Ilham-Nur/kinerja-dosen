@extends('layouts.app')

@section('title', 'Dashboard Dosen')

@section('content')
<main class="page-content dashboard-page">
    <section class="dashboard-hero">
        <div>
            <p class="dashboard-hero-tag">Panel Dosen</p>
            <h1 class="page-header-title">Dashboard Kinerja Saya</h1>
            <p class="page-header-subtitle">Lihat progres pengisian dan status validasi kinerja Anda.</p>
        </div>
        <div class="hero-badge">
            <i class="fa-solid fa-user-check"></i>
            <span>{{ $total_kinerja }} Data Anda</span>
        </div>
    </section>

    <section class="dashboard-section">
        <h2 class="dashboard-section-title">Ringkasan Status</h2>
        <div class="dashboard-grid summary-grid">
            <article class="dashboard-card"><p>Total Kinerja</p><h3>{{ $total_kinerja }}</h3></article>
            <article class="dashboard-card status-pending"><p>Pending</p><h3>{{ $total_pending }}</h3></article>
            <article class="dashboard-card status-approved"><p>Approved</p><h3>{{ $total_approved }}</h3></article>
            <article class="dashboard-card status-rejected"><p>Rejected</p><h3>{{ $total_rejected }}</h3></article>
        </div>
    </section>

    <section class="dashboard-section">
        <h2 class="dashboard-section-title">Kinerja Per Kategori</h2>
        <div class="dashboard-grid category-grid">
            @foreach ($kategori as $nama => $jumlah)
                @php
                    $persentase = $total_kinerja > 0 ? round(($jumlah / $total_kinerja) * 100) : 0;
                @endphp
                <article class="dashboard-card category-card">
                    <div class="category-header">
                        <p>{{ $nama }}</p>
                        <strong>{{ $jumlah }}</strong>
                    </div>
                    <div class="progress-wrap">
                        <div class="progress-bar" style="width: {{ $persentase }}%"></div>
                    </div>
                    <small>{{ $persentase }}% kontribusi</small>
                </article>
            @endforeach
        </div>
    </section>

    <section class="dashboard-grid info-grid">
        <article class="dashboard-card info-card">
            <p>Kategori Paling Sering Diisi</p>
            <h3>{{ $kategori_teratas ?? '-' }}</h3>
            <small>Pertahankan konsistensi pelaporan Anda.</small>
        </article>
    </section>
</main>
@endsection
