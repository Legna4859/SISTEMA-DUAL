<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_o_potencialcosto extends Model
{
    //
    protected $table = 'ri_o_potencialcosto';
    protected $primaryKey='id_potencialcosto';
    protected $fillable=['des_potencialcosto'];
}
