<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PhpParser\Node\Stmt\While_;
use Session;

class In_inicioController extends Controller
{
    public function index()
    {

        return view('ingles.inicio_ingles.inicio_ingles');

    }

    public function inicio_calificaciones()
    {
        $id_profesor_ingles = Session::get('id_profesor_ingles');
        $periodo_ingles = Session::get('periodo_ingles');
        $cuenta_niveles = DB::table('in_hrs_ingles_profesor')
            ->join('in_niveles_ingles', 'in_niveles_ingles.id_niveles_ingles', '=', 'in_hrs_ingles_profesor.id_nivel')
            ->join('in_grupo_ingles', 'in_grupo_ingles.id_grupo_ingles', '=', 'in_hrs_ingles_profesor.id_grupo')
            ->where('in_hrs_ingles_profesor.id_profesor', '=', $id_profesor_ingles)
            ->where('in_hrs_ingles_profesor.id_periodo', '=', $periodo_ingles)
            ->select(DB::raw('count(in_hrs_ingles_profesor.id_profesor) as total'))
            ->get();
        $cuenta_niveles = $cuenta_niveles[0]->total;
        if ($cuenta_niveles == 0) {
            $cuenta_niveles = 0;

        } else {
            $cuenta_niveles = 1;
            $niveles = DB::table('in_hrs_ingles_profesor')
                ->join('in_niveles_ingles', 'in_niveles_ingles.id_niveles_ingles', '=', 'in_hrs_ingles_profesor.id_nivel')
                ->join('in_grupo_ingles', 'in_grupo_ingles.id_grupo_ingles', '=', 'in_hrs_ingles_profesor.id_grupo')
                ->where('in_hrs_ingles_profesor.id_profesor', '=', $id_profesor_ingles)
                ->where('in_hrs_ingles_profesor.id_periodo', '=', $periodo_ingles)
                ->select('in_niveles_ingles.descripcion as nivel', 'in_grupo_ingles.descripcion as grupo', 'in_hrs_ingles_profesor.*')
                ->orderBy('in_niveles_ingles.id_niveles_ingles', 'ASC')
                ->orderBy('in_grupo_ingles.id_grupo_ingles', 'ASC')
                ->get();
        }
        return view('ingles.profesores_ingles.inicio_calificaciones', compact('niveles', 'cuenta_niveles'));
    }

    public function mostrar_alumnos($id_nivel, $id_grupo)
    {
        $periodo_ingles = Session::get('periodo_ingles');
        $alumnos_inscritos = DB::table('in_validar_carga')
            ->join('gnral_alumnos', 'gnral_alumnos.id_alumno', '=', 'in_validar_carga.id_alumno')
            ->join('in_carga_academica_ingles', 'in_carga_academica_ingles.id_alumno', '=', 'in_validar_carga.id_alumno')
            ->join('in_niveles_ingles', 'in_niveles_ingles.id_niveles_ingles', '=', 'in_carga_academica_ingles.id_nivel')
            ->join('in_grupo_ingles', 'in_grupo_ingles.id_grupo_ingles', '=', 'in_carga_academica_ingles.id_grupo')
            ->join('eva_tipo_curso', 'eva_tipo_curso.id_tipo_curso', '=', 'in_carga_academica_ingles.estado_nivel')
            ->where('in_carga_academica_ingles.id_grupo', '=', $id_grupo)
            ->where('in_carga_academica_ingles.id_nivel', '=', $id_nivel)
            ->where('in_carga_academica_ingles.id_periodo_ingles', '=', $periodo_ingles)
            ->where('in_validar_carga.id_periodo', '=', $periodo_ingles)
            ->where('in_validar_carga.id_estado', '=', 2)
            ->select(DB::raw('count(in_validar_carga.id_validar_carga) as total'))
            ->get();
        $alumnos_inscritos = $alumnos_inscritos[0]->total;
        $nivel = DB::table('in_niveles_ingles')
            ->where('in_niveles_ingles.id_niveles_ingles', '=', $id_nivel)
            ->select('in_niveles_ingles.*')
            ->get();
        $nivel=$nivel[0]->descripcion;
        if ($alumnos_inscritos == 0) {
            $alumnos_inscritos = 0;
            return view
            ('ingles.profesores_ingles.asignacion_calificaciones', compact
            ( 'alumnos_inscritos', 'id_grupo', 'id_nivel','nivel'));

        }
        else {


            $alumnos = DB::table('in_validar_carga')
                ->join('gnral_alumnos', 'gnral_alumnos.id_alumno', '=', 'in_validar_carga.id_alumno')
                ->join('gnral_carreras', 'gnral_carreras.id_carrera', '=', 'gnral_alumnos.id_carrera')
                ->join('in_carga_academica_ingles', 'in_carga_academica_ingles.id_alumno', '=', 'in_validar_carga.id_alumno')
                ->join('in_niveles_ingles', 'in_niveles_ingles.id_niveles_ingles', '=', 'in_carga_academica_ingles.id_nivel')
                ->join('in_grupo_ingles', 'in_grupo_ingles.id_grupo_ingles', '=', 'in_carga_academica_ingles.id_grupo')
                ->join('eva_tipo_curso', 'eva_tipo_curso.id_tipo_curso', '=', 'in_carga_academica_ingles.estado_nivel')
                ->where('in_carga_academica_ingles.id_grupo', '=', $id_grupo)
                ->where('in_carga_academica_ingles.id_nivel', '=', $id_nivel)
                ->where('in_carga_academica_ingles.id_periodo_ingles', '=', $periodo_ingles)
                ->where('in_validar_carga.id_periodo', '=', $periodo_ingles)
                ->where('in_validar_carga.id_estado', '=', 2)
                ->select('gnral_carreras.nombre as carrera', 'gnral_alumnos.id_alumno', 'gnral_alumnos.cuenta', 'gnral_alumnos.nombre',
                    'gnral_alumnos.apaterno', 'gnral_alumnos.amaterno', 'in_validar_carga.*', 'in_carga_academica_ingles.*',
                    'in_niveles_ingles.descripcion as nivel_ingles', 'in_grupo_ingles.descripcion as grupo_ingles')
                ->orderBy('gnral_alumnos.apaterno', 'ASC')
                ->orderBy('gnral_alumnos.amaterno', 'ASC')
                ->orderBy('gnral_alumnos.nombre', 'ASC')
                ->get();
            $unidad_maxima = DB::selectOne('select max(in_cal_periodo.id_unidad) unidad 
from in_cal_periodo where
 in_cal_periodo.id_nivel=' . $id_nivel . ' and 
 in_cal_periodo.id_grupo=' . $id_grupo . ' and 
 in_cal_periodo.id_periodo=' . $periodo_ingles . ' and
 in_cal_periodo.evaluada=1');
            $unidad_maxima = $unidad_maxima->unidad;

            $array_calificaciones = array();
            $reprobacion1 = 0;
            $reprobacion2 = 0;
            $reprobacion3 = 0;
            $reprobacion4 = 0;
            $reprobacion5 = 0;
            foreach ($alumnos as $alumno) {
                $promedio_general = 0;
                $dat_alumnos['id_alumno'] = $alumno->id_alumno;
                $dat_alumnos['cuenta'] = $alumno->cuenta;
                $dat_alumnos['id_carga'] = $alumno->id_carga_ingles;
                $dat_alumnos['estado_nivel'] = $alumno->estado_nivel;
                $dat_alumnos['nombre'] = mb_strtoupper($alumno->apaterno, 'utf-8') . " " . mb_strtoupper($alumno->amaterno, 'utf-8') . " " . mb_strtoupper($alumno->nombre, 'utf-8');
                $dat_alumnos['carrera'] = $alumno->carrera;
                $unidad1 = DB::selectOne('select *from in_evaluar_calificacion where
 in_evaluar_calificacion.id_carga_ingles=' . $alumno->id_carga_ingles . ' 
 and in_evaluar_calificacion.id_unidad=1  ');


                if ($unidad1 == null) {
                    $dat_alumnos['unidad1'] = 0;
                    $cal1 = 0;
                } else {
                    $dat_alumnos['unidad1'] = $unidad1->calificacion;
                    $cal1 = $unidad1->calificacion;
                    if ($cal1 < 80) {
                        $reprobacion1++;
                    }

                }
                $unidad2 = DB::selectOne('select *from in_evaluar_calificacion where
 in_evaluar_calificacion.id_carga_ingles=' . $alumno->id_carga_ingles . ' 
 and in_evaluar_calificacion.id_unidad=2  ');


                if ($unidad2 == null) {
                    $dat_alumnos['unidad2'] = 0;
                    $cal2 = 0;
                } else {
                    $dat_alumnos['unidad2'] = $unidad2->calificacion;
                    $cal2 = $unidad2->calificacion;
                    if ($cal2 < 80) {
                        $reprobacion2++;
                    }
                }
                $unidad3 = DB::selectOne('select *from in_evaluar_calificacion where
 in_evaluar_calificacion.id_carga_ingles=' . $alumno->id_carga_ingles . ' 
 and in_evaluar_calificacion.id_unidad=3  ');


                if ($unidad3 == null) {
                    $dat_alumnos['unidad3'] = 0;
                    $cal3 = 0;
                } else {
                    $dat_alumnos['unidad3'] = $unidad3->calificacion;
                    $cal3 = $unidad3->calificacion;
                    if ($cal3 < 80) {
                        $reprobacion3++;
                    }
                }
                $unidad4 = DB::selectOne('select *from in_evaluar_calificacion where
 in_evaluar_calificacion.id_carga_ingles=' . $alumno->id_carga_ingles . ' 
 and in_evaluar_calificacion.id_unidad=4  ');


                if ($unidad4 == null) {
                    $dat_alumnos['unidad4'] = 0;
                    $cal4 = 0;
                } else {
                    $dat_alumnos['unidad4'] = $unidad4->calificacion;
                    $cal4 = $unidad4->calificacion;
                    if ($cal4 < 80) {
                        $reprobacion4++;
                    }
                }
                if ($unidad_maxima == null) {
                    $dat_alumnos['promedio'] = 0;
                } elseif ($unidad_maxima == 1) {
                    $dat_alumnos['promedio'] = $cal1;
                    $promedio_general = $cal1;
                    if ($promedio_general < 80) {
                        $reprobacion5++;
                    }
                } elseif ($unidad_maxima == 2) {
                    $promedio = $cal1 + $cal2;
                    if ($promedio == 0) {
                        $dat_alumnos['promedio'] = 0;
                    } else {
                        $dat_alumnos['promedio'] = round($promedio / 2);
                        $promedio_general = round($promedio / 2);
                        if ($promedio_general < 80) {
                            $reprobacion5++;
                        }
                    }

                } elseif ($unidad_maxima == 3) {
                    $promedio = $cal1 + $cal2 + $cal3;
                    if ($promedio == 0) {
                        $dat_alumnos['promedio'] = 0;
                    } else {
                        $dat_alumnos['promedio'] = round($promedio / 3);
                        $promedio_general = round($promedio / 3);
                        if ($promedio_general < 80) {
                            $reprobacion5++;
                        }
                    }
                } elseif ($unidad_maxima == 4) {
                    $promedio = $cal1 + $cal2 + $cal3 + $cal4;
                    if ($promedio == 0) {
                        $dat_alumnos['promedio'] = 0;
                    } else {
                        $dat_alumnos['promedio'] = round($promedio / 4);
                        $promedio_general = round($promedio / 4);
                        if ($promedio_general < 80) {
                            $reprobacion5++;
                        }
                    }
                }

                array_push($array_calificaciones, $dat_alumnos);
            }


            if ($unidad_maxima == null) {
                $fecha_unidad1 = DB::selectOne('SELECT count(id_cal_periodo)contar_periodo 
FROM in_cal_periodo WHERE id_unidad=1 and id_nivel=' . $id_nivel . ' and id_grupo=' . $id_grupo . ' 
and id_periodo=' . $periodo_ingles . '');
                $fecha_unidad1 = $fecha_unidad1->contar_periodo;
                if ($fecha_unidad1 == 0) {
                    $calificar_unidad['unidad1'] = 9;

                } else {
                    $fecha = DB::selectOne('SELECT  fecha FROM in_cal_periodo 
WHERE id_unidad=1 and id_nivel=' . $id_nivel . ' and id_grupo=' . $id_grupo . ' 
and id_periodo=' . $periodo_ingles . '');

                    $fecha_actual = date("Y-m-d");
                    $fecha_termino = date("Y-m-d", strtotime($fecha->fecha . "+0 days"));
                    if ($fecha_termino < $fecha_actual) {

                        $calificar_unidad['unidad1'] = 5;

                    } else {
                        $calificar_unidad['unidad1'] = 1;
                    }

                }

            } elseif ($unidad_maxima == 1) {
                $fecha_unidad1 = DB::selectOne('SELECT count(id_cal_periodo)contar_periodo 
FROM in_cal_periodo WHERE id_unidad=2 and id_nivel=' . $id_nivel . ' and id_grupo=' . $id_grupo . ' 
and id_periodo=' . $periodo_ingles . '');
                $fecha_unidad1 = $fecha_unidad1->contar_periodo;
                if ($fecha_unidad1 == 0) {
                    $calificar_unidad['unidad1'] = 10;
                } else {
                    $fecha = DB::selectOne('SELECT  fecha FROM in_cal_periodo 
WHERE id_unidad=2 and id_nivel=' . $id_nivel . ' and id_grupo=' . $id_grupo . ' 
and id_periodo=' . $periodo_ingles . '');

                    $fecha_actual = date("Y-m-d");
                    $fecha_termino = date("Y-m-d", strtotime($fecha->fecha . "+0 days"));
                    if ($fecha_termino < $fecha_actual) {

                        $calificar_unidad['unidad1'] = 6;

                    } else {
                        $calificar_unidad['unidad1'] = 2;
                    }

                }

            } elseif ($unidad_maxima == 2) {
                $fecha_unidad1 = DB::selectOne('SELECT count(id_cal_periodo)contar_periodo 
FROM in_cal_periodo WHERE id_unidad=3 and id_nivel=' . $id_nivel . ' and id_grupo=' . $id_grupo . ' 
and id_periodo=' . $periodo_ingles . '');
                $fecha_unidad1 = $fecha_unidad1->contar_periodo;
                if ($fecha_unidad1 == 0) {
                    $calificar_unidad['unidad1'] = 11;
                } else {
                    $fecha = DB::selectOne('SELECT  fecha FROM in_cal_periodo 
WHERE id_unidad=3 and id_nivel=' . $id_nivel . ' and id_grupo=' . $id_grupo . ' 
and id_periodo=' . $periodo_ingles . '');

                    $fecha_actual = date("Y-m-d");
                    $fecha_termino = date("Y-m-d", strtotime($fecha->fecha . "+0 days"));
                    if ($fecha_termino < $fecha_actual) {

                        $calificar_unidad['unidad1'] = 7;


                    } else {
                        $calificar_unidad['unidad1'] = 3;

                    }

                }

            } elseif ($unidad_maxima == 3) {
                $fecha_unidad1 = DB::selectOne('SELECT count(id_cal_periodo)contar_periodo 
FROM in_cal_periodo WHERE id_unidad=4 and id_nivel=' . $id_nivel . ' and id_grupo=' . $id_grupo . ' 
and id_periodo=' . $periodo_ingles . '');
                $fecha_unidad1 = $fecha_unidad1->contar_periodo;
                if ($fecha_unidad1 == 0) {
                    $calificar_unidad['unidad1'] = 12;
                } else {
                    $fecha = DB::selectOne('SELECT  fecha FROM in_cal_periodo 
WHERE id_unidad=4 and id_nivel=' . $id_nivel . ' and id_grupo=' . $id_grupo . ' 
and id_periodo=' . $periodo_ingles . '');

                    $fecha_actual = date("Y-m-d");
                    $fecha_termino = date("Y-m-d", strtotime($fecha->fecha . "+0 days"));
                    if ($fecha_termino < $fecha_actual) {

                        $calificar_unidad['unidad1'] = 8;


                    } else {
                        $calificar_unidad['unidad1'] = 4;
                    }

                }


            } else {
                $calificar_unidad['unidad1'] = 13;

            }

            if ($reprobacion1 == 0) {
                $porcentaje['unidad1'] = 100;
            } else {
                $reprobacion1 = $alumnos_inscritos - $reprobacion1;
                if ($reprobacion1 == 0) {
                    $porcentaje['unidad1'] = 0;
                } else {
                    $suma1 = ($reprobacion1 * 100) / $alumnos_inscritos;
                    $suma1 = round($suma1);
                    $porcentaje['unidad1'] = $suma1;
                }

            }
            if ($reprobacion2 == 0) {
                $porcentaje['unidad2'] = 100;
            } else {
                $reprobacion2 = $alumnos_inscritos - $reprobacion2;
                if ($reprobacion2 == 0) {
                    $porcentaje['unidad2'] = 0;
                } else {
                    $suma2 = ($reprobacion2 * 100) / $alumnos_inscritos;
                    $suma2 = round($suma2);
                    $porcentaje['unidad2'] = $suma2;
                }
            }
            if ($reprobacion3 == 0) {
                $porcentaje['unidad3'] = 100;
            } else {
                $reprobacion3 = $alumnos_inscritos - $reprobacion3;
                if ($reprobacion3 == 0) {
                    $porcentaje['unidad3'] = 0;
                } else {
                    $suma3 = ($reprobacion3 * 100) / $alumnos_inscritos;
                    $suma3 = round($suma3);
                    $porcentaje['unidad3'] = $suma3;
                }
            }
            if ($reprobacion4 == 0) {
                $porcentaje['unidad4'] = 100;
            } else {
                $reprobacion4 = $alumnos_inscritos - $reprobacion4;
                if ($reprobacion4 == 0) {
                    $porcentaje['unidad4'] = 0;
                } else {
                    $suma4 = ($reprobacion4 * 100) / $alumnos_inscritos;
                    $suma4 = round($suma4);
                    $porcentaje['unidad4'] = $suma4;
                }
            }
            //   dd($reprobacion5);
            if ($reprobacion5 == 0) {
                $porcentaje['promedio_general'] = 100;
            } else {
                $reprobacion5 = $alumnos_inscritos - $reprobacion5;
                if ($reprobacion5 == 0) {
                    $porcentaje['promedio_general'] = 0;
                } else {
                    $suma5 = ($reprobacion5 * 100) / $alumnos_inscritos;
                    $suma5 = round($suma5);
                    $porcentaje['promedio_general'] = $suma5;
                }
            }

//dd($porcentaje);
            return view
            ('ingles.profesores_ingles.asignacion_calificaciones', compact
            ('array_calificaciones', 'calificar_unidad', 'alumnos_inscritos', 'id_grupo', 'id_nivel', 'porcentaje', 'nivel'));
        }
    }
    public function periodos_ingles($id_nivel,$id_grupo){
        $periodo_ingles=Session::get('periodo_ingles');
        $cuenta_periodos = DB::table('in_cal_periodo')
            ->where('in_cal_periodo.id_periodo', '=', $periodo_ingles)
            ->where('in_cal_periodo.id_nivel', '=', $id_nivel)
            ->where('in_cal_periodo.id_grupo', '=', $id_grupo)
            ->select(DB::raw('count(in_cal_periodo.id_cal_periodo) as total'))
            ->get();
        $cuenta_periodos=$cuenta_periodos[0]->total;
        if($cuenta_periodos == 0){
            $cuenta_periodos=0;
            $periodo1=0;
            $periodo2=0;

        }elseif($cuenta_periodos == 1)
        {
            $cuenta_periodos=1;
            $periodo1 = DB::table('in_cal_periodo')
                ->where('in_cal_periodo.id_periodo', '=', $periodo_ingles)
                ->where('in_cal_periodo.id_nivel', '=', $id_nivel)
                ->where('in_cal_periodo.id_grupo', '=', $id_grupo)
                ->where('in_cal_periodo.id_unidad', '=', 1)
                ->select('in_cal_periodo.*')
                ->get();
            $periodo2=0;
        }
        else{
            $periodo1 = DB::table('in_cal_periodo')
                ->where('in_cal_periodo.id_periodo', '=', $periodo_ingles)
                ->where('in_cal_periodo.id_nivel', '=', $id_nivel)
                ->where('in_cal_periodo.id_grupo', '=', $id_grupo)
                ->where('in_cal_periodo.id_unidad', '=', 1)
                ->select('in_cal_periodo.*')
                ->get();
            $periodo2 = DB::table('in_cal_periodo')
                ->where('in_cal_periodo.id_periodo', '=', $periodo_ingles)
                ->where('in_cal_periodo.id_nivel', '=', $id_nivel)
                ->where('in_cal_periodo.id_grupo', '=', $id_grupo)
                ->where('in_cal_periodo.id_unidad', '=', 4)
                ->select('in_cal_periodo.*')
                ->get();
        }
        $nivel = DB::table('in_niveles_ingles')
            ->where('in_niveles_ingles.id_niveles_ingles', '=', $id_nivel)
            ->select('in_niveles_ingles.*')
            ->get();
        $nivel=$nivel[0]->descripcion;
        return view('ingles.profesores_ingles.periodos_calificaciones',compact('cuenta_periodos','id_grupo','id_nivel','periodo1','periodo2','nivel'));


}
public function registro_periodo_ingles($id_unidad,$id_nivel,$id_grupo){
    return view('ingles.profesores_ingles.crear_periodo_calificacion',compact('id_unidad','id_nivel','id_grupo'));

    }
public function crear_periodo_cal_ingles(Request $request){
    $periodo_ingles=Session::get('periodo_ingles');
    $this->validate($request, [
        'fecha_periodo' => 'required',
        'id_nivel' => 'required',
        'id_unidad' => 'required',
        'id_grupo' => 'required',
    ]);


    $fecha_periodo = $request->input('fecha_periodo');
    $fecha_periodo = str_replace('/', '-', $fecha_periodo);
    $fecha_periodo = date("Y-m-d", strtotime($fecha_periodo));
    $id_nivel = $request->input('id_nivel');
    $id_unidad = $request->input('id_unidad');
    $id_grupo = $request->input('id_grupo');
    if($id_unidad ==2){
        DB:: table('in_cal_periodo')->insert(['fecha' => $fecha_periodo, 'id_unidad' => 2, 'id_periodo' => $periodo_ingles, 'id_nivel' => $id_nivel, 'id_grupo' => $id_grupo]);
        DB:: table('in_cal_periodo')->insert(['fecha' => $fecha_periodo, 'id_unidad' => 3, 'id_periodo' => $periodo_ingles, 'id_nivel' => $id_nivel, 'id_grupo' => $id_grupo]);
        DB:: table('in_cal_periodo')->insert(['fecha' => $fecha_periodo, 'id_unidad' => 4, 'id_periodo' => $periodo_ingles, 'id_nivel' => $id_nivel, 'id_grupo' => $id_grupo]);

    }
    else {
        DB:: table('in_cal_periodo')->insert(['fecha' => $fecha_periodo, 'id_unidad' => $id_unidad, 'id_periodo' => $periodo_ingles, 'id_nivel' => $id_nivel, 'id_grupo' => $id_grupo]);
    }
    return back();
}
public function agregar_calificacion ($id_nivel,$id_grupo,$id_unidad)
{
    $cal = json_decode($_POST['calificaciones']);
    $all_cal = $cal->alumno;
    foreach ($all_cal as $alumno) {
        $inserta_calificacion = DB:: table('in_evaluar_calificacion')->insert(['id_unidad'=>$alumno->id_unidad,'id_carga_ingles'=>$alumno->id_carga_academica,'calificacion'=>$alumno->calificacion]);


    }
    $periodo_ingles=Session::get('periodo_ingles');
    DB::table('in_cal_periodo')
        ->where('id_unidad',$id_unidad)
        ->where('id_periodo',$periodo_ingles)
        ->where('id_nivel',$id_nivel)
        ->where('id_grupo',$id_grupo)
        ->update(['evaluada' =>1]);

    return back();
}
}
