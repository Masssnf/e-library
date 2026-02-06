<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KehilanganController;
use App\Http\Controllers\KehilanganUserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PeminjamanUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Rute untuk Mahasiswa
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. Rute Dashboard (INI YANG SEBELUMNYA HILANG)
    Route::get('/dashboard', [MahasiswaController::class, 'index'])->name('dashboard');

    // 2. Katalog Buku
    Route::get('/katalog-buku', [PeminjamanUserController::class, 'katalog'])->name('mahasiswa.buku.index');

    // 3. Action Ajukan
    Route::post('/katalog-buku/{id}/ajukan', [PeminjamanUserController::class, 'ajukan'])->name('mahasiswa.buku.ajukan');

    // 4. Riwayat Saya
    Route::get('/riwayat-peminjaman', [PeminjamanUserController::class, 'riwayat'])->name('mahasiswa.peminjaman.index');

    // 5. Lapor Kehilangan
    Route::get('/lapor-kehilangan', [KehilanganUserController::class, 'create'])->name('mahasiswa.kehilangan.create');
    Route::post('/lapor-kehilangan', [KehilanganUserController::class, 'store'])->name('mahasiswa.kehilangan.store');
});

// Rute Khusus Admin
// Perhatikan: 'middleware' => 'admin' mengacu pada alias yang dibuat di bootstrap/app.php
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    // Route::resource('books', BookController::class); // CRUD Buku
    Route::get('/users', [AdminController::class, 'users']);
    Route::resource('anggota', AnggotaController::class);
    Route::resource('buku', BukuController::class);
    Route::resource('users', UserController::class);
    Route::resource('peminjaman', PeminjamanController::class)->except(['edit', 'update', 'destroy']);
    Route::resource('kehilangan', KehilanganController::class);
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');

    // Route khusus untuk tombol "Selesai/Kembali"
    Route::patch('/peminjaman/{id}/complete', [PeminjamanController::class, 'complete'])->name('peminjaman.complete');
    Route::patch('/peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::patch('/peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
