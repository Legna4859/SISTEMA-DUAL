<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semestres extends Model
{
       protected $table = 'gnral_semestres';
       protected $primaryKey='id_semestre';
       protected $fillable=['descripcion'];
}
