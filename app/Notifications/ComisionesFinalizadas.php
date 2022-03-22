<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ComisionesFinalizadas extends Notification
{
    use Queueable;

    public function __construct($comisiones, $zona)
    {
        $this->comisiones = $comisiones;
        $this->zona = $zona;
    }

    public function via()
    {
        return ['mail'];
    }

    public function toMail()
    {
        return (new MailMessage)
            ->subject("Comisiones sin verificar ({$this->zona->nombre})")
            ->line('<b>¡Hola!</b>')
            ->line("Las siguientes comisiones de {$this->zona->nombre} aún no se han verificado:")
            ->line('<ol><li>'.implode('</li><li>', $this->comisiones).'</li></ol>');
    }
}
