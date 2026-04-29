<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\PengabdianController;
use App\Http\Controllers\PengajaranController;
use App\Http\Controllers\PenelitianController;
use App\Http\Controllers\PenunjangController;
use Illuminate\Support\Facades\Route;

Route::get('/dosens', [DosenController::class, 'index'])->name('dosens.index');
Route::get('/dosens/create', [DosenController::class, 'create'])->name('dosens.create');
Route::post('/dosens', [DosenController::class, 'store'])->name('dosens.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/kinerja-saya', [PengajaranController::class, 'index'])->name('kinerja-saya.index');
    Route::get('/kinerja-admin', [PengajaranController::class, 'adminIndex'])->name('kinerja-admin.index');

    Route::get('/kinerja-saya/create', [PengajaranController::class, 'create'])->name('kinerja-saya.create');
    Route::post('/kinerja-saya', [PengajaranController::class, 'store'])->name('kinerja-saya.store');
    Route::get('/kinerja-saya/{pengajaran}/edit', [PengajaranController::class, 'edit'])->name('kinerja-saya.edit');
    Route::put('/kinerja-saya/{pengajaran}', [PengajaranController::class, 'update'])->name('kinerja-saya.update');
    Route::delete('/kinerja-saya/{pengajaran}', [PengajaranController::class, 'destroy'])->name('kinerja-saya.destroy');

    Route::post('/kinerja-saya/buku', [BukuController::class, 'store'])->name('kinerja-saya.buku.store');
    Route::post('/kinerja-saya/penelitian', [PenelitianController::class, 'store'])->name('kinerja-saya.penelitian.store');
    Route::post('/kinerja-saya/pengabdian', [PengabdianController::class, 'store'])->name('kinerja-saya.pengabdian.store');
    Route::post('/kinerja-saya/penunjang', [PenunjangController::class, 'store'])->name('kinerja-saya.penunjang.store');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
