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
        $this->SetY(-28);
        $this->SetFont('Arial','',8);
        // $this->Image('img/sgc.PNG',40,245,18);
        $this->Image('img/pie/logos_iso.jpg',40,243,60);
//        $this->Image('img/tutorias/cir.jpg',85,245,18);
       // $this->Cell(80);
       // $this->Cell(110,-2,utf8_decode('FO-TESVB-81 V.2 15/12/2020'),0,0,'R');
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
        $this->Cell(110,-2,utf8_decode('SUBDIRECCIÓN DE ESTUDIOS PROFESIONALES'),0,0,'R');
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
        $this->Cell(160,10,utf8_decode(' Valle de Bravo, Estado de México, C.P. 51200.    Tels.: (726)26 6 52 00,26 6 51 87 Ext 145                   '),0,0,'L');

        $this->Image('img/logos/Mesquina.jpg',0,252,30);
    }

}

class Beca_pdf_SolicitudBecaController extends Controller
{

    public function  index ($id_autorizar){
        $autorizados_profesionales=DB::selectOne('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.correo_al,
gnral_alumnos.amaterno,gnral_alumnos.curp_al,beca_descuento.descripcion descuento,beca_descuento.id_descuento,beca_autorizar.promedio,
gnral_semestres.id_semestre,gnral_semestres.descripcion semestre,beca_autorizar.fecha,beca_autorizar.id_autorizar,gnral_carreras.id_carrera,gnral_carreras.nombre carrera
 FROM gnral_alumnos,beca_descuento,beca_autorizar,gnral_semestres,gnral_carreras WHERE gnral_alumnos.id_alumno=beca_autorizar.id_alumno 
 and gnral_alumnos.id_carrera=gnral_carreras.id_carrera and beca_autorizar.id_descuento=beca_descuento.id_descuento 
 and beca_autorizar.id_semestre=gnral_semestres.id_semestre and beca_autorizar.id_autorizar='.$id_autorizar.' ');

        $nombre_alumno = mb_strtoupper($autorizados_profesionales->apaterno, 'utf-8') . " " . mb_strtoupper($autorizados_profesionales->amaterno, 'utf-8') . " " . mb_strtoupper($autorizados_profesionales->nombre, 'utf-8');
        $correo=$autorizados_profesionales->correo_al;
        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');

        $pdf=new PDF($orientation='P',$unit='mm',$format='Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(20, 25 , 20);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetLineWidth(0.2);
        $pdf->SetFont('Arial','','8');
        $pdf->Cell(40);
        $pdf->Cell(100,5,utf8_decode($etiqueta->descripcion),0,0,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','B','10');

        $pdf->Cell(180,20,utf8_decode('ESTIMULO AL DESEMPEÑO ESCOLAR'),1,1,'C');
        $pdf->Cell(40,20,utf8_decode('Fecha elaboración:'),1,0,'C');
        $pdf->Cell(140,20,utf8_decode($autorizados_profesionales->fecha),1,1,'C');
        $pdf->Cell(40,20,utf8_decode('Nombre del estudiante:'),1,0,'C');
        $pdf->Cell(140,20,utf8_decode($nombre_alumno),1,1,'C');
        $pdf->Cell(34,20,utf8_decode('Número de Cuenta:'),1,0,'C');
        $pdf->Cell(28,20,utf8_decode($autorizados_profesionales->cuenta),1,0,'C');
        $pdf->Cell(118,20,utf8_decode('Carrera: '.$autorizados_profesionales->carrera),1,1,'C');
        $pdf->Cell(20,20,utf8_decode('Promedio:'),1,0,'C');
        $pdf->Cell(30,20,utf8_decode($autorizados_profesionales->promedio),1,0,'C');
        $pdf->Cell(96,20,utf8_decode('Evaluación Sumativa de Complementación: '),1,0,'C');
        if($autorizados_profesionales->id_descuento == 2){
            $pdf->Cell(17,20,utf8_decode('*SI'),1,0,'C');
            $pdf->Cell(17,20,utf8_decode('NO'),1,1,'C');
        }else{
            $pdf->Cell(17,20,utf8_decode('SI'),1,0,'C');
            $pdf->Cell(17,20,utf8_decode('*NO'),1,1,'C');
        }

        $pdf->Cell(60,15,utf8_decode('Concepto del estímulo:'),1,0,'C');
        if($autorizados_profesionales->id_descuento == 2 || $autorizados_profesionales->id_descuento == 3  ){

                $pdf->Cell(120, 15, utf8_decode('50% (Cincuenta Porciento)'), 1, 1, 'C');
            }
            elseif($autorizados_profesionales->id_descuento == 1  ) {
                $pdf->Cell(120, 15, utf8_decode('100% (Cien Porciento)'), 1, 1, 'C');
            }

        $pdf->Cell(90,30,utf8_decode('CURP: '.$autorizados_profesionales->curp_al),1,0,'C');
        $pdf->Cell(90,30,utf8_decode(''),1,1,'C');
        $pdf->Cell(90,40,utf8_decode(''),1,0,'C');
        $pdf->Cell(90,40,utf8_decode(''),1,1,'C');
        $pdf->MultiCell(180,4,utf8_decode('Una vez analizados los registros del estudiante, que obran en la Subdirección de Servicios Escolares, con fundamento en los criterios para el estimulo al desempeño escolar para estudiantes del Tecnológico de Estudios Superiores de Valle de Bravo.                                                 '),1, 'J');
        if($autorizados_profesionales->id_descuento == 2) {
            $pdf->Line(170, 127, 180, 127);
        }else {
            $pdf->Line(187, 127, 197, 127);
        }
        $pdf->SetXY(110,160);
        $pdf->Cell(90,5,utf8_decode('Correo electrónico:'),0,1,'C');
        $pdf->SetXY(110,165);
        $pdf->Cell(90,5,utf8_decode($correo),0,1,'C');
        $pdf->Line(40,202, 90,202);
        $pdf->SetXY(20,207);
        $pdf->Cell(90,5,utf8_decode('APROBÓ'),0,1,'C');
        $pdf->SetXY(20,212);
        $pdf->Cell(90,5,utf8_decode('DIRECCIÓN ACADÉMICA'),0,1,'C');
        $pdf->Line(130,202, 180,202);
        $pdf->SetXY(110,207);
        $pdf->Cell(90,5,utf8_decode('AUTORIZÓ'),0,1,'C');
        $pdf->SetXY(110,212);
        $pdf->Cell(90,5,utf8_decode('DIRECTORA GENERAL'),0,1,'C');
        $pdf->Output();
        exit();

    }
}
