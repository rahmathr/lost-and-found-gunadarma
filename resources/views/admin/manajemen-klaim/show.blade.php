@extends('admin.layouts.app')

@section('title', 'Detail Verifikasi Klaim')
@section('heading', 'Detail Verifikasi Klaim')

@section('pageStyles')
<style>

    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail{ width:100%; }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-back-row{ margin:0 0 18px; }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-back{
        display:inline-flex; align-items:center; justify-content:center;
        min-height:38px; padding:8px 13px; border:1px solid #ddd5e6;
        border-radius:6px; background:#f5f2f8; color:#403748;
        text-decoration:none; font-size:13px; font-weight:600;
    }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-grid{
        display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:18px;
        align-items:start;
    }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-panel{
        min-width:0; overflow:hidden; margin:0;
        border:1px solid #eee8f2; border-radius:10px;
        background:#fff; box-shadow:0 2px 8px rgba(35,22,49,.05);
    }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-panel-title{
        padding:13px 16px; background:#f0eaf6;
        border-bottom:1px solid #e5ddeb; color:#392451;
        font-size:15px; font-weight:700;
    }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-panel-body{ padding:16px; font-size:14px; line-height:1.6; }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-detail-row{
        padding:0 0 11px; margin:0 0 11px;
        border-bottom:1px solid #eee9f2;
    }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-detail-row:last-child{ margin-bottom:0; padding-bottom:0; border-bottom:0; }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-label{
        display:block; margin:0 0 4px; color:#392451; font-weight:700;
    }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-private-note{
        min-height:110px; padding:12px; border:1px solid #e2dce8;
        border-radius:7px; background:#faf8fc; white-space:pre-wrap;
    }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-current-status{
        display:inline-flex; padding:6px 10px; border:1px solid #e5b83b;
        border-radius:6px; background:#fff3cd; color:#805b00;
        font-size:13px; font-weight:600;
    }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-muted{ color:#756d7d; font-size:12px; }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-decision-option{
        display:flex!important; align-items:center; gap:12px;
        min-height:62px; padding:14px 15px; margin:0 0 9px;
        border:1px solid #ddd5e6; border-radius:8px;
        background:#fff; color:#392451; font-weight:600;
        cursor:pointer; transition:background .15s,border-color .15s;
    }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-decision-option:hover{
        background:#f8f4fb; border-color:#bda8d2;
    }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-decision-option input[type="radio"]{
        display:inline-block!important; flex:0 0 18px;
        width:18px!important; min-width:18px; height:18px!important;
        min-height:18px!important; margin:0!important; padding:0!important;
        accent-color:#7040a5; cursor:pointer;
    }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-decision-form{ display:none; margin-top:15px; }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-decision-form.active{ display:block; }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-decision-form label:not(.claim-decision-option){
        display:block; margin:0 0 7px; color:#392451; font-weight:600;
    }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-decision-form textarea{
        display:block; width:100%; min-height:105px; padding:11px 12px;
        border:1px solid #d4cadd; border-radius:7px; resize:vertical;
        background:#fff; color:#30283a; font:14px/1.5 Arial,sans-serif;
    }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-decision-form textarea:focus{
        outline:none; border-color:#7040a5;
        box-shadow:0 0 0 3px rgba(112,64,165,.12);
    }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-actions{ display:flex; flex-wrap:wrap; gap:9px; margin-top:13px; }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-action-btn{
        display:inline-flex; align-items:center; justify-content:center;
        min-height:39px; padding:9px 14px; border:1px solid transparent;
        border-radius:6px; color:#fff; font-size:13px; font-weight:600;
        cursor:pointer;
    }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-action-primary{ background:#4b2d73; border-color:#4b2d73; }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-action-primary:hover{ background:#62408b; }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-action-warning{ background:#a66a20; border-color:#a66a20; }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-action-danger{ background:#a43c36; border-color:#a43c36; }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-message{
        padding:12px 14px; margin:0 0 15px; border:1px solid transparent; border-radius:7px;
    }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-message.success{ background:#dcfce7; border-color:#a7e7bc; color:#166534; }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-message.error{ background:#fee2e2; border-color:#fecaca; color:#991b1b; }
    .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-message ul{ margin:8px 0 0; padding-left:20px; }
    @media(max-width:850px) {
        .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-grid{ grid-template-columns:1fr; }
    }
    @media(max-width:650px) {
        .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-panel-body{ padding:13px; }
        .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-actions{ align-items:stretch; }
        .admin-kampus-admin-manajemen-klaim-show-blade-php .claim-detail .claim-action-btn{ flex:1 1 100%; }
    }

</style>
@endsection

@section('content')
<div class="admin-kampus-page admin-kampus-admin-manajemen-klaim-show-blade-php">
<section class="claim-detail">

            @if(session('success'))
                <div class="claim-message success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="claim-message error">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="claim-message error">
                    <strong>Periksa kembali data:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <p class="claim-back-row">
                <a href="{{ route('admin.manajemen-klaim.index') }}" class="claim-back">
                    Kembali ke Daftar Klaim
                </a>
            </p>

            <div class="claim-grid">

                {{-- DATA BARANG --}}
                <div class="claim-panel">
                    <div class="claim-panel-title">Data Barang (Publik)</div>

                    <div class="claim-panel-body">

                        <div class="claim-detail-row">
                            <span class="claim-label">Nama Barang</span>
                            {{ $klaim->barangDitemukan->nama_publik ?? '-' }}
                        </div>

                        <div class="claim-detail-row">
                            <span class="claim-label">Kategori</span>
                            {{ $klaim->barangDitemukan->kategori ?? '-' }}
                        </div>

                        <div class="claim-detail-row">
                            <span class="claim-label">Deskripsi</span>
                            {{ $klaim->barangDitemukan->deskripsi_publik ?? '-' }}
                        </div>

                        <div class="claim-detail-row">
                            <span class="claim-label">Tanggal Ditemukan</span>
                            {{ $klaim->barangDitemukan->tanggal_ditemukan
                                ? \Carbon\Carbon::parse($klaim->barangDitemukan->tanggal_ditemukan)->format('d M Y')
                                : '-' }}
                        </div>

                        <div class="claim-detail-row">
                            <span class="claim-label">Lokasi Ditemukan</span>
                            {{ $klaim->barangDitemukan->lokasi_ditemukan ?? '-' }}
                        </div>

                        <div class="claim-detail-row">
                            <span class="claim-label">Kampus</span>
                            {{ $klaim->barangDitemukan->kampus->nama_kampus ?? '-' }}
                        </div>

                    </div>
                </div>

                {{-- DATA PELAPOR --}}
                <div class="claim-panel">
                    <div class="claim-panel-title">Data Pelapor</div>

                    <div class="claim-panel-body">

                        <div class="claim-detail-row">
                            <span class="claim-label">Nama</span>
                            {{ $klaim->pelaporKehilangan->nama ?? '-' }}
                        </div>

                        <div class="claim-detail-row">
                            <span class="claim-label">Email</span>
                            {{ $klaim->pelaporKehilangan->email ?? '-' }}
                        </div>

                        <div class="claim-detail-row">
                            <span class="claim-label">Tanggal Klaim</span>
                            {{ $klaim->tanggal_klaim
                                ? $klaim->tanggal_klaim->format('d M Y H:i')
                                : '-' }}
                        </div>

                        <div class="claim-detail-row">
                            <span class="claim-label">Status Klaim</span>
                            <span class="claim-current-status {{ match ($klaim->status) {
                                'Disetujui', 'Diserahkan' => 'status-approved',
                                'Ditolak' => 'status-rejected',
                                'Menunggu Verifikasi' => 'status-pending',
                                default => 'status-other',
                            } }}">{{ $klaim->status }}</span>
                        </div>

                    </div>
                </div>

                {{-- KETERANGAN PRIVAT --}}
                <div class="claim-panel">
                    <div class="claim-panel-title">Keterangan Privat dari Pelapor</div>

                    <div class="claim-panel-body">
                        <div class="claim-private-note">{{ $klaim->keterangan_privat ?: 'Pelapor tidak memberikan keterangan.' }}</div>

                        <p class="claim-muted">
                            Informasi ini hanya untuk pemeriksaan Admin dan tidak ditampilkan kepada publik.
                        </p>
                    </div>
                </div>

                {{-- BUKTI TAMBAHAN --}}
                <div class="claim-panel">
                    <div class="claim-panel-title">Bukti Tambahan dari Pelapor</div>
                    <div class="claim-panel-body">
                        @if($klaim->bukti_tambahan)
                            <p>Bukti tambahan telah dikirim oleh Pelapor.</p>
                            <a class="btn primary" href="{{ route('admin.manajemen-klaim.bukti', $klaim->id_klaim) }}">Unduh Bukti Tambahan</a>
                        @else
                            <p class="claim-muted">Belum ada file bukti tambahan yang dikirim.</p>
                        @endif
                    </div>
                </div>

                {{-- KEPUTUSAN --}}
                <div class="claim-panel">
                    <div class="claim-panel-title">Keputusan Verifikasi</div>

                    <div class="claim-panel-body">

                        @if(in_array($klaim->status, [
                            'Menunggu Verifikasi',
                            'Perlu Bukti Tambahan'
                        ], true))

                            <p>Pilih keputusan untuk klaim ini:</p>

                            <label class="claim-decision-option">
                                <input
                                    type="radio"
                                    name="decision"
                                    value="setujui"
                                    checked
                                    onclick="pilihKeputusan('setujui')"
                                >
                                Setujui klaim
                            </label>

                            <label class="claim-decision-option">
                                <input
                                    type="radio"
                                    name="decision"
                                    value="bukti"
                                    onclick="pilihKeputusan('bukti')"
                                >
                                Minta bukti tambahan
                            </label>

                            <label class="claim-decision-option">
                                <input
                                    type="radio"
                                    name="decision"
                                    value="tolak"
                                    onclick="pilihKeputusan('tolak')"
                                >
                                Tolak klaim
                            </label>

                            {{-- FORM SETUJUI --}}
                            <form
                                id="form-setujui"
                                class="claim-decision-form active"
                                action="{{ route('admin.manajemen-klaim.setujui', $klaim->id_klaim) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menyetujui klaim ini?')"
                            >
                                @csrf

                                <label>Catatan Admin (opsional)</label>

                                <textarea
                                    name="catatan_admin"
                                    placeholder="Contoh: Bukti kepemilikan sesuai."
                                >{{ old('catatan_admin') }}</textarea>

                                <div class="claim-actions">
                                    <button type="submit" class="claim-action-btn claim-action-primary">
                                        Simpan Persetujuan
                                    </button>
                                </div>
                            </form>

                            {{-- FORM MINTA BUKTI --}}
                            <form
                                id="form-bukti"
                                class="claim-decision-form"
                                action="{{ route('admin.manajemen-klaim.minta-bukti', $klaim->id_klaim) }}"
                                method="POST"
                                onsubmit="return confirm('Kirim permintaan bukti tambahan untuk klaim ini?')"
                            >
                                @csrf

                                <label>Catatan Admin (wajib)</label>

                                <textarea
                                    name="catatan_admin"
                                    minlength="5"
                                    required
                                    placeholder="Jelaskan bukti tambahan yang dibutuhkan."
                                >{{ old('catatan_admin') }}</textarea>

                                <div class="claim-actions">
                                    <button type="submit" class="claim-action-btn claim-action-warning">
                                        Minta Bukti Tambahan
                                    </button>
                                </div>
                            </form>

                            {{-- FORM TOLAK --}}
                            <form
                                id="form-tolak"
                                class="claim-decision-form"
                                action="{{ route('admin.manajemen-klaim.tolak', $klaim->id_klaim) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menolak klaim ini?')"
                            >
                                @csrf

                                <label>Alasan Penolakan (wajib)</label>

                                <textarea
                                    name="catatan_admin"
                                    minlength="5"
                                    required
                                    placeholder="Jelaskan alasan penolakan klaim."
                                >{{ old('catatan_admin') }}</textarea>

                                <div class="claim-actions">
                                    <button type="submit" class="claim-action-btn claim-action-danger">
                                        Tolak Klaim
                                    </button>
                                </div>
                            </form>

                        @else

                            <div class="claim-detail-row">
                                <span class="claim-label">Keputusan Admin</span>
                                {{ $klaim->status }}
                            </div>

                            <div class="claim-detail-row">
                                <span class="claim-label">Catatan Admin</span>
                                {{ $klaim->catatan_admin ?? '-' }}
                            </div>

                            <div class="claim-detail-row">
                                <span class="claim-label">Admin yang Memproses</span>
                                {{ $klaim->admin->nama ?? '-' }}
                            </div>

                        @endif

                    </div>
                </div>

            </div>

        </section>



<script>
    function pilihKeputusan(keputusan) {
        document.querySelectorAll('.claim-decision-form').forEach(form => {
            form.classList.remove('active');
        });

        const formTerpilih = document.getElementById('form-' + keputusan);

        if (formTerpilih) {
            formTerpilih.classList.add('active');
        }
    }
</script>

</div>
@endsection
