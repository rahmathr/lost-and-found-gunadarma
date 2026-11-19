@extends('satpam.layouts.app')

@section('title', 'Riwayat Penerimaan')
@section('heading', 'Riwayat Penerimaan')

@push('styles')
<style>
.satpam-history-page{width:100%;max-width:100%;min-width:0;margin:0 auto;color:#30283a;overflow:hidden}
.satpam-history-page *{box-sizing:border-box}
.satpam-history-page .lf-filter{margin-bottom:18px}
.satpam-history-page table{width:100%;max-width:100%;table-layout:auto}
.satpam-history-page .table-scroll{width:100%;max-width:100%;overflow-x:auto;overscroll-behavior-x:contain}
.satpam-history-page button,.satpam-history-page .button,.satpam-history-page .detail{display:inline-flex;align-items:center;justify-content:center;min-height:38px;padding:9px 15px;border:1px solid #7040a5;border-radius:7px;background:#7040a5;color:#fff;text-decoration:none;font-size:13px;font-weight:600;line-height:1.2;cursor:pointer}
.satpam-history-page .button{background:#f3eef8;color:#392451;border-color:#e1d6ec}
.satpam-history-page button:hover,.satpam-history-page .detail:hover{background:#593184;color:#fff}
.satpam-history-page .button:hover{background:#e9e0f1;color:#392451}
.satpam-history-page table{width:100%;border-collapse:collapse;background:#fff;font-size:13px;line-height:1.45}
.satpam-history-page th,.satpam-history-page td{padding:12px 11px;border:1px solid #e5deeb;text-align:left;vertical-align:middle;overflow-wrap:anywhere}
.satpam-history-page th{background:#f3eef8;color:#392451;font-weight:700}
.satpam-history-page tbody tr:nth-child(even){background:#fbfafd}
.satpam-history-page .status{display:inline-flex;align-items:center;padding:5px 9px;border-radius:20px;font-size:11px;font-weight:700;white-space:normal;border:1px solid transparent}
.satpam-history-page .menunggu{background:#fff7df;color:#8a6200;border-color:#f2d98d}.satpam-history-page .tervalidasi{background:#eaf8ef;color:#166534;border-color:#b7e4c7}.satpam-history-page .ditolak{background:#fff0f0;color:#991b1b;border-color:#f2c0c0}.satpam-history-page .proses{background:#f2eafa;color:#63368b;border-color:#ddc6ef}.satpam-history-page .diserahkan{background:#eaf1ff;color:#244b91;border-color:#c8d8fb}
.satpam-history-page .pagination{margin-top:18px;overflow-x:auto}.satpam-history-page .alert{padding:12px 14px;margin-bottom:15px;border-radius:7px;background:#fff1f2;color:#9f1239;border:1px solid #fecdd3;font-size:13px}
@media(max-width:760px){.satpam-history-page .table-scroll table{min-width:760px}}
</style>
@endpush

@section('content')
<div class="content satpam-history-page">

        @if ($errors->any())
            <div class="alert">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="GET" action="{{ route('satpam.riwayat-penerimaan.index') }}" class="lf-filter">
            <div class="lf-filter__field">
                <label for="satpam-tanggal-mulai">Dari Tanggal</label>
                <input id="satpam-tanggal-mulai" type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
            </div>
            <div class="lf-filter__field">
                <label for="satpam-tanggal-selesai">Sampai Tanggal</label>
                <input id="satpam-tanggal-selesai" type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">
            </div>
            <div class="lf-filter__field">
                <label for="satpam-status">Status</label>
                <select id="satpam-status" name="status">
                    <option value="">Semua Status</option>
                    @foreach (['Diterima Satpam','Dipublikasikan','Ditolak','Dalam Proses Penyerahan','Diserahkan'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div class="lf-filter__actions">
                <button type="submit">Terapkan</button>
                <a href="{{ route('satpam.riwayat-penerimaan.index') }}">Reset</a>
            </div>
        </form>

        <div class="table-scroll">
        <table>
            <thead>
                <tr>
                                        <th>Barang</th>
                    <th>Tanggal Ditemukan</th>
                    <th>Lokasi Ditemukan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($barangTemuan as $item)
                    @php
                        $statusClass = match ($item->status) {
                            'Diterima Satpam' => 'menunggu',
                            'Dipublikasikan' => 'tervalidasi',
                            'Ditolak' => 'ditolak',
                            'Dalam Proses Penyerahan' => 'proses',
                            'Diserahkan' => 'diserahkan',
                            default => '',
                        };
                    @endphp

                    <tr>
                                                <td>{{ $item->nama_publik }}</td>
                        <td>
                            {{ $item->tanggal_ditemukan->format('d M Y') }}
                        </td>
                        <td>{{ $item->lokasi_ditemukan }}</td>
                        <td>
                            <span class="status {{ $statusClass }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td>
                            <a
                                href="{{ route('satpam.riwayat-penerimaan.show', $item->id_barang) }}"
                                class="detail">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;">
                            Belum ada riwayat penerimaan barang.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <div class="pagination">
            {{ $barangTemuan->links() }}
        </div>

    </div>
@endsection
