<?php

namespace App\Imports\todos;

use App\Models\Cliente;
use App\Models\Comision;
use App\Models\Escolta;
use App\Models\Importacion;
use App\Models\Lista;
use App\Models\PuntoControl;
use DateTime;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportComisiones implements ToCollection, WithColumnFormatting
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        try {
            DB::beginTransaction();

            $grupo = Importacion::max('grupo') + 1;

            foreach ($rows as $ind => $row) {
                if ($ind == 0) continue;
                if (empty($row[0])) break;

                $lugares = [];
                $explodeLugares = explode('-', $row[8]);

                preg_match_all('/([^\(|\-]{1,})\(([^\)]{1,})\)/', $row[8], $matches);
                for ($i = 0; $i < count($matches[1]); $i++) {
                    $lugares[] = [
                        trim($matches[1][$i]) => trim($matches[2][$i])
                    ];
                }

                $fechaAprobacion = (is_numeric($row[13])) ? Date::excelToDateTimeObject($row[13]) : DateTime::createFromFormat('d/m/Y', $row[13]);
                $fechaInicio = (is_numeric($row[14])) ? Date::excelToDateTimeObject($row[14]) : DateTime::createFromFormat('d/m/Y', $row[14]);
                $fechaFin = (is_numeric($row[15])) ? Date::excelToDateTimeObject($row[15]) : DateTime::createFromFormat('d/m/Y', $row[15]);

                $cliente = Cliente::where('nombre', 'LIKE', '%' . trim($row[3]) . '%')->first();
                $nombreTipoDesplazamiento = ($row[10] == 1) ? 'Aéreo' : 'Terreste';
                $tipoDesplazamiento = Lista::findByNombre(trim($nombreTipoDesplazamiento), 9);
                $escolta = Escolta::where('identificacion', trim($row[12]))->first();
                $existeNumero = Comision::where('numero', trim($row[0]))->first();

                if ($existeNumero)
                    throw new Exception("El código autorización " . $row[0] . " ya existe. <br> en la línea " . ($ind + 1));
                if (strlen($row[0]) < 13 || strlen($row[0]) > 14)
                    throw new Exception("El código autorización " . $row[0] . " debe ser de 13 o 14 dígitos. <br> en la línea " . ($ind + 1));
                if (!$cliente)
                    throw new Exception("El esquema " . $row[3] . " no existe. <br> en la línea " . ($ind + 1));
                if (!$tipoDesplazamiento)
                    throw new Exception("El tipo de desplazamiento " . $row[10] . " no existe. <br> en la línea " . ($ind + 1));
                if (!$escolta)
                    throw new Exception("El escolta " . $row[12] . " no existe. <br> en la línea " . ($ind + 1));

                $tipo = (trim(strtolower($row[16])) == 'solo desplazamiento') ? 1 : 0;
                $diasAprobados = ($tipo == 1) ? 0 : $row[16];

                $data = [
                    'numero' => $row[0],
                    'fecha_aprobacion_correo' => $fechaAprobacion,
                    'fecha_inicio' => $fechaInicio,
                    'fecha_fin' => $fechaFin,
                    'tipo' => $tipo,
                    'cliente_id' => $cliente->id,
                    'valor_x_dia' => $cliente->zona->codigo,
                    'dias_aprobados' => $diasAprobados,
                    'origen' => $row[7],
                    'tipo_desplazamiento_id' => $tipoDesplazamiento->id,
                    'viajero' => $row[4],
                    'observaciones' => '',
                    'zona_id' => $cliente->zona_id,
                    'usuario_id' => Auth::user()->id
                ];

                $comision = Comision::create($data);
                $escoltas = [];

                if ($escolta) {
                    array_push($escoltas, [
                        "escolta_id" => $escolta->id,
                        "codigo_autorizacion" => $row[0]
                    ]);
                }

                if ($comision && count($escoltas) > 0) {
                    $comision->update([
                        'paso_creacion' => 3
                    ]);
                    $vehiculos = $comision->vehiculosEscoltas()->createMany($escoltas);
                    if ($vehiculos && count($lugares) > 0) {
                        $orden = 1;
                        foreach ($lugares as $value) {
                            foreach ($value as $lugar => $departamento) {
                                $listaDepartamento = Lista::findByNombre(trim($departamento), 5);
                                if ($listaDepartamento) {
                                    $punto = PuntoControl::select('latitud', 'longitud', 'radio')
                                        ->where('departamento_id', $listaDepartamento->id)
                                        ->where('lugar', 'LIKE', trim($lugar))
                                        ->latest()
                                        ->first();

                                    if ($punto) {
                                        $puntoControl = $comision->puntosControl()->create([
                                            'departamento_id' => $listaDepartamento->id,
                                            'orden'           => $orden,
                                            'latitud'         => $punto->latitud,
                                            'longitud'        => $punto->longitud,
                                            'radio'           => $punto->radio,
                                            'lugar'           => $lugar
                                        ]);
                                        if ($puntoControl && count($lugares) == 1 && count($lugares) == count($explodeLugares)) {
                                            $newPuntoControl = $puntoControl->replicate();
                                            $newPuntoControl->save();
                                        }
                                        $orden++;
                                    }
                                }
                            }
                        }
                        if (count($comision->puntosControl()->get()) == count($lugares) && count($lugares) == count($explodeLugares)) {
                            $comision->estados()->create([
                                'observaciones' => '',
                                'estado'        => ($comision->tipo != 1) ? Comision::ESTADO_ASIGNADO : Comision::SOLO_DESPLAZAMIENTO,
                                'usuario_id'    => auth()->user()->id
                            ]);
                            $comision->update([
                                'paso_creacion' => 0
                            ]);
                        }
                    }
                }

                $dataImport = [
                    'comision_id' => $comision->id,
                    'numero' => $comision->numero,
                    'estado' => $comision->paso_creacion,
                    'grupo' => $grupo,
                    'usuario_id' => auth()->user()->id,
                ];

                $import = Importacion::create($dataImport);
                if ($import) {
                    $import->destinos()->create([
                        'lugar' => trim($row[8])
                    ]);
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            Flash::error('Ha ocurrido un error cargando el archivo. ' . $th->getMessage());
            DB::rollback();
            throw new Exception($th->getMessage());
        }
    }

    public function columnFormats(): array
    {
        return [
            'N' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'O' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'P' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
