@extends('layouts.app')

@section('title', 'Kinerja Saya')

@section('content')
<main class="page-content">
    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-header-title">Kinerja Saya</h1>
            <p class="page-header-subtitle">Daftar pengajaran milik akun Anda.</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('kinerja-saya.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah</a>
        </div>
    </div>

    @if ($pengajarans->isEmpty())
        <div class="ks-empty">Belum ada data pengajaran.</div>
    @else
        <div class="table-wrapper ks-desktop">
            <table class="table table-striped">
                <thead>
                    <tr><th>Mata Kuliah</th><th>SKS</th><th>Semester</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @foreach ($pengajarans as $pengajaran)
                        <tr>
                            <td>{{ $pengajaran->mata_kuliah }}</td>
                            <td>{{ $pengajaran->sks }}</td>
                            <td>{{ $pengajaran->semester }}</td>
                            <td><span class="ks-status ks-status-{{ $pengajaran->status }}">{{ ucfirst($pengajaran->status) }}</span></td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('kinerja-saya.edit', $pengajaran) }}" class="btn btn-secondary">Edit</a>
                                    <form method="POST" action="{{ route('kinerja-saya.destroy', $pengajaran) }}" class="delete-form" data-mk="{{ $pengajaran->mata_kuliah }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="ks-mobile">
            @foreach ($pengajarans as $pengajaran)
                <article class="ks-card">
                    <div class="ks-row"><span>Mata Kuliah</span><strong>{{ $pengajaran->mata_kuliah }}</strong></div>
                    <div class="ks-row"><span>SKS</span><strong>{{ $pengajaran->sks }}</strong></div>
                    <div class="ks-row"><span>Semester</span><strong>{{ $pengajaran->semester }}</strong></div>
                    <div class="ks-row"><span>Status</span><span class="ks-status ks-status-{{ $pengajaran->status }}">{{ ucfirst($pengajaran->status) }}</span></div>
                    <div class="ks-actions">
                        <a href="{{ route('kinerja-saya.edit', $pengajaran) }}" class="btn btn-secondary">Edit</a>
                        <form method="POST" action="{{ route('kinerja-saya.destroy', $pengajaran) }}" class="delete-form" data-mk="{{ $pengajaran->mata_kuliah }}" style="width:100%;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="width:100%;">Hapus</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</main>

<style>
    .ks-desktop{display:none}.ks-mobile{display:grid;gap:14px}
    .ks-card{background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:16px}
    .ks-row{display:flex;justify-content:space-between;gap:8px;margin-bottom:10px}.ks-row:last-child{margin-bottom:0}
    .ks-actions{display:flex;gap:10px;margin-top:12px}.ks-actions .btn{flex:1;justify-content:center}
    .ks-status{padding:4px 10px;border-radius:999px;font-weight:700;font-size:12px;text-transform:capitalize}
    .ks-status-pending{background:#fef3c7;color:#92400e}.ks-status-approved{background:#dcfce7;color:#166534}.ks-status-rejected{background:#fee2e2;color:#991b1b}
    .ks-empty{background:#fff;border:1px dashed #d1d5db;border-radius:14px;padding:20px;color:#64748b}
    @media (min-width: 901px){.ks-desktop{display:block}.ks-mobile{display:none}}
</style>

<script>
document.addEventListener('DOMContentLoaded',()=>{
  document.querySelectorAll('.delete-form').forEach((form)=>{
    form.addEventListener('submit', async (event)=>{
      event.preventDefault();
      const mk = form.dataset.mk || 'data ini';
      const ok = await ConfirmDialog.show({
        title: 'Hapus Pengajaran?',
        body: `Data ${mk} akan dihapus permanen.`,
        type: 'danger',
        confirmText: 'Ya, Hapus',
        cancelText: 'Batal',
        confirmClass: 'btn-danger'
      });
      if (ok) form.submit();
    });
  });
});
</script>
@endsection
