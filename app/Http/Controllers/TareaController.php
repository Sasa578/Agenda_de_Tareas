<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\Materia;
use App\Models\Recordatorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tareas = Tarea::with('materia')
            ->where('user_id', Auth::id())
            ->orderBy('fecha_entrega', 'asc')
            ->get();

        $materias = Materia::where('user_id', Auth::id())->get();

        return view('tareas.index', compact('tareas', 'materias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $materias = Materia::where('user_id', Auth::id())->get();
        return view('tareas.create', compact('materias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        // Crear recordatorio automático si se solicita
        if ($request->has('crear_recordatorio') && $request->crear_recordatorio) {
            Recordatorio::create([
                'mensaje' => "Recordatorio: {$tarea->titulo}",
                'fecha_recordatorio' => $request->fecha_recordatorio ?? $tarea->fecha_entrega->subHours(24),
                'tarea_id' => $tarea->id,
                'user_id' => Auth::id(),
            ]);
        }

        return redirect()->route('tareas.index')
            ->with('success', 'Tarea creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarea $tarea)
    {
        // Verificar que el usuario es dueño de la tarea
        if ($tarea->user_id !== Auth::id()) {
            abort(403);
        }

        $recordatorios = $tarea->recordatorios()->orderBy('fecha_recordatorio', 'asc')->get();

        return view('tareas.show', compact('tarea', 'recordatorios'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarea $tarea)
    {
        // Verificar que el usuario es dueño de la tarea
        if ($tarea->user_id !== Auth::id()) {
            abort(403);
        }

        $materias = Materia::where('user_id', Auth::id())->get();

        return view('tareas.edit', compact('tarea', 'materias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarea $tarea)
    {
        // Verificar que el usuario es dueño de la tarea
        if ($tarea->user_id !== Auth::id()) {
            abort(403);
        }

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

        $tarea->update($request->all());

        return redirect()->route('tareas.index')
            ->with('success', 'Tarea actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarea $tarea)
    {
        // Verificar que el usuario es dueño de la tarea
        if ($tarea->user_id !== Auth::id()) {
            abort(403);
        }

        $tarea->delete();

        return redirect()->route('tareas.index')
            ->with('success', 'Tarea eliminada exitosamente.');
    }

    /**
     * Marcar tarea como completada.
     */
    public function completar(Tarea $tarea)
    {
        // Verificar que el usuario es dueño de la tarea
        if ($tarea->user_id !== Auth::id()) {
            abort(403);
        }

        $tarea->update(['estado' => 'completada']);

        return redirect()->back()
            ->with('success', 'Tarea marcada como completada.');
    }

    /**
     * Marcar tarea como pendiente.
     */
    public function marcarPendiente(Tarea $tarea)
    {
        // Verificar que el usuario es dueño de la tarea
        if ($tarea->user_id !== Auth::id()) {
            abort(403);
        }

        $tarea->update(['estado' => 'pendiente']);

        return redirect()->back()
            ->with('success', 'Tarea marcada como pendiente.');
    }

    /**
     * Cambiar estado de la tarea via AJAX.
     */
    public function cambiarEstado(Request $request, Tarea $tarea)
    {
        // Verificar que el usuario es dueño de la tarea
        if ($tarea->user_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $request->validate([
            'estado' => 'required|in:pendiente,en_progreso,completada'
        ]);

        $tarea->update(['estado' => $request->estado]);

        return response()->json([
            'success' => true,
            'nuevo_estado' => $request->estado
        ]);
    }
}