<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
Use Session;
class ri_requisitos extends Model
{
    //
    protected $table = 'ri_requisitos';
    protected $primaryKey='id_requisito';
    protected $fillable=['des_requisito','id_uni_p'];

    public function riesgos()
    {
        //return "ok";
        return $this->hasMany('App\ri_riesgo','id_requisito','id_requisito')->where("id_unidad_admin",Session::get('id_unidad_admin'));

        //return $this->hasMany('App\ri_requisitos', 'id_unidad_p');
    }
    public function riesgosunidad($unidad)
    {
        //return "ok";

        //if($unidad==14)
          //  dd($this->hasMany('App\ri_riesgo','id_requisito','id_requisito')->where("id_unidad_admin",$unidad)->get());
        return $this->hasMany('App\ri_riesgo','id_requisito','id_requisito')->where("id_unidad_admin",$unidad)->get();

        //return $this->hasMany('App\ri_requisitos', 'id_unidad_p');
    }
    public function oportunidades()
    {
        //return "ok";
        return $this->hasMany('App\ri_reg_oportunidad','id_requisito','id_requisito')->where("id_unidad_admin",Session::get('id_unidad_admin'));

        //return $this->hasMany('App\ri_requisitos', 'id_unidad_p');
    }
    public function oportunidadesunidad($unidad)
    {
        //return "ok";
        return $this->hasMany('App\ri_reg_oportunidad','id_requisito','id_requisito')->where("id_unidad_admin",$unidad)->get();

        //return $this->hasMany('App\ri_requisitos', 'id_unidad_p');
    }
    public function partes()
    {
        return $this->hasMany('App\ri_unidad_parte','id_uni_p','id_uni_p');
    }
}
