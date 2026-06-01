<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\LoanController;

Route::get('/', [LoanController::class, 'index']);

// CRUD Resource Routes
Route::resource('users', UserController::class)->except(['create', 'edit']);
Route::resource('equipments', EquipmentController::class)->except(['create', 'edit']);
Route::resource('loans', LoanController::class)->except(['create', 'edit', 'update']);

// Custom Route Khusus Proses Pengembalian Alat
Route::patch('loans/{loan}/return', [LoanController::class, 'returnEquipment'])->name('loans.return');