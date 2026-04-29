<form method="POST" action="{{ route('kinerja-saya.store') }}" class="card">@csrf
<h4>Form Pengajaran</h4>
<input name="mata_kuliah" placeholder="Mata kuliah" required>
<input name="sks" type="number" placeholder="SKS" required>
<select name="semester" required><option value="Ganjil">Ganjil</option><option value="Genap">Genap</option></select>
<button class="btn btn-primary">Simpan</button></form>
