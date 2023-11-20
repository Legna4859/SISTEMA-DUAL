<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class alumno_materias extends Model
{
    protected $table='eva_alumno_materias';
    protected $fillable=[
'cuenta',
'id_hrs_profesor'];
}
