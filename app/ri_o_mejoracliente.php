<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_o_mejoracliente extends Model
{
    //
    protected $table = 'ri_o_mejoracliente';
    protected $primaryKey='id_mejoracliente';
    protected $fillable=['des_mejoracliente','calificacion'];
}
