<div class="card"><div class="card-header"><div><div class="card-title">Input Penunjang</div><div class="card-subtitle">Tambah kegiatan penunjang</div></div></div>
<form data-confirm="true" data-confirm-title="Simpan Penunjang?" data-confirm-body="Data penunjang akan ditambahkan." method="POST" enctype="multipart/form-data" action="{{ route('kinerja-saya.penunjang.store') }}" class="card-body">@csrf
<div class="form-group"><label class="form-label">Nama Kegiatan <span class="required">*</span></label><input name="nama_kegiatan" class="form-control" required></div>
<div class="form-group"><label class="form-label">File</label><input name="file" type="file" class="form-control"></div>
<div class="card-footer" style="padding:12px 0 0"><button class="btn btn-primary">Simpan Penunjang</button></div></form></div>
