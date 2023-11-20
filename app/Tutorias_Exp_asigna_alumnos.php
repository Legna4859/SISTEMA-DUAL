<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Tutorias_Exp_asigna_alumnos extends Model
{
    //
    protected $table='exp_asigna_alumnos';
    protected $primaryKey='id_asigna_alumno';
    protected $fillable=['id_alumno','id_asigna_generacion','estado'];
}
