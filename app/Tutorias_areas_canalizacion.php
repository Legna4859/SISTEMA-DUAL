<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorias_areas_canalizacion extends Model
{
    //
    protected $table ="areas_canalizacion";
    protected $primaryKey="id_area";
    protected $fillable=["descripcion_area"];
}
