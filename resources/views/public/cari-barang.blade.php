<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Barang - Lost &amp; Found Gundar</title>

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
        .nav-links a.active {
            color: var(--brand);
        }

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

        .search-section {
            margin: 20px auto 30px;
            padding: 24px clamp(16px, 3vw, 36px) 22px;
            width: calc(100% - 40px);
            max-width: 1440px;
            background: var(--brand-soft);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            text-align: center;
        }

        .search-section h1 {
            margin: 0 0 18px;
            color: var(--text);
            font-size: clamp(20px, 2vw, 24px);
            line-height: 1.3;
        }

        .search-form {
            display: grid;
            grid-template-columns: minmax(220px, 2fr) minmax(150px, 1fr) minmax(150px, 1fr) minmax(100px, .6fr);
            gap: 10px;
            max-width: 980px;
            margin: 0 auto;
        }

        .search-form input,
        .search-form select {
            width: 100%;
            min-width: 0;
            height: 42px;
            padding: 9px 12px;
            border: 1px solid #cfc6d9;
            border-radius: 6px;
            background: #fff;
            color: var(--text);
            font: inherit;
            font-size: 14px;
        }

        .search-form input:focus,
        .search-form select:focus {
            outline: 2px solid rgba(112, 64, 165, .2);
            border-color: var(--brand);
        }

        .search-button {
            min-height: 42px;
            padding: 9px 18px;
            border: 1px solid var(--brand);
            border-radius: 6px;
            background: var(--brand);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: background .18s ease;
        }

        .search-button:hover { background: var(--brand-dark); }

        .search-note {
            margin: 14px 0 0;
            color: var(--muted);
            font-size: 12px;
        }

        .content {
            width: calc(100% - 40px);
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 0 36px;
        }

        .section-title {
            margin: 0 0 14px 2px;
            color: var(--text);
            font-size: 19px;
            line-height: 1.35;
        }

        .barang-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            align-items: stretch;
            gap: 20px;
        }

        .barang-card {
            min-width: 0;
            display: flex;
            flex-direction: column;
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            background: var(--surface);
            box-shadow: var(--shadow);
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .barang-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(43, 28, 61, .10);
        }

        .barang-image {
            width: 100%;
            aspect-ratio: 16 / 9;
            height: auto;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border);
            border-radius: 5px;
            background: var(--brand-pale);
            color: var(--muted);
            font-size: 13px;
        }

        .barang-image img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .barang-name {
            margin: 11px 2px 6px;
            color: var(--text);
            font-size: 16px;
            line-height: 1.4;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .barang-info {
            margin: 0 2px 7px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .detail-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 120px;
            min-height: 38px;
            margin: auto 0 2px 1px;
            padding: 8px 14px;
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

        .detail-button:hover {
            border-color: var(--brand);
            background: var(--brand-pale);
            color: var(--brand);
        }

        .empty {
            padding: 36px 20px;
            border: 1px dashed #cfc6d9;
            border-radius: var(--radius);
            background: var(--brand-pale);
            text-align: center;
            color: var(--muted);
            grid-column: 1 / -1;
        }

        .empty strong { color: var(--text); }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 26px;
        }

        .pagination a,
        .pagination span {
            min-width: 36px;
            min-height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 10px;
            border: 1px solid var(--border);
            border-radius: 5px;
            color: var(--text);
            background: #fff;
            text-align: center;
            text-decoration: none;
            font-size: 13px;
        }

        .pagination a:hover {
            border-color: var(--brand);
            color: var(--brand);
        }

        .pagination .active {
            background: var(--brand);
            color: #fff;
            border-color: var(--brand);
            font-weight: 700;
        }

        .pagination .disabled {
            color: #aaa;
            background: #faf9fb;
        }

        .result-info {
            margin-top: 18px;
            color: var(--muted);
            font-size: 12px;
        }

        @media (max-width: 900px) {
            .barang-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .search-form { grid-template-columns: 1fr 1fr; }
            .search-form input:first-child { grid-column: 1 / -1; }
        }

        @media (max-width: 600px) {
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

            .search-section {
                width: calc(100% - 24px);
                margin: 14px auto 22px;
                padding: 20px 14px;
            }

            .search-section h1 { font-size: 19px; margin-bottom: 15px; }
            .search-form { grid-template-columns: 1fr; }
            .search-form input:first-child { grid-column: auto; }
            .search-button { width: 100%; }

            .content {
                width: calc(100% - 24px);
                padding-bottom: 28px;
            }

            .section-title { font-size: 17px; }
            .barang-grid { grid-template-columns: 1fr; gap: 14px; }
            .barang-image { aspect-ratio: 16 / 9; }
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

</style>
    <link rel="stylesheet" href="{{ asset('css/lostfound-filters.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lost-found-actions.css') }}?v=20261119-1">
</head>

<body>

<header class="navbar">

    <div class="logo"><img src="{{ asset('images/gunadarma-logo.png') }}" alt="Logo Universitas Gunadarma"></div>

    <div class="brand">Lost &amp; Found Gundar</div>

    <nav class="nav-links">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}" {{ request()->routeIs('home') ? 'aria-current=page' : '' }}>Beranda</a>
        <a href="{{ route('public.barang.index') }}" class="{{ request()->routeIs('public.barang.index') ? 'active' : '' }}" {{ request()->routeIs('public.barang.index') ? 'aria-current=page' : '' }}>Cari Barang</a>

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

<section class="search-section">

    <h1>Temukan Barang yang Ditemukan</h1>

    <form action="{{ route('public.barang.index') }}" method="GET" class="lf-filter lf-filter--public">
        <div class="lf-filter__field lf-filter__field--search">
            <label for="public-keyword">Kata Kunci</label>
            <input id="public-keyword" type="text" name="keyword" placeholder="Kata kunci (mis. dompet, kunci motor)" value="{{ request('keyword') }}">
        </div>
        <div class="lf-filter__field">
            <label for="public-kampus">Kampus</label>
            <select id="public-kampus" name="kampus">
                <option value="">Semua Kampus</option>
                @foreach ($kampus as $item)
                    <option value="{{ $item->id_kampus }}" {{ request('kampus') == $item->id_kampus ? 'selected' : '' }}>{{ $item->nama_kampus }}</option>
                @endforeach
            </select>
        </div>
        <div class="lf-filter__field">
            <label for="public-kategori">Kategori</label>
            <select id="public-kategori" name="kategori">
                <option value="">Semua Kategori</option>
                @foreach ($kategori as $item)
                    <option value="{{ $item }}" {{ request('kategori') == $item ? 'selected' : '' }}>{{ $item }}</option>
                @endforeach
            </select>
        </div>
        <div class="lf-filter__actions">
            <button type="submit">Cari</button>
            <a href="{{ route('public.barang.index') }}">Reset</a>
        </div>
    </form>

    <p class="search-note">
        Hanya barang berstatus Dipublikasikan yang ditampilkan.
        Detail rahasia tidak ditampilkan.
    </p>

</section>

<main class="content">

    <h2 class="section-title">Barang Ditemukan Terbaru</h2>

    <div class="barang-grid">

        @forelse ($barang as $item)

            <article class="barang-card">

                <div class="barang-image">
                    @if($item->foto->isNotEmpty())
                        <img src="{{ app(\App\Services\FileStorageService::class)->url($item->foto->first()->path_foto) }}" alt="Foto {{ $item->nama_publik }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <span>Foto belum tersedia</span>
                    @endif
                </div>

                <h3 class="barang-name">
                    {{ $item->nama_publik }}
                </h3>

                <p class="barang-info">
                    {{ $item->kategori }}
                    -
                    {{ $item->kampus->nama_kampus ?? '-' }}
                </p>

                <p class="barang-info">
                    Ditemukan:
                    {{ $item->tanggal_ditemukan->translatedFormat('d M Y') }}
                    -
                    {{ $item->lokasi_ditemukan }}
                </p>

                <a
                    href="{{ route('public.barang.show', $item->id_barang) }}"
                    class="detail-button"
                >
                    Lihat Detail
                </a>

            </article>

        @empty

            <div class="empty">
                <strong>Barang tidak ditemukan.</strong>
                <p>Coba gunakan kata kunci atau filter lainnya.</p>
            </div>

        @endforelse

    </div>

    @if ($barang->total() > 0)

        <div class="result-info">
            Menampilkan {{ $barang->firstItem() }}–{{ $barang->lastItem() }}
            dari {{ $barang->total() }} data
        </div>

        <div class="pagination">
            @if ($barang->onFirstPage())
                <span class="disabled">&lsaquo;</span>
            @else
                <a href="{{ $barang->previousPageUrl() }}">&lsaquo;</a>
            @endif

            @foreach ($barang->getUrlRange(1, $barang->lastPage()) as $page => $url)
                @if ($page == $barang->currentPage())
                    <span class="active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach

            @if ($barang->hasMorePages())
                <a href="{{ $barang->nextPageUrl() }}">&rsaquo;</a>
            @else
                <span class="disabled">&rsaquo;</span>
            @endif
        </div>

    @endif

</main>

</body>
</html>
