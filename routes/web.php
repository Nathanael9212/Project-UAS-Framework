<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileSiswaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\PendaftaranController;

// Halaman awal: arahkan ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route yang butuh login
Route::middleware('auth')->group(function () {

    // Dashboard untuk semua user yang login (PAKAI CONTROLLER)
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('verified')
        ->name('dashboard');

    // Route khusus ADMIN/PETUGAS
    Route::middleware('role:admin,petugas')->group(function () {
        Route::resource('siswa', SiswaController::class);
        Route::resource('jurusan', JurusanController::class);

        // Route pendaftaran untuk admin (bisa lihat & kelola semua)
        Route::get('/pendaftaran', [PendaftaranController::class, 'index'])
            ->name('pendaftaran.index');
        Route::get('/pendaftaran/create-admin', [PendaftaranController::class, 'create'])
            ->name('pendaftaran.create-admin');
        Route::post('/pendaftaran/store-admin', [PendaftaranController::class, 'store'])
            ->name('pendaftaran.store-admin');
        Route::get('/pendaftaran/{id}/edit', [PendaftaranController::class, 'edit'])
            ->name('pendaftaran.edit');
        Route::put('/pendaftaran/{id}', [PendaftaranController::class, 'update'])
            ->name('pendaftaran.update');
        Route::delete('/pendaftaran/{id}', [PendaftaranController::class, 'destroy'])
            ->name('pendaftaran.destroy');
    });

    // Route khusus SISWA
    Route::middleware('role:siswa')->group(function () {
        // Isi biodata siswa
        Route::get('/profile/biodata', [ProfileSiswaController::class, 'biodata'])
            ->name('profile.biodata');
        Route::post('/profile/biodata', [ProfileSiswaController::class, 'storeBiodata'])
            ->name('profile.biodata.store');

        // Lihat pendaftaran sendiri
        Route::get('/my-pendaftaran', [PendaftaranController::class, 'myPendaftaran'])
            ->name('pendaftaran.my');

        // Lihat daftar semua pendaftar (siswa bisa lihat siswa lain yang daftar)
        Route::get('/daftar-pendaftar', [PendaftaranController::class, 'listPendaftar'])
            ->name('pendaftaran.list');

        // Form daftar jurusan (siswa)
        Route::get('/daftar-jurusan', [PendaftaranController::class, 'createForSiswa'])
            ->name('pendaftaran.create');

        // Simpan pendaftaran siswa
        Route::post('/daftar-jurusan', [PendaftaranController::class, 'storeForSiswa'])
            ->name('pendaftaran.store');
    });

    // Route profile bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// Route auth (login, register, dll) dari Breeze
require __DIR__ . '/auth.php';
