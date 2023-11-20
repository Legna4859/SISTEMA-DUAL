<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tutorias_Exp_generale extends Model
{
    protected $table ="exp_generales";
    protected $primaryKey="id_exp_general";
    protected $fillable=["id_carrera","id_periodo","id_grupo","nombre","edad","sexo","fecha_nacimientos","lugar_nacimientos","id_semestre",
        "id_estado_civil","no_hijos","direccion","correo","tel_casa","cel","nivel_economico","trabaja","ocupacion",
        "horario","no_cuenta","beca","id_expbeca","estado","turno","poblacion","ant_inst","satisfaccion_c","materias_repeticion","tot_repe",
        "materias_especial","tot_espe","gen_espe","id_alumno","foto"];
    public function carrera (){
        return $this->hasOne('App\Carreras','id_carrera','id_carrera');

    }
    public function periodo (){
        return $this->hasOne('App\Periodos','id_periodo','id_periodo');

    }
    public function grupo (){
        return $this->hasOne('App\Gnral_grupos','id_grupo','id_grupo');

    }
    public function semestre (){
        return $this->hasOne('App\Semestres','id_semestre','id_semestre');

    }
    public function civil (){
        return $this->hasOne('App\Tutorias_Exp_civil_estado','id_estado_civil','id_estado_civil');

    }
    public function turno1 (){
        return $this->hasOne('App\Tutorias_Exp_turno','id_turno','turno');

    }
    public function beca (){
        return $this->hasOne('App\Tutorias_Exp_beca','id_expbeca','id_expbeca');

    }
}
