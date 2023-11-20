<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class oc_notificacion extends Model
{
    protected $table='oc_estado_oficio';
    protected $primaryKey='id_notificacion';
    protected $fillable=['descripcion'];
}
