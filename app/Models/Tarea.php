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
        'fecha_inicio',
        'todo_el_dia',
        'ubicacion',
        'prioridad',
        'estado',
        'materia_id',
        'user_id'
    ];

    protected $casts = [
        'fecha_entrega' => 'datetime',
        'fecha_inicio' => 'datetime',
        'todo_el_dia' => 'boolean',
    ];

    /**
     * Relaciones
     */
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

    // Scopes para consultas comunes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeProximas($query)
    {
        return $query->where('fecha_entrega', '>=', now())
                    ->where('fecha_entrega', '<=', now()->addDays(7));
    }

    public function scopeDelUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Método para obtener datos en formato de calendario
    public function toCalendarEvent()
    {
        $color = $this->materia ? $this->materia->color : '#007bff';
        
        // Determinar color basado en prioridad si no hay materia
        if (!$this->materia) {
            $color = match($this->prioridad) {
                'alta' => '#dc3545',
                'media' => '#ffc107',
                'baja' => '#28a745',
                default => '#007bff'
            };
        }

        return [
            'id' => $this->id,
            'title' => $this->titulo,
            'start' => $this->todo_el_dia ? $this->fecha_entrega->format('Y-m-d') : $this->fecha_entrega->toISOString(),
            'end' => $this->fecha_inicio ? ($this->todo_el_dia ? $this->fecha_inicio->format('Y-m-d') : $this->fecha_inicio->toISOString()) : null,
            'allDay' => $this->todo_el_dia,
            'color' => $color,
            'extendedProps' => [
                'descripcion' => $this->descripcion,
                'prioridad' => $this->prioridad,
                'estado' => $this->estado,
                'materia' => $this->materia ? $this->materia->nombre : 'Sin materia',
                'ubicacion' => $this->ubicacion,
                'url' => route('tareas.show', $this->id)
            ]
        ];
    }
}