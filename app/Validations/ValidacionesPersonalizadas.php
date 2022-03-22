<?php namespace App\Validations;

use App\Models\PuntoControl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator as LaravelValidator;

class ValidacionesPersonalizadas extends LaravelValidator 
{
    public function validateCurrentPassword($attribute, $value, $parameters)
    {
        return Hash::check($value, Auth::user()->password);
    }

    public function validateValidarEsquema($attribute, $value, $parameters)
    {
        foreach ($value as $escolta)
            if (!$escolta['vinculacion'])
                return false;
        return true;
    }
    
    public function validateValidarEscoltasComision($attribute, $value, $parameters)
    {
        foreach ($value as $escolta)
            if (!$escolta['codigo_autorizacion'])
                return false;
        return true;
    }

    public function validateCodigoAutorizacion($attribute, $escoltas, $parameters)
    {
        $codigos = array_column($escoltas, 'codigo_autorizacion');
        $repetidos = DB::table('vehiculos_escoltas')
            ->whereIn('codigo_autorizacion', $codigos)
            ->get()
            ->count();
        if (array_diff_assoc($codigos, array_unique($codigos)) || $repetidos)
            return false;
        return true;
    }

    public function validateValidarVehiculosEscoltas($attribute, $value, $parameters)
    {
        foreach ($value as $vehiculo)
            if (!$vehiculo['vehiculo_id'])
                return false;
        return true;
    }

    public function validateNumeroComision($attribute, $value, $parameters)
    {
        foreach ($value as $escolta)
            if (strlen($escolta['codigo_autorizacion']) < 13 || strlen($escolta['codigo_autorizacion']) > 14)
                return false;
        return true;
    }
    
    public function validateValidarPuntosComision($attribute, $value, $parameters)
    {
        foreach ($value as $key => $departamento)
            if (!$departamento ||
                !$this->data['lugares'][$key] || strlen($this->data['lugares'][$key] > 45) ||
                !$this->data['latitudes'][$key] || !is_numeric($this->data['latitudes'][$key]) ||
                !$this->data['longitudes'][$key] || !is_numeric($this->data['longitudes'][$key]) ||
                !$this->data['radios'][$key] || !is_numeric($this->data['radios'][$key]) || $this->data['radios'][$key] > 8388607
            )
                return false;
        return true;
    }

    public function validateCoordenadasAsignacion($attribute, $value, $parameters)
    {
        $latitudNovedad = $this->data['latitud_asignacion'];
        $longitudNovedad = $this->data['longitud_asignacion'];
        if ($punto = PuntoControl::find($this->data['punto_control_id'])) {
            $latitud = $punto->latitud;
            $longitud = $punto->longitud;
            $radio = $punto->radio;
            $rad = function ($x) {
                return $x * pi() / 180;
            };
            $r = 6378137; //Radio de la tierra en km
            $dLat = $rad($latitudNovedad - $latitud);
            $dLong = $rad($longitudNovedad - $longitud);
            $a = sin($dLat/2) * sin($dLat/2) + cos($rad($latitud)) * cos($rad($latitudNovedad)) * sin($dLong/2) * sin($dLong/2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $d = $r * $c;
            if ($d > $radio)
                return !is_null($value);
        }
        return true;
    }
}