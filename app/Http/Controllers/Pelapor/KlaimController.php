<?php

namespace App\Http\Controllers\Pelapor;

use App\Http\Controllers\Controller;
use App\Models\BarangDitemukan;
use App\Models\Klaim;
use App\Services\FileStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Throwable;

class KlaimController extends Controller
{
    public function __construct(private FileStorageService $fileStorage)
    {
    }

    private function idPelapor(Request $request)
    {
        $auth = $request->session()->get('auth');

        if (!$auth || $auth['role'] !== 'pelapor') {
            abort(403, 'Akses tidak diizinkan.');
        }

        return (int) $auth['id'];
    }

    /**
     * Daftar barang yang tersedia untuk diklaim.
     */
    public function index(Request $request)
    {
        $this->idPelapor($request);

        $barangTemuan = BarangDitemukan::with('kampus')
            ->where('status', 'Dipublikasikan')
            ->orderBy('id_barang', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('pelapor.klaim.index', compact('barangTemuan'));
    }

    /**
     * Detail barang sekaligus halaman pengajuan klaim.
     */
    public function show(Request $request, $id)
    {
        $idPelapor = $this->idPelapor($request);

        $barangTemuan = BarangDitemukan::with(['kampus', 'foto'])
            ->where('id_barang', $id)
            ->where('status', 'Dipublikasikan')
            ->firstOrFail();

        $klaim = Klaim::where('id_barang', $barangTemuan->id_barang)
            ->where('id_pelapor', $idPelapor)
            ->first();

        $sudahMengklaim = $klaim !== null;

        return view(
            'pelapor.klaim.show',
            compact('barangTemuan', 'sudahMengklaim', 'klaim')
        );
    }

    /**
     * Menyimpan pengajuan klaim.
     */
    public function store(Request $request, $id)
    {
        $idPelapor = $this->idPelapor($request);

        $validated = $request->validate([
            'keterangan_privat' => [
                'required',
                'string',
                'min:10',
            ],
            'persetujuan' => [
                'required',
                'accepted',
            ],
        ], [
            'keterangan_privat.required' => 'Keterangan kepemilikan wajib diisi.',
            'keterangan_privat.min' => 'Keterangan minimal 10 karakter.',
            'persetujuan.required' => 'Pernyataan kepemilikan wajib disetujui.',
            'persetujuan.accepted' => 'Kamu harus menyetujui pernyataan kepemilikan.',
        ]);

        $barangTemuan = BarangDitemukan::where('id_barang', $id)
            ->where('status', 'Dipublikasikan')
            ->firstOrFail();

        $sudahMengklaim = Klaim::where('id_barang', $barangTemuan->id_barang)
            ->where('id_pelapor', $idPelapor)
            ->exists();

        if ($sudahMengklaim) {
            return redirect()
                ->route('pelapor.klaim.show', $barangTemuan->id_barang)
                ->with('error', 'Kamu sudah pernah mengajukan klaim untuk barang ini.');
        }

        Klaim::create([
            'id_barang' => $barangTemuan->id_barang,
            'id_pelapor' => $idPelapor,
            'id_admin' => null,
            'keterangan_privat' => $validated['keterangan_privat'],
            'status' => 'Menunggu Verifikasi',
            'catatan_admin' => null,
        ]);

        return redirect()
            ->route('pelapor.klaim.riwayat')
            ->with(
                'success',
                'Klaim berhasil diajukan. Silakan tunggu verifikasi Admin Kampus.'
            );
    }

    /**
     * Menyimpan bukti tambahan yang diminta Admin.
     * File disimpan secara privat.
     */
    public function uploadBukti(Request $request, $id)
    {
        $idPelapor = $this->idPelapor($request);

        $validated = $request->validate([
            'bukti_tambahan' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],
        ], [
            'bukti_tambahan.required' => 'Pilih file bukti tambahan terlebih dahulu.',
            'bukti_tambahan.mimes' => 'Bukti harus berupa JPG, PNG, atau PDF.',
            'bukti_tambahan.max' => 'Ukuran file maksimal 5 MB.',
        ]);

        $klaim = Klaim::where('id_klaim', $id)
            ->where('id_pelapor', $idPelapor)
            ->firstOrFail();

        if ($klaim->status !== 'Perlu Bukti Tambahan') {
            return back()->with(
                'error',
                'Klaim ini tidak sedang menunggu bukti tambahan.'
            );
        }

        // Simpan file baru ke penyimpanan privat.
        $pathBaru = $this->fileStorage->store(
            $validated['bukti_tambahan'],
            'bukti-klaim',
            'private'
        );

        if ($pathBaru === false) {
            return back()->with(
                'error',
                'File gagal disimpan. Silakan coba kembali.'
            );
        }

        try {
            $hasil = DB::transaction(function () use (
                $id,
                $idPelapor,
                $pathBaru
            ) {
                // Kunci baris klaim agar tidak diperbarui bersamaan.
                $klaimTerkunci = Klaim::where('id_klaim', $id)
                    ->where('id_pelapor', $idPelapor)
                    ->lockForUpdate()
                    ->firstOrFail();

                // Periksa kembali status setelah mendapatkan kunci.
                if ($klaimTerkunci->status !== 'Perlu Bukti Tambahan') {
                    return [
                        'berhasil' => false,
                        'path_lama' => null,
                        'id_barang' => $klaimTerkunci->id_barang,
                    ];
                }

                $pathLama = $klaimTerkunci->bukti_tambahan;

                $berhasilUpdate = $klaimTerkunci->update([
                    'bukti_tambahan' => $pathBaru,
                    'status' => 'Menunggu Verifikasi',
                ]);

                if (!$berhasilUpdate) {
                    throw new RuntimeException(
                        'Database gagal memperbarui bukti tambahan klaim.'
                    );
                }

                return [
                    'berhasil' => true,
                    'path_lama' => $pathLama,
                    'id_barang' => $klaimTerkunci->id_barang,
                ];
            });
        } catch (Throwable $exception) {
            // Bersihkan file baru jika transaksi database gagal.
            try {
                $this->fileStorage->delete($pathBaru, 'private');
            } catch (Throwable $cleanupException) {
                report($cleanupException);
            }

            throw $exception;
        }

        // Status klaim mungkin berubah sebelum transaksi mendapatkan kunci.
        if (!$hasil['berhasil']) {
            try {
                $this->fileStorage->delete($pathBaru, 'private');
            } catch (Throwable $cleanupException) {
                report($cleanupException);
            }

            return back()->with(
                'error',
                'Klaim ini tidak sedang menunggu bukti tambahan.'
            );
        }

        // Hapus bukti lama hanya setelah database berhasil diperbarui.
        if ($hasil['path_lama']) {
            try {
                $berhasilHapus = $this->fileStorage->delete(
                    $hasil['path_lama'],
                    'private'
                );

                if (!$berhasilHapus) {
                    report(new RuntimeException(
                        "Gagal menghapus bukti klaim lama: {$hasil['path_lama']}"
                    ));
                }
            } catch (Throwable $exception) {
                report($exception);
            }
        }

        return redirect()
            ->route('pelapor.klaim.show', $hasil['id_barang'])
            ->with(
                'success',
                'Bukti tambahan berhasil dikirim. Klaim menunggu pemeriksaan Admin Kampus.'
            );
    }

    /**
     * Menampilkan detail satu klaim milik Pelapor yang sedang login.
     */
    public function detailRiwayat(Request $request, $id)
    {
        $idPelapor = $this->idPelapor($request);

        $item = Klaim::with([
            'barangDitemukan.kampus',
            'admin',
            'penyerahan.admin',
        ])
            ->where('id_klaim', $id)
            ->where('id_pelapor', $idPelapor)
            ->firstOrFail();

        return view('pelapor.klaim.detail', compact('item'));
    }

    /**
     * Riwayat klaim milik Pelapor yang sedang login.
     */
    public function riwayat(Request $request)
    {
        $idPelapor = $this->idPelapor($request);

        $klaim = Klaim::with([
            'barangDitemukan.kampus',
            'admin',
            'penyerahan',
        ])
            ->where('id_pelapor', $idPelapor)
            ->orderBy('id_klaim', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('pelapor.klaim.riwayat', compact('klaim'));
    }
}
