@extends('layouts.app')

@section('title', 'Tambah Pengajaran')

@section('content')
<main class="page-content">
    <h1 class="kf-title">Input Pengajaran</h1>

    <form action="{{ route('kinerja-saya.store') }}" method="POST" class="kf-form">
        @csrf

        <div class="kf-group">
            <label for="mata_kuliah" class="kf-label">Mata Kuliah</label>
            <input type="text" id="mata_kuliah" name="mata_kuliah" value="{{ old('mata_kuliah') }}" class="kf-input" required>
        </div>

        <div class="kf-group">
            <label for="sks" class="kf-label">SKS</label>
            <input type="number" id="sks" name="sks" value="{{ old('sks') }}" class="kf-input" required>
        </div>

        <div class="kf-group">
            <label for="semester" class="kf-label">Semester</label>
            <select id="semester" name="semester" class="kf-input" required>
                <option value="">Pilih Semester</option>
                <option value="Ganjil" @selected(old('semester') === 'Ganjil')>Ganjil</option>
                <option value="Genap" @selected(old('semester') === 'Genap')>Genap</option>
            </select>
        </div>

        <button type="submit" class="kf-submit">Simpan Pengajaran</button>
    </form>
</main>

<style>
    .kf-title { margin:0 0 16px; font-size:24px; }
    .kf-form { background:#fff; border:1px solid #e5e7eb; border-radius:14px; padding:16px; max-width:700px; }
    .kf-group { margin-bottom:14px; }
    .kf-label { display:block; margin-bottom:8px; font-weight:600; }
    .kf-input { width:100%; border:1px solid #d1d5db; border-radius:10px; padding:12px; font-size:15px; }
    .kf-submit { width:100%; border:none; background:#2563eb; color:#fff; border-radius:10px; padding:14px; font-size:16px; font-weight:700; }
</style>
@endsection
