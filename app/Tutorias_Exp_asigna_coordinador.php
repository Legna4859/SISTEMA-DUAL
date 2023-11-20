<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tutorias_Exp_asigna_coordinador extends Model
{
    //

    protected $dates = ['deleted_at'];
    protected $table ="exp_asigna_coordinador";
    protected $primaryKey="id_asigna_coordinador";
    protected $fillable=["id_jefe_periodo","id_personal"];

}
