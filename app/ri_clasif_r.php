<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_clasif_r extends Model
{
    //
    protected $table = 'ri_clasif_r';
    protected $primaryKey='id_cl_r';
    protected $fillable=['des_cl'];
}
