<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_proceso_unidad extends Model
{
    protected $table = 'ri_proceso_unidad';
    protected $primaryKey='id_proceso_unidad';
    protected $fillable=['id_proceso','id_unidad_admin'];

    public function proceso()
    {
        return $this->hasMany('App\ri_proceso','id_proceso','id_proceso');

    }
    public function unidadParte()
    {
       return $this->hasMany('App\ri_unidad_parte','id_unidad_admin','id_unidad_admin');
        //return ri_unidad_parte::where('id_unidad_admin','id_unidad_admin')->where('id_proceso','id_proceso')->get();
    }

    public function procesoParte(){
        return $this->hasMany('App\ri_unidad_parte','id_proceso','id_proceso');

    }
}
