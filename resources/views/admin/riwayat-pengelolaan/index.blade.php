@extends('admin.layouts.app')

@section('title', 'Riwayat Pengelolaan')
@section('heading', 'Riwayat Pengelolaan')

@section('pageStyles')
<style>

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .brand{
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .logo{
            width: 35px;
            height: 35px;
            border: 1px solid #aaa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .brand strong{
            font-size: 14px;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .brand small{
            display: block;
            margin-top: 4px;
            color: #ccc;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .sidebar a, .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .logout-button{
            display: block;
            width: 100%;
            padding: 10px 8px;
            margin-bottom: 5px;
            color: white;
            background: transparent;
            border: none;
            border-radius: 2px;
            text-decoration: none;
            text-align: left;
            font-family: inherit;
            font-size: 13px;
            cursor: pointer;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .sidebar a:hover, .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .sidebar a.active, .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .logout-button:hover{
            background: #7040a5;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .content{
            padding: 25px 20px;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .panel{
            border: 1px solid #bbb;
            padding: 20px;
            margin-bottom: 25px;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php h3{
            font-size: 15px;
            margin: 0 0 18px;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .filter-grid{
            display: grid;
            grid-template-columns: 1fr 1fr 1fr auto;
            gap: 15px;
            align-items: end;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php label{
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php input[type="date"], .admin-kampus-admin-riwayat-pengelolaan-index-blade-php select{
            width: 100%;
            height: 38px;
            border: 1px solid #aaa;
            border-radius: 4px;
            padding: 8px;
            font-size: 13px;
            background: white;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .btn{
            display: inline-block;
            padding: 10px 16px;
            border: 1px solid #777;
            border-radius: 4px;
            background: white;
            color: #333;
            text-decoration: none;
            font-size: 13px;
            cursor: pointer;
            white-space: nowrap;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .btn-primary{
            background: #7040a5;
            color: white;
            border-color: #3072c4;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .table-wrapper{
            overflow-x: auto;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php table{
            width: 100%;
            border-collapse: collapse;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php th, .admin-kampus-admin-riwayat-pengelolaan-index-blade-php td{
            border: 1px solid #ccc;
            padding: 12px 10px;
            text-align: left;
            vertical-align: top;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php th{
            background: #eee7f5;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php tbody tr:nth-child(even){
            background: #f7f7f7;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .actor-role{
            display: block;
            margin-top: 4px;
            color: #777;
            font-size: 12px;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .reference{
            display: inline-block;
            background: #f0e8f8;
            padding: 5px 8px;
            border-radius: 3px;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .empty{
            text-align: center;
            padding: 25px;
            color: #777;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .pagination{
            margin-top: 20px;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .alert{
            padding: 12px;
            margin-bottom: 20px;
            background: #fce4e4;
            color: #9b2525;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .summary{
            margin-bottom: 15px;
            color: #666;
        }

        @media (max-width: 850px) {

            .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .filter-grid{
                grid-template-columns: 1fr;
            }

            .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .content{
                padding: 15px;
            }
        }



        /* Pagination khusus halaman Riwayat Pengelolaan Admin Kampus.
           Selector dibuat unik agar tidak berbenturan dengan layout/role lain. */
        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .admin-content .riwayat-pengelolaan-pagination{
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 18px;
            padding: 14px 0 4px;
            border-top: 1px solid #eee8f2;
            color: #62596b;
            font-family: Arial, sans-serif;
            font-size: 13px;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .admin-content .riwayat-pengelolaan-pagination__info{
            line-height: 1.5;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .admin-content .riwayat-pengelolaan-pagination__nav{
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 5px;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .admin-content .riwayat-pengelolaan-pagination__nav a, .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .admin-content .riwayat-pengelolaan-pagination__number, .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .admin-content .riwayat-pengelolaan-pagination__control{
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            min-height: 34px;
            margin: 0;
            padding: 6px 10px;
            border: 1px solid #e1d8eb;
            border-radius: 6px;
            background: #fff;
            color: #4b2d73;
            font-family: Arial, sans-serif;
            font-size: 13px !important;
            font-weight: 600;
            line-height: 1.2;
            text-decoration: none;
            white-space: nowrap;
            box-shadow: none;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .admin-content .riwayat-pengelolaan-pagination__nav a:hover{
            border-color: #7040a5;
            background: #f5f0fa;
            color: #392451;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .admin-content .riwayat-pengelolaan-pagination__number.is-active{
            border-color: #4b2d73;
            background: #4b2d73;
            color: #fff;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .admin-content .riwayat-pengelolaan-pagination__control.is-disabled{
            border-color: #eee8f2;
            background: #faf9fb;
            color: #aaa2b2;
            cursor: not-allowed;
        }

        .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .admin-content .riwayat-pengelolaan-pagination__dots{
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 22px;
            color: #8a8193;
        }

        @media (max-width: 650px) {
            .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .admin-content .riwayat-pengelolaan-pagination{
                align-items: flex-start;
                flex-direction: column;
            }

            .admin-kampus-admin-riwayat-pengelolaan-index-blade-php .admin-content .riwayat-pengelolaan-pagination__nav{
                max-width: 100%;
            }
        }

        .riwayat-filter-section { margin: 0 0 22px; padding: 0; border: 0; background: transparent; }
        .riwayat-filter-section h3 { margin: 0 0 10px; color: #392451; font-size: 15px; }
</style>
@endsection

@section('content')
<div class="admin-kampus-page admin-kampus-admin-riwayat-pengelolaan-index-blade-php">
<section class="content">

            @if ($errors->any())
                <div class="alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="riwayat-filter-section">
                <h3>Filter Riwayat</h3>

                <form method="GET" action="{{ route('admin.riwayat-pengelolaan.index') }}" class="lf-filter">
                    <div class="lf-filter__field">
                        <label for="tanggal_mulai">Tanggal Mulai</label>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
                    </div>
                    <div class="lf-filter__field">
                        <label for="tanggal_akhir">Tanggal Akhir</label>
                        <input type="date" id="tanggal_akhir" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                    </div>
                    <div class="lf-filter__field">
                        <label for="jenis_tindakan">Jenis Tindakan</label>
                        <select id="jenis_tindakan" name="jenis_tindakan">
                            <option value="">Semua Tindakan</option>
                            @foreach ($jenisTindakan as $jenis)
                                <option value="{{ $jenis }}" @selected(request('jenis_tindakan') === $jenis)>{{ $jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="lf-filter__actions">
                        <button type="submit">Terapkan</button>
                        <a href="{{ route('admin.riwayat-pengelolaan.index') }}">Reset</a>
                    </div>
                </form>
            </div>

            <h3>Daftar Riwayat Aktivitas</h3>

            <div class="summary">
                Total {{ $aktivitas->total() }} aktivitas ditemukan.
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Aktor</th>
                            <th>Tindakan</th>
                            <th>Referensi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($aktivitas as $item)
                            <tr>
                                <td>
                                    {{ $item->waktu
                                        ? $item->waktu->format('d M Y H:i')
                                        : '-' }}
                                </td>

                                <td>
                                    @if ($item->id_admin)
                                        {{ $item->admin->nama ?? '-' }}

                                        <span class="actor-role">
                                            Admin Kampus
                                        </span>
                                    @elseif ($item->id_satpam)
                                        {{ $item->satpam->nama ?? '-' }}

                                        <span class="actor-role">
                                            Satpam
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    {{ $item->tindakan }}
                                </td>

                                <td>
                                    <span class="reference">
                                        {{ $item->referensi_jenis ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty">
                                    Belum ada aktivitas yang sesuai
                                    dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @php
                $aktivitas->appends(request()->query());
                $halamanSekarang = $aktivitas->currentPage();
                $halamanTerakhir = $aktivitas->lastPage();
                $halamanAwal = max(1, $halamanSekarang - 2);
                $halamanAkhir = min($halamanTerakhir, $halamanSekarang + 2);
            @endphp

            <div class="riwayat-pengelolaan-pagination">
                <div class="riwayat-pengelolaan-pagination__info">
                    Menampilkan
                    <strong>{{ $aktivitas->firstItem() ?? 0 }}–{{ $aktivitas->lastItem() ?? 0 }}</strong>
                    dari <strong>{{ $aktivitas->total() }}</strong> aktivitas
                </div>

                @if ($aktivitas->hasPages())
                    <nav class="riwayat-pengelolaan-pagination__nav" aria-label="Navigasi halaman riwayat pengelolaan">
                        @if ($aktivitas->onFirstPage())
                            <span class="riwayat-pengelolaan-pagination__control is-disabled" aria-disabled="true">‹ Sebelumnya</span>
                        @else
                            <a class="riwayat-pengelolaan-pagination__control" href="{{ $aktivitas->previousPageUrl() }}">‹ Sebelumnya</a>
                        @endif

                        @if ($halamanAwal > 1)
                            <a class="riwayat-pengelolaan-pagination__number" href="{{ $aktivitas->url(1) }}">1</a>
                            @if ($halamanAwal > 2)
                                <span class="riwayat-pengelolaan-pagination__dots">…</span>
                            @endif
                        @endif

                        @for ($halaman = $halamanAwal; $halaman <= $halamanAkhir; $halaman++)
                            @if ($halaman === $halamanSekarang)
                                <span class="riwayat-pengelolaan-pagination__number is-active" aria-current="page">{{ $halaman }}</span>
                            @else
                                <a class="riwayat-pengelolaan-pagination__number" href="{{ $aktivitas->url($halaman) }}">{{ $halaman }}</a>
                            @endif
                        @endfor

                        @if ($halamanAkhir < $halamanTerakhir)
                            @if ($halamanAkhir < $halamanTerakhir - 1)
                                <span class="riwayat-pengelolaan-pagination__dots">…</span>
                            @endif
                            <a class="riwayat-pengelolaan-pagination__number" href="{{ $aktivitas->url($halamanTerakhir) }}">{{ $halamanTerakhir }}</a>
                        @endif

                        @if ($aktivitas->hasMorePages())
                            <a class="riwayat-pengelolaan-pagination__control" href="{{ $aktivitas->nextPageUrl() }}">Berikutnya ›</a>
                        @else
                            <span class="riwayat-pengelolaan-pagination__control is-disabled" aria-disabled="true">Berikutnya ›</span>
                        @endif
                    </nav>
                @endif
            </div>

        </section>

</div>
@endsection
