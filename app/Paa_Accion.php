<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paa_Accion extends Model
{
    protected $table='pa_accion';
    protected $primaryKey='id_accion';
    protected $fillable=['nom_accion','id_unimed'];
}
