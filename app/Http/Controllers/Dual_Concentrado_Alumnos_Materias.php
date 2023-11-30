<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Session;

class Dual_Concentrado_Alumnos_Materias extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_materia)
    {
        $id_periodo = Session::get('periodo_actual');
        $carreras = DB::table('gnral_carreras')
            ->where('id_carrera', '!=', 9)
            ->where('id_carrera', '!=', 11)
            ->where('id_carrera', '!=', 15)
            ->get();

        $id_periodo_carrera = DB::table('gnral_periodo_carreras')
            ->where('id_periodo', $id_periodo)
            ->whereIn('id_carrera', $carreras->pluck('id_carrera')->toArray())
            ->value('id_periodo_carrera');

        $alumnos = DB::select('SELECT gnral_alumnos.id_alumno,  gnral_alumnos.cuenta,  gnral_alumnos.nombre,  gnral_alumnos.apaterno,  gnral_alumnos.amaterno, MAX(cal_duales_actuales.id_duales_actuales) AS max_id_duales_actuales, MAX(IFNULL(eva_validacion_de_cargas.estado_validacion, 0)) AS max_estado_validacion
        FROM  gnral_alumnos
        JOIN cal_duales_actuales ON gnral_alumnos.id_alumno = cal_duales_actuales.id_alumno
        JOIN eva_carga_academica ON gnral_alumnos.id_alumno = eva_carga_academica.id_alumno
        JOIN gnral_materias ON eva_carga_academica.id_materia = gnral_materias.id_materia
        JOIN gnral_reticulas ON gnral_materias.id_reticula = gnral_reticulas.id_reticula
        LEFT JOIN eva_validacion_de_cargas ON eva_carga_academica.id_alumno = eva_validacion_de_cargas.id_alumno
        AND eva_validacion_de_cargas.id_periodo = eva_carga_academica.id_periodo 
        WHERE cal_duales_actuales.id_periodo = ' . $id_periodo . '  
        AND gnral_materias.id_semestre > 5  
        AND eva_carga_academica.id_status_materia = 1 
        AND eva_carga_academica.id_periodo = ' . $id_periodo . '
        AND eva_validacion_de_cargas.estado_validacion= 8
        AND eva_carga_academica.id_materia = ' . $id_materia . '
        GROUP BY gnral_alumnos.id_alumno, gnral_alumnos.cuenta, gnral_alumnos.nombre, gnral_alumnos.apaterno, gnral_alumnos.amaterno
        ORDER BY gnral_alumnos.apaterno, gnral_alumnos.amaterno, gnral_alumnos.nombre ASC');
        //dd($alumnos);

        $datos = DB::table('cal_duales_actuales')
            ->join('gnral_alumnos', 'gnral_alumnos.id_alumno', '=', 'cal_duales_actuales.id_alumno')
            ->join('gnral_personales', 'cal_duales_actuales.id_personal', '=', 'gnral_personales.id_personal')
            ->join('abreviaciones_prof', 'gnral_personales.id_personal', '=', 'abreviaciones_prof.id_personal')
            ->join('abreviaciones', 'abreviaciones_prof.id_abreviacion', '=', 'abreviaciones.id_abreviacion')
            ->select('gnral_personales.nombre as profesor', 'abreviaciones.titulo')
            ->distinct()
            ->where('cal_duales_actuales.id_periodo', $id_periodo)
            ->get();
        //dd($datos);

        $materia_seleccionada = DB::select('SELECT gnral_materias.id_materia,MAX(gnral_materias.nombre) AS materias,MAX(gnral_materias.unidades) AS unidades,MAX(gnral_materias.clave) AS clave,MAX(eva_tipo_curso.nombre_curso) AS nombre_curso,MAX(eva_carga_academica.id_carga_academica) AS id_carga_academica,MAX(eva_carga_academica.grupo) AS grupo,MAX(gnral_materias.id_semestre) AS id_semestre,MAX(gnral_materias.creditos) AS creditos,MAX(eva_status_materia.nombre_status) AS nombre_status
        FROM gnral_materias
        JOIN eva_carga_academica ON eva_carga_academica.id_materia = gnral_materias.id_materia
        JOIN eva_status_materia ON eva_carga_academica.id_status_materia = eva_status_materia.id_status_materia
        JOIN eva_tipo_curso ON eva_carga_academica.id_tipo_curso = eva_tipo_curso.id_tipo_curso
        JOIN gnral_grupos ON eva_carga_academica.grupo = gnral_grupos.id_grupo
        JOIN gnral_periodos ON eva_carga_academica.id_periodo = gnral_periodos.id_periodo
        JOIN gnral_alumnos ON eva_carga_academica.id_alumno = gnral_alumnos.id_alumno
        JOIN eva_validacion_de_cargas ON gnral_alumnos.id_alumno = eva_validacion_de_cargas.id_alumno
        WHERE gnral_periodos.id_periodo = ' . $id_periodo . '
        AND eva_carga_academica.id_materia = ' . $id_materia . '
        AND gnral_periodos.id_periodo = eva_validacion_de_cargas.id_periodo
        AND eva_validacion_de_cargas.estado_validacion = 8
        AND eva_status_materia.id_status_materia = 1
        GROUP BY gnral_materias.id_materia');
        //dd($materia_seleccionada);

        $array_materias=array();
        $mayor_unidades=0;
        $esc_alumno=false;
        foreach ($materia_seleccionada as $dat_alumno)
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
            $dat_materia["creditos"]=$dat_alumno->creditos;
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
                    //dd($promedio_general);
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
            $dat_materia['unidades_evaluadas'] = $unidades_evaluadas;
            $dat_materia['suma_unidades'] = $suma_unidades;

            //dd($dat_materia["calificaciones"]);
        }
        $numero=0;
        $materias_calificaciones=array();
        $estado_materias=0;
        $numero_alumno=0;
        $promedio_general=0;
        $numero_promedio_aprobado=0;
        $numero_promedio_reprobado=0;
        $porcentaje_final_aprobado=0;
        $porcentaje_final_reprobado=0;
        foreach ($alumnos as $alumno) {
            $numero++;
            $dat_l['numero'] = $numero;
            $dat_l['id_alumno'] = $alumno->id_alumno;
            $dat_l['cuenta'] = $alumno->cuenta;
            $dat_l['estado_validacion'] = $alumno->max_estado_validacion;
            $dat_l['nombre'] = mb_strtoupper($alumno->apaterno, 'utf-8') . " " . mb_strtoupper($alumno->amaterno, 'utf-8') . " " . mb_strtoupper($alumno->nombre, 'utf-8');
            $cal_al=array();
            $suma_promedio_final=0;
            $suma_materia=0;
            $estado_materia=0;
            foreach ($array_materias as $materiass) {
//dd($array_materias);
                $inscrito = DB::selectOne('SELECT * FROM `eva_carga_academica` 
                  WHERE `id_materia` = '.$materiass['id_materia'].' AND `id_status_materia` = 1 
                  AND `id_periodo` = '.$id_periodo. ' and id_alumno='.$alumno->id_alumno.'');
//dd($inscrito);
                if ($inscrito == null) {
                    $datos_alumnos['id_carga_academica'] = 0;
                    $datos_alumnos['id_materia'] = $materiass['id_materia'];
                    $datos_alumnos['materia'] = '';
                    $datos_alumnos['estado'] = 1;
                    $datos_alumnos['promedio'] = '';
                    $datos_alumnos['te'] = '';
                } else {
                    $suma_materia++;
                    $datos_alumnos['id_carga_academica'] = $inscrito->id_carga_academica;
                    $datos_alumnos['id_materia'] = $inscrito->id_materia;
                    $datos_alumnos['materia'] = $materiass['materia'];
                    $datos_alumnos['estado'] = 2;


                    $materia_promedio = DB::selectOne('SELECT SUM(calificacion) suma FROM `cal_evaluaciones` WHERE `id_carga_academica` =' . $inscrito->id_carga_academica . ' and calificacion >=70');
                    $materia_promedio = $materia_promedio->suma;

                    $contar_unidades_pasadas = DB::selectOne('SELECT count(calificacion) suma FROM `cal_evaluaciones` WHERE `id_carga_academica` = ' . $inscrito->id_carga_academica . ' and calificacion >=70');
                    $contar_unidades_pasadas = $contar_unidades_pasadas->suma;

                    $contar_unidades_sumativas = DB::selectOne('SELECT count(calificacion) num FROM `cal_evaluaciones` WHERE `id_carga_academica` = ' . $inscrito->id_carga_academica . ' and esc=1');
                    $contar_unidades_sumativas = $contar_unidades_sumativas->num;
                    if ($contar_unidades_pasadas == $materiass['unidades']) {
                        if ($materia_promedio == 0) {
                            $promedio = 0;
                        } else {
                            $promedio = round($materia_promedio / $materiass['unidades']);
                        }
                        if ($inscrito->id_tipo_curso == 1 and $contar_unidades_sumativas == 0) {
                            $te = 'O';
                            $valor=10;
                            $estado_materia+=$valor;
                        }
                        elseif($inscrito->id_tipo_curso == 1 and $contar_unidades_sumativas > 0) {
                            $te = 'ESC';
                            $valor=10;
                            $estado_materia+=$valor;
                        }

                        elseif ($inscrito->id_tipo_curso == 2 and $contar_unidades_sumativas == 0) {
                            $te = 'O2';
                            $valor=100;
                            $estado_materia+=$valor;
                        }
                        elseif ($inscrito->id_tipo_curso == 2 and $contar_unidades_sumativas > 0) {
                            $te = 'ESC2';
                            $valor=100;
                            $estado_materia+=$valor;
                        }
                        if ($inscrito->id_tipo_curso == 3 and $contar_unidades_sumativas == 0) {
                            $te = 'CE';
                            $valor=1000;
                            $estado_materia+=$valor;
                        }
                        if ($inscrito->id_tipo_curso == 3 and $contar_unidades_sumativas > 0) {
                            $te = 'EG';
                            $valor=1000;
                            $estado_materia+=$valor;
                        }
                        if ($inscrito->id_tipo_curso == 4) {
                            $te = 'EG';
                            $valor=10000;
                            $estado_materia+=$valor;
                        }
                    } else {

                        if ($materia_promedio == 0) {
                            $promedio = 0;
                        } else {
                            $promedio = 0;
                        }
                        if ($inscrito->id_tipo_curso == 1) {
                            $te = 'ESC';
                            $valor=10;
                            $estado_materia+=$valor;
                        }
                        if ($inscrito->id_tipo_curso == 2) {
                            $te = 'ESC2';
                            $valor=100;
                            $estado_materia+=$valor;
                        }
                        if ($inscrito->id_tipo_curso == 3) {
                            $valor=1000;
                            $estado_materia+=$valor;
                            $te = 'EG';
                        }
                        if ($inscrito->id_tipo_curso == 4) {
                            $valor=10000;
                            $estado_materia+=$valor;
                            $te = 'EG';
                        }
                    }
                    $datos_alumnos['promedio'] = $promedio;
                    $datos_alumnos['te'] = $te;
                    $suma_promedio_final += $promedio;

                }

                array_push($cal_al, $datos_alumnos);
            }
            $estado_materias=$estado_materia;
            if($estado_materias <100){
                $estado_al=1;

            }
            elseif ($estado_materias <1000)
            {
                $estado_al=2;
            }
            elseif ($estado_materias <10000)
            {
                $estado_al=3;
            }
            elseif ($estado_materias <100000)
            {
                $estado_al=4;
            }
            if($suma_promedio_final ==0 )
            {
                $promedio_f=0;
            }
            else{
                $promedio_f=$suma_promedio_final/$suma_materia;
            }
            if($alumno->max_estado_validacion != 10)
            {
                $numero_alumno++;
                $promedio_general+=number_format($promedio_f, 2, '.', ' ');
                $pro_al=number_format($promedio_f, 2, '.', ' ');
                if($pro_al >= 70){
                    $numero_promedio_aprobado++;
                }
                else{
                    $numero_promedio_reprobado++;
                }

            }
            $dat_l['promedio_f']=number_format($promedio_f, 2, '.', ' ');
            $dat_l['l']=$cal_al;
            $dat_l['estado_alumno']=$estado_al;
            array_push($materias_calificaciones, $dat_l);

        }
        if($promedio_general == 0 || $numero_alumno == 0)
        {
            $promedio_general=0;

        }
        else{
            $promedio_general=$promedio_general/$numero_alumno;

        }

//dd($materias_calificaciones);
        $com=array();
        foreach ($array_materias as $mater) {
            $esta=false;

            $contar_alumnos=0;
            $contar_reprobados=0;
            $contar_aprobados=0;
            $suma_promedioss=0;
            $bajas=0;

            foreach ($materias_calificaciones as $cal) {

                foreach ($cal['l'] as $mate) {
                    if ($mater['id_materia'] == $mate['id_materia']) {
                        if ($mate['estado'] == 2 and $cal['estado_validacion'] != 10) {
                            $contar_alumnos++;
                            if ($mate['promedio'] < 70) {
                                $contar_reprobados++;
                            } else {
                                $contar_aprobados++;
                            }
                            $suma_promedioss += $mate['promedio'];
                            if ($mate['te'] == 'EG') {
                                $bajas++;
                            }
                        }
                        elseif($mate['estado'] == 2 and $cal['estado_validacion'] == 10){
                            $bajas++;
                        }
                        $esta = true;
                        break;
                    } // esta es la que se me olvidaba
                }
            }
            $compra['id_materia']=$mater['id_materia'];
            $compra['materia'] = $mater['materia'];
            $compra['creditos'] = $mater['creditos'];
            $compra['aprobados']=$contar_aprobados;
            $compra['reprobados']=$contar_reprobados;
            $compra['suma_promedios']=$suma_promedioss;
            $compra['bajas']=$bajas;
            $compra['total']=$contar_alumnos;
            array_push($com, $compra);
        }
        return view('duales.concentrado_calificaciones_duales.concentrado_alumnos_materias',
            compact('alumnos', 'materia_seleccionada', 'datos','array_materias','array_calificaciones',
                'com','numero_promedio_aprobado','numero_alumno','numero_promedio_reprobado','materias_calificaciones'));

    }
    
}
