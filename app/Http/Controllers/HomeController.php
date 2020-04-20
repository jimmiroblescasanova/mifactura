<?php

namespace App\Http\Controllers;

use App\DocumentosDigitales;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        $data = DocumentosDigitales::pluck('DocumentType');

        return $data;
    }
}
