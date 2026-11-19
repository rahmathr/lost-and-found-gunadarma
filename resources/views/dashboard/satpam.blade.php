@extends('satpam.layouts.app')

@section('title', 'Dashboard Satpam - Lost & Found Gundar')
@section('heading', 'Dashboard Satpam')

@push('styles')
<style>
    /* Reset posisi halaman */
    html,
    body {
        margin: 0 !important;
        padding: 0 !important;
        min-height: 100%;
    }

    body {
        overflow-x: hidden;
    }

    /* Dashboard Satpam */
    .satpam-dashboard {
        width: 100%;
        min-width: 0;
        font-family: Arial, sans-serif;
        font-size: 14px;
        line-height: 1.55;
        color: #30283a;
    }

    .satpam-dashboard * {
        box-sizing: border-box;
    }

    /* Sambutan */
    .satpam-dashboard .welcome {
        padding: 22px 24px;
        margin-bottom: 20px;
        background: #fff;
        border: 1px solid #eee8f2;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(35, 22, 49, .05);
    }

    .satpam-dashboard .welcome h2 {
        margin: 0 0 8px;
        color: #392451;
        font-size: 20px;
        line-height: 1.4;
    }

    .satpam-dashboard .welcome p {
        margin: 0 0 16px;
        color: #62596b;
        font-size: 14px;
        line-height: 1.6;
    }

    /* Tombol */
    .satpam-dashboard .action-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 40px;
        padding: 9px 15px;
        border: 1px solid #ddd6e5;
        border-radius: 6px;
        background: #f4f1f7;
        color: #393142;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: background .15s ease;
    }

    .satpam-dashboard .action-link:hover {
        background: #e9e2ef;
    }

    .satpam-dashboard .action-link.primary {
        background: #4b2d73;
        border-color: #4b2d73;
        color: #fff;
    }

    .satpam-dashboard .action-link.primary:hover {
        background: #62408b;
    }

    /* Statistik */
    .satpam-dashboard .stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 22px;
    }

    .satpam-dashboard .stat-card {
        min-width: 0;
        padding: 20px;
        background: #fff;
        border: 1px solid #eee8f2;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(35, 22, 49, .05);
    }

    .satpam-dashboard .stat-number {
        margin-bottom: 7px;
        color: #4b2d73;
        font-size: 29px;
        font-weight: 700;
        line-height: 1.3;
    }

    .satpam-dashboard .stat-label {
        color: #62596b;
        font-size: 14px;
        line-height: 1.5;
    }

    /* Panel */
    .satpam-dashboard .panel {
        margin-bottom: 20px;
        overflow: hidden;
        background: #fff;
        border: 1px solid #eee8f2;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(35, 22, 49, .05);
    }

    .satpam-dashboard .panel-title {
        padding: 15px 18px;
        background: #f2edf7;
        border-bottom: 1px solid #e5e1e9;
        color: #392451;
        font-size: 16px;
        font-weight: 700;
    }

    .satpam-dashboard .panel-body {
        padding: 18px;
    }

    /* Tabel */
    .satpam-dashboard .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .satpam-dashboard table {
        width: 100%;
        min-width: 650px;
        border-collapse: collapse;
        background: #fff;
        font-size: 14px;
    }

    .satpam-dashboard th,
    .satpam-dashboard td {
        padding: 12px;
        border: 1px solid #e5e1e9;
        text-align: left;
        vertical-align: middle;
        line-height: 1.45;
    }

    .satpam-dashboard th {
        background: #f7f5fa;
        color: #392451;
        font-weight: 700;
    }

    .satpam-dashboard tbody tr:nth-child(even) {
        background: #faf8fc;
    }

    .satpam-dashboard tbody tr:hover {
        background: #f5f0fa;
    }

    /* Status barang */
    .satpam-dashboard .status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 10px;
        border: 1px solid transparent;
        border-radius: 5px;
        font-size: 13px;
        font-weight: 600;
        line-height: 1.3;
        white-space: nowrap;
    }

    .satpam-dashboard .waiting {
        background: #fff4d6;
        border-color: #e5b83b;
        color: #805b00;
    }

    .satpam-dashboard .checking {
        background: #f0e5f7;
        border-color: #a477c1;
        color: #60377b;
    }

    .satpam-dashboard .ready {
        background: #e5f3df;
        border-color: #70ad47;
        color: #386525;
    }

    .satpam-dashboard .approved {
        background: #e3efff;
        border-color: #6d9eeb;
        color: #24538d;
    }

    .satpam-dashboard .rejected {
        background: #fde8e8;
        border-color: #cc6666;
        color: #922d2d;
    }

    /* Data kosong */
    .satpam-dashboard .empty {
        padding: 25px 15px;
        color: #716879;
        text-align: center;
        font-size: 14px;
    }

    /* Menu cepat */
    .satpam-dashboard .quick-actions {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
    }

    .satpam-dashboard .quick-actions a {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        padding: 11px 14px;
        border: 1px solid #ddd6e5;
        border-radius: 6px;
        background: #f4f1f7;
        color: #393142;
        text-align: center;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: background .15s ease;
    }

    .satpam-dashboard .quick-actions a:hover {
        background: #e9e2ef;
    }

    .satpam-dashboard .quick-actions a.primary {
        background: #4b2d73;
        border-color: #4b2d73;
        color: #fff;
    }

    .satpam-dashboard .quick-actions a.primary:hover {
        background: #62408b;
    }

    /* Responsif */
    @media (max-width: 1000px) {
        .satpam-dashboard .stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 650px) {
        .satpam-dashboard .welcome {
            padding: 18px;
        }

        .satpam-dashboard .stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .satpam-dashboard .stat-card {
            padding: 15px;
        }

        .satpam-dashboard .stat-number {
            font-size: 25px;
        }

        .satpam-dashboard .panel-body {
            padding: 13px;
        }

        .satpam-dashboard .quick-actions {
            grid-template-columns: 1fr;
        }

        .satpam-dashboard .quick-actions a {
            width: 100%;
        }
    }

    @media (max-width: 380px) {
        .satpam-dashboard .stats {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="satpam-dashboard">

    {{-- Sambutan --}}
    <section class="welcome">
        <h2>Selamat Datang, {{ $satpam->nama }}!</h2>

        <p>
            Selamat datang di sistem Lost and Found Gunadarma.
            Kelola pencatatan barang temuan dan pantau status
            pemeriksaan barang oleh Admin Kampus.
        </p>

        <a
            href="{{ route('satpam.barang-temuan.create') }}"
            class="action-link primary">
            + Catat Barang Temuan
        </a>
    </section>

    {{-- Statistik --}}
    <section class="stats">

        <div class="stat-card">
            <div class="stat-number">
                {{ $totalBarang }}
            </div>
            <div class="stat-label">
                Total Barang Dicatat
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-number">
                {{ $barangMenunggu }}
            </div>
            <div class="stat-label">
                Dalam Antrean Admin
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-number">
                {{ $barangDipublikasikan }}
            </div>
            <div class="stat-label">
                Sudah Dipublikasikan
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-number">
                {{ $barangDitolak }}
            </div>
            <div class="stat-label">
                Ditolak Admin
            </div>
        </div>

    </section>

    {{-- Barang temuan terbaru --}}
    <section class="panel">

        <div class="panel-title">
            Barang Temuan Terbaru
        </div>

        <div class="panel-body">

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>

                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Tanggal Ditemukan</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($barangTerbaru as $item)

                            @php
                                $statusClass = match ($item->status) {
                                    'Diterima Satpam' => 'waiting',
                                    'Dalam Pemeriksaan' => 'checking',
                                    'Siap Dipublikasikan' => 'ready',
                                    'Dipublikasikan' => 'approved',
                                    'Ditolak' => 'rejected',
                                    default => '',
                                };
                            @endphp

                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $item->nama_publik }}</td>
                                <td>{{ $item->kategori }}</td>
                                <td>
                                    {{ $item->tanggal_ditemukan->format('d-m-Y') }}
                                </td>
                                <td>
                                    <span class="status {{ $statusClass }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="empty">
                                    Belum ada barang temuan yang dicatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <p style="margin: 16px 0 0;">
                <a
                    href="{{ route('satpam.barang-temuan.index') }}"
                    class="action-link">
                    Lihat Semua Barang
                </a>
            </p>

        </div>
    </section>

    {{-- Menu cepat --}}
    <section class="panel">

        <div class="panel-title">
            Menu Cepat
        </div>

        <div class="panel-body">

            <div class="quick-actions">

                <a
                    href="{{ route('satpam.barang-temuan.create') }}"
                    class="primary">
                    Catat Barang Temuan
                </a>

                <a href="{{ route('satpam.barang-temuan.index') }}">
                    Kelola Barang Temuan
                </a>

                <a href="{{ route('satpam.riwayat-penerimaan.index') }}">
                    Riwayat Penerimaan
                </a>

            </div>

        </div>
    </section>

</div>
@endsection
