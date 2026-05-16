@extends('layouts.app')

@section('title', 'Edit Dosen')

@section('content')
<main class="page-content">
    <h1 class="kf-title">Edit Dosen</h1>

    <form data-confirm="true" data-confirm-title="Update Dosen?" data-confirm-body="Perubahan data dosen akan disimpan." action="{{ route('dosens.update', $dosen) }}" method="POST" class="kf-form">
        @csrf
        @method('PUT')

        <div class="field-group">
            <label for="nama">Nama</label>
            <input id="nama" name="nama" type="text" value="{{ old('nama', $dosen->nama) }}" required>
        </div>

        <div class="field-group">
            <label for="nuptk">NUPTK</label>
            <input id="nuptk" name="nuptk" type="text" value="{{ old('nuptk', $dosen->nuptk) }}" required>
        </div>

        <div class="field-group">
            <label for="jabatan_fungsional">Jabatan Fungsional</label>
            <input id="jabatan_fungsional" name="jabatan_fungsional" type="text" value="{{ old('jabatan_fungsional', $dosen->jabatan_fungsional) }}" required>
        </div>

        <div class="field-group">
            <label for="ikatan_kerja">Ikatan Kerja</label>
            <input id="ikatan_kerja" name="ikatan_kerja" type="text" value="{{ old('ikatan_kerja', $dosen->ikatan_kerja) }}" required>
        </div>

        @if (! $dosen->user)
            <label class="check-row" for="buat_akun">
                <input id="buat_akun" name="buat_akun" type="checkbox" value="1" {{ old('buat_akun') ? 'checked' : '' }}>
                <span>Buat akun user otomatis (username: NUPTK, password default: 123456)</span>
            </label>
        @else
            <div class="account-note">
                Akun terhubung: <strong>{{ $dosen->user->username }}</strong>. Nama dan username akun akan ikut diperbarui.
            </div>
        @endif

        <button type="submit" class="btn btn-primary kf-submit">Update Dosen</button>
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
    .account-note{background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:12px;color:#334155}
    .kf-submit{justify-content:center}
</style>
@include('kinerja-saya.partials.confirm-script')
@endsection
