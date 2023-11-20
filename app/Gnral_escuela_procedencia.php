<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gnral_escuela_procedencia extends Model
{
    protected $table = 'gnral_escuela_procedencia';
    protected $primaryKey='id_escuela_procedencia';
    protected $fillable=['nombre_escuela','id_municipio'];
}
