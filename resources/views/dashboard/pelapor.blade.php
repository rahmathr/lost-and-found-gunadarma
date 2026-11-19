@extends('pelapor.layouts.app')

@section('title', 'Dashboard Pelapor - Lost & Found Gundar')
@section('heading', 'Dashboard Pelapor')
@section('active', 'dashboard')

@section('content')
<div class="header">
            <h1>Dashboard Pelapor</h1>
            <p>
                Selamat datang, <strong>{{ $pelapor->nama }}</strong>!
                Berikut ringkasan aktivitas akun Anda.
            </p>
        </div>

        {{-- Statistik --}}
        <div class="statistics">

            <div class="stat-card">
                <p>Total Laporan Kehilangan</p>
                <h2>{{ $totalLaporan }}</h2>
            </div>

            <div class="stat-card">
                <p>Laporan Diajukan</p>
                <h2>{{ $laporanDiajukan }}</h2>
            </div>

            <div class="stat-card">
                <p>Total Klaim Barang</p>
                <h2>{{ $totalKlaim }}</h2>
            </div>

            <div class="stat-card">
                <p>Klaim Menunggu Verifikasi</p>
                <h2>{{ $klaimMenunggu }}</h2>
            </div>

        </div>

        {{-- Laporan Terbaru --}}
        <section class="section">
            <h2>Laporan Kehilangan Terbaru</h2>

            @if ($laporanTerbaru->isEmpty())
                <p class="empty">Belum ada laporan kehilangan.</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Kampus</th>
                            <th>Tanggal Hilang</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($laporanTerbaru as $laporan)
                            <tr>
                                <td>{{ $laporan->nama_barang }}</td>
                                <td>{{ $laporan->kampus->nama_kampus ?? '-' }}</td>
                                <td>
                                    {{ $laporan->tanggal_hilang
                                        ? \Carbon\Carbon::parse($laporan->tanggal_hilang)->format('d-m-Y')
                                        : '-' }}
                                </td>
                                <td><span class="status {{ match ($laporan->status) {
                                    'Diajukan' => 'status-pending',
                                    'Dalam Penanganan', 'Menunggu Informasi' => 'status-other',
                                    'Selesai' => 'status-approved',
                                    'Ditolak' => 'status-rejected',
                                    default => 'status-other',
                                } }}">{{ $laporan->status }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </section>

        {{-- Klaim Terbaru --}}
        <section class="section">
            <h2>Klaim Barang Terbaru</h2>

            @if ($klaimTerbaru->isEmpty())
                <p class="empty">Belum ada klaim barang.</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Kampus</th>
                            <th>Tanggal Klaim</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($klaimTerbaru as $klaim)
                            <tr>
                                <td>
                                    {{ $klaim->barangDitemukan->nama_publik ?? '-' }}
                                </td>

                                <td>
                                    {{ $klaim->barangDitemukan->kampus->nama_kampus ?? '-' }}
                                </td>

                                <td>
                                    {{ $klaim->tanggal_klaim
                                        ? \Carbon\Carbon::parse($klaim->tanggal_klaim)->format('d-m-Y H:i')
                                        : '-' }}
                                </td>

                                <td><span class="status {{ $klaim->penyerahan ? 'diserahkan' : match ($klaim->status) {
                                    'Menunggu Verifikasi' => 'status-pending',
                                    'Disetujui' => 'status-approved',
                                    'Ditolak' => 'status-rejected',
                                    default => 'status-other',
                                } }}">{{ $klaim->penyerahan ? 'Diserahkan' : $klaim->status }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </section>

        {{-- Aksi Cepat --}}
        <section class="section">
            <h2>Aksi Cepat</h2>

            <a href="{{ route('pelapor.laporan-kehilangan.create') }}" class="button">
                + Buat Laporan Kehilangan
            </a>

            <a href="{{ route('pelapor.klaim.index') }}" class="button">
                Cari Barang Ditemukan
            </a>

            <a href="{{ route('pelapor.klaim.riwayat') }}" class="button">
                Lihat Riwayat Klaim
            </a>
        </section>
@endsection
