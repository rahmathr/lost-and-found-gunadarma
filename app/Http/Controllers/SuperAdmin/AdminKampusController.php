<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AdminKampus;
use App\Models\Kampus;
use App\Rules\GunadarmaEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

class AdminKampusController extends Controller
{
    /**
     * Menampilkan daftar Admin Kampus dan form tambah/ubah.
     */
    public function index(Request $request)
    {
        $adminKampus = AdminKampus::with([
            'kampus',
            'superAdminPembuat',
        ])
            ->orderBy('id_admin', 'asc')
            ->paginate(10)
            ->withQueryString();

        $kampus = Kampus::orderBy('nama_kampus', 'asc')->get();

        $adminTerpilih = null;

        if ($request->filled('edit')) {
            $adminTerpilih = AdminKampus::with([
                'kampus',
                'superAdminPembuat',
            ])->findOrFail($request->query('edit'));
        }

        $auth = $request->session()->get('auth');

        $namaSuperAdmin = DB::table('super_admin')
            ->where('id_super_admin', $auth['id'] ?? null)
            ->value('nama');

        return view(
            'super-admin.admin-kampus.index',
            compact(
                'adminKampus',
                'kampus',
                'adminTerpilih',
                'namaSuperAdmin'
            )
        );
    }

    /**
     * Mengarahkan halaman tambah ke halaman utama.
     */
    public function create()
    {
        return redirect()->route('super-admin.admin-kampus.index');
    }

    /**
     * Menyimpan Admin Kampus baru.
     */
    public function store(Request $request)
    {
        $emailInput = $request->input('email');
        if (is_string($emailInput)) {
            $request->merge(['email' => strtolower(trim($emailInput))]);
        }

        $validated = $request->validate([
            'id_kampus' => [
                'required',
                'integer',
                'exists:kampus,id_kampus',
            ],
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
                'unique:admin_kampus,email',
                'unique:super_admin,email',
                'unique:satpam,email',
                'unique:pelapor_kehilangan,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
            ],
        ], [
            'id_kampus.required' => 'Kampus wajib dipilih.',
            'id_kampus.exists' => 'Kampus yang dipilih tidak ditemukan.',
            'nama.required' => 'Nama Admin wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
            'password.required' => 'Kata sandi awal wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        $auth = $request->session()->get('auth');

        abort_unless(
            $auth && ($auth['role'] ?? null) === 'super_admin',
            403,
            'Akses tidak diizinkan.'
        );

        AdminKampus::create([
            'id_kampus' => $validated['id_kampus'],
            'id_super_admin_pembuat' => $auth['id'],
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password_hash' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('super-admin.admin-kampus.index')
            ->with('success', 'Akun Admin Kampus berhasil ditambahkan.');
    }

    /**
     * Mengarahkan halaman edit ke halaman utama dengan form terpilih.
     */
    public function edit(AdminKampus $adminKampus)
    {
        return redirect()->route(
            'super-admin.admin-kampus.index',
            ['edit' => $adminKampus->id_admin]
        );
    }

    /**
     * Memperbarui data Admin Kampus.
     */
    public function update(Request $request, AdminKampus $adminKampus)
    {
        $emailInput = $request->input('email');
        if (is_string($emailInput)) {
            $request->merge(['email' => strtolower(trim($emailInput))]);
        }

        $validated = $request->validate([
            'id_kampus' => [
                'required',
                'integer',
                'exists:kampus,id_kampus',
            ],
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
                Rule::unique('admin_kampus', 'email')
                    ->ignore($adminKampus->id_admin, 'id_admin'),
                'unique:super_admin,email',
                'unique:satpam,email',
                'unique:pelapor_kehilangan,email',
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
            ],
        ], [
            'id_kampus.required' => 'Kampus wajib dipilih.',
            'id_kampus.exists' => 'Kampus yang dipilih tidak ditemukan.',
            'nama.required' => 'Nama Admin wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        $data = [
            'id_kampus' => $validated['id_kampus'],
            'nama' => $validated['nama'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $data['password_hash'] = Hash::make($validated['password']);
        }

        $adminKampus->update($data);

        return redirect()
            ->route('super-admin.admin-kampus.index')
            ->with('success', 'Data Admin Kampus berhasil diperbarui.');
    }

    /**
     * Menghapus Admin Kampus.
     */
    public function destroy(AdminKampus $adminKampus)
    {
        try {
            $adminKampus->delete();

            return redirect()
                ->route('super-admin.admin-kampus.index')
                ->with('success', 'Admin Kampus berhasil dihapus.');

        } catch (QueryException $e) {
            return redirect()
                ->route('super-admin.admin-kampus.index')
                ->with(
                    'error',
                    'Admin Kampus tidak dapat dihapus karena masih memiliki data yang berhubungan.'
                );
        }
    }
}
