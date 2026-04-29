@extends('layouts.app')

@section('title', 'Edit Pengajaran')

@section('content')
<main class="page-content">
    <h1 class="kf-title">Edit Pengajaran</h1>

    <form action="{{ route('kinerja-saya.update', $pengajaran) }}" method="POST" class="kf-form" id="editForm">
        @csrf
        @method('PUT')
        @include('kinerja-saya.partials.form-fields')
        <button type="submit" class="btn btn-primary kf-submit">Simpan Perubahan</button>
    </form>
</main>
@include('kinerja-saya.partials.form-style')
<script>
document.getElementById('editForm')?.addEventListener('submit', async (event) => {
  event.preventDefault();
  const ok = await ConfirmDialog.show({
    title: 'Simpan Perubahan?',
    body: 'Data pengajaran akan diperbarui dan status menjadi pending.',
    type: 'warning',
    confirmText: 'Ya, Simpan',
    cancelText: 'Batal',
    confirmClass: 'btn-primary'
  });
  if (ok) event.target.submit();
});
</script>
@endsection
