<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreacionComision extends Notification
{
    use Queueable;

    public function __construct($comision, $usuario)
    {
        $this->comision = $comision;
        $this->usuario = $usuario;
        if ($comision->zona_id == 1240 || $comision->zona_id == 1241) {
            $this->textoAdicional = "Señor(a) Escolta, por favor recuerde los siguientes aspectos que la UT EXCELLENCE 2022 CONTRATOS 996 Y 993 DE 2022 hace con respecto a su desplazamiento:  <br><br>
            1.	A partir del 01 de febrero del 2022 usted debe hacer un reporte cada día durante la vigencia de su comisión.  <br>
            2.	Si en su desplazamiento está autorizado un destino que no supera los 100 km con respecto a la ciudad de origen del esquema, los reportes que allí realice, no aplicarán para Gastos Reembolsables de acuerdo a lo estipulado en el Anexo Técnico N° 5 a menos que reporten en los demás destinos autorizados y tengan un registro cada 12 horas en la aplicación. <br>
            3.	Que los Gastos Reembolsables de los desplazamientos que no superen los 50 km de distancia con respecto a la ciudad de origen solo aplican para los esquemas pertenecientes a Cauca, Valle del Cauca y Nariño zonas abarcadas por esta UT. <br>
            4.	Que de no cumplirse con los protocolos establecidos por la Unidad Nacional de Protección para el proceso de Legalización de Gastos Reembolsables (reporte diario, reporte dentro del rango de fechas y destinos autorizados por la entidad y el reconocimiento facial) deberá hacer el reintegro de los recursos girados por la Unión Temporal en un lapso de 3 días hábiles una vez notificado. <br>
            5.	Con respecto al punto anterior, que de no hacer el debido reintegro de los recursos una vez notificado, la Unión Temporal solicitará se le aplique el descuento por usted autorizado en su contrato de trabajo y se ajustarán los saldos mediante descuento de nómina.";
        } else {
            $this->textoAdicional = "Señor Escolta, recuerde que si en su desplazamiento está autorizado un destino que no supera los 100 km con respecto a la ciudad de origen del esquema, los reportes que allí realice, no aplicarán para Gastos Reembolsables de acuerdo a lo estipulado en el Anexo Ténico N°5 a menos que reporten en los demas destinos autorizados y tengan un registro diario en la aplicación";
        }
    }

    public function via()
    {
        return ['mail'];
    }

    public function toMail()
    {
        return (new MailMessage)
            ->subject("Comisión asignada #{$this->comision->numero}")
            ->line("Señor(a) {$this->comision->escolta->usuario->nombre_completo} se le ha asignado la comisión #{$this->comision->numero}")
            ->line("
                <b>Fecha de inicio:</b> " . date('d/m/Y', strtotime($this->comision->fecha_inicio)) . " <br>
                <b>Fecha final:</b> " . date('d/m/Y', strtotime($this->comision->fecha_fin)) . " <br>
                <b>Medio desplazamiento:</b> ". $this->comision->medioDesplazamiento->nombre ?? '-' ."<br>
                <b>Días aprobados:</b> {$this->comision->dias_aprobados} <br>
                <b>Observaciones:</b> {$this->comision->observaciones} <br>
                <br>{$this->textoAdicional}
            ")
            ->cc('soporte@qvo.com.co');
    }
}
