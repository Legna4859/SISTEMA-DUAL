<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RmBienes;

class RmModelos extends Model
{
    protected $table = 'rm_modelos';
    protected $primaryKey = 'id';
    protected $fillable = ['modelo','condicion'];

    public function bienes()
    {
        return $this->hasMany('App\RmBienes','id_modelo');
    }
    public function scopeModelos($query, $modelos)
    {
        if ($modelos) {
            return $query->where('marcas', 'like', "%$modelos%");
        }
    }
}
