<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incidencias extends Model
{
    protected $fillable = ['motivo_oficio','tipo_articulo','fecha_rquerida'];
}
