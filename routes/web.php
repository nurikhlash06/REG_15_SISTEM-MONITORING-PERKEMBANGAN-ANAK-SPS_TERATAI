<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Guru\UserOrangtuaController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\MuridController as GuruMuridController;
use App\Http\Controllers\Guru\PerkembanganController as GuruPerkembanganController;
use App\Http\Controllers\OrangTua\DashboardController as OrangTuaDashboardController;
use App\Http\Controllers\OrangTua\PerkembanganController as OrangTuaPerkembanganController;

// Public Routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// Guru Routes
Route::prefix('guru')->name('guru.')->middleware(['auth', 'guru'])->group(function () {
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');
    Route::resource('murid', GuruMuridController::class);
    Route::resource('perkembangan', GuruPerkembanganController::class)->except(['show']);
    Route::resource('orangtua', UserOrangtuaController::class)->only(['index', 'create', 'store', 'destroy']);
});

// Orang Tua Routes
Route::prefix('orangtua')->name('orangtua.')->middleware(['auth', 'orangtua'])->group(function () {
    Route::get('/dashboard', [OrangTuaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/perkembangan', [OrangTuaPerkembanganController::class, 'index'])->name('perkembangan.index');
    Route::get('/perkembangan/{perkembangan}', [OrangTuaPerkembanganController::class, 'show'])->name('perkembangan.show');
});
