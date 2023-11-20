<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorias_subareas_canalizacion extends Model
{
    protected $table ="subareas_canalizacion";
    protected $primaryKey="id_subarea";
    protected $fillable=["descripcion_subarea"];
}
