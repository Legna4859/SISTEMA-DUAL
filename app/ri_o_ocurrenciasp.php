<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_o_ocurrenciasp extends Model
{
    //
    protected $table = 'ri_o_ocurrenciasp';
    protected $primaryKey='id_ocurrenciap';
    protected $fillable=['des_ocurrenciasp','calificacion'];
}

