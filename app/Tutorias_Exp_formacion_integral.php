<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorias_Exp_formacion_integral extends Model
{
    protected $table ="exp_formacion_integral";
    protected $primaryKey="id_exp_formacion_integral";
    //public $timestamps = false;
    protected $fillable=["practica_deporte","especifica_deporte","practica_artistica","especifica_artistica","pasatiempo",
        "actividades_culturales","cuales_act","estado_salud","enfermedad_cronica","especifica_enf_cron","enf_cron_padre",
        "especifica_enf_cron_padres","operacion","deque_operacion","enfer_visual","especifica_enf","usas_lentes",
        "medicamento_controlado","especifica_medicamento","estatura","peso","accidente_grave","relata_breve","id_expbebidas","id_alumno"];

    public function escala (){
        return $this->hasMany('App\Tutorias_Exp_bebidas','id_expbebidas','id_expbebidas');

    }
}
