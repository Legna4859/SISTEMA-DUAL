<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

use Session;


class PersonalPlantillaVerController extends Controller
{
    public function index()
    {

        //$plantillas = DB::select('select gnral_personales.clave,gnral_personales.id_personal,gnral_personales.nombre,gnral_unidad_administrativa.nom_departamento FROM gnral_personales, adscripcion_personal,gnral_unidad_personal,gnral_unidad_administrativa WHERE gnral_personales.id_personal=adscripcion_personal.id_personal and gnral_unidad_personal.id_unidad_persona=adscripcion_personal.id_unidad_persona and gnral_unidad_personal.id_unidad_admin=gnral_unidad_administrativa.id_unidad_admin');
        $jefaturas= DB::select('select *from gnral_unidad_administrativa order by nom_departamento');
        $ver=0;
        $departamento=0;
        return view('plantilla_personal.consultar_personal',compact('jefaturas','ver','departamento'));
    }
    public function  store(Request $request)
    {
        $departamento = $request->input("departamento");
       // dd($departamento);




        return redirect()->route('personaldepartamento', $departamento);
    }
}
