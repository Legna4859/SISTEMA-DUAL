<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class riseleccion extends Model
{
    //
        protected $table = 'ri_seleccion';
        protected $primaryKey='id_seleccion';
        protected $fillable=['des_seleccion'];
}
