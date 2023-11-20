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
        $this->Image('img/sgc.PNG',40,240,20);

        $this->Image('img/sga.PNG',65,240,20);
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
class Tu_Eva_pdf_autoevaController extends Controller
{
   public function index(Request $request)
   {
       $id_asigna_tutor = $request->get('id_asigna_tutor');

       $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');

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
                                    WHERE tutor.id_asigna_tutor =  '.$id_asigna_tutor.' ');

        $periodo=Session::get('periodo_actual');
        
        $datos = DB::SELECTONE('SELECT * FROM tu_eva_autoevaluacion where  id_asigna_tutor = '.$id_asigna_tutor.' ');


        //$preguntas = DB::Select('SELECT * FROM tu_eva_formulario_tutor fo, tu_eva_cuestionario eva WHERE fo.id_eva_cuestionario=eva.id_eva_cuestionario and fo.id_asigna_tutor = '.$datos1->id_asigna_tutor.' ');
        $preguntas = DB::Select('SELECT * FROM tu_eva_formulario_tutor fo, tu_eva_cuestionario eva, tu_eva_calificacion_autoeva au WHERE fo.id_eva_cuestionario=eva.id_eva_cuestionario and au.id_calificacion = fo.calificacion  and fo.id_asigna_tutor = '.$id_asigna_tutor.' ORDER BY fo.id_eva_cuestionario  ASC');
        

        $direccion_img=$request->get('dir_imagen');
        //dd($direccion_img);

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
       $pdf->Cell(190,5,utf8_decode('EVALUACION DEL TUTOR'),0,1,'C');
       $pdf->Ln();

       $pdf->Image($direccion_img,20,65,170,70,'PNG');

       $pdf->Cell(190,5,utf8_decode('TUTOR: '.$datos_tutor->nombre),0,1,'C');
       $pdf->Cell(190,5,utf8_decode($datos_tutor->periodo),0,1,'C');
       $pdf->Ln(80);

       $pdf->Cell(10,5,utf8_decode('#'),1,0,'C');
       $pdf->Cell(90,5,utf8_decode('Aspectos Evaluados'),1,0,'C');
       $pdf->Cell(45,5,utf8_decode('Puntuaje'),1,0,'C');
       $pdf->Cell(45,5,utf8_decode('Calificacion'),1,1,'C');
    
       //$satisfacio = $datos[0]->satisfacio;
       
       $ges = '';
       $act = '';
       $dis = '';

       if ($datos->satisfacion >= 1 and $datos->satisfacion<=1.5)
       {
           $ges = 'Insficiente';
       }
       else if ($datos->satisfacion >= 1.6 and $datos->satisfacion<=2.5)
       {
           $ges = 'Suficiente';
       }
       else if ($datos->satisfacion >= 2.6 and $datos->satisfacion<=3.5)
       {
           $ges = 'Bien';
       }
       else if ($datos->satisfacion >= 3.6 and $datos->satisfacion<=4)
       {
           $ges = 'Exelente';
       }



       if ($datos->necesidades >= 1 and $datos->necesidades<=1.5)
       {
           $act = 'Insficiente';
       }
       else if ($datos->necesidades >= 1.6 and $datos->necesidades<=2.5)
       {
           $act = 'Suficiente';
       }
       else if ($datos->necesidades >= 2.6 and $datos->necesidades<=3.5)
       {
           $act = 'Bien';
       }
       else if ($datos->necesidades >= 3.6 and $datos->necesidades<=4)
       {
           $act = 'Exelente';
       }



       if ($datos->factores >= 1 and $datos->factores<=1.5)
       {
           $dis = 'Insficiente';
       }
       else if ($datos->factores >= 1.6 and $datos->factores<=2.5)
       {
           $dis = 'Suficiente';
       }
       else if ($datos->factores >= 2.6 and $datos->factores<=3.5)
       {
           $dis = 'Bien';
       }
       else if ($datos->factores >= 3.6 and $datos->factores<=4)
       {
           $dis = 'Exelente';
       }


       $pdf->Cell(10,5,utf8_decode('A'),1,0,'C');
       $pdf->Cell(90,5,utf8_decode('Satisfacción de su desempeño como tutor'),1,0,'C');
       $pdf->Cell(45,5,utf8_decode( round($datos->satisfacion,2)),1,0,'C');
       $pdf->Cell(45,5,utf8_decode($ges),1,1,'C');

       $pdf->Cell(10,5,utf8_decode('B'),1,0,'C');
       $pdf->Cell(90,5,utf8_decode('Necesidades de fromación'),1,0,'C');
       $pdf->Cell(45,5,utf8_decode( round($datos->necesidades,2) ),1,0,'C');
       $pdf->Cell(45,5,utf8_decode($act),1,1,'C');

       $pdf->Cell(10,5,utf8_decode('C'),1,0,'C');
       $pdf->Cell(90,5,utf8_decode('Factores que afectan mi desempeño como tutor'),1,0,'C');
       $pdf->Cell(45,5,utf8_decode(round($datos->factores,2)),1,0,'C');
       $pdf->Cell(45,5,utf8_decode($dis),1,1,'C');

       $pdf->Ln(10);

        $pdf->Cell(10,5,utf8_decode('#'),1,0,'C');
        $pdf->Cell(135,5,utf8_decode('Aspectos Evaluados'),1,0,'C');
        $pdf->Cell(45,5,utf8_decode('Puntuaje'),1,1,'C');
       /*foreach ($preguntas as $pregunta)
       {
            $pdf->Cell(10,5,utf8_decode($pregunta->id_eva_cuestionario),1,0,'C');
            $pdf->Cell(90,5,utf8_decode($pregunta->descripcion),1,0,'C');
            $pdf->Cell(45,5,utf8_decode($pregunta->cal),1,1,'C');
       }*/
       //dd($preguntas);
       
       $pdf->Cell(10,5,utf8_decode($preguntas[0]->id_eva_cuestionario),1,0,'C');
       $y1 = $pdf->getY();
       $pdf->MultiCell(135,5,utf8_decode($preguntas[0]->descripcion),1);
       $pdf->setXY(155,$y1);
       $pdf->Cell(45,5,utf8_decode($preguntas[0]->cal),1,1,'C');
        
        $pdf->Cell(10,5,utf8_decode($preguntas[1]->id_eva_cuestionario),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode($preguntas[1]->descripcion),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,5,utf8_decode($preguntas[1]->cal),1,1,'C');

        $pdf->Cell(10,5,utf8_decode($preguntas[2]->id_eva_cuestionario),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode($preguntas[2]->descripcion),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,5,utf8_decode($preguntas[2]->cal),1,1,'C');
        
        $pdf->Cell(10,5,utf8_decode($preguntas[3]->id_eva_cuestionario),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode($preguntas[3]->descripcion),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,5,utf8_decode($preguntas[3]->cal),1,1,'C');

        $pdf->Cell(10,5,utf8_decode($preguntas[4]->id_eva_cuestionario),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode($preguntas[4]->descripcion),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,5,utf8_decode($preguntas[4]->cal),1,1,'C');
        
        $pdf->Cell(10,5,utf8_decode($preguntas[5]->id_eva_cuestionario),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode($preguntas[5]->descripcion),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,5,utf8_decode($preguntas[5]->cal),1,1,'C');

        $pdf->Cell(10,5,utf8_decode($preguntas[6]->id_eva_cuestionario),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode($preguntas[6]->descripcion),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,5,utf8_decode($preguntas[6]->cal),1,1,'C');
        
        $pdf->Cell(10,5,utf8_decode($preguntas[7]->id_eva_cuestionario),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode($preguntas[7]->descripcion),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,5,utf8_decode($preguntas[7]->cal),1,1,'C');

        $pdf->Cell(10,5,utf8_decode($preguntas[8]->id_eva_cuestionario),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode($preguntas[8]->descripcion),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,5,utf8_decode($preguntas[8]->cal),1,1,'C');
        
        $pdf->Cell(10,5,utf8_decode($preguntas[9]->id_eva_cuestionario),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode($preguntas[9]->descripcion),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,5,utf8_decode($preguntas[9]->cal),1,1,'C');

        $pdf->Cell(10,5,utf8_decode($preguntas[10]->id_eva_cuestionario),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode($preguntas[10]->descripcion),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,5,utf8_decode($preguntas[10]->cal),1,1,'C');
        
        $pdf->Cell(10,5,utf8_decode($preguntas[11]->id_eva_cuestionario),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode($preguntas[11]->descripcion),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,5,utf8_decode($preguntas[11]->cal),1,1,'C');

        $pdf->AddPage();

        $pdf->SetMargins(10, 30 , 10, 30);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->SetDrawColor(164,164,164);
        $pdf->SetLineWidth(1.0);
        $pdf->Line(231, 10, 231, 32);
        $pdf->SetFont('Arial','',8);

        $pdf->Ln(20);

        $pdf->Cell(10,5,utf8_decode($preguntas[12]->id_eva_cuestionario),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode($preguntas[12]->descripcion),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,5,utf8_decode($preguntas[12]->cal),1,1,'C');
        
        $pdf->Cell(10,10,utf8_decode($preguntas[13]->id_eva_cuestionario),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode($preguntas[13]->descripcion),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,10,utf8_decode($preguntas[13]->cal),1,1,'C');

        $pdf->Cell(10,5,utf8_decode($preguntas[14]->id_eva_cuestionario),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode($preguntas[14]->descripcion),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,5,utf8_decode($preguntas[14]->cal),1,1,'C');
        
        $pdf->Cell(10,5,utf8_decode($preguntas[15]->id_eva_cuestionario),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode($preguntas[15]->descripcion),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,5,utf8_decode($preguntas[15]->cal),1,1,'C');

        $pdf->Cell(10,5,utf8_decode($preguntas[16]->id_eva_cuestionario),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode($preguntas[16]->descripcion),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,5,utf8_decode($preguntas[16]->cal),1,1,'C');
        
        $pdf->Cell(10,10,utf8_decode($preguntas[17]->id_eva_cuestionario),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode($preguntas[17]->descripcion),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,10,utf8_decode($preguntas[17]->cal),1,1,'C');
        
        $pdf->Cell(10,5,utf8_decode($preguntas[18]->id_eva_cuestionario),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode($preguntas[18]->descripcion),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,5,utf8_decode($preguntas[18]->cal),1,1,'C');
        
        $pdf->Cell(10,5,utf8_decode($preguntas[19]->id_eva_cuestionario),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode($preguntas[19]->descripcion),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,5,utf8_decode($preguntas[19]->cal),1,1,'C');

        $pdf->Cell(10,5,utf8_decode($preguntas[20]->id_eva_cuestionario),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode($preguntas[20]->descripcion),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,5,utf8_decode($preguntas[20]->cal),1,1,'C');
        
        $pdf->Cell(10,5,utf8_decode($preguntas[21]->id_eva_cuestionario),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode($preguntas[21]->descripcion),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,5,utf8_decode($preguntas[21]->cal),1,1,'C');

        $pdf->Cell(10,5,utf8_decode($preguntas[22]->id_eva_cuestionario),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode($preguntas[22]->descripcion),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,5,utf8_decode($preguntas[22]->cal),1,1,'C');
        
        $pdf->Cell(10,5,utf8_decode($preguntas[23]->id_eva_cuestionario),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode($preguntas[23]->descripcion),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,5,utf8_decode($preguntas[23]->cal),1,1,'C');

        $pdf->ln(5);
        if ($datos->comentario == "") {
            
        }
        else{
            $pdf->MultiCell(190,5,utf8_decode('Comentario: '.$datos->comentario),1);
        }

        /*
        $pdf->Cell(10,10,utf8_decode('2'),1,0,'C');
        $y1 = $pdf->getY();
        $pdf->MultiCell(135,5,utf8_decode('Considero que las herramientas con las que se cuentan son suficientes para poder atender las situaciones planteadas por mis tutorados'),1);
        $pdf->setXY(155,$y1);
        $pdf->Cell(45,10,utf8_decode(''),1,1,'C');
       */

       /////////////////////////////////////////////////////////
       $pdf->Output();
       exit();
   }
}
