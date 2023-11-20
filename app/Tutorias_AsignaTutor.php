<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class Tutorias_AsignaTutor extends Model
{
    public static function getTutores(){

        $dat=DB::select('SELECT gnral_personales.id_personal,exp_asigna_generacion.id_asigna_generacion, exp_asigna_tutor.id_asigna_tutor, gnral_personales.nombre, exp_asigna_generacion.grupo, exp_generacion.generacion 
                              from gnral_personales, exp_asigna_tutor,exp_asigna_generacion,exp_generacion where
                               exp_asigna_tutor.id_personal=gnral_personales.id_personal AND exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion AND 
                               exp_asigna_generacion.id_generacion=exp_generacion.id_generacion AND exp_asigna_tutor.deleted_at is null AND exp_asigna_tutor.id_jefe_periodo='.Session::get('id_jefe_periodo'));
        return $dat;
    }


}
