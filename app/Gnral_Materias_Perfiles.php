<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gnral_Materias_Perfiles extends Model
{
    protected $table = 'gnral_materias_perfiles';
    protected $primaryKey = 'id_materia_perfil';
    protected $fillable = ['id_personal','id_materia','mostrar'];
}
