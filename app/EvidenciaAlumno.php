<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvidenciaAlumno extends Model
{
    protected $table = 'actcomple_evidencias_alumno';
    protected $primaryKey='id_evidencia_alumno';
    protected $fillable=['archivo','id_registro_alumno','numero_evidencias'];
}
