@extends('pelapor.layouts.app')

@section('title', 'Edit Laporan Kehilangan - Lost & Found Gundar')
@section('heading', 'Edit Laporan Kehilangan')
@section('active', 'laporan')

@section('content')
<div class="pelapor-content-panel">
    <div class="breadcrumb">Laporan Saya &gt; Edit Laporan Kehilangan</div>
    <h1>Edit Laporan Kehilangan</h1>

    @if ($errors->any())
        <div class="alert">
            <strong>Terjadi kesalahan:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('pelapor.laporan-kehilangan.update', ['laporan' => $laporan->id_laporan]) }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        @include('pelapor.laporan-kehilangan._form')

    </form>

    {{-- Form penghapusan foto ditempatkan di luar form edit agar tidak terjadi nested form. --}}
    @foreach ($laporan->foto as $fotoLaporan)
        <form id="hapus-foto-laporan-{{ $fotoLaporan->id_foto_laporan }}" method="POST" action="{{ route('pelapor.laporan-kehilangan.foto.hapus', ['id' => $laporan->id_laporan, 'foto' => $fotoLaporan->id_foto_laporan]) }}" style="display:none">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
</div>
@endsection
