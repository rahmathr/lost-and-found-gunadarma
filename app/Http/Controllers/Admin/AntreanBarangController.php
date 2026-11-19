<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminKampus;
use App\Models\BarangDitemukan;
use Illuminate\Http\Request;

class AntreanBarangController extends Controller
{
    private function adminLogin(Request $request)
    {
        $auth = $request->session()->get('auth');

        if (!$auth || $auth['role'] !== 'admin_kampus') {
            abort(403, 'Akses tidak diizinkan.');
        }

        return AdminKampus::findOrFail($auth['id']);
    }

    public function index(Request $request)
    {
        $admin = $this->adminLogin($request);

        $query = BarangDitemukan::with([
            'kampus',
            'satpam',
            'adminPenerima',
            'adminValidator',
        ])->where('id_kampus', $admin->id_kampus);

        // Pencarian nama barang
        if ($request->filled('cari')) {
            $query->where(
                'nama_publik',
                'like',
                '%' . $request->cari . '%'
            );
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter sumber penerimaan
        if ($request->filled('sumber')) {
            $query->where('sumber_penerimaan', $request->sumber);
        }

        $barang = $query
            ->orderBy('id_barang', 'desc')
            ->paginate(10)
            ->withQueryString();

        $jumlahSemua = BarangDitemukan::where(
            'id_kampus',
            $admin->id_kampus
        )->count();

        $jumlahMenunggu = BarangDitemukan::where(
            'id_kampus',
            $admin->id_kampus
        )->where('status', 'Diterima Satpam')->count();

        $jumlahDipublikasikan = BarangDitemukan::where(
            'id_kampus',
            $admin->id_kampus
        )->where('status', 'Dipublikasikan')->count();

        $jumlahDiserahkan = BarangDitemukan::where(
            'id_kampus',
            $admin->id_kampus
        )->where('status', 'Diserahkan')->count();

        return view('admin.antrean-barang.index', compact(
            'barang',
            'jumlahSemua',
            'jumlahMenunggu',
            'jumlahDipublikasikan',
            'jumlahDiserahkan'
        ));
    }
}
