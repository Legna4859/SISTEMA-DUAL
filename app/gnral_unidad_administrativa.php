<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gnral_unidad_administrativa extends Model
{
    //
    protected $table = 'gnral_unidad_administrativa';
    protected $primaryKey='id_unidad_admin';
    protected $fillable=['nom_departamento','clave','cod'];
    public function proceso_unidad()
    {
        return $this->hasMany('App\ri_proceso_unidad','id_unidad_admin','id_unidad_admin');

    }
    public function jefeArea(){
        return $this->hasMany('App\GnralJefeUnidadAdministrativa','id_unidad_admin','id_unidad_admin');
    }
    /*
    public function unidadParte()
    {
        return $this->hasMany('App\ri_unidad_parte','id_unidad_admin','id_unidad_admin');
    }*/
}
