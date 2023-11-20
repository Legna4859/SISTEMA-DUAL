<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gnral_Cargos extends Model
{
    protected $table = 'gnral_cargos';
    protected $primaryKey='id_cargo';
    protected $fillable=['cargo','abre'];
}