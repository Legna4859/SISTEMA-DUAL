<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_estrategia_accion extends Model
{
    //
    protected $table='ri_estrategia_accion';
    protected $primaryKey='id_estrategia_a';
    protected $fillable=['id_factor','accion','fecha','fecha_final','id_unidad_admin','file','status'];


    public function getUnidadAdmin()
    {
        return $this->hasMany('App\gnral_unidad_administrativa','id_unidad_admin','id_unidad_admin');
    }
}
