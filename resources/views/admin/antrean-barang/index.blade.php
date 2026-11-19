@extends('admin.layouts.app')

@section('title', 'Antrean Barang')
@section('heading', 'Antrean Barang')

@section('pageStyles')
<style>

        .container {
            max-width: 1250px;
            margin: auto;
            padding: 25px;
            background: white;
            border: 1px solid #ccc;
        }

        h1 {
            margin-top: 0;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin: 20px 0;
        }

        .stat {
            padding: 15px;
            border: 1px solid #bbb;
            background: #f7f7f7;
        }

        .stat strong {
            display: block;
            margin-bottom: 8px;
            font-size: 25px;
        }

        .stat span {
            font-size: 12px;
            color: #555;
        }

        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 20px 0;
        }

        input, select, button, a {
            padding: 10px 12px;
            font-size: 13px;
            border-radius: 4px;
        }

        input, select {
            border: 1px solid #aaa;
        }

        button {
            border: none;
            background: #7040a5;
            color: white;
            cursor: pointer;
        }

        a {
            display: inline-block;
            text-decoration: none;
        }

        .primary {
            background: #7040a5;
            color: white;
        }

        .secondary {
            background: #666;
            color: white;
        }

        .outline {
            border: 1px solid #555;
            color: #333;
            background: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 12px;
        }

        th, td {
            padding: 11px 9px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background: #ddd;
        }

        tr:nth-child(even) {
            background: #f8f8f8;
        }

        .status {
            display: inline-block;
            padding: 5px 8px;
            border: 1px solid;
            border-radius: 3px;
            font-size: 11px;
            white-space: nowrap;
        }

        .waiting {
            background: #fff2cc;
            border-color: #e6b422;
        }

        .approved {
            background: #d9ead3;
            border-color: #6aa84f;
        }

        .rejected {
            background: #f4cccc;
            border-color: #cc0000;
        }

        .process {
            background: #eadcf0;
            border-color: #9b59b6;
        }

        .alert {
            padding: 12px;
            margin: 15px 0;
            background: #f0e8f8;
            border: 1px solid #c9b2e6;
            font-size: 13px;
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination nav {
            display: flex;
            justify-content: center;
        }

        .pagination nav div {
            display: flex;
            gap: 5px;
        }

        @media (max-width: 800px) {

            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .table-wrapper {
                overflow-x: auto;
            }
        }


        /* Filter Antrean Barang: grid responsif khusus halaman ini. */
        .admin-content form.admin-antrean-filters {
            display: grid;
            grid-template-columns: minmax(220px, 1.6fr) minmax(170px, 1fr) minmax(160px, 1fr) auto auto;
            align-items: center;
            gap: 10px;
            width: 100%;
            margin: 20px 0;
            padding: 14px;
            border: 1px solid #eee8f2;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(35,22,49,.04);
        }
        .admin-content form.admin-antrean-filters input,
        .admin-content form.admin-antrean-filters select {
            width: 100%;
            min-width: 0;
            height: 42px;
            margin: 0;
        }
        .admin-content form.admin-antrean-filters button,
        .admin-content form.admin-antrean-filters a {
            min-width: 82px;
            min-height: 42px;
            margin: 0;
            white-space: nowrap;
        }
        @media (max-width: 760px) {
            .admin-content form.admin-antrean-filters {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .admin-content form.admin-antrean-filters input {
                grid-column: 1 / -1;
            }
        }
        @media (max-width: 560px) {
            .admin-content form.admin-antrean-filters {
                grid-template-columns: 1fr;
                padding: 12px;
            }
            .admin-content form.admin-antrean-filters input {
                grid-column: auto;
            }
            .admin-content form.admin-antrean-filters button,
            .admin-content form.admin-antrean-filters a {
                width: 100%;
            }
        }

</style>
@endsection

@section('content')
<div class="container">

    <h1>Antrean Barang</h1>

    <p>
        Kelola barang temuan yang diterima dari Satpam maupun secara langsung.
    </p>

    <a href="{{ route('dashboard.admin') }}" class="secondary">
        Kembali ke Dashboard
    </a>

    <a href="{{ route('admin.barang-diterima.create') }}" class="primary">
        + Catat Barang Langsung
    </a>

    @if (session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    {{-- Statistik --}}
    <div class="stats">

        <div class="stat">
            <strong>{{ $jumlahSemua }}</strong>
            <span>Total Barang</span>
        </div>

        <div class="stat">
            <strong>{{ $jumlahMenunggu }}</strong>
            <span>Diterima Satpam</span>
        </div>

        <div class="stat">
            <strong>{{ $jumlahDipublikasikan }}</strong>
            <span>Dipublikasikan</span>
        </div>

        <div class="stat">
            <strong>{{ $jumlahDiserahkan }}</strong>
            <span>Sudah Diserahkan</span>
        </div>

    </div>

    {{-- Filter --}}
    <form action="{{ route('admin.antrean-barang.index') }}" method="GET" class="lf-filter">
        <div class="lf-filter__field lf-filter__field--search">
            <label for="antrean-cari">Cari barang</label>
            <input id="antrean-cari" type="text" name="cari" placeholder="Cari nama barang..." value="{{ request('cari') }}">
        </div>
        <div class="lf-filter__field">
            <label for="antrean-status">Status</label>
            <select id="antrean-status" name="status">
                <option value="">Semua Status</option>
                <option value="Diterima Satpam" @selected(request('status') === 'Diterima Satpam')>Diterima Satpam</option>
                <option value="Dipublikasikan" @selected(request('status') === 'Dipublikasikan')>Dipublikasikan</option>
                <option value="Ditolak" @selected(request('status') === 'Ditolak')>Ditolak</option>
                <option value="Dalam Proses Penyerahan" @selected(request('status') === 'Dalam Proses Penyerahan')>Dalam Proses Penyerahan</option>
                <option value="Diserahkan" @selected(request('status') === 'Diserahkan')>Diserahkan</option>
            </select>
        </div>
        <div class="lf-filter__field">
            <label for="antrean-sumber">Sumber</label>
            <select id="antrean-sumber" name="sumber">
                <option value="">Semua Sumber</option>
                <option value="Satpam" @selected(request('sumber') === 'Satpam')>Satpam</option>
                <option value="Langsung" @selected(request('sumber') === 'Langsung')>Langsung</option>
            </select>
        </div>
        <div class="lf-filter__actions">
            <button type="submit">Terapkan</button>
            <a href="{{ route('admin.antrean-barang.index') }}">Reset</a>
        </div>
    </form>

    {{-- Tabel Barang --}}
    <div class="table-wrapper">

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Barang</th>
                    <th>Sumber</th>
                    <th>Penerima</th>
                    <th>Tanggal Ditemukan</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($barang as $item)

                    @php
                        $statusClass = match ($item->status) {
                            'Diterima Satpam' => 'waiting',
                            'Dipublikasikan' => 'approved',
                            'Ditolak' => 'rejected',
                            'Dalam Proses Penyerahan' => 'process',
                            'Diserahkan' => 'approved',
                            default => '',
                        };

                        if ($item->sumber_penerimaan === 'Satpam') {
                            $namaPenerima = $item->satpam->nama ?? '-';
                        } else {
                            $namaPenerima = $item->adminPenerima->nama ?? '-';
                        }
                    @endphp

                    <tr>
                        <td>{{ $barang->firstItem() + $loop->index }}</td>


                        <td>{{ $item->nama_publik }}</td>

                        <td>{{ $item->sumber_penerimaan }}</td>

                        <td>{{ $namaPenerima }}</td>

                        <td>
                            {{ $item->tanggal_ditemukan->format('d-m-Y') }}
                        </td>

                        <td>{{ $item->lokasi_ditemukan }}</td>

                        <td>
                            <span class="status {{ $statusClass }}">
                                {{ $item->status }}
                            </span>
                        </td>

                        <td>
                            @if (
                                $item->sumber_penerimaan === 'Satpam'
                                && $item->status === 'Diterima Satpam'
                            )
                                <a
                                    href="{{ route('admin.validasi-barang.show', $item->id_barang) }}"
                                    class="primary">
                                    Periksa
                                </a>

                            @elseif (
                                $item->sumber_penerimaan === 'Langsung'
                                && $item->status === 'Dipublikasikan'
                            )
                                <a
                                    href="{{ route('admin.barang-diterima.edit', $item->id_barang) }}"
                                    class="outline">
                                    Detail
                                </a>

                            @else
                                <span>-</span>
                            @endif
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="9" style="text-align:center;">
                            Belum ada barang yang tercatat.
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>

    </div>

    <div class="pagination">
        {{ $barang->links() }}
    </div>

</div>
@endsection
