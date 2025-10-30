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
        
        $tareasPendientes = Tarea::with('materia')
            ->where('user_id', $user->id)
            ->pendientes()
            ->orderBy('fecha_entrega', 'asc')
            ->limit(10)
            ->get();

        $tareasProximas = Tarea::with('materia')
            ->where('user_id', $user->id)
            ->proximas()
            ->orderBy('fecha_entrega', 'asc')
            ->get();

        $materiasCount = Materia::where('user_id', $user->id)->count();
        $tareasCount = Tarea::where('user_id', $user->id)->count();
        $tareasPendientesCount = Tarea::where('user_id', $user->id)->pendientes()->count();

        return view('dashboard', compact(
            'tareasPendientes',
            'tareasProximas',
            'materiasCount',
            'tareasCount',
            'tareasPendientesCount'
        ));
    }
}