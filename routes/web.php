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
    Route::middleware('permission:kelola_role')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });

    // Route Proyek
    Route::get('proyeks', [ProyekController::class, 'index'])->name('proyeks.index');
    Route::middleware('permission:data_proyek')->group(function () {
        Route::get('proyeks/create', [ProyekController::class, 'create'])->name('proyeks.create');
        Route::post('proyeks', [ProyekController::class, 'store'])->name('proyeks.store');
        Route::get('proyeks/{proyek}/edit', [ProyekController::class, 'edit'])->name('proyeks.edit');
        Route::put('proyeks/{proyek}', [ProyekController::class, 'update'])->name('proyeks.update');
        Route::delete('proyeks/{proyek}', [ProyekController::class, 'destroy'])->name('proyeks.destroy');
    });

    // Route Kriteria
    Route::get('kriterias', [KriteriaController::class, 'index'])->name('kriterias.index');
    Route::middleware('permission:kriteria.view')->group(function () {
        Route::get('kriterias/create', [KriteriaController::class, 'create'])->name('kriterias.create');
        Route::post('kriterias', [KriteriaController::class, 'store'])->name('kriterias.store');
        Route::get('kriterias/{kriteria}/edit', [KriteriaController::class, 'edit'])->name('kriterias.edit');
        Route::put('kriterias/{kriteria}', [KriteriaController::class, 'update'])->name('kriterias.update');
        Route::delete('kriterias/{kriteria}', [KriteriaController::class, 'destroy'])->name('kriterias.destroy');
    });

    // Route Sub-Kriteria
    Route::get('subkriterias', [SubKriteriaController::class, 'index'])->name('subkriterias.index');
    Route::middleware('permission:sub_kriteria.create')->group(function () {
        Route::get('subkriterias/create', [SubKriteriaController::class, 'create'])->name('subkriterias.create');
        Route::post('subkriterias', [SubKriteriaController::class, 'store'])->name('subkriterias.store');
    });
    Route::middleware('permission:sub_kriteria.edit|sub_kriteria.input_bobot')->group(function () {
        Route::get('subkriterias/{subkriteria}/edit', [SubKriteriaController::class, 'edit'])->name('subkriterias.edit');
        Route::put('subkriterias/{subkriteria}', [SubKriteriaController::class, 'update'])->name('subkriterias.update');
    });
    Route::middleware('permission:sub_kriteria.delete')->group(function () {
        Route::delete('subkriterias/{subkriteria}', [SubKriteriaController::class, 'destroy'])->name('subkriterias.destroy');
    });

    // Route AJAX untuk kode sub-kriteria otomatis
    Route::get('subkriterias/next-kode', [App\Http\Controllers\SubKriteriaController::class, 'getNextKode'])->name('subkriterias.nextKode');

    // Route AJAX untuk nilai sub-kriteria otomatis
    Route::get('subkriterias/next-nilai', [App\Http\Controllers\SubKriteriaController::class, 'getNextNilai'])->name('subkriterias.nextNilai');

    // Route Penilaian
    Route::middleware('permission:penilaian')->prefix('penilaian')->name('penilaian.')->group(function () {
        Route::get('/', [PenilaianController::class, 'index'])->name('index');
        Route::get('/{proyekId}/input', [PenilaianController::class, 'createEdit'])->name('create_edit');
        Route::post('/{proyekId}/simpan', [PenilaianController::class, 'storeUpdate'])->name('store_update');
        Route::delete('/{proyekId}', [PenilaianController::class, 'destroy'])->name('destroy');
    });

    // Route untuk menampilkan hasil ranking (bisa diakses siapa saja yang auth)
    Route::get('/awards/ranking', [PenilaianController::class, 'showRanking'])->name('awards.ranking');

    Route::post('/awards/save-ranking', [PenilaianController::class, 'saveRanking'])->name('penilaian.save_ranking');

    // Export PDF riwayat ranking & detail riwayat ranking (gabung middleware laporan)
    Route::middleware('permission:laporan')->group(function () {
        // Route paling spesifik dulu
        Route::get('/awards/history/{id}/export-pdf-detail', [App\Http\Controllers\PenilaianController::class, 'exportHistoryDetailPdf'])->name('awards.history.export_pdf_detail');
        Route::get('/awards/history/export-pdf', [App\Http\Controllers\PenilaianController::class, 'exportHistoryPdf'])->name('awards.history.export_pdf');
    });

    Route::get('/awards/history', [PenilaianController::class, 'showRankingHistory'])->name('awards.history');
    Route::get('/awards/history/{batchId}', [PenilaianController::class, 'showRankingDetail'])->name('awards.history.detail');

    // Route Edit & Delete Ranking Batch (Riwayat Ranking)
    Route::middleware('permission:penilaian')->group(function () {
        Route::get('/awards/history/{batchId}/edit', [PenilaianController::class, 'editRankingBatch'])->name('awards.history.edit');
        Route::put('/awards/history/{batchId}', [PenilaianController::class, 'updateRankingBatch'])->name('awards.history.update');
        Route::delete('/awards/history/{batchId}', [PenilaianController::class, 'destroyRankingBatch'])->name('awards.history.destroy');
    });

    // Route ManajerProyek
    Route::get('manajer-proyeks', [App\Http\Controllers\ManajerProyekController::class, 'index'])->name('manajer-proyeks.index');
    Route::middleware('permission:data_manajer_proyek')->group(function () {
        Route::get('manajer-proyeks/create', [App\Http\Controllers\ManajerProyekController::class, 'create'])->name('manajer-proyeks.create');
        Route::post('manajer-proyeks', [App\Http\Controllers\ManajerProyekController::class, 'store'])->name('manajer-proyeks.store');
        Route::get('manajer-proyeks/{manajer_proyek}/edit', [App\Http\Controllers\ManajerProyekController::class, 'edit'])->name('manajer-proyeks.edit');
        Route::put('manajer-proyeks/{manajer_proyek}', [App\Http\Controllers\ManajerProyekController::class, 'update'])->name('manajer-proyeks.update');
        Route::delete('manajer-proyeks/{manajer_proyek}', [App\Http\Controllers\ManajerProyekController::class, 'destroy'])->name('manajer-proyeks.destroy');
    });

    // Route JenisProyek
    Route::get('jenis-proyeks', [App\Http\Controllers\JenisProyekController::class, 'index'])->name('jenis-proyeks.index');
    Route::middleware('permission:data_jenis_proyek')->group(function () {
        Route::get('jenis-proyeks/create', [App\Http\Controllers\JenisProyekController::class, 'create'])->name('jenis-proyeks.create');
        Route::post('jenis-proyeks', [App\Http\Controllers\JenisProyekController::class, 'store'])->name('jenis-proyeks.store');
        Route::get('jenis-proyeks/{jenis_proyek}/edit', [App\Http\Controllers\JenisProyekController::class, 'edit'])->name('jenis-proyeks.edit');
        Route::put('jenis-proyeks/{jenis_proyek}', [App\Http\Controllers\JenisProyekController::class, 'update'])->name('jenis-proyeks.update');
        Route::delete('jenis-proyeks/{jenis_proyek}', [App\Http\Controllers\JenisProyekController::class, 'destroy'])->name('jenis-proyeks.destroy');
    });

    // Route Role
    Route::resource('roles', App\Http\Controllers\RoleController::class);

});

require __DIR__.'/auth.php';
