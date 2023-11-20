<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class calperiodosSumativas extends Model
{
    protected $table = 'cal_periodos_sumativas';
    protected $primaryKey='id_periodo_sum';
    protected $fillable=['fecha_inicio','fecha_fin','id_periodo'];
}
