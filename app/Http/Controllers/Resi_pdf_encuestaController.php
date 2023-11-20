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
        $this->Image('img/logo3.PNG', 120, 5, 80);
        $this->Image('img/residencia/log_estado.jpg', 20, 5, 50);
        $this->SetTextColor(128,128,128);
        $this->SetFont('Arial', 'B', '7');
        $this->Ln(10);

    }
    //PIE DE PAGINA
    function Footer()
    {
        $this->SetY(-30);


        $this->Image('img/pie/logos_iso.jpg',40,245,58);
        // $this->Image('img/sgc.PNG',40,240,20);
        // $this->Image('img/tutorias/cir.jpg',89,239,20);
        //  $this->Image('img/sga.PNG',65,240,20);
        $this->SetFont('Arial','B',7);
        $this->Ln(4);
        $this->Cell(50);
        $this->Cell(145,-2,utf8_decode('FO-TESVB-98 V.0 23/03/2018'),0,0,'R');
        $this->Ln(3);
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
        $this->Cell(145,-2,utf8_decode('DEPARTAMENTO DE SERVICIO SOCIAL Y RESIDENCIA PROFESIONAL'),0,0,'R');
        $this->Cell(280);
        $this->SetMargins(0,0,0);
        $this->Ln(0);
        $this->SetXY(38,267);
        $this->SetFillColor(120,120,120);
        $this->SetTextColor(255,255,255);
        $this->SetFont('Arial','B',8);
        $this->Cell(167,4,utf8_decode('      Km. 30 de la Carretera Federal Monumento - Valle de Bravo, Ejido de San Antonio de la Laguna,'),0,0,'L',TRUE);
        $this->Ln(3);
        $this->Cell(38);
        $this->SetFont('Arial','B',8);
        $this->Cell(167,4,utf8_decode('      Valle de Bravo, Estado de México, C.P. 51200.'),0,0,'L',TRUE);
        $this->Ln(3);
        $this->Cell(38);
        $this->SetFont('Arial','',8);
        $this->Cell(167,4,utf8_decode('     Tels.:(726)26 6 52 00, 26 6 51 87 EXT. 144      servicio.social@vbravo.tecnm.mx'),0,0,'L',true);

        $this->Image('img/logos/Mesquina.jpg',0,247,38);
    }
}
class Resi_pdf_encuestaController extends Controller
{
    public function index($id_anteproyecto){
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $alumno = DB::table('gnral_alumnos')
            ->where('gnral_alumnos.id_usuario', '=', $id_usuario)
            ->select('gnral_alumnos.*')
            ->get();
        $id_carrera = $alumno[0]->id_carrera;
        $gnral_carreras = DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera', '=', $id_carrera)
            ->select('gnral_carreras.*')
            ->get();
        $carrera=$gnral_carreras[0]->nombre;
        $encuesta = DB::table('resi_encuesta_residencia')
            ->where('resi_encuesta_residencia.id_anteproyecto', '=', $id_anteproyecto)
            ->select('resi_encuesta_residencia.*')
            ->get();
        $dat_alumnos = mb_strtoupper($alumno[0]->nombre, 'utf-8') . " " . mb_strtoupper($alumno[0]->apaterno, 'utf-8') . " " . mb_strtoupper($alumno[0]->amaterno, 'utf-8');

        $pdf = new PDF($orientation = 'P', $unit = 'mm', $format = 'Letter');

        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(10, 25, 10);
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AddPage();
        $pdf->SetFont('Arial','',12);
        $pdf->Ln(5);
        $pdf->Cell(190,5,utf8_decode("EVALUACIÓN FINAL DE RESIDENCIA PROFESIONAL"),0,0,'C',FALSE);
        $pdf->Ln(10);
        $pdf->SetFont('Arial','',10);
        $pdf->SetTextColor(1,1,1);
        $pdf->Cell(190,5,utf8_decode("NOMBRE COMPLETO:"),0,0,'L',FALSE);
        $pdf->Ln(5);
        $pdf->Cell(190,5,utf8_decode($dat_alumnos),0,0,'L',FALSE);
        $pdf->Ln(5);
        $pdf->Cell(190,5,utf8_decode("CARRERA:"),0,0,'L',FALSE);
        $pdf->Ln(5);
        $pdf->Cell(190,5,utf8_decode($carrera),0,0,'L',FALSE);
        $pdf->Ln(10);
        $pdf->MultiCell(190,5,utf8_decode("Instrucciones: Responda con la mayor sinceridad posible las siguientes preguntas."));
        $pdf->Ln(10);
        $pdf->MultiCell(190,5,utf8_decode("1.- ¿Se te instruyó con el curso de inducción por parte del Departamento de Servicio Social y Residencia Profesional?"),0,'L');
        $pdf->Ln(5);

        $pdf->Cell(190,5,utf8_decode($encuesta[0]->pregunta1),0,0,'C',FALSE);
        $pdf->Ln(8);
        $pdf->MultiCell(190,5,utf8_decode("2.- ¿Se te instruyo en el curso sobre los siguientes aspectos? "));
        $pdf->Ln(5);
        $pdf->Cell(190,5,utf8_decode("          Reglamento de residencia profesional"),0,0,'L',FALSE);
        $pdf->SetX(120);
        $pdf->Cell(190,5,utf8_decode($encuesta[0]->pregunta2),0,0,'L',FALSE);
        $pdf->Ln(8);
        $pdf->Cell(190,5,utf8_decode("          Dependencias para realizar residencia profesional"),0,0,'L',FALSE);
        $pdf->SetX(120);
        $pdf->Cell(190,5,utf8_decode($encuesta[0]->pregunta3),0,0,'L',FALSE);
        $pdf->Ln(8);
        $pdf->Cell(190,5,utf8_decode("          El procedimiento"),0,0,'L',FALSE);
        $pdf->SetX(120);
        $pdf->Cell(190,5,utf8_decode($encuesta[0]->pregunta4),0,0,'L',FALSE);
        $pdf->Ln(8);
        $pdf->Cell(190,5,utf8_decode("          Sistema"),0,0,'L',FALSE);
        $pdf->SetX(120);
        $pdf->Cell(190,5,utf8_decode($encuesta[0]->pregunta5),0,0,'L',FALSE);
        $pdf->Ln(8);
        $pdf->MultiCell(190,5,utf8_decode("3.- En una escala de 0 a100, ¿qué tan satisfecho estas con la asesoría por parte del Asesor Interno?"));
        $pdf->Ln(5);
        $pdf->Cell(190,5,utf8_decode($encuesta[0]->pregunta6),0,0,'C',FALSE);
        $pdf->Ln(8);
        $pdf->MultiCell(190,5,utf8_decode("4.- En una escala de 0 a 100 indica, ¿cuál es tu nivel de satisfacción personal al término de residencia profesional?"));
        $pdf->Ln(5);
        $pdf->Cell(190,5,utf8_decode($encuesta[0]->pregunta7),0,0,'C',FALSE);
        $pdf->Ln(8);
        $pdf->Cell(190,5,utf8_decode("Comentarios:"),0,0,'L',FALSE);
        $pdf->Ln(5);
        $pdf->MultiCell(190,5,utf8_decode($encuesta[0]->comentario));

        $pdf->Ln(10);
        $pdf->Cell(190,5,utf8_decode('Firma del Alumno'),0,0,'C',FALSE);
        $pdf->Output();

        exit();
    }
}
