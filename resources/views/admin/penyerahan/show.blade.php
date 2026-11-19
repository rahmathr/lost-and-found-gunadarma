@extends('admin.layouts.app')

@section('title', 'Proses Penyerahan Barang')
@section('heading', 'Proses Penyerahan Barang')

@section('pageStyles')
<style>

        .admin-kampus-admin-penyerahan-show-blade-php .container{
            max-width: 750px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
        }

        .admin-kampus-admin-penyerahan-show-blade-php .detail{
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }

        .admin-kampus-admin-penyerahan-show-blade-php .label{
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .admin-kampus-admin-penyerahan-show-blade-php textarea{
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
        }

        .admin-kampus-admin-penyerahan-show-blade-php button, .admin-kampus-admin-penyerahan-show-blade-php a{
            display: inline-block;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }

        .admin-kampus-admin-penyerahan-show-blade-php button{
            background: #16a34a;
            color: white;
        }

        .admin-kampus-admin-penyerahan-show-blade-php .secondary{
            background: #6b7280;
            color: white;
        }

        .admin-kampus-admin-penyerahan-show-blade-php .success{
            background: #dcfce7;
            color: #166534;
            padding: 12px;
        }

        .admin-kampus-admin-penyerahan-show-blade-php .error{
            color: #dc2626;
        }

</style>
@endsection

@section('content')
<div class="admin-kampus-page admin-kampus-admin-penyerahan-show-blade-php">
<div class="container">

    <h1>Proses Penyerahan Barang</h1>

    <p>Pastikan barang diserahkan kepada Pelapor yang benar.</p>

    <h2>Informasi Klaim</h2>

    <div class="detail">
        <span class="label">Tanggal Klaim</span>
        {{ $klaim->tanggal_klaim->format('d-m-Y H:i') }}
    </div>

    <div class="detail">
        <span class="label">Status Klaim</span>
        <span class="status {{ match ($klaim->status) {
            'Disetujui' => 'status-approved',
            'Ditolak' => 'status-rejected',
            'Menunggu Verifikasi' => 'status-pending',
            default => 'status-other',
        } }}">{{ $klaim->status }}</span>
    </div>

    <h2>Informasi Pelapor</h2>

    <div class="detail">
        <span class="label">Nama Pelapor</span>
        {{ $klaim->pelaporKehilangan->nama ?? '-' }}
    </div>

    <div class="detail">
        <span class="label">Email Pelapor</span>
        {{ $klaim->pelaporKehilangan->email ?? '-' }}
    </div>

    <h2>Informasi Barang</h2>

    <div class="detail">
        <span class="label">Nama Barang</span>
        {{ $klaim->barangDitemukan->nama_publik ?? '-' }}
    </div>

    <div class="detail">
        <span class="label">Kategori</span>
        {{ $klaim->barangDitemukan->kategori ?? '-' }}
    </div>

    <div class="detail">
        <span class="label">Lokasi Ditemukan</span>
        {{ $klaim->barangDitemukan->lokasi_ditemukan ?? '-' }}
    </div>

    <h2>Catat Penyerahan</h2>

    <p>
        Setelah barang benar-benar diserahkan kepada Pelapor,
        simpan catatan penyerahan berikut.
    </p>

    <form
        action="{{ route('admin.penyerahan.store', $klaim->id_klaim) }}"
        method="POST"
        onsubmit="return confirm('Pastikan barang sudah benar-benar diserahkan kepada Pelapor. Lanjutkan?')"
    >
        @csrf

        <label for="catatan">
            Catatan Penyerahan (opsional)
        </label>

        <br><br>

        <textarea
            id="catatan"
            name="catatan"
            rows="4"
            placeholder="Contoh: Barang diserahkan langsung kepada pemilik dengan menunjukkan identitas."
        >{{ old('catatan') }}</textarea>

        @error('catatan')
            <div class="error">{{ $message }}</div>
        @enderror

        <br><br>

        <button type="submit">
            Simpan Penyerahan
        </button>
    </form>

    <p style="margin-top:25px;">
        <a href="{{ route('admin.penyerahan.index') }}" class="secondary">
            Kembali ke Daftar
        </a>
    </p>

</div>

</div>
@endsection
