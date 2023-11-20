<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PhpParser\Node\Stmt\While_;
use Session;
class PDF extends FPDF
{
    //CABECERA DE LA PAGINA
    function Header()
    {
        $this->SetFont('Arial','',8);
        $this->Ln(0);
        $this->Cell(110);
        $this->Cell(50,-12,utf8_decode('TecNM-SEV-DVIA-PCLE-12/17-TESVB-63'),0,0,'R');

        $this->Image('img/logos/ArmasBN.png',7,6,40);
        $this->Image('img/logos/Captura.PNG',55,5,30);
        $this->Image('img/residencia/logo_tec.PNG', 203, 6, 60);

        $this->Ln(4);

    }

    //PIE DE PAGINA
    function Footer()
    {
        $this->SetY(-20);
        $this->SetFont('Arial', '', 5.5);
        $this->Image('img/sgc.PNG', 40, 183, 20);

        $this->Image('img/sga.PNG', 65, 183, 20);
        // $this->Cell(100);
        //$this->Cell(167, -2, utf8_decode('FO-TESVB-39  V.0  23-03-2018'), 0, 0, 'R');
        $this->Ln(3);
        $this->Cell(100);
        $this->Cell(160, -2, utf8_decode('SECRETARÍA DE EDUCACIÓN'), 0, 0, 'R');
        $this->Ln(3);
        $this->Cell(100);
        $this->Cell(160, -2, utf8_decode('SUBSECRETARÍA DE EDUCACIÓN SUPERIOR Y NORMAL'), 0, 0, 'R');
        $this->Cell(300);
        $this->SetMargins(0, 0, 0);
        $this->Ln(1);
        $this->SetXY(30, 204);
        $this->SetFillColor(120, 120, 120);
        $this->Cell(20, 10, '', 0, 0, '', TRUE);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(297, 10, utf8_decode('KM. 30 DE LA CARRETERA FEDERAL MONUMENTO-VALLE DE BRAVO, EJIDO DE SAN ANTONIO DE LA LAGUNA'), 0, 0, 'L', TRUE);
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(160, 10, utf8_decode('VALLE DE BRAVO ESTADO DE MÉXICO C.P.51200     TEL: 01 726 2 62 20 97'), 0, 0, 'L');
        $this->Image('img/logos/Mesquina.jpg', 0, 190, 30);
    }

}

class In_acta_ordinariaController extends Controller
{
    public function index($id_nivel,$id_grupo){

        $periodo_ingles = Session::get('periodo_ingles');
        $id_profesor=DB::selectOne('SELECT * FROM `in_hrs_ingles_profesor` WHERE `id_grupo` = '.$id_grupo.'
        AND `id_nivel` = '.$id_nivel.' AND `id_periodo` = '.$periodo_ingles.' ORDER BY `id_grupo` ASC');
        $id_profesor=$id_profesor->id_profesor;
        $nombre_profesor=DB::selectOne('SELECT * FROM in_profesores_ingles WHERE id_profesores ='.$id_profesor.' ');
        $nombre_profesor=  mb_strtoupper($nombre_profesor->nombre, 'utf-8') . " " . mb_strtoupper($nombre_profesor->apellido_paterno, 'utf-8') . " " . mb_strtoupper($nombre_profesor->apellido_materno, 'utf-8');

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

        $nombre_nivel=$nivel[0]->descripcion;
        $clave_nivel=$nivel[0]->clave;
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
                ->select('gnral_carreras.id_carrera','gnral_carreras.siglas','gnral_carreras.nombre as carrera', 'gnral_alumnos.id_alumno', 'gnral_alumnos.cuenta', 'gnral_alumnos.nombre',
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
        $numero=0;
            foreach ($alumnos as $alumno) {
                $promedio_general = 0;
                $numero++;
                $dat_alumnos['numero'] = $numero;
                $dat_alumnos['id_alumno'] = $alumno->id_alumno;
                $dat_alumnos['cuenta'] = $alumno->cuenta;
                $dat_alumnos['id_carga'] = $alumno->id_carga_ingles;
                $dat_alumnos['estado_nivel'] = $alumno->estado_nivel;
                $dat_alumnos['nombre'] = mb_strtoupper($alumno->apaterno, 'utf-8') . " " . mb_strtoupper($alumno->amaterno, 'utf-8') . " " . mb_strtoupper($alumno->nombre, 'utf-8');
                $dat_alumnos['id_carrera'] = $alumno->id_carrera;
                $dat_alumnos['siglas'] = $alumno->siglas;
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
          //  dd($porcentaje);
        $fechas = date("Y-m-d");

        $num=date("j",strtotime($fechas));
        $ano=date("Y", strtotime($fechas));
        $mes= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes=$mes[(date('m', strtotime($fechas))*1)-1];
        $fech= $num. ' de '.$mes.' del '.$ano;
        $per_ingles=DB::selectOne('SELECT * FROM in_periodos WHERE id_periodo_ingles = '.$periodo_ingles.'');

        $pdf=new PDF($orientation='L',$unit='mm',$format='Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(10, 25 , 10);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();
        $pdf->Ln(1);
        $pdf->SetFillColor(166,166,166);
        $pdf->SetFont('Arial','B','8');
        $pdf->Cell(250,5, utf8_decode('ACTA DE CALIFICACIONES'), 0, 1, 'C',TRUE);
        $pdf->Cell(175,4, utf8_decode('NIVEL DE INGLES:'.$nombre_nivel), 0, 1, 'L');
        $pdf->Cell(175, 3, utf8_decode('CLAVE:'.$clave_nivel), 0, 1, 'L');
        $pdf->Cell(175,3, utf8_decode('PERIODO: '.$per_ingles->periodo_ingles), 0, 1, 'L');
        $pdf->Cell(175,3, utf8_decode('GRUPO:'.$id_grupo), 0, 1, 'L');
        $pdf->Cell(175,3, utf8_decode('FACILITADOR:'.$nombre_profesor), 0, 0, 'L');
        $pdf->Cell(75,3, utf8_decode($fech), 0, 1, 'R');
        $pdf->Ln(1);
        $pdf->SetFont('Arial','B','7');
        $pdf->Cell(10,3,utf8_decode(''),'LTR',0,'C',true);
        $pdf->Cell(25,3,utf8_decode(''),'LTR',0,'C',true);
        $pdf->Cell(100,3,utf8_decode(''),'LTR',0,'C',true);
        $pdf->Cell(40,3,utf8_decode(''),'LTR',0,'C',true);
        $pdf->Cell(75,3,utf8_decode('HABILIDADES'),'LTR',1,'C',true);
        $pdf->Cell(10,5,utf8_decode('NP'),'LBR',0,'C',true);
        $pdf->Cell(25,5,utf8_decode('No. CTA'),'LBR',0,'C',true);
        $pdf->Cell(100,5,utf8_decode('NOMBRE DEL USUARIO'),'LBR',0,'C',true);
        $pdf->Cell(40,5,utf8_decode('CARRERA'),'LBR',0,'C',true);
        $pdf->Cell(15,5,utf8_decode('SPEAKING'),1,0,'C',true);
        $pdf->Cell(15,5,utf8_decode('WRITING'),1,0,'C',true);
        $pdf->Cell(15,5,utf8_decode('READING'),1,0,'C',true);
        $pdf->Cell(15,5,utf8_decode('LISTENING'),1,0,'C',true);
        $pdf->Cell(15,5,utf8_decode('PROMEDIO'),1,1,'C',true);
//dd($array_calificaciones);
        foreach ($array_calificaciones as $calificaciones) {
            $pdf->SetFont('Arial', '', '8');

            $pdf->Cell(10, 5, utf8_decode($calificaciones['numero']), 1, 0, 'C');
            if($calificaciones['estado_nivel']==1)
            {
                $pdf->Cell(25, 5, utf8_decode($calificaciones['cuenta']), 1, 0, 'C');
            }
            elseif($calificaciones['estado_nivel']==2)
            {
                $pdf->SetFillColor(0,128,0);
                $pdf->Cell(25, 5, utf8_decode($calificaciones['cuenta']), 1, 0, 'C',true);
            }
            elseif($calificaciones['estado_nivel']==3){
                $pdf->SetFillColor(255,255,0);
                $pdf->Cell(25, 5, utf8_decode($calificaciones['cuenta']), 1, 0, 'C',true);
            }
            elseif($calificaciones['estado_nivel']==4){
                $pdf->SetFillColor(255,0,0);
                $pdf->Cell(25, 5, utf8_decode($calificaciones['cuenta']), 1, 0, 'C',true);
            }

            $pdf->Cell(100, 5, utf8_decode($calificaciones['nombre']), 1, 0, 'L');
            $pdf->Cell(40, 5, utf8_decode($calificaciones['siglas']), 1, 0, 'C');
            if($calificaciones['unidad1']<80)
            {
                $pdf->SetFillColor(255,0,0);
                $pdf->Cell(15, 5, utf8_decode($calificaciones['unidad1']), 1, 0, 'C',true);
            }
            else{

                $pdf->Cell(15, 5, utf8_decode($calificaciones['unidad1']), 1, 0, 'C');
            }
            if($calificaciones['unidad2']<80)
            {
                $pdf->SetFillColor(255,0,0);
                $pdf->Cell(15, 5, utf8_decode($calificaciones['unidad2']), 1, 0, 'C',true);
            }
            else{

                $pdf->Cell(15, 5, utf8_decode($calificaciones['unidad2']), 1, 0, 'C');
            }
            if($calificaciones['unidad3']<80)
            {
                $pdf->SetFillColor(255,0,0);
                $pdf->Cell(15, 5, utf8_decode($calificaciones['unidad3']), 1, 0, 'C',true);
            }
            else{

                $pdf->Cell(15, 5, utf8_decode($calificaciones['unidad3']), 1, 0, 'C');
            }
            if($calificaciones['unidad4']<80)
            {
                $pdf->SetFillColor(255,0,0);
                $pdf->Cell(15, 5, utf8_decode($calificaciones['unidad4']), 1, 0, 'C',true);
            }
            else{

                $pdf->Cell(15, 5, utf8_decode($calificaciones['unidad4']), 1, 0, 'C');
            }
            if($calificaciones['promedio']<80)
            {
                $pdf->SetFillColor(255,0,0);
                $pdf->Cell(15, 5, utf8_decode($calificaciones['promedio']), 1, 1, 'C',true);
            }
            else{

                $pdf->Cell(15, 5, utf8_decode($calificaciones['promedio']), 1, 1, 'C');
            }


        }
        $pdf->Cell(175);
        $pdf->SetFont('Arial','B','7');
        if($porcentaje['unidad1']==30) {
            $pdf->SetFillColor(255, 255, 0);
            $pdf->Cell(15, 5, utf8_decode($porcentaje['unidad1'].'%'), 1, 0, 'C',true);
        }
        elseif($porcentaje['unidad1']<30) {
            $pdf->SetFillColor(255, 0, 0);
            $pdf->Cell(15, 5, utf8_decode($porcentaje['unidad1'].'%'), 1, 0, 'C',true);
        }
        elseif($porcentaje['unidad1']>30) {
            $pdf->SetFillColor(0, 128, 0);
            $pdf->Cell(15, 5, utf8_decode($porcentaje['unidad1'].'%'), 1, 0, 'C',true);
        }
        if($porcentaje['unidad2']==30) {
            $pdf->SetFillColor(255, 255, 0);
            $pdf->Cell(15, 5, utf8_decode($porcentaje['unidad2'].'%'), 1, 0, 'C',true);
        }
        elseif($porcentaje['unidad2']<30) {
            $pdf->SetFillColor(255, 0, 0);
            $pdf->Cell(15, 5, utf8_decode($porcentaje['unidad2'].'%'), 1, 0, 'C',true);
        }
        elseif($porcentaje['unidad2']>30) {
            $pdf->SetFillColor(0, 128, 0);
            $pdf->Cell(15, 5, utf8_decode($porcentaje['unidad2'].'%'), 1, 0, 'C',true);
        }
        if($porcentaje['unidad3']==30) {
            $pdf->SetFillColor(255, 255, 0);
            $pdf->Cell(15, 5, utf8_decode($porcentaje['unidad3'].'%'), 1, 0, 'C',true);
        }
        elseif($porcentaje['unidad3']<30) {
            $pdf->SetFillColor(255, 0, 0);
            $pdf->Cell(15, 5, utf8_decode($porcentaje['unidad3'].'%'), 1, 0, 'C',true);
        }
        elseif($porcentaje['unidad3']>30) {
            $pdf->SetFillColor(0, 128, 0);
            $pdf->Cell(15, 5, utf8_decode($porcentaje['unidad3'].'%'), 1, 0, 'C',true);
        }
        if($porcentaje['unidad4']==30) {
            $pdf->SetFillColor(255, 255, 0);
            $pdf->Cell(15, 5, utf8_decode($porcentaje['unidad4'].'%'), 1, 0, 'C',true);
        }
        elseif($porcentaje['unidad4']<30) {
            $pdf->SetFillColor(255, 0, 0);
            $pdf->Cell(15, 5, utf8_decode($porcentaje['unidad4'].'%'), 1, 0, 'C',true);
        }
        elseif($porcentaje['unidad4']>30) {
            $pdf->SetFillColor(0, 128, 0);
            $pdf->Cell(15, 5, utf8_decode($porcentaje['unidad4'].'%'), 1, 0, 'C',true);
        }
        if($porcentaje['promedio_general']==30) {
            $pdf->SetFillColor(255, 255, 0);
            $pdf->Cell(15, 5, utf8_decode($porcentaje['promedio_general'].'%'), 1, 1, 'C',true);
        }
        elseif($porcentaje['promedio_general']<30) {
            $pdf->SetFillColor(255, 0, 0);
            $pdf->Cell(15, 5, utf8_decode($porcentaje['promedio_general'].'%'), 1, 1, 'C',true);
        }
        elseif($porcentaje['promedio_general']>30) {
            $pdf->SetFillColor(0, 128, 0);
            $pdf->Cell(15, 5, utf8_decode($porcentaje['promedio_general'].'%'), 1, 1, 'C',true);
        }
        $pdf->Line(165, 175, 225, 175);
        $pdf->Text(162,180,utf8_decode('FACILITADOR: '.$nombre_profesor));

        $pdf->Output();

        exit();
//dd($porcentaje);
           /* return view
            ('ingles.profesores_ingles.asignacion_calificaciones', compact
            ('array_calificaciones', 'calificar_unidad', 'alumnos_inscritos', 'id_grupo', 'id_nivel', 'porcentaje', 'nivel'));

      */
    }
    public function lista_asistencia_ingles($id_nivel,$id_grupo){
        $periodo_ingles = Session::get('periodo_ingles');
        $id_profesor=DB::selectOne('SELECT * FROM `in_hrs_ingles_profesor` WHERE `id_grupo` = '.$id_grupo.'
        AND `id_nivel` = '.$id_nivel.' AND `id_periodo` = '.$periodo_ingles.' ORDER BY `id_grupo` ASC');
        $id_profesor=$id_profesor->id_profesor;
        $nombre_profesor=DB::selectOne('SELECT * FROM in_profesores_ingles WHERE id_profesores ='.$id_profesor.' ');
        $nombre_profesor=  mb_strtoupper($nombre_profesor->nombre, 'utf-8') . " " . mb_strtoupper($nombre_profesor->apellido_paterno, 'utf-8') . " " . mb_strtoupper($nombre_profesor->apellido_materno, 'utf-8');
        $nivel = DB::table('in_niveles_ingles')
            ->where('in_niveles_ingles.id_niveles_ingles', '=', $id_nivel)
            ->select('in_niveles_ingles.*')
            ->get();

        $nombre_nivel=$nivel[0]->descripcion;
        $clave_nivel=$nivel[0]->clave;
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
            ->select('gnral_carreras.id_carrera','gnral_carreras.siglas','gnral_carreras.nombre as carrera', 'gnral_alumnos.id_alumno', 'gnral_alumnos.cuenta', 'gnral_alumnos.nombre',
                'gnral_alumnos.apaterno', 'gnral_alumnos.amaterno', 'in_validar_carga.*', 'in_carga_academica_ingles.*',
                'in_niveles_ingles.descripcion as nivel_ingles', 'in_grupo_ingles.descripcion as grupo_ingles')
            ->orderBy('gnral_alumnos.apaterno', 'ASC')
            ->orderBy('gnral_alumnos.amaterno', 'ASC')
            ->orderBy('gnral_alumnos.nombre', 'ASC')
            ->get();
        $fechas = date("Y-m-d");

        $num=date("j",strtotime($fechas));
        $ano=date("Y", strtotime($fechas));
        $mes= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes=$mes[(date('m', strtotime($fechas))*1)-1];
        $fech= $num. ' de '.$mes.' del '.$ano;
        $per_ingles=DB::selectOne('SELECT * FROM in_periodos WHERE id_periodo_ingles = '.$periodo_ingles.'');

        $pdf=new PDF($orientation='L',$unit='mm',$format='Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(10, 25 , 10);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();
        $pdf->Ln(1);
        $pdf->SetFillColor(166,166,166);
        $pdf->SetFont('Arial','B','8');
        $pdf->Cell(250,5, utf8_decode('LISTA DE ASISTENCIA'), 0, 1, 'C',TRUE);
        $pdf->Cell(175,4, utf8_decode('NIVEL DE INGLES:'.$nombre_nivel), 0, 1, 'L');
        $pdf->Cell(175, 3, utf8_decode('CLAVE:'.$clave_nivel), 0, 1, 'L');
        $pdf->Cell(175,3, utf8_decode('PERIODO: '.$per_ingles->periodo_ingles), 0, 1, 'L');
        $pdf->Cell(175,3, utf8_decode('GRUPO:'.$id_grupo), 0, 1, 'L');
        $pdf->Cell(175,3, utf8_decode('FACILITADOR:'.$nombre_profesor), 0, 0, 'L');
        $pdf->Cell(75,3, utf8_decode($fech), 0, 1, 'R');
        $pdf->Ln(1);
        $pdf->SetFont('Arial','B','7');
        $pdf->Cell(7,5,utf8_decode('NP'),1,0,'C',true);
        $pdf->Cell(17,5,utf8_decode('No. CTA'),1,0,'C',true);
        $pdf->Cell(85,5,utf8_decode('NOMBRE DEL USUARIO'),1,0,'C',true);
        $pdf->Cell(16,5,utf8_decode('CARRERA'),1,0,'C',true);
        $pdf->Cell(124,5,utf8_decode('MES DE:'),1,1,'C',true);
        $numero=0;
        foreach ($alumnos as $alumno) {
            $numero++;

            $pdf->SetFont('Arial', '', '7');

            $pdf->Cell(7, 5, utf8_decode($numero), 1, 0, 'C');
            if ($alumno->estado_nivel == 1) {
                $pdf->Cell(17, 5, utf8_decode($alumno->cuenta), 1, 0, 'C');
            } elseif ($alumno->estado_nivel == 2) {
                $pdf->SetFillColor(0, 128, 0);
                $pdf->Cell(17, 5, utf8_decode($alumno->cuenta), 1, 0, 'C', true);
            } elseif ($alumno->estado_nivel == 3) {
                $pdf->SetFillColor(255, 255, 0);
                $pdf->Cell(17, 5, utf8_decode($alumno->cuenta), 1, 0, 'C', true);
            } elseif ($alumno->estado_nivel == 4) {
                $pdf->SetFillColor(255, 0, 0);
                $pdf->Cell(17, 5, utf8_decode($alumno->cuenta), 1, 0, 'C', true);
            }
            $nombre= mb_strtoupper($alumno->apaterno, 'utf-8') . " " . mb_strtoupper($alumno->amaterno, 'utf-8') . " " . mb_strtoupper($alumno->nombre, 'utf-8');

            $pdf->Cell(85, 5, utf8_decode($nombre), 1, 0, 'L');
            $pdf->Cell(16, 5, utf8_decode($alumno->siglas), 1, 0, 'C');
            for($i=0;$i<31; $i++){

                if($i==30){
                    $pdf->Cell(4, 5, utf8_decode(''), 1, 1, 'C');
                }
                else{
                    $pdf->Cell(4, 5, utf8_decode(''), 1, 0, 'C');
                }
            }

        }
            $pdf->Line(175, 175, 245, 175);
        $pdf->Text(177,180,utf8_decode('FACILITADOR: '.$nombre_profesor));

        $pdf->Output();

        exit();
    }
}
