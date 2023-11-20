<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
class PDF extends FPDF
{

    //CABECERA DE LA PAGINA
    function Header()
    {
        $this->Image('img/logo3.PNG',120,5,80);
        $this->Image('img/edom.png',20,5,50);
        $this->Ln();
    }
    //PIE DE PAGINA
    function Footer()
    {
        $this->SetY(-25);
        $this->SetFont('Arial','',6);
        $this->Cell(100);
        $this->Image('img/logos/prorroga.PNG', 15, 240, 190);
    }

}
class Prorroga_pdf_solicitudController extends Controller
{
    public function index($id_alumno){
        $id_periodo=Session::get('periodo_actual');


        $datosalumno= DB::table('gnral_alumnos')
            ->join('gnral_carreras','gnral_carreras.id_carrera','=','gnral_alumnos.id_carrera')
            ->join('gnral_semestres','gnral_semestres.id_semestre','=','gnral_alumnos.id_semestre')
            ->select('gnral_alumnos.*','gnral_semestres.descripcion as semestre','gnral_carreras.nombre as carrera')
            ->where('id_alumno', '=', $id_alumno)
            ->get();
        $semestres = DB::table('gnral_semestres')->get();
        $nombre_alumno = mb_strtoupper($datosalumno[0]->nombre, 'utf-8')." ".mb_strtoupper($datosalumno[0]->apaterno, 'utf-8') . " " . mb_strtoupper($datosalumno[0]->amaterno, 'utf-8');
        $carrera =$datosalumno[0]->carrera;
        $no_cuenta=$datosalumno[0]->cuenta;
        $id_alumno=$datosalumno[0]->id_alumno;
        $prorroga_solicitudes=DB::selectOne('SELECT prorroga_solicitudes.*,gnral_semestres.descripcion semestre
 FROM `prorroga_solicitudes`,gnral_semestres WHERE prorroga_solicitudes.id_semestre=gnral_semestres.id_semestre and 
  prorroga_solicitudes.id_alumno = '.$id_alumno.' AND prorroga_solicitudes.id_periodo = '.$id_periodo.'');
        $pdf=new PDF($orientation='P',$unit='mm',$format='Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(20, 25 , 20);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetLineWidth(0.2);

        $pdf->Ln(10);
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(180,5,utf8_decode('L. C. MA. ESTHER RODRIGUEZ GÓMEZ'),0,1,'L');
        $pdf->Cell(180,5,utf8_decode('DIRECTORA GENERAL DEL TECNOLÓGICO '),0,1,'L');
        $pdf->Cell(180,5,utf8_decode('DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO.'),0,1,'L');
        $pdf->Cell(180,5,utf8_decode('P R E S E N T E '),0,1,'L');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','','11');
        $pdf->MultiCell(175,6,utf8_decode("El que suscribe ".$nombre_alumno." estudiante de la carrera de ".$carrera." con número de cuenta ".$no_cuenta.", por este medio, se dirige a usted, para solicitar me autorice la prórroga de pago de la colegiatura semestral al ".$prorroga_solicitudes->semestre." semestre, mi compromiso es efectuar el depósito correspondiente a más tardar el día ".$prorroga_solicitudes->fecha_efectuar."."),0, 'J');
        $pdf->Ln(3);
        $pdf->MultiCell(175,6,utf8_decode("Estoy consciente que de no realizar el trámite en la fecha pactada se procederá a la suspensión de mis derechos como estudiante y este mismo documento fungirá como solicitud de baja temporal."),0, 'J');
        $pdf->Ln(3);
        $pdf->MultiCell(175,6,utf8_decode("Sin otro particular por el momento, agradezco la atención que se sirva dar a la presente solicitud."),0, 'J');
        $pdf->Ln(3);
        $pdf->Cell(175,20,utf8_decode('ATENTAMENTE'),0,1,'C');
        $pdf->Cell(175,5,utf8_decode('________________________'),0,1,'C');
        $pdf->Cell(175,5,utf8_decode($nombre_alumno),0,1,'C');
        $pdf->Ln(5);
        $pdf->Cell(87,10,utf8_decode("REVISÓ"),'LTR',0,'C');
        $pdf->Cell(88,10,utf8_decode("AUTORIZO"),'LTR',1,'C');
        $pdf->Cell(87,10,utf8_decode(""),'LR',0,'C');
        $pdf->Cell(88,10,utf8_decode(""),'LR',1,'C');
        $pdf->Cell(87,5,utf8_decode("_________________________"),'LR',0,'C');
        $pdf->Cell(88,5,utf8_decode("_________________________"),'LR',1,'C');
        $pdf->Cell(87,10,utf8_decode("DIRECCIÓN ACADÉMICA"),'LBR',0,'C');
        $pdf->Cell(88,10,utf8_decode("DIRECCIÓN GENERAL"),'LBR',1,'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','7');
        $pdf->Cell(180,5,utf8_decode('c.c.p.- L. C Rómulo Esquivel Reyes - Subdirección de Servicios Escolares'),0,1,'L');
        $pdf->Output();

        exit();

    }
}
