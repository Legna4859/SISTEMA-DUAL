<?php

namespace App\Http\Controllers;
use App\Tutorias_Plan_actividades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
class Tutorias_calendario_eventosController extends Controller
{

    public function index()
    {

        $id=Auth::user()->id;
        //DB::enableQueryLog();
        $evento=Tutorias_Plan_actividades::join('plan_asigna_planeacion_tutor','plan_asigna_planeacion_tutor.id_plan_actividad','=','plan_actividades.id_plan_actividad')
            ->join('exp_asigna_generacion','exp_asigna_generacion.id_generacion','=','plan_actividades.id_generacion')
            ->join('exp_asigna_alumnos','exp_asigna_alumnos.id_asigna_generacion','=','exp_asigna_generacion.id_asigna_generacion')


            ->join('exp_asigna_tutor', function ($join){
                $join->on('exp_asigna_tutor.id_asigna_generacion','=','plan_asigna_planeacion_tutor.id_asigna_generacion');
            })
            ->join('gnral_alumnos','exp_asigna_alumnos.id_alumno' , '=',  'gnral_alumnos.id_alumno')
            ->join('users','gnral_alumnos.id_usuario', '=', 'users.id')
            ->where('users.id','=',$id)

            ->whereRaw("exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion")


            ->where('plan_asigna_planeacion_tutor.id_estrategia','=', 1)
            ->whereNull ('exp_asigna_alumnos.deleted_at')
            ->whereNull('exp_asigna_tutor.deleted_at')

            ->select('plan_actividades.desc_actividad', 'plan_actividades.objetivo_actividad',
                'plan_actividades.fi_actividad', 'plan_actividades.ff_actividad',
                'plan_asigna_planeacion_tutor.estrategia')
            ->get();

        return view('tutorias.calendario_eventos.calendario_eventos')->with(compact( 'evento'));
    }


}
