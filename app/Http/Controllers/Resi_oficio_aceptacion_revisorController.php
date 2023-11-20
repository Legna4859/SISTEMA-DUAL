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
         $this->SetTextColor(128,128,128);
         $this->SetFont('Arial', 'B', '7');
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
        $this->Cell(145,-2,utf8_decode('FO-TESVB-95 V.0 23/03/2018'),0,0,'R');
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
class Resi_oficio_aceptacion_revisorController extends Controller
{
    public function index($id_anteproyecto)
    {
        //dd($id_anteproyecto);
        //CARRERA
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $alumno = DB::table('gnral_alumnos')
            ->where('gnral_alumnos.id_usuario', '=', $id_usuario)
            ->select('gnral_alumnos.*')
            ->get();
        $id_carrera = $alumno[0]->id_carrera;
        $jefe = DB::table('gnral_jefes_periodos')
            ->join('gnral_personales', 'gnral_jefes_periodos.id_personal', '=', 'gnral_personales.id_personal')
            ->join('abreviaciones_prof', 'abreviaciones_prof.id_personal', '=', 'gnral_personales.id_personal')
            ->join('abreviaciones', 'abreviaciones_prof.id_abreviacion', '=', 'abreviaciones.id_abreviacion')
            ->join('gnral_carreras', 'gnral_carreras.id_carrera', '=', 'gnral_jefes_periodos.id_carrera')
            ->where('gnral_jefes_periodos.id_carrera', '=', $id_carrera)
            ->where('gnral_jefes_periodos.id_periodo', '=', $periodo)
            ->where('gnral_jefes_periodos.tipo_cargo', '=', 1)
            ->select('gnral_personales.nombre', 'abreviaciones.titulo', 'gnral_carreras.nombre as carrera')
            ->get();

        $anteproyecto = DB::table('resi_proyecto')
            ->join('resi_anteproyecto', 'resi_proyecto.id_proyecto', '=', 'resi_anteproyecto.id_proyecto')
            ->where('resi_anteproyecto.id_anteproyecto', '=', $id_anteproyecto)
            ->select('resi_proyecto.nom_proyecto')
            ->get();

        $nombre_proyecto = mb_eregi_replace("[\n|\r|\n\r]", '', $anteproyecto[0]->nom_proyecto);


        $etiqueta = DB::table('etiqueta')
            ->where('id_etiqueta', '=', 1)
            ->select('etiqueta.descripcion')
            ->get();
        $etiqueta = $etiqueta[0]->descripcion;


        $dat_alumnos = mb_strtoupper($alumno[0]->nombre, 'utf-8') . " " . mb_strtoupper($alumno[0]->apaterno, 'utf-8') . " " . mb_strtoupper($alumno[0]->amaterno, 'utf-8');



        $pdf = new PDF($orientation = 'P', $unit = 'mm', $format = 'Letter');

        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(10, 25, 10);
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AddPage();

        $fechas = date("Y-m-d");

        $num = date("j", strtotime($fechas));
        $ano = date("Y", strtotime($fechas));
        $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
        $mes = $mes[(date('m', strtotime($fechas)) * 1) - 1];
        $fech = $num . ' de ' . $mes . ' del ' . $ano;

        $pdf->Ln(3);
        $pdf->SetTextColor(86,86,86);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(190,5,utf8_decode($etiqueta),0,0,'C',FALSE);
        $pdf->Ln(10);
        $pdf->SetTextColor(257,257,257);
        $pdf->SetFillColor(167,167,167);
        $pdf->SetX(80);
        $pdf->Cell(120,5,utf8_decode("OFICIO DE ACEPTACIÓN DE INFORME FINAL DE REVISOR"),0,0,'C',true);
        $pdf->Ln(15);
        $pdf->SetFont('Arial','',11);
        $pdf->SetTextColor(1,1,1);
        $pdf->Cell(190,5,utf8_decode($jefe[0]->titulo." ".$jefe[0]->nombre),0,0,'L',FALSE);
        $pdf->Ln(5);
        $pdf->Cell(190,5,utf8_decode("JEFE(A) DE DIVISIÓN DE ".$jefe[0]->carrera),0,0,'L',FALSE);
        $pdf->Ln(5);
        $pdf->Cell(190,5,utf8_decode("TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO"),0,0,'L',FALSE);
        $pdf->Ln(5);
        $pdf->Cell(190,5,utf8_decode("P R E S E N T E"),0,0,'L',FALSE);
        $pdf->Ln(20);
        $pdf->SetFont('Arial','',12);
        $pdf->MultiCell(190,5,utf8_decode("       El suscrito, en mi carácter de revisor, hago constar que después de haber revisado el Informe Final de Residencias Profesionales titulado:  "));
        $pdf->Ln(10);
        $pdf->MultiCell(190,5,utf8_decode($nombre_proyecto),0,'C');
        $pdf->Ln(10);
        $pdf->MultiCell(190,5,utf8_decode("       Presentado por el estudiante ".$dat_alumnos.", cumple con los requisitos establecidos  en el Reglamento para la Acreditación de las Residencias Profesionales. "));
        $pdf->Ln(15);
        $pdf->MultiCell(190,5,utf8_decode("       En la Ciudad de Valle de Bravo, México, a los ".$num." días del mes de ".$mes." del año ".$ano.". Se extiende la presente para los fines que al (la) interesado(a) convengan."));
        $pdf->Ln(15);
        $pdf->Cell(190,5,utf8_decode('ATENTAMENTE'),0,0,'C',FALSE);
        $pdf->Ln(15);
        //$pdf->Cell(190,5,utf8_decode($asesorint),0,0,'C',FALSE);
        $pdf->Ln(5);
        $pdf->Cell(190,5,utf8_decode('Nombre y Firma del Revisor'),0,0,'C',FALSE);



        $pdf->Output();

        exit();
    }
}
