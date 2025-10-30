<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_entrega',
        'prioridad',
        'estado',
        'materia_id',
        'user_id'
    ];

    protected $casts = [
        'fecha_entrega' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function recordatorios()
    {
        return $this->hasMany(Recordatorio::class);
    }

    // Scope para tareas pendientes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    // Scope para tareas próximas (próximos 7 días)
    public function scopeProximas($query)
    {
        return $query->whereBetween('fecha_entrega', [now(), now()->addDays(7)]);
    }
}