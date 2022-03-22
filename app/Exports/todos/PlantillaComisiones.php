<?php

namespace App\Exports\todos;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PlantillaComisiones implements FromView, WithTitle, ShouldAutoSize, WithColumnFormatting
{
    public function __construct()
    { }

    public function view(): View
    {
        return view('todos.comisiones.exports.comisionesPlantilla');
    }

    public function title(): string
    {
        return "Importación";
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
