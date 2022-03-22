<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerificadoComision extends Notification
{
    use Queueable;

    public function __construct($comision, $observaciones)
    {
        $this->comision = $comision;
        $this->observaciones = $observaciones;
    }

    public function via()
    {
        return ['mail'];
    }

    public function toMail()
    {
        return (new MailMessage)
            ->subject('Comisión verificada UT')
            ->line("<b>¡Hola {$this->comision->escolta->usuario->nombre_completo}!</b>")
            ->line("La comisión {$this->comision->numero} fue verificada por UT.")
            ->line("
                <b>Número de aprobación:</b> {$this->comision->numero} <br>
                <b>Fecha de inicio:</b> ".date('d/m/Y', strtotime($this->comision->fecha_inicio))." <br>
                <b>Fecha final:</b> ".date('d/m/Y', strtotime($this->comision->fecha_fin))." <br>
                <b>Días aprobados:</b> {$this->comision->dias_aprobados} <br>
                <b>Días legalizados:</b> {$this->comision->dias_reales} <br>
                <b>Reportes realizados:</b> {$this->comision->reportes->count()} <br>
                <b>Destinos:</b> " . implode(', ', $this->comision->puntosControl()->whereHas('reportes')->pluck('lugar')->toArray()) . " <br>
                <b>Observaciones:</b> {$this->observaciones}
            ")
            ->cc('soporte@qvo.com.co');
    }
}
