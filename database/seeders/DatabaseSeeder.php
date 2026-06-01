<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Equipment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Users
        User::create([
            'name' => 'Admin TEFA PPLG',
            'email' => 'admin@tefa.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Yusuf Student',
            'email' => 'student@tefa.id',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        // Seed Equipments
        Equipment::create([
            'nama_alat' => 'Router MikroTik RB960PGS',
            'kode_alat' => 'ALT-MT-001',
            'stok' => 5,
            'deskripsi' => 'Routerboard hEX PoE dengan 5 port Gigabit Ethernet.',
            'gambar' => null,
        ]);

        Equipment::create([
            'nama_alat' => 'ESP32 NodeMCU Development Board',
            'kode_alat' => 'ALT-ESP-023',
            'stok' => 15,
            'deskripsi' => 'Microcontroller board dengan support Wi-Fi dan Bluetooth.',
            'gambar' => null,
        ]);
        
        Equipment::create([
            'nama_alat' => 'Solder Listrik Adjustable 60W',
            'kode_alat' => 'ALT-SLD-005',
            'stok' => 10,
            'deskripsi' => 'Solder dengan pengatur suhu untuk praktikum IoT.',
            'gambar' => null,
        ]);
    }
}