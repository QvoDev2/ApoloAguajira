<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportePunto extends Model
{
    protected $table = 'reportes_puntos_control';

    public $fillable = [
        'punto_control_id',
        'usuario_id',
        'longitud',
        'latitud',
        'precision',
        'observaciones',
        'fecha_reporte',
        'ubicacion',
        'estado',
        'observaciones_rechazo',
        'longitud_asignacion',
        'latitud_asignacion',
        'editado',
        'observaciones_fuera_radio',
        'usuario_asigna_id',
        'version',
        'ubicacion_actualizada',
    ];

    protected $dates = [
        'fecha_reporte'
    ];

    protected $casts = [
        'id'                        => 'integer',
        'punto_control_id'          => 'integer',
        'usuario_id'                => 'integer',
        'longitud'                  => 'double',
        'latitud'                   => 'double',
        'precision'                 => 'double',
        'observaciones'             => 'string',
        'ubicacion'                 => 'string',
        'estado'                    => 'string',
        'observaciones_rechazo'     => 'string',
        'longitud_asignacion'       => 'double',
        'latitud_asignacion'        => 'double',
        'editado'                   => 'boolean',
        'observaciones_fuera_radio' => 'string',
        'usuario_asigna_id'         => 'integer',
        'version'                   => 'string',
        'ubicacion_actualizada'     => 'string',
    ];

    public function comision()
    {
        return $this->belongsTo(Comision::class, 'comision_id');
    }

    public function punto()
    {
        return $this->belongsTo(PuntoControl::class, 'punto_control_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function getRutaFotoAttribute()
    {
        $ruta = "storage/reportes_puntos/{$this->id}";
        $rutaCompleta = public_path($ruta);
        $adjunto = array_diff(scandir($rutaCompleta), ['..', '.', 'novedades']);
        return "{$ruta}/" . reset($adjunto);
    }

    public function getFotosNovedadesAttribute()
    {
        $ruta = "storage/reportes_puntos/{$this->id}/novedades";
        $rutaCompleta = public_path($ruta);
        return is_dir($rutaCompleta)
            ? array_diff(scandir($rutaCompleta), ['..', '.'])
            : [];
    }
}
