<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajaranController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/kinerja-saya', [PengajaranController::class, 'index'])->name('kinerja-saya.index');
    Route::get('/kinerja-saya/create', [PengajaranController::class, 'create'])->name('kinerja-saya.create');
    Route::post('/kinerja-saya', [PengajaranController::class, 'store'])->name('kinerja-saya.store');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
