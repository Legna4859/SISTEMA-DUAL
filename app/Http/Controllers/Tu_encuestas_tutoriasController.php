<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Tu_encuestas_tutoriasController extends Controller
{
    public function index(){
        return view('encuesta_tutorias.encuesta_tutorias');
    }
    public function guardar_encuesta(Request $request){
        dd($request);

    }
}
