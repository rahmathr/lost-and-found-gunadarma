@extends('super-admin.layouts.app')

@section('title', 'Edit Admin Kampus')
@section('heading', 'Edit Admin Kampus')


@push('styles')
<style>
/* Perapihan form CRUD Super Admin; hanya berlaku di area konten. */
.sa-content .sa-card form { width:100%; min-width:0; }
.sa-content .sa-card .sa-form-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:18px 20px; max-width:900px; }
.sa-content .sa-card .sa-field { min-width:0; }
.sa-content .sa-card .sa-field label { display:block; margin:0 0 7px; color:#393142; font-size:13px; font-weight:700; }
.sa-content .sa-card .sa-field input,
.sa-content .sa-card .sa-field select,
.sa-content .sa-card .sa-field textarea { display:block; width:100%; min-width:0; min-height:42px; padding:10px 12px; border:1px solid #d8d1df; border-radius:7px; background:#fff; color:#30283a; font:14px Arial,sans-serif; }
.sa-content .sa-card .sa-field textarea { min-height:110px; resize:vertical; }
.sa-content .sa-card .sa-field input:focus,
.sa-content .sa-card .sa-field select:focus,
.sa-content .sa-card .sa-field textarea:focus { outline:0; border-color:#7040a5; box-shadow:0 0 0 3px rgba(112,64,165,.12); }
.sa-content .sa-card .sa-field small { display:block; margin-top:6px; color:#706879; line-height:1.45; }
.sa-content .sa-card .sa-form-actions,
.sa-content .sa-card .sa-actions { display:flex; flex-wrap:wrap; align-items:center; gap:10px; margin-top:20px; }
.sa-content .sa-card .sa-btn { min-height:40px; white-space:nowrap; }
.sa-content .sa-card .sa-alert ul { margin:8px 0 0; padding-left:20px; }
@media(max-width:760px){ .sa-content .sa-card .sa-form-grid { grid-template-columns:minmax(0,1fr); } }
</style>
@endpush

@section('content')
<div class="sa-card">
    <p class="sa-description">Perbarui informasi akun Admin Kampus. Kosongkan password jika tidak ingin menggantinya.</p>

    @if ($errors->any())
        <div class="sa-alert sa-alert-error">
            <strong>Terjadi kesalahan. Periksa kembali data berikut:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('super-admin.admin-kampus.update', ['adminKampus' => $adminKampus->id_admin]) }}" method="POST">
        @csrf
        @method('PUT')
        @include('super-admin.admin-kampus._form')
    </form>
</div>
@endsection
