@extends('super-admin.layouts.app')
@section('title', 'Riwayat Aktivitas')
@section('heading', 'Riwayat Aktivitas Sistem')

@push('styles')
<style>
.sa-content .sa-activity-page { width:100%; min-width:0; }
.sa-content .sa-description { margin:0 0 12px; }
.sa-content .sa-filter { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); align-items:end; gap:12px; }
.sa-content .sa-filter .sa-field { min-width:0; }
.sa-content .sa-filter .sa-field input,.sa-content .sa-filter .sa-field select { width:100%; min-width:0; min-height:40px; }
.sa-content .sa-table-wrap { overflow-x:auto; overscroll-behavior-x:contain; }
.sa-content .sa-table { min-width:850px; }
.sa-content .sa-table td { vertical-align:middle; overflow-wrap:anywhere; }
.sa-content .sa-pagination { overflow-x:auto; }
@media(max-width:900px){ .sa-content .sa-filter { grid-template-columns:repeat(2,minmax(0,1fr)); } }
@media(max-width:560px){ .sa-content .sa-filter { grid-template-columns:minmax(0,1fr); } .sa-content .sa-filter .sa-btn { width:100%; } }
</style>
@endpush

@section('content')
<div class="sa-activity-page">
    <p class="sa-description">Halaman ini menampilkan aktivitas perubahan data yang dilakukan oleh Super Admin, Admin Kampus, dan Satpam.</p>
    <form action="{{ route('super-admin.riwayat-aktivitas.index') }}" method="GET" class="lf-filter">
        <div class="lf-filter__field">
            <label for="tanggal_mulai">Tanggal Mulai</label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
        </div>
        <div class="lf-filter__field">
            <label for="tanggal_akhir">Tanggal Akhir</label>
            <input type="date" id="tanggal_akhir" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
        </div>
        <div class="lf-filter__field">
            <label for="jenis_tindakan">Jenis Tindakan</label>
            <select id="jenis_tindakan" name="jenis_tindakan">
                <option value="">Semua Tindakan</option>
                @foreach ($jenisTindakan as $tindakan)
                    <option value="{{ $tindakan }}" @selected(request('jenis_tindakan') === $tindakan)>{{ $tindakan }}</option>
                @endforeach
            </select>
        </div>
        <div class="lf-filter__actions">
            <button type="submit">Terapkan</button>
            <a href="{{ route('super-admin.riwayat-aktivitas.index') }}">Reset</a>
        </div>
    </form>
    <div class="sa-table-wrap"><table class="sa-table">
        <thead><tr><th>No.</th><th>Waktu</th><th>Pengguna</th><th>Peran</th><th>Tindakan</th><th>Jenis Referensi</th></tr></thead>
        <tbody>
        @forelse ($aktivitas as $item)
            <tr>
                <td>{{ $aktivitas->firstItem() + $loop->index }}</td><td>{{ $item->waktu?->format('d-m-Y H:i:s') ?? '-' }}</td>
                <td>@if ($item->id_super_admin){{ $item->superAdmin->nama ?? '-' }}@elseif ($item->id_admin){{ $item->admin->nama ?? '-' }}@elseif ($item->id_satpam){{ $item->satpam->nama ?? '-' }}@else - @endif</td>
                <td>@if ($item->id_super_admin)Super Admin @elseif ($item->id_admin)Admin Kampus @elseif ($item->id_satpam)Satpam @else Tidak diketahui @endif</td>
                <td>{{ $item->tindakan }}</td><td>{{ $item->referensi_jenis ?? '-' }}</td>
            </tr>
        @empty <tr><td colspan="6" style="text-align:center;">Tidak ada aktivitas yang sesuai dengan filter.</td></tr> @endforelse
        </tbody>
    </table></div>
    <div class="sa-pagination">{{ $aktivitas->onEachSide(1)->links('vendor.pagination.super-admin') }}</div>
</div>
@endsection
