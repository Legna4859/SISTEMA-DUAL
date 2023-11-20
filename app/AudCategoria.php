<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudCategoria extends Model
{
    //
    protected $table='aud_categoria';
    protected $primaryKey='id_categoria';
    protected $fillable=['descripcion'];
}
