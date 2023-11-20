<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Eva_Tutor;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Storage;
use Session;

class Tu_Eva_JefeController extends Controller
{
    public function index()
    {
        $periodo=Session::get('periodo_actual');
        //dd($periodo);
        $id_usuario = Session::get('usuario_alumno');
        //dd($id_usuario);
        $cordinador_carrera=DB::selectOne('SELECT gnral_jefes_periodos.id_carrera 
from gnral_jefes_periodos,gnral_personales, exp_asigna_coordinador 
WHERE gnral_jefes_periodos.id_jefe_periodo = exp_asigna_coordinador.id_jefe_periodo 
  and exp_asigna_coordinador.id_personal= gnral_personales.id_personal 
  and gnral_personales.tipo_usuario= '.$id_usuario.' and gnral_jefes_periodos.id_periodo='.$periodo.'');

        if($cordinador_carrera == null) {


            $carrera = Db::selectOne('SELECT car.id_carrera,car.nombre FROM gnral_carreras car 
                                INNER JOIN gnral_jefes_periodos per
                                ON per.id_carrera = car.id_carrera
                                INNER JOIN gnral_personales pers
                                ON pers.id_personal = per.id_personal
                                WHERE pers.tipo_usuario = ' . $id_usuario . ' AND per.id_periodo = ' . $periodo . ' ');

        }else{
            $id_carrera=$cordinador_carrera->id_carrera;
        $carrera = Db::selectOne('SELECT car.id_carrera,car.nombre FROM gnral_carreras car where id_carrera='.$id_carrera.'');
    }
        $tutores = DB::SELECT('SELECT exp_asigna_t.id_asigna_generacion,tu_grupo_s.id_grupo_semestre,car.nombre carrera, car.id_carrera, tu_grupo_t.descripcion grupo, gnral_p.nombre nombre_tutor, gnral_p.tipo_usuario tipo FROM tu_grupo_tutorias tu_grupo_t
                              INNER JOIN tu_grupo_semestre tu_grupo_s
                              ON tu_grupo_s.id_grupo_tutorias = tu_grupo_t.id_grupo_tutorias
                              INNER JOIN exp_asigna_tutor exp_asigna_t 
                              ON exp_asigna_t.id_asigna_tutor = tu_grupo_s.id_asigna_tutor
                              INNER JOIN gnral_personales gnral_p 
                              ON gnral_p.id_personal = exp_asigna_t.id_personal 
                              INNER JOIN gnral_jefes_periodos gnral_j 
                              ON gnral_j.id_jefe_periodo = exp_asigna_t.id_jefe_periodo
                              INNER JOIN gnral_carreras car
                              ON car.id_carrera = gnral_j.id_carrera
                              WHERE gnral_j.id_periodo = '.$periodo.' AND car.id_carrera = '.$carrera->id_carrera.' ');
        $id_carrera=$carrera->id_carrera;

        //dd($tutores);
        return view('tutorias.eva_tutorias.cordinador_index',compact('tutores','carrera','id_carrera'));
    }
}
