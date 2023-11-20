<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\alumnos;
use App\carreras;
use App\ValidacionCarga;
use App\Activa_evaluacion;

class Computo_calificarController extends Controller
{
    public function index(){
        $periodo=Session::get('periodo_actual');


        $alumnos=DB::select('select eva_validacion_de_cargas.id, eva_validacion_de_cargas.id_alumno,gnral_alumnos.cuenta, gnral_alumnos.nombre, gnral_alumnos.apaterno, gnral_alumnos.amaterno, gnral_carreras.nombre carreras 
                                FROM eva_validacion_de_cargas, gnral_alumnos, gnral_carreras 
                                where eva_validacion_de_cargas.id_periodo='.$periodo.' 
                                AND eva_validacion_de_cargas.estado_validacion in (2,8,9)
                                AND eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno 
                                AND gnral_alumnos.id_carrera=gnral_carreras.id_carrera');
        return view('computo.calificar_alumnos',compact('alumnos'));
}
    public function calificacion_al($id_carga)
    {
        $validar_carga = DB::table('eva_validacion_de_cargas')
            ->where('id', '=', $id_carga)
            ->get();

        $id_alumno = $validar_carga[0]->id_alumno;
        $id_periodo = $validar_carga[0]->id_periodo;
        $alum = DB::table('gnral_alumnos')
            ->where('id_alumno', '=', $id_alumno)
            ->get();
        $nombre_alumno = $alum[0]->cuenta . " " . mb_strtoupper($alum[0]->apaterno, 'utf-8') . " " . mb_strtoupper($alum[0]->amaterno, 'utf-8') . " " . mb_strtoupper($alum[0]->nombre, 'utf-8');
        $calificar_dual = DB::table('cal_duales_actuales')
            ->select(DB::raw('count(*) as calificado'))
            ->where('id_alumno', '=', $id_alumno)
            ->where('id_periodo', '=', $id_periodo)
            ->get();
        $calificar_dual=$calificar_dual[0]->calificado;
        $profesores=DB::select('SELECT gnral_personales.id_personal,gnral_personales.nombre,abreviaciones.titulo 
FROM abreviaciones_prof,abreviaciones,gnral_personales where
 gnral_personales.id_personal=abreviaciones_prof.id_personal and 
 abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion ORDER BY `gnral_personales`.`nombre` ASC');

        if($calificar_dual == 0){
            $calificar_dual=0;
            $mentor=0;
        }
        else{
            $profesor = DB::table('cal_duales_actuales')
                ->where('cal_duales_actuales.id_alumno', '=', $id_alumno)
                ->where('cal_duales_actuales.id_periodo', '=', $id_periodo)
                ->get();
            $mentor=$profesor[0]->id_personal;
            $calificar_dual=1;
        }
        $materias=DB::select('select  gnral_materias.id_materia,gnral_materias.nombre as materias,gnral_materias.unidades,gnral_materias.id_materia,eva_tipo_curso.nombre_curso,
eva_carga_academica.id_carga_academica,eva_carga_academica.grupo,gnral_materias.id_semestre,
gnral_materias.creditos,eva_status_materia.nombre_status from
                                gnral_materias,eva_status_materia,eva_tipo_curso,gnral_grupos,eva_carga_academica,gnral_periodos,gnral_alumnos,eva_validacion_de_cargas
                                where eva_carga_academica.id_materia=gnral_materias.id_materia
                                and eva_carga_academica.id_status_materia=eva_status_materia.id_status_materia
                                and eva_carga_academica.id_tipo_curso=eva_tipo_curso.id_tipo_curso
                                and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
                                and eva_carga_academica.grupo=gnral_grupos.id_grupo
                                and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                                and gnral_periodos.id_periodo='.$id_periodo.'
                                and eva_carga_academica.id_materia  NOT IN (773,845,853,1160,1263,1264,1265,1443,1496,1502,1565,1566,1567,1568,1569,1571)
                                and gnral_alumnos.id_alumno=eva_validacion_de_cargas.id_alumno
                                and gnral_periodos.id_periodo=eva_validacion_de_cargas.id_periodo
                                and eva_validacion_de_cargas.id_alumno='.$id_alumno.'
                                and eva_status_materia.id_status_materia=1');

        //dd($materias);
        $array_materias=array();
        $mayor_unidades=0;
        $esc_alumno=false;
        foreach ($materias as $dat_alumno)
        {
            $esc_alumno=false;
            $suma_unidades=0;
            $unidades_evaluadas=0;
            $promedio_general=0;
            $dat_materia['id_carga_academica']=$dat_alumno->id_carga_academica;
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

        return view('computo.cal_alumno',compact('mentor','profesores','id_alumno','id_periodo','array_materias','mayor_unidades','nombre_alumno','calificar_dual'));

    }
    public function promedios_al_carrera(){
        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
    return view('computo.promedio_alumnos.promedio_carrera',compact('carreras'));
    }

    public function ver_carrera_alumno($id_carrera)
    {
        $id_periodo = Session::get('periodo_actual');
        $alumnos = DB::select('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,
       gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.id_carrera 
from gnral_alumnos,eva_validacion_de_cargas where gnral_alumnos.id_alumno=eva_validacion_de_cargas.id_alumno
    and eva_validacion_de_cargas.id_periodo=' . $id_periodo . ' and gnral_alumnos.id_carrera=' . $id_carrera . ' 
                                              and eva_validacion_de_cargas.estado_validacion in (2,8,9)');
        $array_alumnos = array();
        $contar_alumnos_100 = 0;
        $contar_alumnos_50_con_s = 0;
        $contar_alumnos_50_sin_s = 0;
        foreach ($alumnos as $alumno) {
            $datos_alumnos['id_alumno'] = $alumno->id_alumno;
            $datos_alumnos['cuenta'] = $alumno->cuenta;
            $datos_alumnos['nombre_alumno'] = mb_strtoupper($alumno->apaterno, 'utf-8') . " " . mb_strtoupper($alumno->amaterno, 'utf-8') . " " . mb_strtoupper($alumno->nombre, 'utf-8');
            $materias = DB::select('select  gnral_materias.id_materia,eva_carga_academica.id_tipo_curso,gnral_materias.nombre as materias,gnral_materias.unidades,gnral_materias.id_materia,eva_tipo_curso.nombre_curso,
eva_carga_academica.id_carga_academica,eva_carga_academica.grupo,gnral_materias.id_semestre,
gnral_materias.creditos,eva_status_materia.nombre_status from
                                gnral_materias,eva_status_materia,eva_tipo_curso,gnral_grupos,eva_carga_academica
                                where eva_carga_academica.id_materia=gnral_materias.id_materia
                                and eva_carga_academica.id_status_materia=eva_status_materia.id_status_materia
                                and eva_carga_academica.id_tipo_curso=eva_tipo_curso.id_tipo_curso
                                and eva_carga_academica.id_periodo=' . $id_periodo . '
                                and eva_carga_academica.grupo=gnral_grupos.id_grupo
                                and eva_carga_academica.id_alumno=' . $alumno->id_alumno . '
                                and eva_status_materia.id_status_materia=1');

            $promedio_final = 0;
            $mat = 0;
            $array_materias = array();
            $contar_mat_reprobadas = 0;
            $contar_sumativas = 0;
            foreach ($materias as $materia) {
                $mat++;


                $dat_materia['id_materia'] = $materia->id_materia;
                $dat_materia['id_semestre'] = $materia->id_semestre;
                $dat_materia['curso'] = $materia->nombre_curso;
                $dat_materia["materia"] = $materia->materias;
                $dat_materia["unidades"] = $materia->unidades;

                $array_calificaciones = array();
                $calificaciones = DB::select('SELECT * FROM cal_evaluaciones
                      WHERE id_carga_academica=' . $materia->id_carga_academica . '
                      ORDER BY cal_evaluaciones.id_unidad');
                //dd($calificaciones);
                $contar_evaluaciones = DB::selectOne('SELECT count(id_evaluacion) contar FROM cal_evaluaciones
                      WHERE id_carga_academica=' . $materia->id_carga_academica . '
                      ORDER BY cal_evaluaciones.id_unidad');
                $contar_evaluaciones = $contar_evaluaciones->contar;

                $suma_unidades = 0;
                $mat_reprobada = 0;
                $esc_alumno = false;
                if ($contar_evaluaciones >= $materia->unidades) {
                    foreach ($calificaciones as $calificacion) {

                        if ($calificacion->calificacion < 70 || $calificacion->esc == 1) {
                            $esc_alumno = true;
                        }
                        if ($calificacion->calificacion < 70) {
                            $mat_reprobada++;
                        }
                        $suma_unidades += $calificacion->calificacion >= 70 ? $calificacion->calificacion : 0;
                    }
                    if ($mat_reprobada == 0) {
                        $pro = intval(round($suma_unidades / $materia->unidades) + 0);
                        $promedio_final += $pro;
                        $dat_materia['reprobada'] = 0;
                        $dat_materia['promedio'] = $pro;

                    } else {
                        $contar_mat_reprobadas++;
                        $dat_materia['reprobada'] = 1;
                        $dat_materia['promedio'] = 0;
                    }

                } else {
                    $contar_mat_reprobadas++;
                    $dat_materia['reprobada'] = 1;
                    $dat_materia['promedio'] = 0;
                }
                if ($esc_alumno == true) {
                    $contar_sumativas++;
                }
                $dat_materia['esc_alumno'] = $esc_alumno;
                array_push($array_materias, $dat_materia);
            }
            $promedio_finals = round(($promedio_final / $mat), 2);
            $datos_alumnos['promedio_final'] = $promedio_finals;
            $datos_alumnos['materias'] = $array_materias;
            $datos_alumnos['mat_reprobadas'] = $contar_mat_reprobadas;
            $datos_alumnos['mat_sumativas'] = $contar_sumativas;

            array_push($array_alumnos, $datos_alumnos);
        }
        foreach ($array_alumnos as $alum) {

            if($alum['mat_reprobadas'] == 0)
            {
                if($alum['mat_sumativas']== 0 and $alum['promedio_final'] >=95){
                    $contar_alumnos_100++;

                }
                elseif($alum['mat_sumativas'] == 1 and $alum['promedio_final'] >=95 ){
                    $contar_alumnos_50_con_s++;

                }
                elseif($alum['mat_sumativas'] == 0 and $alum['promedio_final'] >=90 and $alum['promedio_final'] <=94 ){
                    $contar_alumnos_50_sin_s++;
                }

            }

        }
        $total=$contar_alumnos_100+$contar_alumnos_50_con_s+$contar_alumnos_50_sin_s;
       $carrera=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera` = '.$id_carrera.' ORDER BY `id_carrera` ASC ');
        return view('computo.promedio_alumnos.alumnos_contados_beca',compact('contar_alumnos_100','contar_alumnos_50_sin_s','contar_alumnos_50_con_s','carrera','total'));
    }
    public function registrar_imagen(){
        $alumnos=DB::select('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta, exp_generales.nombre,exp_generales.foto from gnral_alumnos,exp_generales where exp_generales.id_alumno = gnral_alumnos.id_alumno GROUP by gnral_alumnos.id_alumno ');

     return view('tutorias.administrador.reg_imagenes',compact('alumnos'));
    }
    public function modificar_imagen(Request $request,$id_alumno){

        $alumno=DB::selectOne('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta, exp_generales.nombre,exp_generales.foto from gnral_alumnos,exp_generales where exp_generales.id_alumno = gnral_alumnos.id_alumno and  gnral_alumnos.id_alumno='.$id_alumno.'');

        $file = $request->file('foto');
        $tipo = $file->getClientOriginalExtension();
        $file->move(public_path().'/Fotografias/',$alumno->cuenta.'.'.$tipo);
        DB::table('exp_generales')
            ->where('id_alumno', $id_alumno)
            ->update(['foto' => 'image/'.$tipo]);
        return back();

    }
}
