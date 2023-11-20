<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorias_Exp_bebidas extends Model
{
    //
    protected $table ="exp_bebidas";
    protected $primaryKey="id_expbebida";

    protected $fillable=["descripcion_bebida"];
}
