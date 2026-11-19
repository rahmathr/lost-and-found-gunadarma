<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminKampus;
use App\Models\Satpam;
use App\Rules\GunadarmaEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class SatpamController extends Controller
{
    /**
     * Mengambil data Admin Kampus yang sedang login.
     */
    private function adminLogin(Request $request)
    {
        $auth = $request->session()->get('auth');

        if (!$auth || $auth['role'] !== 'admin_kampus') {
            abort(403, 'Akses tidak diizinkan.');
        }

        return AdminKampus::findOrFail($auth['id']);
    }

    /**
     * Memastikan Satpam berasal dari kampus Admin yang login.
     */
    private function periksaKepemilikan(Satpam $satpam, AdminKampus $admin)
    {
        if ($satpam->id_kampus != $admin->id_kampus) {
            abort(404);
        }
    }

    /**
     * Menampilkan daftar Satpam.
     */
    public function index(Request $request)
    {
        $admin = $this->adminLogin($request);

        $satpam = Satpam::where('id_kampus', $admin->id_kampus)
            ->orderBy('id_satpam', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.satpam.index', compact('satpam'));
    }

    /**
     * Menampilkan form tambah Satpam.
     */
    public function create(Request $request)
    {
        $this->adminLogin($request);

        return view('admin.satpam.create');
    }

    /**
     * Menyimpan Satpam baru.
     */
    public function store(Request $request)
    {
        $admin = $this->adminLogin($request);

        $emailInput = $request->input('email');
        if (is_string($emailInput)) {
            $request->merge(['email' => strtolower(trim($emailInput))]);
        }

        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:100',
            ],
            'email' => [
                'required',
                'email',
                'max:150',
                new GunadarmaEmail(),
                'unique:satpam,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        $emailSudahDigunakan =
            DB::table('super_admin')
                ->where('email', $validated['email'])
                ->exists()
            ||
            DB::table('admin_kampus')
                ->where('email', $validated['email'])
                ->exists()
            ||
            DB::table('pelapor_kehilangan')
                ->where('email', $validated['email'])
                ->exists();

        if ($emailSudahDigunakan) {
            throw ValidationException::withMessages([
                'email' => 'Email sudah digunakan oleh akun lain.',
            ]);
        }

        Satpam::create([
            'id_kampus' => $admin->id_kampus,
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password_hash' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('admin.satpam.index')
            ->with('success', 'Satpam berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit Satpam.
     */
    public function edit(Request $request, Satpam $satpam)
    {
        $admin = $this->adminLogin($request);

        $this->periksaKepemilikan($satpam, $admin);

        return view('admin.satpam.edit', compact('satpam'));
    }

    /**
     * Memperbarui data Satpam.
     */
    public function update(Request $request, Satpam $satpam)
    {
        $admin = $this->adminLogin($request);

        $this->periksaKepemilikan($satpam, $admin);

        $emailInput = $request->input('email');
        if (is_string($emailInput)) {
            $request->merge(['email' => strtolower(trim($emailInput))]);
        }

        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:100',
            ],
            'email' => [
                'required',
                'email',
                'max:150',
                new GunadarmaEmail(),
                'unique:satpam,email,' . $satpam->id_satpam . ',id_satpam',
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        $emailSudahDigunakan =
            DB::table('super_admin')
                ->where('email', $validated['email'])
                ->exists()
            ||
            DB::table('admin_kampus')
                ->where('email', $validated['email'])
                ->exists()
            ||
            DB::table('pelapor_kehilangan')
                ->where('email', $validated['email'])
                ->exists();

        if ($emailSudahDigunakan) {
            throw ValidationException::withMessages([
                'email' => 'Email sudah digunakan oleh akun lain.',
            ]);
        }

        $data = [
            'nama' => $validated['nama'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $data['password_hash'] = Hash::make($validated['password']);
        }

        $satpam->update($data);

        return redirect()
            ->route('admin.satpam.index')
            ->with('success', 'Data Satpam berhasil diperbarui.');
    }

    /**
     * Menghapus Satpam.
     */
    public function destroy(Request $request, Satpam $satpam)
    {
        $admin = $this->adminLogin($request);

        $this->periksaKepemilikan($satpam, $admin);

        try {
            $satpam->delete();

            return redirect()
                ->route('admin.satpam.index')
                ->with('success', 'Satpam berhasil dihapus.');

        } catch (QueryException $e) {
            return redirect()
                ->route('admin.satpam.index')
                ->with(
                    'error',
                    'Satpam tidak dapat dihapus karena masih memiliki data barang temuan atau data terkait lainnya.'
                );
        }
    }
}
