<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class calEvaluaciones extends Model
{
    protected $table = 'cal_evaluaciones';
    protected $primaryKey='id_evaluacion';
    protected $fillable=['id_unidad','id_carga_academica','calificacion','esc',"observaciones","id_canalizacion"];
}
