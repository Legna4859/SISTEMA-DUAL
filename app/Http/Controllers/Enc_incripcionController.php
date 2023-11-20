<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Enc_incripcionController extends Controller
{
    public function encuesta_incripcion(){

        return view('encuestas_satisfacion_cliente.inscripcion.encuesta_inscripcion');
    }
}
