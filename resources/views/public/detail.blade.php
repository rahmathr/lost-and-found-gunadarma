<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $barang->nama_publik }} - Lost & Found Gundar</title>

    <style>

        :root {
            --brand: #7040a5;
            --brand-dark: #5b3289;
            --brand-soft: #eee7f5;
            --brand-pale: #f7f4fa;
            --text: #292333;
            --muted: #6f6878;
            --border: #ddd6e5;
            --surface: #ffffff;
            --radius: 8px;
            --shadow: 0 2px 10px rgba(43, 28, 61, .06);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: var(--text);
            background: #fff;
            font-size: 14px;
            line-height: 1.5;
        }

        .navbar {
            min-height: 64px;
            display: flex;
            align-items: center;
            padding: 8px clamp(16px, 2.2vw, 32px);
            background: var(--brand-soft);
            border: 0;
            border-bottom: 1px solid var(--border);
            gap: 12px;
        }

        .logo {
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
        }

        .logo img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .brand {
            margin-left: 0;
            font-size: 18px;
            font-weight: 700;
            white-space: nowrap;
            color: var(--text);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: clamp(18px, 3.2vw, 46px);
            margin-left: auto;
        }

        .nav-links a {
            color: var(--text);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            white-space: nowrap;
            transition: color .18s ease, background .18s ease;
        }

        .nav-links a:hover,
        .nav-links a.active { color: var(--brand); }

        .nav-links a.active { font-weight: 700; }

        .nav-links .register-button {
            padding: 10px 20px;
            border-radius: 6px;
            background: var(--brand);
            color: #fff;
            font-weight: 700;
        }

        .nav-links .register-button:hover {
            background: var(--brand-dark);
            color: #fff;
        }

        .breadcrumb {
            width: calc(100% - 40px);
            max-width: 1440px;
            margin: 18px auto 20px;
            color: var(--muted);
            font-size: 13px;
            overflow-wrap: anywhere;
        }

        .breadcrumb a:hover { color: var(--brand); }

        .detail-container {
            display: grid;
            grid-template-columns: minmax(0, .95fr) minmax(0, 1.05fr);
            align-items: start;
            gap: clamp(24px, 3vw, 40px);
            width: calc(100% - 40px);
            max-width: 1440px;
            margin: 0 auto 40px;
        }

        .detail-container > section { min-width: 0; }

        .main-photo {
            width: 100%;
            aspect-ratio: 4 / 3;
            height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            background: var(--brand-pale);
            color: var(--muted);
            font-size: 14px;
        }

        .main-photo img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: var(--brand-pale);
        }

        .thumbnail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(92px, 1fr));
            gap: 10px;
            margin-top: 12px;
        }

        .thumbnail {
            width: 100%;
            aspect-ratio: 1 / 1;
            height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 6px;
            background: var(--brand-pale);
            color: var(--muted);
            font-size: 12px;
        }

        .thumbnail img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .detail-info h1 {
            margin: 0 0 12px;
            color: var(--text);
            font-size: clamp(22px, 2.2vw, 28px);
            line-height: 1.25;
            overflow-wrap: anywhere;
        }

        .status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 120px;
            min-height: 30px;
            padding: 5px 12px;
            margin-bottom: 18px;
            border: 1px solid #75ad66;
            border-radius: 5px;
            background: #e4f1df;
            color: #426a37;
            text-align: center;
            font-size: 12px;
            font-weight: 600;
        }

        .information-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            font-size: 14px;
        }

        .information-table th,
        .information-table td {
            padding: 11px 12px;
            border: 1px solid var(--border);
            text-align: left;
            vertical-align: top;
            overflow-wrap: anywhere;
        }

        .information-table th {
            width: 32%;
            background: var(--brand-soft);
            color: var(--text);
            font-weight: 700;
        }

        .information-table td { background: #fff; }

        .description-title {
            margin: 16px 0 8px;
            color: var(--text);
            font-size: 15px;
        }

        .description {
            min-height: 76px;
            padding: 13px 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            background: #fff;
            font-size: 14px;
            line-height: 1.65;
            overflow-wrap: anywhere;
        }

        .privacy-note {
            margin-top: 14px;
            padding: 13px 14px;
            border: 1px solid #c9b2e6;
            border-radius: 6px;
            background: var(--brand-pale);
            color: #51435f;
            font-size: 13px;
            line-height: 1.6;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 18px;
        }

        .action-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 10px 16px;
            border: 1px solid #756d7d;
            border-radius: 6px;
            color: var(--text);
            background: #fff;
            text-align: center;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: color .18s ease, border-color .18s ease, background .18s ease;
        }

        .action-primary {
            border-color: var(--brand);
            background: var(--brand);
            color: #fff;
        }

        .action-primary:hover {
            border-color: var(--brand-dark);
            background: var(--brand-dark);
        }

        .action-secondary:hover {
            border-color: var(--brand);
            background: var(--brand-pale);
            color: var(--brand);
        }

        .login-note {
            margin: 16px 2px 0;
            color: var(--muted);
            font-size: 12px;
        }

        @media (max-width: 900px) {
            .detail-container {
                grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
                gap: 22px;
            }

            .information-table { font-size: 13px; }
            .information-table th,
            .information-table td { padding: 9px 10px; }
        }

        @media (max-width: 700px) {
            .navbar {
                min-height: 0;
                padding: 10px 14px;
                flex-wrap: wrap;
            }

            .logo { width: 36px; height: 36px; flex-basis: 36px; }
            .brand { font-size: 16px; }

            .nav-links {
                width: 100%;
                justify-content: space-between;
                gap: 10px;
                margin: 6px 0 0;
            }

            .nav-links a { font-size: 12px; }
            .nav-links .register-button { padding: 8px 12px; }

            .breadcrumb {
                width: calc(100% - 28px);
                margin: 15px auto;
                font-size: 12px;
            }

            .detail-container {
                width: calc(100% - 28px);
                grid-template-columns: 1fr;
                gap: 22px;
                margin-bottom: 28px;
            }

            .main-photo { aspect-ratio: 4 / 3; }
            .detail-info h1 { font-size: 22px; }
            .actions { flex-direction: column; }
            .action-button { width: 100%; }
        }


/* FIX: tombol Daftar selalu terlihat pada seluruh halaman publik */
.navbar > .nav-links > a.register-button,
.navbar > .nav-links > a.register-button.active,
.navbar > .nav-links > a.register-button:hover {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    box-sizing: border-box !important;
    min-width: 66px !important;
    min-height: 40px !important;
    height: 40px !important;
    margin: 0 !important;
    padding: 0 18px !important;
    background: var(--brand, #7040a5) !important;
    color: #ffffff !important;
    border: 0 !important;
    border-radius: 6px !important;
    line-height: 1 !important;
    font-weight: 700 !important;
    text-decoration: none !important;
}



        /* Perataan status universal: semua badge tetap utuh dan berada di tengah. */

        .status { display:inline-flex !important; align-items:center !important; justify-content:center !important;
            text-align:center !important; vertical-align:middle !important; box-sizing:border-box !important;
            width:max-content !important; min-width:120px !important; max-width:100% !important;
            height:auto !important; min-height:28px; padding:5px 12px !important;
            line-height:1.35 !important; white-space:normal !important; overflow-wrap:anywhere; }


    </style>
    <link rel="stylesheet" href="{{ asset('css/lost-found-status.css') . '?v=20261119-2' }}">
    <link rel="stylesheet" href="{{ asset('css/lost-found-actions.css') }}?v=20261119-1">
</head>

<body>

<header class="navbar">

    <div class="logo"><img src="{{ asset('images/gunadarma-logo.png') }}" alt="Logo Universitas Gunadarma"></div>

    <div class="brand">Lost &amp; Found Gundar</div>

    <nav class="nav-links">
        <a
            href="{{ route('home') }}"
            class="{{ request()->routeIs('home') ? 'active' : '' }}"
            {{ request()->routeIs('home') ? 'aria-current=page' : '' }}
        >Beranda</a>

        <a
            href="{{ route('public.barang.index') }}"
            class="active"
            aria-current="page"
        >Cari Barang</a>

        @if (session()->has('auth'))
            @php
                $role = session('auth.role');
                $dashboardRoute = match ($role) {
                    'super_admin' => 'dashboard.super-admin',
                    'admin_kampus' => 'dashboard.admin',
                    'satpam' => 'dashboard.satpam',
                    'pelapor' => 'dashboard.pelapor',
                    default => 'login',
                };
            @endphp

            <a href="{{ route($dashboardRoute) }}">Dashboard</a>
        @else
            <a href="{{ route('login') }}">Masuk</a>
            <a href="{{ route('register') }}" class="register-button">Daftar</a>
        @endif
    </nav>

</header>

<div class="breadcrumb">
    <a href="{{ route('home') }}" style="color:inherit;text-decoration:none;">Beranda</a>
    &gt; Barang Ditemukan
    &gt; {{ $barang->nama_publik }}
</div>

<main class="detail-container">

    <section>

        <div class="main-photo" style="overflow:hidden;">
            @if($barang->foto->isNotEmpty())
                <img src="{{ asset('storage/'.$barang->foto->first()->path_foto) }}" alt="Foto {{ $barang->nama_publik }}" style="width:100%;height:100%;object-fit:contain;background:#f3f0f7;">
            @else
                Foto belum tersedia
            @endif
        </div>

        @if($barang->foto->count() > 1)
            <div class="thumbnail-grid">
                @foreach($barang->foto->skip(1) as $foto)
                    <div class="thumbnail" style="overflow:hidden;">
                        <img src="{{ asset('storage/'.$foto->path_foto) }}" alt="Foto tambahan {{ $barang->nama_publik }}" style="width:100%;height:100%;object-fit:cover;">
                    </div>
                @endforeach
            </div>
        @endif

    </section>

    <section class="detail-info">

        <h1>{{ $barang->nama_publik }}</h1>

        <span class="status status-approved">Dipublikasikan</span>

        <table class="information-table">
            <tr>
                <th>Kategori</th>
                <td>{{ $barang->kategori }}</td>
            </tr>

            <tr>
                <th>Kampus</th>
                <td>{{ $barang->kampus->nama_kampus ?? '-' }}</td>
            </tr>

            <tr>
                <th>Tanggal Ditemukan</th>
                <td>{{ $barang->tanggal_ditemukan->translatedFormat('d M Y') }}</td>
            </tr>

            <tr>
                <th>Lokasi Ditemukan</th>
                <td>{{ $barang->lokasi_ditemukan }}</td>
            </tr>
        </table>

        <h3 class="description-title">Deskripsi Publik</h3>

        <div class="description">
            {{ $barang->deskripsi_publik ?: 'Tidak ada deskripsi tambahan.' }}
        </div>

        <div class="privacy-note">
            &#9432; Detail rahasia tidak ditampilkan. Pemilik akan diminta
            menjelaskan ciri khusus saat mengajukan klaim.
        </div>

        <div class="actions">

            <a
                href="{{ route('pelapor.klaim.show', $barang->id_barang) }}"
                class="action-button action-primary"
            >
                Ajukan Klaim Barang Ini
            </a>

            <a
                href="{{ route('pelapor.laporan-kehilangan.create') }}"
                class="action-button action-secondary"
            >
                Bukan barang saya? Buat Laporan Kehilangan
            </a>

        </div>

        @if (!session()->has('auth'))
            <p class="login-note">
                Pengunjung yang belum login akan diarahkan ke halaman Login terlebih dahulu.
            </p>
        @endif

    </section>

</main>

</body>
</html>
