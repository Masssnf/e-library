<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [MahasiswaController::class, 'index'])->name('dashboard');
    Route::get('/buku', [MahasiswaController::class, 'buku'])->name('buku.index');
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
    
    // Route khusus untuk tombol "Selesai/Kembali"
    Route::patch('/peminjaman/{id}/complete', [PeminjamanController::class, 'complete'])->name('peminjaman.complete');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
