<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Kampus;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

class KampusController extends Controller
{
    // Menampilkan daftar kampus
    public function index()
    {
        $kampus = Kampus::orderBy('id_kampus', 'asc')->paginate(10)
            ->withQueryString();

        return view('super-admin.kampus.index', compact('kampus'));
    }

    // Menampilkan form tambah kampus
    public function create()
    {
        return view('super-admin.kampus.create');
    }

    // Menyimpan kampus baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kampus' => ['required', 'string', 'max:150', Rule::unique('kampus', 'nama_kampus')],
            'alamat' => ['nullable', 'string', 'max:255'],
        ]);

        Kampus::create($validated);

        return redirect()
            ->route('super-admin.kampus.index')
            ->with('success', 'Kampus berhasil ditambahkan.');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $kampus = Kampus::findOrFail($id);

        return view('super-admin.kampus.edit', compact('kampus'));
    }

    // Memperbarui data kampus
    public function update(Request $request, $id)
    {
        $kampus = Kampus::findOrFail($id);

        $validated = $request->validate([
            'nama_kampus' => ['required', 'string', 'max:150', Rule::unique('kampus', 'nama_kampus')->ignore($kampus->id_kampus, 'id_kampus')],
            'alamat' => ['nullable', 'string', 'max:255'],
        ]);

        $kampus->update($validated);

        return redirect()
            ->route('super-admin.kampus.index')
            ->with('success', 'Data kampus berhasil diperbarui.');
    }

    // Menghapus kampus
    public function destroy($id)
    {
        $kampus = Kampus::findOrFail($id);

        try {
            $kampus->delete();

            return redirect()
                ->route('super-admin.kampus.index')
                ->with('success', 'Kampus berhasil dihapus.');

        } catch (QueryException $e) {

            return redirect()
                ->route('super-admin.kampus.index')
                ->with('error', 'Kampus tidak dapat dihapus karena masih memiliki data yang terhubung.');
        }
    }
}
