<?php

namespace App\Http\Controllers;

use App\Models\AdminKampus;
use App\Models\BarangDitemukan;
use App\Models\Kampus;
use App\Models\Klaim;
use App\Models\LaporanKehilangan;
use App\Models\Satpam;
use App\Models\PelaporKehilangan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function superAdmin(Request $request)
    {
        $kampusTerpilih = $request->query('kampus');

        // Statistik keseluruhan sistem.
        $totalKampus = Kampus::count();
        $totalAdmin = AdminKampus::count();
        $totalBarangDitemukan = BarangDitemukan::count();

        $totalKlaimDisetujui = Klaim::where(
            'status',
            'Disetujui'
        )->count();

        // Status barang yang sudah berhasil dipublikasikan.
        $statusDipublikasikan = [
            'Dipublikasikan',
            'Dalam Proses Penyerahan',
            'Diserahkan',
        ];

        // Mengambil data kampus beserta statistiknya.
        $kampus = Kampus::query()
            ->withCount([
                'adminKampus',

                'barangDitemukan as barang_dipublikasikan_count'
                    => function ($query) use ($statusDipublikasikan) {
                        $query->whereIn('status', $statusDipublikasikan);
                    },

                'laporanKehilangan as laporan_aktif_count'
                    => function ($query) {
                        $query->whereIn('status', [
                            'Diajukan',
                            'Dalam Penanganan',
                            'Menunggu Informasi',
                        ]);
                    },
            ])
            ->orderBy('id_kampus')
            ->get();

        // Statistik klaim menunggu dan barang diserahkan per kampus.
        foreach ($kampus as $dataKampus) {
            $dataKampus->klaim_menunggu_count = Klaim::where(
                'status',
                'Menunggu Verifikasi'
            )
                ->whereHas('barangDitemukan', function ($query) use ($dataKampus) {
                    $query->where('id_kampus', $dataKampus->id_kampus);
                })
                ->count();

            $dataKampus->barang_diserahkan_count = BarangDitemukan::where(
                'id_kampus',
                $dataKampus->id_kampus
            )
                ->where('status', 'Diserahkan')
                ->count();
        }

        // Filter tabel dan grafik berdasarkan kampus.
        $kampusDitampilkan = $kampus;

        if ($kampusTerpilih !== null && $kampusTerpilih !== '') {
            $kampusDitampilkan = $kampus->filter(function ($item) use ($kampusTerpilih) {
                return (string) $item->id_kampus === (string) $kampusTerpilih;
            });

            if ($kampusDitampilkan->isEmpty()) {
                abort(404, 'Kampus tidak ditemukan.');
            }
        }

        // Nilai maksimum untuk menentukan tinggi batang grafik.
        $nilaiMaksimum = max(
            1,
            (int) $kampusDitampilkan->max('barang_dipublikasikan_count'),
            (int) $kampusDitampilkan->max('barang_diserahkan_count')
        );

        return view('dashboard.super-admin', compact(
            'totalKampus',
            'totalAdmin',
            'totalBarangDitemukan',
            'totalKlaimDisetujui',
            'kampus',
            'kampusDitampilkan',
            'kampusTerpilih',
            'nilaiMaksimum'
        ));
    }

    public function admin(Request $request)
    {
        $auth = $request->session()->get('auth');

        if (!$auth || $auth['role'] !== 'admin_kampus') {
            abort(403, 'Akses tidak diizinkan.');
        }

        $admin = AdminKampus::with('kampus')
            ->findOrFail($auth['id']);

        $idKampus = $admin->id_kampus;

        $barangDalamAntrean = BarangDitemukan::where('id_kampus', $idKampus)
            ->whereIn('status', [
                'Diterima Satpam',
                'Diterima Admin',
                'Dalam Pemeriksaan',
                'Siap Dipublikasikan',
            ])
            ->count();

        $barangSiapDipublikasikan = BarangDitemukan::where('id_kampus', $idKampus)
            ->where('status', 'Siap Dipublikasikan')
            ->count();

        $klaimMenunggu = Klaim::where('status', 'Menunggu Verifikasi')
            ->whereHas('barangDitemukan', function ($query) use ($idKampus) {
                $query->where('id_kampus', $idKampus);
            })
            ->count();

        $laporanAktif = LaporanKehilangan::where('id_kampus', $idKampus)
            ->whereIn('status', [
                'Diajukan',
                'Dalam Penanganan',
                'Menunggu Informasi',
            ])
            ->count();

        $antreanTerbaru = BarangDitemukan::with([
            'satpam',
            'adminPenerima',
        ])
            ->where('id_kampus', $idKampus)
            ->whereIn('status', [
                'Diterima Satpam',
                'Diterima Admin',
                'Dalam Pemeriksaan',
                'Siap Dipublikasikan',
            ])
            ->orderBy('id_barang', 'desc')
            ->limit(5)
            ->get();

        $klaimPerluTindakan = Klaim::with([
            'barangDitemukan',
            'pelaporKehilangan',
        ])
            ->where('status', 'Menunggu Verifikasi')
            ->whereHas('barangDitemukan', function ($query) use ($idKampus) {
                $query->where('id_kampus', $idKampus);
            })
            ->orderBy('id_klaim', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.admin', compact(
            'admin',
            'barangDalamAntrean',
            'barangSiapDipublikasikan',
            'klaimMenunggu',
            'laporanAktif',
            'antreanTerbaru',
            'klaimPerluTindakan'
        ));
    }

    public function satpam(Request $request)
    {
        $auth = $request->session()->get('auth');

        if (!$auth || $auth['role'] !== 'satpam') {
            abort(403, 'Akses tidak diizinkan.');
        }

        $satpam = Satpam::with('kampus')
            ->findOrFail($auth['id']);

        $idSatpam = $satpam->id_satpam;

        $totalBarang = BarangDitemukan::where('id_satpam', $idSatpam)
            ->where('sumber_penerimaan', 'Satpam')
            ->count();

        $barangMenunggu = BarangDitemukan::where('id_satpam', $idSatpam)
            ->where('sumber_penerimaan', 'Satpam')
            ->whereIn('status', [
                'Diterima Satpam',
                'Diterima Admin',
                'Dalam Pemeriksaan',
                'Siap Dipublikasikan',
            ])
            ->count();

        $barangDipublikasikan = BarangDitemukan::where('id_satpam', $idSatpam)
            ->where('sumber_penerimaan', 'Satpam')
            ->where('status', 'Dipublikasikan')
            ->count();

        $barangDitolak = BarangDitemukan::where('id_satpam', $idSatpam)
            ->where('sumber_penerimaan', 'Satpam')
            ->where('status', 'Ditolak')
            ->count();

        $barangTerbaru = BarangDitemukan::where('id_satpam', $idSatpam)
            ->where('sumber_penerimaan', 'Satpam')
            ->orderBy('id_barang', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.satpam', compact(
            'satpam',
            'totalBarang',
            'barangMenunggu',
            'barangDipublikasikan',
            'barangDitolak',
            'barangTerbaru'
        ));
    }

    public function pelapor(Request $request)
    {
        $auth = $request->session()->get('auth');

        abort_unless(
            $auth && $auth['role'] === 'pelapor',
            403
        );

        $pelapor = PelaporKehilangan::findOrFail($auth['id']);

        $totalLaporan = LaporanKehilangan::where(
            'id_pelapor',
            $pelapor->id_pelapor
        )->count();

        $laporanDiajukan = LaporanKehilangan::where(
            'id_pelapor',
            $pelapor->id_pelapor
        )->where('status', 'Diajukan')->count();

        $totalKlaim = Klaim::where(
            'id_pelapor',
            $pelapor->id_pelapor
        )->count();

        $klaimMenunggu = Klaim::where(
            'id_pelapor',
            $pelapor->id_pelapor
        )->where('status', 'Menunggu Verifikasi')->count();

        $laporanTerbaru = LaporanKehilangan::with('kampus')
            ->where('id_pelapor', $pelapor->id_pelapor)
            ->orderByDesc('id_laporan')
            ->limit(5)
            ->get();

        $klaimTerbaru = Klaim::with([
            'barangDitemukan.kampus',
            'penyerahan',
        ])
            ->where('id_pelapor', $pelapor->id_pelapor)
            ->orderByDesc('id_klaim')
            ->limit(5)
            ->get();

        return view('dashboard.pelapor', compact(
            'pelapor',
            'totalLaporan',
            'laporanDiajukan',
            'totalKlaim',
            'klaimMenunggu',
            'laporanTerbaru',
            'klaimTerbaru'
        ));
    }
}
