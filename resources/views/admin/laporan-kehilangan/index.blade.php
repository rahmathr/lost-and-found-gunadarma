@extends('admin.layouts.app')

@section('title', 'Kelola Laporan Kehilangan')
@section('heading', 'Kelola Laporan Kehilangan')

@section('pageStyles')
<style>
        .sidebar h3 { margin:5px 5px 30px; }
        .sidebar a:hover,.active { background:#7040a5; }
        .content { padding:20px; }
        .filters { display:flex; gap:10px; margin-bottom:18px; flex-wrap:wrap; }
        input,select,button,.btn {
            padding:10px; border:1px solid #999;
            border-radius:4px; font-size:13px;
        }
        input { width:300px; }
        button,.btn { cursor:pointer; background:white; color:#333; text-decoration:none; }
        .primary { background:#7040a5; color:white; border-color:#7040a5; }
        .panel { border:1px solid #bbb; overflow-x:auto; }
        table { width:100%; border-collapse:collapse; min-width:750px; }
        th,td { padding:12px 9px; border:1px solid #ccc; text-align:left; font-size:12px; }
        th { background:#ddd; }
        tr:nth-child(even) { background:#f8f8f8; }
        .status { padding:5px 9px; border:1px solid #aaa; border-radius:3px; }
        .alert { padding:12px; margin-bottom:15px; background:#dcfce7; color:#166534; }
        .pagination { padding:15px 0 0; }
        @media(max-width:700px) {
            .content { padding:10px; }
        }


        /* Filter Laporan Kehilangan: terisolasi dari CSS halaman lain. */
        .admin-content form.admin-laporan-filters {
            display: grid;
            grid-template-columns: minmax(260px, 2fr) minmax(200px, 1fr) auto auto;
            align-items: center;
            gap: 10px;
            width: 100%;
            margin: 0 0 18px;
            padding: 14px;
            border: 1px solid #eee8f2;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(35,22,49,.04);
        }
        .admin-content form.admin-laporan-filters input,
        .admin-content form.admin-laporan-filters select {
            width: 100%;
            min-width: 0;
            height: 42px;
            margin: 0;
        }
        .admin-content form.admin-laporan-filters button,
        .admin-content form.admin-laporan-filters a {
            min-width: 82px;
            min-height: 42px;
            margin: 0;
            white-space: nowrap;
        }
        @media (max-width: 680px) {
            .admin-content form.admin-laporan-filters {
                grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            }
            .admin-content form.admin-laporan-filters input,
            .admin-content form.admin-laporan-filters select {
                grid-column: span 1;
            }
        }
        @media (max-width: 560px) {
            .admin-content form.admin-laporan-filters {
                grid-template-columns: 1fr;
                padding: 12px;
            }
            .admin-content form.admin-laporan-filters button,
            .admin-content form.admin-laporan-filters a {
                width: 100%;
            }
        }

</style>
@endsection

@section('content')
<section class="content">

            @if(session('success'))
                <div class="alert">{{ session('success') }}</div>
            @endif

            <form method="GET" action="{{ route('admin.laporan-kehilangan.index') }}" class="lf-filter">
                <div class="lf-filter__field lf-filter__field--search">
                    <label for="laporan-search">Cari laporan</label>
                    <input id="laporan-search" type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama barang / pelapor...">
                </div>
                <div class="lf-filter__field">
                    <label for="laporan-status">Status</label>
                    <select id="laporan-status" name="status">
                        <option value="">Semua Status</option>
                        @foreach($daftarStatus as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="lf-filter__actions">
                    <button type="submit">Terapkan</button>
                    <a href="{{ route('admin.laporan-kehilangan.index') }}">Reset</a>
                </div>
            </form>

            <div class="panel">
                <table>
                    <thead>
                        <tr>
                            <th>Pelapor</th>
                            <th>Barang</th>
                            <th>Tgl Hilang</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($laporan as $item)
                            <tr>
                                <td>{{ $item->pelapor->nama ?? '-' }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>
                                    {{ $item->tanggal_hilang
                                        ? \Carbon\Carbon::parse($item->tanggal_hilang)->format('d M Y')
                                        : '-' }}
                                </td>
                                <td>{{ $item->lokasi_hilang }}</td>
                                <td><span class="status {{ match ($item->status) {
                                    'Diajukan' => 'status-pending',
                                    'Dalam Penanganan', 'Menunggu Informasi' => 'status-other',
                                    'Selesai' => 'status-approved',
                                    'Ditolak' => 'status-rejected',
                                    default => 'status-other',
                                } }}">{{ $item->status }}</span></td>
                                <td>
                                    <a class="btn primary"
                                       href="{{ route('admin.laporan-kehilangan.show', $item->id_laporan) }}">
                                        Proses
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center;">
                                    Belum ada laporan kehilangan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($laporan->hasPages())
                    <div class="pagination">
                        {{ $laporan->withQueryString()->links() }}
                    </div>
                @endif
            </div>

        </section>
@endsection
