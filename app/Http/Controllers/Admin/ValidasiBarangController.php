<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminKampus;
use App\Models\BarangDitemukan;
use Illuminate\Http\Request;

class ValidasiBarangController extends Controller
{
    private function adminLogin(Request $request)
    {
        $auth = $request->session()->get('auth');

        if (!$auth || $auth['role'] !== 'admin_kampus') {
            abort(403, 'Akses tidak diizinkan.');
        }

        return AdminKampus::findOrFail($auth['id']);
    }

    private function cariBarang(Request $request, $id)
    {
        $admin = $this->adminLogin($request);

        return BarangDitemukan::with([
            'satpam',
            'adminPenerima',
            'kampus',
            'foto'
        ])
            ->where('id_barang', $id)
            ->where('id_kampus', $admin->id_kampus)
            ->firstOrFail();
    }

    // Menampilkan antrean barang dengan fitur pencarian dan filter.
    public function index(Request $request)
    {
        $admin = $this->adminLogin($request);

        $statusPilihan = [
            'Diterima Satpam',
            'Diterima Admin',
            'Dalam Pemeriksaan',
            'Siap Dipublikasikan',
            'Dipublikasikan',
            'Dalam Proses Penyerahan',
            'Diserahkan',
            'Ditolak',
        ];

        $query = BarangDitemukan::with([
            'satpam',
            'adminPenerima',
            'foto'
        ])
            ->where('id_kampus', $admin->id_kampus);

        // Filter nama barang.
        if ($request->filled('cari')) {
            $query->where(
                'nama_publik',
                'like',
                '%' . $request->cari . '%'
            );
        }

        // Filter status.
        if (
            $request->filled('status') &&
            in_array($request->status, $statusPilihan, true)
        ) {
            $query->where('status', $request->status);
        }

        // Filter sumber penerimaan.
        if (
            $request->filled('sumber') &&
            in_array($request->sumber, ['Satpam', 'Langsung'], true)
        ) {
            $query->where('sumber_penerimaan', $request->sumber);
        }

        $barangTemuan = $query
            ->orderBy('id_barang', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.validasi-barang.index',
            compact('barangTemuan', 'statusPilihan')
        );
    }

    // Menampilkan detail barang.
    public function show(Request $request, $id)
    {
        $barangTemuan = $this->cariBarang($request, $id);

        return view(
            'admin.validasi-barang.show',
            compact('barangTemuan')
        );
    }

    // Memulai pemeriksaan barang.
    public function mulaiPemeriksaan(Request $request, $id)
    {
        $barangTemuan = $this->cariBarang($request, $id);

        if (!in_array($barangTemuan->status, ['Diterima Satpam', 'Diterima Admin'], true)) {
            return back()->with(
                'error',
                'Barang tidak dapat diproses dari status saat ini.'
            );
        }

        $barangTemuan->update([
            'id_admin_validator' => $request->session()->get('auth.id'),
            'status' => 'Dalam Pemeriksaan',
        ]);

        return redirect()
            ->route('admin.validasi-barang.index')
            ->with('success', 'Barang masuk ke tahap pemeriksaan.');
    }

    // Menandai barang siap dipublikasikan.
    public function siapDipublikasikan(Request $request, $id)
    {
        $barangTemuan = $this->cariBarang($request, $id);

        if ($barangTemuan->status !== 'Dalam Pemeriksaan') {
            return back()->with(
                'error',
                'Barang harus berada dalam pemeriksaan terlebih dahulu.'
            );
        }

        $barangTemuan->update([
            'id_admin_validator' => $request->session()->get('auth.id'),
            'status' => 'Siap Dipublikasikan',
        ]);

        return redirect()
            ->route('admin.validasi-barang.index')
            ->with('success', 'Barang siap dipublikasikan.');
    }

    // Mempublikasikan barang.
    public function publikasikan(Request $request, $id)
    {
        $barangTemuan = $this->cariBarang($request, $id);

        if ($barangTemuan->status !== 'Siap Dipublikasikan') {
            return back()->with(
                'error',
                'Barang harus berstatus Siap Dipublikasikan.'
            );
        }

        $barangTemuan->update([
            'id_admin_validator' => $request->session()->get('auth.id'),
            'status' => 'Dipublikasikan',
        ]);

        return redirect()
            ->route('admin.validasi-barang.index')
            ->with('success', 'Barang berhasil dipublikasikan.');
    }

    // Menolak barang.
    public function tolak(Request $request, $id)
    {
        $barangTemuan = $this->cariBarang($request, $id);

        if (!in_array($barangTemuan->status, [
            'Diterima Satpam',
            'Dalam Pemeriksaan',
            'Siap Dipublikasikan'
        ], true)) {
            return back()->with(
                'error',
                'Barang tidak dapat ditolak dari status saat ini.'
            );
        }

        $barangTemuan->update([
            'id_admin_validator' => $request->session()->get('auth.id'),
            'status' => 'Ditolak',
        ]);

        return redirect()
            ->route('admin.validasi-barang.index')
            ->with('success', 'Barang berhasil ditolak.');
    }

    // Kompatibilitas dengan route validasi lama.
    public function validasi(Request $request, $id)
    {
        $barangTemuan = $this->cariBarang($request, $id);

        if (!in_array($barangTemuan->status, [
            'Diterima Satpam',
            'Dalam Pemeriksaan',
            'Siap Dipublikasikan'
        ], true)) {
            return back()->with(
                'error',
                'Barang tidak dapat divalidasi dari status saat ini.'
            );
        }

        $barangTemuan->update([
            'id_admin_validator' => $request->session()->get('auth.id'),
            'status' => 'Dipublikasikan',
        ]);

        return redirect()
            ->route('admin.validasi-barang.index')
            ->with('success', 'Barang berhasil dipublikasikan.');
    }
}
