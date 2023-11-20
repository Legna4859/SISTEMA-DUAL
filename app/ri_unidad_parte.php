<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class ri_unidad_parte extends Model
{
    //
    protected $table = 'ri_unidad_parte';
    protected $primaryKey='id_uni_p';
    protected $fillable=['id_unidad_admin','id_parte','id_proceso'];


    public function requisitos()
    {
        //return "ok";
        return $this->hasMany('App\ri_requisitos','id_uni_p');

        //return $this->hasMany('App\ri_requisitos', 'id_unidad_p');
    }

    public function parte(){

       return $this->hasMany('App\ri_partes','id_parte','id_parte');

    }
    public function proceso(){

        return $this->hasMany('App\ri_proceso','id_proceso','id_proceso');

    }
}

