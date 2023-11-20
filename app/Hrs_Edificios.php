<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hrs_Edificios extends Model
{
    protected $table = 'hrs_edificios';
    protected $primaryKey = 'id_edificio';
    protected $fillable = ['nombre'];
    public $timestamps = true;


}
