@extends('layouts.app')

@section('title', 'Tambah Pengajaran')

@section('content')
<main class="page-content">
    <h1 class="kf-title">Input Pengajaran</h1>

    <form action="{{ route('kinerja-saya.store') }}" method="POST" class="kf-form">
        @csrf
        @include('kinerja-saya.partials.form-fields')
        <button type="submit" class="btn btn-primary kf-submit">Simpan Pengajaran</button>
    </form>
</main>
@include('kinerja-saya.partials.form-style')
@endsection
