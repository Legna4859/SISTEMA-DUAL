<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RmTipobienes extends Model
{
    protected $table = 'rm_tipobienes';
    protected $primaryKey = 'id';
    protected $fillable = ['tipob'];


    public function bienes()
    {
        return $this->hasMany('App\RmBienes','id_tipob');
    }
}
