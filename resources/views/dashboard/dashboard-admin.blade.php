@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<main class="page-content dashboard-page dashboard-page-compact">
    <section class="dashboard-hero compact-hero">
        <div>
            <p class="dashboard-hero-tag">Panel Admin</p>
            <h1 class="page-header-title">Dashboard Ringkas Kinerja Dosen</h1>
        </div>
        <div class="hero-badge">
            <i class="fa-solid fa-chart-line"></i>
            <span>{{ $total_semua_kinerja }} Total Data</span>
        </div>
    </section>

    <section class="dashboard-grid compact-summary-grid">
        <article class="dashboard-card compact-card"><p>Dosen</p><h3>{{ $total_dosen }}</h3></article>
        <article class="dashboard-card compact-card"><p>Kinerja</p><h3>{{ $total_semua_kinerja }}</h3></article>
        <article class="dashboard-card compact-card status-pending"><p>Pending</p><h3>{{ $total_pending }}</h3></article>
        <article class="dashboard-card compact-card status-approved"><p>Approved</p><h3>{{ $total_approved }}</h3></article>
        <article class="dashboard-card compact-card status-rejected"><p>Rejected</p><h3>{{ $total_rejected }}</h3></article>
    </section>

    <section class="dashboard-grid compact-main-grid">
        <article class="dashboard-card compact-card">
            <div class="mini-head">
                <h2 class="dashboard-section-title">Kategori</h2>
                <small>Jumlah data</small>
            </div>
            <ul class="mini-list">
                @foreach ($kategori as $nama => $jumlah)
                    <li><span>{{ $nama }}</span><strong>{{ $jumlah }}</strong></li>
                @endforeach
            </ul>
        </article>

        <article class="dashboard-card compact-card">
            <div class="mini-head">
                <h2 class="dashboard-section-title">Insight</h2>
            </div>
            <ul class="mini-list info-list">
                <li><span>Kategori terbanyak</span><strong>{{ $kategori_terbanyak ?? '-' }}</strong></li>
                <li><span>Pending tertinggi</span><strong>{{ $pending_tertinggi ?? '-' }}</strong></li>
            </ul>
        </article>

        <article class="dashboard-card compact-card top-dosen-card">
            <div class="mini-head">
                <h2 class="dashboard-section-title">Top Upload Dosen</h2>
                <small>Top 5</small>
            </div>
            <ol class="rank-list">
                @forelse ($top_dosen_kinerja->take(5) as $dosen)
                    <li>
                        <div>
                            <p>{{ $dosen->nama }}</p>
                            <small>{{ $dosen->nuptk }}</small>
                        </div>
                        <span class="upload-badge">{{ $dosen->total_kinerja }}</span>
                    </li>
                @empty
                    <li class="empty-state">Belum ada data kinerja dosen.</li>
                @endforelse
            </ol>
        </article>
    </section>
</main>
@endsection
