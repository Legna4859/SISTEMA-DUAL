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
        $this->Image('img/logo3.PNG', 140, 5, 60);
        $this->Image('img/residencia/log_estado.jpg', 10, 5, 30);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', '7');
        $this->Cell(190, 3, utf8_decode('RESIDENCIA PROFESIONAL'), 0, 1, 'C');
        $this->Cell(190, 3, utf8_decode('FORMATO DE EVALUACIÓN'), 0, 0, 'C');
        $this->Ln(8);

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
        $this->Cell(48);
        $this->Cell(145,-2,utf8_decode('FO-TESVB-97 V.0 23/03/2018'),0,0,'R');
        $this->Ln(3);
        $this->Cell(48);
        $this->Cell(145,-2,utf8_decode('SECRETARÍA DE EDUCACIÓN'),0,0,'R');
        $this->Ln(3);
        $this->Cell(48);
        $this->Cell(145,-2,utf8_decode('SUBSECRETARÍA DE EDUCACIÓN SUPERIOR Y NORMAL'),0,0,'R');
        $this->Ln(3);
        $this->Cell(48);
        $this->Cell(145,-2,utf8_decode('TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO'),0,0,'R');
        $this->Ln(3);
        $this->Cell(48);
        $this->Cell(145,-2,utf8_decode('DEPARTAMENTO DE SERVICIO SOCIAL Y RESIDENCIA PROFESIONAL'),0,0,'R');
        $this->Cell(280);
        $this->SetMargins(0,0,0);
        $this->Ln(0);
        $this->SetXY(38,267);
        $this->SetFillColor(120,120,120);
        $this->SetTextColor(255,255,255);
        $this->SetFont('Arial','B',8);
        $this->Cell(170,4,utf8_decode('      Km. 30 de la Carretera Federal Monumento - Valle de Bravo, Ejido de San Antonio de la Laguna,'),0,0,'L',TRUE);
        $this->Ln(3);
        $this->Cell(38);
        $this->SetFont('Arial','B',8);
        $this->Cell(170,4,utf8_decode('      Valle de Bravo, Estado de México, C.P. 51200.'),0,0,'L',TRUE);
        $this->Ln(3);
        $this->Cell(38);
        $this->SetFont('Arial','',8);
        $this->Cell(170,4,utf8_decode('     Tels.:(726)26 6 52 00, 26 6 51 87 EXT. 144      servicio.social@vbravo.tecnm.mx'),0,0,'L',true);

        $this->Image('img/logos/Mesquina.jpg',0,247,38);
    }
}

class Resi_pdf_formato_evaluacionController extends Controller
{
    public function index($id_anteproyecto)
    {

        $datos=DB::table('resi_anteproyecto')
            ->join('gnral_alumnos','gnral_alumnos.id_alumno','=','resi_anteproyecto.id_alumno')
            ->join('gnral_carreras','gnral_carreras.id_carrera','=','gnral_alumnos.id_carrera')
            ->join('resi_proy_empresa','resi_proy_empresa.id_anteproyecto','=','resi_anteproyecto.id_anteproyecto')
            ->join('resi_empresa','resi_empresa.id_empresa','=','resi_proy_empresa.id_empresa')
            ->join('resi_proyecto','resi_anteproyecto.id_proyecto','=','resi_proyecto.id_proyecto')
            ->where('resi_anteproyecto.id_anteproyecto','=',$id_anteproyecto)
            ->select('gnral_carreras.nombre as  carrera','gnral_alumnos.nombre','gnral_alumnos.apaterno',
'gnral_alumnos.amaterno','resi_proyecto.nom_proyecto','resi_empresa.nombre as empresa','gnral_alumnos.cuenta')
            ->get();

          $carrera = mb_strtoupper($datos[0]->carrera);
        $nombre = mb_strtoupper($datos[0]->nombre . ' ' . $datos[0]->apaterno . ' ' . $datos[0]->amaterno);
        $nombre_proyecto = $datos[0]->nom_proyecto;
        $nombre_proyecto = mb_eregi_replace("[\n|\r|\n\r]", '', $nombre_proyecto);
        $nombre_proyecto = mb_strtoupper($nombre_proyecto);

        $nombre_asesor_externo=DB::table('resi_proy_empresa')
            ->join('resi_empresa','resi_empresa.id_empresa','=','resi_proy_empresa.id_empresa')
            ->where('resi_proy_empresa.id_anteproyecto','=',$id_anteproyecto)
            ->select('resi_proy_empresa.*','resi_empresa.dir_gral')
            ->get();
        $calificaciones=DB::table('resi_calificar_residencia')
            ->where('resi_calificar_residencia.id_anteproyecto','=',$id_anteproyecto)
            ->select('resi_calificar_residencia.*')
            ->get();
        $calificacion_final=DB::table('resi_promedio_general_residencia')
            ->where('resi_promedio_general_residencia.id_anteproyecto','=',$id_anteproyecto)
            ->select('resi_promedio_general_residencia.*')
            ->get();
        $calificacion_final=$calificacion_final[0]->promedio_general;

        $nombre_externo=$nombre_asesor_externo[0]->asesor;
        $puesto=$nombre_asesor_externo[0]->puesto;
        $asesor=DB::table('resi_asesores')
            ->join('gnral_personales','resi_asesores.id_profesor','=','gnral_personales.id_personal')
            ->join('abreviaciones_prof','abreviaciones_prof.id_personal','=','gnral_personales.id_personal')
            ->join('abreviaciones','abreviaciones_prof.id_abreviacion','=','abreviaciones.id_abreviacion')
            ->where('resi_asesores.id_anteproyecto','=',$id_anteproyecto)
            ->select('gnral_personales.nombre','abreviaciones.titulo')
            ->get();
        $nombre_asesor=mb_strtoupper($asesor[0]->titulo,'utf-8')." ".mb_strtoupper($asesor[0]->nombre,'utf-8');
        $fecha_inicial=DB::table('resi_cronograma')
            ->where('resi_cronograma.id_anteproyecto','=',$id_anteproyecto)
            ->select(DB::raw('MIN(resi_cronograma.f_inicio) as fecha_inicial'))
            ->get();
        $fecha_inicial=$fecha_inicial[0]->fecha_inicial;
        $fecha_final=DB::table('resi_cronograma')
            ->where('resi_cronograma.id_anteproyecto','=',$id_anteproyecto)
            ->select(DB::raw('MAX(resi_cronograma.f_termino) as fecha_termino'))
            ->get();
        $fecha_final=$fecha_final[0]->fecha_termino;
        $fecha_inicial = date("d-m-Y", strtotime($fecha_inicial));
        $fecha_final = date("d-m-Y", strtotime($fecha_final));
       $cuenta=$datos[0]->cuenta;


        $num=date("j",strtotime($fecha_inicial));
        $ano=date("Y", strtotime($fecha_inicial));
        $mes= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes=$mes[(date('m', strtotime($fecha_inicial))*1)-1];

        $num1=date("j",strtotime($fecha_final));
        $ano1=date("Y", strtotime($fecha_final));
        $mes1= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes1=$mes1[(date('m', strtotime($fecha_final))*1)-1];

        $fech= 'Del '.$num. ' de '.$mes.' del '.$ano.' al '.$num1.' de '.$mes1.' del '.$ano1;

        $pdf = new PDF($orientation = 'P', $unit = 'mm', $format = 'Letter');
        $pdf->SetMargins(15, 20, 15);
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.2);
        $pdf->SetTextColor(1, 1, 1);
        $pdf->Ln(1);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(185, 5, utf8_decode("Nombre del Residente: ".$nombre), 0, 1, 'L', FALSE);
        $pdf->Cell(185, 5, utf8_decode("Número de Cuenta: ".$cuenta ), 0, 1, 'L', FALSE);
        $pdf->Cell(185, 30, utf8_decode("" ), 0, 1, 'L', FALSE);

        $pdf->Cell(185, 5, utf8_decode("En qué medida el Residente cumple con lo siguiente:" ), 1, 1, 'C', FALSE);
        $pdf->Cell(145, 5, utf8_decode("Criterios a evaluar" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode("A valor" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode("B Evaluación" ), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("1. Asiste puntualmente con el horario establecido" ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-5" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode($calificaciones[0]->uno_externo), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("2. Trabajo en equipo" ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-10" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode($calificaciones[0]->dos_externo ), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("3. Tiene iniciativa para ayudar en las actividades encomendadas" ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-10" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode($calificaciones[0]->tres_externo), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("4. Organiza su tiempo y trabaja sin necesidad de una supervisión estrecha." ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-5" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode($calificaciones[0]->cuatro_externo),1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("5. Realiza mejoras al proyecto" ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-10" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode($calificaciones[0]->cinco_externo), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("6. Cumple con los objetivos correspondiente al proyecto" ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-10" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode($calificaciones[0]->seis_externo), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("1. Mostró responsabilidad y compromiso en la residencia profesional" ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-5" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode($calificaciones[0]->uno_interno), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("2. Realizó un trabajo innovador en su área de desempeño" ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-10" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode($calificaciones[0]->dos_interno), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("3. Aplica las competencias para la realización del proyecto" ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-10" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode($calificaciones[0]->tres_interno), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("4. Es dedicado y proactivo en los trabajos encomendados" ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-10" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode($calificaciones[0]->cuatro_interno), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("5. Cumple con los objetivos correspondiente al proyecto" ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-10" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode($calificaciones[0]->cinco_interno), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("6. Entrega en tiempo y forma el informe técnico" ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-5" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode($calificaciones[0]->seis_interno), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(145, 10, utf8_decode("CALIFICACIÓN FINAL" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 10, utf8_decode($calificacion_final), 1, 1, 'C', FALSE);
        if($calificacion_final>=97 && $calificacion_final<=100)
        {
            $des='Excelente';
        }
        else
        {
            if($calificacion_final>=90 && $calificacion_final<=96)
            {
                $des='Muy Bien';
            }
            else
            {
                if($calificacion_final>=80 && $calificacion_final<=89)
                {
                    $des='Bien';
                }
                else
                {
                    if($calificacion_final>=70 && $calificacion_final<=79)
                    {
                        $des='Regular';
                    }
                    else
                    {
                        if($calificacion_final<=69)
                        {
                            $des='Competencia no Alcanzada';
                        }
                        else
                        {

                        }
                    }
                }
            }
        }
        $pdf->Cell(20);
        $pdf->Cell(165, 10, utf8_decode("NIVEL DE DESEMPEÑO: ".$des ), 1, 1, 'C', FALSE);
        $pdf->MultiCell(185, 5, utf8_decode("OBSERVACIONES: ".$calificaciones[0]->observacion ), 1);


        $pdf->SetY(82);
        $pdf->Cell(20,5,utf8_decode('Evaluación'),'LR',0,'C');
        $pdf->SetY(87);
        $pdf->Cell(20,5,utf8_decode('por el'),'LR',0,'C');
        $pdf->SetY(92);
        $pdf->Cell(20,5,utf8_decode('asesor'),'LR',0,'C');
        $pdf->SetY(97);
        $pdf->Cell(20,5,utf8_decode('externo'),'LR',0,'C');
        $pdf->SetY(102);
        $pdf->Cell(20,10,utf8_decode(''),'LBR',0,'C');

        $pdf->SetY(112);
        $pdf->Cell(20,10,utf8_decode(''),'LR',0,'C');
        $pdf->SetY(122);
        $pdf->Cell(20,5,utf8_decode('Evaluación'),'LR',0,'C');
        $pdf->SetY(127);
        $pdf->Cell(20,5,utf8_decode('por el'),'LR',0,'C');
        $pdf->SetY(132);
        $pdf->Cell(20,5,utf8_decode('asesor'),'LR',0,'C');
        $pdf->SetY(137);
        $pdf->Cell(20,5,utf8_decode('interno'),'LR',0,'C');
        $pdf->SetY(142);
        $pdf->Cell(20,20,utf8_decode(''),'LBR',0,'C');
        $pdf->Line(20,220,60,220);
        $pdf->SetXY(20,200);
        $pdf->SetFont('Arial', '', 6);
        $pdf->MultiCell(40,5,utf8_decode($nombre_asesor),0,'C');
        $pdf->SetXY(23,220);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(60,5,utf8_decode('Nombre y firma del Asesor Interno'),0,0,'L');
        $pdf->SetXY(67,200);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(38,30,utf8_decode(""),1,0,'L');
        $pdf->SetXY(67,230);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(40,4,utf8_decode('Sello del Instituto Tecnológico'),0,0,'C');

        $pdf->Line(112,220,152,220);
        $pdf->SetXY(108,200);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(50,5,utf8_decode($nombre_externo),0,0,'C');
        $pdf->SetXY(108,205);
        $pdf->SetFont('Arial', '', 6);
        $pdf->MultiCell(50,5,utf8_decode($puesto),0,'C');
        $pdf->SetXY(114,220);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(60,5,utf8_decode('Nombre y firma del Asesor Externo'),0,0,'L');
        $pdf->SetXY(164,200);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(38,30,utf8_decode(""),1,0,'L');
        $pdf->SetXY(164,230);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(40,4,utf8_decode('Sello de la Dependencia/Empresa'),0,0,'C');
        $pdf->SetY(42);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(185, 5, utf8_decode("Nombre del proyecto: ".$nombre_proyecto ), 0);
        $pdf->Cell(185, 5, utf8_decode("Carrera: ".$carrera ), 0, 1, 'L', FALSE);
        $pdf->Cell(185, 5, utf8_decode("Periodo de realización de la Residencia Profesional: ".$fech ), 0, 1, 'L', FALSE);
        $pdf->Output();
    }
    public function pdf_formato_externo($id_anteproyecto){
        $datos=DB::table('resi_anteproyecto')
            ->join('gnral_alumnos','gnral_alumnos.id_alumno','=','resi_anteproyecto.id_alumno')
            ->join('gnral_carreras','gnral_carreras.id_carrera','=','gnral_alumnos.id_carrera')
            ->join('resi_proy_empresa','resi_proy_empresa.id_anteproyecto','=','resi_anteproyecto.id_anteproyecto')
            ->join('resi_empresa','resi_empresa.id_empresa','=','resi_proy_empresa.id_empresa')
            ->join('resi_proyecto','resi_anteproyecto.id_proyecto','=','resi_proyecto.id_proyecto')
            ->where('resi_anteproyecto.id_anteproyecto','=',$id_anteproyecto)
            ->select('gnral_carreras.nombre as  carrera','gnral_alumnos.nombre','gnral_alumnos.apaterno',
                'gnral_alumnos.amaterno','resi_proyecto.nom_proyecto','resi_empresa.nombre as empresa','gnral_alumnos.cuenta')
            ->get();

        $carrera = mb_strtoupper($datos[0]->carrera);
        $nombre = mb_strtoupper($datos[0]->nombre . ' ' . $datos[0]->apaterno . ' ' . $datos[0]->amaterno);
        $nombre_proyecto = $datos[0]->nom_proyecto;
        $nombre_proyecto = mb_eregi_replace("[\n|\r|\n\r]", '', $nombre_proyecto);
        $nombre_proyecto = mb_strtoupper($nombre_proyecto);

        $nombre_asesor_externo=DB::table('resi_proy_empresa')
            ->join('resi_empresa','resi_empresa.id_empresa','=','resi_proy_empresa.id_empresa')
            ->where('resi_proy_empresa.id_anteproyecto','=',$id_anteproyecto)
            ->select('resi_proy_empresa.*','resi_empresa.dir_gral')
            ->get();

        $nombre_externo=$nombre_asesor_externo[0]->asesor;
        $puesto=$nombre_asesor_externo[0]->puesto;
        $asesor=DB::table('resi_asesores')
            ->join('gnral_personales','resi_asesores.id_profesor','=','gnral_personales.id_personal')
            ->join('abreviaciones_prof','abreviaciones_prof.id_personal','=','gnral_personales.id_personal')
            ->join('abreviaciones','abreviaciones_prof.id_abreviacion','=','abreviaciones.id_abreviacion')
            ->where('resi_asesores.id_anteproyecto','=',$id_anteproyecto)
            ->select('gnral_personales.nombre','abreviaciones.titulo')
            ->get();
        $nombre_asesor=mb_strtoupper($asesor[0]->titulo,'utf-8')." ".mb_strtoupper($asesor[0]->nombre,'utf-8');
        $fecha_inicial=DB::table('resi_cronograma')
            ->where('resi_cronograma.id_anteproyecto','=',$id_anteproyecto)
            ->select(DB::raw('MIN(resi_cronograma.f_inicio) as fecha_inicial'))
            ->get();
        $fecha_inicial=$fecha_inicial[0]->fecha_inicial;
        $fecha_final=DB::table('resi_cronograma')
            ->where('resi_cronograma.id_anteproyecto','=',$id_anteproyecto)
            ->select(DB::raw('MAX(resi_cronograma.f_termino) as fecha_termino'))
            ->get();
        $fecha_final=$fecha_final[0]->fecha_termino;
        $fecha_inicial = date("d-m-Y", strtotime($fecha_inicial));
        $fecha_final = date("d-m-Y", strtotime($fecha_final));
        $cuenta=$datos[0]->cuenta;


        $num=date("j",strtotime($fecha_inicial));
        $ano=date("Y", strtotime($fecha_inicial));
        $mes= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes=$mes[(date('m', strtotime($fecha_inicial))*1)-1];

        $num1=date("j",strtotime($fecha_final));
        $ano1=date("Y", strtotime($fecha_final));
        $mes1= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes1=$mes1[(date('m', strtotime($fecha_final))*1)-1];

        $fech= 'Del '.$num. ' de '.$mes.' del '.$ano.' al '.$num1.' de '.$mes1.' del '.$ano1;

        $pdf = new PDF($orientation = 'P', $unit = 'mm', $format = 'Letter');
        $pdf->SetMargins(15, 20, 15);
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.2);
        $pdf->SetTextColor(1, 1, 1);
        $pdf->Ln(1);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(185, 5, utf8_decode("Nombre del Residente: ".$nombre), 0, 1, 'L', FALSE);
        $pdf->Cell(185, 5, utf8_decode("Número de Cuenta: ".$cuenta ), 0, 1, 'L', FALSE);
        $pdf->Cell(185, 35, utf8_decode("" ), 0, 1, 'L', FALSE);
        $pdf->Cell(185, 5, utf8_decode("En qué medida el Residente cumple con lo siguiente:" ), 1, 1, 'C', FALSE);
        $pdf->Cell(145, 5, utf8_decode("Criterios a evaluar" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode("A valor" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode("B Evaluación" ), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("1. Asiste puntualmente con el horario establecido" ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-5" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode(''), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("2. Trabajo en equipo" ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-10" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode('' ), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("3. Tiene iniciativa para ayudar en las actividades encomendadas" ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-10" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode(''), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("4. Organiza su tiempo y trabaja sin necesidad de una supervisión estrecha." ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-5" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode(''),1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("5. Realiza mejoras al proyecto" ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-10" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode(''), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("6. Cumple con los objetivos correspondiente al proyecto" ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-10" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode(''), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("1. Mostró responsabilidad y compromiso en la residencia profesional" ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-5" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode(''), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("2. Realizó un trabajo innovador en su área de desempeño" ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-10" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode(''), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("3. Aplica las competencias para la realización del proyecto" ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-10" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode(''), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("4. Es dedicado y proactivo en los trabajos encomendados" ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-10" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode(''), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("5. Cumple con los objetivos correspondiente al proyecto" ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-10" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode(''), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(125, 5, utf8_decode("6. Entrega en tiempo y forma el informe técnico" ), 1, 0, 'L', FALSE);
        $pdf->Cell(20, 5, utf8_decode("1-5" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode(''), 1, 1, 'C', FALSE);
        $pdf->Cell(20);
        $pdf->Cell(145, 5, utf8_decode("CALIFICACIÓN FINAL" ), 1, 0, 'C', FALSE);
        $pdf->Cell(20, 5, utf8_decode(''), 1, 1, 'C', FALSE);

        $pdf->Cell(20);
        $pdf->Cell(165, 10, utf8_decode("NIVEL DE DESEMPEÑO: "), 1, 1, 'C', FALSE);
        $pdf->MultiCell(185, 20, utf8_decode("OBSERVACIONES: " ), 1);


        $pdf->SetY(87);
        $pdf->Cell(20,5,utf8_decode('Evaluación'),'LR',0,'C');
        $pdf->SetY(92);
        $pdf->Cell(20,5,utf8_decode('por el'),'LR',0,'C');
        $pdf->SetY(97);
        $pdf->Cell(20,5,utf8_decode('asesor'),'LR',0,'C');
        $pdf->SetY(102);
        $pdf->Cell(20,5,utf8_decode('externo'),'LR',0,'C');
        $pdf->SetY(107);
        $pdf->Cell(20,10,utf8_decode(''),'LBR',0,'C');

        $pdf->SetY(112);
        $pdf->Cell(20,10,utf8_decode(''),'LR',0,'C');
        $pdf->SetY(122);
        $pdf->Cell(20,5,utf8_decode('Evaluación'),'LR',0,'C');
        $pdf->SetY(127);
        $pdf->Cell(20,5,utf8_decode('por el'),'LR',0,'C');
        $pdf->SetY(132);
        $pdf->Cell(20,5,utf8_decode('asesor'),'LR',0,'C');
        $pdf->SetY(137);
        $pdf->Cell(20,5,utf8_decode('interno'),'LR',0,'C');
        $pdf->SetY(142);
        $pdf->Cell(20,20,utf8_decode(''),'LBR',0,'C');
        $pdf->Line(20,220,60,220);
        $pdf->SetXY(20,200);
        $pdf->SetFont('Arial', '', 6);
        $pdf->MultiCell(40,5,utf8_decode($nombre_asesor),0,'C');
        $pdf->SetXY(23,220);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(60,5,utf8_decode('Nombre y firma del Asesor Interno'),0,0,'L');
        $pdf->SetXY(67,200);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(38,30,utf8_decode(""),1,0,'L');
        $pdf->SetXY(67,230);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(40,4,utf8_decode('Sello del Instituto Tecnológico'),0,0,'C');

        $pdf->Line(112,220,152,220);
        $pdf->SetXY(108,200);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(50,5,utf8_decode($nombre_externo),0,0,'C');
        $pdf->SetXY(108,205);
        $pdf->SetFont('Arial', '', 6);
        $pdf->MultiCell(50,5,utf8_decode($puesto),0,'C');
        $pdf->SetXY(114,220);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(60,5,utf8_decode('Nombre y firma del Asesor Externo'),0,0,'L');
        $pdf->SetXY(164,200);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(38,30,utf8_decode(""),1,0,'L');
        $pdf->SetXY(164,230);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(40,4,utf8_decode('Sello de la Dependencia/Empresa'),0,0,'C');
        $pdf->SetY(42);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(185, 5, utf8_decode("Nombre del proyecto: ".$nombre_proyecto ), 0);
        $pdf->Cell(185, 5, utf8_decode("Carrera: ".$carrera ), 0, 1, 'L', FALSE);
        $pdf->Cell(185, 5, utf8_decode("Periodo de realización de la Residencia Profesional: ".$fech ), 0, 1, 'L', FALSE);

        $pdf->Output();
    }
}
