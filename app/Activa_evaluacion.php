<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activa_evaluacion extends Model
{
       protected $table = 'eva_activa_evaluacion';
       protected $primaryKey='id';
       protected $fillable=['estado'];
}
