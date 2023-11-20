<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudAreaGeneralUnidad extends Model
{
    //
    protected $table = 'aud_area_general_unidad';
    protected $primaryKey='id_area_general_unidad';
    protected $fillable=['id_area_general','id_unidad_admin'];
}
