<div class="card" style="margin-top:16px;">
  <div class="card-header"><div><div class="card-title">Data Buku</div></div></div>
  <div class="table-wrapper">
    <table class="table table-striped">
      <thead><tr><th>Judul</th><th>ISBN</th><th>Tahun</th><th>Status</th><th>Aksi</th></tr></thead>
      <tbody>
      @forelse($bukus as $item)
        <tr>
          <td>{{ $item->judul }}</td><td>{{ $item->isbn }}</td><td>{{ $item->tahun }}</td><td><span class="badge {{ $item->status === 'approved' ? 'badge-success' : ($item->status === 'rejected' ? 'badge-danger' : 'badge-warning') }}">{{ ucfirst($item->status) }}</span></td>
          <td>@if($item->status === 'pending')<div class="table-actions"><a href="{{ route('kinerja-saya.buku.edit', $item) }}" class="btn btn-secondary">Edit</a><form data-confirm="true" data-confirm-type="danger" data-confirm-title="Hapus Data?" data-confirm-body="Data buku akan dihapus permanen." method="POST" action="{{ route('kinerja-saya.buku.destroy', $item) }}">@csrf @method('DELETE')<button class="btn btn-danger">Hapus</button></form></div>@else - @endif</td>
        </tr>
      @empty<tr><td colspan="5">Belum ada data.</td></tr>@endforelse
      </tbody>
    </table>
  </div>
</div>
