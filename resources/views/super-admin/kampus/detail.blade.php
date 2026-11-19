@extends('super-admin.layouts.app')

@section('title', 'Detail Kampus - ' . $dataKampus->nama_kampus)
@section('heading', 'Detail Kampus')

@push('styles')
<style>
    .kampus-detail-intro{display:flex;justify-content:space-between;align-items:flex-start;gap:16px;flex-wrap:wrap;margin-bottom:18px}
    .kampus-detail-name{margin:0 0 6px;color:#30283a;font-size:20px}
    .kampus-detail-address{margin:0;color:#6b6478;font-size:13px}
    .kampus-detail-back{display:inline-block;padding:9px 14px;border:1px solid #4b2d73;border-radius:6px;background:#4b2d73;color:#fff;text-decoration:none;font-size:13px;font-weight:600}
    .kampus-detail-back:hover{background:#62408b;color:#fff}
    .kampus-detail-stats{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px;margin-bottom:20px}
    .kampus-detail-stat{padding:16px;background:#fff;border:1px solid #eee8f2;border-radius:9px;box-shadow:0 2px 8px rgba(35,22,49,.05)}
    .kampus-detail-stat strong{display:block;margin-bottom:7px;color:#4b2d73;font-size:25px}
    .kampus-detail-stat span{color:#62596b;font-size:13px}
    .kampus-detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
    .kampus-detail-panel{margin-bottom:18px;overflow:hidden;background:#fff;border:1px solid #eee8f2;border-radius:9px;box-shadow:0 2px 8px rgba(35,22,49,.05)}
    .kampus-detail-panel h2{margin:0;padding:13px 16px;background:#f2edf7;border-bottom:1px solid #e5e1e9;color:#30283a;font-size:15px}
    .kampus-detail-panel-body{padding:15px 16px}
    .kampus-detail-table-wrap{overflow-x:auto}
    .kampus-detail-table{width:100%;border-collapse:collapse;font-size:13px}
    .kampus-detail-table th,.kampus-detail-table td{padding:10px 11px;border:1px solid #e5e1e9;text-align:left;vertical-align:top}
    .kampus-detail-table th{background:#f2edf7;color:#30283a;white-space:nowrap}
    .kampus-detail-table tbody tr:nth-child(even){background:#faf8fc}
    .kampus-detail-empty{padding:18px;text-align:center;color:#766b87}
    .kampus-detail-list{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    .kampus-detail-person{padding:12px;border:1px solid #e8e1ef;border-radius:7px}
    .kampus-detail-person strong{display:block;margin-bottom:5px;color:#30283a}
    .kampus-detail-person span{display:block;color:#6b6478;font-size:12px;overflow-wrap:anywhere}
    .kampus-detail-status{display:inline-block;padding:4px 8px;border-radius:5px;background:#f2edf7;color:#4b2d73;font-size:12px;white-space:nowrap}
    @media(max-width:900px){.kampus-detail-stats{grid-template-columns:repeat(2,minmax(0,1fr))}}
    @media(max-width:650px){.kampus-detail-grid{grid-template-columns:1fr}.kampus-detail-list{grid-template-columns:1fr}}
    @media(max-width:480px){.kampus-detail-stats{grid-template-columns:1fr}}
</style>
@endpush

@section('content')
    <div class="kampus-detail-intro">
        <div>
            <h2 class="kampus-detail-name">{{ $dataKampus->nama_kampus }}</h2>
            <p class="kampus-detail-address">{{ $dataKampus->alamat ?: 'Alamat belum tersedia.' }}</p>
        </div>
        <a class="kampus-detail-back" href="{{ route('dashboard.super-admin') }}">Kembali ke Dashboard</a>
    </div>

    <div class="kampus-detail-stats">
        <div class="kampus-detail-stat"><strong>{{ $statistik['total_barang'] }}</strong><span>Total Barang Ditemukan</span></div>
        <div class="kampus-detail-stat"><strong>{{ $statistik['barang_dipublikasikan'] }}</strong><span>Barang Dipublikasikan</span></div>
        <div class="kampus-detail-stat"><strong>{{ $statistik['barang_diserahkan'] }}</strong><span>Barang Diserahkan</span></div>
        <div class="kampus-detail-stat"><strong>{{ $statistik['laporan_aktif'] }}</strong><span>Laporan Kehilangan Aktif</span></div>
        <div class="kampus-detail-stat"><strong>{{ $statistik['klaim_menunggu'] }}</strong><span>Klaim Menunggu Verifikasi</span></div>
        <div class="kampus-detail-stat"><strong>{{ $statistik['klaim_disetujui'] }}</strong><span>Klaim Disetujui</span></div>
        <div class="kampus-detail-stat"><strong>{{ $dataKampus->adminKampus->count() }}</strong><span>Akun Admin Kampus</span></div>
        <div class="kampus-detail-stat"><strong>{{ $dataKampus->satpam->count() }}</strong><span>Petugas Satpam</span></div>
    </div>

    <div class="kampus-detail-grid">
        <section class="kampus-detail-panel">
            <h2>Admin Kampus</h2>
            <div class="kampus-detail-panel-body">
                @if ($dataKampus->adminKampus->isNotEmpty())
                    <div class="kampus-detail-list">
                        @foreach ($dataKampus->adminKampus as $admin)
                            <div class="kampus-detail-person">
                                <strong>{{ $admin->nama }}</strong>
                                <span>{{ $admin->email }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="kampus-detail-empty">Belum ada akun Admin Kampus.</div>
                @endif
            </div>
        </section>

        <section class="kampus-detail-panel">
            <h2>Petugas Satpam</h2>
            <div class="kampus-detail-panel-body">
                @if ($dataKampus->satpam->isNotEmpty())
                    <div class="kampus-detail-list">
                        @foreach ($dataKampus->satpam as $satpam)
                            <div class="kampus-detail-person">
                                <strong>{{ $satpam->nama }}</strong>
                                <span>{{ $satpam->email }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="kampus-detail-empty">Belum ada petugas Satpam.</div>
                @endif
            </div>
        </section>
    </div>

    <section class="kampus-detail-panel">
        <h2>Barang Temuan Terbaru</h2>
        <div class="kampus-detail-table-wrap">
            <table class="kampus-detail-table">
                <thead><tr><th>Nama Publik</th><th>Kategori</th><th>Tanggal Ditemukan</th><th>Lokasi</th><th>Sumber</th><th>Status</th></tr></thead>
                <tbody>
                @forelse ($barangTerbaru as $barang)
                    <tr>
                        <td>{{ $barang->nama_publik }}</td><td>{{ $barang->kategori }}</td>
                        <td>{{ $barang->tanggal_ditemukan?->format('d-m-Y') ?? '-' }}</td><td>{{ $barang->lokasi_ditemukan }}</td>
                        <td>{{ $barang->sumber_penerimaan }}</td><td><span class="kampus-detail-status {{ match ($barang->status) {
                            'Ditolak' => 'status-rejected',
                            'Dipublikasikan', 'Diserahkan' => 'status-approved',
                            'Dalam Proses Penyerahan' => 'status-other',
                            default => 'status-pending',
                        } }}">{{ $barang->status }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="kampus-detail-empty">Belum ada barang temuan.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="kampus-detail-panel">
        <h2>Laporan Kehilangan Terbaru</h2>
        <div class="kampus-detail-table-wrap">
            <table class="kampus-detail-table">
                <thead><tr><th>Nama Barang</th><th>Tanggal Hilang</th><th>Lokasi</th><th>Status</th></tr></thead>
                <tbody>
                @forelse ($laporanTerbaru as $laporan)
                    <tr>
                        <td>{{ $laporan->nama_barang }}</td>
                        <td>{{ $laporan->tanggal_hilang?->format('d-m-Y') ?? '-' }}</td>
                        <td>{{ $laporan->lokasi_hilang }}</td><td><span class="kampus-detail-status {{ match ($laporan->status) {
                            'Diajukan' => 'status-pending',
                            'Dalam Penanganan', 'Menunggu Informasi' => 'status-other',
                            'Selesai' => 'status-approved',
                            'Ditolak' => 'status-rejected',
                            default => 'status-other',
                        } }}">{{ $laporan->status }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="kampus-detail-empty">Belum ada laporan kehilangan.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
