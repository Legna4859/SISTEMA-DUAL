<?php
namespace App\Http\Controllers;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class PDF extends FPDF
{
    //CABECERA DE LA PAGINA
    function Header()
    {
        if (count($this->pages) === 1) {
            $this->Image('img/logo3.PNG', 120, 5, 80);
            $this->Image('img/edom.png', 20, 5, 50);
            $this->Ln();
        }
    }
    //PIE DE PAGINA
    function Footer()
    {
        if (count($this->pages) === 1) {
            $this->SetY(-25);
            $this->SetFont('Arial', '', 6);
            $this->Cell(100);
            $this->Image('img/personal_reporte.png', 15, 240, 190);
        }
    }
}
class reporte_quincenalController extends Controller
{
    public function index()
    {
        $pdf=new PDF();
        $pdf=new PDF($orientation='P',$unit='mm',$format='Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(10, 25 , 10);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetLineWidth(0.2);
        $pdf->SetFont('Arial','','8');
        $pdf->Cell(40);
        $pdf->Ln();
        $pdf->SetFont('Arial','','8');
        $pdf->Cell(40);
        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 2 ');
        $pdf->Cell(100,5,utf8_decode($etiqueta->descripcion),0,0,'C');
        $pdf->Ln();
        $pdf->SetFont('Arial','B','11');
        $pdf->Cell(80);
        $pdf->Cell(20,4,utf8_decode('REPORTE DE INCIDENCIAS'),0,0,'C');
        $pdf->Ln();
        $pdf->SetFont('Arial','','8');
        $pdf->Cell(125);
        $pdf->Cell(50,4,utf8_decode('Valle de Bravo, México.'),0,0,'R');

        $fechas = date("Y-m-d");
        $num=date("j",strtotime($fechas));
        $ano=date("Y", strtotime($fechas));
        $mes= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes=$mes[(date('m', strtotime($fechas))*1)-1];
        $fech= $num. ' de '.$mes.' del '.$ano;

        $pdf->Ln(4);
        $pdf->SetFont('Arial','','9');
        $pdf->Cell(135);
        $pdf->Cell(40,4,utf8_decode($fech),0,1,'R');




        $id_usuario = Session::get('usuario_alumno');
        $id_personal = DB::SelectOne('SELECT * FROM `gnral_personales` WHERE tipo_usuario='.$id_usuario.'');
        $id_personal = $id_personal->id_personal;
       
        ///////variables de sesión////////
        
        $arti = Session::get('id_articulo_solicitud');
        $desd_fecha = Session::get('id_desd_fech_solicitud');
        $hast_fecha = Session::get('id_hast_fech_solicitud');

        $articulos= DB::select('SELECT * from inc_articulos ORDER by nombre_articulo ASC');
        $fecha=DB::select("SELECT inc_articulos.nombre_articulo, gnral_personales.nombre, inc_solicitudes.fecha_req, inc_solicitudes.id_solicitud from 
        inc_solicitudes,inc_articulos, gnral_personales 
        where inc_solicitudes.id_articulo=inc_articulos.id_articulo and inc_solicitudes.id_personal=gnral_personales.id_personal 
        and fecha_req>='$desd_fecha' and fecha_req<= '$hast_fecha' 
        and inc_solicitudes.id_articulo='$arti'");
        //dd($fecha);
        $todos=DB::select("SELECT inc_articulos.nombre_articulo, gnral_personales.nombre, inc_solicitudes.fecha_req, inc_solicitudes.id_solicitud from 
        inc_solicitudes,inc_articulos, gnral_personales 
        where inc_solicitudes.id_articulo=inc_articulos.id_articulo and inc_solicitudes.id_personal=gnral_personales.id_personal 
        and fecha_req>='$desd_fecha' and fecha_req<= '$hast_fecha' 
        ORDER BY `inc_solicitudes`.`id_articulo` ASC");

        $pdf->Ln(4);
        $pdf->SetFont('Arial','','8');
        $pdf->Cell(10,4,utf8_decode("No."),1,0,'C');
        $pdf->Cell(80,4,utf8_decode("Nombre del solicitante"),1,0,'C');
        $pdf->Cell(80,4,utf8_decode("Artículo"),1,0,'C');
        $pdf->Cell(25,4,utf8_decode("Fecha"),1,1,'L');
       $i=0;
       if($arti==20){
        foreach($todos as $fecha){
            $i++;
            $pdf->SetFont('Arial','','8');
            $pdf->Cell(10,4,utf8_decode($i),1,0,'C');
            $pdf->Cell(80,4,utf8_decode($fecha->nombre),1,0,'C');
            $pdf->Cell(80,4,utf8_decode($fecha->nombre_articulo),1,0,'C');
            $pdf->Cell(25,4,utf8_decode($fecha->fecha_req),1,1,'L');
        }
       }else{
        foreach($fecha as $fecha){
            $i++;
            $pdf->SetFont('Arial','','8');
            $pdf->Cell(10,4,utf8_decode($i),1,0,'C');
            $pdf->Cell(80,4,utf8_decode($fecha->nombre),1,0,'C');
            $pdf->Cell(80,4,utf8_decode($fecha->nombre_articulo),1,0,'C');
            $pdf->Cell(25,4,utf8_decode($fecha->fecha_req),1,1,'L');
        }
    }



$pdf->Output();
exit();
    }

}
