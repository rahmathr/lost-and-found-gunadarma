@extends('admin.layouts.app')

@section('title', 'Detail dan Validasi Barang')
@section('heading', 'Detail dan Validasi Barang')

@section('pageStyles')
<style>

        .admin-kampus-admin-validasi-barang-show-blade-php .brand{
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 30px;
            padding: 5px;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .sidebar a:hover, .admin-kampus-admin-validasi-barang-show-blade-php .sidebar a.active{
            background: #3374c5;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .content{
            padding: 20px;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .grid{
            display: grid;
            grid-template-columns: 1.5fr 0.8fr;
            gap: 20px;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .panel{
            background: white;
            border: 1px solid #bbb;
            margin-bottom: 20px;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .panel-title{
            background: #eee;
            padding: 12px;
            border-bottom: 1px solid #bbb;
            font-weight: bold;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .panel-body{
            padding: 18px;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .detail-row{
            display: grid;
            grid-template-columns: 180px 1fr;
            border-bottom: 1px solid #eee;
            padding: 12px 0;
            font-size: 14px;
            gap: 10px;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .detail-label{
            font-weight: bold;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .description{
            border: 1px solid #ccc;
            padding: 15px;
            min-height: 100px;
            margin-top: 8px;
            white-space: pre-line;
            line-height: 1.5;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .status{
            display: inline-block;
            padding: 7px 12px;
            border: 1px solid;
            border-radius: 4px;
            font-size: 12px;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .waiting{
            background: #fff2cc;
            border-color: #e5b83b;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .checking{
            background: #e8d9f0;
            border-color: #a477c1;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .ready{
            background: #d9ead3;
            border-color: #70ad47;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .published{
            background: #d9eafc;
            border-color: #6d9eeb;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .rejected{
            background: #f4cccc;
            border-color: #cc6666;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .actions{
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php button, .admin-kampus-admin-validasi-barang-show-blade-php .btn{
            display: inline-block;
            padding: 11px 15px;
            border: 1px solid #777;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            font-size: 13px;
            background: white;
            color: #333;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .primary{
            background: #3374c5;
            border-color: #3374c5;
            color: white;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .danger{
            background: #dc2626;
            border-color: #dc2626;
            color: white;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .secondary{
            background: #666;
            border-color: #666;
            color: white;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .alert{
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .success{
            background: #dcfce7;
            color: #166534;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .error{
            background: #fee2e2;
            color: #991b1b;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .flow{
            line-height: 2;
            text-align: center;
            font-size: 13px;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .flow-step{
            padding: 8px;
            border: 1px solid #ccc;
            margin: 5px 0;
            border-radius: 4px;
        }

        .admin-kampus-admin-validasi-barang-show-blade-php .flow-current{
            background: #d9eafc;
            border-color: #3374c5;
            font-weight: bold;
        }

        @media (max-width: 800px) {

            .admin-kampus-admin-validasi-barang-show-blade-php .grid{
                grid-template-columns: 1fr;
            }

            .admin-kampus-admin-validasi-barang-show-blade-php .detail-row{
                grid-template-columns: 1fr;
            }
        }

</style>
@endsection

@section('content')
<div class="admin-kampus-page admin-kampus-admin-validasi-barang-show-blade-php">
<section class="content">

            @if (session('success'))
                <div class="alert success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert error">
                    {{ session('error') }}
                </div>
            @endif

            <p>
                <a
                    href="{{ route('admin.validasi-barang.index') }}"
                    class="btn secondary">
                    Kembali ke Antrean
                </a>
            </p>

            <div class="grid">

                <div>

                    <div class="panel">
                        <div class="panel-title">
                            Informasi Barang
                        </div>

                        <div class="panel-body">

                            <div class="detail-row">
                                <div class="detail-label">Nama Barang</div>
                                <div>{{ $barangTemuan->nama_publik }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="detail-label">Kategori</div>
                                <div>{{ $barangTemuan->kategori }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="detail-label">Kampus</div>
                                <div>{{ $barangTemuan->kampus->nama_kampus ?? '-' }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="detail-label">Sumber Penerimaan</div>
                                <div>
                                    @if ($barangTemuan->sumber_penerimaan === 'Satpam')
                                        Satpam -
                                        {{ $barangTemuan->satpam->nama ?? '-' }}
                                    @else
                                        Langsung -
                                        {{ $barangTemuan->adminPenerima->nama ?? '-' }}
                                    @endif
                                </div>
                            </div>

                            <div class="detail-row">
                                <div class="detail-label">Tanggal Ditemukan</div>
                                <div>
                                    {{ $barangTemuan->tanggal_ditemukan->format('d-m-Y') }}
                                </div>
                            </div>

                            <div class="detail-row">
                                <div class="detail-label">Lokasi Ditemukan</div>
                                <div>{{ $barangTemuan->lokasi_ditemukan }}</div>
                            </div>

                            <div style="margin-top:18px;">
                                <strong>Deskripsi Publik</strong>

                                <div class="description">
                                    {{ $barangTemuan->deskripsi_publik ?? 'Tidak ada deskripsi.' }}
                                </div>
                            </div>

                            <div style="margin-top:20px;">
                                <strong>Foto Barang</strong>

                                @if ($barangTemuan->foto->isNotEmpty())
                                    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:12px;margin-top:10px;">
                                        @foreach ($barangTemuan->foto as $foto)
                                            <div style="border:1px solid #ddd;border-radius:8px;padding:8px;background:#fff;">
                                                <img
                                                    src="{{ asset('storage/' . $foto->path_foto) }}"
                                                    alt="Foto {{ $barangTemuan->nama_publik }}"
                                                    style="display:block;width:100%;height:140px;object-fit:cover;border-radius:5px;">
                                                @if ($foto->is_utama)
                                                    <div style="margin-top:7px;font-size:12px;font-weight:600;color:#2563eb;">
                                                        Foto Utama
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p style="margin-top:8px;color:#777;">
                                        Belum ada foto barang yang diunggah.
                                    </p>
                                @endif
                            </div>

                            <div style="margin-top:20px;">
                                <strong>Status Barang</strong>
                                <br><br>

                                @php
                                    $statusClass = match ($barangTemuan->status) {
                                        'Diterima Satpam' => 'waiting',
                                        'Diterima Admin' => 'waiting',
                                        'Dalam Pemeriksaan' => 'checking',
                                        'Siap Dipublikasikan' => 'ready',
                                        'Dipublikasikan' => 'published',
                                        'Ditolak' => 'rejected',
                                        default => 'published',
                                    };
                                @endphp

                                <span class="status {{ $statusClass }}">
                                    {{ $barangTemuan->status }}
                                </span>
                            </div>

                            <div class="detail-row" style="margin-top:15px;">
                                <div class="detail-label">Admin Validator</div>
                                <div>
                                    {{ $barangTemuan->adminValidator->nama ?? 'Belum divalidasi' }}
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-title">
                            Tindakan Admin
                        </div>

                        <div class="panel-body">

                            @if (in_array($barangTemuan->status, ['Diterima Satpam', 'Diterima Admin'], true))

                                <p>
                                    Barang baru diterima dan menunggu pemeriksaan Admin Kampus.
                                </p>

                                <form
                                    action="{{ route('admin.validasi-barang.mulai-pemeriksaan', $barangTemuan->id_barang) }}"
                                    method="POST">

                                    @csrf

                                    <button type="submit" class="primary">
                                        Mulai Pemeriksaan
                                    </button>
                                </form>

                            @elseif ($barangTemuan->status === 'Dalam Pemeriksaan')

                                <p>
                                    Silakan periksa kesesuaian data barang dengan barang fisik.
                                </p>

                                <div class="actions">

                                    <form
                                        action="{{ route('admin.validasi-barang.siap-dipublikasikan', $barangTemuan->id_barang) }}"
                                        method="POST">

                                        @csrf

                                        <button type="submit" class="primary">
                                            Tandai Siap Dipublikasikan
                                        </button>
                                    </form>

                                    <form
                                        action="{{ route('admin.validasi-barang.tolak', $barangTemuan->id_barang) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menolak barang ini?')">

                                        @csrf

                                        <button type="submit" class="danger">
                                            Tolak Barang
                                        </button>
                                    </form>

                                </div>

                            @elseif ($barangTemuan->status === 'Siap Dipublikasikan')

                                <p>
                                    Barang sudah diperiksa dan siap ditampilkan kepada Pelapor.
                                </p>

                                <div class="actions">

                                    <form
                                        action="{{ route('admin.validasi-barang.publikasikan', $barangTemuan->id_barang) }}"
                                        method="POST"
                                        onsubmit="return confirm('Publikasikan barang ini?')">

                                        @csrf

                                        <button type="submit" class="primary">
                                            Publikasikan Barang
                                        </button>
                                    </form>

                                    <form
                                        action="{{ route('admin.validasi-barang.tolak', $barangTemuan->id_barang) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menolak barang ini?')">

                                        @csrf

                                        <button type="submit" class="danger">
                                            Tolak Barang
                                        </button>
                                    </form>

                                </div>

                            @elseif ($barangTemuan->status === 'Dipublikasikan')

                                <div class="alert success">
                                    Barang sudah dipublikasikan dan dapat dilihat oleh Pelapor.
                                </div>

                            @elseif ($barangTemuan->status === 'Ditolak')

                                <div class="alert error">
                                    Barang telah ditolak dan tidak akan ditampilkan kepada Pelapor.
                                </div>

                            @else

                                <p>
                                    Barang sudah melewati tahap validasi.
                                    Status saat ini: {{ $barangTemuan->status }}.
                                </p>

                            @endif

                        </div>
                    </div>

                </div>

                <div>

                    <div class="panel">
                        <div class="panel-title">
                            Alur Status Barang
                        </div>

                        <div class="panel-body">

                            <div class="flow">

                                <div class="flow-step {{ in_array($barangTemuan->status, ['Diterima Satpam', 'Diterima Admin'], true) ? 'flow-current' : '' }}">
                                    {{ $barangTemuan->sumber_penerimaan === 'Satpam' ? 'Diterima Satpam' : 'Diterima Admin' }}
                                </div>

                                ↓

                                <div class="flow-step {{ $barangTemuan->status === 'Dalam Pemeriksaan' ? 'flow-current' : '' }}">
                                    Dalam Pemeriksaan
                                </div>

                                ↓

                                <div class="flow-step {{ $barangTemuan->status === 'Siap Dipublikasikan' ? 'flow-current' : '' }}">
                                    Siap Dipublikasikan
                                </div>

                                ↓

                                <div class="flow-step {{ $barangTemuan->status === 'Dipublikasikan' ? 'flow-current' : '' }}">
                                    Dipublikasikan
                                </div>

                                <div style="margin-top:15px;color:#991b1b;">
                                    Jika tidak sesuai, Admin dapat menolak barang.
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-title">
                            Informasi Validasi
                        </div>

                        <div class="panel-body" style="font-size:13px;line-height:1.7;">
                            <ul>
                                <li>Periksa kelengkapan informasi barang.</li>
                                <li>Pastikan deskripsi publik tidak membocorkan ciri rahasia.</li>
                                <li>Pastikan barang sesuai dengan informasi yang dicatat.</li>
                                <li>Publikasikan hanya setelah pemeriksaan selesai.</li>
                            </ul>
                        </div>
                    </div>

                </div>

            </div>

        </section>

</div>
@endsection
