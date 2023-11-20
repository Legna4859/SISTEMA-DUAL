<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_proceso extends Model
{
    //
    protected $table = 'ri_proceso';
    protected $primaryKey='id_proceso';
    protected $fillable=['clave','des_proceso','id_sistema'];

    public function sistema()
    {
        //return "ok";
        return $this->hasMany('App\ri_sistema','id_sistema','id_sistema');

        //return $this->hasMany('App\ri_requisitos', 'id_unidad_p');
    }
}
