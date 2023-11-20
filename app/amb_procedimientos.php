<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class amb_procedimientos extends Model
{
    protected $table = 'amb_procedimientos';
    protected $primaryKey='id_procedimiento';
    protected $fillable=['nom_procedimiento'];
}
