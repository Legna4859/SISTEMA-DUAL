<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_clasif_factor extends Model
{
    //
    protected $table = 'ri_clasif_factor';
    protected $primaryKey='id_cl_f';
    protected $fillable=['des_cl_f'];
}
