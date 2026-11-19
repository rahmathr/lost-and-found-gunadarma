@extends('super-admin.layouts.app')

@section('title', 'Dashboard Lintas Kampus')
@section('heading', 'Dashboard Lintas Kampus')

@push('styles')
<style>
    .sa-dashboard-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
        margin-bottom: 18px;
    }

    .sa-dashboard-stat-card {
        border: 1px solid #e2d8f5;
        background: #faf8ff;
        min-height: 80px;
        padding: 12px;
        border-radius: 8px;
    }

    .sa-dashboard-stat-number {
        color: #5b21b6;
        font-size: 23px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .sa-dashboard-stat-label {
        color: #6b6478;
        font-size: 11px;
    }

    .sa-dashboard-filter { margin-bottom: 13px; }

    /* Filter kampus dashboard: gunakan lebar konten, tanpa scrollbar internal */
    form.sa-dashboard-campus-filter {
        display: block !important;
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
        overflow: visible !important;
        padding: 12px !important;
        margin: 0 0 14px !important;
    }

    form.sa-dashboard-campus-filter .lf-filter__field {
        width: 100% !important;
        max-width: 320px !important;
    }

    .sa-dashboard-filter select {
        width: 250px;
        max-width: 100%;
        padding: 9px;
        border: 1px solid #d6c8ef;
        border-radius: 6px;
        background: #fff;
    }

    .sa-dashboard-table-wrapper {
        overflow-x: auto;
        margin-bottom: 24px;
    }

    .sa-dashboard-table-wrapper table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
    }

    .sa-dashboard-table-wrapper th {
        background: #eee7fb;
        color: #4c1d95;
        text-align: left;
        font-weight: bold;
    }

    .sa-dashboard-table-wrapper th,
    .sa-dashboard-table-wrapper td {
        padding: 9px 8px;
        border: 1px solid #e2d8f5;
    }

    .sa-dashboard-table-wrapper tbody tr:nth-child(even) {
        background: #faf8ff;
    }

    .sa-dashboard-btn-detail {
        display: inline-block;
        padding: 5px 14px;
        border: 1px solid #7c3aed;
        border-radius: 5px;
        text-decoration: none;
        color: #6d28d9;
        background: #fff;
        white-space: nowrap;
    }

    .sa-dashboard-btn-detail:hover {
        background: #f3edff;
    }

    .sa-dashboard-chart-container {
        border: 1px solid #e2d8f5;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
    }

    .sa-dashboard-chart-title {
        padding: 9px;
        background: #eee7fb;
        color: #4c1d95;
        border-bottom: 1px solid #e2d8f5;
        font-weight: bold;
    }

    .sa-dashboard-legend {
        display: flex;
        justify-content: flex-end;
        gap: 20px;
        padding: 10px 15px 0;
        font-size: 10px;
    }

    .sa-dashboard-legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .sa-dashboard-legend-color {
        width: 12px;
        height: 12px;
        display: inline-block;
    }

    .sa-dashboard-found-color {
        background: #c4b5fd;
        border: 1px solid #8b5cf6;
    }

    .sa-dashboard-handed-color {
        background: #a7f3d0;
        border: 1px solid #34d399;
    }

    .sa-dashboard-chart {
        min-height: 190px;
        display: flex;
        justify-content: space-around;
        align-items: flex-end;
        padding: 20px 25px 0;
        gap: 15px;
    }

    .sa-dashboard-chart-group {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
    }

    .sa-dashboard-bars {
        height: 145px;
        display: flex;
        align-items: flex-end;
        gap: 5px;
    }

    .sa-dashboard-bar {
        width: 35px;
        min-height: 2px;
    }

    .sa-dashboard-bar-found {
        background: #c4b5fd;
        border: 1px solid #8b5cf6;
    }

    .sa-dashboard-bar-handed {
        background: #a7f3d0;
        border: 1px solid #34d399;
    }

    .sa-dashboard-chart-label {
        text-align: center;
        font-size: 10px;
        margin: 8px 0 12px;
    }

    .sa-dashboard-empty {
        padding: 25px;
        text-align: center;
        color: #766b87;
    }

    @media (max-width: 900px) {
        .sa-dashboard-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 520px) {
        .sa-dashboard-stats { grid-template-columns: 1fr; }
        .sa-dashboard-chart { padding-left: 10px; padding-right: 10px; }
    }
</style>
@endpush


@push('styles')
<style>
.sa-dashboard-stat-card{min-height:104px;padding:17px 18px;border:1px solid #eee8f2;border-radius:9px;background:#fff;box-shadow:0 2px 8px rgba(35,22,49,.05)}
.sa-dashboard-stat-number{font-size:26px;margin-bottom:8px;color:#4b2d73}
.sa-dashboard-stat-label{font-size:14px;line-height:1.45;color:#62596b}
.sa-dashboard-filter select{min-height:42px;padding:10px 12px;border:1px solid #d4cddc;border-radius:6px;font-size:14px}
.sa-dashboard-table-wrapper table{font-size:14px!important;background:#fff}
.sa-dashboard-table-wrapper th,.sa-dashboard-table-wrapper td{padding:12px 13px;border:1px solid #e5e1e9;font-size:14px;line-height:1.45}
.sa-dashboard-table-wrapper th{background:#f2edf7;color:#30283a}
.sa-dashboard-table-wrapper tbody tr:nth-child(even){background:#faf8fc}
.sa-dashboard-btn-detail{min-height:36px;padding:8px 12px;border:1px solid #4b2d73;border-radius:6px;background:#4b2d73;color:#fff;font-size:13px;font-weight:600}
.sa-dashboard-btn-detail:hover{background:#62408b;color:#fff}
.sa-dashboard-chart-container{border:1px solid #eee8f2;border-radius:9px;box-shadow:0 2px 8px rgba(35,22,49,.05)}
.sa-dashboard-chart-title{padding:14px 16px;background:#f2edf7;color:#30283a;font-size:15px}
.sa-dashboard-legend{font-size:13px}
.sa-dashboard-chart-label{font-size:13px}
@media(max-width:700px){.sa-dashboard-stats{grid-template-columns:repeat(2,minmax(0,1fr))}.sa-dashboard-table-wrapper table{min-width:700px}}
@media(max-width:480px){.sa-dashboard-stats{grid-template-columns:1fr}}
</style>
@endpush

@section('content')
    <!-- Statistik keseluruhan -->
    <div class="sa-dashboard-stats">
        <div class="sa-dashboard-stat-card">
            <div class="sa-dashboard-stat-number">{{ $totalKampus }}</div>
            <div class="sa-dashboard-stat-label">Kampus Terdaftar</div>
        </div>

        <div class="sa-dashboard-stat-card">
            <div class="sa-dashboard-stat-number">{{ $totalAdmin }}</div>
            <div class="sa-dashboard-stat-label">Akun Admin Kampus</div>
        </div>

        <div class="sa-dashboard-stat-card">
            <div class="sa-dashboard-stat-number">{{ $totalBarangDitemukan }}</div>
            <div class="sa-dashboard-stat-label">Total Barang Ditemukan</div>
        </div>

        <div class="sa-dashboard-stat-card">
            <div class="sa-dashboard-stat-number">{{ $totalKlaimDisetujui }}</div>
            <div class="sa-dashboard-stat-label">Klaim Disetujui</div>
        </div>
    </div>

    <!-- Filter kampus -->
    <form action="{{ route('dashboard.super-admin') }}" method="GET" class="lf-filter sa-dashboard-campus-filter">
        <div class="lf-filter__field">
            <label for="dashboard-kampus">Filter Kampus</label>
            <select id="dashboard-kampus" name="kampus" onchange="this.form.submit()">
                <option value="">Semua Kampus</option>
                @foreach ($kampus as $item)
                    <option value="{{ $item->id_kampus }}" {{ (string) $kampusTerpilih === (string) $item->id_kampus ? 'selected' : '' }}>{{ $item->nama_kampus }}</option>
                @endforeach
            </select>
        </div>
    </form>

    <!-- Tabel statistik kampus -->
    <div class="sa-dashboard-table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Kampus</th>
                    <th>Barang Dipublikasikan</th>
                    <th>Laporan Aktif</th>
                    <th>Klaim Menunggu</th>
                    <th>Diserahkan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($kampusDitampilkan->isNotEmpty())
                    @foreach ($kampusDitampilkan as $item)
                        <tr>
                            <td>{{ $item->nama_kampus }}</td>
                            <td>{{ $item->barang_dipublikasikan_count }}</td>
                            <td>{{ $item->laporan_aktif_count }}</td>
                            <td>{{ $item->klaim_menunggu_count }}</td>
                            <td>{{ $item->barang_diserahkan_count }}</td>
                            <td>
                                <a
                                    class="sa-dashboard-btn-detail"
                                    href="{{ route('super-admin.kampus.detail', $item->id_kampus) }}"
                                >
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="sa-dashboard-empty">
                            Belum ada data kampus.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Grafik -->
    <div class="sa-dashboard-chart-container">
        <div class="sa-dashboard-chart-title">
            Perbandingan Barang Ditemukan vs Diserahkan per Kampus
        </div>

        <div class="sa-dashboard-legend">
            <div class="sa-dashboard-legend-item">
                <span class="sa-dashboard-legend-color sa-dashboard-found-color"></span>
                Ditemukan
            </div>
            <div class="sa-dashboard-legend-item">
                <span class="sa-dashboard-legend-color sa-dashboard-handed-color"></span>
                Diserahkan
            </div>
        </div>

        <div class="sa-dashboard-chart">
            @if ($kampusDitampilkan->isNotEmpty())
                @foreach ($kampusDitampilkan as $item)
                    @php
                        $tinggiDitemukan = ($item->barang_dipublikasikan_count / $nilaiMaksimum) * 140;
                        $tinggiDiserahkan = ($item->barang_diserahkan_count / $nilaiMaksimum) * 140;
                    @endphp

                    <div class="sa-dashboard-chart-group">
                        <div class="sa-dashboard-bars">
                            <div
                                class="sa-dashboard-bar sa-dashboard-bar-found"
                                title="Dipublikasikan: {{ $item->barang_dipublikasikan_count }}"
                                @style(['height' => $tinggiDitemukan . 'px'])
                            ></div>
                            <div
                                class="sa-dashboard-bar sa-dashboard-bar-handed"
                                title="Diserahkan: {{ $item->barang_diserahkan_count }}"
                                @style(['height' => $tinggiDiserahkan . 'px'])
                            ></div>
                        </div>
                        <div class="sa-dashboard-chart-label">
                            {{ $item->nama_kampus }}
                        </div>
                    </div>
                @endforeach
            @else
                <div class="sa-dashboard-empty">
                    Belum ada data untuk ditampilkan.
                </div>
            @endif
        </div>
    </div>
@endsection
