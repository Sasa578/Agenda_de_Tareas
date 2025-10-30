<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarioController extends Controller
{
    public function index()
    {
        return view('calendario.index');
    }

    public function eventos(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');

        $tareas = Tarea::with('materia')
            ->where('user_id', Auth::id())
            ->calendario($start, $end)
            ->get();

        $eventos = $tareas->map(function ($tarea) {
            return $tarea->toCalendarEvent();
        });

        return response()->json($eventos);
    }

    public function crearEvento(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'fecha_entrega' => 'required|date',
            'fecha_inicio' => 'nullable|date',
            'todo_el_dia' => 'boolean',
            'materia_id' => 'nullable|exists:materias,id',
            'prioridad' => 'required|in:baja,media,alta',
        ]);

        $tarea = Tarea::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_entrega' => $request->fecha_entrega,
            'fecha_inicio' => $request->fecha_inicio,
            'todo_el_dia' => $request->todo_el_dia ?? false,
            'ubicacion' => $request->ubicacion,
            'prioridad' => $request->prioridad,
            'materia_id' => $request->materia_id,
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'evento' => $tarea->toCalendarEvent()
        ]);
    }

    public function actualizarEvento(Request $request, Tarea $tarea)
    {
        // Verificar que el usuario es dueño de la tarea
        if ($tarea->user_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $request->validate([
            'fecha_entrega' => 'required|date',
            'fecha_inicio' => 'nullable|date',
            'todo_el_dia' => 'boolean',
        ]);

        $tarea->update([
            'fecha_entrega' => $request->fecha_entrega,
            'fecha_inicio' => $request->fecha_inicio,
            'todo_el_dia' => $request->todo_el_dia ?? false,
        ]);

        return response()->json([
            'success' => true,
            'evento' => $tarea->toCalendarEvent()
        ]);
    }
}