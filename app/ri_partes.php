<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_partes extends Model
{
    //
    protected $table = 'ri_partes';
    protected $primaryKey='id_parte';
    protected $fillable=['des_parte'];
}
