<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PeralatanController;
use App\Http\Controllers\PeminjamanController;

// Halaman Utama
Route::get('/', [PeminjamanController::class, 'index']);

// ================= ROUTE MANUAL PEMINJAMAN =================
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

// ================= ROUTE MANUAL PENGGUNA =================
Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
Route::get('/pengguna/create', [PenggunaController::class, 'create'])->name('pengguna.create');
Route::post('/pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
Route::delete('/pengguna/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');

// ================= ROUTE MANUAL PERALATAN =================
Route::get('/peralatan', [PeralatanController::class, 'index'])->name('peralatan.index');
Route::get('/peralatan/create', [PeralatanController::class, 'create'])->name('peralatan.create');
Route::post('/peralatan', [PeralatanController::class, 'store'])->name('peralatan.store');
Route::delete('/peralatan/{id}', [PeralatanController::class, 'destroy'])->name('peralatan.destroy');
