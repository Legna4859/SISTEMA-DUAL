<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CargaAcademica extends Model
{
    protected $table = 'eva_carga_academica';
    protected $primaryKey='id_carga_academica';
    protected $fillable=['id_alumno','id_materia','id_status_materia','id_tipo_curso','id_periodo','id_grupo','grupo'];
}
