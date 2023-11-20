<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class oc_vehiculo extends Model
{
    protected $table='oc_vehiculo';
    protected $primaryKey='id_vehiculo';
    protected $fillable=['modelo','placas'];


}
