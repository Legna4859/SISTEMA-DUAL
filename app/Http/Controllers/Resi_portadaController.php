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
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', '11');
        $this->Ln(5);
        $etiqueta=DB::table('etiqueta')
            ->where('id_etiqueta','=',1)
            ->select('etiqueta.descripcion')
            ->get();
        $etiqueta=$etiqueta[0]->descripcion;
        $this->SetFont('Arial','',8);
        $this->Cell(190,5,utf8_decode($etiqueta),0,1,'C',FALSE);
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
        $this->Cell(145,-2,utf8_decode('FO-TESVB-96 V.0 23/03/2018'),0,0,'R');
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
class Resi_portadaController extends Controller
{
    public function index($id_anteproyecto){
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $alumno=DB::table('gnral_alumnos')
            ->join('gnral_carreras','gnral_carreras.id_carrera','=','gnral_alumnos.id_carrera')
            ->where('gnral_alumnos.id_usuario','=',$id_usuario)
            ->select('gnral_alumnos.*','gnral_carreras.nombre as carrera')
            ->get();




        $anteproyecto=DB::table('resi_proyecto')
            ->join('resi_anteproyecto','resi_proyecto.id_proyecto','=','resi_anteproyecto.id_proyecto')
            ->where('resi_anteproyecto.id_anteproyecto','=',$id_anteproyecto)
            ->select('resi_proyecto.nom_proyecto')
            ->get();

        $nombre_proyecto=mb_eregi_replace("[\n|\r|\n\r]",'',$anteproyecto[0]->nom_proyecto);





        $dat_alumnos=mb_strtoupper("C.",'utf-8')." ".mb_strtoupper($alumno[0]->nombre,'utf-8')." ".mb_strtoupper($alumno[0]->apaterno,'utf-8')." ".mb_strtoupper($alumno[0]->amaterno,'utf-8');
        $carrera=$alumno[0]->carrera;
        $pdf=new PDF($orientation='P',$unit='mm',$format='Letter');

        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(10, 25 , 10);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();
        $pdf->Image('img/residencia/tesvb.jpg' , 20 ,40, 35 , 13,'JPG', '');
        $pdf->Ln(8);
        $pdf->SetTextColor(86,86,86);
        //$pdf->Cell(190,5,utf8_decode("RESIDENCIAS PROFESIONALES"),0,0,'C',FALSE);
        $pdf->Ln(5);
        //$pdf->SetDrawColor(16,138,18);
        //$pdf->Cell(190,5,utf8_decode("FORMATO DE PROYECTO DE RESIDENCIA PROFESIONAL"),'B',1,'C',FALSE);
        $pdf->Ln(20);
        $pdf->SetFont('Arial','B',11);
        $pdf->SetTextColor(1,1,1);
        $pdf->Cell(190,5,utf8_decode("PROYECTO DE RESIDENCIA PROFESIONAL"),0,0,'C',FALSE);
        $pdf->Ln(5);
        $pdf->Cell(190,5,utf8_decode("CARRERA:".$carrera),0,0,'C',FALSE);
        $pdf->Ln(25);

        $pdf->SetFont('Arial','',11);
        $pdf->Line(60, 50, 210-20, 50);
        $pdf->SetLineWidth(0.8);
        $pdf->Line(60, 51, 210-20, 51);

        $pdf->SetLineWidth(0.22);
        $pdf->Line(20, 55, 20, 245);
        $pdf->SetLineWidth(0.8);
        $pdf->Line(21, 55, 21, 245);

        $pdf->Cell(190,5,utf8_decode("TEMA:"),0,0,'C',FALSE);
        $pdf->Ln(15);
        $pdf->SetX(25);
        $pdf->MultiCell(150,5,utf8_decode($nombre_proyecto),0,'C',FALSE);
        $pdf->Ln(15);
        $pdf->Cell(190,5,utf8_decode("ELABORADO POR:"),0,0,'C',FALSE);
        $pdf->Ln(15);
        $pdf->Cell(190,5,utf8_decode($dat_alumnos),0,0,'C',FALSE);
        $fechas = date("Y-m-d");

        $num=date("j",strtotime($fechas));
        $ano=date("Y", strtotime($fechas));
        $mes= array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
        $mes=$mes[(date('m', strtotime($fechas))*1)-1];
        $fech= $num. ' de '.$mes.' del '.$ano;
        $pdf->Ln(25);
        $pdf->Cell(190,5,utf8_decode("Valle de Bravo, Estado de México. ".$mes." del ".$ano),0,0,'R',FALSE);
        $pdf->Ln(15);
        $pdf->SetFont('Arial','',8);
        $pdf->SetTextColor(86,86,86);
        $pdf->Image('img/residencia/FIR.PNG' , 30 ,210,45, 35,'PNG', '');
        $pdf->SetXY(37,235);
        $pdf->MultiCell(30,5,utf8_decode("FIRMA DEL ASESOR INTERNO"),0,'C',FALSE);
        $pdf->Image('img/residencia/FIR.PNG' , 85 ,210,45, 35,'PNG', '');
        $pdf->SetXY(93,235);
        $pdf->MultiCell(30,5,utf8_decode("FIRMA DEL ASESOR EXTERNO"),0,'C',FALSE);
        $pdf->Image('img/residencia/FIR.PNG' , 140 ,210,45, 35,'PNG', '');
        $pdf->SetXY(147,235);
        $pdf->MultiCell(30,5,utf8_decode("FIRMA DEL REVISOR"),0,'C',FALSE);
        $pdf->Output();

        exit();
    }
}
