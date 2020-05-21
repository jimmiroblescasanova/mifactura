<?php

namespace App\Http\Controllers;

use App\admDocumentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ajaxController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $usuarios = admDocumentos::where('CRFC', Auth::user()->rfc)->paginate();

            return view('partials.facturas', compact('usuarios'));
        }

        return view('ajax');
    }
}
