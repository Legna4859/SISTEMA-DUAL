<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estados extends Model
{
       protected $table = 'gnral_estados';
    protected $primaryKey='id_estado';
    protected $fillable=['nombre_estado'];
}
