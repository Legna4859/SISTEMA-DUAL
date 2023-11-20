<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorias_Exp_datos_familiare extends Model
{
    protected $table ="exp_datos_familiares";
    protected $primaryKey="id_exp_datos_familiares";
    //public $timestamps = false;
    protected $fillable=["nombre_padre","edad_padre","ocupacion_padre","lugar_residencia_padre","nombre_madre","edad_madre",
        "ocupacion_madre","lugar_residencia_madre","no_hermanos","lugar_ocupas","id_opc_vives","no_personas",
        "etnia_indigena","cual_etnia","hablas_lengua_indigena","sostiene_economia_hogar","id_familia_union","nombre_tutor",
        "id_parentesco","id_alumno"];

    public function vives (){
        return $this->hasOne('App\Tutorias_Exp_opc_vives','id_opc_vives','id_opc_vives');

    }
    public function union (){
        return $this->hasOne('App\Tutorias_Exp_familia_union','id_familia_union','id_familia_union');

    }
    public function parentesco (){
        return $this->hasOne('App\Tutorias_Exp_parentesco','id_parentesco','id_parentesco');

    }
}
