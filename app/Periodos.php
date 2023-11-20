<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodos extends Model
{
     protected $table = 'gnral_periodos';
    protected $primaryKey='id_periodo';
    protected $fillable=['periodo'];
}
