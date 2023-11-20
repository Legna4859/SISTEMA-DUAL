<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_o_mejorareputacion extends Model
{
    //
    protected $table = 'ri_o_mejorareputacion';
    protected $primaryKey='id_mejorareputacion';
    protected $fillable=['des_mejorareputacion','calificacion'];
}
