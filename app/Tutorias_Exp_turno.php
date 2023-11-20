<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorias_Exp_turno extends Model
{
    protected $table ="exp_turno";
    protected $primaryKey="id_turno";
    protected $fillable=["descripcion_turno"];
}
