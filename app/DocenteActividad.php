<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocenteActividad extends Model
{
    protected $table = 'actcomple_docente_actividad';
    protected $primaryKey='id_docente_actividad';
    protected $fillable=['id_personal','id_actividad_comple','estado','id_periodo'];
}
