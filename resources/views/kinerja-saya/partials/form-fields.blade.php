<div class="kf-group">
    <label for="mata_kuliah" class="kf-label">Mata Kuliah</label>
    <input type="text" id="mata_kuliah" name="mata_kuliah" value="{{ old('mata_kuliah', $pengajaran->mata_kuliah ?? '') }}" class="kf-input" required>
</div>
<div class="kf-group">
    <label for="sks" class="kf-label">SKS</label>
    <input type="number" id="sks" name="sks" value="{{ old('sks', $pengajaran->sks ?? '') }}" class="kf-input" required>
</div>
<div class="kf-group">
    <label for="semester" class="kf-label">Semester</label>
    <select id="semester" name="semester" class="kf-input" required>
        <option value="">Pilih Semester</option>
        @foreach ($semesterOptions as $semester)
            <option value="{{ $semester }}" @selected(old('semester', $pengajaran->semester ?? '') === $semester)>{{ $semester }}</option>
        @endforeach
    </select>
</div>
