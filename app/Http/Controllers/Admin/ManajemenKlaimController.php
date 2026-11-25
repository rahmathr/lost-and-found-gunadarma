<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminKampus;
use App\Models\BarangDitemukan;
use App\Models\Klaim;
use App\Services\FileStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManajemenKlaimController extends Controller
{
    public function __construct(private FileStorageService $fileStorage)
    {
    }

    private function adminLogin(Request $request)
    {
        $auth = $request->session()->get('auth');

        if (!$auth || $auth['role'] !== 'admin_kampus') {
            abort(403, 'Akses tidak diizinkan.');
        }

        return AdminKampus::findOrFail($auth['id']);
    }

    private function cariKlaim(Request $request, $id)
    {
        $admin = $this->adminLogin($request);

        return Klaim::with([
            'barangDitemukan.kampus',
            'pelaporKehilangan',
            'admin',
        ])
            ->where('id_klaim', $id)
            ->whereHas('barangDitemukan', function ($query) use ($admin) {
                $query->where('id_kampus', $admin->id_kampus);
            })
            ->firstOrFail();
    }

    public function index(Request $request)
    {
        $admin = $this->adminLogin($request);

        $klaim = Klaim::with([
            'barangDitemukan',
            'pelaporKehilangan',
        ])
            ->whereHas('barangDitemukan', function ($query) use ($admin) {
                $query->where('id_kampus', $admin->id_kampus);
            })
            ->orderByDesc('id_klaim')
            ->paginate(10)
            ->withQueryString();

        return view('admin.manajemen-klaim.index', compact('klaim'));
    }

    public function show(Request $request, $id)
    {
        $klaim = $this->cariKlaim($request, $id);

        return view('admin.manajemen-klaim.show', compact('klaim'));
    }


    /**
     * Mengunduh bukti tambahan secara privat setelah memeriksa kampus admin.
     */
    public function unduhBukti(Request $request, $id)
    {
        $klaim = $this->cariKlaim($request, $id);

        abort_unless($klaim->bukti_tambahan, 404);
        abort_unless($this->fileStorage->exists($klaim->bukti_tambahan, 'private'), 404);

        return $this->fileStorage->download($klaim->bukti_tambahan, 'private');
    }

    /**
     * Menyetujui klaim.
     */
    public function setujui(Request $request, $id)
    {
        $admin = $this->adminLogin($request);

        $validated = $request->validate([
            'catatan_admin' => 'nullable|string|max:2000',
        ]);

        DB::transaction(function () use ($admin, $id, $validated) {

            $klaim = Klaim::where('id_klaim', $id)
                ->lockForUpdate()
                ->firstOrFail();

            $barang = BarangDitemukan::where(
                'id_barang',
                $klaim->id_barang
            )
                ->where('id_kampus', $admin->id_kampus)
                ->lockForUpdate()
                ->firstOrFail();

            if (!in_array($klaim->status, [
                'Menunggu Verifikasi',
                'Perlu Bukti Tambahan',
            ], true)) {
                abort(422, 'Klaim ini sudah diproses sebelumnya.');
            }

            if ($barang->status !== 'Dipublikasikan') {
                abort(422, 'Barang tidak tersedia untuk disetujui.');
            }

            $klaim->update([
                'id_admin' => $admin->id_admin,
                'status' => 'Disetujui',
                'catatan_admin' => $validated['catatan_admin'] ?? null,
            ]);

            $barang->update([
                'status' => 'Dalam Proses Penyerahan',
            ]);

            // Tolak klaim lain yang masih menunggu untuk barang yang sama.
            Klaim::where('id_barang', $barang->id_barang)
                ->where('id_klaim', '!=', $klaim->id_klaim)
                ->whereIn('status', [
                    'Menunggu Verifikasi',
                    'Perlu Bukti Tambahan',
                ])
                ->update([
                    'id_admin' => $admin->id_admin,
                    'status' => 'Ditolak',
                    'catatan_admin' => 'Barang telah disetujui untuk klaim lain dan sedang dalam proses penyerahan.',
                ]);
        });

        return redirect()
            ->route('admin.manajemen-klaim.index')
            ->with('success', 'Klaim berhasil disetujui.');
    }

    /**
     * Meminta bukti tambahan dari Pelapor.
     */
    public function mintaBukti(Request $request, $id)
    {
        $admin = $this->adminLogin($request);

        $validated = $request->validate([
            'catatan_admin' => 'required|string|min:5|max:2000',
        ], [
            'catatan_admin.required' => 'Jelaskan bukti tambahan yang diperlukan.',
            'catatan_admin.min' => 'Catatan minimal 5 karakter.',
        ]);

        $klaim = $this->cariKlaim($request, $id);

        if (!in_array($klaim->status, [
            'Menunggu Verifikasi',
            'Perlu Bukti Tambahan',
        ], true)) {
            return back()->with(
                'error',
                'Klaim ini sudah diproses dan tidak dapat diminta bukti tambahan.'
            );
        }

        $klaim->update([
            'id_admin' => $admin->id_admin,
            'status' => 'Perlu Bukti Tambahan',
            'catatan_admin' => $validated['catatan_admin'],
        ]);

        return redirect()
            ->route('admin.manajemen-klaim.show', $klaim->id_klaim)
            ->with('success', 'Permintaan bukti tambahan berhasil disimpan.');
    }

    /**
     * Menolak klaim.
     */
    public function tolak(Request $request, $id)
    {
        $admin = $this->adminLogin($request);

        $validated = $request->validate([
            'catatan_admin' => 'required|string|min:5|max:2000',
        ], [
            'catatan_admin.required' => 'Alasan penolakan wajib diisi.',
            'catatan_admin.min' => 'Alasan penolakan minimal 5 karakter.',
        ]);

        $klaim = $this->cariKlaim($request, $id);

        if (!in_array($klaim->status, [
            'Menunggu Verifikasi',
            'Perlu Bukti Tambahan',
        ], true)) {
            return back()->with('error', 'Klaim ini sudah diproses sebelumnya.');
        }

        $klaim->update([
            'id_admin' => $admin->id_admin,
            'status' => 'Ditolak',
            'catatan_admin' => $validated['catatan_admin'],
        ]);

        return redirect()
            ->route('admin.manajemen-klaim.index')
            ->with('success', 'Klaim berhasil ditolak.');
    }
}
