<?php

namespace App\Exports;

use App\admDocumentos;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class EDCExport implements FromView, ShouldAutoSize, WithColumnFormatting
{
    /**
     * @var mixed
     */
    public $FechaInicial;
    public $FechaFinal;

    public function __construct($request)
    {
        $this->FechaInicial = $request['fecha_inicial'];
        $this->FechaFinal = $request['fecha_final'];
    }

    public function view(): View
    {
        $documentos = admDocumentos::where('CRFC', Auth::user()->rfc)
            ->whereIn('CIDDOCUMENTODE', [4,5,7,9,12])
            ->whereBetween('CFECHA', [$this->FechaInicial, $this->FechaFinal])
            ->get();

        return view('excel.edc', [
            'documents' => $documentos,
        ]);

    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'E' => NumberFormat::FORMAT_NUMBER_00,
            'F' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }

}
