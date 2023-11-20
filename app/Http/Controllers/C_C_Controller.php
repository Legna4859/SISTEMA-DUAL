<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class C_C_Controller extends Controller
{
    public function index(){
        $estado_activacion = DB::selectOne('SELECT count(id_activacion) contar from cc_activacion_hrs');


        if($estado_activacion == 0){


        }else{

        }
    }
}
