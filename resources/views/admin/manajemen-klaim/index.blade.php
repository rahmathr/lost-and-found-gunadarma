@extends('admin.layouts.app')

@section('title', 'Verifikasi Klaim - Lost & Found')
@section('heading', 'Verifikasi Klaim - Lost & Found')

@section('pageStyles')
<style>

    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-list{ width:100%; }
    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-table-panel{
        width:100%; overflow-x:auto; background:#fff;
        border:1px solid #e2d9eb; border-radius:9px;
        box-shadow:0 2px 9px rgba(35,22,49,.05);
    }
    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-table{
        width:100%; min-width:760px; border-collapse:separate;
        border-spacing:0; background:#fff;
    }
    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-table th, .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-table td{
        padding:13px 14px; border:0; border-bottom:1px solid #e9e3ef;
        text-align:left; vertical-align:middle; line-height:1.45;
    }
    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-table th{
        background:#f0eaf6; color:#392451; font-weight:700;
        white-space:nowrap;
    }
    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-table tbody tr:last-child td{ border-bottom:0; }
    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-table tbody tr:nth-child(even){ background:#fbf9fd; }
    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-table tbody tr:hover{ background:#f5f0fa; }
    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-table th:first-child, .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-table td:first-child{ width:230px; min-width:230px; white-space:nowrap; }
    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-table th:nth-child(4), .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-table td:nth-child(4){ width:175px; white-space:nowrap; }
    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-table th:nth-child(5), .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-table td:nth-child(5){ width:230px; }
    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-table th:last-child, .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-table td:last-child{ width:125px; }
    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-status{
        display:inline-flex; align-items:center; padding:6px 10px;
        border:1px solid; border-radius:6px; font-size:13px;
        font-weight:600; line-height:1.35; white-space:nowrap;
    }
    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-status.waiting{ background:#fff3cd; border-color:#f2c14e; color:#805b00; }
    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-status.evidence{ background:#fff0d9; border-color:#e7b66c; color:#80521a; }
    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-status.approved{ background:#e2f5e8; border-color:#8bc99c; color:#21653a; }
    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-status.rejected{ background:#fde8e7; border-color:#e6a09b; color:#9b3029; }
    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-review-btn{
        display:inline-flex; align-items:center; justify-content:center;
        min-height:38px; padding:8px 14px; border:1px solid #4b2d73;
        border-radius:6px; background:#4b2d73; color:#fff;
        text-decoration:none; font-size:13px; font-weight:600;
    }
    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-review-btn:hover{ background:#62408b; }
    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-alert{
        padding:12px 14px; margin:0 0 16px; border-radius:7px;
        border:1px solid transparent;
    }
    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-alert.success{ background:#dcfce7; border-color:#a7e7bc; color:#166534; }
    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-alert.error{ background:#fee2e2; border-color:#fecaca; color:#991b1b; }
    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-empty{ text-align:center; padding:28px 16px!important; color:#756d7d; }
    .admin-kampus-admin-manajemen-klaim-index-blade-php .claim-pagination{ padding:16px 4px 2px; }

</style>
@endsection

@section('content')
<div class="admin-kampus-page admin-kampus-admin-manajemen-klaim-index-blade-php">
<section class="claim-list">

            @if(session('success'))
                <div class="claim-alert success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="claim-alert error">{{ session('error') }}</div>
            @endif

            <div class="claim-table-panel">
                <table class="claim-table">
                    <thead>
                        <tr>

                            <th>Pelapor</th>
                            <th>Barang</th>
                            <th>Tanggal Klaim</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($klaim as $item)
                            @php
                                $statusClass = match($item->status) {
                                    'Menunggu Verifikasi' => 'waiting',
                                    'Perlu Bukti Tambahan' => 'evidence',
                                    'Disetujui' => 'approved',
                                    'Ditolak' => 'rejected',
                                    default => '',
                                };
                            @endphp

                            <tr>


                                <td class="claim-reporter-cell">{{ $item->pelaporKehilangan->nama ?? '-' }}</td>

                                <td>
                                    {{ $item->barangDitemukan->nama_publik ?? '-' }}
                                </td>

                                <td>
                                    {{ $item->tanggal_klaim
                                        ? $item->tanggal_klaim->format('d M Y')
                                        : '-' }}
                                </td>

                                <td>
                                    <span class="claim-status {{ $statusClass }}">
                                        {{ $item->status }}
                                    </span>
                                </td>

                                <td>
                                    <a
                                        href="{{ route('admin.manajemen-klaim.show', $item->id_klaim) }}"
                                        class="claim-review-btn">
                                        Periksa
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="claim-empty">
                                    Belum ada pengajuan klaim.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="claim-pagination">
                    {{ $klaim->links() }}
                </div>
            </div>

        </section>

</div>
@endsection
