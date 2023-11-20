<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Alumnos;
use App\Http\Requests;

use Session;

use Illuminate\Support\Facades\Auth;
use App\User;

class Tutorias_inicioController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
  public function index(){
      $tipo_p = Session::get('tipo_persona');
      $id_usuario = Session::get('usuario_alumno');
      $periodo = Session::get('periodo_actual');


      Session::put('sistemas_tutorias',true);
      $per_f = DB::selectOne('SELECT count(p.estado)  con FROM tu_eva_periodo p WHERE p.id_periodo = '.$periodo.' and p.estado = 2 ');

      if ($per_f->con == 0)
      {
          Session::put('estado_eva_f',false);
      }
      else
      {
          Session::put('estado_eva_f',true);
      }

      if ($tipo_p==1) {

          $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` WHERE `id_usuario` = '.$id_usuario.'');
          Session::put('cuenta',$alumno->cuenta);
          Session::put('nombre',mb_strtoupper(($alumno->apaterno." ".$alumno->amaterno." ".$alumno->nombre),'utf-8'));
          Session::put('id_alumno',$alumno->id_alumno);

          $tutorasignado=DB::table('exp_asigna_alumnos')
              ->join('exp_asigna_tutor','exp_asigna_tutor.id_asigna_generacion','=','exp_asigna_alumnos.id_asigna_generacion')
              ->join('gnral_jefes_periodos','gnral_jefes_periodos.id_jefe_periodo','=','exp_asigna_tutor.id_jefe_periodo')
              ->join('gnral_personales','gnral_personales.id_personal','=','exp_asigna_tutor.id_personal')
              ->join('exp_asigna_generacion','exp_asigna_generacion.id_asigna_generacion','exp_asigna_alumnos.id_asigna_generacion')
              ->join('exp_generacion','exp_generacion.id_generacion','exp_asigna_generacion.id_generacion')
              ->select('gnral_personales.nombre','exp_generacion.generacion','exp_asigna_generacion.grupo','exp_asigna_alumnos.id_asigna_generacion')
              ->whereNull('exp_asigna_alumnos.deleted_at')
              ->whereNull('exp_asigna_tutor.deleted_at')
              ->where('gnral_jefes_periodos.id_periodo','=',$periodo)
              ->where('exp_asigna_alumnos.id_alumno','=',$alumno->id_alumno)
              ->get();

          if (count($tutorasignado)>0)
          {
              $per = DB::selectOne('SELECT count(p.estado)  con FROM tu_eva_periodo p WHERE p.id_periodo = '.$periodo.' and p.estado = 1 ');
              //dd($per);
              if ($per->con == 0)
              {
                  Session::put('estado_eva',false);
              }
              else
              {
                  Session::put('estado_eva',true);
              }
              Session::put('generacion_asignada','Generación '.$tutorasignado[0]->generacion." Grupo ".$tutorasignado[0]->grupo);
              Session::put('tutor_asignado',$tutorasignado[0]->nombre);
              //dd($tutorasignado);
              return redirect('/tutorias/inicioalu');
          }
          else{
              return "No se ha asignado un tutor";
          }

          // return redirect('/panel');
      }else
          if ($tipo_p==2) {
              //dd($user);

              $jefe = DB::table('gnral_personales')
                  ->join('gnral_jefes_periodos', 'gnral_jefes_periodos.id_personal', '=', 'gnral_personales.id_personal')
                  ->join('gnral_carreras', 'gnral_jefes_periodos.id_carrera', '=', 'gnral_carreras.id_carrera')
                  ->where('gnral_jefes_periodos.id_periodo', '=',$periodo)
                  ->where('gnral_personales.tipo_usuario', '=', $id_usuario)
                  ->select('gnral_personales.nombre', 'gnral_personales.id_departamento', 'gnral_jefes_periodos.id_carrera', 'gnral_jefes_periodos.id_personal',
                      'gnral_carreras.nombre as carrera', 'gnral_jefes_periodos.id_periodo', 'gnral_jefes_periodos.id_jefe_periodo')
                  ->get();


              $tutor = DB::selectOne('SELECT * FROM `gnral_personales` WHERE `tipo_usuario` = '.$id_usuario.'');

              //dd($tutor[0]->id_departamento);
              $estutor = DB::select('SELECT id_asigna_tutor from exp_asigna_tutor where id_personal=' . $tutor->id_personal . '
             AND exp_asigna_tutor.deleted_at is null and id_jefe_periodo in (Select id_jefe_periodo from gnral_jefes_periodos where id_periodo=' .$periodo . ')');

              $escoordinador = DB::select('SELECT id_asigna_coordinador from exp_asigna_coordinador where id_personal=' . $tutor->id_personal . '
             AND exp_asigna_coordinador.deleted_at is null and id_jefe_periodo in (Select id_jefe_periodo from gnral_jefes_periodos where id_periodo=' .$periodo. ')');

             if(count($escoordinador)){
                 Session::put('id_asigna_coordinador', $escoordinador[0]->id_asigna_coordinador);
             }else{
                 Session::put('id_asigna_coordinador', 0);
             }


              $escoordinadorgeneral = DB::select('SELECT id_asigna_coordinador_general
                                                        from desarrollo_asigna_coordinador_general
                                                        where id_personal=' . $tutor->id_personal . '
                                                        AND desarrollo_asigna_coordinador_general.deleted_at is null');

              //$esdesarrollo=DB::select();
              if ($jefe->count() > 0 && $jefe[0]->id_departamento == 2) {
                  $periodo_carrera = DB::select('SELECT id_periodo_carrera from gnral_periodo_carreras where id_carrera=' . $jefe[0]->id_carrera . ' and id_periodo=' . $jefe[0]->id_periodo);
                  //dd($periodo_carrera);
                  Session::put('id_periodo_carrera', $periodo_carrera[0]->id_periodo_carrera);
                  Session::put('jefe', $jefe[0]->id_carrera);
                  Session::put('nombre', $jefe[0]->nombre);
                  Session::put('id_jefe_periodo', $jefe[0]->id_jefe_periodo);
                  return view('tutorias.home');
              }

              if (count($estutor) > 0 ) {
                  //Session::put('coordinador',AsignaCoordinador::isCoordinador());
                  Session::put('tutor', count($estutor));
                  Session::put('nombre', $tutor->nombre);
              }else{
                  Session::put('tutor',0);
              }

              if (count($escoordinador) > 0) {
                  //Session::put('coordinador',AsignaCoordinador::isCoordinador());
                  Session::put('coordinador', count($escoordinador));
                  Session::put('nombre', $tutor->nombre);
              }else{
                  Session::put('coordinador', 0);
              }
              if (count($escoordinadorgeneral) > 0) {
                  //Session::put('coordinador',AsignaCoordinador::isCoordinador());
                  Session::put('coordinadorgeneral', count($escoordinadorgeneral));
                  Session::put('PuestoTutorias', 'coordinadorgeneral');
                  Session::put('nombre', $tutor->nombre);
              }
              if ($tutor->id_departamento == 4) {
                  //Session::put('coordinador',AsignaCoordinador::isCoordinador());
                  Session::put('desarrollo', $tutor->id_personal);
                  Session::put('PuestoTutorias', 'desarrollo');
                  Session::put('nombre', $tutor->nombre);
                  //Session::put('departamento',$tutor[0]->id-);
              }
          }
              return view('tutorias.home');
  }
}
