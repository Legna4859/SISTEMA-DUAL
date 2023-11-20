<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class in_titulo extends Model
{
    protected $table='in_titulo';
    protected $primaryKey='id_titulo';
    protected $fillable=['descripcion'];
}
