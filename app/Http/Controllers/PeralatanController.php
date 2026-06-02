<?php

namespace App\Http\Controllers;

use App\Models\Peralatan;
use Illuminate\Http\Request;

class PeralatanController extends Controller
{
    // 1. LIHAT DATA (Menampilkan tabel utama inventaris alat)
    public function index()
    {
        $peralatan = Peralatan::all();
        // Memanggil file resources/views/peralatan/index.blade.php
        return view('peralatan.index', compact('peralatan'));
    }

    // 2. FORM TAMBAH DATA (Menampilkan halaman form input alat)
    public function create()
    {
        // Memanggil file resources/views/peralatan/create.blade.php
        return view('peralatan.create');
    }

    // 3. PROSES SIMPAN DATA
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_peralatan' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'jumlah_stok' => 'required|integer|min:0',
            'kondisi' => 'required|string|max:100',
        ]);

        Peralatan::create($validated);

        // Setelah sukses menyimpan, kembali ke tabel peralatan
        return redirect()->route('peralatan.index')->with('success', 'Data peralatan berhasil ditambahkan!');
    }

    // 4. PROSES HAPUS DATA
    public function destroy($id)
    {
        $peralatan = Peralatan::findOrFail($id);
        $peralatan->delete();

        // Setelah sukses menghapus, kembali ke tabel peralatan
        return redirect()->route('peralatan.index')->with('success', 'Data peralatan berhasil dihapus!');
    }
}
