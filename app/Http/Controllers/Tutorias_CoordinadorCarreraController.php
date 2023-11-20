<?php

namespace App\Http\Controllers;
use App\Tutorias_Exp_generacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Gnral_Jefes_Periodos;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

use Session;

class Tutorias_CoordinadorCarreraController extends Controller
{
    //
    public function carreras()
    {


        $carreras=DB::select('select gnral_carreras.nombre,gnral_carreras.id_carrera from exp_asigna_coordinador
            JOIN gnral_personales ON exp_asigna_coordinador.id_personal=gnral_personales.id_personal 
            JOIN gnral_jefes_periodos ON exp_asigna_coordinador.id_jefe_periodo=gnral_jefes_periodos.id_jefe_periodo 
            JOIN gnral_carreras ON gnral_carreras.id_carrera=gnral_jefes_periodos.id_carrera WHERE exp_asigna_coordinador.id_jefe_periodo 
            IN (SELECT gnral_jefes_periodos.id_jefe_periodo from gnral_jefes_periodos 
            JOIN gnral_personales ON gnral_personales.id_personal=gnral_jefes_periodos.id_personal where gnral_jefes_periodos.id_periodo='.Session::get('periodo_actual').') AND 
            exp_asigna_coordinador.deleted_at is null AND gnral_personales.tipo_usuario='.Auth::user()->id.'  ORDER BY gnral_carreras.nombre ');
       /* $carreras=DB::table('exp_asigna_coordinador')
            ->join('gnral_personales','gnral_personales.id_personal','=','exp_asigna_coordinador.id_personal')
            ->join('gnral_jefes_periodos','exp_asigna_coordinador.id_jefe_periodo','=','gnral_jefes_periodos.id_jefe_periodo')
            ->join('gnral_carreras','gnral_carreras.id_carrera','=','gnral_jefes_periodos.id_carrera')
            ->whereIn('exp_asigna_coordinador.id_jefe_periodo',DB::raw('SELECT gnral_jefes_periodos.id_jefe_periodo from gnral_jefes_periodos where gnral_jefes_periodos.id_periodo='.Session::get('id_periodo')))
            ->whereNull('exp_asigna_coordinador.deleted_at')
            ->select('gnral_carreras.nombre','gnral_carreras.id_carrera')
            ->orderBy('gnral_carreras.nombre')
            ->get();*/
        return $carreras;
    }
    public function carreras1()
    {

        $carreras=DB::select('select gnral_carreras.nombre,gnral_carreras.id_carrera from exp_asigna_coordinador
            JOIN gnral_personales ON exp_asigna_coordinador.id_personal=gnral_personales.id_personal 
            JOIN gnral_jefes_periodos ON exp_asigna_coordinador.id_jefe_periodo=gnral_jefes_periodos.id_jefe_periodo 
            JOIN gnral_carreras ON gnral_carreras.id_carrera=gnral_jefes_periodos.id_carrera WHERE exp_asigna_coordinador.id_jefe_periodo 
            IN (SELECT gnral_jefes_periodos.id_jefe_periodo from gnral_jefes_periodos where gnral_jefes_periodos.id_periodo='.Session::get('periodo_actual').') AND 
            exp_asigna_coordinador.deleted_at is null ORDER BY gnral_carreras.nombre ');
        /* $carreras=DB::table('exp_asigna_coordinador')
             ->join('gnral_personales','gnral_personales.id_personal','=','exp_asigna_coordinador.id_personal')
             ->join('gnral_jefes_periodos','exp_asigna_coordinador.id_jefe_periodo','=','gnral_jefes_periodos.id_jefe_periodo')
             ->join('gnral_carreras','gnral_carreras.id_carrera','=','gnral_jefes_periodos.id_carrera')
             ->whereIn('exp_asigna_coordinador.id_jefe_periodo',DB::raw('SELECT gnral_jefes_periodos.id_jefe_periodo from gnral_jefes_periodos where gnral_jefes_periodos.id_periodo='.Session::get('id_periodo')))
             ->whereNull('exp_asigna_coordinador.deleted_at')
             ->select('gnral_carreras.nombre','gnral_carreras.id_carrera')
             ->orderBy('gnral_carreras.nombre')
             ->get();*/
        return $carreras;
    }
    public function generaciones(Request $request)

    {

        $periodo = Session::get('periodo_actual');
        $jefeperiodo=Gnral_Jefes_Periodos::where('id_periodo',$periodo)
                        ->where('id_carrera',$request->id_carrera)
                        ->get();
        Session::put('id_jefe_periodo',$jefeperiodo[0]->id_jefe_periodo);

        $generaciones=Tutorias_Exp_generacion::all();
        $generaciones->map(function ($value,$key){
            $value->grupos=DB::select('SELECT *FROM exp_asigna_generacion  where exp_asigna_generacion.deleted_at is null
 and id_jefe_periodo='.Session::get('id_jefe_periodo').' and id_generacion='.$value->id_generacion);
        });
        return $generaciones;
    }

}
