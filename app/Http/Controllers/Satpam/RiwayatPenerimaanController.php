<?php

namespace App\Http\Controllers\Satpam;

use App\Http\Controllers\Controller;
use App\Models\BarangDitemukan;
use App\Models\Satpam;
use Illuminate\Http\Request;

class RiwayatPenerimaanController extends Controller
{
    private function satpamLogin(Request $request)
    {
        $auth = $request->session()->get('auth');

        if (!$auth || $auth['role'] !== 'satpam') {
            abort(403, 'Akses tidak diizinkan.');
        }

        return Satpam::findOrFail($auth['id']);
    }

    public function index(Request $request)
    {
        $satpam = $this->satpamLogin($request);

        $validated = $request->validate([
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => [
                'nullable',
                'date',
                'after_or_equal:tanggal_mulai',
            ],
            'status' => [
                'nullable',
                'in:Diterima Satpam,Dipublikasikan,Ditolak,Dalam Proses Penyerahan,Diserahkan',
            ],
        ]);

        $query = BarangDitemukan::with(['kampus', 'foto'])
            ->where('id_satpam', $satpam->id_satpam)
            ->where('sumber_penerimaan', 'Satpam');

        if (!empty($validated['tanggal_mulai'])) {
            $query->whereDate(
                'tanggal_ditemukan',
                '>=',
                $validated['tanggal_mulai']
            );
        }

        if (!empty($validated['tanggal_selesai'])) {
            $query->whereDate(
                'tanggal_ditemukan',
                '<=',
                $validated['tanggal_selesai']
            );
        }

        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        $barangTemuan = $query
            ->orderBy('tanggal_ditemukan', 'desc')
            ->orderBy('id_barang', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view(
            'satpam.riwayat-penerimaan.index',
            compact('barangTemuan')
        );
    }

    public function show(Request $request, $id)
    {
        $satpam = $this->satpamLogin($request);

        $barangTemuan = BarangDitemukan::with(['kampus', 'foto'])
            ->where('id_barang', $id)
            ->where('id_satpam', $satpam->id_satpam)
            ->where('sumber_penerimaan', 'Satpam')
            ->firstOrFail();

        return view(
            'satpam.riwayat-penerimaan.show',
            compact('barangTemuan')
        );
    }
}
