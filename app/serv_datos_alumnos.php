<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class serv_datos_alumnos extends Model
{
    protected $table = 'serv_datos_alumnos';
    protected $primaryKey='id_datos_alumnos';
    protected $fillable=['correo_electronico','id_tipo_empresa','id_periodo','id_alumno'];

}
