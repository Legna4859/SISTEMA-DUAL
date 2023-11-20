<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Session;

class Tutorias_AsignaCoordinador extends Model
{


    public static function getCoordinador(){

        $datos=DB::select('SELECT exp_asigna_coordinador.id_asigna_coordinador,exp_asigna_coordinador.id_personal,gnral_personales.nombre 
                                  FROM exp_asigna_coordinador,gnral_personales where exp_asigna_coordinador.id_personal=gnral_personales.id_personal and exp_asigna_coordinador.deleted_at is null and 
                                  exp_asigna_coordinador.id_jefe_periodo='.Session::get('id_jefe_periodo'));
        return $datos;
    }

    public static function getAllProf(){


        $profesores=DB::select('select gnral_personales.id_personal,gnral_personales.nombre FROM
                                gnral_personales, gnral_horarios WHERE
                                gnral_horarios.id_periodo_carrera='.Session::get('id_periodo_carrera').' AND
                                gnral_horarios.id_personal=gnral_personales.id_personal');
        return $profesores;
    }
}
