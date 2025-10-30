<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recordatorio extends Model
{
    use HasFactory;

    protected $fillable = [
        'mensaje',
        'fecha_recordatorio',
        'enviado',
        'tarea_id',
        'user_id'
    ];

    protected $casts = [
        'fecha_recordatorio' => 'datetime',
        'enviado' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tarea()
    {
        return $this->belongsTo(Tarea::class);
    }
}