<?php

namespace App\Http\Controllers;

use App\addComprobante;
use DB;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function search(Request $request)
    {
        $documento = addComprobante::where('UUID', $request->uuid)->get();
        /*$documento = DB::connection('sql_metadata')->table('Comprobante')
        ->where('UUID', $request['uuid'])->get();*/

        return view('search', compact('documento'));
    }
}
