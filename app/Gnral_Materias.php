<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gnral_Materias extends Model
{
    protected $table = 'gnral_materias';
    protected $primaryKey = 'id_materia';
    protected $fillable = ['nombre','clave','hrs_practicas','hrs_teoria',
    'id_reticula','id_semestre','creditos','unidades','especial'];
}
