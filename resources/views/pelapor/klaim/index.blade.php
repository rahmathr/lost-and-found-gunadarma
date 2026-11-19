@extends('pelapor.layouts.app')

@section('title', 'Barang Tersedia - Lost & Found Gundar')
@section('heading', 'Barang Tersedia')
@section('active', 'barang')

@section('content')
<div class="pelapor-content-panel pelapor-klaim-tersedia">

<h1>Barang Ditemukan yang Tersedia</h1>

    <p>
        Berikut barang temuan yang sudah divalidasi dan dapat diajukan klaimnya.
    </p>

    <p>
        <a href="{{ route('dashboard.pelapor') }}" class="secondary">
            Kembali ke Dashboard
        </a>

        <a href="{{ route('pelapor.klaim.riwayat') }}" class="primary">
            Riwayat Klaim Saya
        </a>
    </p>

    <style>
        /* Khusus tabel barang tersedia: cegah tombol terpotong menjadi dua baris. */
        .pelapor-klaim-tersedia table { table-layout: auto; }
        .pelapor-klaim-tersedia th:last-child,
        .pelapor-klaim-tersedia td:last-child { width: 132px; min-width: 132px; white-space: nowrap; }
        .pelapor-klaim-tersedia .detail-barang-action {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            width: auto !important;
            min-width: 108px;
            min-height: 40px;
            padding: 10px 16px !important;
            box-sizing: border-box;
            white-space: nowrap !important;
            word-break: keep-all !important;
            overflow-wrap: normal !important;
            line-height: 1.2;
            text-align: center;
        }
        @media (max-width: 700px) {
            .pelapor-klaim-tersedia th:last-child,
            .pelapor-klaim-tersedia td:last-child { width: 132px; min-width: 132px; }
        }
    </style>

    <table>
        <thead>
            <tr>
                <th>No.</th>

                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Kampus</th>
                <th>Tanggal Ditemukan</th>
                <th>Lokasi</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($barangTemuan as $item)
                <tr>
                    <td>{{ $barangTemuan->firstItem() + $loop->index }}</td>

                    <td>{{ $item->nama_publik }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ $item->kampus->nama_kampus ?? '-' }}</td>
                    <td>{{ $item->tanggal_ditemukan->format('d-m-Y') }}</td>
                    <td>{{ $item->lokasi_ditemukan }}</td>
                    <td>
                        <a
                            href="{{ route('pelapor.klaim.show', $item->id_barang) }}"
                            class="primary detail-barang-action">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;">
                        Belum ada barang yang tersedia untuk diklaim.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:20px;">
        {{ $barangTemuan->links() }}
    </div>

</div>
@endsection
