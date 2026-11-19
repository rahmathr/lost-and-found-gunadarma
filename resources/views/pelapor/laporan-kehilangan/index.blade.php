@extends('pelapor.layouts.app')

@section('title', 'Laporan & Klaim Saya - Lost & Found Gundar')
@section('heading', 'Laporan & Klaim Saya')
@section('active', 'laporan')

@push('styles')
<style>
    /* Jarak antarbagian tabel pada halaman Laporan & Klaim Saya saja */
    .pelapor-page-surface .pelapor-content-panel > .claim-table-section {
        margin-top: 18px;
    }
</style>
@endpush

@section('content')
<div class="pelapor-content-panel">

<div class="page-heading">

        <h1>Status Laporan &amp; Klaim Saya</h1>

        <a
            href="{{ route('pelapor.laporan-kehilangan.create') }}"
            class="primary-button"
        >
            + Buat Laporan Kehilangan
        </a>

    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <!-- Ringkasan -->
    <section class="summary-grid">

        <div class="summary-card">
            <div class="summary-number">
                {{ $jumlahLaporanAktif }}
            </div>

            <div class="summary-label">
                Laporan Kehilangan Aktif
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-number">
                {{ $jumlahKlaimMenunggu }}
            </div>

            <div class="summary-label">
                Klaim Menunggu Verifikasi
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-number">
                {{ $jumlahKlaimDisetujui }}
            </div>

            <div class="summary-label">
                Klaim Disetujui
            </div>
        </div>

    </section>

    <!-- Tabel Laporan Kehilangan -->
    <section>

        <h2 class="section-title">Laporan Kehilangan</h2>

        <div class="table-wrapper">

            <table>
                <thead>
                    <tr>

                        <th>Nama Barang</th>
                        <th>Tanggal Hilang</th>
                        <th>Lokasi Hilang</th>
                        <th>Kampus</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($laporan as $item)

                        <tr>
                            <td>{{ $item->nama_barang }}</td>

                            <td>
                                {{ $item->tanggal_hilang->translatedFormat('d M Y') }}
                            </td>

                            <td>{{ $item->lokasi_hilang }}</td>

                            <td>
                                {{ $item->kampus->nama_kampus ?? '-' }}
                            </td>

                            <td>
                                @php
                                    $statusLaporanClass = match ($item->status) {
                                        'Diajukan' => 'status-pending',
                                        'Dalam Penanganan', 'Menunggu Informasi' => 'status-other',
                                        'Selesai' => 'status-approved',
                                        'Ditolak' => 'status-rejected',
                                        default => 'status-other',
                                    };
                                @endphp

                                <span class="status {{ $statusLaporanClass }}">
                                    {{ $item->status }}
                                </span>
                            </td>

                            <td>
                                @if ($item->status === 'Diajukan')

                                    <a
                                        href="{{ route('pelapor.laporan-kehilangan.edit', ['laporan' => $item->id_laporan]) }}"
                                        class="action-button"
                                    >
                                        Edit
                                    </a>

                                @else

                                @endif
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="empty">
                                Belum ada laporan kehilangan.
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>

        </div>

        <div class="pagination">
            {{ $laporan->links() }}
        </div>

    </section>

    <!-- Tabel Klaim -->
    <section class="claim-table-section">

        <h2 class="section-title">Klaim Saya</h2>

        <div class="table-wrapper">

            <table>
                <thead>
                    <tr>

                        <th>Barang</th>
                        <th>Tanggal Klaim</th>
                        <th>Status</th>
                        <th>Catatan Admin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($klaim as $item)

                        <tr>
                            <td>
                                {{ $item->barangDitemukan->nama_publik ?? '-' }}
                            </td>

                            <td>
                                {{ $item->tanggal_klaim->translatedFormat('d M Y') }}
                            </td>

                            <td>
                                @php
                                    $statusKlaim = $item->penyerahan ? 'Diserahkan' : $item->status;
                                    $statusClass = match ($statusKlaim) {
                                        'Menunggu Verifikasi' => 'status-pending',
                                        'Disetujui', 'Diserahkan' => 'status-approved',
                                        'Ditolak' => 'status-rejected',
                                        default => 'status-other',
                                    };
                                @endphp

                                <span class="status {{ $statusClass }}">
                                    {{ $statusKlaim }}
                                </span>
                            </td>

                            <td>
                                {{ $item->catatan_admin ?: '-' }}
                            </td>

                            <td>
                                <a
                                    href="{{ route('pelapor.klaim.detail', $item->id_klaim) }}"
                                    class="action-button"
                                >
                                    Detail
                                </a>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="empty">
                                Belum ada klaim barang.
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>

        </div>

    </section>

    @if ($klaim->contains(fn ($item) => $item->status === 'Disetujui' && !$item->penyerahan))
        <div class="notification">
            &#10003; Kamu memiliki klaim yang disetujui dan masih menunggu proses penyerahan barang. Silakan periksa catatan Admin Kampus pada tabel Klaim Saya untuk informasi lebih lanjut.
        </div>
    @endif

    @if ($klaim->contains(fn ($item) => $item->penyerahan !== null))
        <div class="notification">
            &#10003; Barang dari klaim yang disetujui telah diserahkan. Silakan periksa detail klaim untuk melihat informasi penyerahan.
        </div>
    @endif

</div>
@endsection
