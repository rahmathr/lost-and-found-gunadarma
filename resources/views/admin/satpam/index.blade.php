@extends('admin.layouts.app')

@section('title', 'Manajemen Satpam')
@section('heading', 'Manajemen Satpam')

@section('pageStyles')
<style>

    .admin-kampus-admin-satpam-index-blade-php .satpam-page{ width: 100%; }
    .admin-kampus-admin-satpam-index-blade-php .satpam-toolbar{
        display:flex; justify-content:flex-end; align-items:center;
        margin: 0 0 18px; gap: 10px;
    }
    .admin-kampus-admin-satpam-index-blade-php .satpam-table-wrapper{
        width:100%; overflow-x:auto; background:#fff;
        border:1px solid #e2d9eb; border-radius:9px;
        box-shadow:0 2px 9px rgba(35,22,49,.05);
    }
    .admin-kampus-admin-satpam-index-blade-php .satpam-table{
        width:100%; min-width:650px; border-collapse:separate;
        border-spacing:0; background:#fff;
    }
    .admin-kampus-admin-satpam-index-blade-php .satpam-table th, .admin-kampus-admin-satpam-index-blade-php .satpam-table td{
        padding:13px 14px; border:0; border-bottom:1px solid #e9e3ef;
        text-align:left; vertical-align:middle; line-height:1.45;
    }
    .admin-kampus-admin-satpam-index-blade-php .satpam-table th{
        background:#f0eaf6; color:#392451; font-weight:700;
        white-space:nowrap;
    }
    .admin-kampus-admin-satpam-index-blade-php .satpam-table tbody tr:last-child td{ border-bottom:0; }
    .admin-kampus-admin-satpam-index-blade-php .satpam-table tbody tr:nth-child(even){ background:#fbf9fd; }
    .admin-kampus-admin-satpam-index-blade-php .satpam-table tbody tr:hover{ background:#f5f0fa; }
    .admin-kampus-admin-satpam-index-blade-php .satpam-table th:first-child, .admin-kampus-admin-satpam-index-blade-php .satpam-table td:first-child{ width:70px; }
    .admin-kampus-admin-satpam-index-blade-php .satpam-table th:nth-child(2), .admin-kampus-admin-satpam-index-blade-php .satpam-table td:nth-child(2){ width:220px; min-width:220px; white-space:nowrap; }
    .admin-kampus-admin-satpam-index-blade-php .satpam-table th:nth-child(3), .admin-kampus-admin-satpam-index-blade-php .satpam-table td:nth-child(3){ white-space:nowrap; }
    .admin-kampus-admin-satpam-index-blade-php .satpam-table th:last-child, .admin-kampus-admin-satpam-index-blade-php .satpam-table td:last-child{ width:190px; }
    .admin-kampus-admin-satpam-index-blade-php .satpam-actions{ display:flex; align-items:center; flex-wrap:wrap; gap:8px; }
    .admin-kampus-admin-satpam-index-blade-php .satpam-actions form{ margin:0; }
    .admin-kampus-admin-satpam-index-blade-php .satpam-btn{
        display:inline-flex; align-items:center; justify-content:center;
        min-height:38px; padding:8px 13px; border:1px solid transparent;
        border-radius:6px; text-decoration:none; font-size:13px;
        font-weight:600; line-height:1.2; cursor:pointer;
        transition:background .15s ease, border-color .15s ease;
    }
    .admin-kampus-admin-satpam-index-blade-php .satpam-btn-primary{ background:#4b2d73; border-color:#4b2d73; color:#fff; }
    .admin-kampus-admin-satpam-index-blade-php .satpam-btn-primary:hover{ background:#62408b; border-color:#62408b; }
    .admin-kampus-admin-satpam-index-blade-php .satpam-btn-warning{ background:#f2edf7; border-color:#d8c9e8; color:#4b2d73; }
    .admin-kampus-admin-satpam-index-blade-php .satpam-btn-warning:hover{ background:#e8def1; }
    .admin-kampus-admin-satpam-index-blade-php .satpam-btn-danger{ background:#fff1f0; border-color:#f0c4c0; color:#a43c36; }
    .admin-kampus-admin-satpam-index-blade-php .satpam-btn-danger:hover{ background:#ffe5e2; }
    .admin-kampus-admin-satpam-index-blade-php .satpam-alert{ padding:12px 14px; margin-bottom:16px; border-radius:7px; }
    .admin-kampus-admin-satpam-index-blade-php .satpam-alert-success{ background:#dcfce7; border:1px solid #a7e7bc; color:#166534; }
    .admin-kampus-admin-satpam-index-blade-php .satpam-alert-error{ background:#fee2e2; border:1px solid #fecaca; color:#991b1b; }
    .admin-kampus-admin-satpam-index-blade-php .satpam-pagination{ margin-top:18px; }
    @media(max-width:650px) {
        .admin-kampus-admin-satpam-index-blade-php .satpam-toolbar{ justify-content:stretch; }
        .admin-kampus-admin-satpam-index-blade-php .satpam-toolbar .satpam-btn{ width:100%; }
    }

</style>
@endsection

@section('content')
<div class="admin-kampus-page admin-kampus-admin-satpam-index-blade-php">
<div class="satpam-page">

    <div class="satpam-toolbar">
        <a href="{{ route('admin.satpam.create') }}"
           class="satpam-btn satpam-btn-primary">
            + Tambah Satpam
        </a>
    </div>

    @if (session('success'))
        <div class="satpam-alert satpam-alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="satpam-alert satpam-alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="satpam-table-wrapper">
        <table class="satpam-table">
            <thead>
                <tr>
                    <th>No</th>

                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($satpam as $item)
                    <tr>
                        <td>{{ $satpam->firstItem() + $loop->index }}</td>

                        <td class="satpam-name-cell">{{ $item->nama }}</td>
                        <td class="satpam-email-cell">{{ $item->email }}</td>
                        <td>
                            <div class="satpam-actions">
                                <a
                                    href="{{ route('admin.satpam.edit', ['satpam' => $item->id_satpam]) }}"
                                    class="satpam-btn satpam-btn-warning">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('admin.satpam.destroy', ['satpam' => $item->id_satpam]) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus Satpam ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="satpam-btn satpam-btn-danger btn-delete">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">
                            Belum ada data Satpam.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="satpam-pagination">
        {{ $satpam->links() }}
    </div>

</div>

</div>
@endsection