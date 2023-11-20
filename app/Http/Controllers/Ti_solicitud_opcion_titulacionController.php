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
        $this->Image('img/pie/logos_iso.jpg',40,240,60);
       // $this->Image('img/sgc.PNG',40,240,20);
        //$this->Image('img/tutorias/cir.jpg',89,239,20);
       // $this->Image('img/sga.PNG',65,240,20);
        $this->Cell(50);
        $this->Cell(145,-2,utf8_decode('FO-TESVB-101 V.3 30/06/2022'),0,0,'R');
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
class Ti_solicitud_opcion_titulacionController extends Controller
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

        $domicilio=DB::selectOne('SELECT gnral_estados.nombre_estado,gnral_municipios.nombre_municipio 
FROM gnral_estados, gnral_municipios,ti_reg_datos_alum WHERE gnral_estados.id_estado=gnral_municipios.id_estado 
    and ti_reg_datos_alum.municipio_domicilio=gnral_municipios.id_municipio and ti_reg_datos_alum.municipio_domicilio='.$alumno->municipio_domicilio.'');

        $municipio=$domicilio->nombre_estado;
        $estado=$domicilio->nombre_estado;

        $domi=$alumno->numero_domicilio.", ".$alumno->calle_domicilio.", ".$alumno->colonia_domicilio.", ".$municipio.", ".$estado;
        $telefono=$alumno->telefono;
        $correo=$alumno->correo_electronico;

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
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(190,5,utf8_decode("Solicitud de Opción de Titulación y Titulación Integral"),0,1,'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','10');
        $pdf->Cell(190,5,utf8_decode("Valle de Bravo Estado de México, a ".$fech),0,1,'R');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','11');
        $pdf->MultiCell(190,5,utf8_decode("Por medio del presente solicito autorización para iniciar Trámites de Titulación, por la opción de: ".$opcion_titulacion."."),0,'J');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','11');
        $pdf->Cell(47,5,utf8_decode("Nombre del egresado(a):"),1,0,'');
        $pdf->SetFont('Arial','','11');
        $pdf->Cell(143,5,utf8_decode($nombre_alumno),1,1,'');
        $pdf->SetFont('Arial','B','11');
        $pdf->Cell(47,5,utf8_decode("Programa de estudio:"),1,0,'');
        $pdf->SetFont('Arial','','11');
        $pdf->Cell(143,5,utf8_decode($carrera),1,1,'');
        $pdf->SetFont('Arial','B','11');
        $pdf->Cell(47,5,utf8_decode("No. de control:"),1,0,'');
        $pdf->SetFont('Arial','','11');
        $pdf->Cell(143,5,utf8_decode($cuenta),1,1,'');

        $y=$pdf->GetY();

        $pdf->SetFont('Arial','B','11');
        $pdf->Cell(47,15,utf8_decode("Nombre del proyecto:"),1,0,'');
        $pdf->Cell(143,15,utf8_decode(""),1,1,'');
        $pdf->SetFont('Arial','B','11');
        $pdf->Cell(47,5,utf8_decode("Producto:"),1,0,'');
        $pdf->SetFont('Arial','','11');
        $pdf->Cell(143,5,utf8_decode($opcion_titulacion),1,1,'');
        $pdf->Ln(10);
        $pdf->MultiCell(190,5,utf8_decode("En espera del dictamen correspondiente, quedo a sus ordenes."));
        $pdf->Ln(5);
        $y1=$pdf->GetY();
        $pdf->SetFont('Arial','B','11');
        $pdf->Cell(64,10,utf8_decode("Dirección:"),1,0,'');
        $pdf->Cell(130,10,utf8_decode(""),1,1,'');
        $pdf->SetFont('Arial','B','11');
        $pdf->Cell(64,5,utf8_decode("Teléfono particular o de contacto:"),1,0,'');
        $pdf->SetFont('Arial','','11');
        $pdf->Cell(130,5,utf8_decode($telefono),1,1,'');
        $pdf->SetFont('Arial','B','11');
        $pdf->Cell(64,5,utf8_decode("Correo electrónico del estudiante:"),1,0,'');
        $pdf->SetFont('Arial','','11');
        $pdf->Cell(130,5,utf8_decode($correo),1,1,'');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','11');
        $pdf->Cell(190,5,utf8_decode("ATENTAMENTE"),0,1,'C');
        $pdf->Ln(15);
        $pdf->Cell(40,5,utf8_decode(""),0,0,'C');
        $pdf->Cell(110,5,utf8_decode($nombre_alumno),0,1,'C');
        $pdf->Cell(40,5,utf8_decode(""),0,0,'C');
        $pdf->Cell(110,5,utf8_decode("NOMBRE Y FIRMA DEL SOLICITANTE"),0,1,"C");
        $pdf->Ln(5);
        $pdf->Cell(95,5,utf8_decode("Vo. Bo."),0,0,'C');
        $pdf->Cell(95,5,utf8_decode("AUTORIZO"),0,1,'C');
        $pdf->Cell(95,15,utf8_decode(""),0,0,'C');
        $pdf->Cell(95,15,utf8_decode(""),0,1,'C');
        $pdf->SetXY(10,215);
        $pdf->MultiCell(95,5,utf8_decode($jefe_division),0,'C');
        $pdf->MultiCell(95,5,utf8_decode("JEFE(A) DE DIVISIÓN DE LA CARRERA DE ".$carrera),0,'C',0,false);
        $pdf->SetXY(105,215);
        $pdf->MultiCell(95,5,utf8_decode("$jefe_titulacion"),0,'C');
        $pdf->Cell(95,5,utf8_decode(""),0,0,'C');
        $pdf->MultiCell(95,5,utf8_decode("JEFE(A) DEL DEPARTAMENTO DE TITULACIÓN"),0,'C',0);
        $pdf->SetXY(57,$y);
        $pdf->SetFont('Arial','','11');
        $pdf->MultiCell(143,5,utf8_decode($nombre_proyecto),0,'J');

        $pdf->SetXY(74,$y1);
        $pdf->MultiCell(130,5,utf8_decode($domi),0,'J');
        $pdf->Output();
        exit();
    }
}
