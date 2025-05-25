<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\SubKriteriaController;
use App\Models\SubKriteria;
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
    Route::resource('proyeks', ProyekController::class)->except(['show']);

    // Route Kriteria
    Route::resource('kriterias', KriteriaController::class)->except(['show']);

    // Route Sub-Kriteria
    Route::resource('subkriterias', SubKriteriaController::class)->except(['show']);

});

require __DIR__.'/auth.php';
