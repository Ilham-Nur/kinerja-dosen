@extends('layouts.app')

@section('title', 'Kinerja Saya')

@section('content')
<main class="page-content">
    <div class="ks-header">
        <div>
            <h1 class="ks-title">Kinerja Saya</h1>
            <p class="ks-subtitle">Daftar pengajaran Anda.</p>
        </div>
        <a href="{{ route('kinerja-saya.create') }}" class="ks-btn ks-btn-primary">+ Tambah</a>
    </div>

    @if ($pengajarans->isEmpty())
        <div class="ks-empty">Belum ada data pengajaran.</div>
    @else
        <div class="ks-list">
            @foreach ($pengajarans as $pengajaran)
                <article class="ks-card">
                    <div class="ks-row">
                        <span class="ks-label">Mata Kuliah</span>
                        <span class="ks-value">{{ $pengajaran->mata_kuliah }}</span>
                    </div>
                    <div class="ks-row">
                        <span class="ks-label">SKS</span>
                        <span class="ks-value">{{ $pengajaran->sks }}</span>
                    </div>
                    <div class="ks-row">
                        <span class="ks-label">Semester</span>
                        <span class="ks-value">{{ $pengajaran->semester }}</span>
                    </div>
                    <div class="ks-row">
                        <span class="ks-label">Status</span>
                        <span class="ks-status ks-status-{{ $pengajaran->status }}">{{ ucfirst($pengajaran->status) }}</span>
                    </div>

                    <div class="ks-actions">
                        <button class="ks-btn ks-btn-outline" type="button" disabled>Edit</button>
                        <button class="ks-btn ks-btn-danger" type="button" disabled>Hapus</button>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</main>

<style>
    .ks-header { display:flex; gap:12px; justify-content:space-between; align-items:flex-start; margin-bottom:16px; }
    .ks-title { margin:0; font-size:24px; }
    .ks-subtitle { margin:8px 0 0; color:#6b7280; }
    .ks-list { display:grid; gap:14px; }
    .ks-card { width:100%; background:#fff; border:1px solid #e5e7eb; border-radius:14px; padding:16px; }
    .ks-row { display:flex; justify-content:space-between; gap:12px; margin-bottom:10px; }
    .ks-row:last-child { margin-bottom:0; }
    .ks-label { color:#6b7280; font-size:14px; }
    .ks-value { color:#111827; font-weight:600; text-align:right; }
    .ks-status { font-weight:700; text-transform:capitalize; padding:4px 10px; border-radius:999px; font-size:12px; }
    .ks-status-pending { background:#fef3c7; color:#92400e; }
    .ks-status-approved { background:#dcfce7; color:#166534; }
    .ks-status-rejected { background:#fee2e2; color:#991b1b; }
    .ks-actions { display:flex; gap:10px; margin-top:14px; }
    .ks-btn { border:none; border-radius:10px; padding:12px 14px; font-weight:700; text-align:center; text-decoration:none; font-size:14px; cursor:pointer; }
    .ks-btn-primary { background:#2563eb; color:#fff; }
    .ks-btn-outline { background:#f3f4f6; color:#374151; flex:1; }
    .ks-btn-danger { background:#ef4444; color:#fff; flex:1; }
    .ks-empty { background:#fff; border:1px dashed #d1d5db; border-radius:14px; padding:20px; color:#6b7280; }

    @media (max-width: 640px) {
        .ks-header { flex-direction:column; align-items:stretch; }
        .ks-btn-primary { width:100%; }
        .ks-btn { padding:14px; font-size:16px; }
    }
</style>
@endsection
