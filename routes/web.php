<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MainController;

// Ruta para la página de inicio
Route::get('/', [MainController::class, 'index'])->name('app_homepage');

// Ruta para terminar el confinamiento
Route::post('/lockdown/end', [MainController::class, 'endLockDown'])->name('app_lockdown_end');
