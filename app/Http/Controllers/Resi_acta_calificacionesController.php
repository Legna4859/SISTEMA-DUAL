<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use Illuminate\Support\Facades\DB;
use Session;


class PDF extends FPDF
{

    //CABECERA DE LA PAGINA
    function Header()
    {
        $this->Image('img/logo3.PNG', 170, 15, 85);
        $this->Image('img/gem.png',20,10,32);
        $this->Ln(10);
    }
    //PIE DE PAGINA
    function Footer()
    {

        $this->SetY(-25);
        $this->SetFont('Arial','',8);
        //$this->Image('img/sgc.PNG',40,183,20);
        $this->Image('img/pie/logos_iso.jpg',35,183,55);
       // $this->Image('img/sga.PNG',65,183,20);
        $this->Cell(100);
        $this->Cell(167,-2,utf8_decode(''),0,0,'R');
        $this->Ln(3);
        $this->Cell(80);
        $this->Cell(167,-2,utf8_decode('SECRETARÍA DE EDUCACIÓN'),0,0,'R');
        $this->Ln(3);
        $this->Cell(80);
        $this->Cell(167,-2,utf8_decode('SUBSECRETARÍA DE EDUCACIÓN SUPERIOR Y NORMAL'),0,0,'R');
        $this->Ln(3);
        $this->Cell(80);
        $this->Cell(167,-2,utf8_decode('TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO'),0,0,'R');
        $this->Ln(3);
        $this->Cell(80);
        $this->Cell(167,-2,utf8_decode('SUBDIRECCIÓN DE SERVICIOS ESCOLARES'),0,0,'R');
        $this->Cell(280);
        $this->SetMargins(0,0,0);
        $this->Ln(0);
        $this->SetXY(30,204);
        $this->SetFillColor(120,120,120);
        $this->Cell(20,10,'',0,0,'',TRUE);
        $this->SetTextColor(255,255,255);
        $this->Cell(297,10,utf8_decode('Km. 30 de la Carretera Federal Monumento - Valle de Bravo, Ejido de San Antonio de la Laguna,'),0,0,'L',TRUE);
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(160,10,utf8_decode(' Valle de Bravo, Estado de México, C.P. 51200.    Tels.: (726)26 6 52 00, 26 6 50 77,26 6 51 87 Ext 115                             sub.escolares@vbravo.tecnm.mx'),0,0,'L');

        $this->Image('img/logos/Mesquina.jpg',0,190,30);
    }

}


class Resi_acta_calificacionesController extends Controller
{
    public function index($id_anteproyecto){
        $alumno=DB::selectOne('SELECT gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,
gnral_alumnos.amaterno,gnral_carreras.nombre carrera,resi_proyecto.nom_proyecto,resi_proy_empresa.asesor,
resi_empresa.nombre empresa from gnral_alumnos,gnral_carreras,resi_anteproyecto,resi_proy_empresa,
resi_empresa,resi_proyecto where gnral_alumnos.id_carrera=gnral_carreras.id_carrera and
 resi_anteproyecto.id_alumno=gnral_alumnos.id_alumno and resi_anteproyecto.id_proyecto=resi_proyecto.id_proyecto 
 and resi_anteproyecto.id_anteproyecto=resi_proy_empresa.id_anteproyecto and
  resi_proy_empresa.id_empresa=resi_empresa.id_empresa and
   resi_anteproyecto.id_anteproyecto='.$id_anteproyecto.'');
        $asesor_anteproyecto=DB::selectOne('SELECT abreviaciones.titulo, gnral_personales.nombre,gnral_periodos.periodo 
FROM gnral_personales,abreviaciones_prof,abreviaciones,gnral_periodos,resi_asesores 
where resi_asesores.id_profesor=gnral_personales.id_personal and
 gnral_personales.id_personal=abreviaciones_prof.id_personal and
  abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and
   resi_asesores.id_periodo=gnral_periodos.id_periodo and
    resi_asesores.id_anteproyecto='.$id_anteproyecto.'');
        //dd($alumno);
        $promedio_residencia=DB::selectOne('SELECT * FROM `resi_promedio_general_residencia` WHERE `id_anteproyecto` ='.$id_anteproyecto.'');
        $promedio_residencia=$promedio_residencia->promedio_general;

        $pdf=new PDF($orientation='L',$unit='mm',$format='Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:

         $pdf->SetMargins(20, 20 , 20);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetLineWidth(0.5);
        $pdf->SetFillColor(166,166,166);
         $pdf->Ln(10);
        $pdf->SetFont('Arial','B',13);
        $pdf->Cell(240,15,utf8_decode('ACTA DE CALIFICACIONES DE RESIDENCIA PROFESIONAL'),0,1,'C',true);
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B',10);
        $pdf->MultiCell(245,5,utf8_decode('PROYECTO: '.$alumno->nom_proyecto),0,1,'');
        $pdf->MultiCell(120,5,utf8_decode('EMPRESA: '.$alumno->empresa),0,1,'');

        $pdf->Cell(130,5,utf8_decode('PERIODO: '.$asesor_anteproyecto->periodo),0,0,'');
        $pdf->Cell(110,5,utf8_decode('DURACIÓN: 500 HORAS'),0,1,'');
        $nombre_asesor_interno=mb_strtoupper($asesor_anteproyecto->titulo,'utf-8')." ".mb_strtoupper($asesor_anteproyecto->nombre,'utf-8');

        $pdf->Cell(130,5,utf8_decode('ASESOR INTERNO: '.$nombre_asesor_interno),0,0,'');
        $pdf->Cell(110,5,utf8_decode('CARRERA: '.$alumno->carrera),0,1,'');
        $asesor=mb_strtoupper($alumno->asesor,'utf-8');

        $pdf->Cell(130,5,utf8_decode('ASESOR EXTERNO: '.$asesor),0,0,'');
        $pdf->Cell(110,5,utf8_decode('CLAVE: RES-0001'),0,1,'');
        $pdf->Ln(5);
        $pdf->Cell(10,10,utf8_decode('NP'),1,0,'C',true);
        $pdf->Cell(40,10,utf8_decode('NO. CUENTA'),1,0,'C',true);
        $pdf->Cell(120,10,utf8_decode('NOMBRE DEL ALUMNO'),1,0,'C',true);
        $pdf->Cell(35,10,utf8_decode('CALIFICACIÓN'),1,0,'C',true);
        $pdf->Cell(35,10,utf8_decode('CRÉDITOS'),1,1,'C',true);
        $pdf->Cell(10,10,utf8_decode('1'),1,0,'C');
        $pdf->Cell(40,10,utf8_decode($alumno->cuenta),1,0,'C');
        $nombre_alumno=mb_strtoupper($alumno->apaterno,'utf-8')." ".mb_strtoupper($alumno->amaterno,'utf-8')." ".mb_strtoupper($alumno->nombre,'utf-8');

        $pdf->Cell(120,10,utf8_decode($nombre_alumno),1,0,'');
        if($promedio_residencia >= 70){
            $pdf->Cell(35,10,utf8_decode($promedio_residencia),1,0,'C');
        }
            else{
                $pdf->Cell(35,10,utf8_decode("N.A"),1,0,'C');

            }
        if($promedio_residencia >= 70){
            $pdf->Cell(35,10,utf8_decode('10'),1,1,'C');
        }
        else{
            $pdf->Cell(35,10,utf8_decode('0'),1,1,'C');

        }

        $observacion=DB::selectOne('SELECT * FROM `resi_calificar_residencia` WHERE `id_anteproyecto` ='.$id_anteproyecto.'');
        $observacion=mb_strtoupper($observacion->observacion,'utf-8');
        $pdf->MultiCell(240,5,utf8_decode('OBSERVACIONES: '.$observacion),1);
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(240,5,utf8_decode('ESCALA DE CALIFICACIONES DE 0 A 100, LA CALIFICACIÓN MÍNIMA APROBATORIA ES DE 70'),0,1,'');
        $pdf->Cell(110,10,utf8_decode(''),0,0,'C');
        $pdf->SetFont('Arial','B',10);

        $fechas = date("Y-m-d");
        $num=date("j",strtotime($fechas));
        $ano=date("Y", strtotime($fechas));
        $mes= array('ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE');
        $mes=$mes[(date('m', strtotime($fechas))*1)-1];

            $fech=$num.' DE '.$mes.' DE '.$ano;

        $pdf->Cell(130,10,utf8_decode('VALLE DE BRAVO ESTADO DE MÉXICO A '.$fech),0,1,'C');
        $pdf->Cell(120,10,utf8_decode('NOMBRE Y FIRMA'),0,0,'C');
        $pdf->Cell(120,10,utf8_decode('NOMBRE Y FIRMA'),0,1,'C');
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(115,15,utf8_decode(""),'LTR',0,'C');
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(10,15,utf8_decode(''),0,0,'C');
        $pdf->Cell(115,15,utf8_decode(''),'LTR',1,'C');
        $nombre_jefe=DB::selectOne('SELECT abreviaciones.titulo, gnral_personales.nombre from abreviaciones, abreviaciones_prof, gnral_personales,
        gnral_unidad_personal where abreviaciones.id_abreviacion = abreviaciones_prof.id_abreviacion and abreviaciones_prof.id_personal = gnral_personales.id_personal 
        and gnral_personales.id_personal = gnral_unidad_personal.id_personal and gnral_unidad_personal.id_unidad_admin = 20');
        $nombre_jefe=$nombre_jefe->titulo." ".$nombre_jefe->nombre;
        $pdf->Cell(115,5,utf8_decode($nombre_jefe),'LBR',0,'C');

        $pdf->Cell(10,5,utf8_decode(''),0,0,'C');
        $pdf->Cell(115,5,utf8_decode($nombre_asesor_interno),'LBR',1,'C');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(115,5,utf8_decode('DEPARTAMENTO DE SERVICIO SOCIAL Y RESIDENCIA PROFESIONAL'),0,0,'C');
        $pdf->Cell(10,5,utf8_decode(''),0,0,'C');
        $pdf->Cell(115,5,utf8_decode('ASESOR INTERNO'),0,1,'C');




        $pdf->Output();
        exit();

    }
}
