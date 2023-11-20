<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gnral_Reticulas extends Model
{
	protected $table = 'gnral_reticulas';
    protected $fillable = ['clave','id_carrera'];
}
