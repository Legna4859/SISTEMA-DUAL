<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_reg_oportunidad extends Model
{
    //
    protected $table = 'ri__reg_oportunidad';
    protected $primaryKey='id_oportunidad';
    protected $fillable=['des_oportunidad','id_probabilidad','id_ocurrenciap','calificacion','id_potencialapertura',
        'id_potencialcrecimiento','id_mejoracliente','id_mejorasgc',
        'id_mejorareputacion','id_potencialcosto','calif_beneficio','factor_oportunidad','id_requisito','id_unidad_admin'];

    public function ri_o_probabilidad()
    {
        //dd($this->hasMany('App\ri_o_probabilidad','id_probabilidad','id_probabilidad'));
        return $this->hasMany('App\ri_o_probabilidad','id_probabilidad','id_probabilidad');

    }
    public function ri_o_ocurrencia()
    {
        return $this->hasMany('App\ri_o_ocurrenciasp','id_ocurrenciap','id_ocurrenciap');

    }
    public function ri_o_potencialapertura()
    {
        return $this->hasMany('App\ri_o_potencialapertura','id_potencialapertura','id_potencialapertura');

    }
    public function ri_o_potencialcrecimiento()
    {
        return $this->hasMany('App\ri_o_potencialcrecimiento','id_potencialcrecimiento','id_potencialcrecimiento');

    }
    public function ri_o_mejoracliente()
    {
        return $this->hasMany('App\ri_o_mejoracliente','id_mejoracliente','id_mejoracliente');

    }
    public function ri_o_mejorasgc()
    {
        return $this->hasMany('App\ri_o_mejorasgc','id_mejorasgc','id_mejorasgc');

    }
    public function ri_o_mejorareputacion()
    {
        return $this->hasMany('App\ri_o_mejorareputacion','id_mejorareputacion','id_mejorareputacion');

    }
    public function ri_o_potencialcosto()
    {
        return $this->hasMany('App\ri_o_potencialcosto','id_potencialcosto','id_potencialcosto');

    }
    public function ri_o_planseguimiento()
    {
        return $this->hasMany('App\ri_o_planseguimiento','id_oportunidad','id_oportunidad')->orderBy('fecha_inicial','asc');

    }
    public function ri_requisitos()
    {
        return $this->hasMany('App\ri_requisitos','id_requisito','id_requisito');
    }
}
