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

    Route::get('/kinerja-saya/buku/{buku}/edit', [BukuController::class, 'edit'])->name('kinerja-saya.buku.edit');
    Route::put('/kinerja-saya/buku/{buku}', [BukuController::class, 'update'])->name('kinerja-saya.buku.update');
    Route::delete('/kinerja-saya/buku/{buku}', [BukuController::class, 'destroy'])->name('kinerja-saya.buku.destroy');
    Route::get('/kinerja-saya/penelitian/{penelitian}/edit', [PenelitianController::class, 'edit'])->name('kinerja-saya.penelitian.edit');
    Route::put('/kinerja-saya/penelitian/{penelitian}', [PenelitianController::class, 'update'])->name('kinerja-saya.penelitian.update');
    Route::delete('/kinerja-saya/penelitian/{penelitian}', [PenelitianController::class, 'destroy'])->name('kinerja-saya.penelitian.destroy');
    Route::get('/kinerja-saya/pengabdian/{pengabdian}/edit', [PengabdianController::class, 'edit'])->name('kinerja-saya.pengabdian.edit');
    Route::put('/kinerja-saya/pengabdian/{pengabdian}', [PengabdianController::class, 'update'])->name('kinerja-saya.pengabdian.update');
    Route::delete('/kinerja-saya/pengabdian/{pengabdian}', [PengabdianController::class, 'destroy'])->name('kinerja-saya.pengabdian.destroy');
    Route::get('/kinerja-saya/penunjang/{penunjang}/edit', [PenunjangController::class, 'edit'])->name('kinerja-saya.penunjang.edit');
    Route::put('/kinerja-saya/penunjang/{penunjang}', [PenunjangController::class, 'update'])->name('kinerja-saya.penunjang.update');
    Route::delete('/kinerja-saya/penunjang/{penunjang}', [PenunjangController::class, 'destroy'])->name('kinerja-saya.penunjang.destroy');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
