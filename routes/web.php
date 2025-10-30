<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\TareaController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Resource Routes
    Route::resource('materias', MateriaController::class);
    Route::resource('tareas', TareaController::class);
    
    // Rutas adicionales para tareas
    Route::post('/tareas/{tarea}/completar', [TareaController::class, 'completar'])->name('tareas.completar');
    Route::post('/tareas/{tarea}/pendiente', [TareaController::class, 'marcarPendiente'])->name('tareas.pendiente');
});

