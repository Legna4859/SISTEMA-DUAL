<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GnralJefeUnidadAdministrativa extends Model
{
    //

    protected $table = 'gnral_unidad_personal';
    protected $primaryKey='id_unidad_persona';
    protected $fillable=['id_unidad_admin','id_personal',];

    public function jefe(){
        return $this->hasOne('App\GnralPersonales','id_personal','id_personal');
    }
}
