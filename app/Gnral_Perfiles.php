<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gnral_Perfiles extends Model
{
    protected $table = 'gnral_perfiles';
    protected $primaryKey='id_perfil';
    protected $fillable=['descripcion'];
}