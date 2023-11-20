<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudObjetivo extends Model
{
    //
    protected $table='aud_objetivo';
    protected $primaryKey='id_objetivo';
    protected $fillable=['descripcion'];
}
