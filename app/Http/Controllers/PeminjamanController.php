<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Peralatan;
use Illuminate\Http\Request;

class PeminjamanController extends Controller {
    public function index() {
        $peminjamans = Peminjaman::with(['pengguna', 'peralatan'])->paginate(10);
        return view('peminjaman.index', compact('peminjamans'));
    }

    public function store(Request $request) {
        $request->validate([
            'pengguna_id' => 'required|exists:pengguna,id',
            'peralatan_id' => 'required|exists:peralatan,id',
            'tanggal_pinjam' => 'required|date',
            'jumlah_pinjam' => 'required|integer|min:1',
        ]);

        $peralatan = Peralatan::findOrFail($request->peralatan_id);

        if ($peralatan->jumlah_stok < $request->jumlah_pinjam) {
            return redirect()->back()->with('error', 'Stok peralatan tidak mencukupi!');
        }

        // Kurangi stok alat
        $peralatan->decrement('jumlah_stok', $request->jumlah_pinjam);

        Peminjaman::create($request->all());

        return redirect()->back()->with('success', 'Transaksi peminjaman berhasil dicatat!');
    }

    public function return($id) {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->tanggal_kembali !== null) {
            return redirect()->back()->with('error', 'Peralatan sudah dikembalikan sebelumnya!');
        }

        $peminjaman->update(['tanggal_kembali' => now()]);

        // Kembalikan stok alat
        $peminjaman->peralatan->increment('jumlah_stok', $peminjaman->jumlah_pinjam);

        return redirect()->back()->with('success', 'Peralatan berhasil dikembalikan!');
    }

    public function destroy($id) {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Jika dihapus saat status masih dipinjam, kembalikan stoknya dulu
        if ($peminjaman->tanggal_kembali === null) {
            $peminjaman->peralatan->increment('jumlah_stok', $peminjaman->jumlah_pinjam);
        }

        $peminjaman->delete();
        return redirect()->back()->with('success', 'Log transaksi berhasil dihapus!');
    }
}