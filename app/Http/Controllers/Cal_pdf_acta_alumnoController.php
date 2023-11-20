<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use Illuminate\Support\Facades\DB;
use Session;
class PDF extends FPDF
{

    //CABECERA DE LA PAGINA
    function Header()
    {
        $this->Image('img/logo3.PNG', 180, 15, 85);
        $this->SetY(20);
        $this->SetFont('Arial','',14);
        $this->Cell(200,10,utf8_decode('BOLETA'),0,0,'C');
       $this->Image('img/gem.png',25,10,32);
       $this->Ln(12);
    }
    //PIE DE PAGINA
    function Footer()
    {

                $this->SetY(-25);
                $this->SetFont('Arial','',8);
               // $this->Image('img/sgc.PNG',40,183,20);
                $this->Image('img/pie/logos_iso.jpg',35,180,60);
                //$this->Image('img/sga.PNG',65,183,20);
                $this->Cell(80);
                $this->Cell(167,-2,utf8_decode(''),0,0,'R');
                $this->Ln(3);
                $this->Cell(80);
                $this->Cell(167,-2,utf8_decode('SECRETARÍA DE EDUCACIÓN'),0,0,'R');
                $this->Ln(3);
                $this->Cell(80);
                $this->Cell(167,-2,utf8_decode('SUBSECRETARÍA DE EDUCACIÓN SUPERIOR Y NORMAL'),0,0,'R');
                $this->Ln(3);
                $this->Cell(80);
                $this->Cell(167,-2,utf8_decode('TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO'),0,0,'R');
                $this->Ln(3);
                $this->Cell(80);
                $this->Cell(167,-2,utf8_decode('SUBDIRECCIÓN DE SERVICIOS ESCOLARES'),0,0,'R');
                $this->Cell(280);
                $this->SetMargins(0,0,0);
                $this->Ln(0);
                $this->SetXY(30,204);
                $this->SetFillColor(120,120,120);
                $this->Cell(20,10,'',0,0,'',TRUE);
                $this->SetTextColor(255,255,255);
                $this->Cell(297,10,utf8_decode('Km. 30 de la Carretera Federal Monumento - Valle de Bravo, Ejido de San Antonio de la Laguna,'),0,0,'L',TRUE);
                $this->Ln(3);
                $this->Cell(50);
                $this->Cell(160,10,utf8_decode(' Valle de Bravo, Estado de México, C.P. 51200.    Tels.: (726)26 6 52 00, 26 6 50 77,26 6 51 87 Ext 115                             sub.escolares@vbravo.tecnm.mx'),0,0,'L');

                $this->Image('img/logos/Mesquina.jpg',0,190,30);

    }

}
class Cal_pdf_acta_alumnoController extends Controller
{
    public function acta_materias($id_alumno,$turno,$semestre,$grupo){
        $alum = DB::table('gnral_alumnos')
            ->where('id_alumno', '=', $id_alumno)
            ->get();
        $turno=DB::selectOne('SELECT * FROM `cal_turno` WHERE `id_turno` = '.$turno.' ');
        $semestre=DB::selectOne('SELECT * FROM `gnral_semestres` WHERE `id_semestre` ='.$semestre.'');
        $grupo=DB::selectOne('SELECT * FROM `gnral_grupos` WHERE `id_grupo` ='.$grupo.'');
        $id_periodo=Session::get('periodo_actual');
        $nombre_alumno = mb_strtoupper($alum[0]->apaterno, 'utf-8') . " " . mb_strtoupper($alum[0]->amaterno, 'utf-8') . " " . mb_strtoupper($alum[0]->nombre, 'utf-8');
        $carr = DB::table('gnral_carreras')
            ->where('id_carrera', '=', $alum[0]->id_carrera)
            ->get();
        $codigo_carrera=$carr[0]->codigo_carrera;
        $carrera=$carr[0]->nombre;
        $numero_cuenta=$alum[0]->cuenta;
        $periodo = DB::table('gnral_periodos')
            ->where('id_periodo', '=', $id_periodo)
            ->get();
        $nombre_periodo=$periodo[0]->periodo;
        $fechas = date("Y-m-d");

        $num=date("d",strtotime($fechas));
        $mes=date("m", strtotime($fechas));
        $ano=date("Y", strtotime($fechas));
         $fech= $mes.'/'.$num.'/'.$ano;
        $pdf=new PDF($orientation='L',$unit='mm',$format='Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(20, 25 , 20);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();
        $pdf->SetFillColor(166,166,166);
        $pdf->SetFont('Arial','B','9');
        $pdf->Ln(3);
        $pdf->Cell(190,7,utf8_decode('NOMBRE: '.$nombre_alumno),1,0,'L');
        $pdf->Cell(50,7,utf8_decode('TURNO: '.$turno->turno),1,1,'L');
        $pdf->Cell(45,7,utf8_decode('NO. CTA: '.$numero_cuenta),1,0,'L');
        $pdf->Cell(140,7,utf8_decode('CARRERA: '.$carrera),1,0,'L');
        $pdf->Cell(55,7,utf8_decode('SEMESTRE: '.$semestre->descripcion),1,1,'L');
        $pdf->Cell(125,7,utf8_decode('PERIODO:   '.$nombre_periodo),1,0,'L');
        $pdf->Cell(55,7,utf8_decode('FECHA:  '.$fech),1,0,'L');
        $pdf->Cell(60,7,utf8_decode('GRUPO:  '.$codigo_carrera."".$grupo->grupo),1,1,'L');
        $pdf->SetFont('Arial','B','9');
        $pdf->Cell(30,7,utf8_decode('CLAVE'),1,0,'C');
        $pdf->Cell(114,7,utf8_decode('MATERIA'),1,0,'C');
        $pdf->Cell(27,7,utf8_decode('CREDITOS'),1,0,'C');
        $pdf->Cell(32,7,utf8_decode('CALIFICACIÓN'),1,0,'C');
        $pdf->Cell(37,7,utf8_decode('TIPO DE EXAMEN'),1,1,'C');
        $carga_academica=DB::select('select  gnral_materias.id_materia,gnral_materias.nombre as materias,gnral_materias.unidades,gnral_materias.id_materia,eva_tipo_curso.nombre_curso,
eva_carga_academica.id_carga_academica,eva_carga_academica.grupo,gnral_materias.id_semestre,
gnral_materias.creditos,eva_status_materia.nombre_status,gnral_materias.clave,eva_carga_academica.id_tipo_curso from
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
                                and eva_validacion_de_cargas.estado_validacion in (2,8,9)
                                and eva_validacion_de_cargas.id_alumno='.$id_alumno.'
                                and eva_status_materia.id_status_materia=1');


        $suma_promedio_final=0;
        $suma_materia=0;
        $alumnos= array();
        $total_creditos=0;
        foreach($carga_academica as $materias){
            $suma_materia++;
            $datos_alumnos['numero']=$suma_materia;
            $datos_alumnos['id_carga_academica']=$materias->id_carga_academica;
            $datos_alumnos['id_materia']=$materias->id_materia;
            $datos_alumnos['nombre_materia']=$materias->materias;
            $datos_alumnos['clave']=$materias->clave;
            $datos_alumnos['creditos']=$materias->creditos;


            $materia_promedio=DB::selectOne('SELECT SUM(calificacion) suma FROM `cal_evaluaciones` WHERE `id_carga_academica` ='.$materias->id_carga_academica.' and calificacion >=70');
            $materia_promedio=$materia_promedio->suma;

            $contar_unidades_pasadas=DB::selectOne('SELECT count(calificacion) suma FROM `cal_evaluaciones` WHERE `id_carga_academica` = '.$materias->id_carga_academica.' and calificacion >=70');
            $contar_unidades_pasadas=$contar_unidades_pasadas->suma;

            $contar_sumativa=DB::selectOne('SELECT count(esc) contar FROM `cal_evaluaciones` WHERE `id_carga_academica` = '.$materias->id_carga_academica.' and esc=1');
            $contar_sumativa=$contar_sumativa->contar;

            if($contar_unidades_pasadas ==$materias->unidades){
                if($materia_promedio == 0){
                    $promedio=0;
                }
                else{
                    $promedio=round($materia_promedio/$materias->unidades);
                }
                if($materias->id_tipo_curso ==1  ){
                    if($contar_sumativa == 0){
                        $te='O';
                    }
                    else{
                        $te='ESC';
                    }

                }

                if($materias->id_tipo_curso ==2){
                    if($contar_sumativa == 0){
                        $te='O2';
                    }
                    else{
                        $te='ESC2';
                    }

                }
                if($materias->id_tipo_curso ==3){
                    if($contar_sumativa == 0){
                        $te='CE';
                    }
                    else{
                        $te='EG';
                    }

                }
                if($materias->id_tipo_curso ==4){
                    if($contar_sumativa == 0){
                        $te='EG';
                    }
                    else{
                        $te='EG';
                    }

                }
            }
            else{


                    $promedio=0;

                if($materias->id_tipo_curso==1){
                    $te='ESC';
                }
                if($materias->id_tipo_curso ==2){
                    $te='ESC2';
                }
                if($materias->id_tipo_curso ==3){
                    $te='EG';
                }
                if($materias->id_tipo_curso ==4){
                    $te='EG';
                }



            }
            if($promedio >= 70)
            {
                $total_creditos+=$materias->creditos;
            }
            $datos_alumnos['promedio']=$promedio;
            $datos_alumnos['te']=$te;
            $suma_promedio_final+=$promedio;
            array_push($alumnos,$datos_alumnos);
        }
        $cal_resi=0;
        $calificada=0;
        $resi="";
        $residencia=DB::selectOne('select count(eva_carga_academica.id_alumno) contar from
                                gnral_materias,eva_status_materia,eva_tipo_curso,gnral_grupos,eva_carga_academica,gnral_periodos,gnral_alumnos,eva_validacion_de_cargas
                                where eva_carga_academica.id_materia=gnral_materias.id_materia
                                and eva_carga_academica.id_status_materia=eva_status_materia.id_status_materia
                                and eva_carga_academica.id_tipo_curso=eva_tipo_curso.id_tipo_curso
                                and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
                                and eva_carga_academica.grupo=gnral_grupos.id_grupo
                                and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                                and gnral_periodos.id_periodo='.$id_periodo.'
                                 and eva_carga_academica.id_materia   IN (773,845,853,1160,1263,1264,1265,1443,1496,1502,1565,1566,1567,1568,1569,1571)
                                and gnral_alumnos.id_alumno=eva_validacion_de_cargas.id_alumno
                                and gnral_periodos.id_periodo=eva_validacion_de_cargas.id_periodo
                                and eva_validacion_de_cargas.estado_validacion in (2,8,9)
                                and eva_validacion_de_cargas.id_alumno='.$id_alumno.'
                                and eva_status_materia.id_status_materia=1');
        //dd($residencia);
        if($residencia->contar == 0){

        }
        else{
            $cal_resi=1;
            $contar_r=DB::selectOne('SELECT count(id_cal_residencia) contar_residencia  
FROM `cal_residencia` WHERE `id_alumno` = '.$id_alumno.'');

            if($contar_r->contar_residencia == 0){

            }
            else{
                $calificada=1;
                $resi=DB::selectOne('SELECT   *FROM `cal_residencia` WHERE `id_alumno` = '.$id_alumno.'');
                 $suma_materia=$suma_materia+1;
                 $cal_resi=$resi->calificacion;
                 if($cal_resi >= 70) {

                     $suma_promedio_final = $suma_promedio_final + $cal_resi;
                     $total_creditos = $total_creditos + 10;
                 }

            }
        }
        if($suma_promedio_final > 0){
            $promedio_final=($suma_promedio_final/$suma_materia);
            $promedio_final = number_format($promedio_final, 2, '.', ' ');
        }
        else{
            $promedio_final=0;
        }
        foreach($alumnos as $alumno) {
            $pdf->SetFont('Arial','','9');
            $pdf->Cell(30, 10, utf8_decode($alumno['clave']), 1, 0, 'C');
            $pdf->Cell(114, 10, utf8_decode(''), 1, 0, 'C');

            if($alumno['promedio']< 70) {
                $pdf->Cell(27, 10, utf8_decode("0"), 1, 0, 'C');
                $pdf->Cell(32, 10, utf8_decode('NA'), 1, 0, 'C');
            }
            else{
                $pdf->Cell(27, 10, utf8_decode($alumno['creditos']), 1, 0, 'C');
                $pdf->Cell(32, 10, utf8_decode($alumno['promedio']), 1, 0, 'C');

            }
            $pdf->Cell(37, 10, utf8_decode($alumno['te']), 1, 1, 'C');
        }
        if($calificada == 1)
        {
            $pdf->SetFont('Arial','','9');
            $pdf->Cell(30, 10, utf8_decode('RES-0001'), 1, 0, 'C');
            $pdf->Cell(114, 10, utf8_decode('RESIDENCIA PROFESIONAL'), 1, 0, 'C');

            if($cal_resi< 70) {

                $pdf->Cell(27, 10, utf8_decode('0'), 1, 0, 'C');
                $pdf->Cell(32, 10, utf8_decode('NA'), 1, 0, 'C');
            }
            else{
                $pdf->Cell(27, 10, utf8_decode('10'), 1, 0, 'C');
                $pdf->Cell(32, 10, utf8_decode($cal_resi), 1, 0, 'C');

            }
            $pdf->Cell(37, 10, utf8_decode(" "), 1, 1, 'C');
        }
        $pdf->SetFont('Arial','B','9');
        $pdf->Cell(144, 10, utf8_decode(''), 0, 0, 'R');
        $pdf->Cell(27, 10, utf8_decode('PROMEDIO:'), 1, 0, 'R');
        $pdf->SetFont('Arial','','9');
        $pdf->Cell(32, 10, utf8_decode($promedio_final),1, 1, 'C');
        $pdf->Cell(144, 10, utf8_decode(''), 0, 0, 'R');
        $pdf->SetFont('Arial','B','9');
        $pdf->Cell(27, 10, utf8_decode('CREDITOS:'), 1, 0, 'R');
        $pdf->SetFont('Arial','','9');
        $pdf->Cell(32, 10, utf8_decode($total_creditos),1,1, 'C');
        //dd($alumnos);
        $numero=67;
        foreach($alumnos as $alumno) {


            $pdf->SetXY(50,$numero);
            $pdf->SetFont('Arial','','9');
            $pdf->MultiCell(114,4,utf8_decode($alumno['nombre_materia']),0, '');
            $numero+=10;
        }


        $numero+=20;
        $pdf->Line(30, $numero,120, $numero);
        $pdf->SetXY(30,$numero);
        $pdf->SetFont('Arial','B','11');
        $pdf->MultiCell(90,6,utf8_decode('L. EN C. ROMULO ESQUIVEL REYES'),0, 'C');
        $pdf->SetXY(30,$numero+5);
        $pdf->MultiCell(90,5,utf8_decode('SUBDIRECTOR DE SERVICIOS ESCOLARES'),0, 'C');




        $pdf->Output();
        exit();
    }
}
