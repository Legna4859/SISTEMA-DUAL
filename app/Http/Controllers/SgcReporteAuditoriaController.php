<?php

namespace App\Http\Controllers;

use App\SgcAuditorias;
use App\SgcPrograma;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        //$this->Cell(186,3,utf8_decode('FO-TESVB-23  V.0  23-03-2018'),0,1,'R');
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

class SgcReporteAuditoriaController extends Controller
{
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
        $data = json_decode($id);
        $pdf=new PDF('P','mm','Letter');
        $title = 'Informe Final';
        $pdf->SetTitle($title);
        $pdf->SetMargins(20, 25 , 20, 25);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();
        $pdf->SetFont('Helvetica','B','12');
        $pdf->Ln(10);
        $pdf->Cell(176,5,utf8_decode('Informe del programa de auditoria '.$data[0]),0,1,'C');
        $pdf->Ln(10);
        foreach ($data as $datos){
            if(isset($datos->proceso)){
                $pdf->SetFont('Helvetica','B','12');
                $pdf->Cell(176,5,utf8_decode($datos->proceso),0,1);
                $pdf->SetFont('Helvetica','','12');
                $pdf->MultiCell(176,5,utf8_decode($datos->descripcion),0,1);
                $pdf->Ln(5);
            }
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
//       $notas= DB::table('aud_notas')
//            ->join('aud_reportes', function ($join) {
//                $join->on('aud_reportes.id_reporte', '=', 'aud_notas.id_reporte')
//                    ->where('aud_reportes.id_agenda', '=', 30);
//            })
//           ->joinSub('aud_agenda', function ($join) {
//               $join->on('aud_reportes.id_agenda', '=', 'aud_agenda.id_agenda')
//                   ->where('aud_agenda.id_asigna_audi', '=', 50);
//           })
//            ->get();

        $notas=DB::select('Select aud_auditoria.fecha_i, aud_auditoria.fecha_f, aud_notas.proceso,aud_notas.descripcion from aud_auditoria, aud_notas WHERE id_reporte in (SELECT id_reporte from aud_reportes WHERE id_agenda in (SELECT id_agenda from aud_agenda where id_asigna_audi in (SELECT id_asigna_audi from aud_asigna_audi where id_auditoria in (SELECT id_auditoria FROM aud_auditoria where id_programa=10)))) ');
        $programas=SgcPrograma::get()->where('id_programa',$id);
        $auditorias=SgcAuditorias::get()->where('id_programa',$id);
        return view('sgc.reporte_final',compact('programas','programas','auditorias','notas'));
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
