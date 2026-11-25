<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminKampus;
use App\Models\BarangDitemukan;
use App\Services\FileStorageService;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class BarangDiterimaController extends Controller
{
    protected FileStorageService $fileStorage;

    public function __construct(FileStorageService $fileStorage)
    {
        $this->fileStorage = $fileStorage;
    }

    /**
     * Menghapus file publik dengan penanganan kegagalan.
     */
    private function hapusFilePublik(string $path): void
    {
        try {
            $deleted = $this->fileStorage->delete($path, 'public');

            if (!$deleted) {
                report(new \RuntimeException(
                    "Gagal menghapus foto barang: {$path}"
                ));
            }
        } catch (\Throwable $e) {
            report($e);
        }
    }

    /**
     * Membersihkan file yang sempat diunggah
     * ketika transaksi database gagal.
     */
    private function bersihkanFilePublik(array $paths): void
    {
        foreach ($paths as $path) {
            $this->hapusFilePublik($path);
        }
    }

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

        return BarangDitemukan::where('id_barang', $id)
            ->where('id_kampus', $admin->id_kampus)
            ->where('sumber_penerimaan', 'Langsung')
            ->where('id_admin_penerima', $admin->id_admin)
            ->firstOrFail();
    }

    public function index(Request $request)
    {
        $admin = $this->adminLogin($request);

        $barangTemuan = BarangDitemukan::with(['adminPenerima', 'foto'])
            ->where('id_kampus', $admin->id_kampus)
            ->where('sumber_penerimaan', 'Langsung')
            ->where('id_admin_penerima', $admin->id_admin)
            ->orderBy('id_barang', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.barang-diterima.index', compact('barangTemuan'));
    }

    public function create(Request $request)
    {
        $this->adminLogin($request);

        return view('admin.barang-diterima.create');
    }

    public function store(Request $request)
    {
        $admin = $this->adminLogin($request);

        $validated = $request->validate([
            'nama_publik' => 'required|string|max:150',
            'kategori' => 'required|string|max:80',
            'deskripsi_publik' => 'nullable|string',
            'tanggal_ditemukan' => 'required|date',
            'lokasi_ditemukan' => 'required|string|max:180',
            'foto' => 'nullable|array|max:4',
            'foto.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $uploadedPaths = [];

        try {
            DB::transaction(function () use (
                $admin,
                $validated,
                $request,
                &$uploadedPaths
            ) {
                $barangTemuan = BarangDitemukan::create([
                    'id_kampus' => $admin->id_kampus,
                    'sumber_penerimaan' => 'Langsung',
                    'id_admin_validator' => null,
                    'id_satpam' => null,
                    'id_admin_penerima' => $admin->id_admin,
                    'nama_publik' => $validated['nama_publik'],
                    'kategori' => $validated['kategori'],
                    'deskripsi_publik' => $validated['deskripsi_publik'] ?? null,
                    'tanggal_ditemukan' => $validated['tanggal_ditemukan'],
                    'lokasi_ditemukan' => $validated['lokasi_ditemukan'],
                    'status' => 'Diterima Admin',
                ]);

                if ($request->hasFile('foto')) {
                    foreach ($request->file('foto') as $index => $file) {
                        $path = $this->fileStorage->store(
                            $file,
                            'foto-barang',
                            'public'
                        );

                        if ($path === false) {
                            throw new \RuntimeException(
                                'Foto barang gagal disimpan.'
                            );
                        }

                        $uploadedPaths[] = $path;

                        $barangTemuan->foto()->create([
                            'path_foto' => $path,
                            'is_utama' => $index === 0,
                            'urutan' => $index,
                        ]);
                    }
                }
            });
        } catch (\Throwable $e) {
            $this->bersihkanFilePublik($uploadedPaths);

            throw $e;
        }

        return redirect()
            ->route('admin.barang-diterima.index')
            ->with('success', 'Barang berhasil dicatat.');
    }

    public function edit(Request $request, $id)
    {
        $barangTemuan = $this->cariBarang($request, $id);

        return view('admin.barang-diterima.edit', compact('barangTemuan'));
    }

    public function update(Request $request, $id)
    {
        $barangTemuan = $this->cariBarang($request, $id);

        $validated = $request->validate([
            'nama_publik' => 'required|string|max:150',
            'kategori' => 'required|string|max:80',
            'deskripsi_publik' => 'nullable|string',
            'tanggal_ditemukan' => 'required|date',
            'lokasi_ditemukan' => 'required|string|max:180',
            'foto' => 'nullable|array|max:4',
            'foto.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if (
            $request->hasFile('foto') &&
            $barangTemuan->foto()->count() + count($request->file('foto')) > 4
        ) {
            return back()->withInput()->withErrors([
                'foto' => 'Maksimal 4 foto per barang. Foto lama tetap dipertahankan.',
            ]);
        }

        unset($validated['foto']);

        $uploadedPaths = [];

        try {
            DB::transaction(function () use (
                $barangTemuan,
                $validated,
                $request,
                &$uploadedPaths
            ) {
                $barangTemuan->update($validated);

                if ($request->hasFile('foto')) {
                    $jumlahFoto = $barangTemuan->foto()->count();

                    foreach ($request->file('foto') as $file) {
                        $path = $this->fileStorage->store(
                            $file,
                            'foto-barang',
                            'public'
                        );

                        if ($path === false) {
                            throw new \RuntimeException(
                                'Foto barang gagal disimpan.'
                            );
                        }

                        $uploadedPaths[] = $path;

                        $barangTemuan->foto()->create([
                            'path_foto' => $path,
                            'is_utama' => $jumlahFoto === 0,
                            'urutan' => $jumlahFoto++,
                        ]);
                    }
                }
            });
        } catch (\Throwable $e) {
            $this->bersihkanFilePublik($uploadedPaths);

            throw $e;
        }

        return redirect()
            ->route('admin.barang-diterima.index')
            ->with('success', 'Data barang berhasil diperbarui.');
    }

    public function hapusFoto(Request $request, $id, $foto)
    {
        $barang = $this->cariBarang($request, $id);

        $gambar = $barang->foto()
            ->where('id_foto', $foto)
            ->firstOrFail();

        $path = $gambar->path_foto;

        DB::transaction(function () use ($gambar, $barang) {
            $gambar->delete();

            $sisa = $barang->foto()
                ->orderBy('urutan')
                ->get();

            foreach ($sisa as $i => $item) {
                $item->update([
                    'urutan' => $i,
                    'is_utama' => $i === 0,
                ]);
            }
        });

        $this->hapusFilePublik($path);

        return back()->with('success', 'Foto barang berhasil dihapus.');
    }

    public function fotoUtama(Request $request, $id, $foto)
    {
        $barang = $this->cariBarang($request, $id);

        $barang->foto()
            ->where('id_foto', $foto)
            ->firstOrFail();

        $barang->foto()->update(['is_utama' => false]);

        $barang->foto()
            ->where('id_foto', $foto)
            ->update(['is_utama' => true]);

        return back()->with('success', 'Foto utama berhasil diperbarui.');
    }

    public function destroy(Request $request, $id)
    {
        $barangTemuan = $this->cariBarang($request, $id);

        $pathsFoto = $barangTemuan->foto()
            ->pluck('path_foto')
            ->filter()
            ->values();

        try {
            $berhasilDihapus = $barangTemuan->delete();

            if (!$berhasilDihapus) {
                return redirect()
                    ->route('admin.barang-diterima.index')
                    ->with('error', 'Data barang tidak dapat dihapus.');
            }

            foreach ($pathsFoto as $path) {
                $this->hapusFilePublik($path);
            }

            return redirect()
                ->route('admin.barang-diterima.index')
                ->with('success', 'Data barang berhasil dihapus.');

        } catch (QueryException $e) {
            return redirect()
                ->route('admin.barang-diterima.index')
                ->with('error', 'Barang tidak dapat dihapus karena sudah memiliki data terkait.');
        }
    }
}
