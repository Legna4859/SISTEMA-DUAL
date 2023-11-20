<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaAct extends Model
{
    protected $table = 'actcomple_categorias';
    protected $primaryKey='id_categoria';
    protected $fillable = ['descripcion_cat'];
}
