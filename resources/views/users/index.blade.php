@extends('layouts.app')

@section('title', 'Data User')

@section('content')
<main class="page-content">
    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-header-title">Data User</h1>
            <p class="page-header-subtitle">Kelola akun pengguna sistem.</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah User</a>
        </div>
    </div>

    @if ($users->isEmpty())
        <div class="ks-empty">Belum ada data user.</div>
    @else
        <div style="overflow-x:auto;">
            <table class="table table-striped" style="min-width:720px;">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Tanggal Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td><span class="badge-role">{{ ucfirst($user->role) }}</span></td>
                            <td>{{ $user->created_at?->format('d M Y H:i') ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</main>

<style>
    .ks-empty{background:#fff;border:1px dashed #d1d5db;border-radius:14px;padding:20px;color:#64748b}
    .badge-role{display:inline-block;background:#e2e8f0;color:#334155;border-radius:999px;padding:4px 10px;font-weight:700;font-size:12px}
</style>
@endsection
