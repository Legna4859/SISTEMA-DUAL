<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_o_potencialcrecimiento extends Model
{
    //
    protected $table = 'ri_o_potencialcrecimiento';
    protected $primaryKey='id_potencialcrecimiento';
    protected $fillable=['des_potencialcrecimiento','calificacion'];
}
