<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use Illuminate\Support\Facades\DB;
use Session;
use Storage;

class PDF extends FPDF
{

    //CABECERA DE LA PAGINA
    function Header()
    {
        $this->Image('img/logo3.PNG', 115, 10, 70);
        $this->Image('img/logos/ArmasBN.png',20,10,50);
        $this->Image('img/tutorias/tecnm.jpg',80,10,30);
        $this->Ln(10);
    }
    //PIE DE PAGINA
    function Footer()
    {
        $this->SetY(-35);
        $this->SetFont('Arial','',8);
        $this->Image('img/sga3.jpg',40,240,60);

        //$this->Image('img/sga.PNG',65,240,20);
        $this->Cell(50);
        $this->Cell(145,-2,utf8_decode(''),0,0,'R');
        $this->Ln(3);
        $this->SetFont('Arial','B',8);
        $this->Cell(50);
        $this->Cell(145,-2,utf8_decode('SECRETARÍA DE EDUCACIÓN'),0,0,'R');
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(145,-2,utf8_decode('SUBSECRETARÍA DE EDUCACIÓN SUPERIOR Y NORMAL'),0,0,'R');
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(145,-2,utf8_decode('TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO'),0,0,'R');
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(145,-2,utf8_decode('DEPARTAMENTO DE DESARROLLO ACADEMICO'),0,0,'R');
        $this->Cell(280);
        $this->SetMargins(0,0,0);
        $this->Ln(0);
        $this->SetXY(40,262);
        $this->SetFillColor(120,120,120);
        $this->SetTextColor(255,255,255);
        $this->SetFont('Arial','B',8);
        $this->Cell(165,4,utf8_decode('      Km. 30 de la Carretera Federal Monumento - Valle de Bravo, Ejido de San Antonio de la Laguna,'),0,0,'L',TRUE);
        $this->Ln(3);
        $this->Cell(40);
        $this->SetFont('Arial','B',8);
        $this->Cell(165,4,utf8_decode('      Valle de Bravo, Estado de México, C.P. 51200.'),0,0,'L',TRUE);
        $this->Ln(3);
        $this->Cell(40);
        $this->SetFont('Arial','',8);
        $this->Cell(165,4,utf8_decode('     Tels.:(726)26 6 52 ,26 6 51 87     des.academico@vbravo.tecnm.mx'),0,0,'L',true);

        $this->Image('img/logos/Mesquina.jpg',0,240,40);
    }

}
class Tu_Eva_pdf_fo17Controller extends Controller
{
    public function imprime($per,$id_grupo_semestre)
    {
        $id_usuario = Session::get('usuario_alumno');
        //dd($per);
        $periodo = Session::get('periodo_actual');
        //dd($periodo);
        //dd($id_grupo_semestre);


        $datos1 = DB::SELECTONE('SELECT exp_asigna_t.id_asigna_tutor, gnral_p.nombre nombre_tutor, car.nombre carrera,tu_grupo_t.descripcion grupo, now() fecha, year(now()) ano, month(now()) mes, day(now()) dia
                                FROM tu_grupo_tutorias tu_grupo_t
                                INNER JOIN tu_grupo_semestre tu_grupo_s
                                ON tu_grupo_s.id_grupo_tutorias = tu_grupo_t.id_grupo_tutorias
                                INNER JOIN exp_asigna_tutor exp_asigna_t 
                                ON exp_asigna_t.id_asigna_tutor = tu_grupo_s.id_asigna_tutor
                                INNER JOIN gnral_personales gnral_p 
                                ON gnral_p.id_personal = exp_asigna_t.id_personal 
                                INNER JOIN gnral_jefes_periodos gnral_j 
                                ON gnral_j.id_jefe_periodo = exp_asigna_t.id_jefe_periodo
                                INNER JOIN gnral_carreras car
                                ON car.id_carrera = gnral_j.id_carrera
                                WHERE tu_grupo_s.id_grupo_semestre = '.$id_grupo_semestre.' and gnral_j.id_periodo ='.$periodo.' ');
        $con_q = 'select count(*) con from tu_eva_fo17 where id_asigna_tutor = '.$datos1->id_asigna_tutor.' and per = '.$per.' ';
        //dd($con_q);
        $con = DB::selectone($con_q);
        //dd($con);
        //dd($datos1);
        // $per_c = DB::SELECTONE('SELECT id_personal FROM `gnral_personales` WHERE tipo_usuario = '.$id_usuario.' ');
        // //dd($per_c);
        // $persona = DB::SELECTONE('SELECT cor.id_asigna_coordinador FROM tu_grupo_tutorias tu_grupo_t
        //                         INNER JOIN tu_grupo_semestre tu_grupo_s
        //                         ON tu_grupo_s.id_grupo_tutorias = tu_grupo_t.id_grupo_tutorias
        //                         INNER JOIN exp_asigna_tutor exp_asigna_t
        //                         ON exp_asigna_t.id_asigna_tutor = tu_grupo_s.id_asigna_tutor
        //                         INNER JOIN gnral_personales gnral_p
        //                         ON gnral_p.id_personal = exp_asigna_t.id_personal
        //                         INNER JOIN gnral_jefes_periodos gnral_j
        //                         ON gnral_j.id_jefe_periodo = exp_asigna_t.id_jefe_periodo
        //                         INNER JOIN gnral_carreras car
        //                         ON car.id_carrera = gnral_j.id_carrera
        //                         INNER JOIN 	exp_asigna_coordinador cor
        //                         ON cor.id_personal = gnral_p.id_personal
        //                         WHERE gnral_j.id_periodo = '.$periodo.' AND cor.id_personal = '.$per_c->id_personal.' ');
        // $persona1 = $persona -> id_asigna_coordinador;
        if ($con->con == 0) {
            //dd('0');
            return view('tutorias.eva_seguimiento_tu.formato17',compact('datos1','per'));
        }
        else{
            $datos_tutor= DB::selectOne('SELECT datos.nombre, grupo.descripcion grupo, carrera.nombre carrera, per.periodo FROM gnral_personales datos
                                    INNER JOIN exp_asigna_tutor tutor
                                    ON tutor.id_personal = datos.id_personal
                                    INNER JOIN tu_grupo_semestre semestre
                                    ON semestre.id_asigna_tutor = tutor.id_asigna_tutor
                                    INNER JOIN tu_grupo_tutorias grupo
                                    ON grupo.id_grupo_tutorias = semestre.id_grupo_tutorias
                                    INNER JOIN gnral_jefes_periodos periodo
                                    ON periodo.id_jefe_periodo = tutor.id_jefe_periodo
                                    INNER JOIN gnral_periodos per
                                    ON per.id_periodo = periodo.id_periodo
                                    INNER JOIN gnral_carreras carrera
                                    ON carrera.id_carrera = periodo.id_carrera
                                    WHERE tutor.id_asigna_tutor =  '.$datos1->id_asigna_tutor.' ');
            //dd($datos_tutor);

            $res = DB::selectone('select  id_fo17,id_asigna_tutor,per,IF(experiencia=1,"Si","No") experiencia,anos_tutor, IF(planeacion=1,"Si","No") planeacion,com_planeacion,fecha_establecida,fecha_final,(
            CASE 
                WHEN tu.pregunta1 = 1 THEN "Mala"
                WHEN tu.pregunta1 = 2 THEN "Regular"
                WHEN tu.pregunta1 = 3 THEN "Buena"
                WHEN tu.pregunta1 = 4 THEN "Muy buena"
                WHEN tu.pregunta1 = 5 THEN "Excelente"
            END) pregunta1,
            (CASE 
                WHEN tu.pregunta2 = 1 THEN "Mala"
                WHEN tu.pregunta2 = 2 THEN "Regular"
                WHEN tu.pregunta2 = 3 THEN "Buena"
                WHEN tu.pregunta2 = 4 THEN "Muy buena"
                WHEN tu.pregunta2 = 5 THEN "Excelente"
            END)pregunta2,
            (CASE 
                WHEN tu.pregunta3 = 1 THEN "Mala"
                WHEN tu.pregunta3 = 2 THEN "Regular"
                WHEN tu.pregunta3 = 3 THEN "Buena"
                WHEN tu.pregunta3 = 4 THEN "Muy buena"
                WHEN tu.pregunta3 = 5 THEN "Excelente"
            END)pregunta3,
            (CASE 
                WHEN tu.pregunta4 = 1 THEN "Mala"
                WHEN tu.pregunta4 = 2 THEN "Regular"
                WHEN tu.pregunta4 = 3 THEN "Buena"
                WHEN tu.pregunta4 = 4 THEN "Muy buena"
                WHEN tu.pregunta4 = 5 THEN "Excelente"
            END)pregunta4,
            (CASE
                WHEN tu.pregunta5 = 1 THEN "Mala"
                WHEN tu.pregunta5 = 2 THEN "Regular"
                WHEN tu.pregunta5 = 3 THEN "Buena"
                WHEN tu.pregunta5 = 4 THEN "Muy buena"
                WHEN tu.pregunta5 = 5 THEN "Excelente"
            END)pregunta5,
            (CASE 
                WHEN tu.pregunta6 = 1 THEN "Mala"
                WHEN tu.pregunta6 = 2 THEN "Regular"
                WHEN tu.pregunta6 = 3 THEN "Buena"
                WHEN tu.pregunta6 = 4 THEN "Muy buena"
                WHEN tu.pregunta6 = 5 THEN "Excelente"
            END)pregunta6,
            (CASE 
                WHEN tu.pregunta7 = 1 THEN "Mala"
                WHEN tu.pregunta7 = 2 THEN "Regular"
                WHEN tu.pregunta7 = 3 THEN "Buena"
                WHEN tu.pregunta7 = 4 THEN "Muy buena"
                WHEN tu.pregunta7 = 5 THEN "Excelente"
            END)pregunta7,
            (CASE 
                WHEN tu.pregunta8 = 1 THEN "Mala"
                WHEN tu.pregunta8 = 2 THEN "Regular"
                WHEN tu.pregunta8 = 3 THEN "Buena"
                WHEN tu.pregunta8 = 4 THEN "Muy buena"
                WHEN tu.pregunta8 = 5 THEN "Excelente"
            END)pregunta8,
            (CASE 
                WHEN tu.pregunta9 = 1 THEN "Mala"
                WHEN tu.pregunta9 = 2 THEN "Regular"
                WHEN tu.pregunta9 = 3 THEN "Buena"
                WHEN tu.pregunta9 = 4 THEN "Muy buena"
                WHEN tu.pregunta9 = 5 THEN "Excelente"
            END)pregunta9,
            (CASE 
                WHEN tu.pregunta10= 1 THEN "Mala"
                WHEN tu.pregunta10 = 2 THEN "Regular"
                WHEN tu.pregunta10 = 3 THEN "Buena"
                WHEN tu.pregunta10 = 4 THEN "Muy buena"
                WHEN tu.pregunta10 = 5 THEN "Excelente"
            END)pregunta10,
            comentario,fecha_registro  from tu_eva_fo17 tu where id_asigna_tutor = '.$datos1->id_asigna_tutor.' and per = '.$per.' ');
            /// id_fo17,id_asigna_tutor,id_asigna_cordinador,per,IF(experiencia=1,"Si","No") experiencia,anos_tutor, IF(planeacion=1,"Si","No") planeacion,com_planeacion,fecha_establecida,fecha_final,pregunta1,pregunta2,pregunta3,pregunta4,pregunta5,pregunta6,pregunta7,pregunta8,pregunta9,pregunta10,comentario,fecha_registro

            //dd($res);
            // $id_asigna_tutor = $request->get('id_asigna_tutor');

            $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');



            $periodo=Session::get('periodo_actual');


            //dd($hola);
            //$condi=$request->get('condi');
            $pdf=new PDF($orientation='P',$unit='mm',$format='Letter');
            #Establecemos los márgenes izquierda, arriba y derecha:
            //dd($request);

            //$nombre = 'Tutor: '.$datos_tutor->nombre;
            //dd($datos);
            $pdf->SetMargins(10, 30 , 10, 30);
            $pdf->SetAutoPageBreak(true,25);
            $pdf->AddPage();
            $pdf->SetDrawColor(164,164,164);
            $pdf->SetLineWidth(1.0);
            $pdf->Line(231, 10, 231, 32);
            $pdf->SetFont('Arial','',8);
            //$pdf->Ln();
            $pdf->Cell(190,5,utf8_decode('SEGUIMIENTO DEL TUTOR'),0,1,'C');
            $pdf->Ln();

            $pdf->Cell(200,5,utf8_decode('Nombre de Tutor(a): '.$datos_tutor->nombre),1,1,'C');
            $pdf->Cell(200,5,utf8_decode('Programa de Estudio: '.$datos_tutor->carrera),1,1,'C');
            $pdf->Cell(100,5,utf8_decode('Cuenta con experiencia como tutor(a): '.$res->experiencia),1,0,'C');
            $pdf->Cell(100,5,utf8_decode('Años: '.$res->anos_tutor),1,1,'C');
            $pdf->Cell(100,5,utf8_decode('Entrego la Planeación: '.$res->planeacion),1,0,'C');
            $pdf->Cell(100,5,utf8_decode($res->com_planeacion),1,1,'C');
            $pdf->Cell(100,5,utf8_decode('Entregó cuaderno de planeación didáctica: '),1,0,'C');
            $pdf->Cell(50,5,utf8_decode('Fecha establecida: '.$res->fecha_establecida),1,0,'C');
            $pdf->Cell(50,5,utf8_decode('Fecha real: '.$res->fecha_final),1,1,'C');
            $pdf->Ln(10);
            $pdf->Cell(200,5,utf8_decode('La ponderación para el juicio de valor es: Excelente= 5, Muy buena = 4, Buena = 3, Regular = 2, Mala = 1'),1,1,'C');
            $pdf->Ln(5);
            $pdf->Cell(150,5,utf8_decode('Aspectos Evaluados'),1,0,'C');
            $pdf->Cell(50,5,utf8_decode('Calificacion'),1,1,'C');

            $pdf->Cell(150,5,utf8_decode('El tutor explica la forma de trabajar en el l el programa de tutorías.'),1,0,'C');
            $pdf->Cell(50,5,utf8_decode($res->pregunta1),1,1,'C');

            $pdf->Cell(150,5,utf8_decode('El tutor conoce la Normativa del Tecnológico. '),1,0,'C');
            $pdf->Cell(50,5,utf8_decode($res->pregunta2),1,1,'C');

            $pdf->Cell(150,5,utf8_decode('Asiste a las reuniones de tutorías y apoya en las actividades del programa.'),1,0,'C');
            $pdf->Cell(50,5,utf8_decode($res->pregunta3),1,1,'C');

            $pdf->Cell(150,5,utf8_decode('Participa con su grupo en las actividades de tutorías solicitadas. '),1,0,'C');
            $pdf->Cell(50,5,utf8_decode($res->pregunta4),1,1,'C');

            $pdf->Cell(150,5,utf8_decode('Colabora en asesorías y actividades Complementarias.'),1,0,'C');
            $pdf->Cell(50,5,utf8_decode($res->pregunta5),1,1,'C');

            $pdf->Cell(150,5,utf8_decode('Propicia un ambiente de confianza con el tutorado.'),1,0,'C');
            $pdf->Cell(50,5,utf8_decode($res->pregunta6),1,1,'C');

            $pdf->Cell(150,5,utf8_decode('Propicia el interés por las tutorías.'),1,0,'C');
            $pdf->Cell(50,5,utf8_decode($res->pregunta7),1,1,'C');

            $pdf->Cell(150,5,utf8_decode('Entrega en tiempo y forma la información solicitada de su grupo tutorado. '),1,0,'C');
            $pdf->Cell(50,5,utf8_decode($res->pregunta8),1,1,'C');

            $pdf->Cell(150,5,utf8_decode('Entrega en tiempo y forma los informes de tutorías.'),1,0,'C');
            $pdf->Cell(50,5,utf8_decode($res->pregunta9),1,1,'C');

            $pdf->Cell(150,5,utf8_decode('Resuelve dudas'),1,0,'C');
            $pdf->Cell(50,5,utf8_decode($res->pregunta10),1,1,'C');
            $pdf->Ln(5);
            $pdf->MultiCell(200,5,utf8_decode('Comentario: '.$res->comentario),1);
            $pdf->Ln(50);
            $pdf->Cell(100,5,utf8_decode('Firma del Coordinador'),0,0,'C');
            $pdf->Cell(100,5,utf8_decode('Firma de enterado del Tutor'),0,0,'C');

            $pdf->Output();
            exit();
        }

    }

}
