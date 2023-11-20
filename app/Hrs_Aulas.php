<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hrs_Aulas extends Model
{
    protected $table = 'hrs_aulas';
    protected $primaryKey = 'id_aula';
    protected $fillable = ['id_carrera','nombre','id_edificio','comp'];
}
