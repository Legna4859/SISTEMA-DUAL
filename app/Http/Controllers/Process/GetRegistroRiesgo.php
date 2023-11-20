<?php
/**
 * Created by PhpStorm.
 * User: CPrimero
 * Date: 14/11/18
 * Time: 08:59
 */

namespace App\Http\Controllers\Process;
use App\RegRiesgo;
use App\ri_valoracion_efecto;


class GetRegistroRiesgo
{

    public function getRegRiesgo($id_riesgo,$id_unidad_admin){

        //$dat_reg_riesgo=RegRiesgo::all();
        $dat_reg_riesgo=RegRiesgo::where('id_unidad_admin',$id_unidad_admin)->where('id_riesgo',$id_riesgo)->get();

        if(count($dat_reg_riesgo)==0)
        {
            $num_reg_unidad=RegRiesgo::where('id_unidad_admin',$id_unidad_admin)->get();

            $reg_riesgo = array(
                'numero' => mb_strtoupper((\Carbon\Carbon::now()->year)."-".(count($num_reg_unidad)+1)),
                'id_unidad_admin'=>$id_unidad_admin,
                'id_seleccion'=>0,
                'descip_riesgo'=>"",
                'id_riesgo'=>$id_riesgo,
                'id_nivel_des'=>0,
                'id_cl_r'=>0,
                'fecha'=>\Carbon\Carbon::now()
            );
            RegRiesgo::create($reg_riesgo);
            $dat_reg_riesgo=RegRiesgo::where('id_unidad_admin',$id_unidad_admin)->where('id_riesgo',$id_riesgo)->get();
        }
        if(count(ri_valoracion_efecto::where('id_reg_riesgo',$dat_reg_riesgo[0]->id_reg_riesgo)->get())==0)
            ri_valoracion_efecto::create(array('id_reg_riesgo'=>$dat_reg_riesgo[0]->id_reg_riesgo,'efecto'=>"",
                'grado_impacto'=>0,'probabilidad'=>0,'cuadrante'=>""));
       // dd($dat_reg_riesgo);
        return $dat_reg_riesgo;

    }
}