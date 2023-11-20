<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudNota extends Model
{
    //
    protected $table = 'aud_notas';
    protected $primaryKey='id_notas';
    protected $fillable=['id_reporte', 'punto_proceso', 'observaciones','id_clasificacion','autorizacion',"resultado"];
}
