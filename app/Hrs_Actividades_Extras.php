<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hrs_Actividades_Extras extends Model
{
    protected $table = 'hrs_actividades_extras';
    protected $primaryKey = 'id_hrs_actividad_extra';
    protected $fillable = ['descripcion'];
}
