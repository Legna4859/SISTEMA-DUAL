<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Tutorias_Plan_asigna_planeacion_actividad extends Model
{

    protected $table='plan_asigna_planeacion_actividad';
    protected $primaryKey='id_asigna_planeacion_actividad';
    protected $fillable=['id_asigna_generacion','id_plan_actividad','comentario','id_estado'];

}
