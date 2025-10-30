<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        
        // Obtener estadísticas
        $totalTareas = $user->tareas()->count();
        $tareasCompletadas = $user->tareas()->where('estado', 'completada')->count();
        $tareasPendientes = $user->tareas()->where('estado', 'pendiente')->count();
        $totalMaterias = $user->materias()->count();

        return view('profile.edit', compact(
            'totalTareas',
            'tareasCompletadas',
            'tareasPendientes',
            'totalMaterias'
        ));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update($request->only('name', 'email'));

        return redirect()->route('profile.edit')
            ->with('success', 'Perfil actualizado correctamente.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.edit')
            ->with('success', 'Contraseña actualizada correctamente.');
    }
}