<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_riesgo extends Model
{
    //
    protected $table = 'ri_riesgo';
    protected $primaryKey='id_riesgo';
    protected $fillable=['des_riesgo','id_requisito','id_unidad_admin'];

    public function getRequisito()
    {
    return $this->hasMany('App\ri_requisitos', 'id_requisito','id_requisito');
    }
    public function registro_riesgo()
    {
        return $this->hasMany('App\RegRiesgo', 'id_riesgo','id_riesgo');
    }
}

