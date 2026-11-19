@extends('admin.layouts.app')

@section('title', 'Edit Barang Diterima')
@section('heading', 'Edit Barang Diterima')

@section('content')
<div class="admin-kampus-page admin-kampus-admin-barang-diterima-edit-blade-php">
<h1>Edit Barang Diterima</h1>

    <p>Perbarui informasi barang yang diterima langsung oleh Admin.</p>

    @if ($errors->any())
        <div style="color:red;">
            <strong>Periksa kembali data yang dimasukkan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('admin.barang-diterima.update', $barangTemuan->id_barang) }}"
        method="POST"
    >
        @csrf
        @method('PUT')

        @include('admin.barang-diterima._form')
    </form>

    {{-- Form pengelolaan foto berada di luar form edit untuk mencegah nested form. --}
    @foreach ($barangTemuan->foto as $fotoLama)
        <form id="hapus-foto-barang-{{ $fotoLama->id_foto }}" method="POST" action="{{ route('admin.barang-diterima.foto.hapus', ['id' => $barangTemuan->id_barang, 'foto' => $fotoLama->id_foto]) }}" style="display:none">
            @csrf
            @method('DELETE')
        </form>
        <form id="foto-utama-barang-{{ $fotoLama->id_foto }}" method="POST" action="{{ route('admin.barang-diterima.foto.utama', ['id' => $barangTemuan->id_barang, 'foto' => $fotoLama->id_foto]) }}" style="display:none">
            @csrf
        </form>
    @endforeach

</div>
@endsection
