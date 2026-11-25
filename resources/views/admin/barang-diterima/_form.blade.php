<div class="field">
    <label for="sumber_penerimaan">Sumber Penerimaan (Otomatis)</label>

    <input
        type="text"
        id="sumber_penerimaan"
        value="Langsung - Admin Kampus yang sedang login"
        readonly
    >

    <small style="color:#777;">
        Sistem mencatat identitas Admin berdasarkan akun yang sedang login.
    </small>
</div>

<div class="field">
    <label for="nama_publik">Nama Publik Barang *</label>

    <input
        type="text"
        id="nama_publik"
        name="nama_publik"
        value="{{ old('nama_publik', $barangTemuan->nama_publik ?? '') }}"
        maxlength="150"
        placeholder="Mis. Flashdisk 32GB"
        required
    >

    @error('nama_publik')
        <div class="error">{{ $message }}</div>
    @enderror
</div>

<div class="field">
    <label for="kategori">Kategori *</label>

    <input
        type="text"
        id="kategori"
        name="kategori"
        value="{{ old('kategori', $barangTemuan->kategori ?? '') }}"
        maxlength="80"
        placeholder="Mis. Elektronik"
        required
    >

    @error('kategori')
        <div class="error">{{ $message }}</div>
    @enderror
</div>

<div class="field">
    <label for="deskripsi_publik">Deskripsi Publik *</label>

    <textarea
        id="deskripsi_publik"
        name="deskripsi_publik"
        maxlength="1000"
        placeholder="Deskripsi umum tanpa membocorkan ciri khusus..."
        required
    >{{ old('deskripsi_publik', $barangTemuan->deskripsi_publik ?? '') }}</textarea>

    @error('deskripsi_publik')
        <div class="error">{{ $message }}</div>
    @enderror
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;">

    <div class="field">
        <label for="tanggal_ditemukan">Tanggal Ditemukan *</label>

        <input
            type="date"
            id="tanggal_ditemukan"
            name="tanggal_ditemukan"
            value="{{ old('tanggal_ditemukan', isset($barangTemuan) ? $barangTemuan->tanggal_ditemukan->format('Y-m-d') : '') }}"
            required
        >

        @error('tanggal_ditemukan')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="field">
        <label for="lokasi_ditemukan">Lokasi Ditemukan *</label>

        <input
            type="text"
            id="lokasi_ditemukan"
            name="lokasi_ditemukan"
            value="{{ old('lokasi_ditemukan', $barangTemuan->lokasi_ditemukan ?? '') }}"
            maxlength="180"
            placeholder="Mis. Kantin"
            required
        >

        @error('lokasi_ditemukan')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

</div>


<div class="field">
    <label for="foto">Foto Barang (maksimal 4 foto, masing-masing 5 MB)</label>
    <input type="file" id="foto" name="foto[]" accept="image/jpeg,image/png,image/webp" multiple>
    <small style="display:block;color:#666;margin-top:5px;">Format JPG, PNG, atau WebP. Foto yang sudah ada tetap dipertahankan.</small>
    @error('foto') <div class="error">{{ $message }}</div> @enderror
    @if(isset($barangTemuan) && $barangTemuan->foto->isNotEmpty())
        <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:10px;">
            @foreach($barangTemuan->foto as $fotoLama)
                <div style="width:110px;display:flex;flex-direction:column;align-items:stretch;gap:7px;">
                    <img src="{{ app(\App\Services\FileStorageService::class)->url($fotoLama->path_foto) }}" alt="Foto barang" style="width:110px;height:85px;object-fit:cover;border-radius:6px;border:1px solid #ddd;">
                    @if($fotoLama->is_utama)<small>Foto utama</small>@endif
                    <button type="submit" form="foto-utama-{{ $fotoLama->id_foto }}">Jadikan utama</button>
                    <button type="submit" form="hapus-foto-barang-{{ $fotoLama->id_foto }}" class="btn-delete" onclick="return confirm('Hapus foto ini saja? Data barang tidak akan dihapus.')">Hapus Foto</button>
                </div>
            @endforeach
        </div>
    @endif
</div>

<div class="actions">
    <button type="submit" class="primary">
        Simpan Barang
    </button>

    <a href="{{ route('admin.barang-diterima.index') }}" class="btn">
        Batal
    </a>
</div>
