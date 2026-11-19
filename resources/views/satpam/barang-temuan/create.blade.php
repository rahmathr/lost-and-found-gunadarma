@extends('satpam.layouts.app')

@section('title', 'Catat Barang Temuan')
@section('heading', 'Catat Barang Temuan')

@push('styles')
<style>
.satpam-form-page{width:100%;max-width:820px;margin:0 auto;background:#fff;border:1px solid #e7e0ef;border-radius:10px;padding:24px;box-shadow:0 2px 8px rgba(57,36,81,.04);color:#30283a}
.satpam-form-page *{box-sizing:border-box}.satpam-form-page h1{margin:0 0 10px;color:#392451;font-size:22px}.satpam-form-page p{line-height:1.55;color:#6c6177}
.satpam-form-page label{display:block;font-size:13px;font-weight:600;color:#443653;margin:0 0 7px}
.satpam-form-page input:not([type=file]),.satpam-form-page select,.satpam-form-page textarea{display:block;width:100%;max-width:100%;padding:10px 12px;border:1px solid #d8cfe2;border-radius:7px;background:#fff;color:#30283a;font:inherit;font-size:13px;line-height:1.45}
.satpam-form-page input[type=file]{display:block;width:100%;max-width:100%;padding:9px;border:1px dashed #cfc1dd;border-radius:7px;background:#fbf9fd}
.satpam-form-page textarea{min-height:100px;resize:vertical}.satpam-form-page input:focus,.satpam-form-page select:focus,.satpam-form-page textarea:focus{outline:0;border-color:#7040a5;box-shadow:0 0 0 3px rgba(112,64,165,.12)}
.satpam-form-page button,.satpam-form-page a{display:inline-flex;align-items:center;justify-content:center;min-height:39px;padding:9px 15px;border:1px solid #7040a5;border-radius:7px;background:#7040a5;color:#fff;text-decoration:none;font-size:13px;font-weight:600;line-height:1.2;cursor:pointer}
.satpam-form-page a{background:#f3eef8;border-color:#e1d6ec;color:#392451}.satpam-form-page button:hover{background:#593184}.satpam-form-page a:hover{background:#e9e0f1}
.satpam-form-page .btn-delete{background:#c62828!important;border-color:#c62828!important;color:#fff!important}
.satpam-form-page .alert{padding:12px 14px;margin:0 0 16px;border-radius:7px;background:#fff1f2;color:#9f1239;border:1px solid #fecdd3}
.satpam-form-page img{max-width:100%;object-fit:cover}
@media(max-width:600px){.satpam-form-page{padding:16px}}
</style>
@endpush

@section('content')
<div class="container satpam-form-page">

    <h1>Catat Barang Temuan</h1>

    <p>
        Isi informasi barang yang ditemukan di lingkungan kampus.
    </p>

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
        action="{{ route('satpam.barang-temuan.store') }}"
        method="POST" enctype="multipart/form-data">

        @csrf

        @include('satpam.barang-temuan._form')

    </form>

</div>
@endsection
