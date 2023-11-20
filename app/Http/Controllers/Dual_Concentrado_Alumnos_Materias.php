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
        AND gnral_alumnos.id_carrera IN (' . $carreras->pluck('id_carrera')->implode(',') . ')
        AND gnral_materias.id_semestre > 5  
        AND gnral_reticulas.id_carrera IN (' . $carreras->pluck('id_carrera')->implode(',') . ')
        AND eva_carga_academica.id_status_materia = 1 
        AND eva_carga_academica.id_periodo = ' . $id_periodo . '
        AND (eva_validacion_de_cargas.estado_validacion IN (2, 8, 10) OR eva_validacion_de_cargas.estado_validacion IS NULL)
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
            ->whereIn('gnral_alumnos.id_carrera', $carreras->pluck('id_carrera')->toArray())
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
        AND eva_carga_academica.id_materia NOT IN (773,845,853,1160,1263,1264,1265,1443,1496,1502,1565,1566,1567,1568,1569,1571)
        AND gnral_periodos.id_periodo = eva_validacion_de_cargas.id_periodo
        AND eva_validacion_de_cargas.id_alumno IN (SELECT cal_duales_actuales.id_alumno FROM cal_duales_actuales WHERE cal_duales_actuales.id_periodo = ' . $id_periodo . ')
        AND eva_status_materia.id_status_materia = 1
        GROUP BY gnral_materias.id_materia');

        $array_mat = [];
        foreach ($materia_seleccionada as $materia) {

            $datos_materias['id_materia'] = $materia->id_materia;
            $datos_materias['clave'] = $materia->clave;
            $datos_materias['nombre_materia'] = $materia->materias;
            $datos_materias['grupo'] = $materia->grupo;
            $datos_materias['creditos'] = $materia->creditos;
            $datos_materias['te'] = 'TE';
            $datos_materias['unidades'] = $materia->unidades;
            $materia_seleccionada++;
            $datos_materias['status'] = 1;
            array_push($array_mat, $datos_materias);
        }

        $numero = 0;
        $materias_calificaciones = [];
        $estado_materias = 0;
        $numero_alumno = 0;
        $promedio_general = 0;
        $numero_promedio_aprobado = 0;
        $numero_promedio_reprobado = 0;
        $porcentaje_final_aprobado = 0;
        $porcentaje_final_reprobado = 0;

        foreach ($alumnos as $alumno) {
            $numero++;
            $dat_l['numero'] = $numero;
            $dat_l['id_alumno'] = $alumno->id_alumno;
            $dat_l['cuenta'] = $alumno->cuenta;
            $dat_l['estado_validacion'] = $alumno->max_estado_validacion;
            $dat_l['nombre'] = mb_strtoupper($alumno->apaterno, 'utf-8') . " " . mb_strtoupper($alumno->amaterno, 'utf-8') . " " . mb_strtoupper($alumno->nombre, 'utf-8');
            $cal_al = [];
            $suma_promedio_final = 0;
            $suma_materia = 0;
            $estado_materia = 0;

            array_push($array_mat, $dat_l);
            //dd($dat_l);
        }
        foreach ($array_mat as $materiass) {
            // Verifica si el índice 'id_materia' está definido en el array
            if (isset($materiass['id_materia'])) {
                $inscrito = DB::select('SELECT DISTINCT eva_carga_academica.id_materia,cal_duales_actuales.id_alumno
                    FROM eva_carga_academica, cal_duales_actuales
                    WHERE eva_carga_academica.id_materia = ' . $materiass['id_materia'] . ' AND eva_carga_academica.id_status_materia = 1
                        AND cal_duales_actuales.id_alumno = ' . $alumno->id_alumno . '');
                //dd($inscrito);
                if ($inscrito && is_array($inscrito) && count($inscrito) > 0) {
                    // Resto del código aquí
                } else {
                    // Si la consulta no devuelve resultados
                    $datos_alumnos['id_carga_academica'] = 0;
                    $datos_alumnos['id_materia'] = $materiass['id_materia'];
                    $datos_alumnos['nombre_materia'] = '';
                    $datos_alumnos['estado'] = 1;
                }
                $materia_promedio = 0; // Inicializamos la variable en caso de que no haya resultados

                if ($inscrito && is_object($inscrito) && property_exists($inscrito, 'id_carga_academica')) {
                    // Si $inscrito es un objeto y tiene la propiedad 'id_carga_academica', obtenemos la suma de las calificaciones
                    $resultadoConsulta = DB::selectOne('SELECT SUM(calificacion) suma FROM `cal_evaluaciones` WHERE `id_carga_academica` =' . $inscrito->id_carga_academica . ' and calificacion >=70');

                    if ($resultadoConsulta && is_object($resultadoConsulta) && property_exists($resultadoConsulta, 'suma')) {
                        // Si la propiedad 'suma' existe en $resultadoConsulta, la asignamos a $materia_promedio
                        $materia_promedio = $resultadoConsulta->suma;
                    }
                }


                $contar_unidades_pasadas = 0;
                $contar_unidades_sumativas = 0;

                if ($inscrito && is_object($inscrito) && property_exists($inscrito, 'id_carga_academica')) {
                    // Si $inscrito es un objeto y tiene la propiedad 'id_carga_academica', obtenemos el conteo de unidades pasadas
                    $resultadoPasadas = DB::selectOne('SELECT COUNT(calificacion) as suma FROM `cal_evaluaciones` WHERE `id_carga_academica` =' . $inscrito->id_carga_academica . ' and calificacion >=70');

                    if ($resultadoPasadas && is_object($resultadoPasadas) && property_exists($resultadoPasadas, 'suma')) {
                        // Si la propiedad 'suma' existe en $resultadoPasadas, la asignamos a $contar_unidades_pasadas
                        $contar_unidades_pasadas = $resultadoPasadas->suma;
                    }

                    // Obtenemos el conteo de unidades sumativas
                    $resultadoSumativas = DB::selectOne('SELECT COUNT(calificacion) as num FROM `cal_evaluaciones` WHERE `id_carga_academica` =' . $inscrito->id_carga_academica . ' and esc=1');

                    if ($resultadoSumativas && is_object($resultadoSumativas) && property_exists($resultadoSumativas, 'num')) {
                        // Si la propiedad 'num' existe en $resultadoSumativas, la asignamos a $contar_unidades_sumativas
                        $contar_unidades_sumativas = $resultadoSumativas->num;
                    }
                }
                if ($contar_unidades_pasadas == $materiass['unidades']) {
                    if ($materia_promedio == 0) {
                        $promedio = 0;
                    } else {
                        $promedio = round($materia_promedio / $materiass['unidades']);
                    }
                    if ($inscrito->id_tipo_curso == 1 and $contar_unidades_sumativas == 0) {
                        $te = 'O';
                        $valor = 10;
                        $estado_materia += $valor;
                    } elseif ($inscrito->id_tipo_curso == 1 and $contar_unidades_sumativas > 0) {
                        $te = 'ESC';
                        $valor = 10;
                        $estado_materia += $valor;
                    } elseif ($inscrito->id_tipo_curso == 2 and $contar_unidades_sumativas == 0) {
                        $te = 'O2';
                        $valor = 100;
                        $estado_materia += $valor;
                    } elseif ($inscrito->id_tipo_curso == 2 and $contar_unidades_sumativas > 0) {
                        $te = 'ESC2';
                        $valor = 100;
                        $estado_materia += $valor;
                    }
                    if ($inscrito->id_tipo_curso == 3 and $contar_unidades_sumativas == 0) {
                        $te = 'CE';
                        $valor = 1000;
                        $estado_materia += $valor;
                    }
                    if ($inscrito->id_tipo_curso == 3 and $contar_unidades_sumativas > 0) {
                        $te = 'EG';
                        $valor = 1000;
                        $estado_materia += $valor;
                    }
                    if ($inscrito->id_tipo_curso == 4) {
                        $te = 'EG';
                        $valor = 10000;
                        $estado_materia += $valor;
                    }
                } else {

                    if ($materia_promedio == 0) {
                        $promedio = 0;
                    } else {
                        $promedio = 0;
                    }
                    $te = ''; // Inicializa la variable $te con un valor predeterminado
                    if ($inscrito && is_object($inscrito) && property_exists($inscrito, 'id_tipo_curso')) {
                        // Verificar si $inscrito es un objeto y tiene la propiedad 'id_tipo_curso'

                        if ($inscrito->id_tipo_curso == 1) {
                            $te = 'ESC';
                            $valor = 10;
                            $estado_materia += $valor;
                        }
                        if ($inscrito->id_tipo_curso == 2) {
                            $te = 'ESC2';
                            $valor = 100;
                            $estado_materia += $valor;
                        }
                        if ($inscrito->id_tipo_curso == 3) {
                            $valor = 1000;
                            $estado_materia += $valor;
                            $te = 'EG';
                        }
                        if ($inscrito->id_tipo_curso == 4) {
                            $valor = 10000;
                            $estado_materia += $valor;
                            $te = 'EG';
                        }
                    }

                }
                $datos_alumnos['promedio'] = $promedio;
                $datos_alumnos['te'] = $te;
                $suma_promedio_final += $promedio;

            }

            array_push($cal_al, $datos_alumnos);
        }
        $estado_materias = $estado_materia;
        if ($estado_materias < 100) {
            $estado_al = 1;

        } elseif ($estado_materias < 1000) {
            $estado_al = 2;
        } elseif ($estado_materias < 10000) {
            $estado_al = 3;
        } elseif ($estado_materias < 100000) {
            $estado_al = 4;
        }
        if ($suma_promedio_final == 0) {
            $promedio_f = 0;
        } else {
            $promedio_f = $suma_promedio_final / $suma_materia;
        }
        if ($alumno->max_estado_validacion != 10) {
            $numero_alumno++;
            $promedio_general += number_format($promedio_f, 2, '.', ' ');
            $pro_al = number_format($promedio_f, 2, '.', ' ');
            if ($pro_al >= 70) {
                $numero_promedio_aprobado++;
            } else {
                $numero_promedio_reprobado++;
            }

        }
        $dat_l['promedio_f'] = number_format($promedio_f, 2, '.', ' ');
        $dat_l['l'] = $cal_al;
        $dat_l['estado_alumno'] = $estado_al;
        array_push($materias_calificaciones, $dat_l);

        if ($promedio_general == 0 || $numero_alumno == 0) {
            $promedio_general = 0;

        } else {
            $promedio_general = $promedio_general / $numero_alumno;

        }

//dd($materias_calificaciones);
        $com = array();
        foreach ($array_mat as $mater) {
            $esta = false;

            $contar_alumnos = 0;
            $contar_reprobados = 0;
            $contar_aprobados = 0;
            $suma_promedioss = 0;
            $bajas = 0;

            foreach ($materias_calificaciones as $cal) {

                foreach ($cal['l'] as $mater) {
                    // Asegúrate de que la clave 'id_materia' esté definida en $mater
                    if (isset($mater['id_materia'])) {
                        // Verifica si hay una coincidencia con la condición deseada
                        if ($mater['id_materia'] == $mater['id_materia']) {
                            if ($mater['estado'] == 2 and $cal['estado_validacion'] != 10) {
                                $contar_alumnos++;
                                if ($mater['promedio'] < 70) {
                                    $contar_reprobados++;
                                } else {
                                    $contar_aprobados++;
                                }
                                $suma_promedioss += $mater['promedio'];
                                if ($mater['te'] == 'EG') {
                                    $bajas++;
                                }
                            } elseif ($mater['estado'] == 2 and $cal['estado_validacion'] == 10) {
                                $bajas++;
                            }
                            $esta = true;
                            break;
                        }
                    }
                }
                foreach ($cal['l'] as $mater) {
                    // Asegúrate de que 'id_materia' esté definida en $mater
                    if (isset($mater['id_materia'])) {
                        $compra['id_materia'] = $mater['id_materia'];
                        $compra['nombre_materia'] = $mater['nombre_materia'];
                        $compra['creditos'] = $mater['creditos'];
                        $compra['aprobados'] = $contar_aprobados;
                        $compra['reprobados'] = $contar_reprobados;
                        $compra['suma_promedios'] = $suma_promedioss;
                        $compra['bajas'] = $bajas;
                        $compra['total'] = $contar_alumnos;
                        array_push($com, $compra);
                    }
                }
            }
        }
        return view('duales.concentrado_calificaciones_duales.concentrado_alumnos_materias',
            compact('numero_promedio_reprobado', 'numero_promedio_aprobado', 'numero_alumno', 'promedio_general',
                'com', 'array_mat','materias_calificaciones', 'bajas', 'alumnos', 'materia_seleccionada', 'datos'));

    }
}
