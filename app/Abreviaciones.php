<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Abreviaciones extends Model
{
    protected $table = 'abreviaciones';
    protected $primaryKey='id_abreviacion';
    protected $fillable=['titulo'];
}