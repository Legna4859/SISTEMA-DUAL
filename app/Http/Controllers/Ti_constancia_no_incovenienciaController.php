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
        $this->Image('img/logo3.PNG', 130, 10, 60);
        $this->Image('img/logos/ArmasBN.png',30,10,40);
        $this->Image('img/tutorias/tecnm.jpg',80,10,25);
        $this->Ln(10);
    }
    //PIE DE PAGINA
    function Footer()
    {


    }

}
class Ti_constancia_no_incovenienciaController extends Controller
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

        $nombre_proyecto=$alumno->nom_proyecto;

        $jefe_titulacion=$alumno->nombre_jefe_titulacion;
        $jefe_division=$alumno->nombre_jefe_division;
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(25, 15, 25);
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0,0,0);

        $pdf->SetFillColor(166,166,166);
        $pdf->SetFont('Arial','B','8');
        $pdf->Ln(10);
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(160,5,utf8_decode("CONSTANCIA DE NO INCONVENIENCIA"),0,1,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','','10');
        $pdf->Cell(160,5,utf8_decode("Valle de Bravo, Méx a ".$fech),0,1,'');
        $pdf->Ln(5);
        $pdf->Cell(160,5,utf8_decode("C. ".$nombre_alumno),0,1,'');
        $pdf->Cell(20,5,utf8_decode(""),0,0,'');
        $pdf->Cell(160,5,utf8_decode("Egresado"),0,1,'');
        $pdf->Ln(15);
        $pdf->MultiCell(160,5,utf8_decode("Me permito informarle de acuerdo a su solicitud, que no existe incoveniente para que pueda Ud. Presentar su Acto Protocolario ya que su expediente quedo integrado para tal efecto. "));
        $pdf->Ln(45);
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(160,5,utf8_decode("ATENTAMENTE"),0,1,'C');
        $pdf->Ln(15);
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(160,5,utf8_decode($jefe_titulacion),0,1,'C');
        $pdf->Cell(160,5,utf8_decode("JEFE(A) DEL DEPARTAMENTO DE TITULACIÓN"),0,1,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','','9');
        $pdf->Cell(150,5,utf8_decode("C. c.p.-Archivo"),0,1,'');
        $pdf->Cell(10,5,utf8_decode(""),0,0,'');
        $pdf->Cell(170,5,utf8_decode("TSGB"),0,1,'');

        $pdf->Output();
        exit();
    }
}
