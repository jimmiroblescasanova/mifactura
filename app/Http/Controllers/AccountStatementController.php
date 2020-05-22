<?php

namespace App\Http\Controllers;

use App\admDocumentos;
use App\Exports\EDCExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\EstadoDeCuentaRequest;

class AccountStatementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('accounts.index');
    }

    public function reporte(EstadoDeCuentaRequest $request)
    {
        $documentos = admDocumentos::with('concepto')->where('CRFC', Auth::user()->rfc)
            ->whereIn('CIDDOCUMENTODE', [4,5,7,9,12])
            ->whereBetween('CFECHA', [$request->FechaInicial, $request->FechaFinal])
            ->get();

        $saldo_inicial_cargos = admDocumentos::where([
            ['CRFC', Auth::user()->rfc],
            ['CIDDOCUMENTODE', 4],
            ['CFECHA', '<', $request->FechaInicial],
        ])->sum('CTOTAL');

        $saldo_inicial_abonos = admDocumentos::where('CRFC', Auth::user()->rfc)
        ->whereIn('CIDDOCUMENTODE', [5,7,9,12])
        ->where('CFECHA', '<', $request->FechaInicial)
        ->sum('CTOTAL');

        return response()->json([
            'documents' => $documentos,
            'saldo_inicial' => (double)(round($saldo_inicial_cargos,2) - round($saldo_inicial_abonos, 2)),
            'cargos' => $documentos->where('CIDDOCUMENTODE', 4)->sum('CTOTAL'),
            'abonos' => $documentos->whereIn('CIDDOCUMENTODE', [5,7,9,12])->sum('CTOTAL'),
        ], 200);
    }

    public function excel(Request $request)
    {
        return Excel::download(new EDCExport($request), 'estados_de_cuenta.xlsx');
    }

}
