<?php

namespace App\Http\Controllers;

use App\SgcAgenda;
use App\SgcNotas;
use App\SgcReportes;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use App\Extensiones\calcular_pdf;
use Illuminate\Support\Facades\Session;

class PDF extends FPDF
{
    function Header(){
        $this->Image('img/logos/ArmasBN.png',10,9,40);
        $this->Image('img/tes.png',135,9,27);
        $this->SetFillColor('120','120','120');
        $this->Rect(165,8,1,12,'F');
        $this->Image('img/logos/EdoMEXcolor.png',169,9,35);
        $this->SetDrawColor(0,0,0);
        $this->SetFont('Helvetica','B','9');
        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');
        $this->Cell(176,5,utf8_decode($etiqueta->descripcion),0,1,'C');
    }

    function Footer(){

        $this->SetY(-33);
        $this->SetFont('Helvetica','',5.5);
        $this->Image('img/sgc.PNG',40,242,20);
        $this->Image('img/sga.PNG',65,242,20);
        $this->Cell(186,3,utf8_decode('FO-TESVB-23  V.0  23-03-2018'),0,1,'R');
        $this->SetFont('Helvetica','B',5.5);
        $this->Cell(186,3,utf8_decode('SECRETARÍA DE EDUCACIÓN'),0,1,'R');
        $this->SetTextColor(120,120,120);
        $this->Cell(186,3,utf8_decode('SUBSECRETARÍA DE EDUCACIÓN SUPERIOR Y NORMAL'),0,1,'R');
//        $this->SetTextColor(180,180,180);
        $this->SetTextColor(150,150,150);
        $this->Cell(186,3,utf8_decode('TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO'),0,1,'R');
        $this->SetTextColor(180,180,180);
        $this->Cell(186,3,utf8_decode('DIRECCIÓN ACADÉMICA'),0,1,'R');
        $this->SetMargins(40,10,10);
        $this->SetFillColor(120,120,120);
        $this->Rect($this->GetX()+10,$this->GetY(),210,12  ,'F');
        $this->Image('img/logos/Mesquina.png',0,$this->GetY()-20,40);
        $this->SetTextColor(255,255,255);
        $this->Ln();
        $this->SetY($this->Gety()-3);
        $this->SetFont('Helvetica','B',9);
        $this->Cell(160,4,utf8_decode('Km. 30 de la Carretera Federal Monumento - Valle de Bravo, Ejido de San Antonio de la Laguna,'),0,1,'L');
        $this->Cell(160,4,utf8_decode('Valle de Bravo, Estado de México, C.P. 51200.'),0,1,'L');
        $this->SetFont('Helvetica','',9);
        $this->Cell(160,4,utf8_decode('Tels.: (726) 26 6 52 00, 26 6 50 77, 26 6 51 87  Ext: 103              dir.académica@tesvb.edu.mx '),0,1,'L');
    }
}

class SgcPdfHojaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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


        $agenda=SgcAgenda::get()->where('id_agenda',$id);
        $reporte=SgcReportes::get()->where('id_agenda',$id);
        foreach ($agenda as $agendas){
            $auditoria=$agendas->getAsign;
        }
        foreach ($reporte as $rep){
            Session::put('id_reporte',$rep->id_reporte);
        }
        if (Session::get('id_reporte')){
            $notas=SgcNotas::get()->where('id_reporte',Session::get('id_reporte'));
            foreach ($agenda as $ag){
                $array_procesos=explode(',',$ag->procesos);
                for($i=0;$i<sizeof($array_procesos);$i++) $array_procesos[$i]=ltrim($array_procesos[$i]);
                foreach ($notas as $nota){
                    $i=array_search(ltrim($nota->proceso),$array_procesos);
                    if($i>=0)
                        unset($array_procesos[$i]);
                }
            }
        }



        $pdf=new PDF('P','mm','Letter');
        $title = 'Hoja de trabajo '.$id;
        $pdf->SetTitle($title);
        $pdf->SetMargins(20, 25 , 20, 25);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();
        $pdf->SetFont('Helvetica','B','12');
        $pdf->Ln(10);
        $pdf->Cell(176,5,utf8_decode('Hoja de trabajo'),0,1,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Helvetica','B','11');
        $pdf->Cell(12,5,utf8_decode('Área:'));
        $pdf->SetFont('Helvetica','','11');
        foreach($agenda as $datosA){
            $pdf->MultiCell(110,5,utf8_decode($datosA->area[0]->nom_departamento));
        }
        $pdf->SetXY(147,55);
        $pdf->SetFont('Helvetica','B','11');
        $pdf->Cell(28,5,utf8_decode('Auditoria No.:'));
        $pdf->SetFont('Helvetica','','11');
        $pdf->MultiCell(26,5,utf8_decode(date('Y',strtotime($auditoria->getAuditoria->fecha_i)).' - '.$auditoria->getAuditoria->id_auditoria));
        $pdf->Ln(7);
        $pdf->SetFont('Helvetica','B','11');
        $pdf->Cell(20,5,utf8_decode('Auditado:'));
        $pdf->SetFont('Helvetica','','11');
        foreach($agenda as $datosA){
            if(isset($datosA->area[0]->jefeArea[0]->jefe->nombre)) {
                $pdf->MultiCell(100, 5, utf8_decode($datosA->area[0]->jefeArea[0]->jefe->nombre));
            }
            else{
                $pdf->SetFont('Helvetica','B','11');
                $pdf->MultiCell(100, 5, utf8_decode("Falta dáto del jefe del Área"));
            }

        }
        $pdf->SetFont('Helvetica','B','11');
        $pdf->SetXY(147,67);
        $pdf->Cell(15,5,utf8_decode('Fecha:'));
        $pdf->SetFont('Helvetica','','11');
        foreach($agenda as $datosA){
            $pdf->MultiCell(30,5,utf8_decode(date('d/m/Y',strtotime($datosA->fecha))));
        }
        $pdf->Ln(5);
        $pdf->SetFont('Helvetica','B',11);
        $pdf->Cell(142,8,'Notas',1,0,'C');
        $pdf->Cell(34,8,'',1,1);
        $pdf->SetFont('Helvetica','',11);
        foreach ($notas as $nota){
            $x=$pdf->GetX();
            $y=$pdf->GetY();
            $pdf->MultiCell(142,8,utf8_decode($nota->proceso.': '.$nota->descripcion),1);
            $y2=$pdf->GetY();
            $pdf->SetXY(162,$y);
            $pdf->MultiCell(0,($y2-$y),utf8_decode($nota->getClasificacion->descripcion),1);

        }
        $pdf->Ln(30);
        $pdf->SetX(60);
        $pdf->Line($pdf->GetX(),$pdf->GetY(),$pdf->GetX()+96,$pdf->GetY());
        $pdf->Ln(3);
        foreach($agenda as $datosA){
            $pdf->SetX(60);
            $pdf->Cell(96,5,utf8_decode("AUDITOR"),0,1,'C');
            $pdf->SetX(60);
            $pdf->Cell(96,5,utf8_decode($datosA->getAsign->getAbrPer[0]->abreviaciones->titulo." ".$datosA->getAsign->getNombre[0]->nombre),0,1,'C');
        }
        $pdf->Output();
        exit();
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
}
