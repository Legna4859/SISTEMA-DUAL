<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorias_Exp_tiempoestudia extends Model
{
    protected $table ="exp_tiempoestudia";
    protected $primaryKey="id_tiempoestudia";
    protected $fillable=["descripcion_tiempo"];
}
