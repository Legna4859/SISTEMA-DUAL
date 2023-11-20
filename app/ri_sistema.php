<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ri_sistema extends Model
{
    //
    protected $table = 'ri_sistema';
    protected $primaryKey='id_sistema';
    protected $fillable=['desc_sistema'];
}
