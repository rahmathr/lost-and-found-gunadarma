<div class="sa-form-grid">
    <div class="sa-field">
        <label for="nama_kampus">Nama Kampus</label>
        <input type="text" id="nama_kampus" name="nama_kampus" value="{{ old('nama_kampus', $kampus->nama_kampus ?? '') }}" required maxlength="150" placeholder="Masukkan nama kampus">
        @error('nama_kampus') <p class="sa-error">{{ $message }}</p> @enderror
    </div>
    <div class="sa-field">
        <label for="alamat">Alamat</label>
        <textarea id="alamat" name="alamat" maxlength="255" placeholder="Masukkan alamat kampus">{{ old('alamat', $kampus->alamat ?? '') }}</textarea>
        @error('alamat') <p class="sa-error">{{ $message }}</p> @enderror
    </div>
    <div class="sa-actions">
        <button type="submit" class="sa-btn sa-btn-primary">Simpan</button>
        <a href="{{ route('super-admin.kampus.index') }}" class="sa-btn sa-btn-secondary">Batal</a>
    </div>
</div>
