<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ritipo_f extends Model
{
    //
    protected $table = 'ri_tipo_f';
    protected $primaryKey='id_tipo_f';
    protected $fillable=['des_tf'];
}
