<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class in_profesores_ingles extends Model
{
protected $table='in_profesores_ingles';
    protected $primaryKey='id_profesores';
    protected $fillable=['nombre','apellido_paterno','apellido_materno','id_nivel_ingles','id_tipo_titulo','fecha_emision_titulo',
        'horas_maximas','id_sexo','id_tipo_usuario'];
}
