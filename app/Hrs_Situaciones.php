<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;﻿

class Hrs_Situaciones extends Model
{
	//use SoftDeletes;

    protected $table = 'hrs_situaciones';
    protected $primaryKey = 'id_situacion';
    protected $fillable = ['situacion','abrevia'];
}
