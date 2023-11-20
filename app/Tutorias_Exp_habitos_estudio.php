<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorias_Exp_habitos_estudio extends Model
{
    protected $table ="exp_habitos_estudio";
    protected $primaryKey="id_exp_habitos_estudio";
    //public $timestamps = false;
    protected $fillable=["tiempo_empleado_estudiar", "id_opc_intelectual","forma_estudio","tiempo_libre",
        "asignatura_preferida","porque_asignatura","asignatura_dificil","porque_asignatura_dificil","opinion_tu_mismo_estudiante","id_alumno"];

    public function intelectual (){
        return $this->hasOne('App\Tutorias_Exp_opc_intelectual','id_opc_intelectual','id_opc_intelectual');
    }
    public function tiempo (){
        return $this->hasMany('App\Tutorias_Exp_tiempoestudia','id_tiempoestudia','tiempo_empelado_estudiar');

    }
}
