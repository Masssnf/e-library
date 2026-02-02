<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProfileController;
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
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
