<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paa_UnidadMedida extends Model
{
    protected $table='pa_unimed';
    protected $primaryKey='id_unimed';
    protected $fillable=['nom_unimed'];
}
