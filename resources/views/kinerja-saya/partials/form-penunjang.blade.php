<form method="POST" action="{{ route('kinerja-saya.penunjang.store') }}" class="card">@csrf
<h4>Form Penunjang</h4><input name="nama_kegiatan" placeholder="Nama kegiatan" required><input name="file" placeholder="File"><button class="btn btn-primary">Simpan</button></form>
