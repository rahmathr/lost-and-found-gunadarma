@extends('super-admin.layouts.app')
@section('title', 'Manajemen Kampus')
@section('heading', 'Manajemen Kampus')
@push('styles')
<style>
    /* Tombol aksi khusus halaman Manajemen Kampus.
       Tidak mengubah tombol di halaman Super Admin lainnya. */
    .sa-kampus-index .sa-kampus-row-actions {
        display: inline-flex;
        align-items: center;
        flex-wrap: nowrap;
        gap: 8px;
        margin: 0;
        white-space: nowrap;
    }

    .sa-kampus-index .sa-kampus-row-actions form {
        display: inline-flex;
        align-items: center;
        margin: 0;
        padding: 0;
    }

    .sa-kampus-index .sa-kampus-row-actions .sa-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 76px;
        min-width: 76px;
        height: 38px;
        min-height: 38px;
        margin: 0;
        padding: 0 12px;
        border: 1px solid #ddd6e5;
        border-radius: 6px;
        font: 600 13px Arial, sans-serif;
        line-height: 1;
        text-decoration: none;
        cursor: pointer;
        box-sizing: border-box;
        box-shadow: none;
        transition: background-color .15s ease, border-color .15s ease;
    }

    .sa-kampus-index .sa-kampus-row-actions .sa-btn:not(.sa-btn-danger) {
        background: #f4f1f7;
        border-color: #ddd6e5;
        color: #4b2d73;
    }

    .sa-kampus-index .sa-kampus-row-actions .sa-btn:not(.sa-btn-danger):hover {
        background: #eae3f1;
        border-color: #c9b8dc;
    }

    .sa-kampus-index .sa-kampus-row-actions .sa-btn-danger {
        background: #b42318;
        border-color: #b42318;
        color: #fff;
    }

    .sa-kampus-index .sa-kampus-row-actions .sa-btn-danger:hover {
        background: #941d14;
        border-color: #941d14;
    }

    .sa-kampus-index .sa-kampus-row-actions .sa-btn:focus-visible {
        outline: 3px solid rgba(112, 64, 165, .25);
        outline-offset: 2px;
    }

    .sa-kampus-index .sa-table th:last-child,
    .sa-kampus-index .sa-table td:last-child {
        width: 190px;
        white-space: nowrap;
        vertical-align: middle;
    }

    @media (max-width: 700px) {
        .sa-kampus-index .sa-kampus-row-actions {
            gap: 6px;
        }
        .sa-kampus-index .sa-kampus-row-actions .sa-btn {
            width: 70px;
            min-width: 70px;
        }
    }

    .sa-kampus-index { min-width:0; }
    .sa-kampus-index .sa-table-wrap { width:100%; overflow-x:auto; overscroll-behavior-x:contain; }
    .sa-kampus-index .sa-table { min-width:650px; }
    .sa-kampus-index .sa-table td { vertical-align:middle; overflow-wrap:anywhere; }
    .sa-kampus-index .sa-btn { min-height:38px; white-space:nowrap; }

    /* Pagination kampus: info di kiri, tombol berkelompok rapat di kanan. */
    .sa-kampus-index .sa-pagination {
        display:flex !important; align-items:center !important;
        justify-content:space-between !important; flex-wrap:wrap;
        gap:12px 18px; width:100%; margin-top:18px; padding-top:14px;
        border-top:1px solid #eee8f3; box-sizing:border-box;
    }
    .sa-kampus-index .sa-pagination-info {
        flex:0 1 auto !important; width:auto !important; margin:0;
        color:#6b6472; font-size:13px; line-height:1.5; text-align:left !important;
    }
    .sa-kampus-index nav.sa-pagination-nav {
        display:inline-flex !important; flex:0 0 auto !important;
        width:auto !important; max-width:100%; margin:0 0 0 auto !important;
        padding:0 !important; align-items:center !important;
        justify-content:flex-start !important; flex-wrap:nowrap; gap:8px !important;
    }
    .sa-kampus-index .sa-pagination-nav > .sa-pagination-link {
        display:inline-flex !important; flex:0 0 34px !important;
        width:34px !important; min-width:34px !important; max-width:34px !important;
        height:34px !important; margin:0 !important; padding:0 !important;
        align-items:center !important; justify-content:center !important;
        border:1px solid #e4dbea; border-radius:7px; background:#fff;
        color:#563477; font-size:13px; line-height:1; text-decoration:none;
        box-sizing:border-box;
    }
    .sa-kampus-index .sa-pagination-nav > .sa-pagination-link:hover { background:#f5f0f8; border-color:#cdbbdd; }
    .sa-kampus-index .sa-pagination-nav > .sa-pagination-link.is-active { background:#5b3480; border-color:#5b3480; color:#fff; font-weight:700; }
    .sa-kampus-index .sa-pagination-nav > .sa-pagination-link.is-disabled { color:#aaa2b0; background:#faf9fb; cursor:not-allowed; pointer-events:none; }
    @media(max-width:700px){
        .sa-kampus-index .sa-pagination { justify-content:space-between !important; }
        .sa-kampus-index .sa-pagination-info { width:auto !important; text-align:left !important; }
        .sa-kampus-index nav.sa-pagination-nav { margin-left:auto !important; width:auto !important; }
    }

</style>
@endpush

@section('content')
<div class="sa-kampus-index">
<div class="sa-card">
    <p class="sa-description">Kelola data kampus yang terdaftar dalam sistem Lost &amp; Found Gundarma.</p>
    <div class="sa-actions"><a href="{{ route('super-admin.kampus.create') }}" class="sa-btn sa-btn-primary">+ Tambah Kampus</a></div>
    <div class="sa-table-wrap">
        <table class="sa-table">
            <thead><tr><th>No.</th><th>Nama Kampus</th><th>Alamat</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse ($kampus as $item)
                <tr>
                    <td>{{ $kampus->firstItem() + $loop->index }}</td><td>{{ $item->nama_kampus }}</td><td>{{ $item->alamat ?? '-' }}</td>
                    <td><div class="sa-kampus-row-actions">
                        <a href="{{ route('super-admin.kampus.edit', $item->id_kampus) }}" class="sa-btn">Edit</a>
                        <form action="{{ route('super-admin.kampus.destroy', $item->id_kampus) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kampus ini?')">@csrf @method('DELETE')<button type="submit" class="sa-btn sa-btn-danger btn-delete">Hapus</button></form>
                    </div></td>
                </tr>
            @empty <tr><td colspan="4" style="text-align:center;">Belum ada data kampus.</td></tr> @endforelse
            </tbody>
        </table>
    </div>
    <div class="sa-pagination">{{ $kampus->links('vendor.pagination.lostfound') }}</div>
</div>
</div>
@endsection
