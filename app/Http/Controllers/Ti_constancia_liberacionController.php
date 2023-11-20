<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use Session;
class PDF extends FPDF
{

    //CABECERA DE LA PAGINA
    function Header()
    {

    }
    //PIE DE PAGINA
    function Footer()
    {


    }

}
class Ti_constancia_liberacionController extends Controller
{
    public function index($id_alumno){
        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');

        $pdf = new PDF($orientation = 'P', $unit = 'mm', $format = 'Letter');
        $fechas = date("Y-m-d");

        $num=date("j",strtotime($fechas));
        $ano=date("Y", strtotime($fechas));
        $mes= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes=$mes[(date('m', strtotime($fechas))*1)-1];
        $fech= $num. ' de '.$mes.' del '.$ano;

        $jefe_titulacion=DB::selectOne('SELECT gnral_personales.*,abreviaciones.titulo FROM
                               gnral_unidad_personal,gnral_personales,abreviaciones_prof,abreviaciones WHERE
    gnral_unidad_personal.id_unidad_admin = 28 and
     gnral_personales.id_personal=gnral_unidad_personal.id_personal and abreviaciones_prof.id_personal= gnral_personales.id_personal and abreviaciones_prof.id_abreviacion= abreviaciones.id_abreviacion ');

        $jefe_titulacion=$jefe_titulacion->titulo." ".$jefe_titulacion->nombre;
        $alumno=DB::selectOne('SELECT ti_reg_datos_alum.*,gnral_carreras.nombre carrera FROM ti_reg_datos_alum,gnral_carreras WHERE ti_reg_datos_alum.id_carrera = gnral_carreras.id_carrera and  ti_reg_datos_alum.id_alumno ='.$id_alumno.'');
        $nombre_alumno=$alumno->nombre_al." ".$alumno->apaterno." ".$alumno->amaterno;
        $carrera=$alumno->carrera;
        $cuenta=$alumno->no_cuenta;
        $opcion_titulacion=DB::selectOne('SELECT * FROM `ti_opciones_titulacion` WHERE `id_opcion_titulacion` ='.$alumno->id_opcion_titulacion.'');
        $opcion_titulacion=$opcion_titulacion->opcion_titulacion;

        $jefe_division=DB::selectOne('SELECT gnral_personales.nombre,abreviaciones.titulo 
from abreviaciones,abreviaciones_prof,gnral_personales WHERE
abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion  
and abreviaciones_prof.id_personal=gnral_personales.id_personal and gnral_personales.id_personal='.$alumno->id_jefe_division.'');
        $jefe_division=$jefe_division->titulo." ".$jefe_division->nombre;
        $nombre_proyecto=$alumno->nom_proyecto;


        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(10, 15, 10);
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0,0,0);

        $pdf->SetFillColor(166,166,166);
        $pdf->SetFont('Arial','B','8');
        $pdf->Ln(15);
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(190,5,utf8_decode("DT/".$ano),0,1,'R');
        $pdf->Ln(15);
        $pdf->SetFont('Arial','B','24');
        $pdf->Cell(190,5,utf8_decode("CONSTANCIA DE LIBERACIÓN"),0,1,'C');
        $pdf->Ln(15);
        $pdf->SetFont('Arial','','14');
        $pdf->MultiCell(190,10,utf8_decode("El que suscribe, Jefe del  Departamento de Titulación, hace constar que el C. ".$nombre_alumno." con número de cuenta ".$cuenta." ha reportado a este departamento todos los documentos y pagos para iniciar su Protocolo de Titulación."),"J");
        $pdf->Ln(25);
        $pdf->SetFont('Arial','','14');
        $pdf->MultiCell(190,10,utf8_decode("Se extiende la presente a petición del interesado en la Ciudad Típica de Valle de Bravo, Estado de México a ".$fech."."),"J");

        $pdf->Ln(30);
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(190,5,utf8_decode("ATENTAMENTE"),0,1,'C');
        $pdf->Ln(15);
        $pdf->Cell(40,5,utf8_decode(""),0,0,'C');
        $pdf->Cell(110,5,utf8_decode($jefe_division),"B",1,'C');
        $pdf->Cell(190,5,utf8_decode("JEFE(A) DEL DEPARTAMENTO DE TITULACIÓN"),0,1,'C');
        $pdf->Output();
        exit();
    }
}
