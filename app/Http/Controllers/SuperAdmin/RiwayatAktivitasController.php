<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatAktivitas;
use Illuminate\Http\Request;

class RiwayatAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $auth = $request->session()->get('auth');

        if (!$auth || ($auth['role'] ?? null) !== 'super_admin') {
            abort(403, 'Akses tidak diizinkan.');
        }

        $validated = $request->validate([
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_akhir' => [
                'nullable',
                'date',
                'after_or_equal:tanggal_mulai',
            ],
            'jenis_tindakan' => ['nullable', 'string', 'max:255'],
        ]);

        $query = RiwayatAktivitas::with([
            'superAdmin',
            'admin',
            'satpam',
        ]);

        if (!empty($validated['tanggal_mulai'])) {
            $query->whereDate('waktu', '>=', $validated['tanggal_mulai']);
        }

        if (!empty($validated['tanggal_akhir'])) {
            $query->whereDate('waktu', '<=', $validated['tanggal_akhir']);
        }

        if (!empty($validated['jenis_tindakan'])) {
            $query->where('tindakan', $validated['jenis_tindakan']);
        }

        $aktivitas = $query
            ->orderByDesc('waktu')
            ->orderByDesc('id_aktivitas')
            ->paginate(15)
            ->withQueryString();

        $jenisTindakan = RiwayatAktivitas::query()
            ->whereNotNull('tindakan')
            ->distinct()
            ->orderBy('tindakan')
            ->pluck('tindakan');

        return view(
            'super-admin.riwayat-aktivitas.index',
            compact('aktivitas', 'jenisTindakan')
        );
    }
}
