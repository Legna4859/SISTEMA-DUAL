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
        $this->Image('img/logo3.PNG', 115, 10, 70);
        $this->Image('img/logos/ArmasBN.png',20,10,50);
        $this->Image('img/tutorias/tecnm.jpg',80,10,30);
        $this->Ln(10);
    }
    //PIE DE PAGINA
    function Footer()
    {

        $this->SetY(-35);
        $this->SetFont('Arial','',8);
        $this->Image('img/pie/logos_iso.jpg',40,240,60);
       // $this->Image('img/sgc.PNG',40,240,20);
       // $this->Image('img/tutorias/cir.jpg',89,239,20);
      //  $this->Image('img/sga.PNG',65,240,20);
        $this->Cell(50);
        $this->Cell(145,-2,utf8_decode(''),0,0,'R');
        $this->Ln(3);
        $this->SetFont('Arial','B',8);
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
        $this->Cell(145,-2,utf8_decode('DEPARTAMENTO DE TITULACIÓN'),0,0,'R');
        $this->Cell(280);
        $this->SetMargins(0,0,0);
        $this->Ln(0);
        $this->SetXY(40,262);
        $this->SetFillColor(120,120,120);
        $this->SetTextColor(255,255,255);
        $this->SetFont('Arial','B',8);
        $this->Cell(165,4,utf8_decode('      Km. 30 de la Carretera Federal Monumento - Valle de Bravo, Ejido de San Antonio de la Laguna,'),0,0,'L',TRUE);
        $this->Ln(3);
        $this->Cell(40);
        $this->SetFont('Arial','B',8);
        $this->Cell(165,4,utf8_decode('      Valle de Bravo, Estado de México, C.P. 51200.'),0,0,'L',TRUE);
        $this->Ln(3);
        $this->Cell(40);
        $this->SetFont('Arial','',8);
        $this->Cell(165,4,utf8_decode('     Tels.:(726)266 51 87 Ext 117      titulacion@vbravo.tecnm.mx'),0,0,'L',true);

        $this->Image('img/logos/Mesquina.jpg',0,240,40);
    }

}
class Ti_carta_compromisoController extends Controller
{

    public function index($id_fecha_jurado_alumn){
        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');

        $registro_fecha=DB::selectOne('SELECT ti_fecha_jurado_alumn.*, ti_horarios_dias.horario_dia, ti_horarios_dias.hora  FROM
        ti_fecha_jurado_alumn,ti_horarios_dias WHERE ti_fecha_jurado_alumn.id_horarios_dias = ti_horarios_dias.id_horarios_dias 
        and ti_fecha_jurado_alumn.id_fecha_jurado_alumn='.$id_fecha_jurado_alumn.'');




        $datos_alumnos=DB::selectOne('SELECT * FROM `ti_reg_datos_alum` WHERE `id_alumno` = '.$registro_fecha->id_alumno.'');
        $curp=$datos_alumnos->curp_al;
        $genero=substr($curp, 10,1);
        if($genero == "H"){
            $del="del";
        }else{
            $del="de la";
        }
        //dd($registro_fecha);

        $pdf = new PDF($orientation = 'P', $unit = 'mm', $format = 'Letter');

        $fecha_titulacion=$registro_fecha->fecha_titulacion;
        $num1=date("j",strtotime($fecha_titulacion ));
        $ano1=date("Y", strtotime($fecha_titulacion ));
        $mes1= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes1=$mes1[(date('m', strtotime($fecha_titulacion ))*1)-1];
        $fecha_titulacion = $num1. ' de '.$mes1.' de '.$ano1;


        $hora_titulacion=$registro_fecha->hora;


        $jefe_titulacion=$datos_alumnos->nombre_jefe_titulacion ;
        $alumno=DB::selectOne('SELECT ti_reg_datos_alum.*,gnral_carreras.nombre carrera 
FROM ti_reg_datos_alum,gnral_carreras WHERE ti_reg_datos_alum.id_carrera = gnral_carreras.id_carrera 
                                        and  ti_reg_datos_alum.id_alumno ='.$registro_fecha->id_alumno.'');
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

        $id_carrera=$alumno->id_carrera;
        if($id_carrera == 1){
            $titulo_alumno="Licenciado en Administración";

        }elseif($id_carrera == 2){
            $titulo_alumno="Ingeniero en Sistemas Computacionales";
        }
        elseif($id_carrera == 3){
            $titulo_alumno="Arquitecto";
        }
        elseif($id_carrera == 4){
            $titulo_alumno="Ingeniero Electrico";
        }
        elseif($id_carrera == 5){
            $titulo_alumno="Ingeniero Industrial";
        }
        elseif($id_carrera == 6){
            $titulo_alumno="Ingeniero Forestal";
        }
        elseif($id_carrera == 7){
            $titulo_alumno="Licenciado en Gastronomía";
        }
        elseif($id_carrera == 8){
            $titulo_alumno="Licenciado en Turismo";

        }
        elseif($id_carrera == 13){
            $titulo_alumno="Ingeniero Mecátronico";
        }
        elseif($id_carrera == 14){
            $titulo_alumno="Ingeniero Civil";
        }



        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(10, 15, 10);
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0,0,0);

        $pdf->SetFillColor(166,166,166);
        $pdf->SetFont('Arial','B','8');
        $pdf->Ln(5);
        $pdf->Cell(190,5,utf8_decode($etiqueta->descripcion),0,1,'C');
        $pdf->Ln(5);
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(190,5,utf8_decode("CIUDADANO(A)"),0,1,'');
        $pdf->Cell(190,5,utf8_decode($nombre_alumno),0,1,'');
        $pdf->Cell(190,5,utf8_decode("EGRESADO(A) DE LA CARRERA DE ".$carrera),0,1,'');
        $pdf->Cell(190,5,utf8_decode("PRESENTE:"),0,1,'');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','16');
        $pdf->Cell(190,5,utf8_decode("CARTA DE COMPROMISO"),0,1,'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','12');

        $pdf->MultiCell(190,5,utf8_decode("Por este conducto le informo que su presentación protocolaria para obtener el Título de ".$titulo_alumno.", se llevará a cabo el día ".$fecha_titulacion." a las ".$hora_titulacion." en la Sala de Titulación de esta Institución, que quedará bajo su responsabilidad por el tiempo estipulado en este documento, no sin antes mencionar que la Sala de Titulación se proporcionara con todo su mobiliario, equipo e infraestructura  en buen estado, limpia; y que el usuario descrito en este documento generara automáticamente una constancia de no adeudo por daños o pérdidas sufridas en las instalaciones de la sala de titulación del TESVB, si se detecta que se infringieron las reglas comunicadas, o se hizo uso indebido del mobiliario y/o se dejó mobiliario en la parte externa de la sala de Titulación y/o se terminó dejando sucia el área y/o se dejaron las ventanas y puertas abiertas y/o no se comunicó al Departamento de Titulación la terminación del acto protocolario."));
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','12');
        $pdf->MultiCell(190,5,utf8_decode("NOTA IMPORTANTE: Una vez que se haya notificado en el grupo de Facebook/titulación/registro/ que tu titulo ya esta listo para ser entregado, cuentas con 3 meses a partir de la fecha de la publicación para que el Titulo profesional te sea entregado."),0,'J');
        $pdf->MultiCell(190,5,utf8_decode("El hacer caso omiso a este aviso y no recoger en tiempo y forma el Título Profesional, tendrá como consecuencia que el título permanezca resguardado por el TESVB por un año debido a las políticas de privacidad y resguardo de la información; sin excepción alguna y se tendrá que agendar una cita posterior al año para su entrega, con previo aviso."));
         $pdf->Ln(5);
        $pdf->SetFont('Arial','','12');
        $pdf->MultiCell(190,5,utf8_decode("Sin otro particular por el momento, quedo de Usted."));

        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(190,5,utf8_decode("ATENTAMENTE"),0,1,'C');
        $pdf->Ln(15);
        $pdf->Cell(190,5,utf8_decode($jefe_titulacion),0,1,'C');
        $pdf->Cell(190,5,utf8_decode("JEFE(A) DEL DEPARTAMENTO DE TITULACIÓN"),0,1,'C');
        $pdf->SetFont('Arial','','7');
        $pdf->Cell(190,5,utf8_decode("C. c. p. - Archivo"),0,1,'L');
        $pdf->Cell(190,5,utf8_decode("TSGB"),0,1,'L');
        $modo="I";
        $nom="carta_compromiso_".$cuenta."_".$alumno->nombre_al."_".$alumno->apaterno."_".$alumno->amaterno.".pdf";

        $pdf->Output($nom,$modo);
        exit();
    }
}
