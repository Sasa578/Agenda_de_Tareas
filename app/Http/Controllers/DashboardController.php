<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;

        // Corregir las consultas usando los scopes correctos
        $tareasPendientes = Tarea::with('materia')
            ->where('user_id', $userId)
            ->where('estado', 'pendiente') // Usar where directo en lugar del scope
            ->orderBy('fecha_entrega', 'asc')
            ->limit(10)
            ->get();

        $tareasProximas = Tarea::with('materia')
            ->where('user_id', $userId)
            ->where('fecha_entrega', '>=', now())
            ->where('fecha_entrega', '<=', now()->addDays(7))
            ->orderBy('fecha_entrega', 'asc')
            ->get();

        $materiasCount = Materia::where('user_id', $userId)->count();
        $tareasCount = Tarea::where('user_id', $userId)->count();
        $tareasPendientesCount = Tarea::where('user_id', $userId)
            ->where('estado', 'pendiente')
            ->count();

        return view('dashboard', compact(
            'tareasPendientes',
            'tareasProximas',
            'materiasCount',
            'tareasCount',
            'tareasPendientesCount'
        ));
    }
}