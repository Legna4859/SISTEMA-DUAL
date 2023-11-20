<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use Session;
class PDF extends FPDF
{

    //CABECERA DE LA PAGINA
    function Header()
    {

    }
    //PIE DE PAGINA
    function Footer()
    {


    }

}
class Ti_pdf_acta_mencionController extends Controller
{
    public function index($id_alumno)

    {
        $mencion_honorifica=DB::selectOne('SELECT * FROM `ti_mencion_honorifica` WHERE id_alumno='.$id_alumno.'');
        $fecha_titulacion=DB::selectOne('SELECT * FROM `ti_fecha_jurado_alumn` WHERE `id_alumno` ='.$id_alumno.'');
        $fecha_titulacion=$fecha_titulacion->fecha_titulacion;
        $year=  substr($fecha_titulacion, 6, 4);
        $pdf = new PDF($orientation = 'P', $unit = 'mm', $format = 'Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0,0,0);

        $pdf->SetFillColor(166,166,166);
        $pdf->SetFont('Arial','B','12');
        $pdf->Ln(8);
        $pdf->Image('img/residencia/rectangulo.png',10,10,120);
        $pdf->SetFont('Arial','B','8');
        $pdf->Cell(20,5,utf8_decode(""),0,0,'');
        $pdf->Cell(20,5,utf8_decode("No. Registro:"),0,0,'');
        $pdf->SetFont('Arial','','8');
        $pdf->Cell(40,5,utf8_decode("MH-".$mencion_honorifica->no_registro."-".$year."-TESVB"),'B',1,'');

        $pdf->SetFont('Arial','B','8');
        $pdf->Cell(20,5,utf8_decode(""),0,0,'');
        $pdf->Cell(27,5,utf8_decode("Fecha de Registro:"),0,0,'');
        $pdf->SetFont('Arial','','8');
        $pdf->Cell(20,5,utf8_decode($fecha_titulacion),'B',1,'');

        $pdf->SetFont('Arial','B','8');
        $pdf->Cell(20,5,utf8_decode(""),0,0,'');
        $pdf->Cell(50,5,utf8_decode("Esta Mención honorifica quedo registrada en el libro"),0,1,'');
        $pdf->SetFont('Arial','B','8');
        $pdf->Cell(20,5,utf8_decode(""),0,0,'');
        $pdf->Cell(50,5,utf8_decode("de Registro No.".$mencion_honorifica->libro_registro." que se encuentra "),0,1,'');
        $pdf->Cell(20,5,utf8_decode(""),0,0,'');
        $pdf->Cell(50,5,utf8_decode("resguardado en el Departamento de Titulación."),0,1,'');
        $pdf->Ln(10);
        $pdf->Cell(20,5,utf8_decode(""),0,0,'');
        $pdf->Cell(50,5,utf8_decode("Sello:."),0,1,'');
        $pdf->Cell(20,3,utf8_decode(""),0,0,'');
        $pdf->SetFont('Arial','','7');
        $pdf->Cell(43,3,utf8_decode("Elaboró:"),0,0,'R');
        $pdf->Cell(37,3,utf8_decode("L. A. Tania Sarahi Garcia Benitez"),"B",1,'C');
        $pdf->Cell(20,3,utf8_decode(""),0,0,'');
        $pdf->SetFont('Arial','B','7');
        $pdf->Cell(36,3,utf8_decode(""),0,0,'R');
        $pdf->Cell(44,3,utf8_decode("Jefa del Departamento de Titulación."),0,1,'C');
        $pdf->Ln(5);
        $pdf->Cell(20,3,utf8_decode(""),0,0,'');
        $pdf->SetFont('Arial','','7');
        $pdf->Cell(45,3,utf8_decode("Revisó:"),0,0,'R');
        $pdf->Cell(35,3,utf8_decode("L. C. Romulo Esquivel Reyes"),"B",1,'C');
        $pdf->Cell(20,3,utf8_decode(""),0,0,'');
        $pdf->SetFont('Arial','B','7');
        $pdf->Cell(40,3,utf8_decode(""),0,0,'R');
        $pdf->Cell(40,3,utf8_decode("Subdirector de Servicios Escolares."),0,1,'C');
        $pdf->Ln(5);
        $pdf->Cell(20,3,utf8_decode(""),0,0,'');
        $pdf->SetFont('Arial','','7');
        $pdf->Cell(45,3,utf8_decode("Autorizó:"),0,0,'R');
        $pdf->Cell(35,3,utf8_decode("Dr. Lázaro Abner Hernández Reyes"),"B",1,'C');
        $pdf->Cell(20,3,utf8_decode(""),0,0,'');
        $pdf->SetFont('Arial','B','7');
        $pdf->Cell(40,3,utf8_decode(""),0,0,'R');
        $pdf->Cell(40,3,utf8_decode("Director Académico."),0,1,'C');


        $pdf->Output();
        exit();

    }
}
