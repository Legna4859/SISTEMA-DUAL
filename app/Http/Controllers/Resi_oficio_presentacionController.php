<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
        $this->Cell(145,-2,utf8_decode('FO-TESVB-84 V.1 23/03/2018'),0,0,'R');
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
class Resi_oficio_presentacionController extends Controller
{
    public function index($id_anteproyecto){
        //CARRERA
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
        $pdf->SetX(145);
        $pdf->Cell(50,5,utf8_decode("OFICIO DE PRESENTACIÓN"),0,1,'R',true);
        $pdf->Ln(5);
        $pdf->SetFont('Arial','',10);
        $pdf->SetTextColor(1,1,1);
        $pdf->Cell(180,5,utf8_decode("Valle de Bravo, Estado de México"),0,1,'R',FALSE);
        $pdf->Cell(180,5,utf8_decode("a ".$fech),0,1,'R',FALSE);
        $pdf->Ln(10);
        $pdf->SetFont('Arial','B',11);
        $pdf->SetTextColor(1,1,1);
        $pdf->Cell(180,5,utf8_decode($director_general),0,0,'L',FALSE);
        $pdf->Ln(5);
        $pdf->Cell(180,5,utf8_decode("$nombre_empresa"),0,0,'L',FALSE);
        $pdf->Ln(5);
        $pdf->Cell(180,5,utf8_decode("P R E S E N T E"),0,0,'L',FALSE);
        $pdf->Ln(10);
        $pdf->SetFont('Arial','',12);

        if($alumno[0]->genero == "M"){
            $pdf->MultiCell(180, 5, utf8_decode("Sirve el presente para enviarle un cordial saludo y a la vez presentarle al estudiante " . $dat_alumnos . " de esta institución, quien cursa la carrera de " . $carrera . ", así mismo informarle que ha sido aprobado por parte de la academia de esta institución, el proyecto denominado " . $nombre_proyecto . ", el cual será realizado por dicho estudiante a través de su residencia profesional en la empresa que dignamente representa, durante un periodo de 4 a 6 meses, cubriendo un total de  500 horas, solicitando que los requisitos del proyecto no podrán ser modificados de fondo durante el desarrollo o la liberación de la residencia profesional."));
            $pdf->Ln(10);
            $pdf->MultiCell(180, 5, utf8_decode("No omito manifestar que el asesor externo por parte de la empresa será  " . $asesor_externo . " y el  asesor interno por parte de nuestra institución será " . $asesor_interno . ", quien la orientará, asesorará, supervisará, y evaluará en el desarrollo del proyecto, así como en la elaboración del informe final."));

        }
            else {


                $pdf->MultiCell(180, 5, utf8_decode("Sirve el presente para enviarle un cordial saludo y a la vez presentarle a la estudiante " . $dat_alumnos . " de esta institución, quien cursa la carrera de " . $carrera . ", así mismo informarle que ha sido aprobado por parte de la academia de esta institución, el proyecto denominado " . $nombre_proyecto . ", el cual será realizado por dicha estudiante a través de su residencia profesional en la empresa que dignamente representa, durante un periodo de 4 a 6 meses, cubriendo un total de  500 horas, solicitando que los requisitos del proyecto no podrán ser modificados de fondo durante el desarrollo o la liberación de la residencia profesional."));
                $pdf->Ln(10);
                $pdf->MultiCell(180, 5, utf8_decode("No omito manifestar que el asesor externo por parte de la empresa será  " . $asesor_externo . " y el  asesor interno por parte de nuestra institución será " . $asesor_interno . ", quien la orientará, asesorará, supervisará, y evaluará en el desarrollo del proyecto, así como en la elaboración del informe final."));
            }
        $pdf->Ln(5);
        $pdf->MultiCell(190,5,utf8_decode("Sin otro particular quedo a sus apreciables órdenes."));
        $pdf->Ln(15);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,5,utf8_decode('ATENTAMENTE'),0,0,'C',FALSE);
        $pdf->Ln(15);
        $pdf->Cell(190,5,utf8_decode(""),0,0,'C',FALSE);
        $pdf->Ln(5);
        $pdf->Cell(190,5,utf8_decode('L.A.E. MARÍA ISABEL SALGUERO SANTANA'),0,1,'C',FALSE);
        $pdf->Cell(190,5,utf8_decode('JEFA DE DEPARTAMENTO DE SERVICIO SOCIAL'),0,1,'C',FALSE);
        $pdf->Cell(190,5,utf8_decode('Y RESIDENCIA PROFESIONAL'),0,0,'C',FALSE);



        $pdf->Output();

        exit();
    }
}
