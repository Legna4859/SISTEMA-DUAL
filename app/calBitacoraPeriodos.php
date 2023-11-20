<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class calBitacoraPeriodos extends Model
{
    protected $table = 'cal_bitacora_periodos';
    protected $primaryKey='id_bitacora_periodo';
    protected $fillable=['id_periodo_cal','id_unidad','id_grupo','id_materia','docente','fecha_antigua','fecha_nueva','id_periodo'];
}
