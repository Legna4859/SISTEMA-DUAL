<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hrs_Extra_Clase extends Model
{
    protected $table = 'hrs_extra_clase';
    protected $primaryKey = 'id_extra_clase';
    protected $fillable = ['id_act_extra_clase','id_horario_profesor','grupo'];
}
