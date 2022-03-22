<?php

namespace App\Exports\unp;

use App\Models\Cliente;
use App\Models\Comision;
use App\Models\Lista;
use App\Models\VComision;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ComisionesExport implements FromArray, WithStyles, WithColumnWidths, WithColumnFormatting, ShouldAutoSize, WithDrawings, WithTitle
{
    public function __construct($filtros)
    {
        $this->filtros = $filtros;
        $this->rows = VComision::select(
            'id',
            'numero',
            'nombre_cliente',
            'identificacion_escolta',
            'nombre_escolta',
            DB::raw('DATE_FORMAT(fecha_aprobacion_correo, "%d/%m/%Y")'),
            DB::raw('DATE_FORMAT(fecha_inicio, "%d/%m/%Y")'),
            DB::raw('DATE_FORMAT(fecha_fin, "%d/%m/%Y")'),
            'valor_x_dia',
            DB::raw('REPLACE(dias_aprobados, ".", ",")'),
            DB::raw('valor_x_dia * dias_aprobados'),
            DB::raw('REPLACE(dias_reales, ".", ",")'),
            DB::raw('valor_x_dia * dias_reales'),
            'origen',
            DB::raw('(SELECT GROUP_CONCAT(
                    (SELECT nombre FROM listas WHERE id = puntos_control.departamento_id), 
                    " - ", lugar SEPARATOR ", "
                ) FROM puntos_control WHERE comision_id = vcomisiones.id ORDER BY orden ASC
            )'),
            'viajero',
            'nombre_usuario',
            'observaciones',
            DB::raw("
                CASE estado 
                    WHEN '0' THEN 'SIN COMPLETAR'
                    WHEN '1' THEN 'ASIGNADO'
                    WHEN '2' THEN 'EN CURSO'
                    WHEN '3' THEN 'CANCELADO'
                    WHEN '4' THEN 'FINALIZADO'
                    WHEN '5' THEN 'VERIFICADO UT'
                    WHEN '6' THEN 'NOVEDAD'
                    WHEN '7' THEN 'APROBADO UNP'
                    WHEN '8' THEN 'RECHAZADO UNP'
                END
            "),
            DB::raw('DATE_FORMAT(fecha_primer_reporte, "%d/%m/%Y")'),
            DB::raw('DATE_FORMAT(fecha_ultimo_reporte, "%d/%m/%Y")'),
            'observaciones_verificaciones',
            'medio_desplazamiento'
        )
        ->where(function ($q) {
            if ($this->filtros->escolta) 
                $q->where(function ($q2) {
                    $q2->where('nombre_escolta', 'like', "%{$this->filtros->escolta}%")
                        ->orWhere('identificacion_escolta', 'like', "%{$this->filtros->escolta}%");
                });
            if ($this->filtros->zona) {
                $q->whereIn('zona_id', array_values($this->filtros->zona));
            }
            if ($this->filtros->comision) $q->where('numero', 'like', "{$this->filtros->comision}%");
            if ($this->filtros->cliente) $q->where('cliente_id', $this->filtros->cliente);
            if (!is_null($this->filtros->estado)) $q->where('estado', $this->filtros->estado);
            if ($this->filtros->desde_inicio) $q->where('fecha_inicio', '>=', $this->filtros->desde_inicio);
            if ($this->filtros->hasta_incio) $q->where('fecha_inicio', '<=', $this->filtros->hasta_incio);
            if ($this->filtros->desde_fin) $q->where('fecha_fin', '>=', $this->filtros->desde_fin);
            if ($this->filtros->hasta_fin) $q->where('fecha_fin', '<=', $this->filtros->hasta_fin);
            if (!is_null($this->filtros->tipo)) $q->where('tipo', $this->filtros->tipo);
        })
        ->whereIn('zona_id', auth()->user()->array_zonas)
        ->whereIn('estado', [
            Comision::ESTADO_VERIFICADO_UT,
            Comision::ESTADO_NOVEDAD,
            Comision::ESTADO_APROBADO,
            Comision::ESTADO_RECHAZADO
        ])
        ->get()
        ->toArray();
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 15
        ];
    }

    public function title(): string
    {
        return 'Comisiones';
    }

    public function styles(Worksheet $sheet) {
        $sheet->mergeCells('A1:D1');
        $sheet->mergeCells('A2:B9');
        $sheet->mergeCells('C2:D2');
        $sheet->getStyle('C2')
            ->getAlignment()
            ->setHorizontal(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:D9')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
        $sheet->getStyle('A11:W'.(count($this->rows) + 11))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ]
        ]);
        $sheet->getStyle('A1:C9')->applyFromArray([
            'font' => [
                'bold' => true
            ]
        ]);
        $sheet->getStyle('A11:W11')->applyFromArray([
            'font' => [
                'bold' => true
            ]
        ]);
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setPath(public_path(env('APP_LOGO')));
        $drawing->setHeight(90);
        $drawing->setOffsetX(20);
        $drawing->setOffsetY(25);
        $drawing->setCoordinates('A2');
        return $drawing;
    }

    public function columnFormats(): array { 
        return [
            'B' => NumberFormat::FORMAT_NUMBER,
            'I' => NumberFormat::FORMAT_CURRENCY_USD,
            'K' => NumberFormat::FORMAT_CURRENCY_USD,
            'M' => NumberFormat::FORMAT_CURRENCY_USD,
            'O' => NumberFormat::FORMAT_CURRENCY_USD,
        ];
    }

    public function array(): array
    {
        $zonas_consulta = [];
        if ($this->filtros->zona) {
            foreach($this->filtros->zona as $zona_id) {
                $zonas_consulta[] = Lista::find($zona_id)->nombre;
            }
        }
        return array_merge(
            [
                ['REPORTE COMISIONES - ' . date('d/m/Y g:i A')],
                ['', '', 'FILTROS'],
                ['', '', 'Escolta:', ($escolta = $this->filtros->escolta) ? $escolta : 'Todos'],
                ['', '', 'Cod. autorización:', ($comision = $this->filtros->comision) ? $comision : 'Todos'],
                ['', '', 'Estado:', !is_null($this->filtros->estado) ? Comision::ESTADOS[$this->filtros->estado] : 'Todos'],
                ['', '', 'Esquema:', $this->filtros->cliente ? Cliente::find($this->filtros->cliente)->nombre : 'Todos'],                
                ['', '', 'Desde:', $this->filtros->desde ? date('d/m/Y g:i A', strtotime($this->filtros->desde)) : 'Todos'],
                ['', '', 'Hasta:', $this->filtros->hasta ? date('d/m/Y g:i A', strtotime($this->filtros->hasta)) : 'Todos'],
                ['', '', 'Zona:', $this->filtros->zona ? implode(", ", $zonas_consulta) : 'Todos'],
                [''],
                [
                    'Id', 'No. autorización UNP', 'Esquema', 'Cédula del escolta', 'Nombre del escolta', 'Fecha aprobación correo', 
                    'Fecha inicio', 'Fecha fin', 'Valor por día', 'Días aprobados',
                    'Valor total días aprobados', 'Días reportados', 'Valor total días reportados', 'Origen', 'Puntos de control', 
                    'Viajero', 'Creado por', 'Observaciones', 'Estado', 'Fecha inicio comisión', 'Fecha fin comisión', 'Observaciones verificaciones',
                    'Medio desplazamiento'
                ]
            ],
            $this->rows
        );
    }
}
