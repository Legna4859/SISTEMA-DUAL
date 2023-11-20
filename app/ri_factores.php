<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_factores extends Model
{
    //
    protected $table='ri_factores';
    protected $primaryKey='id_factor';
    protected $fillable=['no_factor','id_reg_riesgo','descripcion_f','id_cl_f','id_tipo_f','tiene_controles'];

    public function ri_tipof()
    {
        //dd($this->hasMany('App\ri_o_probabilidad','id_probabilidad','id_probabilidad'));
        return $this->hasMany('App\ritipo_f','id_tipo_f','id_tipo_f');

    }

    public function ri_clasi_f()
    {
        //dd($this->hasMany('App\ri_o_probabilidad','id_probabilidad','id_probabilidad'));
        return $this->hasMany('App\ri_clasif_factor','id_cl_f','id_cl_f');

    }
    public function riEvaControl()
    {
        return $this->hasMany('App\ri_evaluacion_control','id_factor','id_factor');

    }
    public function riAcciones()
    {
        return $this->hasMany('App\ri_estrategia_accion','id_factor','id_factor')->orderBy('fecha','asc');

    }
}

