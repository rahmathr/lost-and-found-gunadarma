@extends('pelapor.layouts.app')

@section('title', 'Pengajuan Klaim Barang - Lost & Found Gundar')
@section('heading', 'Pengajuan Klaim Barang')
@section('active', 'barang')

@section('content')
<div class="pelapor-content-panel">

<div class="breadcrumb">
        Detail Barang &gt; Ajukan Klaim
    </div>

    <h2>Pengajuan Klaim Barang</h2>

    @if (session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    @if (session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert error">
            <strong>Periksa kembali formulir:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($sudahMengklaim)

        <div class="alert success">
            Kamu sudah pernah mengajukan klaim untuk barang ini.
            Status: <span class="status {{ match ($klaim->status) {
                'Disetujui', 'Diserahkan' => 'status-approved',
                'Ditolak' => 'status-rejected',
                'Menunggu Verifikasi' => 'status-pending',
                default => 'status-other',
            } }}">{{ $klaim->status }}</span>
        </div>

        @if($klaim->catatan_admin)
            <div class="alert error">
                <strong>Catatan Admin:</strong><br>
                {{ $klaim->catatan_admin }}
            </div>
        @endif

        @if($klaim->status === 'Perlu Bukti Tambahan')
            <section class="panel form-panel">
                <h3>Kirim Bukti Tambahan</h3>
                <p>Unggah bukti yang diminta Admin. Format JPG, PNG, atau PDF, maksimal 5 MB.</p>
                <form action="{{ route('pelapor.klaim.upload-bukti', $klaim->id_klaim) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="bukti_tambahan">File Bukti *</label>
                    <input type="file" id="bukti_tambahan" name="bukti_tambahan" accept=".jpg,.jpeg,.png,.pdf" required>
                    @error('bukti_tambahan')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                    <div class="buttons" style="margin-top:15px;">
                        <button type="submit" class="primary">Kirim Bukti Tambahan</button>
                    </div>
                </form>
            </section>
        @elseif($klaim->bukti_tambahan)
            <p>Bukti tambahan sudah dikirim dan menunggu pemeriksaan Admin.</p>
        @endif

        <a href="{{ route('pelapor.klaim.riwayat') }}" class="btn">
            Lihat Riwayat Klaim
        </a>

    @else

        <div class="content">

            <!-- Panel Barang yang Diklaim -->
            <section class="panel">

                <div class="panel-title">
                    Barang yang Diklaim
                </div>

                <div class="product-content">

                    <div class="product-image">
                        @php
                            $fotoUtama = $barangTemuan->foto->firstWhere('is_utama', true) ?? $barangTemuan->foto->first();
                        @endphp
                        @if ($fotoUtama)
                            <img
                                src="{{ asset('storage/' . $fotoUtama->path_foto) }}"
                                alt="Foto {{ $barangTemuan->nama_publik }}"
                                style="width:100%;height:100%;max-height:220px;object-fit:contain;border-radius:8px;"
                            >
                        @else
                            <span>Foto tidak tersedia</span>
                        @endif
                    </div>

                    <div class="product-name">
                        {{ $barangTemuan->nama_publik }}
                    </div>

                    <div class="product-info">
                        Kategori: {{ $barangTemuan->kategori }}<br>

                        Kampus:
                        {{ $barangTemuan->kampus->nama_kampus ?? '-' }}<br>

                        Ditemukan:
                        {{ $barangTemuan->tanggal_ditemukan->format('d M Y') }}<br>

                        Lokasi:
                        {{ $barangTemuan->lokasi_ditemukan }}
                    </div>

                </div>
            </section>

            <!-- Panel Formulir -->
            <section class="panel form-panel">

                <h3>Bukti Kepemilikan</h3>

                <form
                    action="{{ route('pelapor.klaim.store', $barangTemuan->id_barang) }}"
                    method="POST">

                    @csrf

                    <label for="keterangan_privat">
                        Keterangan Privat *
                    </label>

                    <textarea
                        name="keterangan_privat"
                        id="keterangan_privat"
                        minlength="10"
                        required
                        placeholder="Jelaskan ciri khusus, isi barang, atau detail lain yang hanya diketahui pemilik..."
                    >{{ old('keterangan_privat') }}</textarea>

                    @error('keterangan_privat')
                        <div class="field-error">{{ $message }}</div>
                    @enderror

                    <div class="info">
                        &#9432; Keterangan ini hanya dilihat Admin Kampus
                        untuk verifikasi dan tidak ditampilkan ke publik.
                    </div>

                    <label class="checkbox">
                        <input
                            type="checkbox"
                            name="persetujuan"
                            value="1"
                            required
                            @checked(old('persetujuan'))>

                        <span>
                            Saya menyatakan barang ini adalah milik saya
                            dan keterangan di atas benar.
                        </span>
                    </label>

                    @error('persetujuan')
                        <div class="field-error">{{ $message }}</div>
                    @enderror

                    <div class="buttons">

                        <button type="submit" class="primary">
                            Ajukan Klaim
                        </button>

                        <a
                            href="{{ route('pelapor.klaim.index') }}"
                            class="btn">
                            Batal
                        </a>

                    </div>

                </form>

            </section>

        </div>

    @endif

</div>
@endsection
