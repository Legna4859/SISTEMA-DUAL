<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\oc_vehiculo;
use Carbon\Carbon;
use App\Estados;
use App\Municipios;
class SolicitudAutoController extends Controller
{
    public function store(Request $request)
    {

        $id_automovil = $request->input("automoviles");
        $numero_oficio = $request->input("numero_oficio");
        $id_personal = $request->input("id_personal");
        $descripcion_oficio = $request->input("descripcion_oficio");
        $hora_s = $request->input("hora_s");
        $fecha_salida = $request->input("fecha_salida");
        $hora_r = $request->input("hora_r");
        $fecha_regreso = $request->input("fecha_regreso");
        $id_municipios = $request->input("id_municipios");
        $viaticos = $request->input("viaticos");
        $auto = $request->input("auto");
        $id_lugar_s = $request->input("id_lugar_s");
        $id_lugar_r = $request->input("id_lugar_r");
        $fecha= date("Y-m-d");

        DB:: table('oc_oficio')->insert(['fecha'=>$fecha,'numero'=>$numero_oficio,'id_personal'=>$id_personal,'desc_comision'=>$descripcion_oficio,'fecha_salida'=>$fecha_salida,'fecha_regreso'=>$fecha_regreso,'hora_s'=>$hora_s,'hora_r'=>$hora_r,'viaticos'=>$viaticos,'vehiculo'=>$auto,'id_municipio'=>$id_municipios,'id_lugar_salida'=>$id_lugar_s,'id_lugar_entrada'=>$id_lugar_r]);
        DB:: table('oc_oficio_vehiculo')->insert(['id_vehiculo'=>$id_automovil,'numero_oficio'=>$numero_oficio,'fecha_salida'=>$fecha_salida,'fecha_regreso'=>$fecha_regreso]);
        $personales = DB::select('select *from gnral_personales,departamento_personal,gnral_unidad_administrativa where departamento_personal.id_personal=gnral_personales.id_personal and departamento_personal.id_unidad_admin=gnral_unidad_administrativa.id_unidad_admin and gnral_unidad_administrativa.id_unidad_admin=6');


        $estados_alu=Estados::all();
        $municipios=Municipios::all();

        $mensage_carga='DATOS GUARDADOS EXITOSAMENTE';
        //return view('comision_oficio.solicitud_oficio', compact('mensage_carga','estados_alu','municipios','personales'));
        return redirect()->action('OcRegOficioController@index');






    }
}
