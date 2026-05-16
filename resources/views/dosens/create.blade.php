@extends('layouts.app')

@section('title', 'Tambah Dosen')

@section('content')
<main class="page-content">
    <h1 class="kf-title">Tambah Dosen</h1>

    <form action="{{ route('dosens.store') }}" method="POST" class="kf-form">
        @csrf

        <div class="field-group">
            <label for="nama">Nama</label>
            <input id="nama" name="nama" type="text" value="{{ old('nama') }}" required>
        </div>

        <div class="field-group">
            <label for="nuptk">NUPTK</label>
            <input id="nuptk" name="nuptk" type="text" value="{{ old('nuptk') }}" required>
        </div>

        <div class="field-group">
            <label for="jabatan_fungsional">Jabatan Fungsional</label>
            <input id="jabatan_fungsional" name="jabatan_fungsional" type="text" value="{{ old('jabatan_fungsional') }}" required>
        </div>

        <div class="field-group">
            <label for="ikatan_kerja">Ikatan Kerja</label>
            <input id="ikatan_kerja" name="ikatan_kerja" type="text" value="{{ old('ikatan_kerja') }}" required>
        </div>

        <label class="check-row" for="buat_akun">
            <input name="buat_akun" type="hidden" value="0">
            <input id="buat_akun" name="buat_akun" type="checkbox" value="1" {{ old('buat_akun', '1') ? 'checked' : '' }}>
            <span>Buat akun user otomatis (username: NUPTK, password default: 123456)</span>
        </label>

        <button type="submit" class="btn btn-primary kf-submit">Simpan Dosen</button>
    </form>
</main>

<style>
    .kf-title{font-size:28px;font-weight:800;color:#0f172a;margin:0 0 14px}
    .kf-form{background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:18px;display:grid;gap:14px;max-width:760px}
    .field-group{display:grid;gap:8px}
    .field-group label{font-weight:700;color:#334155}
    .field-group input{width:100%;border:1px solid #cbd5e1;border-radius:10px;padding:10px 12px;font-size:14px}
    .check-row{display:flex;align-items:flex-start;gap:10px;color:#334155}
    .check-row input{margin-top:4px}
    .kf-submit{justify-content:center}
</style>
@endsection
