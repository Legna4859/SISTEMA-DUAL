<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hrs_Distribucion_Horas extends Model
{
    protected $table = 'hrs_distribucion_horas';
    protected $primaryKey = 'id_distribucion_hora';
    protected $fillable = ['no_alum','alum_otras_carreras','hrs_docente',
    'hrs_dir_atm_hono','directivo','atm','honorarios','id_periodo_carrera','id_materia'];
}
