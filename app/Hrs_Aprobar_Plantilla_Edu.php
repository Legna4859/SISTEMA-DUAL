<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hrs_Aprobar_Plantilla_Edu extends Model
{
    protected $table = 'hrs_aprobar_plantilla_edu';
    protected $primaryKey = 'id_aprobar_plantilla_edu';
    protected $fillable = ['id_horario','hrs_clase','vinculacion','investigacion','gestion','tutorias','residencia'];
}
