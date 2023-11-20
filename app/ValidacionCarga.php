<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ValidacionCarga extends Model
{
    protected $table = 'eva_validacion_de_cargas';
    protected $primaryKey='id';
    protected $fillable=['id_alumno','id_periodo','estado_validacion','descripcion','no_pregunta'];
}
