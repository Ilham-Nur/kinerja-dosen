@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<main class="page-content dashboard-page">
    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-header-title">Dashboard Admin</h1>
            <p class="page-header-subtitle">Ringkasan data kinerja seluruh dosen.</p>
        </div>
    </div>

    <section class="dashboard-grid summary-grid">
        <article class="dashboard-card"><p>Total Dosen</p><h3>{{ $total_dosen }}</h3></article>
        <article class="dashboard-card"><p>Total Kinerja</p><h3>{{ $total_semua_kinerja }}</h3></article>
        <article class="dashboard-card status-pending"><p>Pending</p><h3>{{ $total_pending }}</h3></article>
        <article class="dashboard-card status-approved"><p>Approved</p><h3>{{ $total_approved }}</h3></article>
        <article class="dashboard-card status-rejected"><p>Rejected</p><h3>{{ $total_rejected }}</h3></article>
    </section>

    <section class="dashboard-grid category-grid">
        @foreach ($kategori as $nama => $jumlah)
            <article class="dashboard-card"><p>{{ $nama }}</p><h3>{{ $jumlah }}</h3></article>
        @endforeach
    </section>

    <section class="dashboard-grid info-grid">
        <article class="dashboard-card info-card"><p>Kategori terbanyak</p><h3>{{ $kategori_terbanyak ?? '-' }}</h3></article>
        <article class="dashboard-card info-card"><p>Pending tertinggi</p><h3>{{ $pending_tertinggi ?? '-' }}</h3></article>
    </section>
</main>
@endsection
