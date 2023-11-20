<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carreras extends Model
{
        protected $table = 'gnral_carreras';
    protected $primaryKey='id_carrera';
    protected $fillable=['nombre','COLOR'];
}
