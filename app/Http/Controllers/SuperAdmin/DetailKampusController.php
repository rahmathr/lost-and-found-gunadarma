<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\BarangDitemukan;
use App\Models\Kampus;
use App\Models\Klaim;
use App\Models\LaporanKehilangan;

class DetailKampusController extends Controller
{
    public function show(int $kampus)
    {
        $dataKampus = Kampus::with(['adminKampus', 'satpam'])
            ->findOrFail($kampus);

        $idKampus = $dataKampus->id_kampus;

        $barangDitemukan = BarangDitemukan::where('id_kampus', $idKampus);

        $statistik = [
            'total_barang' => (clone $barangDitemukan)->count(),
            'barang_dipublikasikan' => (clone $barangDitemukan)
                ->whereIn('status', [
                    'Dipublikasikan',
                    'Tervalidasi',
                    'Dalam Proses Penyerahan',
                    'Diserahkan',
                ])->count(),
            'barang_dalam_proses' => (clone $barangDitemukan)
                ->whereIn('status', [
                    'Diterima Satpam',
                    'Diterima Admin',
                    'Menunggu Validasi',
                    'Dalam Pemeriksaan',
                    'Siap Dipublikasikan',
                ])->count(),
            'barang_diserahkan' => (clone $barangDitemukan)
                ->where('status', 'Diserahkan')->count(),
            'laporan_aktif' => LaporanKehilangan::where('id_kampus', $idKampus)
                ->whereIn('status', [
                    'Diajukan',
                    'Dalam Penanganan',
                    'Menunggu Informasi',
                ])->count(),
            'klaim_menunggu' => Klaim::where('status', 'Menunggu Verifikasi')
                ->whereHas('barangDitemukan', function ($query) use ($idKampus) {
                    $query->where('id_kampus', $idKampus);
                })->count(),
            'klaim_disetujui' => Klaim::where('status', 'Disetujui')
                ->whereHas('barangDitemukan', function ($query) use ($idKampus) {
                    $query->where('id_kampus', $idKampus);
                })->count(),
        ];

        $barangTerbaru = BarangDitemukan::where('id_kampus', $idKampus)
            ->orderByDesc('id_barang')
            ->limit(8)
            ->get([
                'id_barang',
                'nama_publik',
                'kategori',
                'tanggal_ditemukan',
                'lokasi_ditemukan',
                'sumber_penerimaan',
                'status',
            ]);

        $laporanTerbaru = LaporanKehilangan::where('id_kampus', $idKampus)
            ->orderByDesc('id_laporan')
            ->limit(8)
            ->get([
                'id_laporan',
                'nama_barang',
                'tanggal_hilang',
                'lokasi_hilang',
                'status',
            ]);

        return view('super-admin.kampus.detail', compact(
            'dataKampus',
            'statistik',
            'barangTerbaru',
            'laporanTerbaru'
        ));
    }
}
