<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_o_mejorasgc extends Model
{
    //
    protected $table = 'ri_o_mejorasgc';
    protected $primaryKey='id_mejorasgc';
    protected $fillable=['des_mejorasgc','calificacion'];
}
