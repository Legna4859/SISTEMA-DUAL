<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horarios extends Model
{
    protected $table = 'gnral_horarios';
    protected $primaryKey = 'id_horario_profesor';
    protected $fillable = ['id_periodo_carrera','id_personal','aprobado'];
}
