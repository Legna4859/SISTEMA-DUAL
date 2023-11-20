<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_tipo_eva extends Model
{
    //
    protected $table = 'ri_tipo_eva';
    protected $primaryKey='id_tipo_eva';
    protected $fillable=['des_eva'];
}
