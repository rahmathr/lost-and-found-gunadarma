@extends('pelapor.layouts.app')

@section('title', 'Detail Klaim - Lost & Found Gundar')
@section('heading', 'Detail Klaim')
@section('active', 'laporan')

@section('content')
<div class="pelapor-content-panel">

    <div class="page-heading">
        <h1>Detail Klaim Barang</h1>
        <a href="{{ route('dashboard.pelapor') }}" class="secondary">Kembali ke Dashboard</a>
    </div>

    @php
        $statusKlaim = $item->penyerahan ? 'Diserahkan' : $item->status;
        $statusClass = match ($statusKlaim) {
            'Menunggu Verifikasi' => 'status-pending',
            'Disetujui', 'Diserahkan' => 'status-approved',
            'Ditolak' => 'status-rejected',
            default => 'status-other',
        };
    @endphp

    <section class="summary-grid" style="grid-template-columns:repeat(2,minmax(0,1fr));margin-bottom:22px;">
        <div class="summary-card">
            <div class="summary-label">Status Klaim</div>
            <div style="margin-top:12px;">
                <span class="status {{ $statusClass }}">{{ $statusKlaim }}</span>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Tanggal Pengajuan</div>
            <strong style="display:block;margin-top:12px;">
                {{ $item->tanggal_klaim?->format('d-m-Y H:i') ?? '-' }}
            </strong>
        </div>
    </section>

    <h2 class="section-title">Informasi Barang</h2>
    <div class="table-wrapper">
        <table>
            <tbody>
                <tr>
                    <th style="width:30%;">Nama Barang</th>
                    <td>{{ $item->barangDitemukan->nama_publik ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ $item->barangDitemukan->kategori ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Kampus</th>
                    <td>{{ $item->barangDitemukan->kampus->nama_kampus ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Ditemukan</th>
                    <td>{{ $item->barangDitemukan?->tanggal_ditemukan?->format('d-m-Y') ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Lokasi Ditemukan</th>
                    <td>{{ $item->barangDitemukan->lokasi_ditemukan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Deskripsi Kepemilikan yang Dikirim</th>
                    <td>{{ $item->keterangan_privat ?: '-' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <h2 class="section-title">Hasil Verifikasi Admin</h2>
    <div class="table-wrapper">
        <table>
            <tbody>
                <tr>
                    <th style="width:30%;">Admin Pemeriksa</th>
                    <td>{{ $item->admin->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Catatan Admin</th>
                    <td>{{ $item->catatan_admin ?: 'Belum ada catatan dari Admin.' }}</td>
                </tr>
                <tr>
                    <th>Bukti Tambahan</th>
                    <td>
                        @if ($item->bukti_tambahan)
                            Bukti tambahan telah dikirim dan diterima untuk pemeriksaan.
                        @else
                            Tidak ada bukti tambahan.
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    @if ($item->penyerahan)
        <h2 class="section-title">Informasi Penyerahan Barang</h2>
        <div class="table-wrapper">
            <table>
                <tbody>
                    <tr>
                        <th style="width:30%;">Status Penyerahan</th>
                        <td><span class="status status-approved">Diserahkan</span></td>
                    </tr>
                    <tr>
                        <th>Tanggal dan Waktu</th>
                        <td>{{ $item->penyerahan->tanggal_penyerahan?->format('d-m-Y H:i') ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Dicatat oleh Admin</th>
                        <td>{{ $item->penyerahan->admin->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Catatan Penyerahan</th>
                        <td>{{ $item->penyerahan->catatan ?: '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info" style="margin-top:18px;">
            Belum ada data penyerahan barang untuk klaim ini.
        </div>
    @endif

    <p style="margin-top:22px;">
        <a href="{{ route('pelapor.laporan-kehilangan.index') }}" class="secondary">
            Kembali ke Laporan &amp; Klaim Saya
        </a>
        <a href="{{ route('pelapor.klaim.riwayat') }}" class="secondary">
            Lihat Riwayat Klaim
        </a>
    </p>

</div>
@endsection
