<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TrabajoController;
use App\Http\Controllers\ReglaController;
use App\Http\Controllers\TipoServidorController;
use App\Http\Controllers\ServidorDedicadoController;
use App\Http\Controllers\ServidorSoftwareController;
use App\Http\Controllers\ServidorIntegradoController;
use App\Http\Controllers\ServidorCloudController;
use App\Http\Controllers\ServidorCupsController;
use App\Http\Controllers\ServidorLprController;

// Página de selección de tipo de servidor
Route::get('/', [TipoServidorController::class, 'index'])->name('tipo-servidor.index');

// Dashboard original (ahora como "Servidor Básico")
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Módulos de diferentes tipos de servidores
Route::prefix('servidor')->name('servidor.')->group(function () {
    Route::get('/dedicado', [ServidorDedicadoController::class, 'index'])->name('dedicado');
    Route::get('/software', [ServidorSoftwareController::class, 'index'])->name('software');
    Route::get('/integrado', [ServidorIntegradoController::class, 'index'])->name('integrado');
    Route::get('/cloud', [ServidorCloudController::class, 'index'])->name('cloud');
    Route::get('/cups', [ServidorCupsController::class, 'index'])->name('cups');
    Route::get('/lpr', [ServidorLprController::class, 'index'])->name('lpr');
});

Route::prefix('trabajos')->name('trabajos.')->group(function () {
    Route::get('/create', [TrabajoController::class, 'create'])->name('create');
    Route::post('/store', [TrabajoController::class, 'store'])->name('store');
});

Route::prefix('reglas')->name('reglas.')->group(function () {
    Route::get('/', [ReglaController::class, 'index'])->name('index');
    Route::get('/create', [ReglaController::class, 'create'])->name('create');
    Route::post('/store', [ReglaController::class, 'store'])->name('store');
    Route::get('/{regla}/edit', [ReglaController::class, 'edit'])->name('edit');
    Route::put('/{regla}', [ReglaController::class, 'update'])->name('update');
    Route::delete('/{regla}', [ReglaController::class, 'destroy'])->name('destroy');
});

