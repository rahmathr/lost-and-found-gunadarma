<?php

namespace App\Http\Controllers\Pelapor;

use App\Http\Controllers\Controller;
use App\Models\Kampus;
use App\Models\Klaim;
use App\Models\LaporanKehilangan;
use App\Services\FileStorageService;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Throwable;

class LaporanKehilanganController extends Controller
{
    public function __construct(private FileStorageService $fileStorage)
    {
    }

    private function hapusFilePrivat(string $path): void
    {
        try {
            if (!$this->fileStorage->delete($path, 'private')) {
                report(new \RuntimeException("Gagal menghapus file privat: {$path}"));
            }
        } catch (Throwable $exception) {
            report($exception);
        }
    }

    private function bersihkanFilePrivat(array $paths): void
    {
        foreach ($paths as $path) {
            if (is_string($path) && $path !== '') {
                $this->hapusFilePrivat($path);
            }
        }
    }
    /**
     * Mengambil ID Pelapor yang sedang login.
     */
    private function idPelapor(Request $request)
    {
        $auth = $request->session()->get('auth');

        if (!$auth || $auth['role'] !== 'pelapor') {
            abort(403, 'Akses tidak diizinkan.');
        }

        return $auth['id'];
    }

    /**
     * Mengambil laporan milik Pelapor yang sedang login.
     */
    private function cariLaporan(Request $request, $id)
    {
        return LaporanKehilangan::where('id_laporan', $id)
            ->where('id_pelapor', $this->idPelapor($request))
            ->firstOrFail();
    }

    /**
     * Menampilkan Status Laporan dan Klaim Saya.
     */
    public function index(Request $request)
    {
        $idPelapor = $this->idPelapor($request);

        // Mengambil laporan kehilangan milik Pelapor.
        $laporan = LaporanKehilangan::with('kampus')
            ->where('id_pelapor', $idPelapor)
            ->orderBy('id_laporan', 'desc')
            ->paginate(10, ['*'], 'halaman_laporan')
            ->withQueryString();

        // Mengambil klaim milik Pelapor.
        $klaim = Klaim::with([
            'barangDitemukan',
            'admin',
        ])
            ->where('id_pelapor', $idPelapor)
            ->orderBy('tanggal_klaim', 'desc')
            ->get();

        // Menghitung laporan yang masih aktif dan belum selesai/ditolak.
        $jumlahLaporanAktif = LaporanKehilangan::where(
            'id_pelapor',
            $idPelapor
        )
            ->whereIn('status', ['Diajukan', 'Dalam Penanganan', 'Menunggu Informasi'])
            ->count();

        // Menghitung klaim yang menunggu verifikasi.
        $jumlahKlaimMenunggu = Klaim::where(
            'id_pelapor',
            $idPelapor
        )
            ->where('status', 'Menunggu Verifikasi')
            ->count();

        // Menghitung klaim yang pernah disetujui, termasuk yang sudah diserahkan.
        $jumlahKlaimDisetujui = Klaim::where(
            'id_pelapor',
            $idPelapor
        )
            ->whereIn('status', ['Disetujui', 'Diserahkan'])
            ->count();

        return view(
            'pelapor.laporan-kehilangan.index',
            compact(
                'laporan',
                'klaim',
                'jumlahLaporanAktif',
                'jumlahKlaimMenunggu',
                'jumlahKlaimDisetujui'
            )
        );
    }

    /**
     * Menampilkan form tambah laporan.
     */
    public function create(Request $request)
    {
        $this->idPelapor($request);

        $kampus = Kampus::orderBy('nama_kampus', 'asc')->get();

        return view(
            'pelapor.laporan-kehilangan.create',
            compact('kampus')
        );
    }

    /**
     * Menyimpan laporan kehilangan.
     */
    public function store(Request $request)
    {
        $idPelapor = $this->idPelapor($request);

        $validated = $request->validate([
            'id_kampus' => [
                'required',
                'integer',
                'exists:kampus,id_kampus',
            ],
            'nama_barang' => [
                'required',
                'string',
                'max:150',
            ],
            'deskripsi' => [
                'required',
                'string',
            ],
            'tanggal_hilang' => [
                'required',
                'date',
            ],
            'lokasi_hilang' => [
                'required',
                'string',
                'max:180',
            ],
            'foto' => ['nullable', 'array', 'max:4'],
            'foto.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $uploadedPaths = [];

        try {
            DB::transaction(function () use ($validated, $idPelapor, $request, &$uploadedPaths) {
                $laporan = LaporanKehilangan::create([
                    'id_kampus' => $validated['id_kampus'],
                    'id_pelapor' => $idPelapor,
                    'nama_barang' => $validated['nama_barang'],
                    'deskripsi' => $validated['deskripsi'],
                    'tanggal_hilang' => $validated['tanggal_hilang'],
                    'lokasi_hilang' => $validated['lokasi_hilang'],
                    'status' => 'Diajukan',
                ]);

                $this->simpanFoto($request, $laporan, $uploadedPaths);
            });
        } catch (Throwable $exception) {
            $this->bersihkanFilePrivat($uploadedPaths);
            throw $exception;
        }

        return redirect()
            ->route('pelapor.laporan-kehilangan.index')
            ->with('success', 'Laporan kehilangan berhasil diajukan.');
    }

    /**
     * Menampilkan form edit laporan.
     */
    public function edit(Request $request, $laporan)
    {
        $laporan = $this->cariLaporan($request, $laporan)->load('foto');

        if ($laporan->status !== 'Diajukan') {
            return redirect()
                ->route('pelapor.laporan-kehilangan.index')
                ->with('error', 'Laporan yang sudah diproses tidak dapat diedit.');
        }

        $kampus = Kampus::orderBy('nama_kampus', 'asc')->get();

        return view(
            'pelapor.laporan-kehilangan.edit',
            compact('laporan', 'kampus')
        );
    }

    /**
     * Memperbarui laporan kehilangan.
     */
    public function update(Request $request, $id)
    {
        $laporan = $this->cariLaporan($request, $id);

        if ($laporan->status !== 'Diajukan') {
            return redirect()
                ->route('pelapor.laporan-kehilangan.index')
                ->with('error', 'Laporan yang sudah diproses tidak dapat diedit.');
        }

        $validated = $request->validate([
            'id_kampus' => [
                'required',
                'integer',
                'exists:kampus,id_kampus',
            ],
            'nama_barang' => [
                'required',
                'string',
                'max:150',
            ],
            'deskripsi' => [
                'required',
                'string',
            ],
            'tanggal_hilang' => [
                'required',
                'date',
            ],
            'lokasi_hilang' => [
                'required',
                'string',
                'max:180',
            ],
            'foto' => ['nullable', 'array', 'max:4'],
            'foto.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $jumlahFotoSaatIni = $laporan->foto()->count();
        $jumlahFotoBaru = count($request->file('foto', []));
        if ($jumlahFotoSaatIni + $jumlahFotoBaru > 4) {
            return back()->withInput()->withErrors(['foto' => 'Maksimal 4 foto untuk setiap laporan.']);
        }

        $uploadedPaths = [];

        try {
            DB::transaction(function () use ($laporan, $validated, $request, &$uploadedPaths) {
                $laporan->update([
                    'id_kampus' => $validated['id_kampus'],
                    'nama_barang' => $validated['nama_barang'],
                    'deskripsi' => $validated['deskripsi'],
                    'tanggal_hilang' => $validated['tanggal_hilang'],
                    'lokasi_hilang' => $validated['lokasi_hilang'],
                ]);

                $this->simpanFoto($request, $laporan, $uploadedPaths);
            });
        } catch (Throwable $exception) {
            $this->bersihkanFilePrivat($uploadedPaths);
            throw $exception;
        }

        return redirect()
            ->route('pelapor.laporan-kehilangan.index')
            ->with('success', 'Laporan kehilangan berhasil diperbarui.');
    }

    /** Simpan foto laporan secara privat dan catat path untuk kompensasi jika transaksi gagal. */
    private function simpanFoto(
        Request $request,
        LaporanKehilangan $laporan,
        array &$uploadedPaths
    ): void {
        $urutan = $laporan->foto()->count() + 1;

        foreach ($request->file('foto', []) as $file) {
            $path = $this->fileStorage->store(
                $file,
                'foto-laporan-kehilangan/' . $laporan->id_laporan,
                'private'
            );

            if ($path === false) {
                throw new \RuntimeException('Foto laporan gagal disimpan.');
            }

            $uploadedPaths[] = $path;

            $laporan->foto()->create([
                'path_foto' => $path,
                'urutan' => $urutan++,
            ]);
        }
    }

    /** Hapus satu foto milik laporan sendiri; laporan harus masih berstatus Diajukan. */
    public function hapusFoto(Request $request, $id, $foto)
    {
        $laporan = $this->cariLaporan($request, $id);
        abort_unless($laporan->status === 'Diajukan', 403, 'Laporan yang sudah diproses tidak dapat diubah.');

        $gambar = $laporan->foto()
            ->where('id_foto_laporan', $foto)
            ->firstOrFail();
        $path = $gambar->path_foto;

        DB::transaction(function () use ($gambar) {
            $gambar->delete();
        });

        $this->hapusFilePrivat($path);

        return back()->with('success', 'Foto laporan berhasil dihapus.');
    }

    /** Hanya pemilik laporan yang dapat melihat foto privatnya. */
    public function lihatFoto(Request $request, $id, $foto)
    {
        $laporan = $this->cariLaporan($request, $id);
        $gambar = $laporan->foto()
            ->where('id_foto_laporan', $foto)
            ->firstOrFail();

        abort_unless($this->fileStorage->exists($gambar->path_foto, 'private'), 404);

        return $this->fileStorage->response($gambar->path_foto, 'private');
    }

    /**
     * Menghapus laporan kehilangan.
     */
    public function destroy(Request $request, $id)
    {
        $laporan = $this->cariLaporan($request, $id);

        if ($laporan->status !== 'Diajukan') {
            return redirect()
                ->route('pelapor.laporan-kehilangan.index')
                ->with('error', 'Laporan yang sudah diproses tidak dapat dihapus.');
        }

        try {
            $pathsFoto = $laporan->foto()->pluck('path_foto')->all();
            $berhasilDihapus = DB::transaction(function () use ($laporan) {
                return $laporan->delete();
            });

            if (!$berhasilDihapus) {
                return redirect()
                    ->route('pelapor.laporan-kehilangan.index')
                    ->with('error', 'Laporan tidak dapat dihapus.');
            }

            $this->bersihkanFilePrivat($pathsFoto);

            return redirect()
                ->route('pelapor.laporan-kehilangan.index')
                ->with('success', 'Laporan kehilangan berhasil dihapus.');

        } catch (QueryException $e) {
            return redirect()
                ->route('pelapor.laporan-kehilangan.index')
                ->with(
                    'error',
                    'Laporan tidak dapat dihapus karena sudah memiliki data terkait.'
                );
        }
    }
}
