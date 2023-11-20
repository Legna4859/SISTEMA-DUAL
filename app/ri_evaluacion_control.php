<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_evaluacion_control extends Model
{
    //
    protected $table='ri_evaluacion_control';
    protected $primaryKey='id_evaluacion';
    protected $fillable=['No_controles_eva','id_factor','descripcion','id_tipo_eva','documentado','formalizado','efectivo','aplica','resultado'];
    public function riEvaControl()
    {
        return $this->hasMany('App\ri_evaluacion_control','id_factor','id_factor');

    }
    public function tipoEva()
    {
        return $this->hasMany('App\ri_tipo_eva','id_tipo_eva','id_tipo_eva');

    }
}
