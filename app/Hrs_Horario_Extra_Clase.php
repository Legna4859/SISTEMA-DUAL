<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hrs_Horario_Extra_Clase extends Model
{
    protected $table = 'hrs_horario_extra_clase';
    protected $primaryKey = 'id_hr_extra';
    protected $fillable = ['id_extra_clase','id_semana','id_cargo','id_aula'];
}
