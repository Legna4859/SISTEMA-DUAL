<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class in_nivel_ingles extends Model
{
    protected $table='in_nivel_ingles';
    protected $primaryKey='id_nivel_ingles';
    protected $fillable=['descripcion'];
}
