<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RmBienes;


class RmCategoria extends Model
{
    protected $table = 'rm_categorias';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre','descripcion','condicion'];

    public function bienes()
    {
        return $this->hasMany('App\RmBienes','id_categoria','id');
    }

}
