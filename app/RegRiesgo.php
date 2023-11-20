<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegRiesgo extends Model
{
    //
    protected $table = 'ri_registro_riesgo';
    protected $primaryKey='id_reg_riesgo';
    protected $fillable=['numero','id_unidad_admin','id_seleccion','descip_riesgo',
        'id_riesgo','id_nivel_des','id_cl_r','fecha'];
    public function riesgos()
    {
        return $this->hasMany('App\ri_riesgo', 'id_riesgo','id_riesgo');
    }
    public function unidadAdmin()
    {
        return $this->hasMany('App\gnral_unidad_administrativa', 'id_unidad_admin','id_unidad_admin');
    }
    public function seleccion()
    {
        return $this->hasMany('App\riseleccion', 'id_seleccion','id_seleccion');
    }
    public function nivelDecision()
    {
        return $this->hasMany('App\ri_nivel_decision', 'id_nivel_de', 'id_nivel_des');
    }
    public function clasificacionRiesgo()
    {
        return $this->hasMany('App\ri_clasif_r', 'id_cl_r','id_cl_r');
    }

    public function valEfectos()
    {
        //return "ok";
        return $this->hasMany('App\ri_valoracion_efecto','id_reg_riesgo','id_reg_riesgo');

        //return $this->hasMany('App\ri_requisitos', 'id_unidad_p');
    }
    public function factorRiesgo()
    {
        //return "ok";
        return $this->hasMany('App\ri_factores','id_reg_riesgo','id_reg_riesgo');

        //return $this->hasMany('App\ri_requisitos', 'id_unidad_p');
    }
    public function estrategiaRiesgo()
    {
        return $this->hasMany('App\ri_estrategia_riesgo','id_reg_riesgo','id_reg_riesgo');
    }


}
