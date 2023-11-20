<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resi_Periodo_eval_anteproyecto extends Model
{
    protected $table = 'resi_periodo_eval_anteproyecto';
    protected $primaryKey='id_periodo_eval_anteproyecto';
    protected $fillable=['id_periodo','fecha_inicio','fecha_final'];
}
