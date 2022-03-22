<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FinComision extends Notification
{
    use Queueable;

    public function __construct($comision, $usuario)
    {
        $this->comision = $comision;
        $this->usuario = $usuario;
    }

    public function via()
    {
        return ['mail'];
    }

    public function toMail()
    {
        return (new MailMessage)
            ->subject('Recordatorio finalización comisión')
            ->line("Señor(a) {$this->usuario->nombre_completo} recuerde que la comisión #{$this->comision->numero} finaliza hoy");
    }
}
