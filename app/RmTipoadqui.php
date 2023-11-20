<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RmTipoadqui extends Model
{
    protected $table = 'rm_tipoadqui';
    protected $primaryKey = 'id';
    protected $fillable = ['tipoadqui'];

    public function bienes()
    {
        return $this->hasMany('App\RmBienes','id_adqui');
    }
}
