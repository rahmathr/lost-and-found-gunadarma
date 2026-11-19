<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminKampus;
use App\Models\LaporanKehilangan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class LaporanAdminController extends Controller
{
    private function adminLogin(Request $request)
    {
        $auth = $request->session()->get('auth');

        abort_unless(
            $auth && $auth['role'] === 'admin_kampus',
            403
        );

        return AdminKampus::findOrFail($auth['id']);
    }

    private function laporanKampus(Request $request, $id)
    {
        $admin = $this->adminLogin($request);

        return LaporanKehilangan::with([
            'kampus',
            'pelapor',
            'foto',
        ])
            ->where('id_laporan', $id)
            ->where('id_kampus', $admin->id_kampus)
            ->firstOrFail();
    }

    public function index(Request $request)
    {
        $admin = $this->adminLogin($request);

        $query = LaporanKehilangan::with('pelapor')
            ->where('id_kampus', $admin->id_kampus);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                    ->orWhereHas('pelapor', function ($pelapor) use ($search) {
                        $pelapor->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $laporan = $query
            ->orderByDesc('id_laporan')
            ->paginate(10)
            ->withQueryString();

        $daftarStatus = [
            'Diajukan',
            'Dalam Penanganan',
            'Menunggu Informasi',
            'Selesai',
            'Ditolak',
        ];

        return view('admin.laporan-kehilangan.index', compact(
            'laporan',
            'daftarStatus'
        ));
    }

    public function show(Request $request, $id)
    {
        $laporan = $this->laporanKampus($request, $id);

        $daftarStatus = [
            'Diajukan',
            'Dalam Penanganan',
            'Menunggu Informasi',
            'Selesai',
            'Ditolak',
        ];

        return view('admin.laporan-kehilangan.show', compact(
            'laporan',
            'daftarStatus'
        ));
    }

    /** Foto laporan hanya dapat diakses Admin Kampus dari kampus laporan tersebut. */
    public function lihatFoto(Request $request, $id, $foto)
    {
        $laporan = $this->laporanKampus($request, $id);
        $gambar = $laporan->foto()->where('id_foto_laporan', $foto)->firstOrFail();
        abort_unless(Storage::disk('local')->exists($gambar->path_foto), 404);

        return Storage::disk('local')->response($gambar->path_foto);
    }

    public function update(Request $request, $id)
    {
        $laporan = $this->laporanKampus($request, $id);

        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'Diajukan',
                    'Dalam Penanganan',
                    'Menunggu Informasi',
                    'Selesai',
                    'Ditolak',
                ]),
            ],
            'catatan_admin' => 'nullable|string|max:2000',
        ]);

        $laporan->status = $validated['status'];
        $laporan->catatan_admin = $validated['catatan_admin'] ?? null;
        $laporan->save();

        return redirect()
            ->route('admin.laporan-kehilangan.show', $laporan->id_laporan)
            ->with('success', 'Laporan kehilangan berhasil diperbarui.');
    }
}
