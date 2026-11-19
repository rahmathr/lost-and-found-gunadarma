@extends('admin.layouts.app')

@section('title', 'Dashboard Admin Kampus')
@section('heading', 'Dashboard Admin Kampus')

@section('pageStyles')
<style>
.dashboard-page { width:100%; min-width:0; }
.dashboard-page .stats { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:14px; margin:0 0 20px; }
.dashboard-page .stat-card { min-width:0; padding:18px; border:1px solid #eee8f2; border-radius:10px; background:#fff; box-shadow:0 2px 8px rgba(35,22,49,.05); }
.dashboard-page .stat-number { margin:0 0 8px; color:#4b2d73; font-size:27px; line-height:1.2; font-weight:700; }
.dashboard-page .stat-label { color:#62596b; font-size:13px; line-height:1.45; }
.dashboard-page .columns { display:grid; grid-template-columns:minmax(0,1.4fr) minmax(280px,.9fr); gap:18px; align-items:start; }
.dashboard-page .panel { min-width:0; margin:0 0 18px; overflow:hidden; border:1px solid #eee8f2; border-radius:10px; background:#fff; box-shadow:0 2px 8px rgba(35,22,49,.05); }
.dashboard-page .panel-title { padding:14px 16px; background:#f2edf7; border-bottom:1px solid #e5e1e9; color:#392451; font-size:15px; font-weight:700; }
.dashboard-page .panel-body { padding:16px; min-width:0; }
.dashboard-page .panel-body table { width:100%; border-collapse:collapse; font-size:13px; }
.dashboard-page .panel-body th,.dashboard-page .panel-body td { padding:10px 9px; border:1px solid #e5e0ea; text-align:left; vertical-align:middle; }
.dashboard-page .panel-body th { background:#f7f4fa; color:#392451; font-weight:700; }
.dashboard-page .panel-body tbody tr:nth-child(even) { background:#fbf9fd; }
.dashboard-page .status { display:inline-block; padding:5px 9px; border:1px solid #ddd; border-radius:20px; font-size:12px; white-space:nowrap; }
.dashboard-page .action-link { display:inline-flex; align-items:center; justify-content:center; min-height:34px; padding:7px 12px; border:1px solid #d8c9e8; border-radius:6px; background:#f7f3fb; color:#4b2d73; text-decoration:none; font-size:12px; font-weight:700; }
.dashboard-page .action-link:hover { background:#eee6f6; }
.dashboard-page .quick-actions { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:10px; }
.dashboard-page .quick-actions a { display:flex; align-items:center; justify-content:center; min-height:44px; padding:10px; border:1px solid #d8c9e8; border-radius:7px; color:#4b2d73; text-align:center; text-decoration:none; font-size:13px; font-weight:700; }
.dashboard-page .quick-actions a.primary { background:#4b2d73; border-color:#4b2d73; color:#fff; }
.dashboard-page .empty { padding:22px 12px; color:#756d7d; text-align:center; }
@media(max-width:1050px) { .dashboard-page .stats { grid-template-columns:repeat(2,minmax(0,1fr)); } .dashboard-page .columns { grid-template-columns:1fr; } }
@media(max-width:600px) { .dashboard-page .stats { grid-template-columns:1fr 1fr; gap:9px; } .dashboard-page .stat-card { padding:13px; } .dashboard-page .stat-number { font-size:23px; } .dashboard-page .panel-body { overflow-x:auto; } .dashboard-page .quick-actions { grid-template-columns:1fr; } }
</style>
@endsection

@section('content')
<section class="dashboard-page">

            @if (session('success'))
                <div style="background:#dcfce7;color:#166534;padding:12px;margin-bottom:15px;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="stats">

                <div class="stat-card">
                    <div class="stat-number">
                        {{ $barangDalamAntrean }}
                    </div>
                    <div class="stat-label">
                        Barang dalam Antrean
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-number">
                        {{ $barangSiapDipublikasikan }}
                    </div>
                    <div class="stat-label">
                        Siap Dipublikasikan
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-number">
                        {{ $klaimMenunggu }}
                    </div>
                    <div class="stat-label">
                        Klaim Menunggu Verifikasi
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-number">
                        {{ $laporanAktif }}
                    </div>
                    <div class="stat-label">
                        Laporan Kehilangan Aktif
                    </div>
                </div>

            </div>

            <div class="columns">

                <div class="panel">

                    <div class="panel-title">
                        Antrean Barang Terbaru
                    </div>

                    <div class="panel-body">

                        <table>
                            <thead>
                                <tr>
                                    <th>Barang</th>
                                    <th>Sumber</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse ($antreanTerbaru as $barang)

                                    @php
                                        $statusClass = match ($barang->status) {
                                            'Diterima Satpam' => 'waiting',
                                            'Dalam Pemeriksaan' => 'checking',
                                            'Siap Dipublikasikan' => 'ready',
                                            default => '',
                                        };

                                        $sumber = $barang->sumber_penerimaan === 'Satpam'
                                            ? 'Satpam'
                                            : 'Langsung';
                                    @endphp

                                    <tr>
                                        <td>{{ $barang->nama_publik }}</td>

                                        <td>{{ $sumber }}</td>

                                        <td>
                                            <span class="status {{ $statusClass }}">
                                                {{ $barang->status }}
                                            </span>
                                        </td>

                                        <td>
                                            <a
                                                href="{{ route('admin.validasi-barang.show', $barang->id_barang) }}"
                                                class="action-link">
                                                Periksa
                                            </a>
                                        </td>
                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="4" class="empty">
                                            Tidak ada barang dalam antrean.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>
                        </table>

                        <p style="margin-top:15px;">
                            <a
                                href="{{ route('admin.validasi-barang.index') }}"
                                class="action-link">
                                Lihat Semua Antrean
                            </a>
                        </p>

                    </div>
                </div>

                <div class="panel">

                    <div class="panel-title">
                        Klaim Perlu Tindakan
                    </div>

                    <div class="panel-body">

                        @forelse ($klaimPerluTindakan as $klaim)

                            <div style="border:1px solid #ccc;padding:12px;margin-bottom:10px;font-size:12px;">

                                <strong>
                                    {{ $klaim->barangDitemukan->nama_publik ?? 'Barang tidak tersedia' }}
                                </strong>

                                <div style="margin-top:5px;">
                                    Pengajuan klaim
                                </div>

                                <div>
                                    Pelapor:
                                    {{ $klaim->pelaporKehilangan->nama ?? '-' }}
                                </div>

                                <div style="margin:8px 0;">
                                    <span class="status waiting">
                                        {{ $klaim->status }}
                                    </span>
                                </div>

                                <a
                                    href="{{ route('admin.manajemen-klaim.show', $klaim->id_klaim) }}"
                                    class="action-link">
                                    Periksa Klaim
                                </a>

                            </div>

                        @empty

                            <div class="empty">
                                Tidak ada klaim yang menunggu verifikasi.
                            </div>

                        @endforelse

                    </div>
                </div>

            </div>

            <div class="panel">

                <div class="panel-title">
                    Aksi Cepat
                </div>

                <div class="panel-body">

                    <div class="quick-actions">

                        <a
                            href="{{ route('admin.barang-diterima.create') }}"
                            class="primary">
                            + Catat Barang Langsung
                        </a>

                        <a href="{{ route('admin.validasi-barang.index') }}">
                            Proses Antrean Barang
                        </a>

                        <a href="{{ route('admin.laporan-kehilangan.index') }}">
                            Kelola Laporan Kehilangan
                        </a>

                        <a href="{{ route('admin.manajemen-klaim.index') }}">
                            Verifikasi Klaim
                        </a>

                        <a href="{{ route('admin.penyerahan.index') }}">
                            Catat Penyerahan
                        </a>

                        <!-- AKSI CEPAT W-16 -->
                        <a href="{{ route('admin.riwayat-pengelolaan.index') }}">
                            Riwayat Pengelolaan
                        </a>

                    </div>

                </div>
            </div>

        </section>
@endsection
