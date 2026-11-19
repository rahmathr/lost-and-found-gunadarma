@extends('pelapor.layouts.app')

@section('title', 'Riwayat Klaim Saya - Lost & Found Gundar')
@section('heading', 'Riwayat Klaim Saya')
@section('active', 'riwayat')

@push('styles')
<style>
.pelapor-content-panel .claim-status-badge{display:inline-flex;align-items:center;justify-content:center;min-width:94px;max-width:100%;padding:6px 11px;border:1px solid transparent;border-radius:999px;font-size:12px;font-weight:700;line-height:1.25;text-align:center;white-space:normal;overflow-wrap:anywhere}
.pelapor-content-panel .claim-status-badge.is-done{background:#eaf8ef;border-color:#b7e4c7;color:#166534}
.pelapor-content-panel .claim-status-badge.is-rejected{background:#fff0f0;border-color:#f2c0c0;color:#991b1b}
.pelapor-content-panel .claim-status-badge.is-pending{background:#fff7df;border-color:#f2d98d;color:#8a6200}
.pelapor-content-panel .claim-status-badge.is-progress{background:#f2eafa;border-color:#ddc6ef;color:#63368b}
</style>
@endpush

@section('content')
<div class="pelapor-content-panel">

    <p>
        <a href="{{ route('dashboard.pelapor') }}" class="secondary">
            Kembali ke Dashboard
        </a>

        <a href="{{ route('pelapor.klaim.index') }}" class="secondary">
            Lihat Barang Tersedia
        </a>
    </p>

    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Barang</th>
                <th>Tanggal Klaim</th>
                <th>Status</th>
                <th>Catatan Admin</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($klaim as $item)
                <tr>
                    <td>{{ $klaim->firstItem() + $loop->index }}</td>
                    <td>{{ $item->barangDitemukan->nama_publik ?? '-' }}</td>
                    <td>{{ $item->tanggal_klaim->format('d-m-Y H:i') }}</td>
                    @php
                        $statusRiwayat = $item->penyerahan ? 'Diserahkan' : $item->status;
                        $kelasStatus = match ($statusRiwayat) {
                            'Diserahkan', 'Disetujui' => 'is-done',
                            'Ditolak' => 'is-rejected',
                            'Menunggu Verifikasi', 'Diajukan' => 'is-pending',
                            default => 'is-progress',
                        };
                    @endphp
                    <td style="text-align:center;vertical-align:middle;">
                        <span class="claim-status-badge {{ $kelasStatus }}">{{ $statusRiwayat }}</span>
                    </td>
                    <td>{{ $item->catatan_admin ?? '-' }}</td>
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
                    <td colspan="6" style="text-align:center;">
                        Kamu belum pernah mengajukan klaim.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:20px;">
        {{ $klaim->links() }}
    </div>

</div>
@endsection
