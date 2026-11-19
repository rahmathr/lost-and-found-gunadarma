@extends('admin.layouts.app')

@section('title', 'Penyerahan Barang')
@section('heading', 'Penyerahan Barang')

@section('pageStyles')
<style>

        .admin-kampus-admin-penyerahan-index-blade-php .brand{
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .logo{
            width: 35px;
            height: 35px;
            border: 1px solid #aaa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .brand strong{
            font-size: 14px;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .brand small{
            display: block;
            margin-top: 4px;
            color: #ccc;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .sidebar a:hover, .admin-kampus-admin-penyerahan-index-blade-php .sidebar a.active{
            background: #7040a5;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .logout-form{
            margin: 0;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .logout-button{
            display: block;
            width: 100%;
            text-align: left;
            background: none;
            border: 0;
            color: white;
            padding: 10px 8px;
            cursor: pointer;
            font-family: Arial, sans-serif;
            font-size: 13px;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .logout-button:hover{
            background: #555;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .topbar small{
            color: #555;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .content{
            padding: 25px 20px;
        }

        .admin-kampus-admin-penyerahan-index-blade-php h3{
            font-size: 14px;
            margin: 0 0 12px;
        }

        .admin-kampus-admin-penyerahan-index-blade-php table{
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .admin-kampus-admin-penyerahan-index-blade-php th, .admin-kampus-admin-penyerahan-index-blade-php td{
            border: 1px solid #ccc;
            padding: 10px 8px;
            text-align: left;
        }

        .admin-kampus-admin-penyerahan-index-blade-php th{
            background: #eee7f5;
            font-weight: bold;
        }

        .admin-kampus-admin-penyerahan-index-blade-php tbody tr:nth-child(even){
            background: #f7f7f7;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .status{
            display: inline-block;
            min-width: 88px;
            padding: 4px 8px;
            text-align: center;
            border: 1px solid #77b85d;
            background: #d9ead3;
            color: #315d25;
            border-radius: 3px;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .btn{
            display: inline-block;
            padding: 8px 14px;
            border: 1px solid #555;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
            background: white;
            cursor: pointer;
            font-size: 12px;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .btn-primary{
            color: white;
            background: #7040a5;
            border-color: #3072c4;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .btn-primary:hover{
            background: #5c328b;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .form-panel{
            border: 1px solid #bbb;
            padding: 18px 16px 30px;
            margin-top: 25px;
            min-height: 380px;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .form-grid{
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .field{
            margin-bottom: 22px;
        }

        .admin-kampus-admin-penyerahan-index-blade-php label{
            display: block;
            margin: 0 0 7px 3px;
            color: #555;
        }

        .admin-kampus-admin-penyerahan-index-blade-php input[type="text"], .admin-kampus-admin-penyerahan-index-blade-php input[type="datetime-local"], .admin-kampus-admin-penyerahan-index-blade-php textarea{
            width: 100%;
            border: 1px solid #aaa;
            border-radius: 5px;
            padding: 10px;
            font-family: Arial, sans-serif;
            font-size: 13px;
        }

        .admin-kampus-admin-penyerahan-index-blade-php input[readonly]{
            background: #f7f7f7;
            color: #888;
        }

        .admin-kampus-admin-penyerahan-index-blade-php textarea{
            resize: vertical;
            min-height: 72px;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .checkbox{
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 10px 0 20px;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .checkbox label{
            margin: 0;
            color: #333;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .actions{
            display: flex;
            gap: 10px;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .actions button{
            min-width: 100px;
            padding: 12px 20px;
            font-weight: bold;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .alert{
            padding: 12px;
            margin-bottom: 18px;
            border-radius: 4px;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .success{
            background: #d9ead3;
            color: #315d25;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .error{
            background: #fce4e4;
            color: #9b2525;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .validation{
            color: #c62828;
            font-size: 12px;
            margin-top: 5px;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .empty{
            text-align: center;
            padding: 25px;
            color: #777;
        }

        .admin-kampus-admin-penyerahan-index-blade-php .pagination{
            margin-top: 15px;
        }

        @media (max-width: 750px) {

            .admin-kampus-admin-penyerahan-index-blade-php .form-grid{
                grid-template-columns: 1fr;
                gap: 0;
            }

            .admin-kampus-admin-penyerahan-index-blade-php .content{
                overflow-x: auto;
            }
        }

</style>
@endsection

@section('content')
<div class="admin-kampus-page admin-kampus-admin-penyerahan-index-blade-php">
<section class="content">

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
                    <strong>Periksa kembali data yang dimasukkan:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h3>Klaim Disetujui (Menunggu Penyerahan)</h3>

            <table>
                <thead>
                    <tr>

                        <th>Pelapor</th>
                        <th>Barang</th>
                        <th>Tanggal Klaim</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($klaim as $item)
                        <tr>


                            <td>
                                {{ $item->pelaporKehilangan->nama ?? '-' }}
                            </td>

                            <td>
                                {{ $item->barangDitemukan->nama_publik ?? '-' }}
                            </td>

                            <td>
                                {{ $item->tanggal_klaim
                                    ? \Carbon\Carbon::parse($item->tanggal_klaim)->format('d M Y')
                                    : '-' }}
                            </td>

                            <td>
                                <span class="status {{ match ($item->status) {
                                    'Disetujui', 'Diserahkan' => 'status-approved',
                                    'Ditolak' => 'status-rejected',
                                    'Menunggu Verifikasi' => 'status-pending',
                                    default => 'status-other',
                                } }}">
                                    {{ $item->status }}
                                </span>
                            </td>

                            <td>
                                <a
                                    href="{{ route('admin.penyerahan.index', ['klaim' => $item->id_klaim]) }}"
                                    class="btn btn-primary">
                                    Catat Penyerahan
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">
                                Belum ada klaim yang menunggu penyerahan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination">
                {{ $klaim->links() }}
            </div>

            @if ($klaimTerpilih)
                <div class="form-panel" id="form-penyerahan">

                    <h3>Form Penyerahan Barang</h3>

                    <form
                        action="{{ route('admin.penyerahan.store', $klaimTerpilih->id_klaim) }}"
                        method="POST">

                        @csrf

                        <div class="form-grid">

                            <div class="field">
                                <label>Klaim</label>

                                <input
                                    type="text"
                                    readonly
                                    value="{{ $klaimTerpilih->pelaporKehilangan->nama ?? '-' }} - {{ $klaimTerpilih->barangDitemukan->nama_publik ?? '-' }}">
                            </div>

                            <div class="field">
                                <label for="tanggal_penyerahan">
                                    Tanggal & Waktu Penyerahan *
                                </label>

                                <input
                                    type="datetime-local"
                                    id="tanggal_penyerahan"
                                    name="tanggal_penyerahan"
                                    value="{{ old('tanggal_penyerahan') }}"
                                    required>

                                @error('tanggal_penyerahan')
                                    <div class="validation">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="field">
                            <label for="catatan">Catatan Penyerahan</label>

                            <textarea
                                id="catatan"
                                name="catatan"
                                maxlength="2000"
                                placeholder="Contoh: Barang diserahkan langsung kepada pemilik.">{{ old('catatan') }}</textarea>

                            @error('catatan')
                                <div class="validation">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="checkbox">
                            <input
                                type="checkbox"
                                id="konfirmasi_identitas"
                                name="konfirmasi_identitas"
                                value="1"
                                required
                                {{ old('konfirmasi_identitas') ? 'checked' : '' }}>

                            <label for="konfirmasi_identitas">
                                Identitas penerima telah dicocokkan dengan data pelapor / tanda pengenal
                            </label>
                        </div>

                        @error('konfirmasi_identitas')
                            <div class="validation">{{ $message }}</div>
                        @enderror

                        <div class="actions">
                            <button type="submit" class="btn btn-primary">
                                Catat Penyerahan
                            </button>

                            <a
                                href="{{ route('admin.penyerahan.index') }}"
                                class="btn">
                                Batal
                            </a>
                        </div>

                    </form>
                </div>
            @endif

        </section>

</div>
@endsection
