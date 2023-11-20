<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Tutorias_Exp_asigna_tutor extends Model
{
    //

    protected $dates = ['deleted_at'];
    protected $table ="exp_asigna_tutor";
    protected $primaryKey="id_asigna_tutor";
    protected $fillable=["id_jefe_periodo","id_personal","id_asigna_generacion"];

}
