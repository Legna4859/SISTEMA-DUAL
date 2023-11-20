<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SgcClasificacion extends Model
{
    //
    protected $table = 'aud_clasificacion';
    protected $primaryKey='id_clasificacion';
    protected $fillable=['descripcion'];
}
