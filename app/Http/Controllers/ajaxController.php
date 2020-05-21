<?php

namespace App\Http\Controllers;

use App\admDocumentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ajaxController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $usuarios = admDocumentos::where('CRFC', Auth::user()->rfc)->paginate();

            return response()->json($usuarios, 200);
        }

        return view('ajax');
    }
}
