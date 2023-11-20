<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Session;
use PDF;

class PDFCalificacionesController extends Controller
{
    public function generaCalificaciones()
    {
        $periodo=Session::get('periodo_actual');
        $id_materia=$_GET['id_materia'];
        $id_docente=$_GET['id_docente'];
        $id_grupo=$_GET['id_grupo'];
        $mat = DB::selectOne('SELECT  gnral_materias.*,gnral_reticulas.id_reticula,gnral_reticulas.clave clave_rec,gnral_reticulas.id_carrera FROM gnral_materias,gnral_reticulas WHERE id_materia = '.$id_materia.' and gnral_reticulas.id_reticula=gnral_materias.id_reticula');
        $grupos = $mat->id_semestre.'0'.$id_grupo ;
        $carrera= DB::selectOne('SELECT gnral_carreras.nombre from gnral_carreras,gnral_reticulas,gnral_materias WHERE gnral_carreras.id_carrera=gnral_reticulas.id_carrera and gnral_reticulas.id_reticula=gnral_materias.id_reticula and gnral_materias.id_materia= '.$id_materia.'');
        $nom_carrera=$carrera->nombre;
        $profesor=DB::selectOne('SELECT abreviaciones.titulo,gnral_personales.nombre from gnral_personales,abreviaciones_prof,abreviaciones WHERE gnral_personales.id_personal=abreviaciones_prof.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and gnral_personales.id_personal='.$id_docente.'');

        $esc_alumno=false;
				//dd($periodo);
				$periodoAct=DB::select("select periodo from gnral_periodos where id_periodo=".$periodo."");
				$periodoAct=$periodoAct[0]->periodo;
				//dd($periodoAct);
        $uni_asignadas = DB::select('select cal_periodos_califica.id_periodo_cal,cal_periodos_califica.id_unidad,cal_periodos_califica.fecha,cal_periodos_califica.id_materia from cal_periodos_califica 
where id_materia='.$id_materia.' and id_grupo='.$id_grupo.' and id_periodos='.$periodo.'');

        $calificar_sumativa=DB::selectOne('SELECT count(id_calificar_sumativas) sumativa 
FROM `gnral_calificar_sumativas` 
WHERE `id_materia` = '.$id_materia.' AND `id_grupo` = '.$id_grupo.' AND `id_estado` = 1 AND `id_periodo` = '.$periodo.'');
       if($calificar_sumativa->sumativa ==0) {


           $alumnos = DB::select('select gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.id_carrera, gnral_alumnos.apaterno,gnral_alumnos.amaterno,eva_carga_academica.id_carga_academica, gnral_materias.clave,gnral_materias.nombre materia,gnral_materias.unidades,eva_tipo_curso.nombre_curso,eva_validacion_de_cargas.estado_validacion
                from gnral_alumnos,gnral_materias,eva_carga_academica, gnral_periodos,eva_tipo_curso,eva_validacion_de_cargas
                where gnral_periodos.id_periodo=' . $periodo . '
                and gnral_materias.id_materia=' . $id_materia . '
                and eva_carga_academica.grupo=' . $id_grupo . '
                and eva_carga_academica.id_status_materia=1
                and eva_carga_academica.id_materia=gnral_materias.id_materia
                and eva_tipo_curso.id_tipo_curso=eva_carga_academica.id_tipo_curso
                and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
				and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno 
                and eva_validacion_de_cargas.estado_validacion in (2,9,10) 
                and eva_validacion_de_cargas.id_periodo= eva_validacion_de_cargas.id_periodo
                and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
                ORDER BY gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.nombre');
           //dd($alumnos);
           $array_alumnos = array();
           $num_alumnos = 0;
           $numer_al=0;
           $promed=0;
           foreach ($alumnos as $alumno) {
               if($alumno->estado_validacion != 10)
               {
                   $numer_al++;
               }
               $sumativas = false;
               $esc_alumno = false;
               $num_alumnos++;
               if($alumno->id_carrera == $mat->id_carrera){
                   $dat_alumnos['carrera']=1;
               }
               else{
                   $dat_alumnos['carrera']=2;
               }
               $dat_alumnos['np'] = $num_alumnos;
               $dat_alumnos['id_alumno'] = $alumno->id_alumno;
               $dat_alumnos['id_carga_academica'] = $alumno->id_carga_academica;
               $dat_alumnos['estado_validacion'] = $alumno->estado_validacion;
               $dat_alumnos['cuenta'] = $alumno->cuenta;
               $dat_alumnos['nombre'] = mb_strtoupper($alumno->apaterno, 'utf-8') . " " . mb_strtoupper($alumno->amaterno, 'utf-8') . " " . mb_strtoupper($alumno->nombre, 'utf-8');
               $array_calificaciones = array();
               $calificaciones = DB::select('SELECT * FROM cal_evaluaciones
                      WHERE id_carga_academica=' . $alumno->id_carga_academica . '
                      ORDER BY cal_evaluaciones.id_unidad');
               $suma_unidades = 0;
               $calificaciones != null ? $numero_unidades = 0 : $numero_unidades = 1;
               foreach ($calificaciones as $calificacion) {
                   $dat_calificaciones['id_evaluacion'] = $calificacion->id_evaluacion;
                   $dat_calificaciones['calificacion'] = $calificacion->calificacion;
                   $dat_calificaciones['id_unidad'] = $calificacion->id_unidad;
                   $suma_unidades += $calificacion->calificacion >= 70 ? $calificacion->calificacion : 0;
                   if ($calificacion->calificacion < 70 || $calificacion->esc == 1) {
                       $esc_alumno = true;
                   }
                   if ($calificacion->calificacion < 70) {
                       $sumativas = true;

                   }
                   $numero_unidades++;
                   array_push($array_calificaciones, $dat_calificaciones);
               }
               if($alumno->estado_validacion== 10)
               {
                   $esc_alumno=true;
               }
               $dat_alumnos['repeticion'] = $sumativas;
               $dat_alumnos['esc_alumno'] = $esc_alumno;
               if($alumno->estado_validacion == 10)
               {
                   $dat_alumnos['promedio'] =0;

               }
               else{
                   $prome=intval(round($suma_unidades/$numero_unidades)+0);
                   if($prome >=70){
                       $promed++;
                   }
                   $dat_alumnos['promedio'] = intval(round($suma_unidades / $numero_unidades) + 0);
               }

               $dat_alumnos['calificaciones'] = $array_calificaciones;
               $dat_alumnos['curso'] = $alumno->nombre_curso;
               //$dat_alumnos['nombre']=ucwords(strtolower($alumno->nombre)." ".strtolower($alumno->apaterno)." ".strtolower($alumno->amaterno));
               array_push($array_alumnos, $dat_alumnos);
           }

           if($promed >0 and $numer_al >0){
               $imp_porcentaje=($promed*100)/$numer_al;
           }else{
               $imp_porcentaje=0;
           }
           $no_unidades = DB::select('select gnral_materias.unidades
                from gnral_materias  where  gnral_materias.id_materia=' . $id_materia . '
                ');
           $array_porcentajes=array();
           $porcent=0;

           for (   $i = 1 ; $i <= $no_unidades[0]->unidades ; $i++) {
               $contar_alumnos = 0;
               $aprobados=0;

               foreach ($array_alumnos as $alumnoss) {
                   foreach ($alumnoss['calificaciones'] as $cal) {
                       if ($cal['id_unidad'] == $i) {
                           if ($cal['calificacion'] >= 70) {
                               $contar_alumnos++;
                               $aprobados++;

                           } else {
                               $contar_alumnos++;

                           }
                           $esta = true;
                           break;
                       } // esta es la que se me olvidaba
                   }


               }

               $dat_porcentajes['id_unidad']=$i;
               $dat_porcentajes['contar']=$contar_alumnos;
               if($contar_alumnos >0 and $aprobados >0)
               {
                   $porcentaje=($aprobados*100)/$contar_alumnos;

               }
               else{
                   $porcentaje=0;
               }
               $porcent+=$porcentaje;
               $dat_porcentajes['porcentaje']=$porcentaje;
               array_push($array_porcentajes,$dat_porcentajes);
           }
          // dd($array_porcentajes);
           $unidades = $mat->unidades;
       }else{
           $alumnos = DB::select('select gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.id_carrera, gnral_alumnos.apaterno,gnral_alumnos.amaterno,eva_carga_academica.id_carga_academica, gnral_materias.clave,gnral_materias.nombre materia,gnral_materias.unidades,eva_tipo_curso.nombre_curso,eva_validacion_de_cargas.estado_validacion
                from gnral_alumnos,gnral_materias,eva_carga_academica, gnral_periodos,eva_tipo_curso,eva_validacion_de_cargas
                where gnral_periodos.id_periodo=' . $periodo . '
                and gnral_materias.id_materia=' . $id_materia . '
                and eva_carga_academica.grupo=' . $id_grupo . '
                and eva_carga_academica.id_status_materia=1
                and eva_carga_academica.id_materia=gnral_materias.id_materia
                and eva_tipo_curso.id_tipo_curso=eva_carga_academica.id_tipo_curso
                and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
				and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno 
                and eva_validacion_de_cargas.estado_validacion in (2,9,10) 
                and eva_validacion_de_cargas.id_periodo= eva_validacion_de_cargas.id_periodo
                and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
                ORDER BY gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.nombre');
           //dd($alumnos);
           $array_alumnos = array();
           $num_alumnos = 0;
           $numer_al=0;
           $promed=0;
           foreach ($alumnos as $alumno) {
               if($alumno->estado_validacion != 10)
               {
                   $numer_al++;
               }
               if($alumno->id_carrera == $mat->id_carrera){
                   $dat_alumnos['carrera']=1;
               }
               else{
                   $dat_alumnos['carrera']=2;
               }
               $sumativas = false;
               $esc_alumno = false;
               $num_alumnos++;
               $dat_alumnos['np'] = $num_alumnos;
               $dat_alumnos['id_alumno'] = $alumno->id_alumno;
               $dat_alumnos['id_carga_academica'] = $alumno->id_carga_academica;
               $dat_alumnos['estado_validacion'] = $alumno->estado_validacion;
               $dat_alumnos['cuenta'] = $alumno->cuenta;
               $dat_alumnos['nombre'] = mb_strtoupper($alumno->apaterno, 'utf-8') . " " . mb_strtoupper($alumno->amaterno, 'utf-8') . " " . mb_strtoupper($alumno->nombre, 'utf-8');
               $array_calificaciones = array();
               $calificaciones=DB::select('SELECT * FROM cal_evaluaciones_sumativa
                      WHERE id_carga_academica='.$alumno->id_carga_academica.'
                      ORDER BY cal_evaluaciones_sumativa.id_unidad');
               $suma_unidades = 0;
               $calificaciones != null ? $numero_unidades = 0 : $numero_unidades = 1;
               foreach ($calificaciones as $calificacion) {
                   $dat_calificaciones['id_evaluacion'] = $calificacion->id_evaluacion;
                   $dat_calificaciones['calificacion'] = $calificacion->calificacion;
                   $dat_calificaciones['id_unidad'] = $calificacion->id_unidad;
                   $suma_unidades += $calificacion->calificacion >= 70 ? $calificacion->calificacion : 0;
                   if ($calificacion->calificacion < 70 || $calificacion->esc == 1) {
                       $esc_alumno = true;
                   }
                   if ($calificacion->calificacion < 70) {
                       $sumativas = true;

                   }
                   $numero_unidades++;
                   array_push($array_calificaciones, $dat_calificaciones);
               }
               if($alumno->estado_validacion== 10)
               {
                   $esc_alumno=true;
               }
               $dat_alumnos['repeticion'] = $sumativas;
               $dat_alumnos['esc_alumno'] = $esc_alumno;
               if($alumno->estado_validacion == 10)
               {
                   $dat_alumnos['promedio'] =0;

               }
               else{
                   $prome=intval(round($suma_unidades/$numero_unidades)+0);
                   if($prome >=70){
                       $promed++;
                   }
                   $dat_alumnos['promedio'] = intval(round($suma_unidades / $numero_unidades) + 0);
               }

               $dat_alumnos['calificaciones'] = $array_calificaciones;
               $dat_alumnos['curso'] = $alumno->nombre_curso;
               //$dat_alumnos['nombre']=ucwords(strtolower($alumno->nombre)." ".strtolower($alumno->apaterno)." ".strtolower($alumno->amaterno));
               array_push($array_alumnos, $dat_alumnos);
           }
           if($promed >0 and $numer_al >0){
               $imp_porcentaje=($promed*100)/$numer_al;
           }else{
               $imp_porcentaje=0;
           }
           $no_unidades = DB::select('select gnral_materias.unidades
                from gnral_materias  where  gnral_materias.id_materia=' . $id_materia . '
                ');
           $array_porcentajes=array();
           $porcent=0;

           for (   $i = 1 ; $i <= $no_unidades[0]->unidades ; $i++) {
               $contar_alumnos = 0;
               $aprobados=0;

               foreach ($array_alumnos as $alumnoss) {
                   foreach ($alumnoss['calificaciones'] as $cal) {
                       if ($cal['id_unidad'] == $i) {
                           if ($cal['calificacion'] >= 70) {
                               $contar_alumnos++;
                               $aprobados++;

                           } else {
                               $contar_alumnos++;

                           }
                           $esta = true;
                           break;
                       } // esta es la que se me olvidaba
                   }


               }

               $dat_porcentajes['id_unidad']=$i;
               $dat_porcentajes['contar']=$contar_alumnos;
               if($contar_alumnos >0 and $aprobados >0)
               {
                   $porcentaje=($aprobados*100)/$contar_alumnos;

               }
               else{
                   $porcentaje=0;
               }
               $porcent+=$porcentaje;
               $dat_porcentajes['porcentaje']=$porcentaje;
               array_push($array_porcentajes,$dat_porcentajes);
           }
           // dd($array_porcentajes);
           $unidades = $mat->unidades;
       }
        $pdf = PDF::loadView('docentes.genera_pdf',compact('imp_porcentaje','periodoAct','grupos','nom_carrera','mat','profesor','unidades'),['alumnos'=>$array_alumnos,'porcentajes'=>$array_porcentajes,'uni_asignadas'=>$uni_asignadas]);
        return $pdf->stream('ACTA ORDINARIA '.$mat->nombre.'.pdf');
    }
    public function generaCalificacionesjc()
    {
        $periodo=Session::get('periodo_actual');
        $id_materia=$_GET['id_materia'];
        $id_docente=$_GET['id_docente'];
        $id_grupo=$_GET['id_grupo'];
        $nom_jCarrera=$_GET['nomjefe'];
        $id_usuario = Session::get('usuario_alumno');
        //dd($id_usuario);
        $mat = DB::selectOne('SELECT  gnral_materias.*,gnral_reticulas.id_reticula,gnral_reticulas.clave clave_rec,gnral_reticulas.id_carrera FROM gnral_materias,gnral_reticulas WHERE id_materia = '.$id_materia.' and gnral_reticulas.id_reticula=gnral_materias.id_reticula');
        $grupos = $mat->id_semestre.'0'.$id_grupo ;
        $carrera= DB::selectOne('SELECT gnral_carreras.nombre from gnral_carreras,gnral_reticulas,gnral_materias WHERE gnral_carreras.id_carrera=gnral_reticulas.id_carrera and gnral_reticulas.id_reticula=gnral_materias.id_reticula and gnral_materias.id_materia= '.$id_materia.'');
        $nom_carrera=$carrera->nombre;
        $profesor=DB::selectOne('SELECT abreviaciones.titulo,gnral_personales.nombre from gnral_personales,abreviaciones_prof,abreviaciones WHERE gnral_personales.id_personal=abreviaciones_prof.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and gnral_personales.tipo_usuario = '.$id_usuario.'');

        $esc_alumno=false;

				$periodoAct=DB::select("select periodo from gnral_periodos where id_periodo=".$periodo."");
				$periodoAct=$periodoAct[0]->periodo;

        $uni_asignadas = DB::select('select cal_periodos_califica.id_periodo_cal,cal_periodos_califica.id_unidad,cal_periodos_califica.fecha,cal_periodos_califica.id_materia from cal_periodos_califica 
where id_materia='.$id_materia.' and id_grupo='.$id_grupo.' and id_periodos='.$periodo.'');

        $calificar_sumativa=DB::selectOne('SELECT count(id_calificar_sumativas) sumativa 
FROM `gnral_calificar_sumativas` 
WHERE `id_materia` = '.$id_materia.' AND `id_grupo` = '.$id_grupo.' AND `id_estado` = 1 AND `id_periodo` = '.$periodo.'');
        if($calificar_sumativa->sumativa ==0) {

            $alumnos=DB::select('select gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre, gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.id_carrera,eva_carga_academica.id_carga_academica, gnral_materias.clave,gnral_materias.nombre materia,gnral_materias.unidades,eva_tipo_curso.nombre_curso,eva_validacion_de_cargas.estado_validacion
                from gnral_alumnos,gnral_materias,eva_carga_academica, gnral_periodos,eva_tipo_curso,eva_validacion_de_cargas
                where gnral_periodos.id_periodo='.$periodo.'
                and gnral_materias.id_materia='.$id_materia.'
                and eva_carga_academica.grupo='.$id_grupo.'
                and eva_carga_academica.id_status_materia=1
                and eva_carga_academica.id_materia=gnral_materias.id_materia
                and eva_tipo_curso.id_tipo_curso=eva_carga_academica.id_tipo_curso
                and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
				and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno 
                and eva_validacion_de_cargas.estado_validacion in (2,9,10) 
                and eva_validacion_de_cargas.id_periodo= eva_validacion_de_cargas.id_periodo
                and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
                ORDER BY gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.nombre');

            $array_alumnos = array();
            $num_alumnos = 0;
            $numer_al=0;
            $promed=0;
            foreach ($alumnos as $alumno) {
                if($alumno->estado_validacion != 10)
                {
                    $numer_al++;
                }
                if($alumno->id_carrera == $mat->id_carrera){
                    $dat_alumnos['carrera']=1;
                }
                else{
                    $dat_alumnos['carrera']=2;
                }
                $sumativas = false;
                $esc_alumno = false;
                $num_alumnos++;
                $dat_alumnos['np'] = $num_alumnos;
                $dat_alumnos['id_alumno'] = $alumno->id_alumno;
                $dat_alumnos['id_carga_academica'] = $alumno->id_carga_academica;
                $dat_alumnos['estado_validacion'] = $alumno->estado_validacion;
                $dat_alumnos['cuenta'] = $alumno->cuenta;
                $dat_alumnos['nombre'] = mb_strtoupper($alumno->apaterno, 'utf-8') . " " . mb_strtoupper($alumno->amaterno, 'utf-8') . " " . mb_strtoupper($alumno->nombre, 'utf-8');
                $array_calificaciones = array();
                $calificaciones = DB::select('SELECT * FROM cal_evaluaciones
                      WHERE id_carga_academica=' . $alumno->id_carga_academica . '
                      ORDER BY cal_evaluaciones.id_unidad');
                $suma_unidades = 0;
                $calificaciones != null ? $numero_unidades = 0 : $numero_unidades = 1;
                foreach ($calificaciones as $calificacion) {
                    $dat_calificaciones['id_evaluacion'] = $calificacion->id_evaluacion;
                    $dat_calificaciones['calificacion'] = $calificacion->calificacion;
                    $dat_calificaciones['id_unidad'] = $calificacion->id_unidad;
                    $suma_unidades += $calificacion->calificacion >= 70 ? $calificacion->calificacion : 0;
                    if ($calificacion->calificacion < 70 || $calificacion->esc == 1) {
                        $esc_alumno = true;
                    }
                    if ($calificacion->calificacion < 70) {
                        $sumativas = true;

                    }
                    $numero_unidades++;
                    array_push($array_calificaciones, $dat_calificaciones);
                }
                if($alumno->estado_validacion== 10)
                {
                    $esc_alumno=true;
                }
                $dat_alumnos['repeticion'] = $sumativas;
                $dat_alumnos['esc_alumno'] = $esc_alumno;
                if($alumno->estado_validacion == 10)
                {
                    $dat_alumnos['promedio'] =0;

                }
                else{
                    $prome=intval(round($suma_unidades/$numero_unidades)+0);
                    if($prome >=70){
                        $promed++;
                    }
                    $dat_alumnos['promedio'] = intval(round($suma_unidades / $numero_unidades) + 0);
                }
                $dat_alumnos['calificaciones'] = $array_calificaciones;
                $dat_alumnos['curso'] = $alumno->nombre_curso;
                //$dat_alumnos['nombre']=ucwords(strtolower($alumno->nombre)." ".strtolower($alumno->apaterno)." ".strtolower($alumno->amaterno));
                array_push($array_alumnos, $dat_alumnos);
            }
            if($promed >0 and $numer_al >0){
                $imp_porcentaje=($promed*100)/$numer_al;
            }else{
                $imp_porcentaje=0;
            }
            $no_unidades = DB::select('select gnral_materias.unidades
                from gnral_materias  where  gnral_materias.id_materia=' . $id_materia . '
                ');
            $array_porcentajes=array();
            $porcent=0;

            for (   $i = 1 ; $i <= $no_unidades[0]->unidades ; $i++) {
                $contar_alumnos = 0;
                $aprobados=0;

                foreach ($array_alumnos as $alumnoss) {
                    foreach ($alumnoss['calificaciones'] as $cal) {
                        if ($cal['id_unidad'] == $i) {
                            if ($cal['calificacion'] >= 70) {
                                $contar_alumnos++;
                                $aprobados++;

                            } else {
                                $contar_alumnos++;

                            }
                            $esta = true;
                            break;
                        } // esta es la que se me olvidaba
                    }


                }

                $dat_porcentajes['id_unidad']=$i;
                $dat_porcentajes['contar']=$contar_alumnos;
                if($contar_alumnos >0 and $aprobados >0)
                {
                    $porcentaje=($aprobados*100)/$contar_alumnos;

                }
                else{
                    $porcentaje=0;
                }
                $porcent+=$porcentaje;
                $dat_porcentajes['porcentaje']=$porcentaje;
                array_push($array_porcentajes,$dat_porcentajes);
            }
            $unidades = $mat->unidades;
        }else{

            $alumnos=DB::select('select gnral_alumnos.id_carrera,gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre, gnral_alumnos.apaterno,gnral_alumnos.amaterno,eva_carga_academica.id_carga_academica, gnral_materias.clave,gnral_materias.nombre materia,gnral_materias.unidades,eva_tipo_curso.nombre_curso,eva_validacion_de_cargas.estado_validacion
                from gnral_alumnos,gnral_materias,eva_carga_academica, gnral_periodos,eva_tipo_curso,eva_validacion_de_cargas
                where gnral_periodos.id_periodo='.$periodo.'
                and gnral_materias.id_materia='.$id_materia.'
                and eva_carga_academica.grupo='.$id_grupo.'
                and eva_carga_academica.id_status_materia=1
                and eva_carga_academica.id_materia=gnral_materias.id_materia
                and eva_tipo_curso.id_tipo_curso=eva_carga_academica.id_tipo_curso
                and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
				and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno 
                and eva_validacion_de_cargas.estado_validacion in (2,9,10) 
                and eva_validacion_de_cargas.id_periodo= eva_validacion_de_cargas.id_periodo
                and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
                ORDER BY gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.nombre');

            $array_alumnos = array();
            $num_alumnos = 0;
            $numer_al=0;
            $promed=0;
            foreach ($alumnos as $alumno) {
                if($alumno->estado_validacion != 10)
                {
                    $numer_al++;
                }
                if($alumno->id_carrera == $mat->id_carrera){
                    $dat_alumnos['carrera']=1;
                }
                else{
                    $dat_alumnos['carrera']=2;
                }
                $sumativas = false;
                $esc_alumno = false;
                $num_alumnos++;
                $dat_alumnos['np'] = $num_alumnos;
                $dat_alumnos['id_alumno'] = $alumno->id_alumno;
                $dat_alumnos['id_carga_academica'] = $alumno->id_carga_academica;
                $dat_alumnos['estado_validacion'] = $alumno->estado_validacion;
                $dat_alumnos['cuenta'] = $alumno->cuenta;
                $dat_alumnos['nombre'] = mb_strtoupper($alumno->apaterno, 'utf-8') . " " . mb_strtoupper($alumno->amaterno, 'utf-8') . " " . mb_strtoupper($alumno->nombre, 'utf-8');
                $array_calificaciones = array();
                $calificaciones=DB::select('SELECT * FROM cal_evaluaciones_sumativa
                      WHERE id_carga_academica='.$alumno->id_carga_academica.'
                      ORDER BY cal_evaluaciones_sumativa.id_unidad');
                $suma_unidades = 0;
                $calificaciones != null ? $numero_unidades = 0 : $numero_unidades = 1;
                foreach ($calificaciones as $calificacion) {
                    $dat_calificaciones['id_evaluacion'] = $calificacion->id_evaluacion;
                    $dat_calificaciones['calificacion'] = $calificacion->calificacion;
                    $dat_calificaciones['id_unidad'] = $calificacion->id_unidad;
                    $suma_unidades += $calificacion->calificacion >= 70 ? $calificacion->calificacion : 0;
                    if ($calificacion->calificacion < 70 || $calificacion->esc == 1) {
                        $esc_alumno = true;
                    }
                    if ($calificacion->calificacion < 70) {
                        $sumativas = true;

                    }
                    $numero_unidades++;
                    array_push($array_calificaciones, $dat_calificaciones);
                }
                if($alumno->estado_validacion== 10)
                {
                    $esc_alumno=true;
                }
                $dat_alumnos['repeticion'] = $sumativas;
                $dat_alumnos['esc_alumno'] = $esc_alumno;
                if($alumno->estado_validacion == 10)
                {
                    $dat_alumnos['promedio'] =0;

                }
                else{
                    $prome=intval(round($suma_unidades/$numero_unidades)+0);
                    if($prome >=70 ){
                        $promed++;
                    }
                    $dat_alumnos['promedio'] = intval(round($suma_unidades / $numero_unidades) + 0);
                }
                $dat_alumnos['calificaciones'] = $array_calificaciones;
                $dat_alumnos['curso'] = $alumno->nombre_curso;
                //$dat_alumnos['nombre']=ucwords(strtolower($alumno->nombre)." ".strtolower($alumno->apaterno)." ".strtolower($alumno->amaterno));
                array_push($array_alumnos, $dat_alumnos);
            }
            if($promed >0 and $numer_al >0){
                $imp_porcentaje=($promed*100)/$numer_al;
            }else{
                $imp_porcentaje=0;
            }
            $no_unidades = DB::select('select gnral_materias.unidades
                from gnral_materias  where  gnral_materias.id_materia=' . $id_materia . '
                ');
            $array_porcentajes=array();
            $porcent=0;

            for (   $i = 1 ; $i <= $no_unidades[0]->unidades ; $i++) {
                $contar_alumnos = 0;
                $aprobados=0;

                foreach ($array_alumnos as $alumnoss) {
                    foreach ($alumnoss['calificaciones'] as $cal) {
                        if ($cal['id_unidad'] == $i) {
                            if ($cal['calificacion'] >= 70) {
                                $contar_alumnos++;
                                $aprobados++;

                            } else {
                                $contar_alumnos++;

                            }
                            $esta = true;
                            break;
                        } // esta es la que se me olvidaba
                    }


                }

                $dat_porcentajes['id_unidad']=$i;
                $dat_porcentajes['contar']=$contar_alumnos;
                if($contar_alumnos >0 and $aprobados >0)
                {
                    $porcentaje=($aprobados*100)/$contar_alumnos;

                }
                else{
                    $porcentaje=0;
                }
                $porcent+=$porcentaje;
                $dat_porcentajes['porcentaje']=$porcentaje;
                array_push($array_porcentajes,$dat_porcentajes);
            }
            $unidades = $mat->unidades;

        }
        $pdf = PDF::loadView('docentes.genera_pdf',compact('imp_porcentaje','periodoAct','grupos','nom_carrera','mat','profesor','unidades'),['alumnos'=>$array_alumnos,'porcentajes'=>$array_porcentajes,'uni_asignadas'=>$uni_asignadas]);
        return $pdf->stream('ACTA ORDINARIA '.$mat->nombre.'.pdf');
    }
		public function generaCalSumativas()
		{
				$periodo=Session::get('periodo_actual');
				$id_materia=$_GET['id_materia'];
				$id_docente=$_GET['id_docente'];
				$id_grupo=$_GET['id_grupo'];
				$esc_alumno=false;
				//dd($periodo);
            $mat = DB::selectOne('SELECT  gnral_materias.*,gnral_reticulas.id_reticula,gnral_reticulas.clave clave_rec,gnral_reticulas.id_carrera FROM gnral_materias,gnral_reticulas WHERE id_materia = '.$id_materia.' and gnral_reticulas.id_reticula=gnral_materias.id_reticula');
            $grupo = $mat->id_semestre.'0'.$id_grupo ;
            $carrera= DB::selectOne('SELECT gnral_carreras.nombre from gnral_carreras,gnral_reticulas,gnral_materias WHERE gnral_carreras.id_carrera=gnral_reticulas.id_carrera and gnral_reticulas.id_reticula=gnral_materias.id_reticula and gnral_materias.id_materia= '.$id_materia.'');
            $nom_carrera=$carrera->nombre;
            $profesor=DB::selectOne('SELECT abreviaciones.titulo,gnral_personales.nombre from gnral_personales,abreviaciones_prof,abreviaciones WHERE gnral_personales.id_personal=abreviaciones_prof.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and gnral_personales.id_personal='.$id_docente.'');


            $periodoAct=DB::select("select periodo from gnral_periodos where id_periodo=".$periodo."");
				$periodoAct=$periodoAct[0]->periodo;
				//dd($periodoAct);
            $uni_asignadas = DB::select('select cal_periodos_califica.id_periodo_cal,cal_periodos_califica.id_unidad,cal_periodos_califica.fecha,cal_periodos_califica.id_materia from cal_periodos_califica 
where id_materia='.$id_materia.' and id_grupo='.$id_grupo.' and id_periodos='.$periodo.'');

            $alumnos=DB::select('select gnral_alumnos.id_carrera,gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre, gnral_alumnos.apaterno,gnral_alumnos.amaterno,eva_carga_academica.id_carga_academica, gnral_materias.clave,gnral_materias.nombre materia,gnral_materias.unidades,eva_tipo_curso.nombre_curso,eva_validacion_de_cargas.estado_validacion
                from gnral_alumnos,gnral_materias,eva_carga_academica, gnral_periodos,eva_tipo_curso,eva_validacion_de_cargas
                where gnral_periodos.id_periodo='.$periodo.'
                and gnral_materias.id_materia='.$id_materia.'
                and eva_carga_academica.grupo='.$id_grupo.'
                and eva_carga_academica.id_status_materia=1
                and eva_carga_academica.id_materia=gnral_materias.id_materia
                and eva_tipo_curso.id_tipo_curso=eva_carga_academica.id_tipo_curso
                and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
				and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno 
                and eva_validacion_de_cargas.estado_validacion in (2,9,10) 
                and eva_validacion_de_cargas.id_periodo= eva_validacion_de_cargas.id_periodo
                and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
                ORDER BY gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.nombre');	//dd($alumnos);
				$array_alumnos=array();
				$num_alumnos=0;
                $numer_al=0;
                $promed=0;
				foreach ($alumnos as $alumno)
				{  $sumativas = false;
						$esc_alumno=false;
						$num_alumnos++;
						$clave_m=$alumno->clave;
						$unidades=$alumno->unidades;
                    if($alumno->estado_validacion != 10)
                    {
                        $numer_al++;
                    }
                    if($alumno->id_carrera == $mat->id_carrera){
                        $dat_alumnos['carrera']=1;
                    }
                    else{
                        $dat_alumnos['carrera']=2;
                    }
						$dat_alumnos['np']=$num_alumnos;
						$dat_alumnos['id_alumno']=$alumno->id_alumno;
						$dat_alumnos['id_carga_academica']=$alumno->id_carga_academica;
						$dat_alumnos['cuenta']=$alumno->cuenta;
                        $dat_alumnos['estado_validacion'] = $alumno->estado_validacion;
						$dat_alumnos['nombre']=mb_strtoupper($alumno->apaterno,'utf-8')." ".mb_strtoupper($alumno->amaterno,'utf-8')." ".mb_strtoupper($alumno->nombre,'utf-8');
						$array_calificaciones=array();
						$calificaciones=DB::select('SELECT * FROM cal_evaluaciones
											WHERE id_carga_academica='.$alumno->id_carga_academica.'
											ORDER BY cal_evaluaciones.id_unidad');
						$suma_unidades=0;
						$calificaciones!= null ? $numero_unidades=0 : $numero_unidades=1;
						foreach ($calificaciones as $calificacion)
						{
								$dat_calificaciones['id_evaluacion']=$calificacion->id_evaluacion;
								$dat_calificaciones['calificacion']=$calificacion->calificacion;
								$dat_calificaciones['id_unidad']=$calificacion->id_unidad;
								$suma_unidades+=$calificacion->calificacion>=70 ? $calificacion->calificacion : 0;
								if ($calificacion->calificacion<70 || $calificacion->esc==1)
								{
										$esc_alumno=true;
								}
                            if ($calificacion->calificacion < 70) {
                                $sumativas = true;

                            }
								$numero_unidades++;
								array_push($array_calificaciones,$dat_calificaciones);
						}
                    $dat_alumnos['repeticion'] = $sumativas;
                    if($alumno->estado_validacion == 10)
                    {
                        $esc_alumno=true;

                    }
						$dat_alumnos['esc_alumno']=$esc_alumno;
                    if($alumno->estado_validacion == 10)
                    {
                        $dat_alumnos['promedio'] =0;

                    }
                    else{
                        $prome=intval(round($suma_unidades/$numero_unidades)+0);
                        if($prome >=70 and $sumativas == false){
                            $promed++;
                        }
                        $dat_alumnos['promedio'] = intval(round($suma_unidades / $numero_unidades) + 0);
                    }
                    $dat_alumnos['calificaciones']=$array_calificaciones;
						$dat_alumnos['curso']=$alumno->nombre_curso;
						//$dat_alumnos['nombre']=ucwords(strtolower($alumno->nombre)." ".strtolower($alumno->apaterno)." ".strtolower($alumno->amaterno));
						array_push($array_alumnos,$dat_alumnos);
				}

            if($promed >0 and $numer_al >0){
                $imp_porcentaje=($promed*100)/$numer_al;
            }else{
                $imp_porcentaje=0;
            }
            $no_unidades = DB::select('select gnral_materias.unidades
                from gnral_materias  where  gnral_materias.id_materia=' . $id_materia . '
                ');
            $array_porcentajes=array();
            $porcent=0;

            for (   $i = 1 ; $i <= $no_unidades[0]->unidades ; $i++) {
                $contar_alumnos = 0;
                $aprobados=0;

                foreach ($array_alumnos as $alumnoss) {
                    foreach ($alumnoss['calificaciones'] as $cal) {
                        if ($cal['id_unidad'] == $i) {
                            if ($cal['calificacion'] >= 70) {
                                $contar_alumnos++;
                                $aprobados++;

                            } else {
                                $contar_alumnos++;

                            }
                            $esta = true;
                            break;
                        } // esta es la que se me olvidaba
                    }


                }

                $dat_porcentajes['id_unidad']=$i;
                $dat_porcentajes['apro']=$aprobados;
                $dat_porcentajes['contar']=$contar_alumnos;
                if($contar_alumnos >0 and $aprobados >0)
                {
                    $porcentaje=($aprobados*100)/$contar_alumnos;

                }
                else{
                    $porcentaje=0;
                }
                $porcent+=$porcentaje;
                $dat_porcentajes['porcentaje']=$porcentaje;
                array_push($array_porcentajes,$dat_porcentajes);
            }
            //dd($array_porcentajes);
            $unidades=$mat->unidades;
				$pdf = PDF::loadView('docentes.genera_pdf_sumativas',compact('imp_porcentaje','periodoAct','grupo','nom_carrera','mat','profesor','unidades'),['alumnos'=>$array_alumnos,'porcentajes'=>$array_porcentajes,'uni_asignadas'=>$uni_asignadas]);
				return $pdf->stream('ACTA SUMATIVA '.$mat->nombre.'.pdf');
		}
		public function generaCalSumativasjc()
		{
				$periodo=Session::get('periodo_actual');
				$id_materia=$_GET['id_materia'];
				$id_docente=$_GET['id_docente'];
				$id_grupo=$_GET['id_grupo'];
				$nom_jCarrera=$_GET['nomjefe'];
				$esc_alumno=false;
            $id_usuario = Session::get('usuario_alumno');
            //dd($id_usuario);
            $mat = DB::selectOne('SELECT  gnral_materias.*,gnral_reticulas.id_reticula,gnral_reticulas.clave clave_rec,gnral_reticulas.id_carrera FROM gnral_materias,gnral_reticulas WHERE id_materia = '.$id_materia.' and gnral_reticulas.id_reticula=gnral_materias.id_reticula');
            $grupo = $mat->id_semestre.'0'.$id_grupo ;
            $carrera= DB::selectOne('SELECT gnral_carreras.nombre from gnral_carreras,gnral_reticulas,gnral_materias WHERE gnral_carreras.id_carrera=gnral_reticulas.id_carrera and gnral_reticulas.id_reticula=gnral_materias.id_reticula and gnral_materias.id_materia= '.$id_materia.'');
            $nom_carrera=$carrera->nombre;
            $profesor=DB::selectOne('SELECT abreviaciones.titulo,gnral_personales.nombre from gnral_personales,abreviaciones_prof,abreviaciones WHERE gnral_personales.id_personal=abreviaciones_prof.id_personal and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and gnral_personales.tipo_usuario = '.$id_usuario.'');

				$periodoAct=DB::select("select periodo from gnral_periodos where id_periodo=".$periodo."");
				$periodoAct=$periodoAct[0]->periodo;

            $uni_asignadas = DB::select('select cal_periodos_califica.id_periodo_cal,cal_periodos_califica.id_unidad,cal_periodos_califica.fecha,cal_periodos_califica.id_materia from cal_periodos_califica 
where id_materia='.$id_materia.' and id_grupo='.$id_grupo.' and id_periodos='.$periodo.'');

            $alumnos=DB::select('select gnral_alumnos.id_carrera,gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre, gnral_alumnos.apaterno,gnral_alumnos.amaterno,eva_carga_academica.id_carga_academica, gnral_materias.clave,gnral_materias.nombre materia,gnral_materias.unidades,eva_tipo_curso.nombre_curso,eva_validacion_de_cargas.estado_validacion
                from gnral_alumnos,gnral_materias,eva_carga_academica, gnral_periodos,eva_tipo_curso,eva_validacion_de_cargas
                where gnral_periodos.id_periodo='.$periodo.'
                and gnral_materias.id_materia='.$id_materia.'
                and eva_carga_academica.grupo='.$id_grupo.'
                and eva_carga_academica.id_status_materia=1
                and eva_carga_academica.id_materia=gnral_materias.id_materia
                and eva_tipo_curso.id_tipo_curso=eva_carga_academica.id_tipo_curso
                and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
				and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno 
                and eva_validacion_de_cargas.estado_validacion in (2,9,10) 
                and eva_validacion_de_cargas.id_periodo= eva_validacion_de_cargas.id_periodo
                and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
                ORDER BY gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.nombre');	//dd($alumnos);
            $array_alumnos=array();
            $num_alumnos=0;
            $numer_al=0;
            $promed=0;
            foreach ($alumnos as $alumno)
            {  $sumativas = false;
                $esc_alumno=false;
                $num_alumnos++;
                $clave_m=$alumno->clave;
                $unidades=$alumno->unidades;
                if($alumno->estado_validacion != 10)
                {
                    $numer_al++;
                }
                if($alumno->id_carrera == $mat->id_carrera){
                    $dat_alumnos['carrera']=1;
                }
                else{
                    $dat_alumnos['carrera']=2;
                }
                $dat_alumnos['np']=$num_alumnos;
                $dat_alumnos['id_alumno']=$alumno->id_alumno;
                $dat_alumnos['id_carga_academica']=$alumno->id_carga_academica;
                $dat_alumnos['cuenta']=$alumno->cuenta;
                $dat_alumnos['estado_validacion'] = $alumno->estado_validacion;
                $dat_alumnos['nombre']=mb_strtoupper($alumno->apaterno,'utf-8')." ".mb_strtoupper($alumno->amaterno,'utf-8')." ".mb_strtoupper($alumno->nombre,'utf-8');
                $array_calificaciones=array();
                $calificaciones=DB::select('SELECT * FROM cal_evaluaciones
											WHERE id_carga_academica='.$alumno->id_carga_academica.'
											ORDER BY cal_evaluaciones.id_unidad');
                $suma_unidades=0;
                $calificaciones!= null ? $numero_unidades=0 : $numero_unidades=1;
                foreach ($calificaciones as $calificacion)
                {
                    $dat_calificaciones['id_evaluacion']=$calificacion->id_evaluacion;
                    $dat_calificaciones['calificacion']=$calificacion->calificacion;
                    $dat_calificaciones['id_unidad']=$calificacion->id_unidad;
                    $suma_unidades+=$calificacion->calificacion>=70 ? $calificacion->calificacion : 0;
                    if ($calificacion->calificacion<70 || $calificacion->esc==1)
                    {
                        $esc_alumno=true;
                    }
                    if ($calificacion->calificacion < 70) {
                        $sumativas = true;

                    }
                    $numero_unidades++;
                    array_push($array_calificaciones,$dat_calificaciones);
                }
                $dat_alumnos['repeticion'] = $sumativas;
                if($alumno->estado_validacion == 10)
                {
                    $esc_alumno=true;

                }
                $dat_alumnos['esc_alumno']=$esc_alumno;
                if($alumno->estado_validacion == 10)
                {
                    $dat_alumnos['promedio'] =0;

                }
                else{
                    $prome=intval(round($suma_unidades/$numero_unidades)+0);
                    if($prome >=70 and $sumativas == false){
                        $promed++;
                    }
                    $dat_alumnos['promedio'] = intval(round($suma_unidades / $numero_unidades) + 0);
                }
                $dat_alumnos['calificaciones']=$array_calificaciones;
                $dat_alumnos['curso']=$alumno->nombre_curso;
                //$dat_alumnos['nombre']=ucwords(strtolower($alumno->nombre)." ".strtolower($alumno->apaterno)." ".strtolower($alumno->amaterno));
                array_push($array_alumnos,$dat_alumnos);
            }
            if($promed >0 and $numer_al >0){
                $imp_porcentaje=($promed*100)/$numer_al;
            }else{
                $imp_porcentaje=0;
            }
            $no_unidades = DB::select('select gnral_materias.unidades
                from gnral_materias  where  gnral_materias.id_materia=' . $id_materia . '
                ');
            $array_porcentajes=array();
            $porcent=0;

            for (   $i = 1 ; $i <= $no_unidades[0]->unidades ; $i++) {
                $contar_alumnos = 0;
                $aprobados=0;

                foreach ($array_alumnos as $alumnoss) {
                    foreach ($alumnoss['calificaciones'] as $cal) {
                        if ($cal['id_unidad'] == $i) {
                            if ($cal['calificacion'] >= 70) {
                                $contar_alumnos++;
                                $aprobados++;

                            } else {
                                $contar_alumnos++;

                            }
                            $esta = true;
                            break;
                        } // esta es la que se me olvidaba
                    }


                }

                $dat_porcentajes['id_unidad']=$i;
                $dat_porcentajes['contar']=$contar_alumnos;
                if($contar_alumnos >0 and $aprobados >0)
                {
                    $porcentaje=($aprobados*100)/$contar_alumnos;

                }
                else{
                    $porcentaje=0;
                }
                $porcent+=$porcentaje;
                $dat_porcentajes['porcentaje']=$porcentaje;
                array_push($array_porcentajes,$dat_porcentajes);
            }
            $unidades=$mat->unidades;
				$pdf = PDF::loadView('docentes.genera_pdf_sumativas',compact('imp_porcentaje','periodoAct','grupo','profesor','mat','nom_carrera','unidades'),['alumnos'=>$array_alumnos,'porcentajes'=>$array_porcentajes,'uni_asignadas'=>$uni_asignadas]);
				return $pdf->stream('ACTA SUMATIVA '.$mat->nombre.'.pdf');
		}
}
