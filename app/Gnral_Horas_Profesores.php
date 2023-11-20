<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gnral_Horas_Profesores extends Model
{
    protected $table = 'gnral_horas_profesores';
    protected $primaryKey = 'id_hrs_profesor';
    protected $fillable = ['id_horario_profesor','grupo','id_materia_perfil'];
}
