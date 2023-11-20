<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class Tutorias_Profesor extends Model
{

    public static function getAllGen(){
        $carrera=DB::select('SELECT * FROM datos_personales where id_user='.Auth::user()->id);
        $datos=DB::select('SELECT count(alumnos.id_alumno) cantidad, CASE alumnos.id_genero WHEN 1 THEN "Hombres" WHEN 2 THEN "Mujeres" END gen
        FROM asigna_semestre,alumnos,grupos,periodos,carreras
        where asigna_semestre.id_alumno=alumnos.id_alumno and
                asigna_semestre.id_grupo=grupos.id_grupo and
                alumnos.id_carrera=carreras.id_carrera and
                asigna_semestre.id_periodo=periodos.id_periodo and
                alumnos.id_carrera='.$carrera[0]->id_carrera.' group by alumnos.id_genero;');
        return $datos;
    }
    public static function getAlGen($id){

        $datos=DB::select('SELECT CASE alumnos.id_genero WHEN 1 THEN "Hombres" WHEN 2 THEN "Mujeres" END name, count(alumnos.id_alumno) y
        FROM asigna_semestre,alumnos,grupos,periodos,carreras
        where asigna_semestre.id_alumno=alumnos.id_alumno and
                asigna_semestre.id_grupo=grupos.id_grupo and
                alumnos.id_carrera=carreras.id_carrera and
                asigna_semestre.id_periodo=periodos.id_periodo and
                alumnos.id_carrera='.$id.' group by alumnos.id_genero;');
        return $datos;
    }


}
