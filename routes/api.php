<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrabajoController;
use App\Http\Controllers\SimulacionController;

use App\Http\Controllers\UsuarioController;

Route::get('/trabajos', [TrabajoController::class, 'index']);
Route::get('/trabajos/estado/{estado}', [TrabajoController::class, 'porEstado']);

Route::get('/usuarios', [UsuarioController::class, 'index']);

Route::post('/simulacion/procesar', [SimulacionController::class, 'procesar']);
Route::get('/simulacion/estado', [SimulacionController::class, 'estado']);

