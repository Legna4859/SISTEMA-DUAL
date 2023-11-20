<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Abreviaciones_prof extends Model
{
    protected $table = 'abreviaciones_prof';
    protected $primaryKey='id_abreviacion_prof';
    protected $fillable=['id_abreviacion','id_personal'];
    public function getAbreviatura(){
        return $this->hasMany('App\Abreviaciones','id_abreviacion','id_abreviacion');
    }

    //no modificar se utiliza en oficios
    public function abreviaciones(){
        return $this->hasMany('App\Abreviaciones','id_abreviacion','id_abreviacion');
    }
}