<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RmBienes;

class RmEstadouso extends Model
{
    protected $table = 'rm_estadousos';
    protected $primaryKey = 'id';
    protected $fillable = ['estado'];

    public function bienes()
    {
        return $this->hasMany('App\RmBienes','id_estado');
    }
}
