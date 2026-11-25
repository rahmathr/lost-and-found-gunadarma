@extends('satpam.layouts.app')

@section('title', 'Detail Riwayat Penerimaan')
@section('heading', 'Detail Riwayat Penerimaan')

@push('styles')
<style>.satpam-detail-page{width:100%;max-width:900px;margin:0 auto;background:#fff;border:1px solid #e7e0ef;border-radius:10px;padding:24px;box-shadow:0 2px 8px rgba(57,36,81,.04);color:#30283a}.satpam-detail-page h1{margin:0 0 18px;color:#392451;font-size:22px}.satpam-detail-page .detail{padding:13px 0;border-bottom:1px solid #eee7f3;line-height:1.5;overflow-wrap:anywhere}.satpam-detail-page .label{display:block;font-weight:700;color:#59476a;font-size:12px;margin-bottom:5px}.satpam-detail-page .photo-list{display:flex;flex-wrap:wrap;gap:12px;margin:16px 0}.satpam-detail-page .photo-list img{width:180px;height:135px;object-fit:cover;border:1px solid #e1d6ec;border-radius:8px}.satpam-detail-page a{display:inline-flex;align-items:center;justify-content:center;min-height:39px;padding:9px 15px;margin-top:20px;background:#7040a5;color:#fff;text-decoration:none;border-radius:7px;font-size:13px;font-weight:600}.satpam-detail-page a:hover{background:#593184}@media(max-width:600px){.satpam-detail-page{padding:16px}}</style>
@endpush

@section('content')
<div class="container satpam-detail-page">

    <h1>Detail Riwayat Penerimaan</h1>

@if($barangTemuan->foto && $barangTemuan->foto->isNotEmpty())
    <section class="photo-list">
        @foreach($barangTemuan->foto as $foto)
            <img src="{{ app(\App\Services\FileStorageService::class)->url($foto->path_foto) }}" alt="Foto {{ $barangTemuan->nama_publik }}">
        @endforeach
    </section>
@else
    <p style="color:#777;">Foto barang belum tersedia.</p>
@endif



    <div class="detail">
        <span class="label">Nama Barang</span>
        {{ $barangTemuan->nama_publik }}
    </div>

    <div class="detail">
        <span class="label">Kategori</span>
        {{ $barangTemuan->kategori }}
    </div>

    <div class="detail">
        <span class="label">Deskripsi</span>
        {{ $barangTemuan->deskripsi_publik ?? '-' }}
    </div>

    <div class="detail">
        <span class="label">Kampus</span>
        {{ $barangTemuan->kampus->nama_kampus ?? '-' }}
    </div>

    <div class="detail">
        <span class="label">Tanggal Ditemukan</span>
        {{ $barangTemuan->tanggal_ditemukan->format('d-m-Y') }}
    </div>

    <div class="detail">
        <span class="label">Lokasi Ditemukan</span>
        {{ $barangTemuan->lokasi_ditemukan }}
    </div>

    <div class="detail">
        <span class="label">Sumber Penerimaan</span>
        {{ $barangTemuan->sumber_penerimaan }}
    </div>

    <div class="detail">
        <span class="label">Status</span>
        <span class="status {{ match ($barangTemuan->status) {
            'Ditolak' => 'status-rejected',
            'Dipublikasikan', 'Diserahkan' => 'status-approved',
            'Dalam Proses Penyerahan' => 'status-other',
            default => 'status-pending',
        } }}">{{ $barangTemuan->status }}</span>
    </div>

    <a href="{{ route('satpam.riwayat-penerimaan.index') }}">
        Kembali ke Riwayat
    </a>

</div>
@endsection
