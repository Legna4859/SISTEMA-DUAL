<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorias_Exp_beca extends Model
{
    //
    protected $table ="exp_beca";
    protected $primaryKey="id_expbeca";
    protected $fillable=["descripcion_beca"];
}
