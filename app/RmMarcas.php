<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RmBienes;

class RmMarcas extends Model
{
    protected $table  = 'rm_marcas';
    protected $primaryKey = 'id';
    protected $fillable = ['marca','condicion'];

    public function bienes()
    {
        return $this->hasMany('App\RmBienes','id_marca');
    }
    public function scopeMarcas($query, $marcas)
    {
        if ($marcas) {
            return $query->where('marcas', 'like', "%$marcas%");
        }
    }

}
