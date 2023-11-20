<?php

namespace App\Http\Controllers;

use App\AudAgenda;
use App\AudAgendaActividad;
use App\AudAgendaArea;
use App\AudAgendaAuditor;
use App\AudAgendaEvento;
use App\AudAgendaProceso;
use App\AudAreaGeneral;
use App\AudAreaGeneralUnidad;
use App\AudAsignaAuditoria;
use App\AudAuditorAuditoria;
use App\AudAuditores;
use App\AudAuditoriaProceso;
use App\AudAuditorias;
use App\AudInforme;
use App\audParseCase;
use App\AudPrint;
use App\AudProgramas;
use App\gnral_unidad_administrativa;
use App\GnralPersonales;
use App\ri_proceso;
use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$no_oficio="";

class pdf2 extends FPDF{
    function Header(){
        $this->Image('img/FONDO.png',0,0,280);
        $this->Image('img/FONDOCONSTANCIA.png',0,-5,280);
        $this->Image('img/escudouaem.png',5,2,35);
    }
}

class PDF extends FPDF
{

    function Header(){
        $this->SetXY(20,25);
        $this->Image('img/logos/ArmasBN.png',10,9,40);
        $this->Image('img/tes.png',135,9,27);
        $this->SetFillColor('120','120','120');
        $this->Rect(165,8,1,12,'F');
        $this->Image('img/logos/EdoMEXcolor.png',169,9,35);
        $this->SetDrawColor(0,0,0);
        $this->SetFont('Helvetica','B','9');
        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');
        $this->Cell(176,5,utf8_decode($etiqueta->descripcion),0,1,'C');
//        $this->Cell(176,5,utf8_decode('"2019. Año del Centésimo Aniversario de Emiliano Zapata salazar. El Caudillo del sur"'),0,1,'C');
    }

    function Footer(){
//        $this->SetXY(20,25);
        $this->SetY(-33);
        $this->SetFont('Helvetica','',5.5);
        $this->Image('img/sgc.PNG',40,242,18);
        $this->Image('img/sga.PNG',65,242,18);
        $this->SetX(20);
        $this->Cell(186,3,utf8_decode($GLOBALS['no_oficio']),0,1,'R');
        $this->SetFont('Helvetica','B',5.5);
        $this->SetX(20);
        $this->Cell(186,3,utf8_decode('SECRETARÍA DE EDUCACIÓN'),0,1,'R');
        $this->SetTextColor(120,120,120);
        $this->SetX(20);
        $this->Cell(186,3,utf8_decode('SUBSECRETARÍA DE EDUCACIÓN SUPERIOR Y NORMAL'),0,1,'R');
//        $this->SetTextColor(180,180,180);
        $this->SetTextColor(150,150,150);
        $this->SetX(20);
        $this->Cell(186,3,utf8_decode('TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO'),0,1,'R');
        $this->SetTextColor(180,180,180);
        $this->SetX(20);
        $this->Cell(186,3,utf8_decode('DIRECCIÓN ACADÉMICA'),0,1,'R');
//        $this->SetMargins(40,10,10);
        $this->SetFillColor(120,120,120);
        $this->SetX(20);
        $this->Rect($this->GetX()+10,$this->GetY(),210,12  ,'F');
        $this->Image('img/logos/Mesquina.png',0,$this->GetY()-20,40);
        $this->SetTextColor(255,255,255);
        $this->Ln();
        $this->SetY($this->Gety()-3);
        $this->SetX(43);
        $this->SetFont('Helvetica','B',9);
        $this->Cell(160,4,utf8_decode('Km. 30 de la Carretera Federal Monumento - Valle de Bravo, Ejido de San Antonio de la Laguna,'),0,1,'L');
        $this->SetX(43);
        $this->Cell(160,4,utf8_decode('Valle de Bravo, Estado de México, C.P. 51200.'),0,1,'L');
        $this->SetFont('Helvetica','',9);
        $this->SetX(43);
        $this->Cell(160,4,utf8_decode('Tels.: (726) 26 6 52 00, 26 6 50 77, 26 6 51 87  Ext: 103              dir.académica@tesvb.edu.mx '),0,1,'L');
    }
    function TextWithDirection($x, $y, $txt, $direction='R')
    {
        if ($direction=='R')
            $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',1,0,0,1,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
        elseif ($direction=='L')
            $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',-1,0,0,-1,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
        elseif ($direction=='U')
            $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',0,1,-1,0,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
        elseif ($direction=='D')
            $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',0,-1,1,0,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
        else
            $s=sprintf('BT %.2F %.2F Td (%s) Tj ET',$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
        if ($this->ColorFlag)
            $s='q '.$this->TextColor.' '.$s.' Q';
        $this->_out($s);
    }

    function toSpanish($text){
        if (strtolower($text)=='jan') return 'Enero';
        elseif (strtolower($text)=='feb') return 'Febrero';
        elseif (strtolower($text)=='mar') return 'Marzo';
        elseif (strtolower($text)=='apr') return 'Abril';
        elseif (strtolower($text)=='may') return 'Mayo';
        elseif (strtolower($text)=='jun') return 'Junio';
        elseif (strtolower($text)=='jul') return 'Julio';
        elseif (strtolower($text)=='aug') return 'Agosto';
        elseif (strtolower($text)=='sep') return 'Septiembre';
        elseif (strtolower($text)=='oct') return 'Octubre';
        elseif (strtolower($text)=='nov') return 'Noviembre';
        elseif (strtolower($text)=='dec') return 'Diciembre';
    }

}

class AudPrintController extends Controller
{
    private $procesosT=[];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function printPrograma($id,$aprueba){
        $data=AudPrint::getDataProgram($id);
        $procesos=$data->procesos;
        $auditorias=$data->auditorias;
        $programa=$data->programa;

        $GLOBALS['no_oficio']="FO-TESVB-20  V.0  23-03-2018";

        $pdf=new PDF('P','mm','Letter');
        $title = utf8_decode('Programa de auditoría');
        $pdf->SetTitle($title);
        $pdf->SetMargins(20, 25 , 20, 25);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();
        $pdf->SetFont('Helvetica','B','12');
        $pdf->Ln(10);
        $pdf->Cell(176,5,utf8_decode('Programa de auditoría'),0,1,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Helvetica','B','11');
        $pdf->Cell(18,5,utf8_decode('Periodo:'));
        $pdf->SetFont('Helvetica','','11');
//            $pdf->MultiCell(80,5,utf8_decode($pdf->toSpanish(date('M',strtotime($programa->fecha_i)).' - '.$pdf->toSpanish(date('M',strtotime($programa->fecha_f))).' '.date('YY',strtotime($programa->fecha_i)))),0,'L');
        $pdf->MultiCell(80,5,utf8_decode(audParseCase::toSpanish(date('M',strtotime($programa->fecha_i)))).' - '.utf8_decode(audParseCase::toSpanish(date('M',strtotime($programa->fecha_f)))).' '.date('Y',strtotime($programa->fecha_f)),0,'L');
        $pdf->SetXY(110,55);
        $pdf->SetFont('Helvetica','B','11');
        $pdf->Cell(15,5,utf8_decode('Lugar:'));
        $pdf->SetFont('Helvetica','','11');
        $pdf->MultiCell(70, 5, utf8_decode($programa->lugar));

        $pdf->Ln(5);
        $pdf->SetFont('Helvetica','B','11');
        $pdf->Cell(180,5,utf8_decode('Alcance del programa de auditorías:'));
        $pdf->Ln(5);
        $pdf->SetFont('Helvetica','','11');
        $pdf->MultiCell(176, 5, utf8_decode($programa->alcance));

        $pdf->Ln(5);
        $pdf->SetFont('Helvetica','B','11');
        $pdf->Cell(180,5,utf8_decode('Objetivo del programa de auditorías:'));
        $pdf->Ln(5);
        $pdf->SetFont('Helvetica','','11');
        $pdf->MultiCell(176, 5, utf8_decode($programa->objetivo));

        $pdf->Ln(5);
        $pdf->SetFont('Helvetica','B','11');
        $pdf->Cell(180,5,utf8_decode('Métodos:'));
        $pdf->Ln(5);
        $pdf->SetFont('Helvetica','','11');
        $pdf->MultiCell(176, 5, utf8_decode($programa->metodos));

        $pdf->Ln(5);
        $pdf->SetFont('Helvetica','B','11');
        $pdf->Cell(180,5,utf8_decode('Responsabilidades:'));
        $pdf->Ln(5);
        $pdf->SetFont('Helvetica','','11');
        $pdf->MultiCell(176, 5, utf8_decode($programa->responsabilidades));

        $pdf->Ln(5);
        $pdf->SetFont('Helvetica','B','11');
        $pdf->Cell(60,5,utf8_decode('Planeación:'));
        $pdf->Ln(7);
        $pdf->Cell(58,5,utf8_decode('Recursos:'),0,0,'C');
        $pdf->Cell(58,5,utf8_decode('Requisitos:'),0,0,'C');
        $pdf->Cell(59,5,utf8_decode('Criterios de aceptación:'),0,1,'C');
        $pdf->SetFont('Helvetica','','11');
        $y=$pdf->GetY();
        $pdf->SetX(23);
        $pdf->MultiCell(52, 5, utf8_decode($programa->recursos),0,'J');
        $pdf->SetXY(81,$y);
        $pdf->MultiCell(52, 5, utf8_decode($programa->requisitos),0,'J');
        $pdf->SetXY(139,$y);
        $pdf->MultiCell(53, 5, utf8_decode($programa->criterios),0,'J');

        $y2=$pdf->GetY();
        $pdf->SetY($y-5);
        $pdf->SetY($pdf->GetY()-1);
        $pdf->Rect($pdf->GetX(),$pdf->GetY(),58,$y2-($y-8));
        $pdf->Rect($pdf->GetX()+58,$pdf->GetY(),58,$y2-($y-8));
        $pdf->Rect($pdf->GetX()+116,$pdf->GetY(),59,$y2-($y-8));
        $pdf->AddPage();
        $pdf->Ln(15);
        $pdf->SetFont('Helvetica','B','11');
        $pdf->Cell(58,5,utf8_decode('Programación:'),0,1,'L');
        $pdf->SetFont('Helvetica','','11');
        $pdf->Cell(10,40,utf8_decode('No.'),1,0,'C');
        $pdf->Cell(70,40,utf8_decode('Cláusula/Proceso o actividad'),1,0,'C');
        $x=$pdf->GetX();
        $pdf->Cell(40,5,utf8_decode('Mes'),1,0,'C');
        $pdf->Cell(55,40,utf8_decode('Observaciones'),1,0,'C');
        $pdf->SetXY($x,$pdf->GetY()+5);
        for ($i=0;$i<5;$i++)
            $pdf->Cell(8,35,utf8_decode(''),1,0,'C');
        $pdf->Ln();
        $x+=5;


        foreach ($auditorias as $auditoria){
            if (date('M',strtotime($auditoria->fecha_i))==date('M',strtotime($auditoria->fecha_f)))
                $fecha=$pdf->toSpanish(date('M',strtotime($auditoria->fecha_i)));
            else {
                $fecha = $pdf->toSpanish(date('M', strtotime($auditoria->fecha_i))) . ' - ' . $pdf->toSpanish(date('M', strtotime($auditoria->fecha_f)));
            }
            if(strlen($fecha)>16) $pdf->SetFont('Helvetica','','8.5');
            $pdf->TextWithDirection($x, $pdf->GetY()-1, utf8_decode($fecha),'U');
            $x+=8;
            $pdf->SetFont('Helvetica','','11');
        }

        $iteration=1;
//        foreach ($procesos as $proceso){
//            $x1=$pdf->GetX();
//            $y1=$pdf->GetY();
//            $pdf->SetX($pdf->GetX()+10);
//            if ($proceso->id_sistema!=3)
//                $pdf->MultiCell(70,5,audParseCase::parseProcesoPDF($proceso->des_proceso),1,'J');
//            else
//                $pdf->MultiCell(70,5,$proceso->clave.' '.audParseCase::parseProcesoPDF($proceso->des_proceso),1,'J');
//
//            $y2=$pdf->GetY();
//            $pdf->SetXY($x1,$y1);
//            $pdf->Cell(10,$y2-$y1,$iteration,1,0,'C');
//            $pdf->SetX($pdf->GetX()+70);
//            $iteration++;
//            for ($i=0; $i<5;$i++){
//                if ($i<sizeof($auditoriasProg)){
//                    $existe=false;
//                    $xxx=0;
//                    foreach ($procesosAud as $procesoAud){
//                        $xxx++;
//                        if ($procesoAud->id_auditoria==$auditoriasProg[$i]){
//                            if ($proceso->id_proceso==$procesoAud->id_proceso) {
//                                $pdf->Cell(8,$y2-$y1,'X',1,0,'C');
//                                $existe=true;
//                            }
//                        }
//                    }
//                    if(!$existe){
//                        $pdf->Cell(8,$y2-$y1,'',1,0,'C');
//                    }
//                }
//                else{
//                    $pdf->Cell(8,$y2-$y1,'',1,0,'C');
//                }
//            }
//            $pdf->Cell(55,$y2-$y1,'Obj',1,0,'C');
//            $pdf->Ln();
//            if ($pdf->GetY()>220){
//                $pdf->AddPage();
//                $pdf->Ln(15);
//            }
//
//        }

        $no=1;
        foreach ($procesos as $proceso){

            $x1 = $pdf->GetX();
            $y1 = $pdf->GetY();
            $procesoMayor=false;
            if ($proceso->id_sistemas==3){
                if (strlen(audParseCase::parseProcesoPDF($proceso->clave.' '.$proceso->des_proceso)) >= strlen(utf8_decode($proceso->observaciones))) {
                    $pdf->SetX(30);
                    $pdf->MultiCell(70, 5, $proceso->clave . ' ' . audParseCase::parseProcesoPDF($proceso->des_proceso), 1, 'J');
                    $procesoMayor=true;
                }
                else{
                    $pdf->SetX(140);
                    $pdf->MultiCell(55, 5,  audParseCase::parseProcesoPDF($proceso->observaciones), 1, 'J');
                }
            }
            else{
                if (strlen(audParseCase::parseProcesoPDF($proceso->des_proceso)) >= strlen(utf8_decode($proceso->observaciones))) {
                    $pdf->SetX(30);
                    $pdf->MultiCell(70, 5, audParseCase::parseProcesoPDF($proceso->des_proceso), 1, 'J');
                    $procesoMayor=true;
                }
                else{
                    $pdf->SetX(140);
                    $pdf->MultiCell(55, 5,  audParseCase::parseProcesoPDF($proceso->observaciones), 1, 'J');
                }
            }
            $y2 = $pdf->GetY();
            if ($procesoMayor){
                $diferencia=round((($y2-$y1)-(ceil(strlen( audParseCase::parseProcesoPDF($proceso->observaciones))/16))*5)/2);
                if (strlen($proceso->observaciones)>0) {
                    if ($diferencia > 0) {
                        $pdf->SetXY(140,$y1);
                        $pdf->Cell(55,$y2-$y1,'',1);
                        $pdf->SetXY(140, $y1 + $diferencia);
                        $pdf->MultiCell(55, 5,  audParseCase::parseProcesoPDF($proceso->observaciones), 0, 'J');
                    } else {
                        $pdf->SetXY(140, $y1);
                        $pdf->MultiCell(55, 5, audParseCase::parseProcesoPDF($proceso->observaciones), 1, 'J');
                    }
                }
                else{
                    $pdf->SetXY(140, $y1);
                    $pdf->Cell(55, $y2 - $y1, '', 1, 0, 'C');
                }
            }
            else{
                $pdf->SetXY(30, $y1);
                if ($proceso->id_sistema != 3) {
                    $diferencia=round((($y2-$y1)-(ceil(strlen(audParseCase::parseProcesoPDF($proceso->des_proceso))/35))*5)/2);
//                    dd(strlen(audParseCase::parseProcesoPDF($proceso->des_proceso)));
                    $pdf->Cell(70, $y2 - $y1, '', 1);
                    $pdf->SetXY(30, $y1+$diferencia);
                    $pdf->MultiCell(70, 5, audParseCase::parseProcesoPDF($proceso->des_proceso).' '.$diferencia, 0, 'J');
                }
                else
                    $pdf->MultiCell(70, 5, $proceso->clave . ' ' . audParseCase::parseProcesoPDF($proceso->des_proceso), 1, 'J');
            }

            $pdf->SetXY(20,$y1);
            $pdf->Cell(10, $y2 - $y1, $no, 1, 0, 'C');
            $pdf->Ln();
            $no++;

            $iteration = 0;
            $pdf->SetXY(100, $y1);
            foreach ($proceso->fechas as $fecha) {
                $pdf->Cell(8, $y2 - $y1, $fecha, 1, 0, 'C');
                $iteration++;
            }
            for (; $iteration < 5; $iteration++) {
                $pdf->Cell(8, $y2 - $y1, '', 1, 0, 'C');
            }
            $pdf->Ln();

            if ($pdf->GetY() > 220) {
                $pdf->AddPage();
                $pdf->Ln(15);
            }

//
////            dd(audParseCase::parseProcesoPDF($proceso->des_proceso).'('.strlen(audParseCase::parseProcesoPDF($proceso->des_proceso)).')    '.strlen($proceso->observaciones));
//            if (strlen(audParseCase::parseProcesoPDF($proceso->des_proceso)) >= strlen(utf8_decode($proceso->observaciones))) {
//                $x1 = $pdf->GetX();
//                $y1 = $pdf->GetY();
//                $pdf->SetX(($x1 + 10));
//                if ($proceso->id_sistema != 3)
//                    $pdf->MultiCell(70, 5, audParseCase::parseProcesoPDF($proceso->des_proceso), 1, 'J');
//                else
//                    $pdf->MultiCell(70, 5, $proceso->clave . ' ' . audParseCase::parseProcesoPDF($proceso->des_proceso), 1, 'J');
//
//                $x2 = $x1 + 80;
//                $y2 = $pdf->GetY();
//                $pdf->SetXY($x1, $y1);
//                $pdf->Cell(10, $y2 - $y1, $no, 1, 0, 'C');
//                $iteration = 0;
//                $pdf->SetXY($x2, $y1);
//                foreach ($proceso->fechas as $fecha) {
//                    $pdf->Cell(8, $y2 - $y1, $fecha, 1, 0, 'C');
//                    $iteration++;
//                }
//                for (; $iteration < 5; $iteration++) {
//                    $pdf->Cell(8, $y2 - $y1, '', 1, 0, 'C');
//                }
////                dd('y1:'.$y1." y2:".$y2);
//                $diferencia=round((($y2-$y1)-(ceil(strlen($proceso->observaciones)/16))*5)/2);
////                dd($diferencia);
////                dd($y2-$y1/ceil(strlen($proceso->observaciones)/16));
//                if (strlen($proceso->observaciones)>0) {
//                    if ($diferencia > 0) {
//                        $pdf->SetXY(140,$y1);
//                        $pdf->Cell(55,$y2-$y1,'',1);
//                        $pdf->SetXY(140, $y1 + $diferencia);
//                        $pdf->MultiCell(55, 5, $proceso->observaciones, 0, 'J');
//                    } else {
//                        $pdf->SetXY(140, $y1);
//                        $pdf->MultiCell(55, 5, $proceso->observaciones, 1, 'J');
//                    }
//                }
//                else{
//                    $pdf->SetXY(140, $y1);
//                    $pdf->Cell(55, $y2 - $y1, '', 1, 0, 'C');
//                }
//
//
//                $pdf->Ln();
//                $pdf->SetY($y2);
//
//                if ($pdf->GetY() > 220) {
//                    $pdf->AddPage();
//                    $pdf->Ln(15);
//                }
//                $no++;
//            }
//            else{
//                $x1 = $pdf->GetX();
//                $y1 = $pdf->GetY();
//                $pdf->SetX(140);
//                $pdf->MultiCell(55, 5, $proceso->observaciones, 1, 'J');
//                $x2 = $pdf->GetX();
//                $y2 = $pdf->GetY();
//
//                $pdf->SetXY(20,$y1);
//                $pdf->Cell(10, $y2 - $y1, $no, 1, 0, 'C');
//
//
//                $diferencia=round((($y2-$y1)-(ceil(strlen($proceso->clave.' '.$proceso->des_proceso)/35))*5)/2);
////                dd($diferencia);
//                $pdf->SetXY(30, $y1+$diferencia);
//                //$pdf->SetXY(85,$y+$diferencia);
//
//                if ($proceso->id_sistema != 3)
//                    $pdf->MultiCell(70, 5, audParseCase::parseProcesoPDF($proceso->des_proceso), 0, 'J');
//                else
//                    $pdf->MultiCell(70, 5, $proceso->clave . ' ' . audParseCase::parseProcesoPDF($proceso->des_proceso), 1, 'J');
//
//                $iteration = 0;
//                $pdf->SetXY(100, $y1);
//                foreach ($proceso->fechas as $fecha) {
//                    $pdf->Cell(8, $y2 - $y1, $fecha, 1, 0, 'C');
//                    $iteration++;
//                }
//                for (; $iteration < 5; $iteration++) {
//                    $pdf->Cell(8, $y2 - $y1, '', 1, 0, 'C');
//                }
//
//                $pdf->Ln();
//                $pdf->SetY($y2);
//
//                if ($pdf->GetY() > 220) {
//                    $pdf->AddPage();
//                    $pdf->Ln(15);
//                }
//                $no++;
//            }
        }

        if($pdf->GetY()>180)
            $pdf->AddPage();


        $pdf->Ln(5);
        $pdf->SetX(35);
        $pdf->Cell(65,5,utf8_decode('Elaboró'),0,0,'C');
        $pdf->SetX(115);
        $pdf->Cell(65,5,utf8_decode('Aprobó'),0,0,'C');

        $pdf->Ln(20);
        $pdf->SetX(35);
        $pdf->Cell(65,0,'',1,0,'C');
        $pdf->SetX(115);
        $pdf->Cell(65,0,'',1,0,'C');


        $pdf->Ln();
        $pdf->SetX(25);
        $y=$pdf->GetY();
        $lider=AudPrint::getFirmaPrograma(1);
        $pdf->MultiCell(80,5,audParseCase::parseAbr($lider->titulo).' '.audParseCase::parseNombrePDF($lider->nombre),0,'C');
        $pdf->SetX(25);
        $pdf->Cell(80,5,utf8_decode('Auditor Líder'),0,0,'C');
        $pdf->SetXY(110,$y);


        if ($aprueba==1){
            $sgc=AudPrint::getFirmaPrograma(2);
            $pdf->MultiCell(80,5,audParseCase::parseAbr($sgc->titulo).' '.audParseCase::parseNombrePDF($sgc->nombre),0,'C');
            $pdf->SetX(110);
            $pdf->MultiCell(80,5,utf8_decode('Coordinadora del Sistema de Gestión de la Calidad'),0,'C');
        }
        else if($aprueba==2){
            $director=AudPrint::getFirmaPrograma(3);
            $pdf->MultiCell(80,5,audParseCase::parseAbr($director->titulo).' '.audParseCase::parseNombrePDF($director->nombre),0,'C');
            $pdf->SetX(110);
            $pdf->MultiCell(80,5,utf8_decode('Director General'),0,'C');
        }
        $y=$pdf->GetY();
        //$pdf->Cell(65,5,$y,0,0,'C');
        $pdf->Output();
        exit();
    }

    public function printPlan($id,$aprueba){

        $plan=AudAuditorias::findOrFail($id);
        $planes=AudAuditorias::where('id_programa',$plan->id_programa)->orderBy('fecha_i')->orderBy('fecha_f')->get();
        $no_aud=Carbon::parse($plan->fecha_i)->format('Y').'-';
        $i=1;
        foreach ($planes as $planP){
            if ($planP->id_auditoria==$plan->id_auditoria) $no_aud.=$i;
            $i++;
        }
        $lider=AudAuditorias::getAuditores($id,1);
        $auditores=AudAuditorias::getAuditores($id,2);
        $entrenamiento=AudAuditorias::getAuditores($id,3);
        $fechas=AudAgenda::where('id_auditoria',$id)
            ->select('aud_agenda.fecha')
            ->orderBy('aud_agenda.fecha')
            ->distinct()
            ->get();
       // dd($fechas);
        $auditoresT=AudAuditorAuditoria::join('gnral_personales','gnral_personales.id_personal','=','aud_auditor_auditoria.id_personal')
            ->join('abreviaciones_prof','abreviaciones_prof.id_personal','=','gnral_personales.id_personal')
            ->join('abreviaciones','abreviaciones.id_abreviacion','=','abreviaciones_prof.id_abreviacion')
            ->where('aud_auditor_auditoria.id_auditoria','=',$id)
            ->where('aud_auditor_auditoria.deleted_at','=',NULL)
            ->select('aud_auditor_auditoria.id_categoria','aud_auditor_auditoria.id_auditor_auditoria','gnral_personales.nombre','abreviaciones.titulo')
            ->orderBy('aud_auditor_auditoria.id_categoria','ASC')
            ->orderBy('gnral_personales.sexo','ASC')
            ->orderBy('gnral_personales.nombre','ASC')
            ->get();

        $GLOBALS['no_oficio']="FO-TESVB-22  V.0  23-03-2018";

        $generalAreas=AudAreaGeneral::select('id_area_general','descripcion')->get();
        $generalAreas->map(function($value){
            $id_areas=[];
            $result=AudAreaGeneralUnidad::where('id_area_general',$value->id_area_general);
            if ($result->count()>0){
                $result=$result->get();
                foreach ($result as $item){
                    array_push($id_areas,$item->id_unidad_admin);
                }
            }
            $value['involucradas']=$id_areas;
        });

        //dd($fechas);
        /**
        $fechas->map(function ($value) use($id, $auditoresT,$generalAreas){
            $agendaFecha=AudAgenda::where('id_auditoria',$id)
                ->where('fecha',$value->fecha)
                ->select('id_agenda','hora_i','hora_f','criterios')
                ->orderBy('fecha','ASC')
              // ->orderBy("id_agenda","ASC")
                ->orderBy('hora_i','ASC');
               // ->orderBy('hora_f','ASC');
           // dd($agendaFecha->get());

            /*
             * Para actividades generales
             * $agendaActividadFecha=AudAgendaActividad::where('id_auditoria',$id)
                ->where('fecha',$value->fecha)
                ->select('id_agenda_actividad','hora_i','hora_f')
                ->orderBy('fecha','ASC')
                ->orderBy('hora_i','ASC')
                ->orderBy('hora_f','ASC');
            */

/*
            if ($agendaFecha->count()>0){
                $agendaFecha=$agendaFecha->get();
               // dd($agendaFecha);
                $this->procesosT=[];
                $agendaFecha->map(function ($item) use($auditoresT,$generalAreas){
                    $result=AudAgendaAuditor::join('aud_auditor_auditoria','aud_agenda_auditor.id_auditor_auditoria','=','aud_auditor_auditoria.id_auditor_auditoria')
                        ->where('aud_agenda_auditor.id_agenda',$item->id_agenda)
                        ->select('aud_auditor_auditoria.id_auditor_auditoria','aud_auditor_auditoria.id_personal','aud_auditor_auditoria.id_categoria')
                        ->orderBy('aud_auditor_auditoria.id_categoria','ASC');

                    if ($result->count()>0) {
                        $result = $result->get();

                        $auditores=[];
                        $id_auditores=[];
                        $id_personal_lider=[];
                        foreach ($result as $auditor){
                            $equipo=1;
                            $entrenamiento=1;
                            if ($auditor->id_categoria==1){
                                array_push($auditores,'Auditor Lider');
                                array_push($id_personal_lider,$auditor->id_personal);
                            }

                            elseif ($auditor->id_categoria==2){
                                foreach ($auditoresT as $persona){
                                    if ($persona->id_categoria==2){
                                        if ($persona->id_auditor_auditoria==$auditor->id_auditor_auditoria)
                                            array_push($auditores,'Auditor '.$equipo);
                                        $equipo++;
                                    }
                                }
                            }
                            elseif ($auditor->id_categoria==3){
                                foreach ($auditoresT as $persona){
                                    if ($persona->id_categoria==3){
                                        if ($persona->id_auditor_auditoria==$auditor->id_auditor_auditoria)
                                            array_push($auditores,'AE '.$entrenamiento);
                                        $entrenamiento++;
                                    }
                                }
                            }
                            array_push($id_auditores,$auditor->id_personal);
                        }
                        $item['auditores']=$auditores;
                        $item['id_auditores']=$id_auditores;
                        $item['id_personal_lider']=$id_personal_lider;
                    }
                    $result=AudAgendaProceso::join('aud_auditoria_proceso','aud_agenda_proceso.id_auditoria_proceso','=','aud_auditoria_proceso.id_auditoria_proceso')
                        ->join('ri_proceso','aud_auditoria_proceso.id_proceso','=','ri_proceso.id_proceso')
                        ->where('aud_agenda_proceso.id_agenda',$item->id_agenda)
                        ->select('aud_auditoria_proceso.id_auditoria_proceso','ri_proceso.des_proceso')
                        ->orderBy('ri_proceso.des_proceso','ASC');
                    if ($result->count()>0) {
                        $procesos=[];
                        $result = $result->get();
                        foreach ($result as $proceso) {
                            if (!in_array($proceso->id_auditoria_proceso,$this->procesosT))
                                array_push($this->procesosT,$proceso->id_auditoria_proceso);

                            array_push($procesos,audParseCase::parseProceso($proceso->des_proceso));
                        }
                        $item['procesos']=$procesos;
                    }

                    $result=AudAgendaArea::join('gnral_unidad_administrativa','aud_agenda_area.id_area','=','gnral_unidad_administrativa.id_unidad_admin')
                        ->where('aud_agenda_area.id_agenda',$item->id_agenda)
                        ->select('gnral_unidad_administrativa.id_unidad_admin','gnral_unidad_administrativa.nom_departamento')
                        ->orderBy('gnral_unidad_administrativa.nom_departamento','ASC');
                    if ($result->count()>0) {
                        $areas=[];
                        $id_areas=[];
                        $result = $result->get();
                        foreach ($result as $area) {
                            array_push($areas,audParseCase::parseNombre($area->nom_departamento));
                            array_push($id_areas,$area->id_unidad_admin);
                        }
                        $coincidencia=[];
                        $nom_general="";
                        foreach ($generalAreas as $general){
                            if (sizeof($general->involucradas)==sizeof($id_areas)){
                                $coincidencia=array_intersect($general->involucradas,$id_areas);
                                $nom_general=$general->descripcion;
                            }
                        }
                        if (sizeof($coincidencia)>0)
                            $item['areas']=$nom_general;
                        else
                            $item['areas']=$areas;
                    }
                    return $item;
                });

               // dd($agendaFecha);
                $value['eventos']=$agendaFecha;
            }
            //dd($value->eventos->sortBy('hora_i')->sortBy('hora_f'));
            $value=($value->eventos->sortBy('hora_i'));
            return $value;
        });
*/
        $datosNuevos=new AudAgendaController();
        $datosNuevos=$datosNuevos->getDatos($id);
        //dd($datosNuevos);
       // dd($fechas);
        $pdf=new PDF('P','mm','Letter');
        $pdf->SetTitle(utf8_decode('Plan de auditoría'));
        $pdf->SetMargins(20, 25 , 20);
        $pdf->SetAutoPageBreak(true,45);
        $pdf->AddPage();
        $pdf->SetFont('Helvetica','B','12');
        $pdf->Ln(2);
        $pdf->Cell(176,5,utf8_decode('Plan de auditoría'),0,1,'C');
        $pdf->Ln(5);
        $pdf->SetFont('Helvetica','B','11');
        $pdf->Cell(176,8,utf8_decode('Número de auditoría:'),1);
        $pdf->SetFont('Helvetica','','11');
        $pdf->SetXY(60,42);
        $pdf->Cell(30,8,utf8_decode($no_aud));
        $pdf->Ln(8);
        $y=$pdf->GetY();
        $pdf->SetFont('Helvetica','B','11');
        $pdf->Cell(176,8,'Objetivo:',0,1);
        $pdf->SetFont('Helvetica','','11');
        $pdf->MultiCell(176,5,utf8_decode($plan->objetivo),0,'J',0);
        $y2=$pdf->GetY();
        $pdf->Rect(20,$y,176,$y2-$y);
        $y=$pdf->GetY();
        $pdf->SetFont('Helvetica','B','11');
        $pdf->Cell(176,8,'Alcance:',0,1);
        $pdf->SetFont('Helvetica','','11');
        $pdf->MultiCell(176,5,utf8_decode($plan->alcance),0,'J',0);
        $y2=$pdf->GetY();
        $pdf->Rect(20,$y,176,$y2-$y);
        $y=$pdf->GetY();
        $pdf->SetFont('Helvetica','B','11');
        $pdf->Cell(176,8,utf8_decode('Criterios de auditoría:'),0,1);
        $pdf->SetFont('Helvetica','','11');
        $pdf->MultiCell(176,5,utf8_decode($plan->criterio),0,'J',0);
        $y2=$pdf->GetY();
        $pdf->Rect(20,$y,176,$y2-$y);
        $y=$pdf->GetY();
        $pdf->SetFont('Helvetica','B','11');
        $pdf->Cell(176,8,utf8_decode('Fechas:'),0,1);
        $pdf->SetFont('Helvetica','','11');
        $inicio=Carbon::parse($plan->fecha_i);
        $fin=Carbon::parse($plan->fecha_f);
        if ($inicio->format('MMMM-YYYY')==$fin->format('MMMM-YYYY'))
            $pdf->MultiCell(176,5,$inicio->Format('d').' al '.$fin->Format('d').' de '.$pdf->toSpanish($fin->format('M')).' del '.$fin->format('Y'),0,'J',0);
        else
            $pdf->MultiCell(176,5,$inicio->Format('d').' de '.$pdf->toSpanish($inicio->format('M')).' al '.$fin->Format('d').' de '.$pdf->toSpanish($fin->format('M')).' del '.$fin->format('Y'),0,'J',0);
        $y2=$pdf->GetY();
        $pdf->Rect(20,$y,176,$y2-$y);
        $y=$pdf->GetY();
        $pdf->SetFont('Helvetica','B','11');
        $pdf->Cell(176,8,utf8_decode('Auditor Líder:'),0,1);
        $pdf->SetFont('Helvetica','','11');
        $pdf->Cell(176,3,audParseCase::parseAbr($lider[0]->titulo).' '.audParseCase::parseNombrePDF($lider[0]->nombre),0,1);
        $pdf->Ln(4);
        $pdf->SetFont('Helvetica','B','11');
        $pdf->Cell(176,8,utf8_decode('Equipo de auditores:'),0,1);
        $pdf->SetFont('Helvetica','','11');
        for ($i=0; $i<sizeof($auditores); $i++){
            $pdf->SetFont('Helvetica','B','11');
            $pdf->Cell(20,5,utf8_decode('Auditor '.($i+1).':'),0);
            $pdf->SetFont('Helvetica','','11');
            $pdf->Cell(136,5,audParseCase::parseAbr($auditores[$i]->titulo).' '.audParseCase::parseNombrePDF($auditores[$i]->nombre),0,1);
        }
        $pdf->Ln();
        $pdf->SetFont('Helvetica','B','11');
        $pdf->Cell(176,8,utf8_decode('Auditores en Entrenamiento:'),0,1);
        $pdf->SetFont('Helvetica','','11');
        for ($i=0; $i<sizeof($entrenamiento); $i++){
            $pdf->Cell(10,5,utf8_decode('AE'.($i+1).':'),0);
            $pdf->SetFont('Helvetica','','11');
            $pdf->Cell(136,5,audParseCase::parseAbr($entrenamiento[$i]->titulo).' '.audParseCase::parseNombrePDF($entrenamiento[$i]->nombre),0,1);
        }
        $pdf->Ln(2);
        $y2=$pdf->GetY();
        $pdf->Rect(20,$y,176,$y2-$y);
        $pdf->Ln(8);

        $pdf->SetFont('Helvetica','B','11');
        $pdf->SetFillColor(150,150,150);
        $pdf->Cell(25,6,'Hora',1,0,'C',1);
        $pdf->Cell(40,6,'Proceso(s)',1,0,'C',1);
        $pdf->Cell(55,6,utf8_decode('Área responsable'),1,0,'C',1);
        $pdf->Cell(56,6,'Auditor',1,1,'C',1);
        foreach ($datosNuevos["fechas"] as $fecha){
            $pdf->SetFont('Helvetica','B','11');
            $pdf->Cell(176,6,utf8_decode(mb_strtolower(date('d',strtotime($fecha)).' de '.$pdf->toSpanish(date('M',strtotime($fecha))))),1,1);
            $pdf->SetFont('Helvetica','','11');
            foreach ($datosNuevos["agendaFinal"] as $evento){

                if($evento["fecha"]==$fecha) {
                    if ($pdf->GetY() > 200) {
                        $pdf->AddPage();
                    }
                    $y = $pdf->GetY();

                   // dd($evento["procesos"]);
                    if (is_array($evento["procesos"]))
                        $procesos = implode(', ',$evento["procesos"]);
                    else
                        $procesos = $evento["procesos"];

                    if (is_array($evento["areas"]))
                        $areas = implode(', ', $evento["areas"]);
                    else
                        $areas = $evento["areas"];

                    if (strlen($evento["criterios"]) > 0)
                        $rec_procesos = $evento["criterios"] . PHP_EOL . $procesos;
                    else
                        $rec_procesos = $procesos;

                    $lineas_procesos = strlen($rec_procesos) / 21;
                    $lineas_areas = strlen($areas) / 33;

                    //dd($evento);
                    if ($lineas_procesos > $lineas_areas) {
                        $pdf->SetX(45);
                        $pdf->MultiCell(40, 6, audParseCase::parseProcesoPDF($rec_procesos), 1);
                        $y2 = $pdf->GetY();
                        $pdf->Rect(85, $y, 55, $y2 - $y);
                        $diferencia = round((($y2 - $y) - (ceil(strlen($areas) / 33)) * 6) / 2);
                        $pdf->SetXY(85, $y + $diferencia);
                        $pdf->MultiCell(55, 6, ($evento["tipo"]==1?audParseCase::parseNombrePDF($areas):utf8_decode("Todas las áreas")), 0);
                        $pdf->SetXY(20, $y);
                        $pdf->MultiCell(25, $y2 - $y, Carbon::parse($evento["inicio"])->format('H:i')."-".Carbon::parse($evento["fin"])->format('H:i'), 1);
                        $pdf->Rect(140, $y, 56, $y2 - $y);
                        $diferencia = round((($y2 - $y) - (($evento["tipo"]==1?sizeof($evento["responsables"]):1) * 6) ) / 2);
                        $pdf->SetXY(140, $y + $diferencia);
                        $pdf->MultiCell(56, 6, ($evento["tipo"]==1?implode(PHP_EOL, $evento["responsables"]):utf8_decode("Todas las áreas")), 0);
                        $pdf->SetXY(20, $y2);
                    } else {
                        $pdf->SetX(85);
                        $pdf->MultiCell(55, 6, audParseCase::parseProcesoPDF($areas), 1);
                        $y2 = $pdf->GetY();
                        $pdf->Rect(20, $y, 25, $y2 - $y);
                        $primera_div_procesos = explode(PHP_EOL, $rec_procesos);
                        $lineas = ceil(strlen($primera_div_procesos[0]) / 21);
                        for ($i = 1; $i < sizeof($primera_div_procesos); $i++) {
                            $segunda_div_procesos = explode(" ", $primera_div_procesos[$i]);
                            $anterior = 0;
                            $suma = 0;
                            for ($j = 0; $j < sizeof($segunda_div_procesos); $j++) {
                                if ($suma == 0)
                                    $suma += $anterior;
                                $suma += strlen($segunda_div_procesos[$j]);
                                if ($suma >= 19) {
                                    $lineas++;
                                    $suma = 0;
                                    $anterior = strlen($segunda_div_procesos[$j]);
                                }
                            }
                            if ($suma > 0)
                                $lineas++;
                        }
                        if ($lineas > $lineas_areas)
                            $diferencia = 0;
                        else
                            $diferencia = round(($y2 - $y) - ((ceil($lineas_procesos) + (substr_count($rec_procesos, PHP_EOL))) * 6) / 2);

                        $pdf->SetXY(45, $y + 0);
                        $pdf->MultiCell(40, 6, audParseCase::parseNombrePDF($rec_procesos), 0);
                        $pdf->Rect(45, $y, 40, $y2 - $y);
                        $pdf->SetXY(20, $y);
                        $pdf->MultiCell(25, $y2 - $y, Carbon::parse($evento["inicio"])->format('H:i')."-".Carbon::parse($evento["fin"])->format('H:i'), 1);
                        $pdf->Rect(140, $y, 56, $y2 - $y);
                        $diferencia = round((($y2 - $y) - (($evento["tipo"]==1?sizeof($evento["responsables"]):1) * 6)) / 2);
                        $pdf->SetXY(140, $y + $diferencia);
                        $pdf->MultiCell(56, 6, ($evento["tipo"]==1?implode(PHP_EOL, $evento["responsables"]):utf8_decode("Todas las áreas")), 0);
                        $pdf->SetXY(20, $y2);
                    }
                }
            }
        }

        /*foreach ($fechas as $fecha){
            $pdf->Cell(176,6,utf8_decode(mb_strtolower(date('d',strtotime($fecha->fecha)).' de '.$pdf->toSpanish(date('M',strtotime($fecha->fecha))))),1,1);
            $eventos=DB::table('aud_agenda')
                ->join('gnral_unidad_administrativa','aud_agenda.id_area','=','gnral_unidad_administrativa.id_unidad_admin')
                ->where('aud_agenda.fecha','=',$fecha->fecha)
                ->select('aud_agenda.id_agenda','aud_agenda.hora_i','aud_agenda.hora_f','gnral_unidad_administrativa.nom_departamento','aud_agenda.criterios')
                ->orderBy('hora_i')
                ->orderBy('hora_f')
                ->get();
//            $eventos=AudAgenda::where('fecha','=',$fecha->fecha)->orderBy('hora_i')->orderBy('hora_f')->get();
            $pdf->SetFont('Helvetica','','11');
            foreach ($eventos as $evento){
                if ($pdf->GetY()>200){
                    $pdf->AddPage();
                }
                $y=$pdf->GetY();
                $procesos=[];
                foreach (AudAgenda::getProcesos($evento->id_agenda) as $proceso)
                    array_push($procesos,audParseCase::parseProcesoPDF($proceso->proceso));
                $pdf->SetX(45);
                $pdf->MultiCell(40,6,$evento->criterios.PHP_EOL.implode(", ",$procesos),1);
                $y2=$pdf->GetY();

                $pdf->Rect(85,$y,55,$y2-$y);

                $diferencia=round((($y2-$y)-(ceil(strlen($evento->nom_departamento)/27))*6)/2);
                $pdf->SetXY(85,$y+$diferencia);
                $pdf->MultiCell(55,6,audParseCase::parseNombrePDF($evento->nom_departamento),0);

                $pdf->SetXY(20,$y);
                $pdf->MultiCell(25,$y2-$y,$evento->hora_i,1);

                $pdf->SetY($y);
                $auditores=[];
                foreach(AudAgenda::getAuditores($evento->id_agenda) as $auditor){
                    if($auditor->id_categoria==1)array_push($auditores,'Auditor Lider');
                    else{
                        $i=0;
                        foreach(AudAuditorias::getAuditores($id,2) as $audT){
                            $i++;
                            if($audT->nombre==$auditor->nombre)array_push($auditores,'Auditor '.$i);
                        }
                        $i=0;
                        foreach(\App\AudAuditorias::getAuditores($id,3) as $audT){
                            $i++;
                            if($audT->nombre==$auditor->nombre)array_push($auditores,'AE '.$i);
                        }
                    }

                }

                $pdf->SetXY(140,$y);
                $pdf->MultiCell(56,$y2-$y,implode($auditores),1);
            }
        }*/

        $pdf->Ln(5);
        $pdf->SetX(35);
        $pdf->Cell(65,5,utf8_decode('Elaboró'),0,0,'C');
        $pdf->SetX(115);
        $pdf->Cell(65,5,utf8_decode('Aprobó'),0,0,'C');

        $pdf->Ln(20);
        $pdf->SetX(35);
        $pdf->Cell(65,0,'',1,0,'C');
        $pdf->SetX(115);
        $pdf->Cell(65,0,'',1,0,'C');

        $pdf->Ln();
        $pdf->SetX(25);
        $y=$pdf->GetY();
        $lider=AudPrint::getFirmaPrograma(1);
        $pdf->MultiCell(80,5,audParseCase::parseAbr($lider->titulo).' '.audParseCase::parseNombrePDF($lider->nombre),0,'C');
        $pdf->SetX(25);
        $pdf->Cell(80,5,utf8_decode('Auditor Líder'),0,0,'C');
        $pdf->SetXY(110,$y);


        if ($aprueba==1){
            $sgc=AudPrint::getFirmaPrograma(2);
            $pdf->MultiCell(80,5,audParseCase::parseAbr($sgc->titulo).' '.audParseCase::parseNombrePDF($sgc->nombre),0,'C');
            $pdf->SetX(110);
            $pdf->MultiCell(80,5,utf8_decode('Coordinadora del Sistema de Gestión de la Calidad'),0,'C');
        }
        else if($aprueba==2){
            $director=AudPrint::getFirmaPrograma(3);
            $pdf->MultiCell(80,5,audParseCase::parseAbr($director->titulo).' '.audParseCase::parseNombrePDF($director->nombre),0,'C');
            $pdf->SetX(110);
            $pdf->MultiCell(80,5,utf8_decode('Director General'),0,'C');
        }

        $pdf->Output();
        exit();
    }

    public static function printProgramaExcel($id,$aprueba){
        $data=AudPrint::getDataProgram($id);
        $procesos=$data->procesos;
        $auditorias=$data->auditorias;
        $programa=$data->programa;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getPageMargins()->setTop(1.6);
        $sheet->getPageMargins()->setRight(0.787402);
        $sheet->getPageMargins()->setLeft(0.787402);
        $sheet->getPageMargins()->setBottom(1.6);

        $sheet->getPageSetup()->setPrintArea('A1:X20,A22:X42,A44:X64');

        $sheet->getPageSetup()->setFitToPage(true);


//        *************************ENCABEZADO Y PIE DE PAGINA DEL EXCEL*************************

       /* $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');
        $sheet->getHeaderFooter()
            ->setOddHeader('&B&C&11 '.utf8_decode($etiqueta->descripcion));

        $etiqueta='"2019. Año del Centésimo Aniversario de Emiliano Zapata salazar. El Caudillo del sur"';
        $sheet->getHeaderFooter()
            ->setOddHeader('&B&C&11 '.$etiqueta);



        $logo = new \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing();
        $logo->setName('Header Logo');
        $logo->setPath(public_path('img\logos\ArmasBN.png'));
        $logo->setWidth(40);
//        $logo->setCoordinates('A1');
//        $logo->getShadow()->setVisible(true);
        $sheet->getHeaderFooter()->addImage($logo, \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooter::IMAGE_HEADER_LEFT);
//        $sheet->getHeaderFooter()->setDifferentFirst(true);*/

        $mainText = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
            'font' => [
                'bold' => true,
                'name' => 'HelveticaNeueLT Std',
                'size' => 11
            ],
        ];
        $title = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
            'font' => [
                'bold' => true,
                'name' => 'HelveticaNeueLT Std',
                'size' => 11
            ],
        ];
        $text = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
            'font' => [
                'name' => 'HelveticaNeueLT Std',
                'size' => 11
            ],
        ];
        $mainTextTable = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'font' => [
                'bold' => true,
                'name' => 'HelveticaNeueLT Std',
                'size' => 11
            ],
        ];
        $secondTextTable = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'font' => [
                'name' => 'HelveticaNeueLT Std',
                'size' => 11
            ],
        ];
        $titleTable = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'font' => [
                'name' => 'HelveticaNeueLT Std',
                'size' => 11
            ],
        ];
        $textTable = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'font' => [
                'name' => 'HelveticaNeueLT Std',
                'size' => 11
            ],
        ];
        $textFirms = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
            'font' => [
                'name' => 'HelveticaNeueLT Std',
                'size' => 11
            ],
        ];

        $programa_codigo=utf8_decode(audParseCase::toSpanish(date('M',strtotime($programa->fecha_i)))).' - '.utf8_decode(audParseCase::toSpanish(date('M',strtotime($programa->fecha_f)))).' '.date('Y',strtotime($programa->fecha_f));

        $sheet->mergeCells('A1:X1')
            ->setCellValue('A1','Programa de auditoría')
            ->getStyle('A1')
            ->applyFromArray($mainText);

        $sheet->mergeCells('A4:C4')
            ->setCellValue('A4','Periodo:')
            ->getStyle('A4')
            ->applyFromArray($title);
        $sheet->mergeCells('D4:L4')
            ->setCellValue('D4',$programa_codigo)
            ->getStyle('D4')
            ->applyFromArray($text);

        $sheet->mergeCells('M4:O4')
            ->setCellValue('M4','Lugar:')
            ->getStyle('M4')
            ->applyFromArray($title);
        $sheet->mergeCells('P4:X4')
            ->setCellValue('P4',$programa->lugar)
            ->getRowDimension('4')
            ->setRowHeight(AudPrint::getNoRows($programa->lugar,40));
        $sheet->getStyle('P4')
            ->applyFromArray($text);

        $sheet->mergeCells('A6:X6')
            ->setCellValue('A6','Alcance del programa de auditorías:')
            ->getStyle('A6')
            ->applyFromArray($title);
        $sheet->mergeCells('A7:X7')
            ->setCellValue('A7',$programa->alcance)
            ->getRowDimension('7')
            ->setRowHeight(AudPrint::getNoRows($programa->alcance,100));
        $sheet->getStyle('A7')
            ->applyFromArray($text);

        $sheet->mergeCells('A9:X9')
            ->setCellValue('A9','Objetivo del programa de auditorías:')
            ->getStyle('A9')
            ->applyFromArray($title);
        $sheet->mergeCells('A10:X10')
            ->setCellValue('A10',$programa->objetivo)
            ->getRowDimension('10')
            ->setRowHeight(AudPrint::getNoRows($programa->objetivo,100));
        $sheet->getStyle('A10')
            ->applyFromArray($text);

        $sheet->mergeCells('A12:X12')
            ->setCellValue('A12','Métodos:')
            ->getStyle('A12')
            ->applyFromArray($title);
        $sheet->mergeCells('A13:X13')
            ->setCellValue('A13',$programa->metodos)
            ->getRowDimension('13')
            ->setRowHeight(AudPrint::getNoRows($programa->metodos,100));
        $sheet->getStyle('A13')
            ->applyFromArray($text);

        $sheet->mergeCells('A15:X15')
            ->setCellValue('A15','Responsabilidades:')
            ->getStyle('A15')
            ->applyFromArray($title);
        $sheet->mergeCells('A16:X16')
            ->setCellValue('A16',$programa->responsabilidades)
            ->getRowDimension('16')
            ->setRowHeight(AudPrint::getNoRows($programa->responsabilidades,100));
        $sheet->getStyle('A16')
            ->applyFromArray($text);

        $sheet->mergeCells('A18:X18')
            ->setCellValue('A18','Planeación:')
            ->getStyle('A18')
            ->applyFromArray($title);

        $sheet->mergeCells('A19:H19')
            ->setCellValue('A19','Recursos:')
            ->getStyle('A19')
            ->applyFromArray($mainTextTable);
        $sheet->mergeCells('I19:P19')
            ->setCellValue('I19','Requisitos:')
            ->getStyle('I19')
            ->applyFromArray($mainTextTable);
        $sheet->mergeCells('Q19:X19')
            ->setCellValue('Q19','Criterios de aceptación:')
            ->getStyle('Q19')
            ->applyFromArray($mainTextTable);

        $sheet->mergeCells('A20:H20')
            ->setCellValue('A20',$programa->recursos)
            ->getStyle('A20')
            ->applyFromArray($secondTextTable);
        $sheet->mergeCells('I20:P20')
            ->setCellValue('I20',$programa->requisitos)
            ->getStyle('I20')
            ->applyFromArray($secondTextTable);
        $sheet->mergeCells('Q20:X20')
            ->setCellValue('Q20',$programa->criterios)
            ->getStyle('Q20')
            ->applyFromArray($secondTextTable);
        $sheet->getRowDimension('20')
            ->setRowHeight(AudPrint::getNoRowsArray([$programa->recursos,$programa->requisitos,$programa->criterios],30));

        $sheet->mergeCells('A22:X22')
            ->setCellValue('A22','Programación:')
            ->getStyle('A22')
            ->applyFromArray($title);


        $sheet->mergeCells('A23:A24')
            ->setCellValue('A23', 'No.')
            ->getStyle('A23')
            ->applyFromArray($titleTable);
        $sheet->mergeCells('B23:K24')
            ->setCellValue('B23', 'Cláusula/Proceso o actividad')
            ->getStyle('B23')
            ->applyFromArray($titleTable);
        $sheet->mergeCells('L23:P23')
            ->setCellValue('L23','Mes')
            ->getStyle('L23')
            ->applyFromArray($titleTable);
        $sheet->mergeCells('Q23:X24')
            ->setCellValue('Q23', 'Observaciones')
            ->getStyle('Q23')
            ->applyFromArray($titleTable);

        $cell=25;
        $arrayProcesos=$procesos->toArray();

        for ($i=0;$i<count($procesos);$i++){
            $sheet->setCellValue('A'.$cell,($i+1))
                ->getStyle('A'.$cell)
                ->applyFromArray($titleTable);
            $sheet->mergeCells('B'.$cell.':K'.$cell)
                ->setCellValue('B'.$cell,audParseCase::parseProceso($arrayProcesos[$i]['des_proceso']))
                ->getStyle('B'.$cell)
                ->applyFromArray($textTable);
            $iteracion=0;
            $auditorias=['L','M','N','O','P'];
            foreach ($arrayProcesos[$i]['fechas'] as $fecha){
                $sheet->setCellValue($auditorias[$iteracion].$cell,$fecha)
                    ->getStyle($auditorias[$iteracion].$cell)
                    ->applyFromArray($titleTable);
               $iteracion++;
            }

            for (;$iteracion<5;$iteracion++){
                $sheet->setCellValue($auditorias[$iteracion].$cell,'')
                    ->getStyle($auditorias[$iteracion].$cell)
                    ->applyFromArray($titleTable);
            }

            $sheet->mergeCells('Q'.$cell.':X'.$cell)
                ->setCellValue('Q'.$cell,audParseCase::parseProceso($arrayProcesos[$i]['observaciones']))
                ->getStyle('Q'.$cell)
                ->applyFromArray($textTable);
            $sheet->getRowDimension($cell)
                ->setRowHeight(AudPrint::getNoRowsArrayTable([$arrayProcesos[$i]['des_proceso'],$arrayProcesos[$i]['observaciones']],[42,30]));
            $cell++;
            if ($cell==43)
                $cell=44;
        }

        $cell++;
        $sheet->mergeCells('C'.$cell.':J'.$cell)
            ->setCellValue('C'.$cell,"Elaboró")
            ->getStyle('C'.$cell)
            ->getBorders()
            ->getBottom()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->mergeCells('O'.$cell.':V'.$cell)
            ->setCellValue('O'.$cell,"Aprobó")
            ->getStyle('O'.$cell)
            ->getBorders()
            ->getBottom()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('C'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('O'.$cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C'.$cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle('O'.$cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getRowDimension($cell)->setRowHeight(45);

        $lider=AudPrint::getFirmaPrograma(1);
        $p_lider=audParseCase::parseAbr($lider->titulo).' '.audParseCase::parseNombre($lider->nombre).PHP_EOL.'Auditor Líder';
        if ($aprueba==1)
            $P_aprueba=AudPrint::getFirmaPrograma(2);
        else if ($aprueba==2)
            $P_aprueba=AudPrint::getFirmaPrograma(3);
        $p_aprueba=audParseCase::parseAbr($P_aprueba->titulo).' '.audParseCase::parseNombre($P_aprueba->nombre);
        $cell++;

        $sheet->mergeCells('C'.$cell.':J'.$cell)
            ->setCellValue('C'.$cell,$p_lider)
            ->getStyle('C'.$cell)
            ->applyFromArray($textFirms);
        if ($aprueba==1){
            $p_aprueba.=PHP_EOL.'Coordinadora del Sistema de Gestión de la Calidad';
            $sheet->mergeCells('O'.$cell.':V'.$cell)
                ->setCellValue('O'.$cell,$p_aprueba)
                ->getStyle('O'.$cell)
                ->applyFromArray($textFirms);
        }
        else if ($aprueba==2){
            $p_aprueba.=PHP_EOL.'Director General';
            $sheet->mergeCells('O'.$cell.':V'.$cell)
                ->setCellValue('O'.$cell,$p_aprueba)
                ->getStyle('O'.$cell)
                ->applyFromArray($textFirms);
        }
        $sheet->getRowDimension($cell)->setRowHeight(AudPrint::getNoRowsArrayFirms([$p_lider,$p_aprueba],30));



        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setWidth(4);
        $sheet->getColumnDimension('C')->setWidth(4);
        $sheet->getColumnDimension('D')->setWidth(4);
        $sheet->getColumnDimension('E')->setWidth(4);
        $sheet->getColumnDimension('F')->setWidth(4);
        $sheet->getColumnDimension('G')->setWidth(4);
        $sheet->getColumnDimension('H')->setWidth(4);
        $sheet->getColumnDimension('I')->setWidth(4);
        $sheet->getColumnDimension('J')->setWidth(4);
        $sheet->getColumnDimension('K')->setWidth(4);
        $sheet->getColumnDimension('L')->setWidth(4);
        $sheet->getColumnDimension('M')->setWidth(4);
        $sheet->getColumnDimension('N')->setWidth(4);
        $sheet->getColumnDimension('O')->setWidth(4);
        $sheet->getColumnDimension('P')->setWidth(4);
        $sheet->getColumnDimension('Q')->setWidth(4);
        $sheet->getColumnDimension('R')->setWidth(4);
        $sheet->getColumnDimension('S')->setWidth(4);
        $sheet->getColumnDimension('T')->setWidth(4);
        $sheet->getColumnDimension('U')->setWidth(4);
        $sheet->getColumnDimension('V')->setWidth(4);
        $sheet->getColumnDimension('W')->setWidth(4);
        $sheet->getColumnDimension('X')->setWidth(4);

        $sheet->getStyle('A1:X'.$cell)->getAlignment()->setWrapText(true);

        $writer = new Xlsx($spreadsheet);
        $writer->save('Programa de Auditoría '.$programa_codigo.'xlsx');
        Excel::load('Programa de Auditoría '.$programa_codigo.'xlsx')->export('xlsx');
    }

    public static function constancia($id){
        $pdf=new pdf2('L','mm','Letter');
        $pdf->AddFont('MonotypeCorsiva','','MTCORSVA.php');
        $pdf->SetTitle(utf8_decode('Constancia de participación'));
        $pdf->SetMargins(20, 44 , 20, 25);
        $pdf->SetAutoPageBreak(true,5);
        $pdf->AddPage();
        $pdf->SetFont('Arial','B','25');
        $pdf->Cell(243,10,utf8_decode('Univeridad Autónoma del Estado de México'),0,1,'C');
        $pdf->SetFont('Arial','','21');
        $pdf->Cell(243,10,utf8_decode('Centro Universitario UAEM Temascaltepec'),0,0,'C');
        $pdf->Ln(13);
        $pdf->SetFont('Arial','B','21');
        $pdf->Cell(243,10,utf8_decode('Otorga la presente'),0,0,'C');
        $pdf->Ln(12);
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(243,10,utf8_decode('C  O  N  S  T  A  N  C  I  A'),0,0,'C');
        $pdf->Ln(11);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(243,10,utf8_decode('A:'),0,0,'C');
        $pdf->Ln(11);
        $pdf->SetFont('MonotypeCorsiva','I','36');
        $pdf->Cell(243,10,utf8_decode('Nombre del participante'),0,0,'C');
        $pdf->Ln(20);
        $pdf->SetFont('Arial','B','21');
        $pdf->MultiCell(243,8,utf8_decode('Por asistir a la ponencia: NOMBRE DE LA PONENCIA'),0,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','B','18');
        $pdf->MultiCell(243,8,utf8_decode('en el Foro Académico Ambiental en el Marco del 263 Aniversario del Natalicio del Ilustre Naturalista José Mariano Mociño'),0,'C');
        $pdf->Ln(8);

        //////////////////////// D E R E C H A ////////////////////////
        /*$pdf->SetFont('Arial','B','14');
        $pdf->Cell(243,8,utf8_decode('Patria, Ciencia y Trabajo'),0,0,'R');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','14');
        $pdf->Cell(243,8,utf8_decode('"2020, Año del 25 Aniversario de los Estudios de Doctorado en la UAEM"'),0,0,'R');
        $pdf->Ln(22);
        $pdf->SetFont('Arial','B','14');
        $pdf->Cell(243,8,utf8_decode('Dr. En C. Edu. Manuel Antonio Pérez Chávez'),0,0,'R');
        $pdf->Ln(6);
        $pdf->SetX(153);
        $pdf->SetFont('Arial','','14');
        $pdf->MultiCell(110,5,utf8_decode('Encargado del Despacho de la Dirección del Centro Universitario UAEM Temascaltepec'),0,'R');*/

        //////////////////////// C E N T R O ////////////////////////
        /*$pdf->SetFont('Arial','B','14');
        $pdf->Cell(243,8,utf8_decode('Patria, Ciencia y Trabajo'),0,0,'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','14');
        $pdf->Cell(243,8,utf8_decode('"2020, Año del 25 Aniversario de los Estudios de Doctorado en la UAEM"'),0,0,'C');
        $pdf->Ln(22);
        $pdf->SetFont('Arial','B','14');
        $pdf->Cell(243,8,utf8_decode('Dr. En C. Edu. Manuel Antonio Pérez Chávez'),0,0,'C');
        $pdf->Ln(6);
        $pdf->SetX(86);
        $pdf->SetFont('Arial','','14');
        $pdf->MultiCell(110,5,utf8_decode('Encargado del Despacho de la Dirección del Centro Universitario UAEM Temascaltepec'),0,'C');*/

        //////////////////////// I Z Q U I E R D A ////////////////////////
        $pdf->SetFont('Arial','B','14');
        $pdf->Cell(243,8,utf8_decode('Patria, Ciencia y Trabajo'),0,0,'L');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','14');
        $pdf->Cell(243,8,utf8_decode('"2020, Año del 25 Aniversario de los Estudios de Doctorado en la UAEM"'),0,0,'L');
        $pdf->Ln(22);
        $pdf->SetFont('Arial','B','14');
        $pdf->Cell(243,8,utf8_decode('Dr. En C. Edu. Manuel Antonio Pérez Chávez'),0,0,'L');
        $pdf->Ln(6);
        $pdf->SetX(20);
        $pdf->SetFont('Arial','','14');
        $pdf->MultiCell(110,5,utf8_decode('Encargado del Despacho de la Dirección del Centro Universitario UAEM Temascaltepec'),0,'L');


        $pdf->Output();
        exit();
    }
    public function printInforme($id,$aprueba)
    {
        //dd("ok");

        $fecha=AudAuditorias::where('id_auditoria',$id)->get()->pluck('id_programa');
        $auditorias=AudAuditorias::orderBy('fecha_i','ASC')->where('id_programa',$fecha)->get();
        $informe=AudInforme::where('id_auditoria',$id)->get()->first();
        $num_aud=0;
        $auditoria;
        foreach($auditorias as $audit) {
            $num_aud++;
            if ($audit->id_auditoria==$id)
            {
                $auditoria=$audit;
                break;
            }
        }
        $lider=AudAuditorAuditoria::where('id_auditoria',$id)->where('id_categoria','1')->get();
        $personas=AudInforme::getPersonas($id);
        $noConformidad=AudInforme::getDatosInforme($id,1);
        $fortalezas=AudInforme::getDatosInforme($id,5);
        $oportunidades=AudInforme::getDatosInforme($id,2);
        $seguimientoAcciones=AudInforme::getDatosInforme($id,4);



        $GLOBALS['no_oficio'] = "FO-TESVB-34  V.0  23/03/2018";

        $pdf = new PDF('P', 'mm', 'Letter');
        $title = utf8_decode('Informe de Auditoría');
        $pdf->SetTitle($title);
        $pdf->SetMargins(20, 25, 20);
        $pdf->SetAutoPageBreak(true, 45);
        $pdf->AddPage();

        $pdf->SetFont('Helvetica', '', '11');
        //$pdf->Ln(10);
        $pdf->Cell(176, 5, utf8_decode('Informe de Auditoría'), 0, 1, 'C');
        $pdf->Ln(10);
        $pdf->SetFont('Helvetica', '', '10');
        $y = $pdf->GetY();
        $pdf->Cell(120, 5, utf8_decode("NÚMERO DE AUDITORÍA:"), 0, 0, 'L');
        $pdf->Cell(56, 5, utf8_decode("FECHAS DE LA AUDITORIA:"), 0, 1, 'L');
        $pdf->Cell(120, 5, Carbon::parse($auditoria->fecha_i)->format('Y').'-'.$num_aud, 0, 0, 'L');//Numero de la auditoría
        $pdf->Cell(56, 5, Carbon::parse($auditoria->fecha_i)->format('d/m/Y')." al ".Carbon::parse($auditoria->fecha_f)->format('d/m/Y'), 0, 1, 'L');//Fechas de la auditoría
        $pdf->Rect(20, $y, 120, 10);
        $pdf->Rect(140, $y, 56, 10);
        $pdf->MultiCell(176, 5, utf8_decode("NORMA DE REFERENCIA \n\n".$auditoria->criterio), 1, 'C', 0);

        $pdf->Ln(8);
        $pdf->MultiCell(176,5,utf8_decode("OBJETIVO: ".$auditoria->objetivo),1,'J',0);
        $pdf->MultiCell(176,5,utf8_decode("ALCANCE: \n".$auditoria->alcance),1,'J',0);

        if($pdf->GetY()>180)
            $pdf->AddPage();
        $pdf->Ln(5);
        $pdf->SetFont('Helvetica','B','10');
        $pdf->Cell(176,5,utf8_decode('EQUIPO AUDITOR'),0,1,'C');
        $pdf->SetFont('Helvetica','','10');
        $pdf->Ln(5);
        $auditorLider="";
        foreach($lider as $auditores)
        foreach($auditores->getAbr->getAbreviatura as $auditor)
            $auditorLider=audParseCase::parseAbr($auditor->titulo).' '.\App\audParseCase::parseNombre($auditores->getName->nombre);


        $y = $pdf->GetY();
        $pdf->SetFont('Helvetica','B','10');
        $pdf->Cell(88,5,utf8_decode('AUDITOR LÍDER:'),0,1,'l');
        $pdf->Ln(5);
        $pdf->Cell(88,5,utf8_decode($auditorLider),0,1,'l');
        $pdf->SetXY(108,$y);
        $pdf->Cell(88,5,utf8_decode('AUDITORES:'),0,1,'l');
        $pdf->Ln(5);
        //$equipo=AudAuditorAuditoria::where('id_auditoria',$id)->where('id_categoria','2')->get();
        $equipo=$auditoria->getAuditores($auditoria->id_auditoria, 2);
        $i=1;
        foreach ($equipo as $auditor){
            $pdf->SetX(108);
            $pdf->SetFont('Helvetica','B','10');
            //$pdf->Cell(25,5,utf8_decode('Auditor '.$loop->iteration.':'),0,0,'l');
            $pdf->Cell(20,5,utf8_decode('Auditor '.$i.':'),0,0,'l');
            $pdf->SetFont('Helvetica','','10');
            $pdf->Cell(25,5,utf8_decode(audParseCase::parseAbr($auditor->titulo).' '.audParseCase::parseNombre($auditor->nombre)),0,1,'l');
            $i++;
        }

        //$pdf->Rect(20,$y,88,$y2-$y);
        //$pdf->Rect(108,$y,88,$y2-$y);
        $pdf->SetFont('Helvetica','B','10');
       // $y = $pdf->GetY();
        $pdf->Cell(176,5,utf8_decode('AUDITORES EN ENTRENAMIENTO:'),0,1,'l');
        $pdf->Ln(5);

        $auditores_entrenamiento = $auditoria->getAuditores($auditoria->id_auditoria, 3);
        if (sizeof($auditores_entrenamiento)>0){
            $i=1;
            foreach ($auditores_entrenamiento as $auditor_e){
                $pdf->SetFont('Helvetica','B','10');
                //$pdf->Cell(25,5,utf8_decode('Auditor '.$loop->iteration.':'),0,0,'l');
                $pdf->Cell(20,5,utf8_decode('Auditor '.$i.':'),0,0,'l');
                $pdf->SetFont('Helvetica','','10');
                $pdf->Cell(25,5,utf8_decode($auditor_e['abreviatura'].' '.$auditor_e['name']),0,1,'l');
                $i++;
            }
        }
        else {
            $pdf->SetFont('Helvetica','','10');
            $pdf->Cell(176,5,utf8_decode('No se cuenta con auditores en entrenamiento'),0,1,'l');
        }
        $y2 = $pdf->GetY();

        //$y2 = $pdf->GetY();
       $pdf->Rect(20,$y,176,$y2-$y);

        $pdf->Ln(3);
        $pdf->SetFont('Helvetica','B','10');
        $pdf->Cell(176,5,utf8_decode('INFORME DE AUDITORÍA'),0,1,'C');
        $pdf->SetFont('Helvetica','','10');

        $contenido="RESUMEN:\n\n".$informe->resumen."\n\nSe contó con la presencia de las siguientes personas:\n\n";
        foreach($personas as $key=>$persona)
            $contenido=$contenido."\t\t\t".(($key+1)."- ".$persona->nombre.", ".$persona->jefe_descripcion.($persona->funciones!=null?" ".$persona->funciones.";":";"))."\n";

        $contenido="\n\n".$contenido.$informe->cierre."\n\n REPORTES DE NO CONFORMIDAD LEVANTADOS\n\n";
        if(count($noConformidad)>0)
            foreach($noConformidad as $key=>$registro)
                $contenido=$contenido.($key+1)."- ".$registro->punto_proceso." ".$registro->resultado."\n";
        else
            $contenido=$contenido."No se encontraron  No conformidades";

        $contenido=$contenido."\n\nFORTALEZAS DEL SISTEMA: \n\n";
        if(count($fortalezas)>0)
            foreach($fortalezas as $key=>$registro)
                $contenido=$contenido.($key+1)."- ".$registro->punto_proceso." ".$registro->resultado."\n";
        else
            $contenido=$contenido."No se encontraron  fortalezas.";

        $contenido=$contenido."\n\nOPORTUNIDADES: \n\n";
        if(count($oportunidades)>0)
            foreach($oportunidades as $key=>$registro)
                $contenido=$contenido.($key+1)."- ".$registro->punto_proceso." ".$registro->resultado."\n";
        else
            $contenido=$contenido."No se encontraron  oportunidades.";

        $contenido=$contenido."\n\nSEGUIMIENTO DE ACCIONES: \n\n";
        if(count($seguimientoAcciones)>0)
            foreach($seguimientoAcciones as $key=>$registro)
                $contenido=$contenido.($key+1)."- ".$registro->punto_proceso." ".$registro->resultado."\n";
        else
            $contenido=$contenido."No se encontraron  seguimiento.";

        $contenido=$contenido."\n\nCONCLUSIONES:\n\n".$informe->conclusiones;


        $pdf->MultiCell(176,5,utf8_decode($contenido),1,'J',0);


        if($pdf->GetY()>180)
            $pdf->AddPage();


        $pdf->Ln(5);
        $pdf->SetX(35);
        $pdf->Cell(65,5,utf8_decode('Elaboró'),0,0,'C');
        $pdf->SetX(115);
        $pdf->Cell(65,5,utf8_decode('Aprobó'),0,0,'C');

        $pdf->Ln(20);
        $pdf->SetX(35);
        $pdf->Cell(65,0,'',1,0,'C');
        $pdf->SetX(115);
        $pdf->Cell(65,0,'',1,0,'C');


        $pdf->Ln();
        $pdf->SetX(25);
        $y=$pdf->GetY();
        $lider=AudPrint::getFirmaPrograma(1);
        $pdf->MultiCell(80,5,audParseCase::parseAbr($lider->titulo).' '.audParseCase::parseNombrePDF($lider->nombre),0,'C');
        $pdf->SetX(25);
        $pdf->Cell(80,5,utf8_decode('Auditor Líder'),0,0,'C');
        $pdf->SetXY(110,$y);


        if ($aprueba==1){
            $sgc=AudPrint::getFirmaPrograma(2);
            $pdf->MultiCell(80,5,audParseCase::parseAbr($sgc->titulo).' '.audParseCase::parseNombrePDF($sgc->nombre),0,'C');
            $pdf->SetX(110);
            $pdf->MultiCell(80,5,utf8_decode('Coordinadora del Sistema de Gestión de la Calidad'),0,'C');
        }
        else if($aprueba==2){
            $director=AudPrint::getFirmaPrograma(3);
            $pdf->MultiCell(80,5,audParseCase::parseAbr($director->titulo).' '.audParseCase::parseNombrePDF($director->nombre),0,'C');
            $pdf->SetX(110);
            $pdf->MultiCell(80,5,utf8_decode('Director General'),0,'C');
        }
        $y=$pdf->GetY();
        //$pdf->Cell(65,5,$y,0,0,'C');
        $pdf->Output();
        exit();
    }
}