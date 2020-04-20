<?php

namespace App\Http\Controllers;

use App\addComprobante;
use DB;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search()
    {
        /*$documentos = DB::connection('sql_metadata')->table('Comprobante')
        ->select(DB::raw('CAST(GuidDocument AS VARCHAR(36)) as GuidDocument, RFCEmisor, NombreReceptor'))
        ->get();*/

        $documentos = addComprobante::pluck('GuidDocument')->get();

        return dd($documentos);
    }
}
