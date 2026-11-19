@extends('satpam.layouts.app')

@section('title', 'Penerimaan Barang')
@section('heading', 'Penerimaan Barang')

@push('styles')

<style>
.satpam-index-page{width:100%;max-width:1400px;margin:0 auto;padding:0!important;color:#30283a}
.satpam-index-page *{box-sizing:border-box}
.satpam-index-page .columns{display:grid;grid-template-columns:minmax(0,1.05fr) minmax(0,1fr);gap:20px;align-items:start}
.satpam-index-page .panel{min-width:0;background:#fff;border:1px solid #e7e0ef;border-radius:10px;overflow:hidden;box-shadow:0 2px 8px rgba(57,36,81,.04)}
.satpam-index-page .panel-header{background:#f3eef8;border-bottom:1px solid #e7e0ef;padding:13px 16px;font-size:14px;font-weight:700;color:#392451}
.satpam-index-page .form-body,.satpam-index-page .table-body{padding:18px}
.satpam-index-page .form-group{margin-bottom:16px;min-width:0}
.satpam-index-page label{display:block;font-size:13px;font-weight:600;color:#443653;margin:0 0 7px}
.satpam-index-page input,.satpam-index-page select,.satpam-index-page textarea{display:block;width:100%;max-width:100%;min-width:0;padding:10px 12px;border:1px solid #d8cfe2;border-radius:7px;background:#fff;color:#30283a;font:inherit;font-size:13px;line-height:1.45}
.satpam-index-page textarea{min-height:90px;resize:vertical}
.satpam-index-page input:focus,.satpam-index-page select:focus,.satpam-index-page textarea:focus{outline:0;border-color:#7040a5;box-shadow:0 0 0 3px rgba(112,64,165,.12)}
.satpam-index-page .two-columns{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}
.satpam-index-page .status-info,.satpam-index-page .note{padding:12px 14px;border:1px solid #ead8a2;border-radius:7px;background:#fff8e6;color:#725516;font-size:12px;line-height:1.55;margin:0 0 16px}
.satpam-index-page .buttons{display:flex;flex-wrap:wrap;gap:9px;align-items:center}
.satpam-index-page button,.satpam-index-page .btn{display:inline-flex;align-items:center;justify-content:center;min-height:38px;padding:9px 14px;border:1px solid #7040a5;border-radius:7px;background:#7040a5;color:#fff;text-decoration:none;font-size:13px;font-weight:600;line-height:1.2;cursor:pointer}
.satpam-index-page button:hover,.satpam-index-page .btn:hover{background:#593184;border-color:#593184;color:#fff}
.satpam-index-page table{width:100%;border-collapse:collapse;font-size:13px;line-height:1.45}
.satpam-index-page th,.satpam-index-page td{padding:11px 10px;border:1px solid #e5deeb;text-align:left;vertical-align:middle;overflow-wrap:anywhere}
.satpam-index-page th{background:#f3eef8;color:#392451;font-weight:700;white-space:normal}
.satpam-index-page tbody tr:nth-child(even){background:#fbfafd}
.satpam-index-page .table-body{overflow-x:auto}
.satpam-index-page .empty{text-align:center;color:#766b80;padding:22px}
.satpam-index-page .alert{padding:12px 14px;margin:0 0 15px;border-radius:7px;font-size:13px;line-height:1.5}
.satpam-index-page .alert.success{background:#ecfdf3;color:#166534;border:1px solid #bbf7d0}
.satpam-index-page .alert.error{background:#fff1f2;color:#9f1239;border:1px solid #fecdd3}
.satpam-index-page .pagination{margin-top:16px;overflow-x:auto}
.satpam-index-page .btn-delete{background:#c62828!important;border-color:#c62828!important;color:#fff!important}
.satpam-index-page .btn-delete:hover{background:#a91f1f!important;border-color:#941b1b!important}
@media(max-width:900px){.satpam-index-page .columns{grid-template-columns:1fr}}
@media(max-width:600px){.satpam-index-page .form-body,.satpam-index-page .table-body{padding:12px}.satpam-index-page .two-columns{grid-template-columns:1fr}.satpam-index-page table{min-width:720px}}
</style>
@endpush

@section('content')
<div class="content satpam-index-page">

            @if (session('success'))
                <div class="alert success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert error">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert error">
                    <strong>Periksa kembali data berikut:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="columns">

                <!-- FORM PENERIMAAN -->
                <section class="panel">

                    <div class="panel-header">
                        Catatan Penerimaan Sementara
                    </div>

                    <div class="form-body">

                        <form
                            action="{{ route('satpam.barang-temuan.store') }}"
                            method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            <div class="form-group">
                                <label for="nama_publik">
                                    Nama / Jenis Barang *
                                </label>

                                <input
                                    type="text"
                                    name="nama_publik"
                                    id="nama_publik"
                                    value="{{ old('nama_publik') }}"
                                    maxlength="150"
                                    placeholder="Mis. Flashdisk hitam"
                                    required>

                                @error('nama_publik')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="kategori">Kategori *</label>

                                <select name="kategori" id="kategori" required>
                                    <option value="">Pilih kategori ▼</option>

                                    @foreach ([
                                        'Elektronik',
                                        'Aksesoris',
                                        'Dokumen',
                                        'Kunci',
                                        'Pakaian',
                                        'Perlengkapan',
                                        'Tas',
                                        'Lainnya'
                                    ] as $kategori)
                                        <option
                                            value="{{ $kategori }}"
                                            @selected(old('kategori') === $kategori)>
                                            {{ $kategori }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('kategori')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="deskripsi_publik">
                                    Deskripsi Singkat *
                                </label>

                                <textarea
                                    name="deskripsi_publik"
                                    id="deskripsi_publik"
                                    required
                                    placeholder="Warna, merek, kondisi...">{{ old('deskripsi_publik') }}</textarea>

                                @error('deskripsi_publik')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="two-columns">

                                <div class="form-group">
                                    <label for="tanggal_ditemukan">
                                        Tanggal Ditemukan *
                                    </label>

                                    <input
                                        type="date"
                                        name="tanggal_ditemukan"
                                        id="tanggal_ditemukan"
                                        value="{{ old('tanggal_ditemukan') }}"
                                        required>

                                    @error('tanggal_ditemukan')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="lokasi_ditemukan">
                                        Lokasi Ditemukan *
                                    </label>

                                    <input
                                        type="text"
                                        name="lokasi_ditemukan"
                                        id="lokasi_ditemukan"
                                        value="{{ old('lokasi_ditemukan') }}"
                                        maxlength="180"
                                        placeholder="Mis. Kantin"
                                        required>

                                    @error('lokasi_ditemukan')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="foto">Foto Barang (maksimal 4 foto, masing-masing 5 MB)</label>
                                <input
                                    type="file"
                                    name="foto[]"
                                    id="foto"
                                    accept="image/jpeg,image/png,image/webp"
                                    multiple>
                                <small style="display:block; color:#666; margin-top:5px;">
                                    Format JPG, PNG, atau WebP. Foto boleh dikosongkan.
                                </small>
                                @error('foto')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror
                                @error('foto.*')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="status-info">
                                Status otomatis: Diterima Satpam
                            </div>

                            <div class="buttons">

                                <button type="submit" class="primary">
                                    Simpan Catatan Penerimaan
                                </button>

                                <button type="reset">
                                    Reset
                                </button>

                            </div>

                        </form>

                    </div>

                </section>

                <!-- DAFTAR PENERIMAAN TERBARU -->
                <section class="panel">

                    <div class="panel-header">
                        Catatan Penerimaan Terbaru
                    </div>

                    <div class="table-body">

                        <table>
                            <thead>
                                <tr>
                                    <th>Barang</th>
                                    <th>Tanggal Ditemukan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($riwayatTerbaru as $item)
                                    <tr>
                                        <td>{{ $item->nama_publik }}</td>

                                        <td>
                                            {{ $item->tanggal_ditemukan->format('d-m-Y') }}
                                        </td>

                                        <td>
                                            <span class="badge {{ $item->status === 'Diterima Satpam' ? 'tervalidasi' : match ($item->status) {
                                                'Ditolak' => 'status-rejected',
                                                'Dipublikasikan', 'Diserahkan' => 'status-approved',
                                                'Dalam Proses Penyerahan' => 'status-other',
                                                default => 'status-pending',
                                            } }}">
                                                {{ $item->status === 'Diterima Satpam' ? 'Diterima' : $item->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="empty">
                                            Belum ada catatan penerimaan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="note">
                            Barang fisik disimpan sementara di pos keamanan
                            sampai diproses Admin Kampus. Tanggal yang ditampilkan
                            merupakan tanggal ditemukan, bukan jam penerimaan.
                        </div>

                    </div>

                </section>

            </div>

            <!-- DAFTAR LENGKAP -->
            <section style="margin-top:25px;">

                <h3 style="font-size:14px;">
                    Riwayat Barang yang Dicatat
                </h3>

                <div class="panel">
                    <div class="table-body">

                        <table>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Tanggal Ditemukan</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($barangTemuan as $item)
                                    <tr>
                                        <td>
                                            {{ $barangTemuan->firstItem() + $loop->index }}
                                        </td>

                                        <td>{{ $item->nama_publik }}</td>

                                        <td>{{ $item->kategori }}</td>

                                        <td>
                                            {{ $item->tanggal_ditemukan->format('d-m-Y') }}
                                        </td>

                                        <td>{{ $item->lokasi_ditemukan }}</td>

                                        <td><span class="status {{ match ($item->status) {
                            'Ditolak' => 'status-rejected',
                            'Dipublikasikan', 'Diserahkan' => 'status-approved',
                            'Dalam Proses Penyerahan' => 'status-other',
                            default => 'status-pending',
                        } }}">{{ $item->status }}</span></td>

                                        <td>
                                            @if ($item->status === 'Diterima Satpam')
                                                <a
                                                    class="btn"
                                                    href="{{ route('satpam.barang-temuan.edit', ['barangTemuan' => $item->id_barang]) }}">
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ route('satpam.barang-temuan.destroy', ['barangTemuan' => $item->id_barang]) }}"
                                                    method="POST"
                                                    style="display:inline;"
                                                    onsubmit="return confirm('Yakin ingin menghapus barang ini?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn-delete">
                                                        Hapus
                                                    </button>

                                                </form>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="empty">
                                            Belum ada barang yang dicatat.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="pagination">
                            {{ $barangTemuan->links() }}
                        </div>

                    </div>
                </div>

            </section>

        </div>
@endsection
