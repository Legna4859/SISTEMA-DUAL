<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudNormatividad extends Model
{
    //
    protected $table='aud_normatividad';
    protected $primaryKey='id_normatividad';
    protected $fillable=['descripcion'];
}
