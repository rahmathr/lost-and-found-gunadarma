<aside class="admin-sidebar">
    <div class="admin-brand">
        <img class="admin-brand-logo" src="{{ asset('images/gunadarma-logo.png') }}" alt="Logo Universitas Gunadarma">
        <div class="admin-brand-text">
            Lost &amp; Found Gundar
            <small>Admin Kampus</small>
        </div>
    </div>

    <nav class="admin-nav" aria-label="Navigasi Admin Kampus">
        <div class="nav-group">
            <div class="nav-group-title">Ringkasan</div>
            <a href="{{ route('dashboard.admin') }}" class="{{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">@include('shared.sidebar-icon', ['name' => 'dashboard']) Dashboard</a>
        </div>

        <div class="nav-group">
            <div class="nav-group-title">Operasional Barang</div>
            <a href="{{ route('admin.validasi-barang.index') }}" class="{{ request()->routeIs('admin.validasi-barang.*', 'admin.antrean-barang.*') ? 'active' : '' }}">@include('shared.sidebar-icon', ['name' => 'inbox']) Antrean Barang</a>
            <a href="{{ route('admin.barang-diterima.create') }}" class="{{ request()->routeIs('admin.barang-diterima.*') ? 'active' : '' }}">@include('shared.sidebar-icon', ['name' => 'package-plus']) Catat Barang Langsung</a>
            <a href="{{ route('admin.laporan-kehilangan.index') }}" class="{{ request()->routeIs('admin.laporan-kehilangan.*') ? 'active' : '' }}">@include('shared.sidebar-icon', ['name' => 'file-text']) Laporan Kehilangan</a>
        </div>

        <div class="nav-group">
            <div class="nav-group-title">Layanan &amp; Pengelolaan</div>
            <a href="{{ route('admin.satpam.index') }}" class="{{ request()->routeIs('admin.satpam.*') ? 'active' : '' }}">@include('shared.sidebar-icon', ['name' => 'users']) Manajemen Satpam</a>
            <a href="{{ route('admin.manajemen-klaim.index') }}" class="{{ request()->routeIs('admin.manajemen-klaim.*') ? 'active' : '' }}">@include('shared.sidebar-icon', ['name' => 'shield-check']) Verifikasi Klaim</a>
            <a href="{{ route('admin.penyerahan.index') }}" class="{{ request()->routeIs('admin.penyerahan.index', 'admin.penyerahan.show', 'admin.penyerahan.store') ? 'active' : '' }}">@include('shared.sidebar-icon', ['name' => 'handshake']) Penyerahan Barang</a>
        </div>

        <div class="nav-group">
            <div class="nav-group-title">Arsip &amp; Riwayat</div>
            <a href="{{ route('admin.penyerahan.riwayat') }}" class="{{ request()->routeIs('admin.penyerahan.riwayat') ? 'active' : '' }}">@include('shared.sidebar-icon', ['name' => 'history']) Riwayat Penyerahan</a>
            <a href="{{ route('admin.riwayat-pengelolaan.index') }}" class="{{ request()->routeIs('admin.riwayat-pengelolaan.*') ? 'active' : '' }}">@include('shared.sidebar-icon', ['name' => 'clipboard-list']) Riwayat Pengelolaan</a>
        </div>
    </nav>

    <form class="sidebar-logout" action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">@include('shared.sidebar-icon', ['name' => 'log-out']) Keluar</button>
    </form>
</aside>
