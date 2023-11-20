<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalCanalizacion extends Model
{
    //
    protected $table = 'cal_canalizacion';
    protected $primaryKey='id';
    protected $fillable=['descripcion'];
}
