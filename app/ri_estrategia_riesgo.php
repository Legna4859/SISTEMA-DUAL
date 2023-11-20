<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_estrategia_riesgo extends Model
{
    //
    protected $table='ri_estrategia_riesgo';
    protected $primaryKey='id_estrategia_r';
    protected $fillable=['id_estrategia','id_reg_riesgo'];

    public function getEstrategia()
    {
        return $this->hasMany('App\riEstrategia','id_estrategia','id_estrategia');
    }
}
