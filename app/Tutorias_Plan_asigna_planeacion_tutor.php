<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Tutorias_Plan_asigna_planeacion_tutor extends Model
{

    protected $table='plan_asigna_planeacion_tutor';
    protected $primaryKey='id_asigna_planeacion_tutor';
    protected $fillable=['id_asigna_planeacion_actividad','id_asigna_generacion','id_estrategia','estrategia','requiere_evidencia','boton'];


    public static function getDatosAct(){

        $datos=DB::select('SELECT plan_actividades.*,plan_asigna_planeacion_tutor.requiere_evidencia,plan_asigna_planeacion_tutor.*
                                    FROM plan_actividades,exp_generacion,exp_asigna_generacion,exp_asigna_tutor
                                    ,exp_asigna_alumnos,plan_asigna_planeacion_tutor,plan_asigna_planeacion_actividad,gnral_alumnos,users
                                    WHERE exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
                                    AND exp_asigna_generacion.id_asigna_generacion= exp_asigna_alumnos.id_asigna_generacion
                                    AND exp_asigna_generacion.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                                    AND exp_asigna_tutor.id_asigna_tutor=plan_asigna_planeacion_tutor.id_asigna_tutor
                                    AND plan_actividades.id_plan_actividad=plan_asigna_planeacion_actividad.id_plan_actividad
                                    and plan_asigna_planeacion_actividad.id_asigna_planeacion_actividad=plan_asigna_planeacion_tutor.id_asigna_planeacion_actividad
                                    AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno
                                    AND gnral_alumnos.id_usuario=users.id
                                    AND users.id='.Auth::user()->id.'
                                    AND plan_asigna_planeacion_tutor.id_estrategia=1');
        return $datos;
    }
}
