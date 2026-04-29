@extends('layouts.app')
@section('title','Edit')
@section('content')
<main class='page-content'>
  <h1 class='page-header-title'>Edit Data</h1>
  <div class='card'><form method='POST' enctype='multipart/form-data' class='card-body' action='{{ route('kinerja-saya.penunjang.update', $item) }}'>@csrf @method('PUT')
<div class='form-group'><label class='form-label'>Nama Kegiatan</label><input class='form-control' name='nama_kegiatan' value='{{ old('nama_kegiatan',$item->nama_kegiatan) }}' required></div><div class='form-group'><label class='form-label'>File Baru (opsional)</label><input type='file' name='file' class='form-control'></div><button class='btn btn-primary'>Simpan Perubahan</button></form></div></main>@endsection