<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorias_Plan_asigna_evidencias extends Model
{
    //
    protected $table ="plan_asigna_evidencias";
    protected $primaryKey="id_evidencia";
    public $timestamps=false;
    protected $fillable=["evidencia","id_alumno","id_asigna_planeacion_tutor"];
}
