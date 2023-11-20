<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paa_Programa extends Model
{
    protected $table='pa_programa';
    protected $primaryKey='id_programa';
    protected $fillable=['nom_programa'];
}
