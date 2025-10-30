<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\CalendarioController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Materias
    Route::resource('materias', MateriaController::class);
    
    // Tareas
    Route::resource('tareas', TareaController::class);
    Route::post('/tareas/{tarea}/completar', [TareaController::class, 'completar'])->name('tareas.completar');
    Route::post('/tareas/{tarea}/pendiente', [TareaController::class, 'marcarPendiente'])->name('tareas.pendiente');
    Route::post('/tareas/{tarea}/cambiar-estado', [TareaController::class, 'cambiarEstado'])->name('tareas.cambiar-estado');
    
    // Calendario
    Route::prefix('calendario')->group(function () {
        Route::get('/', [CalendarioController::class, 'index'])->name('calendario.index');
        Route::get('/eventos', [CalendarioController::class, 'eventos'])->name('calendario.eventos');
        Route::post('/eventos', [CalendarioController::class, 'crearEvento'])->name('calendario.crear');
        Route::put('/eventos/{tarea}', [CalendarioController::class, 'actualizarEvento'])->name('calendario.actualizar');
    });
});

// Las rutas de autenticación deben estar al final
require __DIR__.'/auth.php';