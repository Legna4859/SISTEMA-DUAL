<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hrs_No_Horas_Docentes extends Model
{
    protected $table = 'hrs_no_horas_docentes';
    protected $primaryKey = 'id_horas_docente';
    protected $fillable = ['id_profesor','no_total','id_periodo','id_cargo'];
}
