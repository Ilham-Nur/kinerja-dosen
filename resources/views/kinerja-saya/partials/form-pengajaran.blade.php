<div class="card">
  <div class="card-header"><div><div class="card-title">Input Pengajaran</div><div class="card-subtitle">Tambah data mata kuliah</div></div></div>
  <form method="POST" action="{{ route('kinerja-saya.store') }}" class="card-body">@csrf
    <div class="form-group"><label class="form-label">Mata Kuliah <span class="required">*</span></label><input name="mata_kuliah" class="form-control" required></div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
      <div class="form-group"><label class="form-label">SKS <span class="required">*</span></label><input name="sks" type="number" class="form-control" required></div>
      <div class="form-group"><label class="form-label">Semester <span class="required">*</span></label><select name="semester" class="form-control" required><option value="Ganjil">Ganjil</option><option value="Genap">Genap</option></select></div>
    </div>
    <div class="card-footer" style="padding:12px 0 0"><button class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Pengajaran</button></div>
  </form>
</div>
