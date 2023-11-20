<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;

class Ipomex_agregar_fracionesController extends Controller
{
    public function index(){
        $unidad=Session::get('id_unidad_admin');
//dd($unidad);
        $articulos=DB::select('SELECT ipomex_articulos_generales.descripcion articulo_general,ipomex_articulos_estatales.descripcion articulo_estatal,ipomex_fracciones_generales.* 
from ipomex_articulos_generales,ipomex_jefes_articulos,ipomex_articulos_estatales,ipomex_fracciones_generales 
where ipomex_jefes_articulos.id_fraccion_general=ipomex_fracciones_generales.id_fraccion_general 
and ipomex_articulos_generales.id_articulo_general=ipomex_fracciones_generales.id_articulo_general
 and ipomex_articulos_estatales.id_articulo_estatal=ipomex_fracciones_generales.id_articulo_estatal 
 and ipomex_jefes_articulos.id_unidad_admin='.$unidad.'');
       // dd($articulos);
        return view('ipomex.mostrar_articulos',compact('articulos'));
    }
    public function contralor_ver_ipomex(){

        $art_ipomex=DB::select('SELECT ipomex_articulos_generales.descripcion articulo_general,ipomex_articulos_estatales.descripcion articulo_estatal,ipomex_fracciones_generales.* ,abreviaciones.titulo,gnral_personales.nombre
from ipomex_articulos_generales,ipomex_jefes_articulos,ipomex_articulos_estatales,ipomex_fracciones_generales,abreviaciones,gnral_personales, gnral_unidad_personal, abreviaciones_prof where ipomex_jefes_articulos.id_fraccion_general=ipomex_fracciones_generales.id_fraccion_general 
and ipomex_articulos_generales.id_articulo_general=ipomex_fracciones_generales.id_articulo_general
 and ipomex_articulos_estatales.id_articulo_estatal=ipomex_fracciones_generales.id_articulo_estatal 
 and ipomex_jefes_articulos.id_unidad_admin=gnral_unidad_personal.id_unidad_admin and 
    gnral_unidad_personal.id_personal=gnral_personales.id_personal and
    abreviaciones_prof.id_personal=gnral_personales.id_personal and 
abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion ORDER BY gnral_personales.nombre DESC');
        return view('ipomex.mostrar_jefes_ipomex',compact('art_ipomex'));
    }
    public function  show(){

}
}
