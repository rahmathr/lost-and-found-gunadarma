<?php

namespace App\Http\Controllers\Pelapor;

use App\Http\Controllers\Controller;
use App\Models\Kampus;
use App\Models\Klaim;
use App\Models\LaporanKehilangan;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class LaporanKehilanganController extends Controller
{
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

        $laporan = LaporanKehilangan::create([
            'id_kampus' => $validated['id_kampus'],
            'id_pelapor' => $idPelapor,
            'nama_barang' => $validated['nama_barang'],
            'deskripsi' => $validated['deskripsi'],
            'tanggal_hilang' => $validated['tanggal_hilang'],
            'lokasi_hilang' => $validated['lokasi_hilang'],
            'status' => 'Diajukan',
        ]);

        $this->simpanFoto($request, $laporan);

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

        $laporan->update([
            'id_kampus' => $validated['id_kampus'],
            'nama_barang' => $validated['nama_barang'],
            'deskripsi' => $validated['deskripsi'],
            'tanggal_hilang' => $validated['tanggal_hilang'],
            'lokasi_hilang' => $validated['lokasi_hilang'],
        ]);

        $this->simpanFoto($request, $laporan);

        return redirect()
            ->route('pelapor.laporan-kehilangan.index')
            ->with('success', 'Laporan kehilangan berhasil diperbarui.');
    }

    /** Simpan foto laporan pada disk privat (bukan public/storage). */
    private function simpanFoto(Request $request, LaporanKehilangan $laporan): void
    {
        $urutan = $laporan->foto()->count() + 1;
        foreach ($request->file('foto', []) as $file) {
            $path = $file->store('foto-laporan-kehilangan/' . $laporan->id_laporan, 'local');
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
        $gambar = $laporan->foto()->where('id_foto_laporan', $foto)->firstOrFail();
        $path = $gambar->path_foto;
        $gambar->delete();
        Storage::disk('local')->delete($path);

        return back()->with('success', 'Foto laporan berhasil dihapus.');
    }

    /** Hanya pemilik laporan yang dapat melihat foto privatnya. */
    public function lihatFoto(Request $request, $id, $foto)
    {
        $laporan = $this->cariLaporan($request, $id);
        $gambar = $laporan->foto()->where('id_foto_laporan', $foto)->firstOrFail();
        abort_unless(Storage::disk('local')->exists($gambar->path_foto), 404);

        return Storage::disk('local')->response($gambar->path_foto);
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
            $laporan->delete();
            Storage::disk('local')->delete($pathsFoto);

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
