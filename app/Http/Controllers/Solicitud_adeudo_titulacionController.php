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
        $this->Image('img/logo3.PNG', 125, 10, 75);
        $this->Image('img/logos/Captura.PNG',85,10,30);
        $this->Image('img/gem.png',20,5,25);
        $this->Ln(2);
        $this->SetFont('Arial','',8);
        $etiqueta=DB::table('etiqueta')
            ->where('id_etiqueta','=',1)
            ->select('etiqueta.descripcion')
            ->get();
        $etiqueta=$etiqueta[0]->descripcion;
        $this->Cell(175,5,utf8_decode($etiqueta),0,1,'C',FALSE);
        $this->Ln(0);
    }
    //PIE DE PAGINA
    function Footer()
    {

        $this->SetY(-28);
        $this->SetFont('Arial','',8);
        //$this->Image('img/sgc.PNG',40,245,18);
        $this->Image('img/pie/logos_iso.jpg',40,243,60);
        //$this->Image('img/sga.PNG',65,245,18);
       // $this->Image('img/tutorias/cir.jpg',85,245,18);
        $this->Cell(80);
        $this->Cell(110,-2,utf8_decode('FO-TESVB-81 V.2 15/12/2020'),0,0,'R');
        $this->Ln(3);
        $this->Cell(80);
        $this->Cell(110,-2,utf8_decode('SECRETARÍA DE EDUCACIÓN'),0,0,'R');
        $this->Ln(3);
        $this->Cell(80);
        $this->Cell(110,-2,utf8_decode('SUBSECRETARÍA DE EDUCACIÓN SUPERIOR Y NORMAL'),0,0,'R');
        $this->Ln(3);
        $this->Cell(80);
        $this->Cell(110,-2,utf8_decode('TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO'),0,0,'R');
        $this->Ln(3);
        $this->Cell(80);
        $this->Cell(110,-2,utf8_decode('DEPARTAMENTO DE TITULACIÓN'),0,0,'R');
        $this->Cell(280);
        $this->SetMargins(0,0,0);
        $this->Ln(0);
        $this->SetXY(17,266);
        $this->SetFillColor(120,120,120);
        $this->Cell(20,10,'',0,0,'',TRUE);
        $this->SetTextColor(255,255,255);
        $this->Cell(175,10,utf8_decode('Km. 30 de la Carretera Federal Monumento - Valle de Bravo, Ejido de San Antonio de la Laguna,'),0,0,'L',TRUE);
        $this->Ln(3);
        $this->Cell(35);
        $this->Cell(160,10,utf8_decode(' Valle de Bravo, Estado de México, C.P. 51200.    Tels.: (726)26 6 52 00,26 6 51 87 Ext 117                             titulacion@vbravo.tecnm.mx'),0,0,'L');

        $this->Image('img/logos/Mesquina.jpg',0,252,30);

    }

}
class Solicitud_adeudo_titulacionController extends Controller
{
    public  function index($id_alumno){
        $alumno=DB::table('gnral_alumnos')
             ->where('gnral_alumnos.id_alumno','=',$id_alumno)
            ->select('gnral_alumnos.*')
            ->get();
        $cuenta=mb_strtoupper($alumno[0]->cuenta,'utf-8');
        $nombre_alumno=mb_strtoupper($alumno[0]->apaterno,'utf-8')." ".mb_strtoupper($alumno[0]->amaterno,'utf-8')." ".mb_strtoupper($alumno[0]->nombre,'utf-8');

        $fechas = date("Y-m-d");
        $num=date("j",strtotime($fechas));
        $ano=date("Y", strtotime($fechas));
        $mes= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes=$mes[(date('m', strtotime($fechas))*1)-1];
        if($num == 1)
        {
            $fech= 'al '.$num.' dia  del mes '.$mes.' del año '.$ano;
        }
        else{
            $fech='a los '. $num.' dias del mes '.$mes.' del año '.$ano;
        }
        $pdf=new PDF($orientation='P',$unit='mm',$format='Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(20, 25 , 20);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();
        $pdf->SetFillColor(166,166,166);
        $pdf->SetFont('Arial','B','12');
        $pdf->Ln(10);
        $pdf->Cell(175,5,utf8_decode("DT/".$ano),0,1,'R');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','B','20');
        $pdf->Cell(175,10,utf8_decode("CONSTANCIA DE NO ADEUDO"),0,1,'C');
        $pdf->SetFont('Arial','','12');
        $pdf->Cell(71);
        $pdf->Cell(5,5,utf8_decode("T"),0,0,'C');
        $pdf->Cell(5,5,utf8_decode("X"),1,0,'C');
        $pdf->Cell(5,5,utf8_decode("C"),0,0,'C');
        $pdf->Cell(5,5,utf8_decode(" "),1,0,'C');
        $pdf->Cell(8,5,utf8_decode("CR"),0,0,'C');
        $pdf->Cell(5,5,utf8_decode(" "),1,1,'C');
        $pdf->Ln(10);
        $texto="El Tecnológico de Estudios Superiores de Valle de Bravo hace constar que el (la) C. ".$nombre_alumno." con número de cuenta ".$cuenta.", es egresado (a) de esta institución, y no presenta adeudos en las áreas de: Dirección General, Direcciones de Área, Subdirecciones, Jefaturas de División, Bolsa de Trabajo y Seguimiento de Egresados, Jefaturas de Departamento, Centro de Información y Centro de Cómputo.";

        $pdf->MultiCell(175,5,utf8_decode($texto),0,'J');
        $pdf->Ln(10);
        $pdf->MultiCell(175,5,utf8_decode("Se extiende la presente a petición del interesado (a) en la Ciudad Típica de Valle de Bravo, Estado de México; ".$fech."."),0,'J');
        $pdf->Ln(15);
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(175,10,utf8_decode("ATENTAMENTE"),0,1,'C');
        $pdf->Ln(15);
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(175,5,utf8_decode("L. A. TANIA SARAHI GARCÍA BENÍTEZ"),0,1,'C');
        $pdf->Cell(175,5,utf8_decode("DEPARTAMENTO  DE TITULACIÓN"),0,1,'C');
        $pdf->Output();
        exit();

    }
}
