<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes untuk User (Petugas Security)
    Route::prefix('absensi')->group(function () {
        Route::get('/', [AbsensiController::class, 'index'])->name('absensi.index');
        Route::get('/create', [AbsensiController::class, 'create'])->name('absensi.add-absensi');
        Route::post('absensi/store', [AbsensiController::class, 'store'])->name('absensi.store');
        Route::get('/absensi/data', [AbsensiController::class, 'data'])->name('absensi.data');
        Route::get('/{absensi}/edit', [AbsensiController::class, 'edit'])->name('absensi.edit');
        Route::put('/{absensi}', [AbsensiController::class, 'update'])->name('absensi.update');
        Route::delete('/{absensi}', [AbsensiController::class, 'destroy'])->name('absensi.destroy');
    });

    // Routes untuk Admin
    Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::get('/data-absensi', [AbsensiController::class, 'indexAdmin'])->name('admin.data-absensi');
        Route::get('/data-absensi/data', [AbsensiController::class, 'data'])->name('admin.data-absensi.data');
        Route::post('/data-absensi', [AbsensiController::class, 'store'])->name('admin.data-absensi.store');
        Route::put('/data-absensi/{id}', [AbsensiController::class, 'update'])->name('admin.data-absensi.update');
        Route::delete('/data-absensi/{id}', [AbsensiController::class, 'destroy'])->name('admin.data-absensi.destroy');
        Route::post('/update-status', [AbsensiController::class, 'updateStatus'])->name('admin.absensi.update-status');  // Ensure this is POST
        Route::get('/data-pengguna', [UserController::class, 'index'])->name('admin.data-pengguna');
        // web.php
        Route::delete('/data-pengguna/{id}', [UserController::class, 'destroy'])->name('admin.data-pengguna.destroy');
        Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan');
    });
});

require __DIR__ . '/auth.php';
