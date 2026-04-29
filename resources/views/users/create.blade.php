@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<main class="page-content">
    <h1 class="kf-title">Tambah User</h1>

    <form action="{{ route('users.store') }}" method="POST" class="kf-form">
        @csrf

        <div class="field-group">
            <label for="name">Nama</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required>
        </div>

        <div class="field-group">
            <label for="username">Username</label>
            <input id="username" name="username" type="text" value="{{ old('username') }}" required>
        </div>

        <div class="field-group">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>
        </div>

        <div class="field-group">
            <label for="role">Role</label>
            <select id="role" name="role" required>
                <option value="">-- Pilih Role --</option>
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="dosen" {{ old('role') === 'dosen' ? 'selected' : '' }}>Dosen</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary kf-submit">Simpan User</button>
    </form>
</main>

<style>
    .kf-title{font-size:28px;font-weight:800;color:#0f172a;margin:0 0 14px}
    .kf-form{background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:18px;display:grid;gap:14px;max-width:760px}
    .field-group{display:grid;gap:8px}
    .field-group label{font-weight:700;color:#334155}
    .field-group input,.field-group select{width:100%;border:1px solid #cbd5e1;border-radius:10px;padding:10px 12px;font-size:14px;background:#fff}
    .kf-submit{justify-content:center}
</style>
@endsection
