<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Exp_generacion;

class Tutorias_Plan_actividades extends Model
{

    protected $table='plan_actividades';
    protected $primaryKey='id_plan_actividad';
    protected $fillable=['desc_actividad','objetivo_actividad','fi_actividad','ff_actividad','id_generacion','id_periodo','id_estado','comentario'];

}
