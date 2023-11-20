<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SgcNormatividad extends Model
{
    //
    protected $table = 'aud_normatividad';
    protected $primaryKey='id_normatividad';
    protected $fillable=['descripcion'];
}
