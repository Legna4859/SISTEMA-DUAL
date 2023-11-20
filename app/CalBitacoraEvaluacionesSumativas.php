<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalBitacoraEvaluacionesSumativas extends Model
{
    protected $table = 'cal_bitacoras_sumativas';
    protected $primaryKey='id_bitacora_sumativas';
    protected $fillable=['id_evaluacion','id_unidad','id_carga_academica','id_materia','docente','cal_antigua','cal_nueva','id_periodo'];

}
