<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Tabel Pengguna
        DB::table('pengguna')->insert([
            [
                'nama' => 'Ahmad Fauzi',
                'kelas' => 'XII',
                'jurusan' => 'PPLG 1',
                'no_hp' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Siti Aminah',
                'kelas' => 'XI',
                'jurusan' => 'PPLG 2',
                'no_hp' => '089876543210',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Seed Tabel Peralatan
        DB::table('peralatan')->insert([
            [
                'nama_peralatan' => 'Laptop ASUS ROG',
                'kategori' => 'Komputer',
                'jumlah_stok' => 10,
                'kondisi' => 'Bagus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_peralatan' => 'Drawing Tablet Wacom',
                'kategori' => 'Aksesoris',
                'jumlah_stok' => 5,
                'kondisi' => 'Bagus',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
