<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class oc_oficio_vehiculo extends Model
{
    protected $table = 'oc_oficio_vehiculo';
    protected $primaryKey='id_oficio_vehiculo';
    protected $fillable=['id_oficio','id_vehiculo','fecha_salida', 'fecha_regreso','licencia'];


}
