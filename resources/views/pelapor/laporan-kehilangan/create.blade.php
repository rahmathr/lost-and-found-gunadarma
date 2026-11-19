@extends('pelapor.layouts.app')

@section('title', 'Buat Laporan Kehilangan - Lost & Found Gundar')
@section('heading', 'Buat Laporan Kehilangan')
@section('active', 'laporan')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('pelapor.laporan-kehilangan.index') }}">
        Laporan Saya
    </a>
    &gt; Buat Laporan Kehilangan
</div>

<h1 class="page-title">Form Laporan Kehilangan</h1>

<main class="page-layout">

    <section class="form-panel">

        @if ($errors->any())
            <div class="alert-error">
                <strong>Periksa kembali data yang kamu masukkan:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('pelapor.laporan-kehilangan.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            @include('pelapor.laporan-kehilangan._form')

        </form>

    </section>

    <aside class="tips-panel">
        <div class="tips-title">Tips Pengisian</div>

        <div class="tips-content">
            <ul>
                <li>Tulis ciri khusus yang hanya diketahui pemilik.</li>
                <li>Cantumkan perkiraan waktu dan lokasi terakhir.</li>
                <li>Cek halaman Beranda, barang Anda mungkin sudah dipublikasikan.</li>
                <li>Status laporan dapat dipantau di menu Laporan &amp; Klaim Saya.</li>
            </ul>
        </div>
    </aside>

</main>
@endsection
