<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class ActividadesComplementarias extends Model
{
    protected $table = 'actividades_complementarias';
        //protected $fillable = ['*']; 
    protected $primaryKey='id_actividad_comple';
    protected $fillable=['descripcion','id_categoria','horas','creditos','id_jefatura','estado'];
}