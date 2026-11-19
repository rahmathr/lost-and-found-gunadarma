<aside class="sa-sidebar">
    <div class="sa-brand">
        <div class="sa-logo"><img src="{{ asset('images/gunadarma-logo.png') }}" alt="Logo Universitas Gunadarma"></div>
        <div>
            <div class="sa-brand-name">Lost &amp; Found Gundar</div>
            <div class="sa-brand-role">Super Admin</div>
        </div>
    </div>

    <nav class="sa-nav" aria-label="Navigasi Super Admin">
        <div class="nav-group">
            <div class="nav-group-title">Ringkasan</div>
            <a href="{{ route('dashboard.super-admin') }}" class="{{ request()->routeIs('dashboard.super-admin') ? 'active' : '' }}">@include('shared.sidebar-icon', ['name' => 'dashboard']) Dashboard Lintas Kampus</a>
        </div>
        <div class="nav-group">
            <div class="nav-group-title">Data &amp; Akses</div>
            <a href="{{ route('super-admin.kampus.index') }}" class="{{ request()->routeIs('super-admin.kampus.*') ? 'active' : '' }}">@include('shared.sidebar-icon', ['name' => 'university']) Kelola Data Kampus</a>
            <a href="{{ route('super-admin.admin-kampus.index') }}" class="{{ request()->routeIs('super-admin.admin-kampus.*') ? 'active' : '' }}">@include('shared.sidebar-icon', ['name' => 'users']) Kelola Akun Admin</a>
        </div>
        <div class="nav-group">
            <div class="nav-group-title">Pemantauan</div>
            <a href="{{ route('super-admin.riwayat-aktivitas.index') }}" class="{{ request()->routeIs('super-admin.riwayat-aktivitas.*') ? 'active' : '' }}">@include('shared.sidebar-icon', ['name' => 'history']) Riwayat Aktivitas</a>
        </div>
    </nav>

    <form class="sidebar-logout" action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">@include('shared.sidebar-icon', ['name' => 'log-out']) Keluar</button>
    </form>
</aside>
