<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_o_planseguimiento extends Model
{
    //
    protected $table = 'ri_o_planseguimiento';
    protected $primaryKey='id_planseguimiento';
    protected $fillable=['des_planseguimiento','id_oportunidad','fecha_inicial','fecha','file','status'];

}
