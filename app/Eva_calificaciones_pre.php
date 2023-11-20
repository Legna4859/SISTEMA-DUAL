<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eva_calificaciones_pre extends Model
{
    protected $table = 'abreviaciones';
    protected $primaryKey='id';
    protected $fillable=['titulo','id_periodo','no_pregunta','calificacion_p','id_hrs_profesor','id_criterio'];
}