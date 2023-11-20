<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudAreaGeneral extends Model
{
    //
    protected $table = 'aud_area_general';
    protected $primaryKey='id_area_general';
    protected $fillable=['descripcion'];
}
