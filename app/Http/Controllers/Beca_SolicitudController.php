<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\carreras;
use App\materias;
use App\reticulas;
use Session;

class Beca_SolicitudController extends Controller
{
    public function  index()

    {


        $id_periodo = Session::get('periodo_actual');
        $fecha_hoy=date("Y-m-d ");
        $periodo_beca=DB::selectOne("SELECT count(id_beca_periodo)estado FROM beca_periodo  WHERE id_periodo='$id_periodo' and '$fecha_hoy' BETWEEN 	fecha_inicial AND fecha_final ");
        $periodo_beca=$periodo_beca->estado;
        $semestres=DB::select("select *from gnral_semestres");




        $id_usuario = Session::get('usuario_alumno');
        $datosalumno = DB::table('gnral_alumnos')
            ->join('gnral_carreras', 'gnral_carreras.id_carrera', '=', 'gnral_alumnos.id_carrera')
            ->join('gnral_semestres', 'gnral_semestres.id_semestre', '=', 'gnral_alumnos.id_semestre')
            ->select('gnral_alumnos.*', 'gnral_semestres.descripcion as semestre', 'gnral_carreras.nombre as carrera')
            ->where('id_usuario', '=', $id_usuario)
            ->get();


        $id_alumno = $datosalumno[0]->id_alumno;
        $id_carrera = Session::get('carrera');
        $id_semestre = $datosalumno[0]->id_semestre;

        $alta_carga = DB::selectOne('SELECT count(id)validacion FROM eva_validacion_de_cargas 
WHERE id_alumno = ' . $id_alumno . ' AND id_periodo = ' . $id_periodo . ' and estado_validacion in (2,8,9)');
        $alta_carga = $alta_carga->validacion;


        if ($alta_carga == 0) {
            $alta_carga =0;
            $peri=DB::selectOne('SELECT beca_periodo.*,gnral_periodos.periodo from beca_periodo,gnral_periodos 
            where beca_periodo.id_periodo=gnral_periodos.id_periodo ');
            $descuento_estimulo=0;
            $promedio_final=0;
            return view('beca_estimulo.solicitud_beca', compact( 'periodo_beca','alta_carga','peri','datosalumno','descuento_estimulo','promedio_final'));

        }else {
            $peri=DB::selectOne('SELECT beca_periodo.*,gnral_periodos.periodo from beca_periodo,gnral_periodos 
            where beca_periodo.id_periodo=gnral_periodos.id_periodo ');

            $alta_carga = 1;
            $estado_beca = DB::selectOne('SELECT COUNT(id_autorizar) autorizar
 FROM beca_autorizar where id_alumno=' . $id_alumno . ' and id_periodo=' . $id_periodo . '');
            $estado_beca = $estado_beca->autorizar;

            if ($estado_beca == 0) {
                $estado_estimulo = 1;
                $docentes = DB::select('select  gnral_materias.id_materia,eva_carga_academica.id_tipo_curso,gnral_materias.nombre as materias,gnral_materias.unidades,gnral_materias.id_materia,eva_tipo_curso.nombre_curso,
eva_carga_academica.id_carga_academica,eva_carga_academica.grupo,gnral_materias.id_semestre,
gnral_materias.creditos,eva_status_materia.nombre_status from
                                gnral_materias,eva_status_materia,eva_tipo_curso,gnral_grupos,eva_carga_academica,gnral_periodos,gnral_alumnos,eva_validacion_de_cargas
                                where eva_carga_academica.id_materia=gnral_materias.id_materia
                                and eva_carga_academica.id_status_materia=eva_status_materia.id_status_materia
                                and eva_carga_academica.id_tipo_curso=eva_tipo_curso.id_tipo_curso
                                and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
                                and eva_carga_academica.grupo=gnral_grupos.id_grupo
                                and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                                and gnral_periodos.id_periodo=' . $id_periodo . '
                                and gnral_alumnos.id_alumno=eva_validacion_de_cargas.id_alumno
                                and gnral_periodos.id_periodo=eva_validacion_de_cargas.id_periodo
                                and eva_validacion_de_cargas.estado_validacion in (2,8,9)
                                and eva_validacion_de_cargas.id_alumno=' . $id_alumno . '
                                and eva_status_materia.id_status_materia=1');

                $mayor_unidades = 0;
                $array_materias = array();
                $numero_curso_no_normal = 0;
                $diferente_semestre = 0;
                $mat_reprobadas = 0;
                $sumativas = 0;
                $promedio_final = 0;
                $mat = 0;
                foreach ($docentes as $dat_alumno) {
                    $esc_alumno = false;
                    $reprobada = false;
                    $suma_unidades = 0;
                    $unidades_evaluadas = 0;
                    $promedio_general = 0;
                    if ($dat_alumno->id_tipo_curso >= 3) {
                        $numero_curso_no_normal++;
                    }

                    $mat++;
                    $dat_materia['id_materia'] = $dat_alumno->id_materia;
                    $dat_materia['id_semestre'] = $dat_alumno->id_semestre;
                    $dat_materia['curso'] = $dat_alumno->nombre_curso;
                    $dat_materia["materia"] = $dat_alumno->materias;
                    $dat_materia["unidades"] = $dat_alumno->unidades;
                    $mayor_unidades = $mayor_unidades > $dat_alumno->unidades ? $mayor_unidades : $dat_alumno->unidades;
                    $array_calificaciones = array();
                    $calificaciones = DB::select('SELECT * FROM cal_evaluaciones
                      WHERE id_carga_academica=' . $dat_alumno->id_carga_academica . '
                      ORDER BY cal_evaluaciones.id_unidad');
                    $contar_evaluaciones = DB::selectOne('SELECT count(id_evaluacion) contar FROM cal_evaluaciones
                      WHERE id_carga_academica=' . $dat_alumno->id_carga_academica . '
                      ORDER BY cal_evaluaciones.id_unidad');
                    $contar_evaluaciones = $contar_evaluaciones->contar;
                    $calificaciones != null ? $unidades_evaluadas = 0 : $unidades_evaluadas = 1;
                    foreach ($calificaciones as $calificacion) {
                        $dat_calificaciones['id_evaluacion'] = $calificacion->id_evaluacion;
                        $dat_calificaciones['calificacion'] = $calificacion->calificacion;
                        $dat_calificaciones['id_unidad'] = $calificacion->id_unidad;
                        if ($calificacion->calificacion < 70 || $calificacion->esc == 1) {
                            $esc_alumno = true;
                        }
                        if ($calificacion->calificacion < 70) {
                            $reprobada = true;
                            $promedio_general++;
                            $mat_reprobadas++;
                        }
                        $unidades_evaluadas++;
                        $suma_unidades += $calificacion->calificacion >= 70 ? $calificacion->calificacion : 0;
                        array_push($array_calificaciones, $dat_calificaciones);
                    }


                    if ($promedio_general == 0 and $contar_evaluaciones == $dat_alumno->unidades) {
                        $pro = intval(round($suma_unidades / $dat_alumno->unidades) + 0);
                        $promedio_final += $pro;
                        $dat_materia['promedio'] = $pro;

                    } else {
                        $dat_materia['promedio'] = 0;
                    }
                    //  $dat_materia['promedio']=intval(round($suma_unidades/$unidades_evaluadas)+0);
                    if ($esc_alumno == true) {
                        $sumativas++;
                    }
                    $dat_materia['reprobada'] = $reprobada;
                    $dat_materia['esc_alumno'] = $esc_alumno;
                    $dat_materia["calificaciones"] = $array_calificaciones;
                    array_push($array_materias, $dat_materia);
                }
                if ($promedio_final > 0 and $mat > 0) {
                    $promedio_final = round($promedio_final / $mat, 2);
                    $promedio_final = number_format($promedio_final, 2, '.', '');

                } else {
                    $promedio_final = 0;
                }


                if ($numero_curso_no_normal == 0 and $mat_reprobadas == 0 and $sumativas == 0 and $promedio_final >= 95 and $promedio_final <= 100) {
                    $descuento_estimulo = 1;


                } elseif ($numero_curso_no_normal == 0 and $mat_reprobadas == 0 and $sumativas == 1 and $promedio_final >= 95 and $promedio_final <= 100) {
                    $descuento_estimulo = 2;

                } elseif ($numero_curso_no_normal == 0 and $mat_reprobadas == 0 and $sumativas == 0 and $promedio_final >= 90 and $promedio_final < 95) {

                    $descuento_estimulo = 3;

                } else {
                    $descuento_estimulo = 4;

                }
                return view('beca_estimulo.solicitud_beca', compact('peri','periodo_beca','alta_carga', 'estado_estimulo', 'descuento_estimulo', 'array_materias', 'mayor_unidades', 'datosalumno', 'promedio_final', 'estado_beca','semestres'));


            } else {
                $estado_beca = 1;
                $estado_estimulo=0;
                $descuento_estimulo=0;
                $promedio_final=0;
                $registro_estado = DB::selectOne('SELECT  beca_autorizar.*,gnral_semestres.descripcion as semestre FROM beca_autorizar,gnral_semestres where beca_autorizar.id_alumno=' . $id_alumno . ' and beca_autorizar.id_periodo=' . $id_periodo . ' and beca_autorizar.id_semestre=gnral_semestres.id_semestre');

                return view('beca_estimulo.solicitud_beca', compact('periodo_beca','alta_carga', 'estado_beca', 'datosalumno', 'registro_estado','estado_estimulo','descuento_estimulo','promedio_final'));


            }


        }





                    //dd($array_materias);






    }
    public function enviar_estimulo($id_alumno,$descuento_estimulo,$promedio_final,$id_semestre){
        $id_periodo=Session::get('periodo_actual');

        $fecha = date("d/m/Y");
        if($descuento_estimulo == 1){ //100
            DB:: table('beca_autorizar')->insert(['id_alumno'=>$id_alumno,'id_descuento'=>1,'promedio'=>$promedio_final,'id_estado'=>1,'id_periodo'=>$id_periodo,'id_semestre'=>$id_semestre,'fecha'=>$fecha]);
        }
        elseif($descuento_estimulo == 2){ //50 con sumativa
            DB:: table('beca_autorizar')->insert(['id_alumno'=>$id_alumno,'id_descuento'=>2,'promedio'=>$promedio_final,'id_estado'=>1,'id_periodo'=>$id_periodo,'id_semestre'=>$id_semestre,'fecha'=>$fecha]);
        }
        elseif($descuento_estimulo ==3){//50
            DB:: table('beca_autorizar')->insert(['id_alumno'=>$id_alumno,'id_descuento'=>3,'promedio'=>$promedio_final,'id_estado'=>1,'id_periodo'=>$id_periodo,'id_semestre'=>$id_semestre,'fecha'=>$fecha]);

        }
        return back();

    }
    public function escolares_autorizar(){
        $id_periodo=Session::get('periodo_actual');
        $autorizar_escolares=DB::select('SELECT gnral_alumnos.correo_al,gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,
gnral_alumnos.amaterno,gnral_alumnos.curp_al,beca_descuento.descripcion descuento,beca_descuento.id_descuento,beca_autorizar.promedio,
gnral_semestres.id_semestre,gnral_semestres.descripcion semestre,beca_autorizar.id_autorizar,gnral_carreras.id_carrera,gnral_carreras.nombre carrera
 FROM gnral_alumnos,beca_descuento,beca_autorizar,gnral_semestres,gnral_carreras WHERE gnral_alumnos.id_alumno=beca_autorizar.id_alumno 
 and gnral_alumnos.id_carrera=gnral_carreras.id_carrera and beca_autorizar.id_descuento=beca_descuento.id_descuento 
 and beca_autorizar.id_semestre=gnral_semestres.id_semestre and beca_autorizar.id_periodo='.$id_periodo.' and beca_autorizar.id_estado=1 ');

        $rechazados_escolares=DB::select('SELECT gnral_alumnos.correo_al,gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,
gnral_alumnos.amaterno,gnral_alumnos.curp_al,beca_descuento.descripcion descuento,beca_descuento.id_descuento,beca_autorizar.promedio,
gnral_semestres.id_semestre,gnral_semestres.descripcion semestre,beca_autorizar.id_autorizar,gnral_carreras.id_carrera,gnral_carreras.nombre carrera
 FROM gnral_alumnos,beca_descuento,beca_autorizar,gnral_semestres,gnral_carreras WHERE gnral_alumnos.id_alumno=beca_autorizar.id_alumno 
 and gnral_alumnos.id_carrera=gnral_carreras.id_carrera and beca_autorizar.id_descuento=beca_descuento.id_descuento 
 and beca_autorizar.id_semestre=gnral_semestres.id_semestre and beca_autorizar.id_periodo='.$id_periodo.' and beca_autorizar.id_estado=2 ');

        $autorizar_profesionales=DB::select('SELECT gnral_alumnos.correo_al,gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,
gnral_alumnos.amaterno,gnral_alumnos.curp_al,beca_descuento.descripcion descuento,beca_descuento.id_descuento,beca_autorizar.promedio,
gnral_semestres.id_semestre,gnral_semestres.descripcion semestre,beca_autorizar.id_autorizar,gnral_carreras.id_carrera,gnral_carreras.nombre carrera
 FROM gnral_alumnos,beca_descuento,beca_autorizar,gnral_semestres,gnral_carreras WHERE gnral_alumnos.id_alumno=beca_autorizar.id_alumno 
 and gnral_alumnos.id_carrera=gnral_carreras.id_carrera and beca_autorizar.id_descuento=beca_descuento.id_descuento 
 and beca_autorizar.id_semestre=gnral_semestres.id_semestre and beca_autorizar.id_periodo='.$id_periodo.' and beca_autorizar.id_estado=3 ');

        $rechazados_profesionales=DB::select('SELECT gnral_alumnos.correo_al,gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,
gnral_alumnos.amaterno,gnral_alumnos.curp_al,beca_descuento.descripcion descuento,beca_descuento.id_descuento,beca_autorizar.promedio,
gnral_semestres.id_semestre,gnral_semestres.descripcion semestre,beca_autorizar.id_autorizar,gnral_carreras.id_carrera,gnral_carreras.nombre carrera
 FROM gnral_alumnos,beca_descuento,beca_autorizar,gnral_semestres,gnral_carreras WHERE gnral_alumnos.id_alumno=beca_autorizar.id_alumno 
 and gnral_alumnos.id_carrera=gnral_carreras.id_carrera and beca_autorizar.id_descuento=beca_descuento.id_descuento 
 and beca_autorizar.id_semestre=gnral_semestres.id_semestre and beca_autorizar.id_periodo='.$id_periodo.' and beca_autorizar.id_estado=4 ');

        $autorizados_profesionales=DB::select('SELECT gnral_alumnos.correo_al,gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,
gnral_alumnos.amaterno,gnral_alumnos.curp_al,beca_descuento.descripcion descuento,beca_descuento.id_descuento,beca_autorizar.promedio,
gnral_semestres.id_semestre,gnral_semestres.descripcion semestre,beca_autorizar.id_autorizar,gnral_carreras.id_carrera,gnral_carreras.nombre carrera
 FROM gnral_alumnos,beca_descuento,beca_autorizar,gnral_semestres,gnral_carreras WHERE gnral_alumnos.id_alumno=beca_autorizar.id_alumno 
 and gnral_alumnos.id_carrera=gnral_carreras.id_carrera and beca_autorizar.id_descuento=beca_descuento.id_descuento 
 and beca_autorizar.id_semestre=gnral_semestres.id_semestre and beca_autorizar.id_periodo='.$id_periodo.' and beca_autorizar.id_estado=5 ');

        return view('beca_estimulo.autorizar_escolares',compact('autorizar_escolares','rechazados_escolares','autorizar_profesionales','rechazados_profesionales','autorizados_profesionales'));
    }
    public function verificar_beca($id_autorizar,$autorizacion){
        if($autorizacion == 1){
            DB::update('UPDATE beca_autorizar SET id_estado = 3 WHERE id_autorizar='.$id_autorizar.'');

        }
        if ($autorizacion == 2)
        {
            DB::update('UPDATE beca_autorizar SET id_estado = 2 WHERE id_autorizar='.$id_autorizar.'');

        }
return back();

    }
    public function autorizar_academico(){
        $id_periodo=Session::get('periodo_actual');
        $autorizar_escolares=DB::select('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,
gnral_alumnos.amaterno,gnral_alumnos.curp_al,beca_descuento.descripcion descuento,beca_descuento.id_descuento,beca_autorizar.promedio,
gnral_semestres.id_semestre,gnral_semestres.descripcion semestre,beca_autorizar.id_autorizar,gnral_carreras.id_carrera,gnral_carreras.nombre carrera
 FROM gnral_alumnos,beca_descuento,beca_autorizar,gnral_semestres,gnral_carreras WHERE gnral_alumnos.id_alumno=beca_autorizar.id_alumno 
 and gnral_alumnos.id_carrera=gnral_carreras.id_carrera and beca_autorizar.id_descuento=beca_descuento.id_descuento 
 and beca_autorizar.id_semestre=gnral_semestres.id_semestre and beca_autorizar.id_periodo='.$id_periodo.' and beca_autorizar.id_estado=1 ');

        $rechazados_escolares=DB::select('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,
gnral_alumnos.amaterno,gnral_alumnos.curp_al,beca_descuento.descripcion descuento,beca_descuento.id_descuento,beca_autorizar.promedio,
gnral_semestres.id_semestre,gnral_semestres.descripcion semestre,beca_autorizar.id_autorizar,gnral_carreras.id_carrera,gnral_carreras.nombre carrera
 FROM gnral_alumnos,beca_descuento,beca_autorizar,gnral_semestres,gnral_carreras WHERE gnral_alumnos.id_alumno=beca_autorizar.id_alumno 
 and gnral_alumnos.id_carrera=gnral_carreras.id_carrera and beca_autorizar.id_descuento=beca_descuento.id_descuento 
 and beca_autorizar.id_semestre=gnral_semestres.id_semestre and beca_autorizar.id_periodo='.$id_periodo.' and beca_autorizar.id_estado=2 ');

        $autorizar_profesionales=DB::select('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,
gnral_alumnos.amaterno,gnral_alumnos.curp_al,beca_descuento.descripcion descuento,beca_descuento.id_descuento,beca_autorizar.promedio,
gnral_semestres.id_semestre,gnral_semestres.descripcion semestre,beca_autorizar.id_autorizar,gnral_carreras.id_carrera,gnral_carreras.nombre carrera
 FROM gnral_alumnos,beca_descuento,beca_autorizar,gnral_semestres,gnral_carreras WHERE gnral_alumnos.id_alumno=beca_autorizar.id_alumno 
 and gnral_alumnos.id_carrera=gnral_carreras.id_carrera and beca_autorizar.id_descuento=beca_descuento.id_descuento 
 and beca_autorizar.id_semestre=gnral_semestres.id_semestre and beca_autorizar.id_periodo='.$id_periodo.' and beca_autorizar.id_estado=3 ');

        $rechazados_profesionales=DB::select('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,
gnral_alumnos.amaterno,gnral_alumnos.curp_al,beca_descuento.descripcion descuento,beca_descuento.id_descuento,beca_autorizar.promedio,
gnral_semestres.id_semestre,gnral_semestres.descripcion semestre,beca_autorizar.id_autorizar,gnral_carreras.id_carrera,gnral_carreras.nombre carrera
 FROM gnral_alumnos,beca_descuento,beca_autorizar,gnral_semestres,gnral_carreras WHERE gnral_alumnos.id_alumno=beca_autorizar.id_alumno 
 and gnral_alumnos.id_carrera=gnral_carreras.id_carrera and beca_autorizar.id_descuento=beca_descuento.id_descuento 
 and beca_autorizar.id_semestre=gnral_semestres.id_semestre and beca_autorizar.id_periodo='.$id_periodo.' and beca_autorizar.id_estado=4 ');

        $autorizados_profesionales=DB::select('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,
gnral_alumnos.amaterno,gnral_alumnos.curp_al,beca_descuento.descripcion descuento,beca_descuento.id_descuento,beca_autorizar.promedio,
gnral_semestres.id_semestre,gnral_semestres.descripcion semestre,beca_autorizar.id_autorizar,gnral_carreras.id_carrera,gnral_carreras.nombre carrera
 FROM gnral_alumnos,beca_descuento,beca_autorizar,gnral_semestres,gnral_carreras WHERE gnral_alumnos.id_alumno=beca_autorizar.id_alumno 
 and gnral_alumnos.id_carrera=gnral_carreras.id_carrera and beca_autorizar.id_descuento=beca_descuento.id_descuento 
 and beca_autorizar.id_semestre=gnral_semestres.id_semestre and beca_autorizar.id_periodo='.$id_periodo.' and beca_autorizar.id_estado=5 ');

        return view('beca_estimulo.autorizar_academico',compact('autorizar_escolares','rechazados_escolares','autorizar_profesionales','rechazados_profesionales','autorizados_profesionales'));


    }
    public function  verificar_beca_profesionales($id_autorizar,$autorizacion){
        if($autorizacion == 1){
            DB::update('UPDATE beca_autorizar SET id_estado = 5 WHERE id_autorizar='.$id_autorizar.'');

        }
        if ($autorizacion == 2)
        {
            DB::update('UPDATE beca_autorizar SET id_estado = 4 WHERE id_autorizar='.$id_autorizar.'');

        }
        return back();

    }
}
