<?php

namespace App\Http\Controllers;

use App\Models\BarangDitemukan;
use App\Models\Kampus;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Beranda: menampilkan beberapa barang terbaru tanpa filter pencarian.
     */
    public function home()
    {
        $barang = BarangDitemukan::with(['kampus', 'foto'])
            ->where('status', 'Dipublikasikan')
            ->orderBy('tanggal_ditemukan', 'desc')
            ->orderBy('id_barang', 'desc')
            ->paginate(4);

        return view('public.home', compact('barang'));
    }

    /**
     * Halaman pencarian barang dengan filter kata kunci, kampus, dan kategori.
     */
    public function index(Request $request)
    {
        $query = BarangDitemukan::with(['kampus', 'foto'])
            ->where('status', 'Dipublikasikan');

        // Pencarian nama atau deskripsi barang.
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('nama_publik', 'like', "%{$keyword}%")
                    ->orWhere('deskripsi_publik', 'like', "%{$keyword}%");
            });
        }

        // Filter kampus.
        if ($request->filled('kampus')) {
            $query->where('id_kampus', $request->kampus);
        }

        // Filter kategori.
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $barang = $query
            ->orderBy('tanggal_ditemukan', 'desc')
            ->orderBy('id_barang', 'desc')
            ->paginate(8)
            ->withQueryString();

        $kampus = Kampus::orderBy('nama_kampus')->get();

        $kategori = BarangDitemukan::where('status', 'Dipublikasikan')
            ->select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('public.cari-barang', compact(
            'barang',
            'kampus',
            'kategori'
        ));
    }

    /**
     * Detail barang yang sudah tervalidasi.
     */
    public function show($id)
    {
        $barang = BarangDitemukan::with(['kampus', 'foto'])
            ->where('status', 'Dipublikasikan')
            ->findOrFail($id);

        return view('public.detail', compact('barang'));
    }
}
