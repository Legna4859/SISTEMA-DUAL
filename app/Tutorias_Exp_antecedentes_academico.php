<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorias_Exp_antecedentes_academico extends Model
{
    protected $table ="exp_antecedentes_academicos";
    protected $primaryKey="id_exp_antecedentes_academicos";
    //public $timestamps = false;
    protected $fillable=["id_bachillerato", "otros_estudios","anos_curso_bachillerato","ano_terminacion",
        "escuela_procedente","promedio","materias_reprobadas","otra_carrera_ini","institucion","semestres_cursados",
        "interrupciones_estudios","razones_interrupcion","razon_descide_estudiar_tesvb","sabedel_perfil_profesional",
        "otras_opciones_vocales","cuales_otras_opciones_vocales","tegusta_carrera_elegida","porque_carrera_elegida",
        "suspension_estudios_bachillerato","razones_suspension_estudios","teestimula_familia","id_alumno"];

    public function bachillerato (){
        return $this->hasMany('App\Tutorias_Exp_bachillerato','id_bachillerato','id_bachillerato');

    }
}
