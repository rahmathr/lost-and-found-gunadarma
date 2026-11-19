<style>
.satpam-form-page .satpam-field{margin-bottom:16px}.satpam-form-page .field-error{display:block;margin-top:5px;color:#b42318;font-size:12px}.satpam-form-page .field-help{display:block;margin-top:6px;color:#766b80;font-size:12px;line-height:1.45}.satpam-form-page .satpam-photo-grid{display:flex;flex-wrap:wrap;gap:12px;margin-top:12px}.satpam-form-page .satpam-photo-item{width:120px;display:flex;flex-direction:column;align-items:stretch;gap:7px}.satpam-form-page .satpam-photo-item img{width:120px;height:90px;object-fit:cover;border:1px solid #e1d6ec;border-radius:7px}.satpam-form-page .satpam-photo-item button{font-size:11px;padding:7px 8px;min-height:32px}
</style>
<div class="satpam-field">
    <label for="nama_publik">Nama Barang</label>

    <input
        type="text"
        name="nama_publik"
        id="nama_publik"
        value="{{ old('nama_publik', $barangTemuan->nama_publik ?? '') }}"
        maxlength="150"
        required>

    @error('nama_publik')
        <small>{{ $message }}</small>
    @enderror
</div>

<div class="satpam-field">
    <label for="kategori">Kategori Barang</label>

    <input
        type="text"
        name="kategori"
        id="kategori"
        value="{{ old('kategori', $barangTemuan->kategori ?? '') }}"
        maxlength="80"
        placeholder="Contoh: Elektronik, Aksesoris, Dokumen"
        required>

    @error('kategori')
        <small>{{ $message }}</small>
    @enderror
</div>

<div class="satpam-field">
    <label for="deskripsi_publik">Deskripsi Barang</label>

    <textarea
        name="deskripsi_publik"
        id="deskripsi_publik"
        rows="4">{{ old('deskripsi_publik', $barangTemuan->deskripsi_publik ?? '') }}</textarea>

    @error('deskripsi_publik')
        <small>{{ $message }}</small>
    @enderror
</div>

<div class="satpam-field">
    <label for="tanggal_ditemukan">Tanggal Ditemukan</label>

    <input
        type="date"
        name="tanggal_ditemukan"
        id="tanggal_ditemukan"
        value="{{ old('tanggal_ditemukan', isset($barangTemuan) ? $barangTemuan->tanggal_ditemukan->format('Y-m-d') : '') }}"
        required>

    @error('tanggal_ditemukan')
        <small>{{ $message }}</small>
    @enderror
</div>

<div class="satpam-field">
    <label for="lokasi_ditemukan">Lokasi Ditemukan</label>

    <input
        type="text"
        name="lokasi_ditemukan"
        id="lokasi_ditemukan"
        value="{{ old('lokasi_ditemukan', $barangTemuan->lokasi_ditemukan ?? '') }}"
        maxlength="180"
        required>

    @error('lokasi_ditemukan')
        <small>{{ $message }}</small>
    @enderror
</div>


<div class="satpam-field">
    <label for="foto">Foto Barang (maksimal 4 foto, masing-masing 5 MB)</label>
    <input type="file" name="foto[]" id="foto" accept="image/jpeg,image/png,image/webp" multiple>
    <small>Format JPG, PNG, atau WebP. Foto yang sudah ada tidak akan dihapus saat menambah foto baru.</small>
    @error('foto') <small>{{ $message }}</small> @enderror
    @if(isset($barangTemuan) && $barangTemuan->foto->isNotEmpty())
        <div>
            @foreach($barangTemuan->foto as $fotoLama)
                <div>
                    <img src="{{ asset('storage/'.$fotoLama->path_foto) }}" alt="Foto barang">
                    @if($fotoLama->is_utama)<small>Foto utama</small>@endif
                    <button type="submit" form="foto-utama-barang-{{ $fotoLama->id_foto }}">Jadikan utama</button>
                    <button type="submit" form="hapus-foto-barang-{{ $fotoLama->id_foto }}" class="btn-delete" onclick="return confirm('Hapus foto ini saja? Data barang tidak akan dihapus.')">Hapus Foto</button>
                </div>
            @endforeach
        </div>
    @endif
</div>

<button
    type="submit">

    {{ isset($barangTemuan) ? 'Simpan Perubahan' : 'Simpan Barang Temuan' }}

</button>

<a
    href="{{ route('satpam.barang-temuan.index') }}">
    Batal
</a>
