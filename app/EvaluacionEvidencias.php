<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluacionEvidencias extends Model
{
    protected $table = 'actcomple_evaluaciones';
    protected $primaryKey='id_evaluacion';
    protected $fillable=['estado','abreviaciones','id_evidencia_alumno','calificacion','cuenta'];
}
