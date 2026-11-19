@extends('admin.layouts.app')

@section('title', 'Catat & Validasi Barang Temuan')
@section('heading', 'Catat & Validasi Barang Temuan')

@section('pageStyles')
<style>

        .admin-kampus-admin-antrean-barang-form-blade-php .brand{
            margin-bottom: 30px;
            line-height: 1.5;
        }

        .admin-kampus-admin-antrean-barang-form-blade-php .brand strong{ display: block; }
        .admin-kampus-admin-antrean-barang-form-blade-php .brand small{ color: #ccc; }

        .admin-kampus-admin-antrean-barang-form-blade-php .sidebar a.active, .admin-kampus-admin-antrean-barang-form-blade-php .content{
            display: grid;
            grid-template-columns: 1.7fr 1fr;
            gap: 18px;
            padding: 20px;
        }

        .admin-kampus-admin-antrean-barang-form-blade-php .panel{
            border: 1px solid #bbb;
            padding: 18px;
        }

        .admin-kampus-admin-antrean-barang-form-blade-php .field{ margin-bottom: 16px; }

        .admin-kampus-admin-antrean-barang-form-blade-php label{
            display: block;
            margin-bottom: 7px;
            font-size: 12px;
        }

        .admin-kampus-admin-antrean-barang-form-blade-php input, .admin-kampus-admin-antrean-barang-form-blade-php select, .admin-kampus-admin-antrean-barang-form-blade-php textarea{
            width: 100%;
            padding: 10px;
            border: 1px solid #aaa;
            border-radius: 4px;
            font-family: Arial, sans-serif;
        }

        .admin-kampus-admin-antrean-barang-form-blade-php textarea{
            min-height: 90px;
            resize: vertical;
        }

        .admin-kampus-admin-antrean-barang-form-blade-php input[readonly]{
            background: #f5f5f5;
        }

        .admin-kampus-admin-antrean-barang-form-blade-php .right-column{
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .admin-kampus-admin-antrean-barang-form-blade-php .panel-title{
            margin: -18px -18px 15px;
            padding: 10px;
            background: #eee7f5;
            border-bottom: 1px solid #c9b2e6;
            font-size: 13px;
            font-weight: bold;
        }

        .admin-kampus-admin-antrean-barang-form-blade-php .check{
            display: flex;
            align-items: flex-start;
            gap: 9px;
            margin-bottom: 16px;
            font-size: 12px;
        }

        .admin-kampus-admin-antrean-barang-form-blade-php .check input{
            width: auto;
            margin-top: 1px;
        }

        .admin-kampus-admin-antrean-barang-form-blade-php .preview{
            border: 1px solid #ccc;
            padding: 10px;
        }

        .admin-kampus-admin-antrean-barang-form-blade-php .photo{
            height: 110px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #e8e8e8;
            border: 1px solid #bbb;
            color: #777;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .admin-kampus-admin-antrean-barang-form-blade-php .preview small{
            display: block;
            margin-top: 8px;
            color: #666;
        }

        .admin-kampus-admin-antrean-barang-form-blade-php .flow{
            text-align: center;
            font-size: 11px;
            line-height: 2;
        }

        .admin-kampus-admin-antrean-barang-form-blade-php .actions{
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 20px;
        }

        .admin-kampus-admin-antrean-barang-form-blade-php button, .admin-kampus-admin-antrean-barang-form-blade-php .button{
            padding: 11px 15px;
            border: 1px solid #555;
            border-radius: 4px;
            background: white;
            color: #333;
            text-decoration: none;
            cursor: pointer;
            font-size: 12px;
        }

        .admin-kampus-admin-antrean-barang-form-blade-php .primary{
            background: #7040a5;
            color: white;
            border-color: #7040a5;
            font-weight: bold;
        }

        .admin-kampus-admin-antrean-barang-form-blade-php .danger{
            background: #c9302c;
            color: white;
            border-color: #c9302c;
        }

        .admin-kampus-admin-antrean-barang-form-blade-php .alert{
            margin: 20px 20px 0;
            padding: 12px;
            background: #fee2e2;
            color: #991b1b;
        }

        .admin-kampus-admin-antrean-barang-form-blade-php .help{
            padding: 10px;
            margin-bottom: 15px;
            background: #f0e8f8;
            border: 1px solid #9bbde9;
            font-size: 12px;
        }

        @media (max-width: 950px) {
            .admin-kampus-admin-antrean-barang-form-blade-php .content{ grid-template-columns: 1fr; }
        }

</style>
@endsection

@section('content')
<div class="admin-kampus-page admin-kampus-admin-antrean-barang-form-blade-php">
<div class="main">

    <div class="topbar">
        <span>
            {{ $barangTemuan ? 'Catat & Validasi Barang Temuan' : 'Catat Barang Temuan' }}
        </span>

        <span class="user-info">
            Admin Kampus –
            {{ $admin->kampus->nama_kampus ?? 'Kampus' }}
            | {{ $admin->nama }}
        </span>
    </div>

    @if ($errors->any())
        <div class="alert">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="content">

        <div class="panel">

            @if ($barangTemuan)

                <div class="help">
                    Barang ini dicatat oleh Satpam. Periksa kelengkapan data,
                    kesesuaian fisik, dan keamanan deskripsi publik sebelum validasi.
                </div>

                <div class="field">
                    <label>Sumber Penerimaan</label>
                    <input
                        type="text"
                        value="Satpam - {{ $barangTemuan->satpam->nama ?? '-' }}"
                        readonly>
                </div>

                <div class="field">
                    <label>Nama Publik Barang</label>
                    <input value="{{ $barangTemuan->nama_publik }}" readonly>
                </div>

                <div class="field">
                    <label>Kategori</label>
                    <input value="{{ $barangTemuan->kategori }}" readonly>
                </div>

                <div class="field">
                    <label>Deskripsi Publik</label>
                    <textarea readonly>{{ $barangTemuan->deskripsi_publik }}</textarea>
                </div>

                <div class="field">
                    <label>Tanggal Ditemukan</label>
                    <input
                        value="{{ $barangTemuan->tanggal_ditemukan->format('d/m/Y') }}"
                        readonly>
                </div>

                <div class="field">
                    <label>Lokasi Ditemukan</label>
                    <input value="{{ $barangTemuan->lokasi_ditemukan }}" readonly>
                </div>

                <div class="field">
                    <label>Status Barang</label>
                    <input value="{{ $barangTemuan->status }}" readonly>
                </div>

                @if ($barangTemuan->status === 'Diterima Satpam')

                    <form
                        action="{{ route('admin.antrean-barang.validasi', $barangTemuan->id_barang) }}"
                        method="POST">

                        @csrf

                        <div class="actions">
                            <button type="submit" class="primary">
                                Tandai Siap Dipublikasikan
                            </button>
                        </div>

                        <div style="margin-top:18px;">
                            <label class="check">
                                <input type="checkbox" name="check_data" value="1" required>
                                Data barang lengkap
                            </label>

                            <label class="check">
                                <input type="checkbox" name="check_fisik" value="1" required>
                                Sesuai dengan barang fisik
                            </label>

                            <label class="check">
                                <input type="checkbox" name="check_privasi" value="1" required>
                                Deskripsi publik tidak membocorkan ciri khusus
                            </label>
                        </div>

                    </form>

                    <form
                        action="{{ route('admin.antrean-barang.tolak', $barangTemuan->id_barang) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menolak barang ini?')"
                        style="margin-top:10px;">

                        @csrf

                        <button type="submit" class="danger">
                            Tolak Barang
                        </button>

                    </form>

                @else

                    <div class="help">
                        Barang sudah diproses. Status saat ini:
                        <span class="status {{ match ($barangTemuan->status) {
                            'Ditolak' => 'status-rejected',
                            'Dipublikasikan', 'Diserahkan' => 'status-approved',
                            'Dalam Proses Penyerahan' => 'status-other',
                            'Diterima Satpam', 'Diterima Admin' => 'status-pending',
                            default => 'status-other',
                        } }}">{{ $barangTemuan->status }}</span>
                    </div>

                @endif

            @else

                <form
                    action="{{ route('admin.antrean-barang.store') }}"
                    method="POST">

                    @csrf

                    <div class="field">
                        <label>Sumber Penerimaan (otomatis)</label>
                        <input
                            type="text"
                            value="Langsung - {{ $admin->nama }}"
                            readonly>
                    </div>

                    <div class="field">
                        <label for="nama_publik">Nama Publik Barang *</label>
                        <input
                            type="text"
                            id="nama_publik"
                            name="nama_publik"
                            maxlength="150"
                            value="{{ old('nama_publik') }}"
                            placeholder="Mis. Flashdisk 32GB"
                            required>
                    </div>

                    <div class="field">
                        <label for="kategori">Kategori *</label>
                        <input
                            type="text"
                            id="kategori"
                            name="kategori"
                            maxlength="80"
                            value="{{ old('kategori') }}"
                            placeholder="Mis. Elektronik"
                            required>
                    </div>

                    <div class="field">
                        <label for="deskripsi_publik">Deskripsi Publik *</label>
                        <textarea
                            id="deskripsi_publik"
                            name="deskripsi_publik"
                            required
                            placeholder="Deskripsi umum tanpa membocorkan ciri khusus">{{ old('deskripsi_publik') }}</textarea>
                    </div>

                    <div class="field">
                        <label for="tanggal_ditemukan">Tanggal Ditemukan *</label>
                        <input
                            type="date"
                            id="tanggal_ditemukan"
                            name="tanggal_ditemukan"
                            value="{{ old('tanggal_ditemukan') }}"
                            required>
                    </div>

                    <div class="field">
                        <label for="lokasi_ditemukan">Lokasi Ditemukan *</label>
                        <input
                            type="text"
                            id="lokasi_ditemukan"
                            name="lokasi_ditemukan"
                            maxlength="180"
                            value="{{ old('lokasi_ditemukan') }}"
                            placeholder="Mis. Kantin"
                            required>
                    </div>

                    <div class="help">
                        Status barang yang diterima langsung oleh Admin akan
                        menjadi <strong>Dipublikasikan</strong> setelah disimpan.
                    </div>

                    <div class="actions">
                        <button type="submit" class="primary">
                            Simpan Barang
                        </button>

                        <a
                            href="{{ route('admin.antrean-barang.index') }}"
                            class="button">
                            Batal
                        </a>
                    </div>

                </form>

            @endif

        </div>

        <div class="right-column">

            @if ($barangTemuan && $barangTemuan->status === 'Diterima Satpam')

                <div class="panel">
                    <div class="panel-title">Checklist Validasi</div>

                    <p style="font-size:12px;">
                        Centang seluruh checklist di formulir setelah memastikan
                        kondisi barang dan informasi yang dicatat sudah benar.
                    </p>
                </div>

            @endif

            <div class="panel">

                <div class="panel-title">Pratinjau Tampilan Publik</div>

                <div class="preview">

                    <div class="photo">Foto Barang</div>

                    <strong>
                        {{ $barangTemuan->nama_publik ?? 'Nama Barang' }}
                    </strong>

                    <small>
                        {{ $barangTemuan->kategori ?? 'Kategori' }}
                        -
                        {{ $admin->kampus->nama_kampus ?? 'Kampus' }}
                    </small>

                    <small>
                        Ditemukan:
                        {{ $barangTemuan
                            ? $barangTemuan->tanggal_ditemukan->format('d M Y')
                            : 'Tanggal belum diisi' }}
                    </small>

                    <small>
                        Lokasi:
                        {{ $barangTemuan->lokasi_ditemukan ?? 'Lokasi belum diisi' }}
                    </small>

                    <p>
                        <span class="status approved">
                            {{ $barangTemuan->status ?? 'Siap Dipublikasikan' }}
                        </span>
                    </p>

                </div>

            </div>

            <div class="panel">

                <div class="panel-title">Alur Status Barang</div>

                <div class="flow">
                    Diterima Satpam / Diterima Admin
                    <br>↓<br>
                    Dalam Pemeriksaan
                    <br>↓<br>
                    Siap Dipublikasikan
                    <br>↓<br>
                    Dipublikasikan → Diserahkan
                </div>

                <p style="font-size:11px;color:#777;">
                    Alur di atas merupakan gambaran proses. Status yang disimpan
                    aplikasi mengikuti nilai status database.
                </p>

            </div>

        </div>

    </div>
</div>

</div>
@endsection
