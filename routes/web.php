<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\PegawaiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth','role:superadmin'])->prefix('superadmin')->group(function () {

    Route::get('/dashboard', function () {
        return view('superadmin.dashboard');
    });

    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/pegawai/wajah', [PegawaiController::class, 'wajah'])->name('pegawai.wajah');
    Route::get('/pegawai/dokumen', [PegawaiController::class, 'dokumen'])->name('pegawai.dokumen');

});

Route::middleware(['auth','role:admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

});

require __DIR__.'/auth.php';