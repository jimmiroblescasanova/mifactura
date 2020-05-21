<?php

namespace App\Http\Controllers;

use App\admDocumentos;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /* $saldo_total = admDocumentos::where([
            ['CRFC', Auth::user()->rfc],
            ['CIDDOCUMENTODE', 4],
            ['CFECHA', NOW()->format('Y-m-d')]
            ])->sum('CPENDIENTE'); */

        return view('home');
    }
}
