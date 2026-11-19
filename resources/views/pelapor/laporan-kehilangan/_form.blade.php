<div class="form-group">
    <label for="id_kampus">Kampus tempat kehilangan *</label>

    <select name="id_kampus" id="id_kampus" required>
        <option value="">Pilih kampus</option>

        @foreach ($kampus as $item)
            <option
                value="{{ $item->id_kampus }}"
                @selected(old('id_kampus', $laporan->id_kampus ?? '') == $item->id_kampus)
            >
                {{ $item->nama_kampus }}
            </option>
        @endforeach
    </select>

    @error('id_kampus')
        <div class="field-error">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="nama_barang">Nama Barang *</label>

    <input
        type="text"
        name="nama_barang"
        id="nama_barang"
        value="{{ old('nama_barang', $laporan->nama_barang ?? '') }}"
        placeholder="Mis. Dompet kulit hitam"
        maxlength="150"
        required
    >

    @error('nama_barang')
        <div class="field-error">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="deskripsi">Deskripsi Barang *</label>

    <textarea
        name="deskripsi"
        id="deskripsi"
        placeholder="Warna, merek, ciri khusus, isi barang..."
        rows="4"
        required
    >{{ old('deskripsi', $laporan->deskripsi ?? '') }}</textarea>

    @error('deskripsi')
        <div class="field-error">{{ $message }}</div>
    @enderror
</div>

<div class="form-row">

    <div class="form-group">
        <label for="tanggal_hilang">Tanggal Hilang *</label>

        <input
            type="date"
            name="tanggal_hilang"
            id="tanggal_hilang"
            value="{{ old('tanggal_hilang', isset($laporan) ? $laporan->tanggal_hilang->format('Y-m-d') : '') }}"
            required
        >

        @error('tanggal_hilang')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="lokasi_hilang">Lokasi Hilang *</label>

        <input
            type="text"
            name="lokasi_hilang"
            id="lokasi_hilang"
            value="{{ old('lokasi_hilang', $laporan->lokasi_hilang ?? '') }}"
            placeholder="Mis. Perpustakaan Lt.2"
            maxlength="180"
            required
        >

        @error('lokasi_hilang')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

</div>

<div class="form-group">
    <label for="foto">Foto Barang (opsional, maksimal 4 foto)</label>
    <input type="file" name="foto[]" id="foto" accept="image/jpeg,image/png,image/webp" multiple>
    <small>Format JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB per foto.</small>
    @error('foto') <div class="field-error">{{ $message }}</div> @enderror
    @error('foto.*') <div class="field-error">{{ $message }}</div> @enderror

    @if(isset($laporan) && $laporan->foto->isNotEmpty())
        <div style="display:flex;flex-wrap:wrap;gap:12px;margin-top:12px;">
            @foreach($laporan->foto as $fotoLaporan)
                <div style="width:95px;display:flex;flex-direction:column;align-items:stretch;gap:7px;">
                    <a href="{{ route('pelapor.laporan-kehilangan.foto', ['id' => $laporan->id_laporan, 'foto' => $fotoLaporan->id_foto_laporan]) }}" target="_blank" rel="noopener" style="display:block;line-height:0;">
                        <img src="{{ route('pelapor.laporan-kehilangan.foto', ['id' => $laporan->id_laporan, 'foto' => $fotoLaporan->id_foto_laporan]) }}" alt="Foto barang hilang" style="width:95px;height:95px;object-fit:cover;border:1px solid #ccc;border-radius:5px;">
                    </a>
                    @if($laporan->status === 'Diajukan')
                        <button type="submit" form="hapus-foto-laporan-{{ $fotoLaporan->id_foto_laporan }}" class="btn-delete" onclick="return confirm('Hapus foto ini saja? Laporan tidak akan dihapus.')">Hapus Foto</button>
                    @endif
                </div>
            @endforeach
        </div>
        <small>Foto yang sudah ada tetap tersimpan. Unggah foto tambahan jika diperlukan.</small>
    @endif
</div>

<div class="form-actions">

    <button type="submit" class="button button-primary">
        {{ isset($laporan) ? 'Simpan Perubahan' : 'Simpan Laporan' }}
    </button>

    <a
        href="{{ route('pelapor.laporan-kehilangan.index') }}"
        class="button button-secondary"
    >
        Batal
    </a>

</div>
