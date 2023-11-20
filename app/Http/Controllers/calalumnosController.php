<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Support\Facades\DB;


class calalumnosController extends Controller
{
    public function index()
    {
        $periodo=Session::get('periodo_actual');
        $carrera = Session::get('carrera');
        $mayor_unidades=0;
        $esc_alumno=false;
        $id_usuario = Session::get('usuario_alumno');
        $datosalumno=DB::selectOne('select * FROM `gnral_alumnos` WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;

        $docentes=DB::select('select  gnral_materias.id_materia,gnral_materias.nombre as materias,gnral_materias.unidades,gnral_materias.id_materia,eva_tipo_curso.nombre_curso,
eva_carga_academica.id_carga_academica,eva_carga_academica.grupo,gnral_materias.id_semestre,
gnral_materias.creditos,eva_status_materia.nombre_status from
                                gnral_materias,eva_status_materia,eva_tipo_curso,gnral_grupos,eva_carga_academica,gnral_periodos,gnral_alumnos,eva_validacion_de_cargas
                                where eva_carga_academica.id_materia=gnral_materias.id_materia
                                and eva_carga_academica.id_status_materia=eva_status_materia.id_status_materia
                                and eva_carga_academica.id_tipo_curso=eva_tipo_curso.id_tipo_curso
                                and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
                                and eva_carga_academica.grupo=gnral_grupos.id_grupo
                                and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                                and gnral_periodos.id_periodo='.$periodo.'
                                and gnral_alumnos.id_alumno=eva_validacion_de_cargas.id_alumno
                                and gnral_periodos.id_periodo=eva_validacion_de_cargas.id_periodo
                                and eva_carga_academica.id_materia  NOT IN (773,845,853,1160,1263,1264,1265,1443,1496,1502,1565,1566,1567,1568,1569,1571)
                                and eva_validacion_de_cargas.estado_validacion in (2,8,9)
                                and eva_validacion_de_cargas.id_alumno='.$alumno.'
                                and eva_status_materia.id_status_materia=1');
        $array_materias=array();
        foreach ($docentes as $dat_alumno)
        {
            $esc_alumno=false;
            $suma_unidades=0;
            $unidades_evaluadas=0;
            $promedio_general=0;
            $dat_materia['id_materia']=$dat_alumno->id_materia;
            $dat_materia['curso']=$dat_alumno->nombre_curso;
            $dat_materia["materia"]=$dat_alumno->materias;
            $dat_materia["unidades"]=$dat_alumno->unidades;
            $mayor_unidades= $mayor_unidades > $dat_alumno->unidades ? $mayor_unidades : $dat_alumno->unidades;
            $array_calificaciones=array();
            $calificaciones=DB::select('SELECT * FROM cal_evaluaciones
                      WHERE id_carga_academica='.$dat_alumno->id_carga_academica.'
                      ORDER BY cal_evaluaciones.id_unidad');
            $calificaciones != null ? $unidades_evaluadas=0 : $unidades_evaluadas=1;
            foreach ($calificaciones as $calificacion)
            {
                $dat_calificaciones['id_evaluacion']=$calificacion->id_evaluacion;
                $dat_calificaciones['calificacion']=$calificacion->calificacion;
                $dat_calificaciones['id_unidad']=$calificacion->id_unidad;
                if ($calificacion->calificacion<70 || $calificacion->esc==1)
                {
                    $esc_alumno=true;
                }
                if ($calificacion->calificacion<70 )
                {
                    $promedio_general++;
                }
                $unidades_evaluadas++;
                $suma_unidades+=$calificacion->calificacion>=70 ? $calificacion->calificacion : 0;
                array_push($array_calificaciones,$dat_calificaciones);
            }
            if($promedio_general == 0){

                $dat_materia['promedio'] = intval(round($suma_unidades / $unidades_evaluadas) + 0);

            }
            else {
                $dat_materia['promedio']=0;
            }
          //  $dat_materia['promedio']=intval(round($suma_unidades/$unidades_evaluadas)+0);
            $dat_materia['esc_alumno']=$esc_alumno;
            $dat_materia["calificaciones"]=$array_calificaciones;
            array_push($array_materias,$dat_materia);
        }

       // dd($array_materias);
       // $array_profesor=array();
    $profesores=DB::select('select gnral_personales.nombre,gnral_materias.nombre materias,gnral_horas_profesores.grupo,gnral_horas_profesores.id_hrs_profesor ,gnral_materias.id_semestre
                            from gnral_alumnos, gnral_personales,gnral_materias,gnral_materias_perfiles,gnral_horarios,gnral_horas_profesores,gnral_periodo_carreras,gnral_periodos,eva_carga_academica,
                            eva_validacion_de_cargas
                            where gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo  
                            and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                            and gnral_horarios.id_personal=gnral_personales.id_personal 
                            and gnral_materias_perfiles.id_materia=gnral_materias.id_materia 
                            and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil 
                            and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor 
                            and gnral_periodos.id_periodo='.$periodo.'
                            and eva_carga_academica.id_periodo=gnral_periodos.id_periodo 
                            and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno 
                            and eva_carga_academica.id_materia=gnral_materias.id_materia 
                            and gnral_alumnos.id_alumno='.$alumno.'
                            and eva_carga_academica.grupo=gnral_horas_profesores.grupo
                            and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
                            and eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno
                            and eva_carga_academica.id_status_materia=1
                            and eva_validacion_de_cargas.estado_validacion in (2,8,9)');

         $estado_validacion_carga=DB::selectOne('SELECT count(eva_validacion_de_cargas.id) estado 
from eva_validacion_de_cargas where id_periodo = '.$periodo.' and estado_validacion in (2,8, 9) and id_alumno ='.$alumno.'');

         $estado_residencia=DB::selectOne('SELECT count(eva_validacion_de_cargas.id) estado 
from eva_validacion_de_cargas, eva_carga_academica where eva_validacion_de_cargas.id_periodo = '.$periodo.' 
                                                     and eva_validacion_de_cargas.estado_validacion in (2,8, 9) 
                                                     and eva_validacion_de_cargas.id_alumno ='.$alumno.' 
                                                     and eva_carga_academica.id_materia IN (773,845,853,1160,1263,1264,1265,1443,1496,1502,1565,1566,1567,1568,1569,1571) 
                                                     and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno and
                                                      eva_validacion_de_cargas.id_periodo=eva_carga_academica.id_periodo ');
         $estado_residencia=$estado_residencia->estado;
        $proceso=0;
        $cal_residencia=0;
         if($estado_residencia == 0){
             $estado_residencia=0;
         }else{
             $estado_residencia=1;
             $id_anteproyecto = DB::selectOne('SELECT resi_anteproyecto.id_anteproyecto from resi_anteproyecto,
                                              resi_asesores WHERE resi_anteproyecto.id_anteproyecto =resi_asesores.id_anteproyecto 
                                                              and resi_anteproyecto.id_alumno='.$alumno.' and resi_asesores.id_periodo='.$periodo.'');
             if($id_anteproyecto == null)
             {
                 $proceso=1; //proceso de   validacion de anteproyecto
                 $cal_residencia=0;
             }else{
                 $id_anteproyecto=$id_anteproyecto->id_anteproyecto;
                $cal_residencia=DB::selectOne('SELECT * FROM `resi_promedio_general_residencia` WHERE `id_anteproyecto` ='.$id_anteproyecto.'');
             if($cal_residencia == null){
                 $proceso=2; //proceso  de seguimiento
                 $cal_residencia=0;
             }else{
                 $proceso=3;
                 $cal_residencia=$cal_residencia->promedio_general;

             }
             }

         }
        //dd($array_materias);
        return view('evaluacion_docente.Alumnos.calificaciones',compact('cal_residencia','proceso','estado_residencia','docentes','mayor_unidades','array_materias','profesores','estado_validacion_carga'));
    }
}
