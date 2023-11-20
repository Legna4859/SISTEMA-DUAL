<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_o_probabilidad extends Model
{
    //
    protected $table = 'ri_o_probabilidad';
    protected $primaryKey='id_probabilidad';
    protected $fillable=['des_probabilidad','calificacion'];
}
