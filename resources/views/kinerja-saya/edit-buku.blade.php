@extends('layouts.app')
@section('title','Edit Buku')
@section('content')
<main class='page-content'><h1 class='page-header-title'>Edit Buku</h1>
<div class='card'><form data-confirm="true" data-confirm-title="Simpan Perubahan Buku?" data-confirm-body="Perubahan data buku akan disimpan." method='POST' enctype='multipart/form-data' class='card-body' action='{{ route('kinerja-saya.buku.update', $item) }}'>@csrf @method('PUT')
<div class='form-group'><label class='form-label'>Judul</label><input class='form-control' name='judul' value='{{ old('judul',$item->judul) }}' required></div><div class='form-group'><label class='form-label'>Tahun</label><input class='form-control' name='tahun' value='{{ old('tahun',$item->tahun) }}' required></div><div class='form-group'><label class='form-label'>Sumber Biaya</label><input class='form-control' name='sumber_biaya' value='{{ old('sumber_biaya',$item->sumber_biaya) }}' required></div><div class='form-group'><label class='form-label'>Jumlah Biaya</label><input class='form-control' name='jumlah_biaya' value='{{ old('jumlah_biaya',$item->jumlah_biaya) }}' required></div><div class='form-group'><label class='form-label'>Link</label><input class='form-control' name='link' value='{{ old('link',$item->link) }}'></div><div class='form-group'><label class='form-label'>File Baru (opsional)</label><input type='file' name='file' class='form-control'></div><button class='btn btn-primary'>Simpan Perubahan</button></form></div></main>
@include('kinerja-saya.partials.confirm-script')
@endsection
