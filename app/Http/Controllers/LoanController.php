<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Equipment;
use App\Http\Requests\StoreLoanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function index()
    {
        // Eager loading relations untuk mencegah N+1 problem
        $loans = Loan::with(['user', 'equipment'])->latest()->paginate(10);
        return view('loans.index', compact('loans'));
    }

    public function store(StoreLoanRequest $request)
    {
        // Menggunakan Database Transaction untuk menjamin integritas data (Atomicity)
        DB::transaction(function () use ($request) {
            $data = $request->validated();
            $data['status'] = 'dipinjam';

            // Kurangi stok barang menggunakan decrement
            $equipment = Equipment::lockForUpdate()->find($data['equipment_id']);
            
            // Validasi double check mengantisipasi race condition
            if ($equipment->stok < 1) {
                throw new \Exception('Stok mendadak habis dikarenakan diakses user lain.');
            }

            $equipment->decrement('stok', 1);

            Loan::create($data);
        });

        return redirect()->route('loans.index')->with('success', 'Transaksi peminjaman berhasil dicatat.');
    }

    public function returnEquipment(Request $request, Loan $loan)
    {
        if ($loan->status === 'dikembalikan') {
            return redirect()->route('loans.index')->with('error', 'Peralatan ini sudah dikembalikan sebelumnya.');
        }

        DB::transaction(function () use ($loan) {
            // Update status transaksi peminjaman
            $loan->update([
                'status' => 'dikembalikan',
                'tanggal_kembali' => now()->format('Y-m-d'),
            ]);

            // Kembalikan jumlah stok barang menggunakan increment
            $loan->equipment()->increment('stok', 1);
        });

        return redirect()->route('loans.index')->with('success', 'Pengembalian alat berhasil diproses.');
    }
    
    public function destroy(Loan $loan)
    {
        DB::transaction(function () use ($loan) {
            // Jika data dihapus saat statusnya masih dipinjam, kembalikan stoknya terlebih dahulu
            if ($loan->status === 'dipinjam') {
                $loan->equipment()->increment('stok', 1);
            }
            $loan->delete();
        });

        return redirect()->route('loans.index')->with('success', 'Log transaksi peminjaman berhasil dihapus.');
    }
}