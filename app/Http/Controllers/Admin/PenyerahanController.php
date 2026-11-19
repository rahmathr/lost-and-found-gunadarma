<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminKampus;
use App\Models\BarangDitemukan;
use App\Models\Klaim;
use App\Models\Penyerahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenyerahanController extends Controller
{
    /**
     * Mengambil Admin Kampus yang sedang login.
     */
    private function adminLogin(Request $request)
    {
        $auth = $request->session()->get('auth');

        if (!$auth || ($auth['role'] ?? null) !== 'admin_kampus') {
            abort(403, 'Akses tidak diizinkan.');
        }

        return AdminKampus::findOrFail($auth['id']);
    }

    /**
     * Mengambil klaim milik kampus Admin.
     */
    private function cariKlaim(Request $request, $id)
    {
        $admin = $this->adminLogin($request);

        return Klaim::with([
            'barangDitemukan.kampus',
            'pelaporKehilangan',
            'penyerahan',
        ])
            ->where('id_klaim', $id)
            ->where('status', 'Disetujui')
            ->whereHas('barangDitemukan', function ($query) use ($admin) {
                $query->where('id_kampus', $admin->id_kampus)
                    ->where('status', 'Dalam Proses Penyerahan');
            })
            ->firstOrFail();
    }

    /**
     * Menampilkan daftar klaim dan form penyerahan.
     */
    public function index(Request $request)
    {
        $admin = $this->adminLogin($request);

        $klaim = Klaim::with([
            'barangDitemukan',
            'pelaporKehilangan',
        ])
            ->where('status', 'Disetujui')
            ->whereHas('barangDitemukan', function ($query) use ($admin) {
                $query->where('id_kampus', $admin->id_kampus)
                    ->where('status', 'Dalam Proses Penyerahan');
            })
            ->whereDoesntHave('penyerahan')
            ->orderByDesc('id_klaim')
            ->paginate(10)
            ->withQueryString();

        $klaimTerpilih = null;

        if ($request->filled('klaim')) {
            $klaimTerpilih = $klaim->getCollection()->firstWhere(
                'id_klaim',
                $request->query('klaim')
            );

            // Jika klaim tidak ada di halaman pagination saat ini,
            // cari kembali dengan pembatasan kampus yang sama.
            if (!$klaimTerpilih) {
                $klaimTerpilih = Klaim::with([
                    'barangDitemukan',
                    'pelaporKehilangan',
                    'penyerahan',
                ])
                    ->where('id_klaim', $request->query('klaim'))
                    ->where('status', 'Disetujui')
                    ->whereDoesntHave('penyerahan')
                    ->whereHas('barangDitemukan', function ($query) use ($admin) {
                        $query->where('id_kampus', $admin->id_kampus)
                            ->where('status', 'Dalam Proses Penyerahan');
                    })
                    ->first();
            }
        }

        return view('admin.penyerahan.index', compact(
            'klaim',
            'klaimTerpilih'
        ));
    }

    /**
     * Menampilkan detail klaim.
     * Dipertahankan untuk kompatibilitas dengan route lama.
     */
    public function show(Request $request, $id)
    {
        $klaim = $this->cariKlaim($request, $id);

        if ($klaim->penyerahan) {
            return redirect()
                ->route('admin.penyerahan.riwayat')
                ->with('error', 'Barang untuk klaim ini sudah diserahkan.');
        }

        return view('admin.penyerahan.show', compact('klaim'));
    }

    /**
     * Mencatat penyerahan barang.
     */
    public function store(Request $request, $id)
    {
        $admin = $this->adminLogin($request);

        $validated = $request->validate([
            'tanggal_penyerahan' => [
                'required',
                'date',
            ],
            'catatan' => [
                'nullable',
                'string',
                'max:2000',
            ],
            'konfirmasi_identitas' => [
                'required',
                'accepted',
            ],
        ], [
            'tanggal_penyerahan.required' => 'Tanggal dan waktu penyerahan wajib diisi.',
            'tanggal_penyerahan.date' => 'Format tanggal dan waktu tidak valid.',
            'catatan.max' => 'Catatan maksimal 2000 karakter.',
            'konfirmasi_identitas.required' => 'Konfirmasi identitas penerima wajib dicentang.',
            'konfirmasi_identitas.accepted' => 'Identitas penerima harus dikonfirmasi terlebih dahulu.',
        ]);

        DB::transaction(function () use ($admin, $id, $validated) {

            $klaim = Klaim::where('id_klaim', $id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($klaim->status !== 'Disetujui') {
                abort(422, 'Klaim belum disetujui atau sudah diproses.');
            }

            $barang = BarangDitemukan::where(
                'id_barang',
                $klaim->id_barang
            )
                ->where('id_kampus', $admin->id_kampus)
                ->lockForUpdate()
                ->firstOrFail();

            if ($barang->status !== 'Dalam Proses Penyerahan') {
                abort(422, 'Barang tidak berada dalam proses penyerahan.');
            }

            $sudahDiserahkan = Penyerahan::where(
                'id_klaim',
                $klaim->id_klaim
            )->exists();

            if ($sudahDiserahkan) {
                abort(422, 'Penyerahan untuk klaim ini sudah tercatat.');
            }

            Penyerahan::create([
                'id_klaim' => $klaim->id_klaim,
                'id_admin' => $admin->id_admin,
                'tanggal_penyerahan' => $validated['tanggal_penyerahan'],
                'catatan' => $validated['catatan'] ?? null,
            ]);

            $barang->update([
                'status' => 'Diserahkan',
            ]);
        });

        return redirect()
            ->route('admin.penyerahan.index')
            ->with('success', 'Penyerahan barang berhasil dicatat.');
    }

    /**
     * Menampilkan riwayat penyerahan barang.
     */
    public function riwayat(Request $request)
    {
        $admin = $this->adminLogin($request);

        $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
        ]);

        $query = Penyerahan::with([
            'klaim.barangDitemukan',
            'klaim.pelaporKehilangan',
            'admin',
        ])
            ->where('id_admin', $admin->id_admin)
            ->whereHas('klaim.barangDitemukan', function ($query) use ($admin) {
                $query->where('id_kampus', $admin->id_kampus);
            });

        if ($request->filled('q')) {
            $kataKunci = trim($request->query('q'));
            $query->whereHas('klaim', function ($klaimQuery) use ($kataKunci) {
                $klaimQuery->whereHas('barangDitemukan', function ($barangQuery) use ($kataKunci) {
                    $barangQuery->where('nama_publik', 'like', '%' . $kataKunci . '%');
                })->orWhereHas('pelaporKehilangan', function ($pelaporQuery) use ($kataKunci) {
                    $pelaporQuery->where('nama', 'like', '%' . $kataKunci . '%');
                });
            });
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_penyerahan', '>=', $request->query('tanggal_mulai'));
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_penyerahan', '<=', $request->query('tanggal_selesai'));
        }

        $penyerahan = $query->orderByDesc('id_penyerahan')
            ->paginate(10)
            ->withQueryString();

        return view('admin.penyerahan.riwayat', compact('penyerahan'));
    }
}
