<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RmColores extends Model
{
    protected $table = 'rm_colores';
    protected $primaryKey = 'id';
    protected $fillable = ['color'];

    public function bienes()
    {
        return $this->hasMany('App\RmBienes','id_color');
    }
}
