<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\calPeriodos;
use Session;
use App\calperiodosSumativas;

class jcarreraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function docentes($id_carrera)
    {
        $periodo=Session::get('periodo_actual');
				$periodo_sumativas=calperiodosSumativas::where("id_periodo" ,"=", $periodo)->get()->toArray();
				if ($periodo_sumativas==null)
				{
						$periodo_sumativas=0;
				}
				else
				{
						$f_inicio=$periodo_sumativas[0]["fecha_inicio"];
						$f_fin=$periodo_sumativas[0]["fecha_fin"];
						$f_actual= date("Y")."-".date("m")."-".date("d");
						if ($f_inicio<=$f_actual && $f_actual<=$f_fin)
						{
								$periodo_sumativas=1;
						}
						else
						{
								$periodo_sumativas=0;
						}
				}
        $carreras=DB::select('select Distinct(gnral_carreras.nombre) carrera,gnral_carreras.id_carrera,gnral_carreras.color
                      from gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres
                      where gnral_periodos.id_periodo='.$periodo.'
                      and gnral_carreras.id_carrera='.$id_carrera.'
                      and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                      and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                      and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                      and gnral_materias_perfiles.id_materia=gnral_materias.id_materia
                      and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor
                      and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil
                      and gnral_horarios.id_personal=gnral_personales.id_personal
                      and gnral_materias.id_semestre=gnral_semestres.id_semestre');
        $datos=array();
        foreach ($carreras as $carrera)
        {
            $dat_carreras['nombre_carrera']=$carrera->carrera;
            $dat_carreras['id_carrera']=$carrera->id_carrera;
            $dat_carreras['color']=$carrera->color;
            $docentes=DB::select('select DISTINCT(gnral_personales.nombre),gnral_personales.id_personal
                                from gnral_personales, gnral_horarios,gnral_horas_profesores,gnral_periodos,gnral_periodo_carreras,gnral_carreras
                                where gnral_periodos.id_periodo='.$periodo.'
                                and gnral_carreras.id_carrera='.$carrera->id_carrera.'
                                and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                                and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                                and gnral_horarios.id_personal=gnral_personales.id_personal
                                and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera and
                                gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor ORDER BY gnral_carreras.id_carrera');
            $array_docentes=array();
            foreach ($docentes as $docente)
            {
                $dat_docente['id_personal']=$docente->id_personal;
                $dat_docente['nombre']=$docente->nombre;
                $materias=DB::select('select  DISTINCT(gnral_horas_profesores.id_hrs_profesor),gnral_materias.id_materia,gnral_materias.nombre mat, gnral_semestres.id_semestre idsem,gnral_carreras.nombre,gnral_carreras.id_carrera,gnral_semestres.descripcion semestre,
                CONCAT(gnral_semestres.id_semestre,"0",gnral_horas_profesores.grupo) grupo, gnral_personales.nombre nombrepro
                from gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres
                where gnral_periodos.id_periodo='.$periodo.'
                and gnral_carreras.id_carrera='.$carrera->id_carrera.'
                and gnral_horarios.id_personal='.$docente->id_personal.'
                and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                and gnral_materias_perfiles.id_materia=gnral_materias.id_materia
                and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor
                and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil
                and gnral_horarios.id_personal=gnral_personales.id_personal
               /* and gnral_materias.id_materia=eva_carga_academica.id_materia */
                and gnral_materias.id_semestre=gnral_semestres.id_semestre GROUP BY gnral_materias.id_materia');
                $array_materias=array();
                $cont=0;
                foreach ($materias as $materia)
                {
                    $cont++;
                    $dat_materias['id_materia']=$materia->id_materia;
                    $dat_materias['nombre_materia']=$materia->mat;
                    $dat_materias['id_semestre']=$materia->idsem;
                    $dat_materias['nombre_semestre']=$materia->semestre;
                    $dat_materias['contador']=$cont;
                    $dat_materias['idcarrera']=$materia->id_carrera;
                    $grupos=DB::select('select gnral_horas_profesores.grupo id_grupo,CONCAT(gnral_semestres.id_semestre ,"0",gnral_horas_profesores.grupo) grupo, gnral_personales.nombre nombrepro
                        from gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_personales,gnral_semestres
                        where gnral_periodos.id_periodo='.$periodo.'
                        and gnral_materias.id_materia='.$materia->id_materia.'
                        and gnral_horarios.id_personal='.$docente->id_personal.'
                        and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo
                        and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                        and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                        and gnral_materias_perfiles.id_materia=gnral_materias.id_materia
                        and gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor
                        and gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil
                        and gnral_horarios.id_personal=gnral_personales.id_personal
                        and gnral_materias.id_semestre=gnral_semestres.id_semestre ORDER BY grupo');
                    $array_grupos=array();
                    foreach ($grupos as $grupo)
                    {
                        $dat_grupos['id_grupo']=$grupo->id_grupo;
                        $dat_grupos['grupos']=$grupo->grupo;
                        array_push($array_grupos,$dat_grupos);
                    }
                    $dat_materias['grupos']=$array_grupos;
                    array_push($array_materias,$dat_materias);
                }
                $dat_docente['materias']=$array_materias;
                array_push($array_docentes,$dat_docente);
            }
            $dat_carreras['docentes']=$array_docentes;
            array_push($datos, $dat_carreras);
        }
        return view("jefe_carrera.index",compact('periodo_sumativas'))->with(['carreras'=>$datos]);
    }
    public function reg_periodo($id_docente, $id_materia, $id_grupo){
        $periodo =Session::get('periodotrabaja');
        $tot_unidades = DB::selectOne('SELECT  *FROM gnral_materias WHERE id_materia = '.$id_materia.'');
        $uni_asignadas = DB::select('SELECT * FROM cal_periodos_califica WHERE id_periodos = '.$periodo.' AND id_materia = '.$id_materia.' AND id_grupo = '.$id_grupo.'');
        $carrera= DB::selectOne('SELECT gnral_carreras.nombre from gnral_carreras,gnral_reticulas,gnral_materias WHERE gnral_carreras.id_carrera=gnral_reticulas.id_carrera and gnral_reticulas.id_reticula=gnral_materias.id_reticula and gnral_materias.id_materia= '.$id_materia.'');
        $asignadas = DB::selectOne('select max(cal_periodos_califica.id_unidad)maxima  FROM cal_periodos_califica WHERE id_periodos = '.$periodo.' AND id_materia = '.$id_materia.' AND id_grupo = '.$id_grupo.'');


        $array_periodos = array();
        foreach ($uni_asignadas as $asignada) {
            $array_alumnos['id_unidad'] = $asignada->id_unidad;
            $array_alumnos['fecha'] = $asignada->fecha;
            $array_alumnos['id_materia'] = $asignada->id_materia;
            $array_alumnos['evaluada'] = $asignada->evaluada;
            $array_alumnos['status'] = 1;
            array_push($array_periodos, $array_alumnos);

        }
        $ultima_unidad = $asignadas->maxima + 1;
        $total = $tot_unidades->unidades + 1;
        // dd($array_periodos);
        $array_peri = array();
        for ($i = $ultima_unidad; $i < $total; $i++) {
            $calificar = $asignadas->maxima + 1;
            if ($i == $calificar) {
                $array_periodo['id_unidad'] = $i;
                $array_periodo['fecha'] = "";
                $array_periodo['id_materia'] = $id_materia;
                $array_periodo['evaluada'] = 2;
                $array_periodo['status'] = 2;

            } else {
                $array_periodo['id_unidad'] = $i;
                $array_periodo['fecha'] = "";
                $array_periodo['id_materia'] = $id_materia;
                $array_periodo['evaluada'] = 2;
                $array_periodo['status'] = 3;

            }
            array_push($array_peri, $array_periodo);
        }
        $array_perio = array_merge($array_periodos, $array_peri);
        $nom_carrera=$carrera->nombre;;
        $grupo=$tot_unidades->id_semestre.'0'.$id_grupo;
        return view('jefe_carrera.jefe_periodos',compact('id_docente','id_materia','id_grupo','grupo','nom_carrera','id_grupo','array_perio','tot_unidades'));


    }
    public function acciones($id_docente,$id_materia,$id_grupo)
    {
        $periodo =Session::get('periodotrabaja');

        $per=DB::selectOne('SELECT * FROM `gnral_periodos` WHERE `id_periodo` = '.$periodo.'');
        $fecha_fech= $per->fecha_inicio;


        $fecha_dia=date("Y-m-d",strtotime($fecha_fech."+ 20 days"));


        $fecha_hoy = date("Y-m-d");

        if($fecha_dia >= $fecha_hoy){
            $mostrar_mensaje=1;
        }else {
            $mostrar_mensaje = 2;
        }
      //  dd($mostrar_mensaje);

        $calificar_sumativa=DB::selectOne('SELECT count(id_calificar_sumativas) sumativa 
FROM `gnral_calificar_sumativas` 
WHERE `id_materia` = '.$id_materia.' AND `id_grupo` = '.$id_grupo.' AND `id_estado` = 1 AND `id_periodo` = '.$periodo.'');

        $mat = DB::selectOne('SELECT  *FROM gnral_materias WHERE id_materia = '.$id_materia.'');
        $grupo = $mat->id_semestre.'0'.$id_grupo ;
        $carrera= DB::selectOne('SELECT gnral_carreras.nombre from gnral_carreras,gnral_reticulas,gnral_materias WHERE gnral_carreras.id_carrera=gnral_reticulas.id_carrera and gnral_reticulas.id_reticula=gnral_materias.id_reticula and gnral_materias.id_materia= '.$id_materia.'');
        $nom_carrera=$carrera->nombre;
        $nom_docente = DB::table('gnral_personales')->select('nombre')->where('id_personal', '=', $id_docente)->first();
        $nom_docente = $nom_docente->{'nombre'};

            $cont_unievaluadas=0;
            $unidades=0;
            $esc_alumno=false;
            $esc_pormateria=0;
            $estado_reprobado=0;
            $alumno_rep=0;
        $uni_asignadas = DB::select('select cal_periodos_califica.id_periodo_cal,cal_periodos_califica.id_unidad,cal_periodos_califica.fecha,cal_periodos_califica.id_materia from cal_periodos_califica 
where id_materia='.$id_materia.' and id_grupo='.$id_grupo.' and id_periodos='.$periodo.'');


        if($calificar_sumativa->sumativa ==0)
        {
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
                $calificaciones=DB::select('SELECT * FROM cal_evaluaciones
                      WHERE id_carga_academica='.$alumno->id_carga_academica.'
                      ORDER BY cal_evaluaciones.id_unidad');
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
                $dat_alumnos['repeticion'] = $sumativas;
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
                        if($alumnoss['repeticion'] == true){
                            $alumno_rep++;
                        }
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




            if($cont_unievaluadas==$no_unidades[0]->unidades) {


                $calf_duales = DB::selectOne('SELECT COUNT(id_duales) total from gnral_calificar_duales where id_materia=' . $id_materia . ' and status=1 and id_periodo=' . $periodo . ' and id_grupo=' . $id_grupo . '');
                $calf_duales = $calf_duales->total;
                if ($num_duales == 0 ) {
                    $habilitaPDF=2;
                    if($alumno_rep == 0){
                        $estado_reprobado=1;
                    }
                } else {
                    if($calf_duales == 0){
                        $habilitaPDF=1;
                    }
                    else {
                        $habilitaPDF = 2;
                        if($alumno_rep == 0){
                            $estado_reprobado=1;
                        }
                    }
                }
            }
            else{
                $habilitaPDF=0;
            }

        }
        else{
            ///////////////cuando ya se califico sumativas
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
                $dat_alumnos['repeticion'] = $sumativas;
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


            if($cont_unievaluadas==$no_unidades[0]->unidades) {


                $calf_duales = DB::selectOne('SELECT COUNT(id_duales) total from gnral_calificar_duales where id_materia=' . $id_materia . ' and status=1 and id_periodo=' . $periodo . ' and id_grupo=' . $id_grupo . '');
                $calf_duales = $calf_duales->total;
                if ($num_duales == 0 ) {
                    $habilitaPDF=2;
                } else {
                    if($calf_duales == 0){
                        $habilitaPDF=1;
                    }
                    else {
                        $habilitaPDF = 2;
                    }
                }
            }
            else{
                $habilitaPDF=0;
            }
        }

      //dd($array_alumnos);

           // $habilitaPDF=$cont_unievaluadas==$no_unidades[0]->unidades ? "1" : "0";
            return view('jefe_carrera.jefe_evaluaciones',compact('mostrar_mensaje','imp_porcentaje',
                'esc_pormateria','habilitaPDF','id_grupo','grupo','id_docente','id_materia',
                'nom_docente','nom_carrera','mat','unidades','estado_reprobado'))->with(['alumnos'=>$array_alumnos,'porcentajes'=>$array_porcentajes,'uni_asignadas'=>$uni_asignadas]);

    }
    public function calificar_duales($id_carga_academica){

        $carga_academica=DB::selectOne('SELECT * FROM `eva_carga_academica` WHERE `id_carga_academica`='.$id_carga_academica.'');
        $id_materia=$carga_academica->id_materia;
        $materia=DB::selectOne('SELECT * FROM `gnral_materias` WHERE `id_materia` ='.$id_materia.'');
        $unidades=$materia->unidades;
        $array_cali=array();
       for($i=1; $i<=$unidades;$i++){
           $cal=DB::selectOne('SELECT * FROM `cal_evaluaciones` WHERE `id_unidad` = '.$i.' AND `id_carga_academica` = '.$id_carga_academica.'');
           $dat_cal['id_unidad']=$i;
           if($cal == null){
               $dat_cal['calificacion']=0;
           }
           else{
               $dat_cal['calificacion']=$cal->calificacion;
           }

           $dat_cal['id_carga_academica']=$id_carga_academica;
           array_push($array_cali,$dat_cal);
       }
      // dd($array_cali);
       return view('jefe_carrera.calificar_duales',compact('array_cali','id_carga_academica','unidades'));

    }
    public function registrar_cal_duales(Request $request){
       // dd($request);

        $unidades =$request->get('unidades');
        $id_carga_academica =$request->get('id_carga_academica');
       // dd($id_carga_academica);
        for($i=1; $i<=$unidades;$i++){
            $unidad =$request->get('unidad_'.$i);
            $cal=DB::selectOne('SELECT count(id_evaluacion) total FROM `cal_evaluaciones` WHERE `id_unidad` = '.$i.' AND `id_carga_academica` = '.$id_carga_academica.'');
            $cal=$cal->total;
            if($cal == 0){
                $insertar = DB:: table('cal_evaluaciones')
                    ->insert(['id_carga_academica'=>$id_carga_academica,
                        'id_unidad' => $i,
                        'calificacion' => $unidad
                    ]);
            }
            else{
                DB::table('cal_evaluaciones')
                    ->where('id_carga_academica', $id_carga_academica)
                    ->where( 'id_unidad', $i)
                    ->update(['calificacion' => $unidad]);
                DB::table('cal_evaluaciones_sumativa')
                    ->where('id_carga_academica', $id_carga_academica)
                    ->where( 'id_unidad', $i)
                    ->update(['calificacion' => $unidad]);

            }
        }
        return back();
    }
    public function termino_evaluacion(Request  $request,$id_materia,$id_grupo){
        $periodo =Session::get('periodotrabaja');
        //dd($id_materia);
        $insertar = DB:: table('gnral_calificar_duales')
            ->insert(['id_materia'=>$id_materia,
                'status' => 1,
                'id_periodo' => $periodo,
                'id_grupo' =>$id_grupo
            ]);
       return back();
    }
    public function evaluacionSumativa($id_docente,$id_materia,$id_semestre,$id_grupo,$nom_carrera)
    {


        $periodo = Session::get('periodo_actual');
        $grupo = $id_semestre . "0" . $id_grupo;
        $cont_unievaluadas=0;
        $unidades=0;
        $esc_pormateria=0;
        $esc_alumno=false;
        $nom_docente = DB::table('gnral_personales')->select('nombre')->where('id_personal', '=', $id_docente)->first();
        $nom_docente = $nom_docente->{'nombre'};
        $uni_asignadas = DB::select('select cal_periodos_califica.id_periodo_cal,cal_periodos_califica.id_unidad,cal_periodos_califica.fecha,cal_periodos_califica.id_materia from cal_periodos_califica 
where id_materia='.$id_materia.' and id_grupo='.$id_grupo.' and id_periodos='.$periodo.'');

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
        $calificar_sumativa=DB::selectOne('SELECT count(id_calificar_sumativas) sumativa 
FROM `gnral_calificar_sumativas` 
WHERE `id_materia` = '.$id_materia.' AND `id_grupo` = '.$id_grupo.' AND `id_estado` = 1 AND `id_periodo` = '.$periodo.'');
 if($calificar_sumativa->sumativa ==0){
     $calificada_sumativa=0;
 }else{
     $calificada_sumativa=1;
 }
        //  dd($array_alumnos);
        return view('jefe_carrera.jefe_sumativas',compact('imp_porcentaje','calificada_sumativa','nom_docente','esc_pormateria','habilitaPDF','id_grupo','grupo','id_docente','id_materia','nom_carrera','nom_materia','clave_m','unidades'))->with(['alumnos'=>$array_alumnos,'porcentajes'=>$array_porcentajes,'uni_asignadas'=>$uni_asignadas]);
    }
    public function destroy($id)
    {
        //
    }
}
