<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Gnral_Personales;
use App\Http\Requests;
use App\Tutorias_Desarrollo_asigna_coordinador_general;
use Session;

class Tutorias_DesarrolloVistaController extends Controller
{
    //
    public function index(Request $request)
    {

        return view('tutorias.desarrollo.index');
    }
}
