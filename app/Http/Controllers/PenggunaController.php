<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    // 1. LIHAT DATA
    public function index()
    {
        $pengguna = Pengguna::all();
        return view('pengguna.index', compact('pengguna'));
    }

    // 2. FORM TAMBAH DATA
    public function create()
    {
        return view('pengguna.create');
    }

    // 3. PROSES SIMPAN DATA
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'jurusan' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
        ]);

        Pengguna::create($validated);

        return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil ditambahkan!');
    }

    // 4. PROSES HAPUS DATA
    public function destroy($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $pengguna->delete();

        return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil dihapus!');
    }
}
