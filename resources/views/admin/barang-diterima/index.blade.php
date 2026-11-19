@extends('admin.layouts.app')

@section('title', 'Barang Diterima Langsung')
@section('heading', 'Barang Diterima Langsung')

@section('pageStyles')
<style>

        .admin-kampus-admin-barang-diterima-index-blade-php .container{
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
        }

        .admin-kampus-admin-barang-diterima-index-blade-php table{
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .admin-kampus-admin-barang-diterima-index-blade-php th, .admin-kampus-admin-barang-diterima-index-blade-php td{
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .admin-kampus-admin-barang-diterima-index-blade-php th{
            background: #eee;
        }

        .admin-kampus-admin-barang-diterima-index-blade-php a, .admin-kampus-admin-barang-diterima-index-blade-php button{
            display: inline-block;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .admin-kampus-admin-barang-diterima-index-blade-php .primary{
            background: #2563eb;
            color: white;
        }

        .admin-kampus-admin-barang-diterima-index-blade-php .warning{
            background: #d97706;
            color: white;
        }

        .admin-kampus-admin-barang-diterima-index-blade-php .danger{
            background: #dc2626;
            color: white;
        }

        .admin-kampus-admin-barang-diterima-index-blade-php .secondary{
            background: #6b7280;
            color: white;
        }

        .admin-kampus-admin-barang-diterima-index-blade-php .success{
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            margin-top: 15px;
        }

        .admin-kampus-admin-barang-diterima-index-blade-php .error{
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            margin-top: 15px;
        }

</style>
@endsection

@section('content')
<div class="admin-kampus-page admin-kampus-admin-barang-diterima-index-blade-php">
<div class="container">

    <h1>Barang Diterima Langsung</h1>

    <p>
        <a href="{{ route('dashboard.admin') }}" class="secondary">
            Kembali ke Dashboard
        </a>

        <a href="{{ route('admin.barang-diterima.create') }}" class="primary">
            + Catat Barang Baru
        </a>
    </p>

    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No.</th>

                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Tanggal Ditemukan</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($barangTemuan as $item)
                <tr>
                    <td>{{ $barangTemuan->firstItem() + $loop->index }}</td>

                    <td>{{ $item->nama_publik }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ $item->tanggal_ditemukan->format('d-m-Y') }}</td>
                    <td>{{ $item->lokasi_ditemukan }}</td>
                    <td><span class="status {{ match ($item->status) {
                        'Ditolak' => 'status-rejected',
                        'Dipublikasikan', 'Diserahkan' => 'status-approved',
                        'Dalam Proses Penyerahan' => 'status-other',
                        default => 'status-pending',
                    } }}">{{ $item->status }}</span></td>
                    <td>
                        <a
                            href="{{ route('admin.barang-diterima.edit', $item->id_barang) }}"
                            class="warning">
                            Edit
                        </a>

                        <form
                            action="{{ route('admin.barang-diterima.destroy', $item->id_barang) }}"
                            method="POST"
                            style="display:inline;"
                            onsubmit="return confirm('Yakin ingin menghapus barang ini?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="danger btn-delete">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;">
                        Belum ada barang yang diterima langsung.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:20px;">
        {{ $barangTemuan->links() }}
    </div>

</div>

</div>
@endsection
