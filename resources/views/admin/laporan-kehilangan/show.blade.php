@extends('admin.layouts.app')

@section('title', 'Proses Laporan Kehilangan')
@section('heading', 'Proses Laporan Kehilangan')

@section('pageStyles')
<style>
        .admin-kampus-admin-laporan-kehilangan-show-blade-php .sidebar a:hover, .admin-kampus-admin-laporan-kehilangan-show-blade-php .active{ background:#7040a5; }
        .admin-kampus-admin-laporan-kehilangan-show-blade-php .content{ padding:20px; }
        .admin-kampus-admin-laporan-kehilangan-show-blade-php .panel{ border:1px solid #bbb; margin-top:20px; }
        .admin-kampus-admin-laporan-kehilangan-show-blade-php .panel-title{ background:#eee7f5; padding:12px; border-bottom:1px solid #c9b2e6; font-weight:bold; }
        .admin-kampus-admin-laporan-kehilangan-show-blade-php .panel-body{ padding:20px; }
        .admin-kampus-admin-laporan-kehilangan-show-blade-php .grid{ display:grid; grid-template-columns:1fr 1fr; gap:25px; }
        .admin-kampus-admin-laporan-kehilangan-show-blade-php label{ display:block; font-size:13px; margin:12px 0 7px; }
        .admin-kampus-admin-laporan-kehilangan-show-blade-php select, .admin-kampus-admin-laporan-kehilangan-show-blade-php textarea, .admin-kampus-admin-laporan-kehilangan-show-blade-php button, .admin-kampus-admin-laporan-kehilangan-show-blade-php .btn{ width:100%; padding:11px; border:1px solid #999; border-radius:4px; }
        .admin-kampus-admin-laporan-kehilangan-show-blade-php textarea{ min-height:110px; resize:vertical; }
        .admin-kampus-admin-laporan-kehilangan-show-blade-php button, .admin-kampus-admin-laporan-kehilangan-show-blade-php .btn{ cursor:pointer; text-decoration:none; }
        .admin-kampus-admin-laporan-kehilangan-show-blade-php .primary{ background:#7040a5; border-color:#7040a5; color:white; }
        .admin-kampus-admin-laporan-kehilangan-show-blade-php .alert{ padding:12px; margin-bottom:15px; }
        .admin-kampus-admin-laporan-kehilangan-show-blade-php .success{ background:#dcfce7; color:#166534; }
        .admin-kampus-admin-laporan-kehilangan-show-blade-php .error{ background:#fee2e2; color:#991b1b; }
        .admin-kampus-admin-laporan-kehilangan-show-blade-php .info{ line-height:1.8; font-size:13px; }
        .admin-kampus-admin-laporan-kehilangan-show-blade-php .actions{ display:flex; gap:10px; margin-top:20px; }
        @media(max-width:750px) {
            .admin-kampus-admin-laporan-kehilangan-show-blade-php .grid{ grid-template-columns:1fr; }
        }

</style>
@endsection

@section('content')
<div class="admin-kampus-page admin-kampus-admin-laporan-kehilangan-show-blade-php">
<section class="content">

            @if(session('success'))
                <div class="alert success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <a href="{{ route('admin.laporan-kehilangan.index') }}" class="btn">
                Kembali ke Daftar
            </a>

            <div class="panel">
                <div class="panel-title">
                    Detail Laporan Kehilangan
                </div>

                <div class="panel-body">
                    <div class="grid">

                        <div class="info">
                            <strong>Informasi Laporan</strong>
                            <p>
                                Pelapor:
                                {{ $laporan->pelapor->nama ?? '-' }}
                                <br>
                                Barang: {{ $laporan->nama_barang }}
                                <br>
                                Deskripsi: {{ $laporan->deskripsi }}
                                <br>
                                Tanggal Hilang:
                                {{ \Carbon\Carbon::parse($laporan->tanggal_hilang)->format('d M Y') }}
                                <br>
                                Lokasi: {{ $laporan->lokasi_hilang }}
                                <br>
                                Kampus: {{ $laporan->kampus->nama_kampus ?? '-' }}
                                <br>
                                Status: <span class="status {{ match ($laporan->status) {
                                    'Diajukan' => 'status-pending',
                                    'Dalam Penanganan', 'Menunggu Informasi' => 'status-other',
                                    'Selesai' => 'status-approved',
                                    'Ditolak' => 'status-rejected',
                                    default => 'status-other',
                                } }}">{{ $laporan->status }}</span>
                            </p>
                        </div>

                        <div class="info" style="margin-top:18px;">
                            <strong>Foto Barang yang Hilang</strong>
                            @if($laporan->foto->isNotEmpty())
                                <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:12px;">
                                    @foreach($laporan->foto as $fotoLaporan)
                                        <a href="{{ route('admin.laporan-kehilangan.foto', ['id' => $laporan->id_laporan, 'foto' => $fotoLaporan->id_foto_laporan]) }}" target="_blank" rel="noopener">
                                            <img src="{{ route('admin.laporan-kehilangan.foto', ['id' => $laporan->id_laporan, 'foto' => $fotoLaporan->id_foto_laporan]) }}" alt="Foto barang hilang" style="width:110px;height:110px;object-fit:cover;border:1px solid #ccc;border-radius:5px;">
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <p>Belum ada foto yang diunggah.</p>
                            @endif
                        </div>

                        <div>
                            <form
                                action="{{ route('admin.laporan-kehilangan.update', $laporan->id_laporan) }}"
                                method="POST"
                            >
                                @csrf
                                @method('PUT')

                                <strong>Perbarui Status Laporan</strong>

                                <label for="status">Status</label>
                                <select name="status" id="status" required>
                                    @foreach($daftarStatus as $status)
                                        <option value="{{ $status }}"
                                            @selected(old('status', $laporan->status) === $status)>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>

                                <label for="catatan_admin">Catatan Admin</label>
                                <textarea
                                    name="catatan_admin"
                                    id="catatan_admin"
                                    placeholder="Catatan internal (opsional)"
                                >{{ old('catatan_admin', $laporan->catatan_admin) }}</textarea>

                                <div class="actions">
                                    <button type="submit" class="primary">
                                        Perbarui Laporan
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </section>

</div>
@endsection
