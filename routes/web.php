<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Aplikasi Mini Donor Darah
|--------------------------------------------------------------------------
*/

// 1. Rute Publik (Landing Page & Cek Stok)
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::post('/search-stock', [LandingController::class, 'search'])->name('stock.search');


// 2. Rute Autentikasi Pengguna (Hanya Akses untuk yang Belum Login)
Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'showLogin')->name('login');
        Route::post('/login', 'login');
        
        // Tambahkan rute GET ini untuk menampilkan form daftar:
        Route::get('/register', 'showRegister')->name('register'); 
        // Rute POST ini tetap ada untuk memproses datanya:
        Route::post('/register', 'register'); 
    });
});


// 3. Rute Fitur Internal (Wajib Login / Terautentikasi)
Route::middleware('auth')->group(function () {
    // Proses Keluar Aplikasi
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Fitur Utama Pendonor (Dashboard & Registrasi Jadwal)
    Route::controller(DonorController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::post('/register-donor', 'registerDonor')->name('donor.register');
    });
});