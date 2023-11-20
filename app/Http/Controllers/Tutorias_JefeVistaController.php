<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Tutorias_JefeVistaController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('tutorias.jefe.index');
    }
}
