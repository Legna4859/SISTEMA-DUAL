<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;

class PaaGenerarPaaController extends Controller
{
    public function index(){
        $meses=DB::select('SELECT * FROM pa_mes');
        $programas=DB::select('SELECT * FROM pa_programa');
        $subprogramas=DB::select('SELECT * FROM pa_subprograma');
        $acciones=DB::select('SELECT pa_accion.id_accion,pa_accion.nom_accion,pa_unimed.id_unimed,pa_unimed.nom_unimed 
FROM pa_accion,pa_unimed where pa_accion.id_unimed=pa_unimed.id_unimed');

    }
}
