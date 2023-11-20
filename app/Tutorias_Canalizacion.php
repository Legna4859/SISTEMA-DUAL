<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorias_Canalizacion extends Model
{
    protected $table ="canalizacion";
    protected $primaryKey="id_canalizacion";
    protected $fillable=["id_alumno","id_personal","fecha_canalizacion","hora"
        ,"aspectos_sociologicos1","aspectos_sociologicos2","aspectos_sociologicos3","aspectos_academicos1","aspectos_academicos2","aspectos_academicos3"
        ,"observaciones","otros","desc_area","desc_subarea","status"];

}
