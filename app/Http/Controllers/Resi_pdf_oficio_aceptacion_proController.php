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
        $this->Image('img/logos/ArmasBN.png', 20, 5, 50);
        $this->Image('img/logos/Captura.PNG', 80, 5, 30);
        $this->SetTextColor(128,128,128);
        $this->SetFont('Arial', 'B', '9');
        $etiqueta=DB::table('etiqueta')
            ->where('id_etiqueta','=',1)
            ->select('etiqueta.descripcion')
            ->get();
        $etiqueta=$etiqueta[0]->descripcion;
        $this->Cell(190,5,utf8_decode($etiqueta),0,0,'C',FALSE);
        $this->Ln(5);

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
        $this->Cell(43);
        $this->Cell(145,-2,utf8_decode('FO-TESVB-85 V.0 23/03/2018'),0,0,'R');
        $this->Ln(3);
        $this->Cell(43);
        $this->Cell(145,-2,utf8_decode('SECRETARÍA DE EDUCACIÓN'),0,0,'R');
        $this->Ln(3);
        $this->Cell(43);
        $this->Cell(145,-2,utf8_decode('SUBSECRETARÍA DE EDUCACIÓN SUPERIOR Y NORMAL'),0,0,'R');
        $this->Ln(3);
        $this->Cell(43);
        $this->Cell(145,-2,utf8_decode('TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO'),0,0,'R');
        $this->Ln(3);
        $this->Cell(43);
        $this->Cell(145,-2,utf8_decode('DEPARTAMENTO DE SERVICIO SOCIAL Y RESIDENCIA PROFESIONAL'),0,0,'R');
        $this->Cell(280);
        $this->SetMargins(0,0,0);
        $this->Ln(0);
        $this->SetXY(38,267);
        $this->SetFillColor(120,120,120);
        $this->SetTextColor(255,255,255);
        $this->SetFont('Arial','B',8);
        $this->Cell(165,4,utf8_decode('      Km. 30 de la Carretera Federal Monumento - Valle de Bravo, Ejido de San Antonio de la Laguna,'),0,0,'L',TRUE);
        $this->Ln(3);
        $this->Cell(38);
        $this->SetFont('Arial','B',8);
        $this->Cell(165,4,utf8_decode('      Valle de Bravo, Estado de México, C.P. 51200.'),0,0,'L',TRUE);
        $this->Ln(3);
        $this->Cell(38);
        $this->SetFont('Arial','',8);
        $this->Cell(165,4,utf8_decode('     Tels.:(726)26 6 52 00, 26 6 51 87 EXT. 144      servicio.social@vbravo.tecnm.mx'),0,0,'L',true);

        $this->Image('img/logos/Mesquina.jpg',0,247,38);


    }
}
class Resi_pdf_oficio_aceptacion_proController extends Controller
{
    public function index($id_asesores){
        $asesor=DB::selectOne('SELECT resi_oficio_acept_proy.numero_oficio, resi_asesores.* from resi_oficio_acept_proy, resi_asesores
        where resi_oficio_acept_proy.id_asesores = resi_asesores.id_asesores  and resi_oficio_acept_proy.id_asesores ='.$id_asesores.'');
        $periodoss=DB::selectOne('SELECT * FROM `gnral_periodos` WHERE `id_periodo` ='.$asesor->id_periodo.'');
        $periodos=$periodoss->periodo;
        $fecha_inicio=$periodoss->fecha_inicio;
        $num=date("j",strtotime($fecha_inicio));
        $ano=date("Y", strtotime($fecha_inicio));
        $mes= array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
        $mes=$mes[(date('m', strtotime($fecha_inicio))*1)-1];
        $fecha_in= $num. ' de '.$mes.' del  año en curso, ';
        $id_anteproyecto=$asesor->id_anteproyecto;
        $anteproyecto=DB::table('resi_proyecto')
            ->join('resi_anteproyecto','resi_proyecto.id_proyecto','=','resi_anteproyecto.id_proyecto')
            ->where('resi_anteproyecto.id_anteproyecto','=',$id_anteproyecto)
            ->select('resi_proyecto.nom_proyecto','resi_anteproyecto.*')
            ->get();

        $periodo = Session::get('periodo_actual');
        $alumno=DB::table('gnral_alumnos')
            ->where('gnral_alumnos.id_alumno','=',$anteproyecto[0]->id_alumno)
            ->select('gnral_alumnos.*')
            ->get();
        $jefe = DB::table('gnral_jefes_periodos')
            ->join('gnral_personales', 'gnral_jefes_periodos.id_personal', '=', 'gnral_personales.id_personal')
            ->join('abreviaciones_prof', 'abreviaciones_prof.id_personal', '=', 'gnral_personales.id_personal')
            ->join('abreviaciones', 'abreviaciones_prof.id_abreviacion', '=', 'abreviaciones.id_abreviacion')
            ->join('gnral_carreras', 'gnral_carreras.id_carrera', '=', 'gnral_jefes_periodos.id_carrera')
            ->where('gnral_jefes_periodos.id_carrera', '=', $alumno[0]->id_carrera)
            ->where('gnral_jefes_periodos.id_periodo', '=', $periodo)
            ->where('gnral_jefes_periodos.tipo_cargo', '=', 1)
            ->select('gnral_personales.nombre', 'abreviaciones.titulo', 'gnral_carreras.nombre as carrera')
            ->get();
        $nombre_jefe=$jefe[0]->titulo." ".$jefe[0]->nombre;
        $carrera=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','=',$alumno[0]->id_carrera)
            ->get();
        $carrera=$carrera[0]->nombre;
        $empresa=DB::table('resi_proy_empresa')
            ->join('resi_empresa','resi_proy_empresa.id_empresa','=','resi_empresa.id_empresa')
            ->where('resi_proy_empresa.id_anteproyecto','=',$id_anteproyecto)
            ->select('resi_empresa.*','resi_proy_empresa.asesor','resi_proy_empresa.puesto')
            ->get();

        $asesor_externo=mb_strtoupper($empresa[0]->asesor,'utf-8');
        $director_general=mb_strtoupper($empresa[0]->dir_gral,'utf-8');
        $nombre_empresa=mb_strtoupper($empresa[0]->nombre,'utf-8');

        $nombre_proyecto=mb_eregi_replace("[\n|\r|\n\r]",'',$anteproyecto[0]->nom_proyecto);

        $asesor_ext=DB::selectOne('SELECT abreviaciones.titulo,gnral_personales.nombre 
FROM abreviaciones,abreviaciones_prof,gnral_personales,resi_asesores where 
        abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion and 
    abreviaciones_prof.id_personal=gnral_personales.id_personal and 
gnral_personales.id_personal=resi_asesores.id_profesor and resi_asesores.id_anteproyecto='.$id_anteproyecto.'');
        $asesor_interno=mb_strtoupper($asesor_ext->titulo,'utf-8')." ".mb_strtoupper($asesor_ext->nombre,'utf-8');


        $dat_alumnos=mb_strtoupper($alumno[0]->nombre,'utf-8')." ".mb_strtoupper($alumno[0]->apaterno,'utf-8')." ".mb_strtoupper($alumno[0]->amaterno,'utf-8');

        $fechas = date("Y-m-d");

        $num=date("j",strtotime($fechas));
        $ano=date("Y", strtotime($fechas));
        $mes= array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
        $mes=$mes[(date('m', strtotime($fechas))*1)-1];
        $fech= $num. ' de '.$mes.' del '.$ano;


        $pdf=new PDF($orientation='P',$unit='mm',$format='Letter');

        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(15, 25 ,15);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();



        $pdf->Ln(3);
        $pdf->SetFont('Arial','B',10);
        $pdf->SetTextColor(257,257,257);
        $pdf->SetFillColor(167,167,167);
        $pdf->SetX(125);
        $pdf->Cell(70,5,utf8_decode("OFICIO DE ACEPTACIÓN DE PROYECTO"),0,1,'R',true);
        $pdf->Ln(5);
        $pdf->SetFont('Arial','',9);
        $pdf->SetTextColor(1,1,1);
        $pdf->Cell(180,5,utf8_decode("Valle de Bravo, Estado de México"),0,1,'R',FALSE);
        $pdf->Cell(180,5,utf8_decode("a ".$fech),0,1,'R',FALSE);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(180,5,utf8_decode("Oficio No. ".$asesor->numero_oficio),0,1,'R',FALSE);
        $pdf->Ln(2);
        $pdf->SetFont('Arial','B',9);
        $pdf->SetTextColor(1,1,1);
        $pdf->Cell(180,5,utf8_decode("CIUDADANO(A)"),0,1,'L',FALSE);
        $pdf->Cell(180,5,utf8_decode($dat_alumnos),0,1,'L',FALSE);
        $pdf->Cell(180,5,utf8_decode("$carrera"),0,0,'L',FALSE);
        $pdf->Ln(5);
        $pdf->Cell(180,5,utf8_decode("P R E S E N T E"),0,0,'L',FALSE);
        $pdf->Ln(10);
        $pdf->SetFont('Arial','',10);


            $pdf->MultiCell(180, 5, utf8_decode("Sea este el medio para hacer de su conocimiento que le ha sido autorizado y asignado su proyecto de Residencia Profesional denominado " . $nombre_proyecto . ", el cual será realizado en la empresa: ".$nombre_empresa." así mismo le informo que la asignación oficial de asesor se hará por la Jefatura de División al inicio del Semestre ".$periodos."."));
            $pdf->Ln(2);
            $pdf->MultiCell(180, 5, utf8_decode("De igual manera le comunico que con fundamento en el Artículo 7° del Reglamento para la Acreditación de Residencias Profesionales del TESVB, la duración de las Residencias Profesionales queda determinada a que se realice durante un periodo de 4 a 6 meses debiendo acumularse un total de 500 horas, el inicio de su Residencia Profesional es a partir del ".$fecha_in."fecha en que inicia el computo de su periodo para concluirla, sin olvidar el cronograma previamente autorizado."));

        $pdf->Ln(2);
        $pdf->MultiCell(180, 5, utf8_decode("No omito manifestarle que de conformidad con el Artículo 25 del Reglamento para la Acreditación de Residencias Profesionales del TESVB, para la acreditación de la Residencia Profesional, el estudiante deberá elaborar un informe final del proyecto realizado, Articulo 28 el proyecto será aprobado cuando el estudiante entregue al Departamento de Servicio Social y Residencia Profesional"));
        $pdf->MultiCell(180,5,utf8_decode("- Constancia de aceptación del Trabajo firmada por los asesores internos y externos así como por los revisores del proyecto."));
        $pdf->MultiCell(180,5,utf8_decode("- Las evaluaciones internas y externas."));
        $pdf->MultiCell(180,5,utf8_decode("- Copia de su informe final del proyecto en formato digital."));
        $pdf->MultiCell(180,5,utf8_decode("- Formato de Evaluación firmada por los asesores interno y externo."));


        $pdf->Ln(5);
        $pdf->MultiCell(190,5,utf8_decode("Sin más por el momento, reciba un cordial saludo."));
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(190,5,utf8_decode('ATENTAMENTE'),0,0,'C',FALSE);
        $pdf->Ln(15);
        $pdf->Cell(190,5,utf8_decode(""),0,0,'C',FALSE);
        $pdf->Ln(5);
        $pdf->Cell(190,5,utf8_decode($nombre_jefe),0,1,'C',FALSE);
        $pdf->Cell(190,5,utf8_decode('JEFE(A) DE DIVISIÓN  DE '.$carrera),0,1,'C',FALSE);




        $pdf->Output();

        exit();
    }
}
