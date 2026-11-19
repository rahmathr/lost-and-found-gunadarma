@extends('admin.layouts.app')

@section('title', 'Edit Satpam')
@section('heading', 'Edit Satpam')

@section('pageStyles')
<style>

    .admin-kampus-admin-satpam-edit-blade-php .satpam-form-card{
        width:100%; max-width:620px; margin:8px auto 24px;
        padding:28px 30px; background:#fff; border:1px solid #eee8f2;
        border-radius:10px; box-shadow:0 3px 12px rgba(35,22,49,.06);
    }
    .admin-kampus-admin-satpam-edit-blade-php .satpam-form-card h1{
        margin:0 0 22px; color:#392451; font-size:25px;
        line-height:1.3; font-weight:700;
    }
    .admin-kampus-admin-satpam-edit-blade-php .satpam-form-field{ margin:0 0 17px; }
    .admin-kampus-admin-satpam-edit-blade-php .satpam-form-field label{
        display:block; margin:0 0 7px; color:#392451;
        font-size:14px; line-height:1.4; font-weight:600;
    }
    .admin-kampus-admin-satpam-edit-blade-php .satpam-form-field input{
        display:block; width:100%; min-height:42px; padding:10px 12px;
        margin:0; border:1px solid #d4cadd; border-radius:6px;
        background:#fff; color:#30283a; font:14px Arial,sans-serif;
        transition:border-color .15s ease, box-shadow .15s ease;
    }
    .admin-kampus-admin-satpam-edit-blade-php .satpam-form-field input:focus{
        outline:none; border-color:#7040a5;
        box-shadow:0 0 0 3px rgba(112,64,165,.12);
    }
    .admin-kampus-admin-satpam-edit-blade-php .satpam-form-help{ display:block; margin-top:6px; color:#756d7d; font-size:12px; line-height:1.45; }
    .admin-kampus-admin-satpam-edit-blade-php .satpam-form-error{ display:block; margin-top:6px; color:#b42318; font-size:12px; }
    .admin-kampus-admin-satpam-edit-blade-php .satpam-form-actions{ display:flex; align-items:center; flex-wrap:wrap; gap:9px; margin-top:4px; }
    .admin-kampus-admin-satpam-edit-blade-php .satpam-form-button{
        display:inline-flex; align-items:center; justify-content:center;
        min-height:40px; padding:9px 15px; border:1px solid #4b2d73;
        border-radius:6px; background:#4b2d73; color:#fff;
        font:600 14px Arial,sans-serif; text-decoration:none; cursor:pointer;
    }
    .admin-kampus-admin-satpam-edit-blade-php .satpam-form-button:hover{ background:#62408b; border-color:#62408b; }
    .admin-kampus-admin-satpam-edit-blade-php .satpam-form-cancel{
        display:inline-flex; align-items:center; justify-content:center;
        min-height:40px; padding:9px 15px; border:1px solid #d9d2df;
        border-radius:6px; background:#f5f2f7; color:#403748;
        font-size:14px; font-weight:600; text-decoration:none;
    }
    .admin-kampus-admin-satpam-edit-blade-php .satpam-form-cancel:hover{ background:#ebe5f0; }
    .admin-kampus-admin-satpam-edit-blade-php .satpam-form-alert{
        padding:12px 14px; margin:0 0 18px; border:1px solid #fecaca;
        border-radius:7px; background:#fff1f0; color:#991b1b;
    }
    .admin-kampus-admin-satpam-edit-blade-php .satpam-form-alert ul{ margin:8px 0 0; padding-left:20px; }
    @media(max-width:650px) {
        .admin-kampus-admin-satpam-edit-blade-php .satpam-form-card{ padding:22px 18px; margin:0 auto 18px; }
        .admin-kampus-admin-satpam-edit-blade-php .satpam-form-card h1{ font-size:22px; }
        .admin-kampus-admin-satpam-edit-blade-php .satpam-form-actions{ align-items:stretch; }
        .admin-kampus-admin-satpam-edit-blade-php .satpam-form-actions > *{ flex:1 1 auto; }
    }

</style>
@endsection

@section('content')
<div class="admin-kampus-page admin-kampus-admin-satpam-edit-blade-php">
<div class="satpam-form-card">

    <h1>Edit Satpam</h1>

    @if ($errors->any())
        <div class="satpam-form-alert">
            <strong>Terjadi kesalahan:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('admin.satpam.update', ['satpam' => $satpam->id_satpam]) }}"
        method="POST">

        @csrf
        @method('PUT')

        @include('admin.satpam._form')

    </form>

</div>

</div>
@endsection
