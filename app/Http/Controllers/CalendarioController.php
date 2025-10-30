<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarioController extends Controller
{
    public function index()
    {
        // Obtener las materias del usuario para el formulario
        $materias = Materia::where('user_id', Auth::id())->get();
        return view('calendario.index', compact('materias'));
    }

    public function eventos(Request $request)
    {
        $tareas = Tarea::with('materia')
            ->where('user_id', Auth::id())
            ->get();

        $eventos = $tareas->map(function ($tarea) {
            return [
                'id' => $tarea->id,
                'titulo' => $tarea->titulo,
                'descripcion' => $tarea->descripcion,
                'start' => $tarea->fecha_entrega->toISOString(),
                'prioridad' => $tarea->prioridad,
                'materia' => $tarea->materia ? $tarea->materia->nombre : 'Sin materia',
                'color' => $tarea->materia ? $tarea->materia->color : '#007bff'
            ];
        });

        return response()->json($eventos);
    }

    public function crearEvento(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_entrega' => 'required|date',
            'fecha_inicio' => 'nullable|date',
            'prioridad' => 'required|in:baja,media,alta',
            'materia_id' => 'required|exists:materias,id',
            'ubicacion' => 'nullable|string|max:255',
            'todo_el_dia' => 'boolean',
        ]);

        // Verificar que la materia pertenece al usuario
        $materia = Materia::where('id', $request->materia_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $tarea = Tarea::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_entrega' => $request->fecha_entrega,
            'fecha_inicio' => $request->fecha_inicio,
            'prioridad' => $request->prioridad,
            'materia_id' => $request->materia_id,
            'ubicacion' => $request->ubicacion,
            'todo_el_dia' => $request->todo_el_dia ?? false,
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tarea creada exitosamente',
            'evento' => $tarea->load('materia')->toCalendarEvent()
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

    // Agregar este método al controlador existente
    public function showEvento(Tarea $tarea)
    {
        // Verificar que el usuario es dueño de la tarea
        if ($tarea->user_id !== Auth::id()) {
            abort(403);
        }

        return response()->json([
            'evento' => $tarea->toCalendarEvent(),
            'tarea' => [
                'descripcion' => $tarea->descripcion,
                'prioridad' => $tarea->prioridad,
                'estado' => $tarea->estado,
                'materia' => $tarea->materia->nombre ?? 'Sin materia',
                'ubicacion' => $tarea->ubicacion,
                'edit_url' => route('tareas.edit', $tarea),
                'view_url' => route('tareas.show', $tarea)
            ]
        ]);
    }


}