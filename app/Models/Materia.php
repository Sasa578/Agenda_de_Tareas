<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'codigo',
        'color',
        'descripcion',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class);
    }

    public function tareasPendientes()
    {
        return $this->hasMany(Tarea::class)->where('estado', 'pendiente');
    }
}