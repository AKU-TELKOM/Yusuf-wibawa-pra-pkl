<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use App\Models\Peralatan;
use App\Models\Peminjaman;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // Data Pengguna Dummy
        $pengguna = Pengguna::create([
            'nama' => 'Muhammad Yusuf Wibawa',
            'kelas' => 'XII',
            'jurusan' => 'PPLG',
            'no_hp' => '081234567890'
        ]);

        // Data Peralatan Dummy
        $peralatan1 = Peralatan::create([
            'nama_peralatan' => 'Solder Listrik Adjustable',
            'kategori' => 'Elektronika',
            'jumlah_stok' => 10,
            'kondisi' => 'Bagus'
        ]);

        $peralatan2 = Peralatan::create([
            'nama_peralatan' => 'MikroTik RouterBOARD RB960PGS',
            'kategori' => 'Networking',
            'jumlah_stok' => 5,
            'kondisi' => 'Bagus'
        ]);

        // Data Transaksi Peminjaman Dummy
        Peminjaman::create([
            'pengguna_id' => $pengguna->id,
            'peralatan_id' => $peralatan1->id,
            'tanggal_pinjam' => now(),
            'tanggal_kembali' => null,
            'jumlah_pinjam' => 1
        ]);
    }
}