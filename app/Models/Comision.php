<?php

namespace App\Models;

use App\Notifications\CreacionComision;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comision extends Model
{
    protected $table = 'comisiones';

    const SIN_COMPLETAR = 0;
    const ESTADO_ASIGNADO = 1;
    const ESTADO_EN_CURSO = 2;
    const ESTADO_CANCELADO = 3;
    const ESTADO_FINALIZADO = 4;
    const ESTADO_VERIFICADO_UT = 5;
    const ESTADO_NOVEDAD = 6;
    const ESTADO_APROBADO = 7;
    const ESTADO_RECHAZADO = 8;
    const SOLO_DESPLAZAMIENTO = 9;

    public const ESTADOS = [
        self::SIN_COMPLETAR        => 'SIN COMPLETAR',
        self::ESTADO_ASIGNADO      => 'ASIGNADO',
        self::ESTADO_EN_CURSO      => 'EN CURSO',
        self::ESTADO_CANCELADO     => 'CANCELADO',
        self::ESTADO_FINALIZADO    => 'FINALIZADO',
        self::ESTADO_VERIFICADO_UT => 'VERIFICADO UT',
        self::ESTADO_NOVEDAD       => 'NOVEDAD',
        self::ESTADO_APROBADO      => 'APROBADO UNP',
        self::ESTADO_RECHAZADO     => 'RECHAZADO UNP',
        self::SOLO_DESPLAZAMIENTO  => 'SOLO DESPLAZAMIENTO'
    ];

    public const ACCIONES = [
        self::ESTADO_ASIGNADO => [
            // [
            //     'estado' => self::ESTADO_EN_CURSO,
            //     'accion' => 'Colocar en curso',
            //     'color' => 'success',
            //     'icono' => 'fa fa-check'
            // ],
            [
                'estado' => self::ESTADO_CANCELADO,
                'accion' => 'Cancelar',
                'color' => 'danger',
                'icono' => 'fa fa-times'
            ]
        ],
        self::ESTADO_EN_CURSO => [
            // [
            //     'estado' => self::ESTADO_FINALIZADO,
            //     'accion' => 'Finalizar',
            //     'color' => 'success',
            //     'icono' => 'fa fa-check'
            // ]
        ],
        self::ESTADO_CANCELADO => [
            //* Finaliza
        ],
        self::ESTADO_FINALIZADO => [
            [
                'estado' => self::ESTADO_VERIFICADO_UT,
                'accion' => 'Verificar UT',
                'color' => 'success',
                'icono' => 'fa fa-check',
                'funcion' => 'verificarComision'
            ]
        ],
        self::ESTADO_VERIFICADO_UT => [
            [
                'estado' => self::ESTADO_NOVEDAD,
                'accion' => 'Reportar novedad',
                'color' => 'warning',
                'icono' => 'fas fa-clipboard-list'
            ],
            [
                'estado' => self::ESTADO_APROBADO,
                'accion' => 'Aprobar',
                'color' => 'success',
                'icono' => 'fa fa-check',
                'perfiles' => [1, 3]
            ],
            [
                'estado' => self::ESTADO_RECHAZADO,
                'accion' => 'Rechazado',
                'color' => 'danger',
                'icono' => 'fa fa-times',
                'perfiles' => [1, 3],
                'funcion' => 'rechazar'
            ]
        ],
        self::ESTADO_NOVEDAD => [
            [
                'estado' => self::ESTADO_NOVEDAD,
                'accion' => 'Reportar novedad',
                'color' => 'warning',
                'icono' => 'fas fa-clipboard-list',
                'funcion' => 'adicionarNovedad'
            ],
            [
                'estado' => self::ESTADO_APROBADO,
                'accion' => 'Aprobar',
                'color' => 'success',
                'icono' => 'fa fa-check'
            ],
            [
                'estado' => self::ESTADO_RECHAZADO,
                'accion' => 'Rechazado',
                'color' => 'danger',
                'icono' => 'fa fa-times'
            ]
        ],
        self::ESTADO_APROBADO => [
            //* Finaliza
        ],
        self::ESTADO_RECHAZADO => [
            //* Finaliza
        ],
        self::SOLO_DESPLAZAMIENTO => [
            //* Finaliza
        ]
    ];

    public $hidden = [
        'pivot'
    ];

    public $fillable = [
        'paso_creacion',
        'numero',
        'fecha_aprobacion_correo',
        'fecha_inicio',
        'fecha_fin',
        'tipo',
        'valor_x_dia',
        'observaciones',
        'cliente_id',
        'usuario_id',
        'dias_aprobados',
        'dias_reales',
        'created_at',
        'ciudad_id',
        'origen',
        'tipo_desplazamiento_id',
        'viajero',
        'zona_id',
    ];

    protected $casts = [
        'id'                      => 'integer',
        'tipo'                    => 'integer',
        'paso_creacion'           => 'integer',
        'numero'                  => 'string',
        'valor_x_dia'             => 'double',
        'observaciones'           => 'string',
        'cliente_id'              => 'integer',
        'usuario_id'              => 'integer',
        'fecha_aprobacion_correo' => 'date_format:Y-m-d',
        'fecha_inicio'            => 'date_format:Y-m-d',
        'fecha_fin'               => 'date_format:Y-m-d',
        'dias_aprobados'          => 'double',
        'dias_reales'             => 'double',
        'origen'                  => 'string',
        'tipo_desplazamiento_id'  => 'integer',
        'viajero'                 => 'string',
        'zona_id'                 => 'integer',
    ];

    public function getAccionesAttribute()
    {
        return self::ACCIONES[$this->estado];
    }

    public function getPosiblesEstadosAttribute()
    {
        return array_map(function ($i) {
            return $i['estado'];
        }, $this->acciones);
    }

    public function getEstadoAttribute()
    {
        return $this->estados()->first()->estado ?? 0;
    }

    public function getEstadoTextoAttribute()
    {
        return self::ESTADOS[$this->estado];
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function vehiculosEscoltas()
    {
        return $this->hasMany(VehiculoEscolta::class, 'comision_id');
    }

    public function escoltas()
    {
        return $this->belongsToMany(Escolta::class, 'vehiculos_escoltas', 'comision_id', 'escolta_id');
    }

    public function getEscoltaAttribute()
    {
        return $this->escoltas()->first();
    }

    public function puntosControl()
    {
        return $this->hasMany(PuntoControl::class, 'comision_id');
    }

    public function medioDesplazamiento()
    {
        return $this->belongsTo(Lista::class, 'tipo_desplazamiento_id');
    }

    public function getPuntosControlSinReporteAttribute()
    {
        return $this->puntosControl()
            ->whereDoesntHave('reportes')
            ->pluck('lugar', 'id')
            ->toArray();
    }

    public function estados()
    {
        return $this->hasMany(EstadoComision::class, 'comision_id')
            ->orderBy('created_at', 'DESC')
            ->orderBy('id', 'DESC');
    }

    public function estadosEliminados()
    {
        return $this->hasMany(EstadoEliminado::class, 'comision_id');
    }

    public function reportes()
    {
        return $this->hasMany(ReportePunto::class, 'comision_id');
    }

    public function getReportesOrdenadosAttribute()
    {
        return $this->puntosControl()
            ->select('reportes_puntos_control.*', 'puntos_control.lugar', 'puntos_control.departamento_id', 'puntos_control.longitud as lonPunto', 'puntos_control.latitud as latPunto', 'puntos_control.radio as radioPunto')
            ->leftJoin('reportes_puntos_control', 'puntos_control.id', 'reportes_puntos_control.punto_control_id')
            ->orderBy('reportes_puntos_control.fecha_reporte', 'DESC')
            ->get();
    }

    public function getReportesSinPuntoAttribute()
    {
        return $this->reportes()->whereNull('punto_control_id')->get();
    }

    public function replicar()
    {
        $cnt = 0;
        foreach ($this->vehiculosEscoltas as $escolta) {
            if ($cnt == 0) {
                $cnt++;
                $this->update(['numero' => $escolta->codigo_autorizacion]);
                if ($usuario = (Escolta::find($escolta->escolta_id)->usuario ?? null))
                    if ($this->tipo != 1) $usuario->notify(new CreacionComision($this, $usuario));
                continue;
            }
            $clone = $this->replicate();
            $this->relations = [];
            $this->load('puntosControl', 'estados');
            $clone->numero = $escolta->codigo_autorizacion;
            $clone->push();
            foreach ($this->relations as $relationName => $values)
                $clone->{$relationName}()->createMany($values->toArray());
            $escolta->update(['comision_id' => $clone->id]);
            if ($usuario = (Escolta::find($escolta->escolta_id)->usuario ?? null))
                if ($this->tipo != 1) $usuario->notify(new CreacionComision($clone, $usuario));
            $cnt++;
        }
    }

    public function existeEstado($estado)
    {
        return $this->estados()
            ->where('estado', $estado)
            ->get()
            ->count() > 0;
    }

    public function getEstado($estado)
    {
        return $this->estados()
            ->where('estado', $estado)
            ->first();
    }

    public function getFechaReporte($tipo)
    {
        return $this->reportes()
            ->whereNotNull('punto_control_id')
            ->{$tipo}('fecha_reporte');
    }

    public function validarEstado($request)
    {
        if (!$this->existeEstado(self::ESTADO_EN_CURSO)) {
            $estado = $this->estados()->create([
                'observaciones' => $request->observaciones,
                'estado'        => self::ESTADO_EN_CURSO,
                'usuario_id'    => $this->escolta->usuario->id ?? auth()->user()->id,
            ]);
            $estado->created_at = $request->fecha_reporte;
            $estado->update();
        } else {
            $estado = $this->getEstado(self::ESTADO_EN_CURSO);
            $estado->created_at = $this->getFechaReporte('min');
            $estado->update();
        }
        if ($this->existeEstado(self::ESTADO_FINALIZADO)) {
            $estado = $this->getEstado(self::ESTADO_FINALIZADO);
            $estado->created_at = $this->getFechaReporte('max');
            $estado->update();
        }
    }

    public function getNovedadesAttribute()
    {
        return $this
            ->estados()
            ->where('estado', self::ESTADO_NOVEDAD)
            ->get();
    }

    public function recalcularFechas()
    {
        if ($this->existeEstado(self::ESTADO_EN_CURSO)) {
            $estado = $this->getEstado(self::ESTADO_EN_CURSO);
            $estado->created_at = $this->getFechaReporte('min');
            $estado->update();
        } else {
            $estado = $this->estados()->create([
                'observaciones' => '',
                'estado'        => self::ESTADO_EN_CURSO,
                'usuario_id'    => $this->escolta->usuario->id ?? auth()->user()->id,
            ]);
            $estado->created_at = $this->getFechaReporte('min');
            $estado->update();
        }
        if ($this->existeEstado(self::ESTADO_FINALIZADO)) {
            $estado = $this->getEstado(self::ESTADO_FINALIZADO);
            $estado->created_at = $this->getFechaReporte('max');
            $estado->update();
        }
    }

    public function zona()
    {
        return $this->belongsTo(Lista::class, 'zona_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'comision_id');
    }

    public function devoluciones()
    {
        return $this->hasMany(Devolucion::class, 'comision_id');
    }

    public function getNochesPernoctadasAttribute()
    {
        $noches = 0;
        $result = DB::select("WITH datos (fecha, agrupacion) AS (
            select date_format(fecha_reporte, '%Y-%m-%d') fecha,
            date_add(date_format(fecha_reporte, '%Y-%m-%d'), interval -ROW_NUMBER() OVER (
                ORDER BY date_format(fecha_reporte, '%Y-%m-%d')
            ) DAY) FROM reportes_puntos_control where comision_id=$this->id and punto_control_id IS NOT NULL
            group by date_format(fecha_reporte, '%Y-%m-%d')
            ORDER BY fecha_reporte
        ) select if(min(fecha)=max(fecha), 0.5, datediff(max(fecha), min(fecha))) as noches
        FROM datos
        GROUP BY agrupacion");

        foreach ($result as $value) {
            $noches += $value->noches;
        }
        return $noches;
    }
}
