<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificacionController;

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

    //Profile
    Route::prefix('user/profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    });

    // Notificaciones
    Route::prefix('notificaciones')->group(function () {
        Route::get('/', [NotificacionController::class, 'index'])->name('notificaciones.index');
        Route::post('/{id}/read', [NotificacionController::class, 'markAsRead'])->name('notificaciones.markRead');
        Route::post('/mark-all-read', [NotificacionController::class, 'markAllAsRead'])->name('notificaciones.markAllRead');
        Route::delete('/{id}', [NotificacionController::class, 'destroy'])->name('notificaciones.destroy');
        Route::delete('/', [NotificacionController::class, 'clearAll'])->name('notificaciones.clearAll');
        Route::get('/unread-count', [NotificacionController::class, 'getUnreadCount'])->name('notificaciones.unreadCount');
        Route::get('/latest', [NotificacionController::class, 'getNotifications'])->name('notificaciones.latest');
    });

    Route::get('/eventos/{tarea}', [CalendarioController::class, 'showEvento'])->name('calendario.mostrar');
});

// Las rutas de autenticación deben estar al final
require __DIR__ . '/auth.php';