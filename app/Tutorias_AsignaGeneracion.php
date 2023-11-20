<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;
class Tutorias_AsignaGeneracion extends Model
{
    //
    public static function getList($datos){
        $datos=DB::select('SELECT asigna_semestre.id_grupo, alumnos.nombre FROM asigna_semestre,alumnos,grupos,periodos where
        asigna_semestre.id_alumno=alumnos.id_alumno and
        asigna_semestre.id_grupo=grupos.id_grupo and
        asigna_semestre.id_periodo=periodos.id_periodo and
        grupos.desc_grupo="'.$datos->id.'" and
        alumnos.id_carrera='.$datos->carrera);
        //dd($datos);
        return $datos;
    }
    public static function getAll($id){
        $carrera=DB::select('SELECT datos_personales.id_carrera FROM sistematutorias.datos_personales where
        datos_personales.id_user='.Auth::user()->id.';');
        //dd();
        $datos=DB::select('select datos_personales.nombre,grupos.desc_grupo,datos_personales.id_carrera,asigna_generacion.generacion from asigna_generacion,grupos,users,datos_personales where
        asigna_generacion.id_grupo=grupos.id_grupo and
        asigna_generacion.id_tutor=users.id and
        datos_personales.id_user=users.id and
        asigna_generacion.generacion='.$id->id.' and
        datos_personales.id_carrera='.$carrera[0]->id_carrera);
        //dd($datos);
        return $datos;
    }
    public static function getAllGeneracion(){
        $carrera=DB::select('SELECT datos_personales.id_carrera FROM sistematutorias.datos_personales where
        datos_personales.id_user='.Auth::user()->id.';');
        //dd($carrera[0]->id_carrera);
        $datos=DB::select('select asigna_generacion.generacion from asigna_generacion,grupos,users,datos_personales where
        asigna_generacion.id_grupo=grupos.id_grupo and
        asigna_generacion.id_tutor=users.id and
        datos_personales.id_user=users.id and
        datos_personales.id_carrera='.$carrera[0]->id_carrera.' group by asigna_generacion.generacion;');
        //dd($datos);
        return $datos;
    }
}
