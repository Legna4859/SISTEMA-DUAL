<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inc_solicitude  extends Model
{

    protected $fillable = [
        'id_articulo',
        'fecha_req',
        'motivo_oficio',
        'hora_e',
        'hora_st',
        'fecha_invac',
        'fecha_tervac',
        'ingreso_a_la_institucion',
        'hora_e1',
        'hora_s1',
        'hora_e2',
        'hora_s2',
        'id_estado_solicitud',
        'id_personal',
        'id_jefe',
        'arch_solicitud',
    ];
}
