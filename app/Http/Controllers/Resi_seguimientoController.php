<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

use Session;
class Resi_seguimientoController extends Controller
{
    public function  index(){
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;

        $seguimiento= DB::selectOne('SELECT resi_anteproyecto.id_anteproyecto 
from resi_anteproyecto,resi_asesores where resi_anteproyecto.id_anteproyecto=resi_asesores.id_anteproyecto 
and resi_asesores.id_periodo='.$periodo.' and resi_anteproyecto.id_alumno='.$alumno.' ');
        $id_anteproyecto=$seguimiento->id_anteproyecto;
        $cronogramas=DB::select('SELECT * FROM `resi_cronograma` WHERE `id_anteproyecto` = '.$id_anteproyecto.' ORDER BY `no_semana` ASC');
        //dd($cronogramas);
        foreach ($cronogramas as $cronograma){
            $contar_evaluacion=DB::selectOne('SELECT count(id_promedios) promedio from resi_promedio_rubros where id_cronograma='.$cronograma->id_cronograma.'');

            if($contar_evaluacion->promedio == 0 ){
                $semana= DB::selectOne('SELECT * FROM `resi_cronograma` WHERE `id_cronograma` = '.$cronograma->id_cronograma.' ORDER BY `no_semana` ASC');
                $fecha_termino=$semana->f_termino;
                // dd($fecha_termino);
                $fecha_actual = date("Y-m-d");
                $fecha_termino=date("Y-m-d",strtotime($fecha_termino."+21 days"));
                if($fecha_termino < $fecha_actual){
                    $comentario="El docente no evaluo en tiempo y forma";
                    DB:: table('resi_rubro_actitud')->insert(['id_cronograma' =>$semana->id_cronograma,'calificacion' =>0,'id_anteproyecto' =>$semana->id_anteproyecto,'semana'=>$semana->no_semana]);
                    DB:: table('resi_rubro_aplicacion')->insert(['id_cronograma' =>$semana->id_cronograma,'calificacion' =>0,'id_anteproyecto' =>$semana->id_anteproyecto,'semana'=>$semana->no_semana]);
                    DB:: table('resi_rubro_calidad')->insert(['id_cronograma' =>$semana->id_cronograma,'calificacion' =>0,'id_anteproyecto' =>$semana->id_anteproyecto,'semana'=>$semana->no_semana]);
                    DB:: table('resi_rubro_capacidad')->insert(['id_cronograma' =>$semana->id_cronograma,'calificacion' =>0,'id_anteproyecto' =>$semana->id_anteproyecto,'semana'=>$semana->no_semana]);
                    DB:: table('resi_rubro_responsabilidad')->insert(['id_cronograma' =>$semana->id_cronograma,'calificacion' =>0,'id_anteproyecto' =>$semana->id_anteproyecto,'semana'=>$semana->no_semana]);
                    DB:: table('resi_promedio_rubros')->insert(['id_cronograma' =>$semana->id_cronograma,'id_semana' =>$semana->no_semana,'id_anteproyecto' =>$semana->id_anteproyecto,'promedio'=>0,'observaciones' =>$comentario,'pendientes' =>$comentario]);

                }

            }

        }
        return redirect()->route('cronograma_alumno', $id_anteproyecto);
        //dd('hola');
    }
    public function seguimiento_cronograma_alumno($id_anteproyecto){
        $asignadas = DB::selectOne('SELECT MAX(semana) semana FROM resi_rubro_aplicacion WHERE `id_anteproyecto` = '.$id_anteproyecto.'');
        $asignadas=$asignadas->semana;
        $semanas_asignadas=DB::select('SELECT resi_cronograma.*,resi_promedio_rubros.promedio FROM
 resi_cronograma,resi_promedio_rubros WHERE resi_cronograma.id_cronograma=resi_promedio_rubros.id_cronograma 
 and resi_promedio_rubros.id_anteproyecto='.$id_anteproyecto.'  
ORDER BY `resi_cronograma`.`no_semana` ASC');
        $promedio=DB::selectOne('SELECT sum(resi_promedio_rubros.promedio) promedio FROM resi_promedio_rubros WHERE resi_promedio_rubros.id_anteproyecto='.$id_anteproyecto.'');
        if ($promedio == null){
            $promedio=0;
        }
        else{
            if($asignadas == null){
                $promedio=0;
            }
            else{
                if($promedio->promedio != 0 and $asignadas !=0){
                    $promedio=($promedio->promedio/$asignadas);
                }
                else{
                    $promedio=0;
                }

            }

        }
        $semana_siguiente=$asignadas+1;
        // dd($semana_siguiente);
        $ultima_semana=DB::selectOne('SELECT MAX(resi_cronograma.no_semana) semana FROM resi_cronograma WHERE `id_anteproyecto` ='.$id_anteproyecto.'');

        $ultima_semana=$ultima_semana->semana+1;
        $semana= DB::selectOne('SELECT * FROM `resi_cronograma` WHERE `id_anteproyecto` = '.$id_anteproyecto.' and no_semana='.$semana_siguiente.' ORDER BY `no_semana` ASC');
       if($semana == null){
           $calificar=0;
       }else {


           $fecha_inicio = $semana->f_inicio;
           $fecha_final = $semana->f_termino;
           $fecha_actual = date("Y-m-d");
           $fecha_inicio = date("Y-m-d", strtotime($fecha_inicio . "+0 days"));
           $fecha_final = date("Y-m-d", strtotime($fecha_final . "+0 days"));

           //dd($fecha_actual);
           if ($fecha_inicio <= $fecha_actual) {
               $calificar = 1;
               //dd($calificar);
           } else {
               $calificar = 0;
           }
       }

        $array_periodos = array();
        foreach ($semanas_asignadas as $asignada) {
            $array_crono['no_semana'] = $asignada->no_semana;
            $array_crono['id_cronograma'] = $asignada->id_cronograma;
            $array_crono['actividad'] = $asignada->actividad;
            $array_crono['f_inicio'] = $asignada->f_inicio;
            $array_crono['f_termino'] = $asignada->f_termino;
            $array_crono['promedio']= $asignada->promedio;
            $array_crono['estatus'] = 1;
            array_push($array_periodos, $array_crono);

        }
        $asignacion=$asignadas+1;
        $array_peri = array();
        for ($i = $asignacion; $i < $ultima_semana; $i++) {

            $semanass= DB::selectOne('SELECT * FROM `resi_cronograma` WHERE `id_anteproyecto` = '.$id_anteproyecto.' and no_semana='.$i.' ORDER BY `no_semana` ASC');


                $array_crono['no_semana'] = $i;
                $array_crono['id_cronograma'] =$semanass->id_cronograma;
                $array_crono['actividad'] = $semanass->actividad;
                $array_crono['f_inicio'] = $semanass->f_inicio;
                $array_crono['f_termino'] = $semanass->f_termino;
                $array_crono['promedio']=0;
                $array_crono['estatus'] = 3;



            array_push($array_peri, $array_crono);
        }
        $semanas = array_merge($array_periodos, $array_peri);
        $ultima=DB::selectOne('SELECT MAX(resi_cronograma.no_semana) semana FROM resi_cronograma WHERE `id_anteproyecto` ='.$id_anteproyecto.'');
        $ultima=$ultima->semana;
        $proyecto_calificado=DB::selectOne('SELECT max(id_semana)semana FROM `resi_promedio_rubros` WHERE `id_anteproyecto` ='.$id_anteproyecto.'');
        $proyecto_calificado=$proyecto_calificado->semana;
        if($ultima== $proyecto_calificado){
           $terminado_proyecto=1;
        }else{
            $terminado_proyecto=0;
        }
        $promedio_resi=DB::selectOne('SELECT count(id_anteproyecto) numero FROM `resi_promedio_general_residencia` WHERE `id_anteproyecto` ='.$id_anteproyecto.'' );
        if($promedio_resi->numero == 0){
            $promedio_final=0;
            $promedio_residencia=0;
        }
        else{
            $promedio_final=1;
            $promedio_residencia=DB::selectOne('SELECT *FROM `resi_promedio_general_residencia` WHERE `id_anteproyecto` ='.$id_anteproyecto.'' );
            $promedio_residencia=$promedio_residencia->promedio_general;
        }
      $encuesta=DB::table('resi_encuesta_residencia')
            ->where('resi_encuesta_residencia.id_anteproyecto','=',$id_anteproyecto)
            ->select(DB::raw('count(id_encuesta) as encuesta'))
            ->get();
        $encuesta=$encuesta[0]->encuesta;
        if($encuesta==0)
        {
            $encuesta=0;
        }
        else{
            $encuesta=1;
        }

          return view('residencia.seguimiento.consultar_cal_residencia',compact('semanas','promedio','id_anteproyecto','ultima','proyecto_calificado','terminado_proyecto','promedio_final','promedio_residencia','encuesta'));

    }
    public function seguimiento_asesor(){
        $id_profesor = Session::get('id_perso');
        $periodo = Session::get('periodo_actual');

        $segumientos_proyectos=DB::select('SELECT gnral_alumnos.nombre,gnral_alumnos.cuenta,gnral_alumnos.apaterno,
gnral_alumnos.amaterno,resi_proyecto.nom_proyecto,resi_anteproyecto.id_anteproyecto,resi_anteproyecto.autorizacion_departamento  
FROM resi_asesores,resi_anteproyecto,resi_proyecto,gnral_alumnos WHERE resi_asesores.id_profesor ='.$id_profesor.' 
 AND resi_asesores.id_periodo = '.$periodo.' and resi_asesores.id_anteproyecto=resi_anteproyecto.id_anteproyecto
  and resi_anteproyecto.id_alumno=gnral_alumnos.id_alumno 
and resi_anteproyecto.id_proyecto=resi_proyecto.id_proyecto');

      return view('residencia.seguimiento.consultar_proyectos_aceptados',compact('segumientos_proyectos')) ;
    }
    public function seguimiento_alumno($id_anteproyecto){
        $cronogramas=DB::select('SELECT * FROM `resi_cronograma` WHERE `id_anteproyecto` = '.$id_anteproyecto.' ORDER BY `no_semana` ASC');
       //dd($cronogramas);
        foreach ($cronogramas as $cronograma){
           $contar_evaluacion=DB::selectOne('SELECT count(id_promedios) promedio from resi_promedio_rubros where id_cronograma='.$cronograma->id_cronograma.'');

           if($contar_evaluacion->promedio == 0 ){
               $semana= DB::selectOne('SELECT * FROM `resi_cronograma` WHERE `id_cronograma` = '.$cronograma->id_cronograma.' ORDER BY `no_semana` ASC');
               $fecha_termino=$semana->f_termino;
              // dd($fecha_termino);
               $fecha_actual = date("Y-m-d");
               $fecha_termino=date("Y-m-d",strtotime($fecha_termino."+21 days"));
               if($fecha_termino < $fecha_actual){
                   $comentario="El docente no evaluo en tiempo y forma";

                   DB:: table('resi_rubro_actitud')->insert(['id_cronograma' =>$semana->id_cronograma,'calificacion' =>0,'id_anteproyecto' =>$semana->id_anteproyecto,'semana'=>$semana->no_semana]);
                   DB:: table('resi_rubro_aplicacion')->insert(['id_cronograma' =>$semana->id_cronograma,'calificacion' =>0,'id_anteproyecto' =>$semana->id_anteproyecto,'semana'=>$semana->no_semana]);
                   DB:: table('resi_rubro_calidad')->insert(['id_cronograma' =>$semana->id_cronograma,'calificacion' =>0,'id_anteproyecto' =>$semana->id_anteproyecto,'semana'=>$semana->no_semana]);
                   DB:: table('resi_rubro_capacidad')->insert(['id_cronograma' =>$semana->id_cronograma,'calificacion' =>0,'id_anteproyecto' =>$semana->id_anteproyecto,'semana'=>$semana->no_semana]);
                   DB:: table('resi_rubro_responsabilidad')->insert(['id_cronograma' =>$semana->id_cronograma,'calificacion' =>0,'id_anteproyecto' =>$semana->id_anteproyecto,'semana'=>$semana->no_semana]);
                   DB:: table('resi_promedio_rubros')->insert(['id_cronograma' =>$semana->id_cronograma,'id_semana' =>$semana->no_semana,'id_anteproyecto' =>$semana->id_anteproyecto,'promedio'=>0,'observaciones' =>$comentario,'pendientes' =>$comentario]);

               }

           }

       }
        return redirect()->route('calificar_alumno', $id_anteproyecto);
    }
    public function seguimiento_alumno_residencia($id_anteproyecto){

        $asignadas = DB::selectOne('SELECT MAX(semana) semana FROM resi_rubro_aplicacion WHERE `id_anteproyecto` = '.$id_anteproyecto.'');
        $asignadas=$asignadas->semana;
        $semanas_asignadas=DB::select('SELECT resi_cronograma.*,resi_promedio_rubros.promedio FROM
 resi_cronograma,resi_promedio_rubros WHERE resi_cronograma.id_cronograma=resi_promedio_rubros.id_cronograma 
 and resi_promedio_rubros.id_anteproyecto='.$id_anteproyecto.'  
ORDER BY `resi_cronograma`.`no_semana` ASC');
        $promedio=DB::selectOne('SELECT sum(resi_promedio_rubros.promedio) promedio FROM resi_promedio_rubros WHERE resi_promedio_rubros.id_anteproyecto='.$id_anteproyecto.'');

        if ($promedio == null){
            $promedio=0;
      }
      else{
          if($asignadas == null){
              $promedio=0;
          }
          else{
                 if($promedio->promedio != 0 and $asignadas !=0){
                     $promedio=($promedio->promedio/$asignadas);
                 }
                 else{
                     $promedio=0;
                 }

          }

      }

       //dd($promedio);
        $semana_siguiente=$asignadas+1;
       // dd($semana_siguiente);
       $ultima_semana=DB::selectOne('SELECT MAX(resi_cronograma.no_semana) semana FROM resi_cronograma WHERE `id_anteproyecto` ='.$id_anteproyecto.'');
       $ultima_semana=$ultima_semana->semana+1;
        $semana= DB::selectOne('SELECT * FROM `resi_cronograma` WHERE `id_anteproyecto` = '.$id_anteproyecto.' and no_semana='.$semana_siguiente.' ORDER BY `no_semana` ASC');
        if($semana == null){
            $calificar=0;
        }
        else {
            $fecha_inicio = $semana->f_inicio;
            $fecha_final = $semana->f_termino;
            $fecha_actual = date("Y-m-d");
            $fecha_inicio = date("Y-m-d", strtotime($fecha_inicio . "+0 days"));
            $fecha_final = date("Y-m-d", strtotime($fecha_final . "+0 days"));

            //dd($fecha_actual);
           // if ($fecha_inicio <= $fecha_actual) {
                $calificar = 1;
                //dd($calificar);
           // } else {
                //$calificar=0;
            //}
        }

        $array_periodos = array();
        foreach ($semanas_asignadas as $asignada) {
            $array_crono['no_semana'] = $asignada->no_semana;
            $array_crono['id_cronograma'] = $asignada->id_cronograma;
            $array_crono['actividad'] = $asignada->actividad;
            $array_crono['f_inicio'] = $asignada->f_inicio;
            $array_crono['f_termino'] = $asignada->f_termino;
            $array_crono['promedio']= $asignada->promedio;
            $array_crono['estatus'] = 1;
            array_push($array_periodos, $array_crono);

        }
         $asignacion=$asignadas+1;
        $array_peri = array();
        for ($i = $asignacion; $i < $ultima_semana; $i++) {

            $semanass= DB::selectOne('SELECT * FROM `resi_cronograma` WHERE `id_anteproyecto` = '.$id_anteproyecto.' and no_semana='.$i.' ORDER BY `no_semana` ASC');

            if ($i == $semana_siguiente and $calificar==1) {

                $array_crono['no_semana'] = $i;
                $array_crono['id_cronograma'] =$semanass->id_cronograma;
                $array_crono['actividad'] = $semanass->actividad;
                $array_crono['f_inicio'] = $semanass->f_inicio;
                $array_crono['f_termino'] = $semanass->f_termino;
                $array_crono['promedio']=0;
                $array_crono['estatus'] = 2;

            } else {
                $array_crono['no_semana'] = $i;
                $array_crono['id_cronograma'] =$semanass->id_cronograma;
                $array_crono['actividad'] = $semanass->actividad;
                $array_crono['f_inicio'] = $semanass->f_inicio;
                $array_crono['f_termino'] = $semanass->f_termino;
                $array_crono['promedio']=0;
                $array_crono['estatus'] = 3;

            }

            array_push($array_peri, $array_crono);
        }
        $semanas = array_merge($array_periodos, $array_peri);
        $ultima=DB::selectOne('SELECT MAX(resi_cronograma.no_semana) semana FROM resi_cronograma WHERE `id_anteproyecto` ='.$id_anteproyecto.'');
        $ultima=$ultima->semana;
        $proyecto_calificado=DB::selectOne('SELECT max(id_semana)semana FROM `resi_promedio_rubros` WHERE `id_anteproyecto` ='.$id_anteproyecto.'');
        $proyecto_calificado=$proyecto_calificado->semana;
        if($ultima== $proyecto_calificado){
            $terminado_proyecto=1;
        }else{
            $terminado_proyecto=0;
        }

        $promedio_resi=DB::selectOne('SELECT count(id_anteproyecto) numero FROM `resi_promedio_general_residencia` WHERE `id_anteproyecto` ='.$id_anteproyecto.'' );
        if($promedio_resi->numero == 0){
            $promedio_final=0;
            $promedio_residencia=0;
            $liberar_depto=0;
        }
        else{
            $promedio_final=1;
            $promedio_residencia=DB::selectOne('SELECT *FROM `resi_promedio_general_residencia` WHERE `id_anteproyecto` ='.$id_anteproyecto.'' );
            $promedio_residencia=$promedio_residencia->promedio_general;
            $liberar_depto=DB::selectOne('SELECT * FROM `resi_promedio_general_residencia` WHERE `id_anteproyecto` ='.$id_anteproyecto.'');



        }
        $alumno_anteproyecto=DB::selectOne('SELECT gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno from gnral_alumnos,resi_anteproyecto where gnral_alumnos.id_alumno=resi_anteproyecto.id_alumno and resi_anteproyecto.id_anteproyecto='.$id_anteproyecto.'');
        $nombre_alumno=$alumno_anteproyecto->cuenta." ".$alumno_anteproyecto->nombre." ".$alumno_anteproyecto->apaterno." ".$alumno_anteproyecto->amaterno;


return view('residencia.seguimiento.actividades_evaluadas',compact('semanas','promedio','terminado_proyecto','id_anteproyecto','promedio_residencia','promedio_final','nombre_alumno','liberar_depto'));

    }
    public function calificar_anteproyecto($id_cronograma){

        return view('residencia.seguimiento.calificar_semana',compact('id_cronograma'));
    }
    public function guardar_calificacion_anteproyecto(Request $request){
       // dd($request);
        $this->validate($request,[
            'id_cronograma' => 'required',
            'id_actitud' => 'required',
            'id_responsabilidad' => 'required',
            'id_capacidad' => 'required',
            'id_aplicacion' => 'required',
            'id_calidad' => 'required',
            'id_observacion' => 'required',
            'id_pendiente' => 'required',
        ]);
        $id_cronograma = $request->input("id_cronograma");
        $id_actitud = $request->input("id_actitud");
        $id_responsabilidad = $request->input("id_responsabilidad");
        $id_capacidad = $request->input("id_capacidad");
        $id_aplicacion = $request->input("id_aplicacion");
        $id_calidad = $request->input("id_calidad");
        $id_observacion = $request->input("id_observacion");
        $id_pendiente = $request->input("id_pendiente");
        $pro=$id_actitud+$id_responsabilidad+$id_capacidad+$id_aplicacion+$id_calidad;
        $promedio=$pro/5;
        $cronograma=DB::selectOne('SELECT * FROM `resi_cronograma` WHERE `id_cronograma` = '.$id_cronograma.' ORDER BY `no_semana` ASC ');
        $id_anteproyecto=$cronograma->id_anteproyecto;
        $no_semana=$cronograma->no_semana;
        DB:: table('resi_rubro_actitud')->insert(['id_cronograma' =>$id_cronograma,'calificacion' =>$id_actitud,'id_anteproyecto' =>$id_anteproyecto,'semana'=>$no_semana]);
        DB:: table('resi_rubro_responsabilidad')->insert(['id_cronograma' =>$id_cronograma,'calificacion' =>$id_responsabilidad,'id_anteproyecto' =>$id_anteproyecto,'semana'=>$no_semana]);
        DB:: table('resi_rubro_capacidad')->insert(['id_cronograma' =>$id_cronograma,'calificacion' =>$id_capacidad,'id_anteproyecto' =>$id_anteproyecto,'semana'=>$no_semana]);
        DB:: table('resi_rubro_aplicacion')->insert(['id_cronograma' =>$id_cronograma,'calificacion' =>$id_aplicacion,'id_anteproyecto' =>$id_anteproyecto,'semana'=>$no_semana]);
        DB:: table('resi_rubro_calidad')->insert(['id_cronograma' =>$id_cronograma,'calificacion' =>$id_calidad,'id_anteproyecto' =>$id_anteproyecto,'semana'=>$no_semana]);
           DB:: table('resi_promedio_rubros')->insert(['id_cronograma' =>$id_cronograma,'id_semana' =>$no_semana,'id_anteproyecto' =>$id_anteproyecto,'promedio'=>$promedio,'observaciones'=>$id_observacion,'pendientes' =>$id_pendiente]);

return back();
    }
    public function formato_evaluacion_residencia($id_anteproyecto){

        return view('residencia.seguimiento.calificar_residencia',compact('id_anteproyecto'));
    }
    public function guardar_calificacion__residencia(Request $request){
        $this->validate($request,[
            'id_anteproyecto' => 'required',
            'uno' => 'required',
            'dos' => 'required',
            'tres' => 'required',
            'cuatro' => 'required',
            'cinco' => 'required',
            'seis' => 'required',
            'siete' => 'required',
            'ocho' => 'required',
            'nueve' => 'required',
            'diez' => 'required',
            'once' => 'required',
            'doce' => 'required',
            'observacion' => 'required',

        ]);
        $id_anteproyecto = $request->input("id_anteproyecto");
        $uno = $request->input("uno");
        $dos = $request->input("dos");
        $tres = $request->input("tres");
        $cuatro = $request->input("cuatro");
        $cinco = $request->input("cinco");
        $seis = $request->input("seis");
        $siete = $request->input("siete");
        $ocho = $request->input("ocho");
        $nueve = $request->input("nueve");
        $diez = $request->input("diez");
        $once = $request->input("once");
        $doce = $request->input("doce");
        $observacion = $request->input("observacion");
        DB:: table('resi_calificar_residencia')->insert(['uno_externo' =>$uno,'dos_externo' =>$dos,'tres_externo' =>$tres,'cuatro_externo' =>$cuatro,'cinco_externo' =>$cinco,'seis_externo' =>$seis,'uno_interno' =>$siete,'dos_interno' =>$ocho,'tres_interno' =>$nueve,'cuatro_interno' =>$diez,'cinco_interno' =>$once,'seis_interno' =>$doce,'id_anteproyecto' =>$id_anteproyecto,'observacion' =>$observacion]);

        $promedio_residencia=$uno+$dos+$tres+$cuatro+$cinco+$seis+$siete+$ocho+$nueve+$diez+$once+$doce;

        $asignadas = DB::selectOne('SELECT MAX(semana) semana FROM resi_rubro_aplicacion WHERE `id_anteproyecto` = '.$id_anteproyecto.'');
        $asignadas=$asignadas->semana;
        $promedio=DB::selectOne('SELECT sum(resi_promedio_rubros.promedio) promedio FROM resi_promedio_rubros WHERE resi_promedio_rubros.id_anteproyecto='.$id_anteproyecto.'');
       $promedio=$promedio->promedio;
        $promedio_seguimiento=$promedio/$asignadas;

        $promedio_general=$promedio_residencia+$promedio_seguimiento;
        $promedio_general=$promedio_general/2;

        $hoy= date("Y-m-d H:i:s");
        DB:: table('resi_promedio_general_residencia')
            ->insert(['calificacion_seguimiento' =>$promedio_seguimiento,
                'calif_externo_interno' =>$promedio_residencia,
                'promedio_general' =>$promedio_general,
                'id_anteproyecto'=>$id_anteproyecto,
                'fecha_registro' => $hoy]);
        $periodo = Session::get('periodo_actual');
        DB:: table('resi_liberacion_documentos')->insert(['id_anteproyecto'=>$id_anteproyecto,'id_periodo'=>$periodo]);

return back();


    }
    public function evaluacion_final_residencia(Request $request){
        $this->validate($request,[
            'id_anteproyecto' => 'required',
            'pregunta1' => 'required',
            'pregunta2' => 'required',
            'pregunta3' => 'required',
            'pregunta4' => 'required',
            'pregunta5' => 'required',
            'pregunta6' => 'required',
            'pregunta7' => 'required',
            'comentario' => 'required',
        ]);
        $id_anteproyecto = $request->input("id_anteproyecto");
        $pregunta1 = $request->input("pregunta1");
        $pregunta2 = $request->input("pregunta2");
        $pregunta3 = $request->input("pregunta3");
        $pregunta4 = $request->input("pregunta4");
        $pregunta5 = $request->input("pregunta5");
        $pregunta6 = $request->input("pregunta6");
        $pregunta7 = $request->input("pregunta7");
        $comentario = $request->input("comentario");
        DB:: table('resi_encuesta_residencia')->insert(['id_anteproyecto' =>$id_anteproyecto,'pregunta1' =>$pregunta1,'pregunta2' =>$pregunta2,'pregunta3' =>$pregunta3,'pregunta4' =>$pregunta4,'pregunta5' =>$pregunta5,'pregunta6' =>$pregunta6,'pregunta7' =>$pregunta7,'comentario' =>$comentario]);
return back();
    }
    public function autorizar_imprimir_acta(){
        $periodo = Session::get('periodo_actual');
      $alumnos=DB::select('SELECT gnral_alumnos.cuenta,gnral_alumnos.nombre,
       gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_carreras.nombre carrera,resi_promedio_general_residencia.* 
FROM gnral_alumnos,resi_anteproyecto,resi_promedio_general_residencia,gnral_carreras,resi_asesores 
WHERE gnral_alumnos.id_alumno=resi_anteproyecto.id_alumno and
      resi_anteproyecto.id_anteproyecto = resi_promedio_general_residencia.id_anteproyecto 
  and gnral_alumnos.id_carrera = gnral_carreras.id_carrera and 
      resi_asesores.id_anteproyecto = resi_anteproyecto.id_anteproyecto and 
      resi_asesores.id_periodo ='.$periodo.'');
    return view('residencia.departamento_residencia.autorizar_impresion_acta',compact('alumnos'));
    }
    public function autorizacion_acta_alumno($id_promedio_general){
       $alumno=DB::selectOne('SELECT gnral_alumnos.cuenta,gnral_alumnos.nombre,
       gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_carreras.nombre carrera,resi_promedio_general_residencia.* 
FROM gnral_alumnos,resi_anteproyecto,resi_promedio_general_residencia,gnral_carreras,resi_asesores 
WHERE gnral_alumnos.id_alumno=resi_anteproyecto.id_alumno and resi_anteproyecto.id_anteproyecto = resi_promedio_general_residencia.id_anteproyecto 
  and gnral_alumnos.id_carrera = gnral_carreras.id_carrera and resi_asesores.id_anteproyecto = resi_anteproyecto.id_anteproyecto and resi_promedio_general_residencia.id_promedio_general ='.$id_promedio_general.'');
 //dd($alumno);
   return view('residencia.seguimiento.modal_dato_autorizar_acta',compact('alumno'));
    }
    public function registrar_estado_acta(Request $request){
        $this->validate($request,[
            'id_promedio_general' => 'required',
        ]);

        $id_promedio_general = $request->input("id_promedio_general");

        $promedio=DB::selectOne('SELECT * FROM `resi_promedio_general_residencia` WHERE `id_promedio_general` = '.$id_promedio_general.'');
        $fecha_reg= $promedio->fecha_registro;

        $num=$fecha_reg;
        $year =substr($num, 0,4);
        $mes =substr($num, 5,2);
        $dia =substr($num, 8,2);
        $fecha_r= $year.'-'.$mes.'-'.$dia;
        //dd($fecha_r);


        $id_alumno = DB::selectOne('SELECT * FROM `resi_anteproyecto` WHERE `id_anteproyecto` ='.$promedio->id_anteproyecto.'');

        $id_alumno = $id_alumno->id_alumno;
        //dd($promedio);

        DB:: table('cal_residencia')
            ->insert(['calificacion' =>$promedio->promedio_general,
                'id_alumno' =>$id_alumno,
                'fecha_termino' =>$fecha_r,
                'clave' => "RES-0001"]);

        DB::table('resi_promedio_general_residencia')
            ->where('id_promedio_general', $id_promedio_general)
            ->update([
                'id_calificar_departamento' => 1,
            ]);
        return back();

    }
}
