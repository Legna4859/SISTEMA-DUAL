<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorias_Exp_generacion extends Model
{
    //
    protected $table='exp_generacion';
    protected $primaryKey='id_generacion';
    protected $fillable=['generacion'];

    function getGrupo()
    {
        return $this->hasMany('App\Tutorias_Exp_asigna_generacion','id_generacion','id_generacion');
    }
}
