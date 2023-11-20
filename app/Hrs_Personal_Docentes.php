<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hrs_Personal_Docentes extends Model
{
    protected $table = 'hrs_personal_docentes';
    protected $primaryKey = 'id_personal_docente';
    protected $fillable = ['id_horario','caso','id_caso_factibilidad'];
}
