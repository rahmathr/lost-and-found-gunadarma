@extends('super-admin.layouts.app')

@section('title', 'Kelola Akun Admin Kampus')
@section('heading', 'Kelola Akun Admin Kampus')

@push('styles')
<style>
    .sa-admin-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 321px;
        gap: 22px;
        align-items: start;
    }

    .sa-admin-add {
        min-width: 201px;
        margin-bottom: 11px;
    }

    .sa-admin-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .sa-admin-table {
        width: 100%;
        min-width: 690px;
        table-layout: auto;
        border-collapse: collapse;
        background: #fff;
        font-size: 11px;
    }

    .sa-admin-table th,
    .sa-admin-table td {
        padding: 9px 8px;
        border: 1px solid #cfc5dc;
        text-align: left;
        vertical-align: middle;
    }

    .sa-admin-table td:nth-child(2),
    .sa-admin-table td:nth-child(3),
    .sa-admin-table td:nth-child(4),
    .sa-admin-table td:nth-child(5),
    .sa-admin-table td:last-child {
        white-space: nowrap;
    }

    .sa-admin-table td:last-child { width: 82px; }
    .sa-admin-table .sa-btn { display: inline-flex; white-space: nowrap; min-width: 52px; justify-content: center; }

    .sa-admin-table th {
        background: #e2e2e2;
        color: #333;
        font-weight: 700;
        white-space: nowrap;
    }

    .sa-admin-table tbody tr:nth-child(even) {
        background: #f7f2fb;
    }

    .sa-admin-form-panel {
        min-height: 590px;
        padding: 18px 16px;
        border: 1px solid #cfc5dc;
        background: #fff;
    }

    .sa-admin-form-panel h2 {
        margin: 0 0 18px;
        text-align: center;
        font-size: 14px;
    }

    .sa-admin-field {
        margin-bottom: 15px;
    }

    .sa-admin-field label {
        display: block;
        margin-bottom: 5px;
        font-size: 11px;
    }

    .sa-admin-field input,
    .sa-admin-field select {
        display: block;
        width: 100%;
        height: 34px;
        padding: 8px;
        border: 1px solid #aaa;
        border-radius: 4px;
        background: #fff;
        color: #333;
        font: 12px Arial, sans-serif;
    }

    .sa-admin-field input[readonly] {
        background: #f3f0f6;
        color: #777;
    }

    .sa-admin-field small {
        display: block;
        margin-top: 5px;
        color: #777;
        font-size: 10px;
        line-height: 1.4;
    }

    .sa-admin-field .sa-error {
        color: #b42318;
        font-size: 11px;
    }

    .sa-admin-form-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin-top: 17px;
    }

    .sa-admin-form-actions .sa-btn {
        min-width: 100px;
        padding: 12px 18px;
    }

    .sa-admin-empty {
        padding: 20px;
        text-align: center !important;
        color: #777;
    }

    .sa-admin-validation {
        margin-bottom: 14px;
        padding: 10px 25px;
        border: 1px solid #e5b8b8;
        border-radius: 4px;
        background: #fff1f1;
        color: #8b2525;
        font-size: 12px;
    }

    .sa-admin-validation ul {
        margin-bottom: 0;
    }

    .sa-admin-pagination {
        margin-top: 15px;
    }

    .sa-admin-pagination nav {
        display: flex;
        justify-content: center;
    }

    .sa-admin-pagination svg {
        width: 16px;
        height: 16px;
    }

    .sa-admin-pagination a,
    .sa-admin-pagination span {
        padding: 5px 9px;
    }

    /* Warna aksen halaman mengikuti wireframe W-19. */
    .sa-admin-layout .sa-btn-primary {
        background: #7040a5;
        border-color: #7040a5;
        color: #fff;
    }

    .sa-admin-layout .sa-btn-primary:hover {
        background: #5d328d;
        border-color: #5d328d;
    }

    @media (max-width: 950px) {
        .sa-admin-layout {
            grid-template-columns: 1fr;
        }

        .sa-admin-form-panel {
            min-height: auto;
        }
    }

    /* Penyempurnaan responsif tabel dan panel CRUD, tanpa menyentuh navigasi. */
    .sa-admin-layout { grid-template-columns:minmax(0,1.65fr) minmax(280px,1fr); gap:20px; }
    .sa-admin-table-section,.sa-admin-form-panel { min-width:0; }
    .sa-admin-table-wrap { overflow-x:auto; overscroll-behavior-x:contain; border:1px solid #e8e1ed; border-radius:8px; }
    .sa-admin-table { min-width:720px; }
    .sa-admin-table th { white-space:nowrap; }
    .sa-admin-table td { vertical-align:middle; overflow-wrap:anywhere; }
    .sa-admin-form-panel { border-radius:10px; }
    .sa-admin-field { min-width:0; }
    .sa-admin-field input,.sa-admin-field select { width:100%; max-width:100%; min-height:40px; border:1px solid #d8d1df; border-radius:7px; padding:9px 11px; }
    .sa-admin-field input:focus,.sa-admin-field select:focus { outline:0; border-color:#7040a5; box-shadow:0 0 0 3px rgba(112,64,165,.12); }
    .sa-admin-form-actions { display:flex; flex-wrap:wrap; gap:9px; align-items:center; }
    .sa-admin-form-actions .sa-btn { min-height:40px; white-space:nowrap; }
    @media(max-width:1100px){ .sa-admin-layout { grid-template-columns:minmax(0,1fr); } }
    @media(max-width:700px){ .sa-admin-table { min-width:720px; } .sa-admin-form-panel { padding:18px; } }

</style>
@endpush

@section('content')
    @if ($errors->any())
        <div class="sa-admin-validation">
            <strong>Periksa kembali data berikut:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="sa-admin-layout">
        <div class="sa-admin-table-section">
            <a
                href="{{ route('super-admin.admin-kampus.index') }}"
                class="sa-btn sa-btn-primary sa-admin-add"
            >
                + Tambah Akun Admin
            </a>

            <div class="sa-admin-table-wrap">
                <table class="sa-admin-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Kampus</th>
                            <th>Dibuat oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($adminKampus as $admin)
                            <tr>
                                <td>{{ $admin->nama }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>{{ $admin->kampus->nama_kampus ?? '-' }}</td>
                                <td>{{ $admin->superAdminPembuat->nama ?? '-' }}</td>
                                <td>
                                    <a
                                        href="{{ route('super-admin.admin-kampus.index', ['edit' => $admin->id_admin]) }}"
                                        class="sa-btn"
                                    >
                                        Ubah
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="sa-admin-empty">
                                    Belum ada data Admin Kampus.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="sa-admin-pagination">
                {{ $adminKampus->links() }}
            </div>
        </div>

        <div class="sa-admin-form-panel">
            <h2>{{ $adminTerpilih ? 'Ubah Akun Admin' : 'Tambah / Ubah Akun Admin' }}</h2>

            <form
                action="{{ $adminTerpilih
                    ? route('super-admin.admin-kampus.update', $adminTerpilih->id_admin)
                    : route('super-admin.admin-kampus.store') }}"
                method="POST"
            >
                @csrf
                @if ($adminTerpilih)
                    @method('PUT')
                @endif

                <div class="sa-admin-field">
                    <label for="nama">Nama *</label>
                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        value="{{ old('nama', $adminTerpilih->nama ?? '') }}"
                        placeholder="Nama lengkap"
                        maxlength="100"
                        required
                    >
                    @error('nama') <small class="sa-error">{{ $message }}</small> @enderror
                </div>

                <div class="sa-admin-field">
                    <label for="email">Email *</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $adminTerpilih->email ?? '') }}"
                        placeholder="admin@gunadarma.ac.id"
                        maxlength="150"
                        required
                    >
                    @error('email') <small class="sa-error">{{ $message }}</small> @enderror
                </div>

                <div class="sa-admin-field">
                    <label for="password">
                        Kata Sandi Awal {{ $adminTerpilih ? '(kosongkan jika tidak diubah)' : '*' }}
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        minlength="8"
                        {{ $adminTerpilih ? '' : 'required' }}
                    >
                    @if ($adminTerpilih)
                        <small>Kosongkan jika tidak ingin mengubah kata sandi.</small>
                    @endif
                    @error('password') <small class="sa-error">{{ $message }}</small> @enderror
                </div>

                <div class="sa-admin-field">
                    <label for="id_kampus">Kampus yang Dikelola *</label>
                    <select name="id_kampus" id="id_kampus" required>
                        <option value="">Pilih kampus</option>
                        @foreach ($kampus as $item)
                            <option
                                value="{{ $item->id_kampus }}"
                                {{ (string) old('id_kampus', $adminTerpilih->id_kampus ?? '') === (string) $item->id_kampus ? 'selected' : '' }}
                            >
                                {{ $item->nama_kampus }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_kampus') <small class="sa-error">{{ $message }}</small> @enderror
                </div>

                <div class="sa-admin-field">
                    <label for="dibuat_oleh">Dibuat oleh (otomatis)</label>
                    <input
                        type="text"
                        id="dibuat_oleh"
                        value="{{ $adminTerpilih
                            ? ($adminTerpilih->superAdminPembuat->nama ?? 'Tidak diketahui')
                            : ($namaSuperAdmin ?? 'Super Admin') . ' (Super Admin)' }}"
                        readonly
                    >
                </div>

                <div class="sa-admin-form-actions">
                    <button type="submit" class="sa-btn sa-btn-primary">Simpan</button>
                    <a href="{{ route('super-admin.admin-kampus.index') }}" class="sa-btn">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
