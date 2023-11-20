<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_o_potencialapertura extends Model
{
    //
    protected $table = 'ri_o_potencialapertura';
    protected $primaryKey='id_potencialapertura';
    protected $fillable=['des_potencialapertura','calificacion'];
}
