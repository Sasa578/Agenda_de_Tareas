<?php

namespace App\Notifications;

use App\Models\Tarea;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TareaRecordatorio extends Notification implements ShouldQueue
{
    use Queueable;

    public $tarea;

    public function __construct(Tarea $tarea)
    {
        $this->tarea = $tarea;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $fechaEntrega = $this->tarea->fecha_entrega->format('d/m/Y H:i');
        $url = url('/tareas/' . $this->tarea->id);

        return (new MailMessage)
            ->subject('🔔 Recordatorio de Tarea: ' . $this->tarea->titulo)
            ->greeting('Hola ' . $notifiable->name . '!')
            ->line('Tienes una tarea próxima a vencer:')
            ->line('**' . $this->tarea->titulo . '**')
            ->line('**Fecha de entrega:** ' . $fechaEntrega)
            ->line('**Materia:** ' . ($this->tarea->materia->nombre ?? 'Sin materia'))
            ->line('**Prioridad:** ' . ucfirst($this->tarea->prioridad))
            ->action('Ver Tarea', $url)
            ->line('¡No olvides completarla a tiempo!')
            ->salutation('Saludos, Agenda Universitaria');
    }

    public function toArray($notifiable)
    {
        return [
            'tarea_id' => $this->tarea->id,
            'titulo' => $this->tarea->titulo,
            'mensaje' => 'Tarea próxima: ' . $this->tarea->titulo,
            'fecha_entrega' => $this->tarea->fecha_entrega->toDateTimeString(),
            'tipo' => 'recordatorio',
            'url' => '/tareas/' . $this->tarea->id,
        ];
    }
}