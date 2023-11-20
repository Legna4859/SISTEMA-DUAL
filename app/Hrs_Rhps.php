<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hrs_Rhps extends Model
{
    protected $table = 'hrs_rhps';
    protected $primaryKey = 'id_rhps';
    protected $fillable = ['id_hrs_profesor','id_semana','id_cargo','id_aula'];
}
