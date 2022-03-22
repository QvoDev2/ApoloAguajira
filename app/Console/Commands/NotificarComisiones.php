<?php

namespace App\Console\Commands;

use App\Models\Comision;
use App\Models\Lista;
use App\Models\Perfil;
use App\Models\VComision;
use App\Notifications\ComisionesFinalizadas;
use App\Notifications\FinComision;
use App\Notifications\InicioComision;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class NotificarComisiones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificar:comisiones';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifica a las usuarios por zona, las comisiones finalizadas sin verificar';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Lista::zonas()->each(function ($zona) {
            $comisiones = $zona->comisiones()
                ->where('estado', Comision::ESTADO_FINALIZADO)
                ->pluck('numero')
                ->toArray();
            $correos = $zona->usuarios()
                ->where('perfil_id', Perfil::UT)
                ->pluck('email')
                ->toArray();
            if ($comisiones)
                Notification::route('mail', $correos)
                    ->notify(new ComisionesFinalizadas($comisiones, $zona));
        });

        Comision::whereDate('fecha_inicio', date('Y-m-d'))
            ->each(function ($comision) {
                if ($usuario = $comision->escolta->usuario ?? null)
                    $usuario->notify(new InicioComision($comision, $usuario));
            });

        VComision::whereDate('fecha_fin', date('Y-m-d'))
            ->whereIn('estado', [Comision::ESTADO_ASIGNADO, Comision::ESTADO_EN_CURSO])
            ->each(function ($comision) {
                if ($usuario = $comision->escolta->usuario ?? null)
                    $usuario->notify(new FinComision($comision, $usuario));
            });
    }
}
