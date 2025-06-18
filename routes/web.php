<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Models\Penilaian;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route User
    Route::middleware('role:super-admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });

    // Route Proyek
    Route::get('proyeks', [ProyekController::class, 'index'])->name('proyeks.index');
    Route::middleware('role:super-admin')->group(function () {
        Route::get('proyeks/create', [ProyekController::class, 'create'])->name('proyeks.create');
        Route::post('proyeks', [ProyekController::class, 'store'])->name('proyeks.store');
        Route::get('proyeks/{proyek}/edit', [ProyekController::class, 'edit'])->name('proyeks.edit');
        Route::put('proyeks/{proyek}', [ProyekController::class, 'update'])->name('proyeks.update');
        Route::delete('proyeks/{proyek}', [ProyekController::class, 'destroy'])->name('proyeks.destroy');
    });

    // Route Kriteria
    Route::get('kriterias', [KriteriaController::class, 'index'])->name('kriterias.index');
    Route::middleware('role:super-admin')->group(function () {
        Route::get('kriterias/create', [KriteriaController::class, 'create'])->name('kriterias.create');
        Route::post('kriterias', [KriteriaController::class, 'store'])->name('kriterias.store');
        Route::get('kriterias/{kriteria}/edit', [KriteriaController::class, 'edit'])->name('kriterias.edit');
        Route::put('kriterias/{kriteria}', [KriteriaController::class, 'update'])->name('kriterias.update');
        Route::delete('kriterias/{kriteria}', [KriteriaController::class, 'destroy'])->name('kriterias.destroy');
    });

    // Route Sub-Kriteria
    Route::get('subkriterias', [SubKriteriaController::class, 'index'])->name('subkriterias.index');
    Route::middleware('role:super-admin')->group(function () {
        Route::get('subkriterias/create', [SubKriteriaController::class, 'create'])->name('subkriterias.create');
        Route::post('subkriterias', [SubKriteriaController::class, 'store'])->name('subkriterias.store');
        Route::get('subkriterias/{subkriteria}/edit', [SubKriteriaController::class, 'edit'])->name('subkriterias.edit');
        Route::put('subkriterias/{subkriteria}', [SubKriteriaController::class, 'update'])->name('subkriterias.update');
        Route::delete('subkriterias/{subkriteria}', [SubKriteriaController::class, 'destroy'])->name('subkriterias.destroy');
    });

    // Route Penilaian
    Route::prefix('penilaian')->name('penilaian.')->group(function () {
        Route::get('/', [PenilaianController::class, 'index'])->name('index');
        Route::get('/{proyekId}/input', [PenilaianController::class, 'createEdit'])->name('create_edit');
        Route::post('/{proyekId}/simpan', [PenilaianController::class, 'storeUpdate'])->name('store_update');
    });

    // Route untuk menampilkan hasil ranking (bisa diakses siapa saja yang auth)
    Route::get('/awards/ranking', [PenilaianController::class, 'showRanking'])->name('awards.ranking');

    Route::post('/awards/save-ranking', [PenilaianController::class, 'saveRanking'])->name('penilaian.save_ranking');
    Route::get('/awards/history', [PenilaianController::class, 'showRankingHistory'])->name('awards.history');
    Route::get('/awards/history/{batchId}', [PenilaianController::class, 'showRankingDetail'])->name('awards.history.detail');

    // Route Edit & Delete Ranking Batch (Riwayat Ranking)
    Route::middleware('role:super-admin')->group(function () {
        Route::get('/awards/history/{batchId}/edit', [PenilaianController::class, 'editRankingBatch'])->name('awards.history.edit');
        Route::put('/awards/history/{batchId}', [PenilaianController::class, 'updateRankingBatch'])->name('awards.history.update');
        Route::delete('/awards/history/{batchId}', [PenilaianController::class, 'destroyRankingBatch'])->name('awards.history.destroy');
    });

});

require __DIR__.'/auth.php';
