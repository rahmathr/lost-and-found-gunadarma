@extends('admin.layouts.app')

@section('title', 'Antrean Barang')
@section('heading', 'Antrean Barang')

@section('pageStyles')
<style>

        .brand {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 30px;
            padding: 5px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #3374c5;
        }

        .content {
            padding: 20px;
        }

        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 18px;
        }

        input,
        select {
            padding: 10px;
            border: 1px solid #aaa;
            border-radius: 4px;
            background: white;
            font-size: 13px;
        }

        .search-input {
            width: 300px;
        }

        .filter-form select {
            min-width: 180px;
        }

        button,
        .btn {
            display: inline-block;
            padding: 10px 15px;
            border: 1px solid #777;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            font-size: 13px;
            background: white;
            color: #333;
        }

        .btn-primary {
            background: #3374c5;
            color: white;
            border-color: #3374c5;
        }

        .btn-primary:hover {
            background: #245da2;
        }

        .btn-detail {
            padding: 7px 12px;
        }

        .table-wrapper {
            overflow-x: auto;
            background: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th,
        td {
            padding: 11px 9px;
            border: 1px solid #ccc;
            text-align: left;
            white-space: nowrap;
        }

        th {
            background: #ddd;
        }

        tbody tr:nth-child(even) {
            background: #f8f8f8;
        }

        .status-cell {
            text-align: center !important;
            vertical-align: middle;
        }

        .status {
            display: block;
            width: 100px;
            min-width: 100px;
            max-width: 100%;
            box-sizing: border-box;
            margin: 0 auto;
            text-align: center;
            padding: 5px 8px;
            border-radius: 3px;
            font-size: 11px;
            border: 1px solid;
        }

        .waiting {
            background: #fff2cc;
            border-color: #e5b83b;
        }

        .checking {
            background: #e8d9f0;
            border-color: #a477c1;
        }

        .ready {
            background: #d9ead3;
            border-color: #70ad47;
        }

        .published {
            background: #d9eafc;
            border-color: #6d9eeb;
        }

        .rejected {
            background: #f4cccc;
            border-color: #cc6666;
        }

        .handed {
            background: #d9eafc;
            border-color: #6d9eeb;
        }

        .alert {
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .pagination {
            margin-top: 18px;
        }

        .pagination nav {
            display: flex;
            justify-content: center;
        }

        @media (max-width: 750px) {

            .content {
                padding: 12px;
            }

            .search-input {
                width: 100%;
            }
        }


        /* Filter Validasi Barang: aturan khusus, tidak menyentuh sidebar/layout. */
        .admin-content form.admin-validasi-filters {
            display: grid;
            grid-template-columns: minmax(220px, 2fr) minmax(170px, 1.15fr) minmax(150px, 1fr) auto auto auto;
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
        .admin-content form.admin-validasi-filters input,
        .admin-content form.admin-validasi-filters select {
            width: 100%;
            min-width: 0;
            height: 42px;
            margin: 0;
        }
        .admin-content form.admin-validasi-filters button,
        .admin-content form.admin-validasi-filters a {
            min-width: 78px;
            min-height: 42px;
            margin: 0;
            white-space: nowrap;
        }
        @media (max-width: 1100px) {
            .admin-content form.admin-validasi-filters {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .admin-content form.admin-validasi-filters input {
                grid-column: 1 / -1;
            }
        }
        @media (max-width: 560px) {
            .admin-content form.admin-validasi-filters {
                grid-template-columns: 1fr;
                padding: 12px;
            }
            .admin-content form.admin-validasi-filters input {
                grid-column: auto;
            }
            .admin-content form.admin-validasi-filters button,
            .admin-content form.admin-validasi-filters a {
                width: 100%;
            }
        }

</style>
@endsection

@section('content')
<section class="content">

            @if (session('success'))
                <div class="alert success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert error">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form pencarian dan filter -->
            <form action="{{ route('admin.validasi-barang.index') }}" method="GET" class="lf-filter">
                <div class="lf-filter__field lf-filter__field--search">
                    <label for="validasi-cari">Cari barang</label>
                    <input id="validasi-cari" type="text" name="cari" placeholder="Cari nama barang..." value="{{ request('cari') }}">
                </div>
                <div class="lf-filter__field">
                    <label for="validasi-status">Status</label>
                    <select id="validasi-status" name="status">
                        <option value="">Semua Status</option>
                        @foreach ($statusPilihan as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="lf-filter__field">
                    <label for="validasi-sumber">Sumber</label>
                    <select id="validasi-sumber" name="sumber">
                        <option value="">Semua Sumber</option>
                        <option value="Satpam" @selected(request('sumber') === 'Satpam')>Satpam</option>
                        <option value="Langsung" @selected(request('sumber') === 'Langsung')>Langsung</option>
                    </select>
                </div>
                <div class="lf-filter__actions">
                    <button type="submit">Terapkan</button>
                    <a href="{{ route('admin.validasi-barang.index') }}">Reset</a>
                    <a class="lf-filter__secondary" href="{{ route('admin.barang-diterima.create') }}">+ Catat Barang Langsung</a>
                </div>
            </form>

            <!-- Tabel antrean barang -->
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Sumber</th>
                            <th>Tgl Diterima</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($barangTemuan as $item)
                            <tr>
                                <td>{{ $item->nama_publik }}</td>

                                <td>
                                    @if ($item->sumber_penerimaan === 'Satpam')
                                        Satpam
                                        ({{ $item->satpam->nama ?? '-' }})
                                    @else
                                        Langsung
                                        ({{ $item->adminPenerima->nama ?? '-' }})
                                    @endif
                                </td>

                                <td>
                                    {{ $item->tanggal_ditemukan->format('d M Y') }}
                                </td>

                                <td>{{ $item->lokasi_ditemukan }}</td>

                                <td class="status-cell">
                                    @php
                                        $statusClass = match ($item->status) {
                                            'Diterima Satpam' => 'waiting',
                                            'Dalam Pemeriksaan' => 'checking',
                                            'Siap Dipublikasikan' => 'ready',
                                            'Dipublikasikan' => 'published',
                                            'Dalam Proses Penyerahan',
                                            'Diserahkan' => 'handed',
                                            'Ditolak' => 'rejected',
                                            default => '',
                                        };
                                    @endphp

                                    <span class="status {{ $statusClass }}">
                                        {{ $item->status }}
                                    </span>
                                </td>

                                <td>
                                    <a
                                        href="{{ route('admin.validasi-barang.show', $item->id_barang) }}"
                                        class="btn btn-detail">

                                        @if ($item->status === 'Diterima Satpam')
                                            Periksa
                                        @elseif ($item->status === 'Dalam Pemeriksaan')
                                            Lanjutkan
                                        @elseif ($item->status === 'Siap Dipublikasikan')
                                            Publikasikan
                                        @else
                                            Detail
                                        @endif

                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center;padding:25px;">
                                    Tidak ada barang yang sesuai dengan pencarian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $barangTemuan->links() }}
            </div>

            <p style="font-size:12px;color:#777;">
                Menampilkan {{ $barangTemuan->count() }}
                dari {{ $barangTemuan->total() }} data barang.
            </p>

        </section>
@endsection
