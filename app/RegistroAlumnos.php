<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroAlumnos extends Model
{
    protected $table='actcomple_registro_alumnos';
    protected $primaryKey='id_registro_alumno';
    protected $fillable=['cuenta','id_periodo','liberacion','rubrica','id_semestre','fecha_registro','id_docente_actividad'];

}
