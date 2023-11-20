<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class calBitacoraEvaluaciones extends Model
{
    protected $table = 'cal_bitacora_evaluaciones';
    protected $primaryKey='id_bitacora_eval';
    protected $fillable=['id_evaluacion','id_unidad','id_carga_academica','id_materia','docente','cal_antigua','cal_nueva','id_periodo'];
}
