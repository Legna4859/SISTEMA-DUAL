<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class amb_periodo_amb extends Model
{
    protected $table = 'amb_periodo_amb';
    protected $primaryKey='id_periodo_amb';
    protected $fillable=['nombre_periodo_amb','fecha_inicial','fecha_final'];
}
