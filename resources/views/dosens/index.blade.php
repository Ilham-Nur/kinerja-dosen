@extends('layouts.app')

@section('title', 'Data Dosen')

@section('content')
<main class="page-content">
    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-header-title">Data Dosen</h1>
            <p class="page-header-subtitle">Kelola data dosen dan status akun pengguna.</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('dosens.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah</a>
        </div>
    </div>

    @if ($dosens->isEmpty())
        <div class="ks-empty">Belum ada data dosen.</div>
    @else
        <div style="overflow-x:auto;">
            <table class="table table-striped" style="min-width:780px;">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NUPTK</th>
                        <th>Jabatan</th>
                        <th>Status Akun</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dosens as $dosen)
                        <tr>
                            <td>{{ $dosen->nama }}</td>
                            <td>{{ $dosen->nuptk }}</td>
                            <td>{{ $dosen->jabatan_fungsional }}</td>
                            <td>
                                @if ($dosen->user)
                                    <span class="status status-ok">Sudah punya akun</span>
                                @else
                                    <span class="status status-pending">Belum punya akun</span>
                                @endif
                            </td>
                            <td>
                                <div class="table-actions">
                                    <button type="button" class="btn btn-secondary" disabled>Edit</button>
                                    <button type="button" class="btn btn-danger" disabled>Hapus</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</main>

<style>
    .status{padding:4px 10px;border-radius:999px;font-weight:700;font-size:12px}
    .status-ok{background:#dcfce7;color:#166534}
    .status-pending{background:#fef3c7;color:#92400e}
    .ks-empty{background:#fff;border:1px dashed #d1d5db;border-radius:14px;padding:20px;color:#64748b}
</style>
@endsection
