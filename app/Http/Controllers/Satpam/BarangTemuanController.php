<?php

namespace App\Http\Controllers\Satpam;

use App\Http\Controllers\Controller;
use App\Models\BarangDitemukan;
use App\Models\Satpam;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class BarangTemuanController extends Controller
{
    /**
     * Mengambil akun Satpam yang sedang login.
     */
    private function satpamLogin(Request $request)
    {
        $auth = $request->session()->get('auth');

        if (!$auth || $auth['role'] !== 'satpam') {
            abort(403, 'Akses tidak diizinkan.');
        }

        return Satpam::findOrFail($auth['id']);
    }

    /**
     * Mengambil barang milik Satpam yang sedang login.
     */
    private function cariBarang(Request $request, $id)
    {
        $satpam = $this->satpamLogin($request);

        return BarangDitemukan::with('foto')->where('id_barang', $id)
            ->where('id_satpam', $satpam->id_satpam)
            ->where('sumber_penerimaan', 'Satpam')
            ->firstOrFail();
    }

    /**
     * Halaman penerimaan barang dan daftar barang terbaru.
     */
    public function index(Request $request)
    {
        $satpam = $this->satpamLogin($request);

        $barangTemuan = BarangDitemukan::with('foto')->where(
            'id_satpam',
            $satpam->id_satpam
        )
            ->where('sumber_penerimaan', 'Satpam')
            ->orderBy('id_barang', 'desc')
            ->paginate(10)
            ->withQueryString();

        $riwayatTerbaru = BarangDitemukan::where(
            'id_satpam',
            $satpam->id_satpam
        )
            ->where('sumber_penerimaan', 'Satpam')
            ->orderBy('id_barang', 'desc')
            ->limit(5)
            ->get();

        return view(
            'satpam.barang-temuan.index',
            compact('barangTemuan', 'riwayatTerbaru', 'satpam')
        );
    }

    /**
     * Mempertahankan route create yang sudah ada.
     */
    public function create(Request $request)
    {
        $this->satpamLogin($request);

        return redirect()->route('satpam.barang-temuan.index');
    }

    /**
     * Menyimpan catatan penerimaan barang.
     */
    public function store(Request $request)
    {
        $satpam = $this->satpamLogin($request);

        $validated = $request->validate([
            'nama_publik' => [
                'required',
                'string',
                'max:150',
            ],
            'kategori' => [
                'required',
                'string',
                'max:80',
            ],
            'deskripsi_publik' => [
                'required',
                'string',
            ],
            'tanggal_ditemukan' => [
                'required',
                'date',
            ],
            'lokasi_ditemukan' => [
                'required',
                'string',
                'max:180',
            ],
            'foto' => ['nullable', 'array', 'max:4'],
            'foto.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'nama_publik.required' => 'Nama barang wajib diisi.',
            'kategori.required' => 'Kategori barang wajib diisi.',
            'deskripsi_publik.required' => 'Deskripsi barang wajib diisi.',
            'tanggal_ditemukan.required' => 'Tanggal ditemukan wajib diisi.',
            'lokasi_ditemukan.required' => 'Lokasi ditemukan wajib diisi.',
        ]);

        $barangTemuan = BarangDitemukan::create([
            'id_kampus' => $satpam->id_kampus,
            'sumber_penerimaan' => 'Satpam',
            'id_admin_validator' => null,
            'id_satpam' => $satpam->id_satpam,
            'id_admin_penerima' => null,
            'nama_publik' => $validated['nama_publik'],
            'kategori' => $validated['kategori'],
            'deskripsi_publik' => $validated['deskripsi_publik'],
            'tanggal_ditemukan' => $validated['tanggal_ditemukan'],
            'lokasi_ditemukan' => $validated['lokasi_ditemukan'],
            'status' => 'Diterima Satpam',
        ]);

        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $index => $file) {
                $path = $file->store('foto-barang', 'public');
                $barangTemuan->foto()->create([
                    'path_foto' => $path,
                    'is_utama' => $index === 0,
                    'urutan' => $index,
                ]);
            }
        }

        return redirect()
            ->route('satpam.barang-temuan.index')
            ->with(
                'success',
                'Catatan penerimaan berhasil disimpan. Barang menunggu validasi Admin Kampus.'
            );
    }

    /**
     * Menampilkan form edit barang.
     */
    public function edit(Request $request, $barangTemuan)
    {
        $barangTemuan = $this->cariBarang($request, $barangTemuan);

        if ($barangTemuan->status !== 'Diterima Satpam') {
            return redirect()
                ->route('satpam.barang-temuan.index')
                ->with('error', 'Barang yang sudah diproses Admin tidak dapat diedit.');
        }

        return view(
            'satpam.barang-temuan.edit',
            compact('barangTemuan')
        );
    }

    /**
     * Memperbarui barang temuan.
     */
    public function update(Request $request, $id)
    {
        $barangTemuan = $this->cariBarang($request, $id);

        if ($barangTemuan->status !== 'Diterima Satpam') {
            return redirect()
                ->route('satpam.barang-temuan.index')
                ->with('error', 'Barang yang sudah diproses Admin tidak dapat diedit.');
        }

        $validated = $request->validate([
            'nama_publik' => [
                'required',
                'string',
                'max:150',
            ],
            'kategori' => [
                'required',
                'string',
                'max:80',
            ],
            'deskripsi_publik' => [
                'required',
                'string',
            ],
            'tanggal_ditemukan' => [
                'required',
                'date',
            ],
            'lokasi_ditemukan' => [
                'required',
                'string',
                'max:180',
            ],
            'foto' => ['nullable', 'array', 'max:4'],
            'foto.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        if ($request->hasFile('foto') && $barangTemuan->foto()->count() + count($request->file('foto')) > 4) {
            return back()->withInput()->withErrors([
                'foto' => 'Maksimal 4 foto per barang. Foto lama tetap dipertahankan.',
            ]);
        }

        $barangTemuan->update([
            'nama_publik' => $validated['nama_publik'],
            'kategori' => $validated['kategori'],
            'deskripsi_publik' => $validated['deskripsi_publik'],
            'tanggal_ditemukan' => $validated['tanggal_ditemukan'],
            'lokasi_ditemukan' => $validated['lokasi_ditemukan'],
        ]);

        if ($request->hasFile('foto')) {
            $jumlahFoto = $barangTemuan->foto()->count();
            $fotoBaru = $request->file('foto');
            foreach ($fotoBaru as $file) {
                $path = $file->store('foto-barang', 'public');
                $barangTemuan->foto()->create([
                    'path_foto' => $path,
                    'is_utama' => $jumlahFoto === 0,
                    'urutan' => $jumlahFoto++,
                ]);
            }
        }

        return redirect()
            ->route('satpam.barang-temuan.index')
            ->with('success', 'Data barang temuan berhasil diperbarui.');
    }

    /** Menghapus satu foto tanpa menghapus data barang. */
    public function hapusFoto(Request $request, $id, $foto)
    {
        $barang = $this->cariBarang($request, $id);
        abort_unless($barang->status === 'Diterima Satpam', 403, 'Foto tidak dapat diubah setelah barang diproses Admin.');
        $gambar = $barang->foto()->where('id_foto', $foto)->firstOrFail();
        $path = $gambar->path_foto;
        $gambar->delete();
        \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
        $sisa = $barang->foto()->orderBy('urutan')->get();
        foreach ($sisa as $i => $item) { $item->update(['urutan' => $i, 'is_utama' => $i === 0]); }
        return back()->with('success', 'Foto barang berhasil dihapus.');
    }

    /** Menetapkan foto utama barang temuan. */
    public function fotoUtama(Request $request, $id, $foto)
    {
        $barang = $this->cariBarang($request, $id);
        abort_unless($barang->status === 'Diterima Satpam', 403, 'Foto tidak dapat diubah setelah barang diproses Admin.');
        $barang->foto()->where('id_foto', $foto)->firstOrFail();
        $barang->foto()->update(['is_utama' => false]);
        $barang->foto()->where('id_foto', $foto)->update(['is_utama' => true]);
        return back()->with('success', 'Foto utama berhasil diperbarui.');
    }

    /**
     * Menghapus barang temuan.
     */
    public function destroy(Request $request, $id)
    {
        $barangTemuan = $this->cariBarang($request, $id);

        if ($barangTemuan->status !== 'Diterima Satpam') {
            return redirect()
                ->route('satpam.barang-temuan.index')
                ->with('error', 'Barang yang sudah diproses Admin tidak dapat dihapus.');
        }

        try {
            $barangTemuan->delete();

            return redirect()
                ->route('satpam.barang-temuan.index')
                ->with('success', 'Barang temuan berhasil dihapus.');

        } catch (QueryException $e) {
            return redirect()
                ->route('satpam.barang-temuan.index')
                ->with(
                    'error',
                    'Barang tidak dapat dihapus karena sudah memiliki data terkait.'
                );
        }
    }
}
