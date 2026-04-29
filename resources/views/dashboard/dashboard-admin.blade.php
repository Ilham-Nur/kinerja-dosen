@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<main class="page-content dashboard-page">
    <section class="dashboard-hero">
        <div>
            <p class="dashboard-hero-tag">Panel Admin</p>
            <h1 class="page-header-title">Dashboard Kinerja Dosen</h1>
            <p class="page-header-subtitle">Pantau performa, approval, dan distribusi kategori secara cepat.</p>
        </div>
        <div class="hero-badge">
            <i class="fa-solid fa-chart-line"></i>
            <span>{{ $total_semua_kinerja }} Total Data</span>
        </div>
    </section>

    <section class="dashboard-section">
        <h2 class="dashboard-section-title">Ringkasan Utama</h2>
        <div class="dashboard-grid summary-grid">
            <article class="dashboard-card"><p>Total Dosen</p><h3>{{ $total_dosen }}</h3></article>
            <article class="dashboard-card"><p>Total Kinerja</p><h3>{{ $total_semua_kinerja }}</h3></article>
            <article class="dashboard-card status-pending"><p>Pending</p><h3>{{ $total_pending }}</h3></article>
            <article class="dashboard-card status-approved"><p>Approved</p><h3>{{ $total_approved }}</h3></article>
            <article class="dashboard-card status-rejected"><p>Rejected</p><h3>{{ $total_rejected }}</h3></article>
        </div>
    </section>

    <section class="dashboard-section">
        <h2 class="dashboard-section-title">Distribusi Per Kategori</h2>
        <div class="dashboard-grid category-grid">
            @foreach ($kategori as $nama => $jumlah)
                @php
                    $persentase = $total_semua_kinerja > 0 ? round(($jumlah / $total_semua_kinerja) * 100) : 0;
                @endphp
                <article class="dashboard-card category-card">
                    <div class="category-header">
                        <p>{{ $nama }}</p>
                        <strong>{{ $jumlah }}</strong>
                    </div>
                    <div class="progress-wrap">
                        <div class="progress-bar" style="width: {{ $persentase }}%"></div>
                    </div>
                    <small>{{ $persentase }}% dari total kinerja</small>
                </article>
            @endforeach
        </div>
    </section>

    <section class="dashboard-grid info-grid">
        <article class="dashboard-card info-card">
            <p>Kategori Terbanyak</p>
            <h3>{{ $kategori_terbanyak ?? '-' }}</h3>
            <small>Ini kategori yang paling dominan saat ini.</small>
        </article>
        <article class="dashboard-card info-card">
            <p>Pending Tertinggi</p>
            <h3>{{ $pending_tertinggi ?? '-' }}</h3>
            <small>Fokuskan review untuk mempercepat approval.</small>
        </article>
    </section>

    <section class="dashboard-section">
        <h2 class="dashboard-section-title">Top Dosen Berdasarkan Upload Kinerja</h2>
        <article class="dashboard-card table-card">
            <div class="table-responsive">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Dosen</th>
                            <th>NUPTK</th>
                            <th>Total Upload</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($top_dosen_kinerja as $index => $dosen)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $dosen->nama }}</td>
                                <td>{{ $dosen->nuptk }}</td>
                                <td><span class="upload-badge">{{ $dosen->total_kinerja }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state">Belum ada data kinerja dosen.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>
    </section>
</main>
@endsection
