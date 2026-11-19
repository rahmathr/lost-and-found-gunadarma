@extends('admin.layouts.app')

@section('title', 'Riwayat Penyerahan')
@section('heading', 'Riwayat Penyerahan')

@section('pageStyles')

<style>
    .admin-kampus-admin-penyerahan-riwayat-blade-php .riwayat-penyerahan-page{
        width: 100%;
    }

    .admin-kampus-admin-penyerahan-riwayat-blade-php .riwayat-penyerahan-page .page-description{
        margin: 0 0 18px;
        color: #555;
        font-size: 14px;
    }

    .admin-kampus-admin-penyerahan-riwayat-blade-php .riwayat-penyerahan-page .alert-success{
        padding: 12px 15px;
        margin-bottom: 18px;
        background: #dcfce7;
        color: #166534;
        border: 1px solid #86efac;
        border-radius: 4px;
    }

    .admin-kampus-admin-penyerahan-riwayat-blade-php .riwayat-penyerahan-page .table-wrapper{
        width: 100%;
        overflow-x: auto;
        background: #fff;
    }

    .admin-kampus-admin-penyerahan-riwayat-blade-php .riwayat-penyerahan-page table{
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        font-size: 13px;
    }

    .admin-kampus-admin-penyerahan-riwayat-blade-php .riwayat-penyerahan-page th, .admin-kampus-admin-penyerahan-riwayat-blade-php .riwayat-penyerahan-page td{
        padding: 12px;
        border: 1px solid #ccc;
        text-align: left;
        vertical-align: top;
    }

    .admin-kampus-admin-penyerahan-riwayat-blade-php .riwayat-penyerahan-page th{
        background: #ddd;
        font-weight: 700;
    }

    .admin-kampus-admin-penyerahan-riwayat-blade-php .riwayat-penyerahan-page tbody tr:nth-child(even){
        background: #f8f8f8;
    }

    .admin-kampus-admin-penyerahan-riwayat-blade-php .riwayat-penyerahan-page .empty-row{
        padding: 25px;
        text-align: center;
        color: #777;
    }

    .admin-kampus-admin-penyerahan-riwayat-blade-php .riwayat-penyerahan-page .pagination-wrapper{
        margin-top: 20px;
    }
</style>
@endsection

@section('content')
<div class="admin-kampus-page admin-kampus-admin-penyerahan-riwayat-blade-php">

<div class="riwayat-penyerahan-page">

    <p class="page-description">
        Berikut daftar barang yang sudah diserahkan kepada Pelapor.
    </p>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('admin.penyerahan.riwayat') }}" class="lf-filter">
        <div>
            <label for="q">Cari barang / nama Pelapor</label>
            <input id="q" name="q" type="search" value="{{ request('q') }}" placeholder="Masukkan kata kunci">
        </div>
        <div>
            <label for="tanggal_mulai">Dari tanggal</label>
            <input id="tanggal_mulai" name="tanggal_mulai" type="date" value="{{ request('tanggal_mulai') }}">
        </div>
        <div>
            <label for="tanggal_selesai">Sampai tanggal</label>
            <input id="tanggal_selesai" name="tanggal_selesai" type="date" value="{{ request('tanggal_selesai') }}">
        </div>
        <button type="submit" class="primary">Terapkan</button>
        <a href="{{ route('admin.penyerahan.riwayat') }}" class="outline">Reset</a>
    </form>

    <div class="table-wrapper">

        <table>
            <thead>
                <tr>
                    <th>No.</th>


                    <th>Nama Barang</th>
                    <th>Nama Pelapor</th>
                    <th>Tanggal Penyerahan</th>
                    <th>Catatan</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($penyerahan as $item)
                    <tr>
                        <td>
                            {{ $penyerahan->firstItem() + $loop->index }}
                        </td>

                        <td>
                            {{ $item->klaim->barangDitemukan->nama_publik ?? '-' }}
                        </td>

                        <td>
                            {{ $item->klaim->pelaporKehilangan->nama ?? '-' }}
                        </td>

                        <td>
                            {{ $item->tanggal_penyerahan->format('d-m-Y H:i') }}
                        </td>

                        <td>{{ $item->catatan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-row">
                            Belum ada riwayat penyerahan barang.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <div class="pagination-wrapper">
        {{ $penyerahan->links() }}
    </div>

</div>


</div>
@endsection
?>