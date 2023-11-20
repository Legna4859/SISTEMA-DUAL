<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hrs_Act_Extra_Clases extends Model
{
    protected $table = 'hrs_act_extra_clases';
    protected $primaryKey = 'id_act_extra_clase';
    protected $fillable = ['id_hrs_actividad_extra','actividad','id_carrera'];
}
