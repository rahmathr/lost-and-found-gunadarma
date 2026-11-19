<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminKampus;
use App\Models\RiwayatAktivitas;
use Illuminate\Http\Request;

class RiwayatPengelolaanController extends Controller
{
    public function index(Request $request)
    {
        $auth = $request->session()->get('auth');

        if (!$auth || ($auth['role'] ?? null) !== 'admin_kampus') {
            abort(403, 'Akses tidak diizinkan.');
        }

        $admin = AdminKampus::findOrFail($auth['id']);

        $validated = $request->validate([
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_akhir' => [
                'nullable',
                'date',
                'after_or_equal:tanggal_mulai',
            ],
            'jenis_tindakan' => ['nullable', 'string', 'max:255'],
        ]);

        // Ambil aktivitas Admin dan Satpam dari kampus yang sama.
        // Aktivitas Super Admin tidak ditampilkan di sini.
        $query = RiwayatAktivitas::with([
            'admin',
            'satpam',
        ])
            ->where(function ($query) use ($admin) {
                $query->whereHas('admin', function ($subQuery) use ($admin) {
                    $subQuery->where('id_kampus', $admin->id_kampus);
                })
                ->orWhereHas('satpam', function ($subQuery) use ($admin) {
                    $subQuery->where('id_kampus', $admin->id_kampus);
                });
            });

        if (!empty($validated['tanggal_mulai'])) {
            $query->whereDate(
                'waktu',
                '>=',
                $validated['tanggal_mulai']
            );
        }

        if (!empty($validated['tanggal_akhir'])) {
            $query->whereDate(
                'waktu',
                '<=',
                $validated['tanggal_akhir']
            );
        }

        if (!empty($validated['jenis_tindakan'])) {
            $query->where(
                'tindakan',
                $validated['jenis_tindakan']
            );
        }

        $aktivitas = $query
            ->orderByDesc('waktu')
            ->orderByDesc('id_aktivitas')
            ->paginate(10)
            ->withQueryString();

        // Pilihan filter diambil dari aktivitas kampus sendiri.
        $jenisTindakan = RiwayatAktivitas::query()
            ->where(function ($query) use ($admin) {
                $query->whereHas('admin', function ($subQuery) use ($admin) {
                    $subQuery->where('id_kampus', $admin->id_kampus);
                })
                ->orWhereHas('satpam', function ($subQuery) use ($admin) {
                    $subQuery->where('id_kampus', $admin->id_kampus);
                });
            })
            ->whereNotNull('tindakan')
            ->distinct()
            ->orderBy('tindakan')
            ->pluck('tindakan');

        return view(
            'admin.riwayat-pengelolaan.index',
            compact('aktivitas', 'jenisTindakan')
        );
    }
}
