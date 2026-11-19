@extends('admin.layouts.app')

@section('title', 'Catat Barang Temuan - Lost & Found')
@section('heading', 'Catat Barang Temuan - Lost & Found')

@section('pageStyles')
<style>

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page{
        padding: 4px !important;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .grid{
        display: grid;
        grid-template-columns: minmax(0, 1.7fr) minmax(320px, .9fr);
        gap: 18px;
        align-items: start;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .panel{
        min-width: 0;
        margin-bottom: 16px;
        overflow: hidden;
        border: 1px solid #e8e1ee;
        border-radius: 9px;
        background: #fff;
        box-shadow: 0 2px 8px rgba(35, 22, 49, .045);
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .panel-title{
        padding: 13px 16px !important;
        background: #f2edf7 !important;
        border-bottom: 1px solid #e5ddec !important;
        color: #392451 !important;
        font-size: 14px !important;
        line-height: 1.4;
        font-weight: 700;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .panel-body{
        padding: 16px !important;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .field{
        margin-bottom: 14px;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .field label{
        margin-bottom: 6px;
        color: #392f46;
        font-size: 13px;
        line-height: 1.4;
        font-weight: 600;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .field small{
        display: block;
        margin-top: 5px;
        color: #756d7d !important;
        font-size: 11px;
        line-height: 1.45;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .field input, .admin-kampus-admin-barang-diterima-create-blade-php .record-page .field textarea{
        width: 100%;
        min-height: 38px;
        padding: 9px 10px;
        border: 1px solid #d4cbdc;
        border-radius: 5px;
        font-size: 13px !important;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .field textarea{
        min-height: 96px;
        resize: vertical;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .field input[readonly]{
        background: #f4f2f6;
        color: #6f6878;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .date-location-grid{
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 12px;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .checklist{
        padding: 16px !important;
        font-size: 13px;
        line-height: 1.5;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .checklist label{
        display: grid !important;
        grid-template-columns: 17px minmax(0, 1fr);
        align-items: start;
        column-gap: 10px;
        margin: 0 0 13px !important;
        color: #392f46;
        font-size: 13px !important;
        line-height: 1.5 !important;
        font-weight: 600;
        cursor: pointer;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .checklist label:last-of-type{
        margin-bottom: 12px !important;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .checklist input[type="checkbox"]{
        width: 16px !important;
        min-width: 16px;
        height: 16px;
        min-height: 16px !important;
        margin: 1px 0 0;
        padding: 0;
        accent-color: #7040a5;
        cursor: pointer;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .checklist p{
        margin: 4px 0 0;
        color: #756d7d !important;
        font-size: 11px !important;
        line-height: 1.55 !important;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .preview-image{
        width: 100%;
        min-height: 140px;
        height: 180px;
        margin: 0 0 12px;
        padding: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        overflow: hidden;
        border: 1px solid #d8d0df;
        border-radius: 5px;
        background: #f7f5f9;
        color: #756d7d;
        font-size: 13px;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .preview-image img{
        display: block;
        width: 100%;
        height: 100%;
        min-width: 0;
        min-height: 0;
        object-fit: contain;
        object-position: center;
        border-radius: 3px;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .preview-image.has-multiple{
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        grid-template-rows: repeat(2, minmax(0, 1fr));
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .preview-image.has-multiple img{
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .preview-name{
        margin: 0 0 5px;
        color: #30283a;
        font-size: 14px;
        line-height: 1.4;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .preview-info{
        color: #6f6878;
        font-size: 12px;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .flow{
        text-align: center;
        color: #392f46;
        font-size: 12px;
        line-height: 1.6;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .flow-step{
        margin: 7px 0;
        padding: 9px 10px;
        border: 1px solid #ddd6e5;
        border-radius: 4px;
        background: #fff;
        line-height: 1.4;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .flow-current{
        background: #e5efff;
        border-color: #3677e8;
        color: #243e68;
        font-weight: 700;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .actions{
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        margin-top: 4px;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .actions .primary{
        background: #4b2d73;
        border: 1px solid #4b2d73;
        color: #fff;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .actions .primary:hover{
        background: #62408b;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .actions .btn{
        background: #fff;
        border: 1px solid #bdb4c8;
        color: #392f46;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .alert{
        margin-bottom: 16px;
        border: 1px solid #fecaca;
        border-radius: 6px;
        line-height: 1.5;
    }

    .admin-kampus-admin-barang-diterima-create-blade-php .record-page .success-message{
        padding: 12px 14px;
        margin-bottom: 16px;
        border: 1px solid #a7e5b9;
        border-radius: 6px;
        background: #dcfce7;
        color: #166534;
    }

    @media (max-width: 900px) {
        .admin-kampus-admin-barang-diterima-create-blade-php .record-page .grid{
            grid-template-columns: minmax(0, 1fr);
        }

        .admin-kampus-admin-barang-diterima-create-blade-php .record-page .right-column{
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            align-items: start;
        }

        .admin-kampus-admin-barang-diterima-create-blade-php .record-page .right-column .panel{
            margin-bottom: 0;
        }

        .admin-kampus-admin-barang-diterima-create-blade-php .record-page .right-column .panel:last-child{
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 600px) {
        .admin-kampus-admin-barang-diterima-create-blade-php .record-page{ padding: 0 !important; }

        .admin-kampus-admin-barang-diterima-create-blade-php .record-page .panel-body{ padding: 13px !important; }

        .admin-kampus-admin-barang-diterima-create-blade-php .record-page .right-column{
            display: block;
        }

        .admin-kampus-admin-barang-diterima-create-blade-php .record-page .right-column .panel{
            margin-bottom: 14px;
        }

        .admin-kampus-admin-barang-diterima-create-blade-php .record-page .date-location-grid{
            grid-template-columns: 1fr;
            gap: 0;
        }

        .admin-kampus-admin-barang-diterima-create-blade-php .record-page .preview-image{ height: 160px; }
    }

</style>
@endsection

@section('content')
<div class="admin-kampus-page admin-kampus-admin-barang-diterima-create-blade-php">
<section class="record-page">

            @if ($errors->any())
                <div class="alert">
                    <strong>Periksa kembali data yang dimasukkan:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.barang-diterima.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid">

                    <div class="panel">
                        <div class="panel-title">Form Pencatatan Barang</div>

                        <div class="panel-body">

                            @include('admin.barang-diterima._form')

                        </div>
                    </div>

                    <div class="right-column">

                        <div class="panel">
                            <div class="panel-title">Checklist Persiapan Data</div>
                            <div class="panel-body checklist">
                                <label>
                                    <input type="checkbox" id="check-data" style="width:auto;">
                                    Data barang sudah lengkap
                                </label>

                                <label>
                                    <input type="checkbox" id="check-fisik" style="width:auto;">
                                    Barang fisik sudah diterima
                                </label>

                                <label>
                                    <input type="checkbox" id="check-deskripsi" style="width:auto;">
                                    Deskripsi publik tidak membocorkan ciri khusus
                                </label>

                                <p style="font-size:11px;color:#777;line-height:1.5;">
                                    Checklist ini merupakan pengingat saat pencatatan,
                                    bukan status validasi permanen.
                                </p>
                            </div>
                        </div>

                        <div class="panel">
                            <div class="panel-title">Pratinjau Tampilan Publik</div>

                            <div class="panel-body">
                                <div class="preview-image" id="preview-image" aria-live="polite">
                                    <span id="preview-image-placeholder">Foto Barang akan tampil di sini setelah dipilih.</span>
                                </div>

                                <div class="preview-name" id="preview-name">
                                    Nama Barang
                                </div>

                                <div class="preview-info">
                                    <span id="preview-category">Kategori</span>
                                    <br>
                                    <span id="preview-location">Lokasi belum diisi</span>
                                    <br>
                                    Ditemukan:
                                    <span id="preview-date">Tanggal belum diisi</span>
                                </div>
                            </div>
                        </div>

                        <div class="panel">
                            <div class="panel-title">Alur Status Barang</div>

                            <div class="panel-body">
                                <div class="flow">
                                    <div class="flow-step flow-current">
                                        Diterima Admin
                                    </div>
                                    ↓
                                    <div class="flow-step">
                                        Dalam Pemeriksaan
                                    </div>
                                    ↓
                                    <div class="flow-step">
                                        Siap Dipublikasikan
                                    </div>
                                    ↓
                                    <div class="flow-step">
                                        Dipublikasikan
                                    </div>
                                    ↓
                                    <div class="flow-step">
                                        Diserahkan
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </section>



<script>
    const fields = {
        nama: document.getElementById('nama_publik'),
        kategori: document.getElementById('kategori'),
        lokasi: document.getElementById('lokasi_ditemukan'),
        tanggal: document.getElementById('tanggal_ditemukan')
    };

    const fotoInput = document.getElementById('foto');
    const fotoPreview = document.getElementById('preview-image');
    let previewUrls = [];

    function updatePreview() {
        document.getElementById('preview-name').textContent =
            fields.nama.value.trim() || 'Nama Barang';

        document.getElementById('preview-category').textContent =
            fields.kategori.value.trim() || 'Kategori';

        document.getElementById('preview-location').textContent =
            fields.lokasi.value.trim() || 'Lokasi belum diisi';

        if (fields.tanggal.value) {
            const date = new Date(fields.tanggal.value + 'T00:00:00');
            document.getElementById('preview-date').textContent =
                date.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
        } else {
            document.getElementById('preview-date').textContent =
                'Tanggal belum diisi';
        }
    }

    function updatePhotoPreview() {
        previewUrls.forEach(url => URL.revokeObjectURL(url));
        previewUrls = [];
        fotoPreview.replaceChildren();

        const files = Array.from(fotoInput.files || [])
            .filter(file => file.type.startsWith('image/'))
            .slice(0, 4);

        fotoPreview.classList.toggle('has-multiple', files.length > 1);

        if (files.length === 0) {
            const placeholder = document.createElement('span');
            placeholder.id = 'preview-image-placeholder';
            placeholder.textContent = 'Foto Barang akan tampil di sini setelah dipilih.';
            fotoPreview.appendChild(placeholder);
            return;
        }

        files.forEach((file, index) => {
            const url = URL.createObjectURL(file);
            previewUrls.push(url);

            const image = document.createElement('img');
            image.src = url;
            image.alt = 'Pratinjau foto barang ' + (index + 1);
            image.title = file.name;
            fotoPreview.appendChild(image);
        });
    }

    Object.values(fields).forEach(field => {
        field.addEventListener('input', updatePreview);
        field.addEventListener('change', updatePreview);
    });

    fotoInput.addEventListener('change', updatePhotoPreview);

    updatePreview();
    updatePhotoPreview();
</script>

</div>
@endsection
