<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class calPeriodos extends Model
{
    protected $table = 'cal_periodos_califica';
    protected $primaryKey='id_periodo_cal';
    protected $fillable=['fecha','id_unidad','id_periodos','id_materia','id_grupo','evaluada'];
}
