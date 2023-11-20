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
        $this->Cell(145,-2,utf8_decode('DEPARTAMENTO DE DESARROLLO'),0,0,'R');
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
class Tu_Eva_pdf_graficaController extends Controller
{
   public function index(Request $request)
   {
       $id_asigna_tutor = $request->get('id_asigna_tutor');

       $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');

       $datos_tutor= DB::selectOne('SELECT datos.nombre, grupo.descripcion grupo, carrera.nombre carrera, per.periodo  FROM gnral_personales datos
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

       $datos = DB::selectOne('SELECT tu_grupo_s.id_grupo_semestre,car.nombre carrera, tu_grupo_t.descripcion grupo, gnral_p.nombre nombre_tutor,exp_asigna_t.id_asigna_tutor,
                                ( (sum(gestion)*4)/ (COUNT(form.id_eva_resultado)*16) ) gestion , 
                                ( (sum(actitud)*4)/ (COUNT(form.id_eva_resultado)*28) ) actitud, 
                                ( (sum(disponibilidad_confianza)*4)/(COUNT(form.id_eva_resultado)*20) ) disponibilidad_confianza,
                                ( (sum(servicios_del_programa_de_tutoria)*4 )/( COUNT(form.id_eva_resultado)*24 ) )servicios_del_programa_de_tutoria,
                                ( (sum(tus_logros_y_avances)*4 )/( COUNT(form.id_eva_resultado)*36 ) ) tus_logros_y_avances
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
                                INNER JOIN tu_eva_resultados_formulario form
                                ON form.id_asigna_tutor=exp_asigna_t.id_asigna_tutor
                                WHERE exp_asigna_t.id_asigna_tutor =  '.$id_asigna_tutor.'  ');
       //dd($datos);
       $promeio = ($datos->gestion + $datos->actitud + $datos->disponibilidad_confianza + $datos->servicios_del_programa_de_tutoria + $datos->tus_logros_y_avances)/5;
       //dd($promeio);
       $direccion_img=$request->get('dir_imagen');
       // dd($direccion_img);

       if ($datos->gestion >= 1 and $datos->gestion<=1.6)
       {
           $ges = 'Insuficiente';
       }
       else if ($datos->gestion >= 1.6 and $datos->gestion<=2.6)
       {
           $ges = 'Suficiente';
       }
       else if ($datos->gestion >= 2.6 and $datos->gestion<=3.6)
       {
           $ges = 'Bien';
       }
       else if ($datos->gestion >= 3.6 and $datos->gestion<=4)
       {
           $ges = 'Excelente';
       }

       if ($datos->actitud >= 1 and $datos->actitud<=1.6)
       {
           $act = 'Insuficiente';
       }
       else if ($datos->actitud >= 1.6 and $datos->actitud<=2.6)
       {
           $act = 'Suficiente';
       }
       else if ($datos->actitud >= 2.6 and $datos->actitud<=3.6)
       {
           $act = 'Bien';
       }
       else if ($datos->actitud >= 3.6 and $datos->actitud<=4)
       {
           $act = 'Excelente';
       }

       if ($datos->disponibilidad_confianza >= 1 and $datos->disponibilidad_confianza<=1.6)
       {
           $dis = 'Insuficiente';
       }
       else if ($datos->disponibilidad_confianza >= 1.6 and $datos->disponibilidad_confianza<=2.6)
       {
           $dis = 'Suficiente';
       }
       else if ($datos->disponibilidad_confianza >= 2.6 and $datos->disponibilidad_confianza<=3.6)
       {
           $dis = 'Bien';
       }
       else if ($datos->disponibilidad_confianza >= 3.6 and $datos->disponibilidad_confianza<=4)
       {
           $dis = 'Excelente';
       }

       if ($datos->servicios_del_programa_de_tutoria >= 1 and $datos->servicios_del_programa_de_tutoria<=1.6)
       {
           $ser = 'Insuficiente';
       }
       else if ($datos->servicios_del_programa_de_tutoria >= 1.6 and $datos->servicios_del_programa_de_tutoria<=2.6)
       {
           $ser = 'Suficiente';
       }
       else if ($datos->servicios_del_programa_de_tutoria >= 2.6 and $datos->servicios_del_programa_de_tutoria<=3.6)
       {
           $ser = 'Bien';
       }
       else if ($datos->servicios_del_programa_de_tutoria >= 3.6 and $datos->servicios_del_programa_de_tutoria<=4)
       {
           $ser = 'Excelente';
       }

       if ($datos->tus_logros_y_avances >= 1 and $datos->tus_logros_y_avances<=1.6)
       {
           $tus = 'Insuficiente';
       }
       else if ($datos->tus_logros_y_avances >= 1.6 and $datos->tus_logros_y_avances<=2.6)
       {
           $tus = 'Suficiente';
       }
       else if ($datos->tus_logros_y_avances >= 2.6 and $datos->tus_logros_y_avances<=3.6)
       {
           $tus = 'Bien';
       }
       else if ($datos->tus_logros_y_avances >= 3.6 and $datos->tus_logros_y_avances<=4)
       {
           $tus = 'Excelente';
       }

       if ($promeio >= 1 and $promeio<=1.6)
       {
           $pro = 'Insuficiente';
       }
       else if ($promeio >= 1.6 and$promeio<=2.6)
       {
           $pro = 'Suficiente';
       }
       else if ($promeio >= 2.6 and $promeio<=3.6)
       {
           $pro = 'Bien';
       }
       else if ($promeio >= 3.6 and $promeio<=4)
       {
           $pro = 'Excelente';
       }

       //dd($hola);
       //$condi=$request->get('condi');
       $pdf=new PDF($orientation='P',$unit='mm',$format='Letter');
       #Establecemos los márgenes izquierda, arriba y derecha:
       //dd($request);

       //$nombre = 'Tutor: '.$datos_tutor->nombre;
       //dd($nombre);
       $pdf->SetMargins(10, 25 , 0);
       $pdf->SetAutoPageBreak(true,25);
       $pdf->AddPage();
       $pdf->SetDrawColor(164,164,164);
       $pdf->SetLineWidth(1.0);
       $pdf->Line(231, 10, 231, 32);
       $pdf->SetFont('Arial','',8);
       //$pdf->Ln();
       $pdf->Cell(190,5,utf8_decode('EVALUACION DEL TUTOR'),0,1,'C');
       $pdf->Ln();

       $pdf->Cell(190,5,utf8_decode('TUTOR: '.$datos_tutor->nombre),0,1,'C');
       $pdf->Cell(190,5,utf8_decode('GRUPO: '.$datos_tutor->grupo),0,1,'C');
       $pdf->Cell(190,5,utf8_decode($datos_tutor->carrera),0,1,'C');
       $pdf->Cell(190,5,utf8_decode($datos_tutor->periodo),0,1,'C');
       $pdf->Ln(5);

       $pdf->Cell(10,5,utf8_decode('#'),1,0,'C');
       $pdf->Cell(90,5,utf8_decode('Aspectos Evaluados'),1,0,'C');
       $pdf->Cell(45,5,utf8_decode('Puntuaje'),1,0,'C');
       $pdf->Cell(45,5,utf8_decode('Calificación'),1,1,'C');

       $pdf->Cell(10,5,utf8_decode('A'),1,0,'C');
       $pdf->Cell(90,5,utf8_decode('Percepción respecto a tu tutor(a) en la gestión'),1,0,'C');
       $pdf->Cell(45,5,utf8_decode( round($datos->gestion,2)),1,0,'C');
       $pdf->Cell(45,5,utf8_decode($ges),1,1,'C');

       $pdf->Cell(10,5,utf8_decode('B'),1,0,'C');
       $pdf->Cell(90,5,utf8_decode('Percepción respecto a tu tutor(a) en la Actitud'),1,0,'C');
       $pdf->Cell(45,5,utf8_decode( round($datos->actitud,2) ),1,0,'C');
       $pdf->Cell(45,5,utf8_decode($act),1,1,'C');

       $pdf->Cell(10,5,utf8_decode('C'),1,0,'C');
       $pdf->Cell(90,5,utf8_decode('Percepción respecto a tu tutor(a) en la disponibilidad y confianza'),1,0,'C');
       $pdf->Cell(45,5,utf8_decode(round($datos->disponibilidad_confianza,2)),1,0,'C');
       $pdf->Cell(45,5,utf8_decode($dis),1,1,'C');

       $pdf->Cell(10,5,utf8_decode('D'),1,0,'C');
       $pdf->Cell(90,5,utf8_decode('Percepción respecto a los servicios del programa de Tutoría'),1,0,'C');
       $pdf->Cell(45,5,utf8_decode(round($datos->servicios_del_programa_de_tutoria,2)),1,0,'C');
       $pdf->Cell(45,5,utf8_decode($ser),1,1,'C');

       $pdf->Cell(10,5,utf8_decode('E'),1,0,'C');
       $pdf->Cell(90,5,utf8_decode('Percepción respecto a tus logros y avances'),1,0,'C');
       $pdf->Cell(45,5,utf8_decode(round($datos->tus_logros_y_avances,2)),1,0,'C');
       $pdf->Cell(45,5,utf8_decode($tus),1,1,'C');

       $pdf->Cell(100,5,utf8_decode('Promedio'),1,0,'C');
       $pdf->Cell(45,5,utf8_decode(round($promeio,2)),1,0,'C');
       $pdf->Cell(45,5,utf8_decode($pro),1,1,'C');

       $pdf->Image($direccion_img,20,130,170,70,'PNG');
       /////////////////////////////////////////////////////////
       $pdf->Output();
       exit();
   }
}
