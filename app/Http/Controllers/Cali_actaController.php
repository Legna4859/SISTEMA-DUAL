<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Classes\PHPExcel;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Requests;
use App\Carreras;
use App\Gnral_Cargos;
use Session;
use PHPExcel_Worksheet_Drawing;

class Cali_actaController extends Controller
{
    public function acta_constituitiva($id_docente,$id_materia,$id_grupo)
    {
        Session::put('id_docente1',$id_docente);
        Session::put('id_materia1',$id_materia);
        Session::put('id_grupo1',$id_grupo);
$mat=DB::selectOne('SELECT * FROM `gnral_materias` WHERE `id_materia` = '.$id_materia.'');
$mat=$mat->nombre;
        Excel::create('Acta-'.$mat, function($excel)
        {
            $excel->sheet('Acta', function($sheet)
            {
                $id_docente=Session::get('id_docente1');
                $id_materia=Session::get('id_materia1');
                $id_grupo=Session::get('id_grupo1');
                $periodo = Session::get('periodo_actual');
                $mat = DB::selectOne('SELECT  *FROM gnral_materias WHERE id_materia = '.$id_materia.'');

                $grupo = $mat->id_semestre.'0'.$id_grupo ;
                $nom_docente = DB::table('gnral_personales')->select('nombre')->where('id_personal', '=', $id_docente)->first();
                $nom_docente = $nom_docente->{'nombre'};
                $carrera= DB::selectOne('SELECT gnral_carreras.nombre from gnral_carreras,gnral_reticulas,gnral_materias WHERE gnral_carreras.id_carrera=gnral_reticulas.id_carrera and gnral_reticulas.id_reticula=gnral_materias.id_reticula and gnral_materias.id_materia= '.$id_materia.'');
                $nom_carrera=$carrera->nombre;
                //accion 1 = periodos
                //accion 2 = calificaciones

                $esc_alumno=false;

                $alumnos = DB::select('select gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre, gnral_alumnos.apaterno,gnral_alumnos.amaterno,eva_carga_academica.id_carga_academica, gnral_materias.clave,gnral_materias.nombre materia,gnral_materias.unidades,eva_tipo_curso.nombre_curso,eva_validacion_de_cargas.estado_validacion
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
                $num_duales = 0;
                $numer_al = 0;
                $promed = 0;
                foreach ($alumnos as $alumno) {
                    if ($alumno->estado_validacion != 10) {
                        $numer_al++;
                    }
                    if ($alumno->estado_validacion == 9) {
                        $num_duales++;
                    }
                    if ($alumno->estado_validacion == 10) {
                        $dat_alumnos["baja"] = 1;
                    } else {
                        $dat_alumnos["baja"] = 0;
                    }
                    $sumativas = false;
                    $esc_alumno = false;
                    $num_alumnos++;
                    $nom_materia = $alumno->materia;
                    $clave_m = $alumno->clave;
                    $unidades = $alumno->unidades;
                    $dat_alumnos['np'] = $num_alumnos;
                    $dat_alumnos['id_alumno'] = $alumno->id_alumno;
                    $dat_alumnos['id_carga_academica'] = $alumno->id_carga_academica;
                    $dat_alumnos['cuenta'] = $alumno->cuenta;
                    $dat_alumnos['estado_validacion'] = $alumno->estado_validacion;
                    $dat_alumnos['nombre'] = mb_strtoupper($alumno->apaterno, 'utf-8') . " " . mb_strtoupper($alumno->amaterno, 'utf-8') . " " . mb_strtoupper($alumno->nombre, 'utf-8');
                    $array_calificaciones = array();
                    $calificaciones = DB::select('SELECT * FROM cal_evaluaciones
                      WHERE id_carga_academica=' . $alumno->id_carga_academica . '
                      ORDER BY cal_evaluaciones.id_unidad');
                    $suma_unidades = 0;
                    $calificaciones != null ? $numero_unidades = 0 : $numero_unidades = 1;
                    $cont_unievaluadas = 0;
                    foreach ($calificaciones as $calificacion) {
                        $bitacora_modificacion = DB::select('SELECT id_carga_academica FROM cal_bitacora_evaluaciones
                      WHERE id_evaluacion=' . $calificacion->id_evaluacion . '
                      GROUP BY cal_bitacora_evaluaciones.id_carga_academica');
                        $dat_calificaciones['id_evaluacion'] = $calificacion->id_evaluacion;
                        $dat_calificaciones['calificacion'] = $calificacion->calificacion;
                        $dat_calificaciones['modificado'] = $bitacora_modificacion != null ? '1' : '2';
                        $dat_calificaciones['id_unidad'] = $calificacion->id_unidad;
                        $suma_unidades += $calificacion->calificacion >= 70 ? $calificacion->calificacion : 0;
                        if ($calificacion->calificacion < 70) {
                            $esc_alumno = true;
                        }
                        if ($calificacion->esc == 1) {
                            $esc_alumno = true;
                            $esc_pormateria = true;
                        }
                        if ($calificacion->calificacion < 70) {
                            $sumativas = true;

                        }


                        $numero_unidades++;
                        $cont_unievaluadas++;
                        array_push($array_calificaciones, $dat_calificaciones);
                    }
                    if ($alumno->estado_validacion == 10) {
                        $esc_alumno = true;
                    }
                    $dat_alumnos['sumativa'] = $sumativas;
                    $dat_alumnos['esc_alumno'] = $esc_alumno;
                    $dat_alumnos["especial_bloq"] = $esc_alumno == 1 && $alumno->nombre_curso == "ESPECIAL" ? 1 : 0;
                    if ($alumno->estado_validacion == 10) {
                        $dat_alumnos['promedio'] = 0;

                    } else {
                        $prome = intval(round($suma_unidades / $numero_unidades) + 0);
                        if ($prome >= 70) {
                            $promed++;
                        }
                        $dat_alumnos['promedio'] = intval(round($suma_unidades / $numero_unidades) + 0);

                    }
                    $dat_alumnos['calificaciones'] = $array_calificaciones;
                    $dat_alumnos['curso'] = $alumno->nombre_curso;
                    //$dat_alumnos['nombre']=ucwords(strtolower($alumno->nombre)." ".strtolower($alumno->apaterno)." ".strtolower($alumno->amaterno));
                    array_push($array_alumnos, $dat_alumnos);
                }
                if ($promed > 0 and $numer_al > 0) {
                    $imp_porcentaje = ($promed * 100) / $numer_al;
                } else {
                    $imp_porcentaje = 0;
                }

                $no_unidades = DB::select('select gnral_materias.unidades
                from gnral_materias  where  gnral_materias.id_materia=' . $id_materia . '
                ');
                $array_porcentajes = array();
                $porcent = 0;

                for ($i = 1; $i <= $no_unidades[0]->unidades; $i++) {
                    $contar_alumnos = 0;
                    $aprobados = 0;

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

                    $dat_porcentajes['id_unidad'] = $i;
                    $dat_porcentajes['contar'] = $contar_alumnos;
                    if ($contar_alumnos > 0 and $aprobados > 0) {
                        $porcentaje = ($aprobados * 100) / $contar_alumnos;

                    } else {
                        $porcentaje = 0;
                    }
                    $porcent += $porcentaje;
                    $dat_porcentajes['porcentaje'] = $porcentaje;
                    array_push($array_porcentajes, $dat_porcentajes);
                }

                $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');
                $sheet->loadView('servicios_escolares.excel_acta',compact('id_docente','id_grupo','id_materia','grupo','nom_docente','nom_carrera','nom_materia','clave_m','unidades','imp_porcentaje'))->with(['alumnos'=>$array_alumnos,'porcentajes'=>$array_porcentajes]);




                /*  $obj6 = new PHPExcel_Worksheet_Drawing;
                  $obj6->setPath(public_path('img/barra-gris.png')); //your image path
                  $obj6->setWidth(700);
                  $obj6->setCoordinates('C65');
                  $obj6->setWorksheet($sheet);
 */
            });

        })->export('xls');

        return back();
    }
    public function acta_constituitiva_sumativa($id_docente,$id_materia,$id_grupo){
        Session::put('id_docente1',$id_docente);
        Session::put('id_materia1',$id_materia);
        Session::put('id_grupo1',$id_grupo);
        $mat=DB::selectOne('SELECT * FROM `gnral_materias` WHERE `id_materia` = '.$id_materia.'');
        $mat=$mat->nombre;
        Excel::create('Acta-'.$mat, function($excel)
        {
            $excel->sheet('Acta', function($sheet)
            {
                $id_docente=Session::get('id_docente1');
                $id_materia=Session::get('id_materia1');
                $id_grupo=Session::get('id_grupo1');
                $periodo = Session::get('periodo_actual');
                $mat = DB::selectOne('SELECT  *FROM gnral_materias WHERE id_materia = '.$id_materia.'');

                $grupo = $mat->id_semestre.'0'.$id_grupo ;
                $nom_docente = DB::table('gnral_personales')->select('nombre')->where('id_personal', '=', $id_docente)->first();
                $nom_docente = $nom_docente->{'nombre'};
                $carrera= DB::selectOne('SELECT gnral_carreras.nombre from gnral_carreras,gnral_reticulas,gnral_materias WHERE gnral_carreras.id_carrera=gnral_reticulas.id_carrera and gnral_reticulas.id_reticula=gnral_materias.id_reticula and gnral_materias.id_materia= '.$id_materia.'');
                $nom_carrera=$carrera->nombre;
                //accion 1 = periodos
                //accion 2 = calificaciones

                $esc_alumno=false;

                $alumnos=DB::select('select gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre, gnral_alumnos.apaterno,gnral_alumnos.amaterno,eva_carga_academica.id_carga_academica, gnral_materias.clave,gnral_materias.nombre materia,gnral_materias.unidades,eva_tipo_curso.nombre_curso,eva_validacion_de_cargas.estado_validacion
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
//dd($alumnos);
                $array_alumnos=array();
                $num_alumnos=0;
                $num_duales=0;
                $numer_al=0;
                $promed=0;
                foreach ($alumnos as $alumno)
                {
                    if($alumno->estado_validacion != 10)
                    {
                        $numer_al++;
                    }
                    if($alumno->estado_validacion ==9)
                    {
                        $num_duales++;
                    }
                    if($alumno->estado_validacion ==10)
                    {
                        $dat_alumnos["baja"]=1;
                    }
                    else{
                        $dat_alumnos["baja"]=0;
                    }
                    $sumativas = false;
                    $esc_alumno=false;
                    $num_alumnos++;
                    $nom_materia=$alumno->materia;
                    $clave_m=$alumno->clave;
                    $unidades=$alumno->unidades;
                    $dat_alumnos['np']=$num_alumnos;
                    $dat_alumnos['id_alumno']=$alumno->id_alumno;
                    $dat_alumnos['id_carga_academica']=$alumno->id_carga_academica;
                    $dat_alumnos['cuenta']=$alumno->cuenta;
                    $dat_alumnos['estado_validacion']=$alumno->estado_validacion;
                    $dat_alumnos['nombre']=mb_strtoupper($alumno->apaterno,'utf-8')." ".mb_strtoupper($alumno->amaterno,'utf-8')." ".mb_strtoupper($alumno->nombre,'utf-8');
                    $array_calificaciones=array();
                    $calificaciones=DB::select('SELECT * FROM cal_evaluaciones_sumativa
                      WHERE id_carga_academica='.$alumno->id_carga_academica.'
                      ORDER BY cal_evaluaciones_sumativa.id_unidad');
                    $suma_unidades=0;
                    $calificaciones!= null ? $numero_unidades=0 : $numero_unidades=1;
                    $cont_unievaluadas=0;
                    foreach ($calificaciones as $calificacion)
                    {
                        $bitacora_modificacion=DB::select('SELECT id_carga_academica FROM cal_bitacora_evaluaciones
                      WHERE id_evaluacion='.$calificacion->id_evaluacion.'
                      GROUP BY cal_bitacora_evaluaciones.id_carga_academica');
                        $dat_calificaciones['id_evaluacion']=$calificacion->id_evaluacion;
                        $dat_calificaciones['calificacion']=$calificacion->calificacion;
                        $dat_calificaciones['modificado']=$bitacora_modificacion != null ? '1' : '2';
                        $dat_calificaciones['id_unidad']=$calificacion->id_unidad;
                        $suma_unidades+=$calificacion->calificacion>=70 ? $calificacion->calificacion : 0;
                        if ($calificacion->calificacion<70)
                        {
                            $esc_alumno=true;
                        }
                        if ($calificacion->esc==1)
                        {
                            $esc_alumno=true;
                            $esc_pormateria=true;
                        }
                        if ($calificacion->calificacion < 70) {
                            $sumativas = true;

                        }


                        $numero_unidades++;
                        $cont_unievaluadas++;
                        array_push($array_calificaciones,$dat_calificaciones);
                    }
                    if($alumno->estado_validacion ==10) {
                        $esc_alumno=true;
                    }
                    $dat_alumnos['sumativa'] = $sumativas;
                    $dat_alumnos['esc_alumno']=$esc_alumno;
                    $dat_alumnos["especial_bloq"]= $esc_alumno==1 && $alumno->nombre_curso=="ESPECIAL" ? 1: 0;
                    if($alumno->estado_validacion ==10) {
                        $dat_alumnos['promedio']=0;

                    }
                    else{
                        $prome=intval(round($suma_unidades/$numero_unidades)+0);
                        if($prome >=70){
                            $promed++;
                        }
                        $dat_alumnos['promedio']=intval(round($suma_unidades/$numero_unidades)+0);

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
                //dd($array_alumnos);
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

                $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');
                $sheet->loadView('servicios_escolares.excel_acta',compact('id_docente','id_grupo','id_materia','grupo','nom_docente','nom_carrera','nom_materia','clave_m','unidades','imp_porcentaje'))->with(['alumnos'=>$array_alumnos,'porcentajes'=>$array_porcentajes]);




                /*  $obj6 = new PHPExcel_Worksheet_Drawing;
                  $obj6->setPath(public_path('img/barra-gris.png')); //your image path
                  $obj6->setWidth(700);
                  $obj6->setCoordinates('C65');
                  $obj6->setWorksheet($sheet);
 */
            });

        })->export('xls');

        return back();
    }
    public function acta_sumativa($id_docente,$id_materia,$id_grupo){
        Session::put('id_docente1',$id_docente);
        Session::put('id_materia1',$id_materia);
        Session::put('id_grupo1',$id_grupo);
        $mat=DB::selectOne('SELECT * FROM `gnral_materias` WHERE `id_materia` = '.$id_materia.'');
        $mat=$mat->nombre;
        Excel::create('Acta-'.$mat, function($excel)
        {
            $excel->sheet('Acta', function($sheet)
            {
                $id_docente=Session::get('id_docente1');
                $id_materia=Session::get('id_materia1');
                $id_grupo=Session::get('id_grupo1');
                $periodo = Session::get('periodo_actual');
                $mat = DB::selectOne('SELECT  *FROM gnral_materias WHERE id_materia = '.$id_materia.'');

                $grupo = $mat->id_semestre.'0'.$id_grupo ;
                $nom_docente = DB::table('gnral_personales')->select('nombre')->where('id_personal', '=', $id_docente)->first();
                $nom_docente = $nom_docente->{'nombre'};
                $carrera= DB::selectOne('SELECT gnral_carreras.nombre from gnral_carreras,gnral_reticulas,gnral_materias WHERE gnral_carreras.id_carrera=gnral_reticulas.id_carrera and gnral_reticulas.id_reticula=gnral_materias.id_reticula and gnral_materias.id_materia= '.$id_materia.'');
                $nom_carrera=$carrera->nombre;
                //accion 1 = periodos
                //accion 2 = calificaciones

                $esc_alumno=false;

                $alumnos=DB::select('select gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre, gnral_alumnos.apaterno,gnral_alumnos.amaterno,eva_carga_academica.id_carga_academica, gnral_materias.clave,gnral_materias.nombre materia,gnral_materias.unidades,eva_tipo_curso.nombre_curso,eva_validacion_de_cargas.estado_validacion
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
//dd($alumnos);
                $array_alumnos=array();
                $num_alumnos=0;
                $numer_al=0;
                $promed=0;
                foreach ($alumnos as $alumno)
                {
                    $sumativas = false;
                    $esc_alumno=false;
                    $num_alumnos++;
                    $nom_materia=$alumno->materia;
                    $clave_m=$alumno->clave;
                    $unidades=$alumno->unidades;
                    if($alumno->estado_validacion != 10)
                    {
                        $numer_al++;
                    }
                    if($alumno->estado_validacion ==10)
                    {
                        $dat_alumnos["baja"]=1;
                    }
                    else{
                        $dat_alumnos["baja"]=0;
                    }
                    $dat_alumnos['np']=$num_alumnos;
                    $dat_alumnos['id_alumno']=$alumno->id_alumno;
                    $dat_alumnos['id_carga_academica']=$alumno->id_carga_academica;
                    $dat_alumnos['cuenta']=$alumno->cuenta;
                    $dat_alumnos['estado_validacion']=$alumno->estado_validacion;
                    $dat_alumnos['nombre']=mb_strtoupper($alumno->apaterno,'utf-8')." ".mb_strtoupper($alumno->amaterno,'utf-8')." ".mb_strtoupper($alumno->nombre,'utf-8');
                    $array_calificaciones=array();
                    $calificaciones=DB::select('SELECT * FROM cal_evaluaciones
                      WHERE id_carga_academica='.$alumno->id_carga_academica.'
                      ORDER BY cal_evaluaciones.id_unidad');
                    $suma_unidades=0;
                    $calificaciones!= null ? $numero_unidades=0 : $numero_unidades=1;
                    $cont_unievaluadas=0;
                    foreach ($calificaciones as $calificacion)
                    {
                        $esc_cal=false;
                        $bitacora_modificacion=DB::select('SELECT id_carga_academica FROM cal_bitacora_evaluaciones
                      WHERE id_evaluacion='.$calificacion->id_evaluacion.'
                      GROUP BY cal_bitacora_evaluaciones.id_carga_academica');
                        $dat_calificaciones['id_evaluacion']=$calificacion->id_evaluacion;
                        $dat_calificaciones['calificacion']=$calificacion->calificacion;
                        $dat_calificaciones['modificado']=$bitacora_modificacion != null ? '1' : '2';
                        $dat_calificaciones['id_unidad']=$calificacion->id_unidad;
                        $dat_calificaciones['esc']= $calificacion->esc;
                        if ($calificacion->esc==1)
                        {
                            $esc_alumno=true;
                            $esc_pormateria=true;
                        }
                        if ($calificacion->calificacion<70)
                        {
                            $esc_cal=true;
                            $esc_alumno=true;
                        }
                        if ($calificacion->calificacion < 70) {
                            $sumativas = true;

                        }

                        $dat_calificaciones['esc']= $esc_cal;
                        $suma_unidades+=$calificacion->calificacion>=70 ? $calificacion->calificacion : 0;
                        $numero_unidades++;
                        $cont_unievaluadas++;
                        array_push($array_calificaciones,$dat_calificaciones);
                    }
                    if($alumno->estado_validacion ==10) {
                        $esc_alumno=true;
                    }
                    $dat_alumnos['repeticion'] = $sumativas;
                    $dat_alumnos['esc_alumno']=$esc_alumno;
                    $dat_alumnos["especial_bloq"]= $esc_alumno==1 && $alumno->nombre_curso=="ESPECIAL" ? 1: 0;
                    if($alumno->estado_validacion ==10) {
                        $dat_alumnos['promedio']=0;

                    }
                    else{
                        $prome=intval(round($suma_unidades/$numero_unidades)+0);
                        if($prome >=70 and $sumativas == false){
                            $promed++;
                        }
                        $dat_alumnos['promedio']=intval(round($suma_unidades/$numero_unidades)+0);

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
                //dd($array_alumnos);
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

                $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');
                $sheet->loadView('servicios_escolares.excel_acta_sumativa',compact('id_docente','id_grupo','id_materia','grupo','nom_docente','nom_carrera','nom_materia','clave_m','unidades','imp_porcentaje'))->with(['alumnos'=>$array_alumnos,'porcentajes'=>$array_porcentajes]);




                /*  $obj6 = new PHPExcel_Worksheet_Drawing;
                  $obj6->setPath(public_path('img/barra-gris.png')); //your image path
                  $obj6->setWidth(700);
                  $obj6->setCoordinates('C65');
                  $obj6->setWorksheet($sheet);
 */
            });

        })->export('xls');

        return back();

    }
}
