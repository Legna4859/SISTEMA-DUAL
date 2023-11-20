<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_nivel_decision extends Model
{
    //
    protected $table = 'ri_nivel_decision';
    protected $primaryKey='id_nivel_de';
    protected $fillable=['des_nivel_des'];
}
