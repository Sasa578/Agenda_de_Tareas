<?php

namespace App\Console\Commands;

use App\Models\Tarea;
use App\Notifications\TareaRecordatorio;
use Illuminate\Console\Command;
use Carbon\Carbon;

class EnviarRecordatorios extends Command
{
    protected $signature = 'recordatorios:enviar';
    protected $description = 'Envía recordatorios de tareas próximas';

    public function handle()
    {
        $now = Carbon::now();
        
        // Tareas que vencen en las próximas 24 horas y no están completadas
        $tareasProximas = Tarea::with(['user', 'materia'])
            ->where('estado', '!=', 'completada')
            ->whereBetween('fecha_entrega', [$now, $now->copy()->addHours(24)])
            ->whereDoesntHave('recordatorios', function($query) use ($now) {
                $query->where('fecha_recordatorio', '>=', $now->copy()->subHours(1));
            })
            ->get();

        foreach ($tareasProximas as $tarea) {
            // Crear recordatorio en la base de datos
            $tarea->recordatorios()->create([
                'mensaje' => "Recordatorio: {$tarea->titulo}",
                'fecha_recordatorio' => $now,
                'enviado' => true,
                'user_id' => $tarea->user_id,
            ]);

            // Enviar notificación
            $tarea->user->notify(new TareaRecordatorio($tarea));
            
            $this->info("Recordatorio enviado para: {$tarea->titulo}");
        }

        $this->info('Total de recordatorios enviados: ' . $tareasProximas->count());
        
        return Command::SUCCESS;
    }
}