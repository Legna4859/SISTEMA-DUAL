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
        if (count($this->pages) === 1) {-
            $this->SetY(-25);
            $this->SetFont('Arial', '', 6);
            $this->Cell(100);
            $this->Image('img/personal.PNG', 15, 240, 190);
        }
    }
}
class PdfSolicitudIncidenciaContratoController extends Controller
{
    /////////CONTRATO COLECTIVO/////////
    public function index1($id_solicitud)
    {
        
        
   $solicitud=DB::selectOne('select gnral_personales.nombre, inc_solicitudes.motivo_oficio,inc_solicitudes.fecha_req,inc_solicitudes.hora_e,inc_solicitudes.hora_st, inc_articulos.descripcion_art, inc_articulos.nombre_articulosolo 
    FROM inc_solicitudes, inc_articulos, gnral_personales
    WHERE inc_solicitudes.id_personal=gnral_personales.id_personal and id_solicitud='.$id_solicitud.'');
        

        $nombre_personal=DB::SelectOne('SELECT abreviaciones.titulo,gnral_personales.nombre, gnral_cargos.cargo FROM 
        abreviaciones, abreviaciones_prof,gnral_personales,gnral_cargos, inc_solicitudes WHERE 
        abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion 
        AND abreviaciones_prof.id_personal=gnral_personales.id_personal AND gnral_personales.id_personal=inc_solicitudes.id_personal 
        and gnral_personales.id_cargo=gnral_cargos.id_cargo and inc_solicitudes.id_solicitud='.$id_solicitud.'');
        //dd($nombre_personal);
        $nombre_jefe=DB::SelectOne('SELECT inc_solicitudes.id_solicitud,abreviaciones.titulo,gnral_personales.nombre,gnral_unidad_administrativa.clave, gnral_unidad_administrativa.jefe_descripcion 
        FROM abreviaciones, abreviaciones_prof,gnral_personales,gnral_unidad_administrativa,gnral_unidad_personal, inc_solicitudes 
        WHERE abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion
        AND abreviaciones_prof.id_personal=gnral_personales.id_personal AND gnral_personales.id_personal=inc_solicitudes.id_jefe 
        and inc_solicitudes.id_solicitud='.$id_solicitud.' and gnral_personales.id_personal=gnral_unidad_personal.id_personal 
        and gnral_unidad_personal.id_unidad_admin=gnral_unidad_administrativa.id_unidad_admin ');
       //dd($nombre_jefe);
        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');
       // $articulos= DB::select('SELECT * from inc_articulos ORDER by nombre_articulo ASC');
       // dd($articulos);
       // return view('incidencias.pdfincidencia', compact('articulos'));
       {
        $pdf=new PDF($orientation='P',$unit='mm',$format='Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(20, 25 , 20);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetLineWidth(0.2);
        $pdf->SetFont('Arial','','8');
        $pdf->Cell(40);
        $pdf->Ln();
        $pdf->SetFont('Arial','','8');
        $pdf->Cell(40);
        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1');
        $pdf->Cell(100,5,utf8_decode($etiqueta->descripcion),0,0,'C');
        $pdf->Ln();
        $pdf->SetFont('Arial','B','11');
        $pdf->Cell(80);

        $pdf->Ln(5);
        $pdf->SetFont('Arial','','8');
        $pdf->Cell(125);
        $pdf->Cell(50,4,utf8_decode('Valle de Bravo, México.'),0,0,'R');
        
        //fecha
        $fechas = date("d-m-Y");
    
        $num=date("j",strtotime($fechas));
        $ano=date("Y", strtotime($fechas));
        $mes= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes=$mes[(date('m', strtotime($fechas))*1)-1];
        $fech= $num. ' de '.$mes.' del '.$ano;

        $fecha_req=$solicitud->fecha_req;
        $num=date("j",strtotime($fecha_req));
        $ano=date("Y", strtotime($fecha_req));
         $mes=date('m', strtotime($fecha_req));
        $fecha_req= $num. '-'.$mes.'-'.$ano;
        
        $pdf->Ln(4);
        $pdf->SetFont('Arial','','9');
        $pdf->Cell(135);
        $pdf->Cell(40,4,utf8_decode($fech),0,0,'R');
        $pdf->Ln();
        $pdf->SetFont('Arial','','9');
        $pdf->Cell(147);
        $numero=$id_solicitud;
        $pdf->Cell(28,4,utf8_decode('Oficio No. '.$nombre_jefe->clave.'/'.$nombre_jefe->id_solicitud.'/'.$ano),0,0,'R');
        $pdf->SetFont('Arial','B','11');
        $pdf->Ln(10);
        $pdf->Cell(180, 5, utf8_decode($nombre_jefe->titulo.' '. $nombre_jefe->nombre), 0, 1, '');
        $pdf->Cell(180, 5, utf8_decode($nombre_jefe->jefe_descripcion), 0, 1, '');
        $pdf->SetFont('Arial','B','11');
        $pdf->Cell(80, 5, utf8_decode('DEL TECNOLÓGICO DE ESTUDIOS'), 0, 1, '');
        $pdf->Cell(80, 5, utf8_decode('SUPERIORES DE VALLE DE BRAVO'), 0, 1, '');
        $pdf->SetFont('Arial','B','11');
        $pdf->Cell(80, 5, utf8_decode('PRESENTE'), 0, 0, '');
        
    
        $pdf->Ln(10);
        $pdf->SetFont('Arial','','11');
        $pdf->MultiCell(180,5,utf8_decode('Por   medio   del   presente   me   permito   enviarle   un   coordial   saludo,  y   al   mismo   tiempo solicitar  a  usted   de   la   manera  más   atenta   y   amable,  que   con  fundamento en el/la '.$solicitud->nombre_articulosolo.' estipulado en  el  Contrato  Colectivo  del Trabajo firmado entre el TESVB y el Sindicato de trabajadores Academicos y Administrativos, que a la letra dice:'),0,'J');
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', '11');
        $pdf->MultiCell(180, 5,utf8_decode(' "'.$solicitud->descripcion_art.'"'),0,'J');
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', '11');
        $pdf->MultiCell(177, 5,utf8_decode('Con lo anterior mencionado solicito el día '.$fecha_req.' para cumplir con el siguiente motivo: '.$solicitud->motivo_oficio.'.'),0,'J',0);

        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', '11');
        $pdf->Cell(80, 5,utf8_decode('Sin otro particular por el momento, quedó de usted.'),0,0,'');
        $pdf->Ln(20);
        
        $pdf->SetFont('Arial', 'B', '10');
        $pdf->Cell(180, 10, utf8_decode('A T E N T A M E N T E'), 0, 1, 'C');
        $pdf->Ln(10);
        $pdf->Cell(180, 5, utf8_decode($nombre_personal->titulo.' '. $nombre_personal->nombre), 0, 1, 'C');
        $pdf->Cell(180, 5, utf8_decode($nombre_personal->cargo),0 , 1, 'C');
            
        $pdf->Ln(22);
        $pdf->Cell(45);
        $pdf->SetFont('Arial', 'B', '10');
        $pdf->Cell(90, 10, utf8_decode('Nombre, Fecha, Hora y Firma de autorización'), 0, 0, 'C');

        } 
//////////////////////////////NO BORRAR//////////
    $pdf->Output();
    exit();
}
///////////REGLAMENTO INTERNO////////////
public function index2($id_solicitud)

{
   /*$fechar=($fechass->fecha_req); 
   $fechass=DB::SelectOne('SELECT fecha_req FROM `inc_solicitudes` WHERE inc_solicitudes.id_personal ');*/
   $solicitud=DB::selectOne('select gnral_personales.nombre, inc_solicitudes.motivo_oficio,inc_solicitudes.fecha_req,inc_solicitudes.hora_e,inc_solicitudes.hora_st, inc_articulos.descripcion_art, inc_articulos.nombre_articulosolo 
    FROM inc_solicitudes, inc_articulos, gnral_personales
    WHERE inc_solicitudes.id_personal=gnral_personales.id_personal and id_solicitud='.$id_solicitud.'');
   

$nombre_personal=DB::SelectOne('SELECT abreviaciones.titulo,gnral_personales.nombre, gnral_cargos.cargo FROM abreviaciones, abreviaciones_prof,gnral_personales,gnral_cargos, inc_solicitudes WHERE abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion 
AND abreviaciones_prof.id_personal=gnral_personales.id_personal AND gnral_personales.id_personal=inc_solicitudes.id_personal and gnral_personales.id_cargo=gnral_cargos.id_cargo and inc_solicitudes.id_solicitud='.$id_solicitud.'');
$nombre_jefe=DB::SelectOne('SELECT gnral_unidad_administrativa.clave,inc_solicitudes.id_solicitud, abreviaciones.titulo,gnral_personales.nombre, gnral_unidad_administrativa.jefe_descripcion FROM abreviaciones, abreviaciones_prof,gnral_personales,gnral_unidad_administrativa,gnral_unidad_personal, inc_solicitudes WHERE abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion 
AND abreviaciones_prof.id_personal=gnral_personales.id_personal AND gnral_personales.id_personal=inc_solicitudes.id_jefe and inc_solicitudes.id_solicitud='.$id_solicitud.' and gnral_personales.id_personal=gnral_unidad_personal.id_personal 
and gnral_unidad_personal.id_unidad_admin=gnral_unidad_administrativa.id_unidad_admin ');
   
    $pdf=new PDF($orientation='P',$unit='mm',$format='Letter');
    #Establecemos los márgenes izquierda, arriba y derecha:

    $pdf->SetMargins(20, 25 , 20);
    $pdf->SetAutoPageBreak(true,25);
    $pdf->AddPage();
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetLineWidth(0.2);
    $pdf->SetFont('Arial','','8');
    $pdf->Cell(40);
    
    $pdf->Ln();
    $pdf->SetFont('Arial','','8');
    $pdf->Cell(40);
    $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');
    $pdf->Cell(100,5,utf8_decode($etiqueta->descripcion),0,0,'C');
    $pdf->Ln();
    $pdf->SetFont('Arial','B','11');
    $pdf->Cell(80);

    $pdf->Ln();
    $pdf->SetFont('Arial','','8');
    $pdf->Cell(125);
    $pdf->Cell(50,4,utf8_decode('Valle de Bravo,México.'),0,0,'R');
    
    //fecha
    $fechas = date("d-m-Y");
    
    $num=date("j",strtotime($fechas));
    $ano=date("Y", strtotime($fechas));
    $mes= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
    $mes=$mes[(date('m', strtotime($fechas))*1)-1];
    $fech= $num. ' de '.$mes.' del '.$ano;

    $fecha_req=$solicitud->fecha_req;
    $num=date("j",strtotime($fecha_req));
    $ano=date("Y", strtotime($fecha_req));
     $mes=date('m', strtotime($fecha_req));
    $fecha_req= $num. '-'.$mes.'-'.$ano;
    //dd($fecha_req);
    $pdf->Ln(4);
        $pdf->SetFont('Arial','','9');
        $pdf->Cell(135);
        $pdf->Cell(40,4,utf8_decode($fech),0,0,'R');
        $pdf->Ln();
        $pdf->SetFont('Arial','','9');
        $pdf->Cell(147);
        $numero=$id_solicitud;
        $pdf->Cell(28,4,utf8_decode('Oficio No. '.$nombre_jefe->clave.'/'.$nombre_jefe->id_solicitud.'/'.$ano),0,0,'R');
        $pdf->SetFont('Arial','B','11');
    
  
    $pdf->Ln();
    $pdf->Cell(180, 5, utf8_decode($nombre_jefe->titulo.' '. $nombre_jefe->nombre), 0, 1, '');
    $pdf->Cell(180, 5, utf8_decode($nombre_jefe->jefe_descripcion), 0, 1, '');
    $pdf->SetFont('Arial','B','11');
    $pdf->Cell(80, 5, utf8_decode('DEL TECNOLÓGICO DE ESTUDIOS'), 0, 1, '');
    $pdf->Cell(80, 5, utf8_decode('SUPERIORES DE VALLE DE BRAVO'), 0, 1, '');
    $pdf->SetFont('Arial','B','11');
    $pdf->Cell(80, 5, utf8_decode('PRESENTE'), 0, 0, '');

    $pdf->Ln(10);
    $pdf->SetFont('Arial','','11');
    $pdf->Cell(177,5,utf8_decode('Por medio del presente me permito enviarle un coordial saludo,y al mismo tiempo solicitar a usted de'),0,'J',1);
    $pdf->Ln(5);
    $pdf->SetFont('Arial','','11');
    $pdf->Cell(166,5,utf8_decode('la manera más atenta y amable, que con fundamento en el/la '.$solicitud->nombre_articulosolo.'estipulado en el Reglamento'),0,'J',1);
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', '11');
    $pdf->Cell(175, 5,utf8_decode('Interno del Trabajo del Tecnológico de Estudios Superiores de Valle de Bravo, que a la letra dice:'),0,'J',1);
    $pdf->Ln(6);
    $pdf->SetFont('Arial', '', '11');
    $pdf->MultiCell(177, 5,utf8_decode(' "'.$solicitud->descripcion_art.'"'),0,'J',0);
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', '11');
    $pdf->MultiCell(177, 5,utf8_decode('Con lo anterior mencionado solicito el día '.$fecha_req.' para cumplir con el siguiente motivo: '.$solicitud->motivo_oficio.''),0,'J',0);
   

        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', '11');
        $pdf->Cell(90, 5,utf8_decode('Sin otro particular por el momento, quedó de usted.'),0,0,0);

        $pdf->Ln(20);
        $pdf->SetFont('Arial', 'B', '10');
        $pdf->Cell(180, 10, utf8_decode('A T E N T A M E N T E'), 0, 1, 'C');
        $pdf->Ln(10);
        $pdf->Cell(180, 5, utf8_decode($nombre_personal->titulo.' '. $nombre_personal->nombre), 0, 1, 'C');
        $pdf->Cell(180, 5, utf8_decode($nombre_personal->cargo),0 , 1, 'C');
        
        $pdf->Ln(22);
        $pdf->Cell(45);
        $pdf->SetFont('Arial', 'B', '10');
        $pdf->Cell(90, 10, utf8_decode('Nombre, Fecha, Hora y Firma de autorización'), 0, 0, 'C');
$pdf->Output();
    exit();}}