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
        $this->Image('img/tes.PNG', 80 , 15, 50);
        //$this->Image('img/gem.png',25,10,32);
        $this->Ln(10);
    }

}
class Cal_pdf_acta_dualController extends Controller
{
    public function acta_dual_actual($id_alumno,$id_periodo){
        $alum = DB::table('gnral_alumnos')
            ->where('id_alumno', '=', $id_alumno)
            ->get();

        $profesor = DB::table('cal_duales_actuales')
            ->join('gnral_personales','gnral_personales.id_personal','=','cal_duales_actuales.id_personal')
            ->join('abreviaciones_prof','abreviaciones_prof.id_personal','=','gnral_personales.id_personal')
            ->join('abreviaciones','abreviaciones_prof.id_abreviacion','=','abreviaciones.id_abreviacion')
            ->where('cal_duales_actuales.id_alumno', '=', $id_alumno)
            ->where('cal_duales_actuales.id_periodo', '=', $id_periodo)
            ->select('gnral_personales.nombre','abreviaciones.titulo')
            ->get();
        $profesor= mb_strtoupper($profesor[0]->titulo, 'utf-8') . " " . mb_strtoupper($profesor[0]->nombre, 'utf-8');

        $nombre_alumno = mb_strtoupper($alum[0]->apaterno, 'utf-8') . " " . mb_strtoupper($alum[0]->amaterno, 'utf-8') . " " . mb_strtoupper($alum[0]->nombre, 'utf-8');
        $carrera = DB::table('gnral_carreras')
            ->where('id_carrera', '=', $alum[0]->id_carrera)
            ->get();
        $carrera=$carrera[0]->nombre;
        $numero_cuenta=$alum[0]->cuenta;
        $periodo = DB::table('gnral_periodos')
            ->where('id_periodo', '=', $id_periodo)
            ->get();
        $nombre_periodo=$periodo[0]->periodo;
        $fechas = date("Y-m-d");

        $num=date("j",strtotime($fechas));
        $ano=date("Y", strtotime($fechas));
        $mes= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes=$mes[(date('m', strtotime($fechas))*1)-1];
        $fech= $mes.' '.$num.', '.$ano;
        $pdf=new PDF($orientation='P',$unit='mm',$format='Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(20, 25 , 20);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();
        $pdf->SetFont('Times','B','8');
        $pdf->Cell(80);
        $pdf->Cell(15,10,utf8_decode('TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO'),0,1,'C');
        $pdf->Ln(1);
        $pdf->SetFillColor(220, 220, 220); // Gris claro
        $pdf->SetFont('Times','B','9');
        $pdf->Ln(3);
        $pdf->Cell(180,5,utf8_decode('ACTA DE CALIFICACIONES DE ESTUDIANTE DUAL'),0,1,'C',true);
        $pdf->Ln(5);
        $pdf->Cell(47,5,utf8_decode('PROGRAMA ACADÉMICO:'),0,0,'L');
        $pdf->Cell(133,5,utf8_decode($carrera),0,1,'L');
        $pdf->Cell(25,5,utf8_decode('ESTUDIANTE:'),0,0,'L');
        $pdf->Cell(155,5,utf8_decode($nombre_alumno),0,1,'L');
        $pdf->Cell(25,5,utf8_decode('NO. CUENTA:'),0,0,'L');
        $pdf->Cell(155,5,utf8_decode($numero_cuenta),0,1,'L');
        $pdf->Cell(29,5,utf8_decode('MENTOR DUAL:'),0,0,'L');
        $pdf->Cell(151,5,utf8_decode($profesor),0,1,'L');
        $pdf->Cell(29,5,utf8_decode(''),0,0,'L');
        $pdf->Cell(151,5,utf8_decode($nombre_periodo),0,1,'R');
        $pdf->Cell(130,5,utf8_decode(''),0,0,'L');
        $pdf->Cell(50,5,utf8_decode($fech),0,1,'C');
        $pdf->Ln(3);
        $pdf->SetFont('Times','B','6');
        $pdf->Cell(10,3,utf8_decode(''),'LTR',0,'C',true);
        $pdf->Cell(30,3,utf8_decode('SEMESTRE DE LA'),'LTR',0,'C',true);
        $pdf->Cell(30,3,utf8_decode('CLAVE DE LA'),'LTR',0,'C',true);
        $pdf->Cell(70,3,utf8_decode(''),'LTR',0,'C',true);
        $pdf->Cell(20,3,utf8_decode(''),'LTR',0,'C',true);
        $pdf->Cell(20,3,utf8_decode(''),'LTR',1,'C',true);
        $pdf->Cell(10,3,utf8_decode('NP'),'LBR',0,'C',true);
        $pdf->Cell(30,3,utf8_decode('MATERIA'),'LBR',0,'C',true);
        $pdf->Cell(30,3,utf8_decode('MATERIA'),'LBR',0,'C',true);
        $pdf->Cell(70,3,utf8_decode('MATERIA'),'LBR',0,'C',true);
        $pdf->Cell(20,3,utf8_decode('PROMEDIO'),'LBR',0,'C',true);
        $pdf->Cell(20,3,utf8_decode('TE'),'LBR',1,'C',true);    
        $carga_academica = DB::table('eva_carga_academica')
            ->join('gnral_materias','gnral_materias.id_materia','=','eva_carga_academica.id_materia')
            ->join('eva_tipo_curso','eva_tipo_curso.id_tipo_curso','=','eva_carga_academica.id_tipo_curso')
            ->join('gnral_semestres','gnral_semestres.id_semestre','=','gnral_materias.id_semestre')
            ->where('id_periodo', '=', $id_periodo)
            ->where('id_alumno', '=', $id_alumno)
            ->where('id_status_materia', '=', 1)
            ->whereNotIn('gnral_materias.id_materia', [773,845,853,1160,1263,1264,1265,1443,1496,1502,1565,1566,1567,1568,1569,1571])
            ->select('eva_carga_academica.id_carga_academica','eva_carga_academica.id_tipo_curso','eva_tipo_curso.nombre_curso','gnral_materias.*','gnral_semestres.descripcion as semestre')
            ->get();
        $suma_promedio_final=0;
        $suma_materia=0;
        $alumnos= array();
        foreach($carga_academica as $materias){
            $suma_materia++;
            $datos_alumnos['numero']=$suma_materia;
            $datos_alumnos['id_carga_academica']=$materias->id_carga_academica;
            $datos_alumnos['id_materia']=$materias->id_materia;
            $datos_alumnos['nombre_materia']=$materias->nombre;
            $datos_alumnos['semestre']=$materias->semestre;
            $datos_alumnos['clave']=$materias->clave;

            $materia_promedio=DB::selectOne('SELECT SUM(calificacion) suma FROM `cal_evaluaciones` WHERE `id_carga_academica` ='.$materias->id_carga_academica.' and calificacion >=70');
            $materia_promedio=$materia_promedio->suma;
            $contar_unidades_pasadas=DB::selectOne('SELECT count(calificacion) suma FROM `cal_evaluaciones` WHERE `id_carga_academica` = '.$materias->id_carga_academica.' and calificacion >=70');
           $contar_unidades_pasadas=$contar_unidades_pasadas->suma;
           if($contar_unidades_pasadas ==$materias->unidades){
               if($materia_promedio == 0){
                   $promedio=0;
               }
               else{
                   $promedio=round($materia_promedio/$materias->unidades);
               }
             if($materias->id_tipo_curso ==1){
                 $te='O';
             }
               if($materias->id_tipo_curso ==2){
                   $te='O2';
               }
               if($materias->id_tipo_curso ==3){
                   $te='CE';
               }
               if($materias->id_tipo_curso ==4){
                   $te='EG';
               }
           }
           else{
               if($materia_promedio == 0){
                   $promedio=0;
               }
               else{
                   $promedio=0;
               }
               if($materias->id_tipo_curso ==1){
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
            $datos_alumnos['promedio']=$promedio;
            $datos_alumnos['te']=$te;
            $suma_promedio_final+=$promedio;
            array_push($alumnos,$datos_alumnos);
        }
        if($suma_promedio_final > 0){
            $promedio_final=($suma_promedio_final/$suma_materia);
            $promedio_final = number_format($promedio_final, 2, '.', ' ');
        }
        else{
            $promedio_final=0;
        }
        foreach($alumnos as $alumno) {
            $pdf->Cell(10, 10, utf8_decode($alumno['numero']), 1, 0, 'C');
            $pdf->Cell(30, 10, utf8_decode($alumno['semestre']), 1, 0, 'C');
            $pdf->Cell(30, 10, utf8_decode($alumno['clave']), 1, 0, 'C');
            $pdf->Cell(70, 10, utf8_decode(''), 1, 0, 'C');
            if($alumno['promedio']< 70) {
                $pdf->SetFillColor(255, 0, 0);
                $pdf->Cell(20, 10, utf8_decode('NA'), 1, 0, 'C',true);
            }
            else{
                $pdf->Cell(20, 10, utf8_decode($alumno['promedio']), 1, 0, 'C');
            }
            $pdf->Cell(20, 10, utf8_decode($alumno['te']), 1, 1, 'C');
        }
        // Agregar una celda vacía al lado de la celda "Promedio Final"
        $pdf->Cell(70, 10, '', 0, 0);
        $pdf->Cell(70, 10, utf8_decode('PROMEDIO:'), 1, 0, 'R');
        $pdf->SetFillColor(220, 220, 220); // Gris claro
        $pdf->Cell(20, 10, utf8_decode($promedio_final), 1, 1, 'C',true);
      //dd($alumnos);
        $numero=87;
        foreach($alumnos as $alumno) {
            $pdf->SetXY(90,$numero);
            $pdf->MultiCell(70,30,utf8_decode($alumno['nombre_materia']),0, 'C');
            $numero+=10;
        }
        $pdf->Ln(50);
        $numero += 50; // Ajustar la posición vertical
        $pdf->Line(140, $numero, 195, $numero);
        $pdf->SetXY(132, $numero);
        $pdf->MultiCell(70, 4, utf8_decode($profesor), 0, 'C');
        $pdf->Output();
        exit();
    }
}
