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
        $this->Image('img/logo3.PNG', 115, 10, 80);
        $this->Image('img/logos/ArmasBN.png',20,10,60);
        $this->Ln(10);
    }
    //PIE DE PAGINA
    function Footer()
    {

        $this->SetY(-35);
        $this->SetFont('Arial','',8);
        $this->Image('img/pie/logos_iso.jpg',40,240,60);
       // $this->Image('img/sgc.PNG',40,240,20);

        //$this->Image('img/sga.PNG',65,240,20);
        $this->Cell(50);
        $this->Cell(145,-2,utf8_decode('FO-TESVB-62 V.2 30/06/2022'),0,0,'R');
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
        $this->Cell(145,-2,utf8_decode('DEPARTAMENTO DE TITULACIÓN'),0,0,'R');
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
        $this->Cell(165,4,utf8_decode('     Tels.:(726)26 6 52 00, 26 6 50 77,26 6 51 87 Ext 117      titulacion@vbravo.tecnm.mx'),0,0,'L',true);

        $this->Image('img/logos/Mesquina.jpg',0,240,40);
    }

}
class Ti_proyecto_titulacionController extends Controller
{
    public function index($id_alumno){
        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');

        $pdf = new PDF($orientation = 'P', $unit = 'mm', $format = 'Letter');
        $fechas = date("Y-m-d");

        $num=date("j",strtotime($fechas));
        $ano=date("Y", strtotime($fechas));
        $mes= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes=$mes[(date('m', strtotime($fechas))*1)-1];
        $fech= $num. ' de '.$mes.' del '.$ano;


        $alumno=DB::selectOne('SELECT ti_reg_datos_alum.*,gnral_carreras.nombre carrera FROM ti_reg_datos_alum,gnral_carreras WHERE ti_reg_datos_alum.id_carrera = gnral_carreras.id_carrera and  ti_reg_datos_alum.id_alumno ='.$id_alumno.'');
        $nombre_alumno=$alumno->nombre_al." ".$alumno->apaterno." ".$alumno->amaterno;
        $carrera=$alumno->carrera;
        $cuenta=$alumno->no_cuenta;
        $opcion_titulacion=DB::selectOne('SELECT * FROM `ti_opciones_titulacion` WHERE `id_opcion_titulacion` ='.$alumno->id_opcion_titulacion.'');
        $opcion_titulacion=$opcion_titulacion->opcion_titulacion;

        $jefe_titulacion=$alumno->nombre_jefe_titulacion;
      $jefe_division=$alumno->nombre_jefe_division;
      $nombre_proyecto=$alumno->nom_proyecto;


        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(10, 15, 10);
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0,0,0);

        $pdf->SetFillColor(166,166,166);
        $pdf->SetFont('Arial','B','8');
        $pdf->Ln(10);
        $pdf->Cell(190,5,utf8_decode($etiqueta->descripcion),0,1,'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','10');
        $pdf->Cell(190,5,utf8_decode("Valle de Bravo, Méx a ".$fech),0,1,'R');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','10');
        $pdf->Cell(190,5,utf8_decode("LIBERACIÓN PARA PROYECTO DE TITULACIÓN Y TITULACIÓN INTEGRAL"),0,1,'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','11');
        $pdf->Cell(190,5,utf8_decode($jefe_titulacion),0,1,'');
        $pdf->Cell(190,5,utf8_decode("JEFE(A) DEL DEPARTAMENTO DE TITULACIÓN"),0,1,'');
        $pdf->Cell(190,5,utf8_decode("PRESENTE:"),0,1,'');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','','11');
        $pdf->MultiCell(190,5,utf8_decode("Por este medio le informo que ha sido liberado el siguiente proyecto para la Titulación integral"));
        $pdf->Ln(10);
        $pdf->Cell(45,5,utf8_decode("Nombre del egresado(a):"),1,0,'R');
        $pdf->Cell(145,5,utf8_decode($nombre_alumno),1,1,'');
        $pdf->Cell(45,5,utf8_decode("Programa de estudio:"),1,0,'R');
        $pdf->Cell(145,5,utf8_decode($carrera),1,1,'');
        $pdf->Cell(45,5,utf8_decode("No. de control:"),1,0,'R');
        $pdf->Cell(145,5,utf8_decode($cuenta),1,1,'');
        $y=$pdf->GetY();
        $pdf->Cell(45,15,utf8_decode("Nombre del proyecto:"),1,0,'R');
        $pdf->Cell(145,15,utf8_decode(""),1,1,'');
        $pdf->Cell(45,5,utf8_decode("Producto:"),1,0,'R');
        $pdf->Cell(145,5,utf8_decode($opcion_titulacion),1,1,'');
        $pdf->Ln(10);
        $pdf->MultiCell(190,5,utf8_decode("Agradezco de antemano su valioso apoyo en esta importante actividad para la formación profesional de nuestros egresados(as)."));
        $pdf->Ln(10);
        $pdf->Cell(190,5,utf8_decode("ATENTAMENTE"),0,1,'C');
        $pdf->Ln(15);
        $pdf->Cell(40,5,utf8_decode(""),0,0,'C');
        $pdf->Cell(110,5,utf8_decode($jefe_division),"B",1,'C');
        $pdf->Cell(40,5,utf8_decode(""),0,0,'C');
        $pdf->MultiCell(110,5,utf8_decode("JEFE(A) DE DIVISIÓN DE ".$carrera),0,'C');
        $pdf->Ln(5);
        $pdf->Cell(20,15,utf8_decode(""),0,0,'C');
        $pdf->Cell(75,15,utf8_decode(""),"LTR",0,'C');
        $pdf->Cell(75,15,utf8_decode(""),"LTR",1,'C');
        $pdf->Cell(20,5,utf8_decode(""),0,0,'C');
        $pdf->Cell(5,5,utf8_decode(""),"L",0,'C');
        $pdf->Cell(65,5,utf8_decode(""),"B",0,'C');
        $pdf->Cell(5,5,utf8_decode(""),"R",0,'C');
        $pdf->Cell(5,5,utf8_decode(""),"L",0,'C');
        $pdf->Cell(65,5,utf8_decode(""),"B",0,'C');
        $pdf->Cell(5,5,utf8_decode(""),"R",1,'C');
        $pdf->Cell(20,20,utf8_decode(""),0,0,'C');
        $pdf->Cell(75,5,utf8_decode("Nombre de asesor(a)"),"LBR",0,'C');
        $pdf->Cell(75,5,utf8_decode("Nombre del Revisor(a)"),"LBR",1,'C');
        $pdf->SetXY(55,$y);
        $pdf->MultiCell(145,5,utf8_decode($nombre_proyecto),0,'J');
        $pdf->Output();
        exit();
    }
}
