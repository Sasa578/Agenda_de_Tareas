<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materias = Materia::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('materias.index', compact('materias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('materias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50|unique:materias',
            'color' => 'required|string|max:7',
            'descripcion' => 'nullable|string',
        ]);

        Materia::create([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'color' => $request->color,
            'descripcion' => $request->descripcion,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('materias.index')
            ->with('success', 'Materia creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Materia $materia)
    {
        // Verificar que el usuario es dueño de la materia
        if ($materia->user_id !== Auth::id()) {
            abort(403);
        }

        $tareas = $materia->tareas()
            ->orderBy('fecha_entrega', 'asc')
            ->get();

        return view('materias.show', compact('materia', 'tareas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Materia $materia)
    {
        // Verificar que el usuario es dueño de la materia
        if ($materia->user_id !== Auth::id()) {
            abort(403);
        }

        return view('materias.edit', compact('materia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materia $materia)
    {
        // Verificar que el usuario es dueño de la materia
        if ($materia->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50|unique:materias,codigo,' . $materia->id,
            'color' => 'required|string|max:7',
            'descripcion' => 'nullable|string',
        ]);

        $materia->update($request->all());

        return redirect()->route('materias.index')
            ->with('success', 'Materia actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materia $materia)
    {
        // Verificar que el usuario es dueño de la materia
        if ($materia->user_id !== Auth::id()) {
            abort(403);
        }

        $materia->delete();

        return redirect()->route('materias.index')
            ->with('success', 'Materia eliminada exitosamente.');
    }
}