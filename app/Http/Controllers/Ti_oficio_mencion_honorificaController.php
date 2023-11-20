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
      //  $this->Image('img/sgc.PNG',40,240,20);
        $this->Image('img/pie/logos_iso.jpg',40,240,60);
      //  $this->Image('img/sga.PNG',65,240,20);
        $this->Cell(50);
        $this->Cell(145,-2,utf8_decode(''),0,0,'R');
        $this->Ln(3);
        $this->SetFont('Arial','B',8);
        $this->Cell(50);
        $this->Cell(135,-2,utf8_decode('SECRETARÍA DE EDUCACIÓN'),0,0,'R');
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(135,-2,utf8_decode('SUBSECRETARÍA DE EDUCACIÓN SUPERIOR Y NORMAL'),0,0,'R');
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(135,-2,utf8_decode('TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO'),0,0,'R');
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(135,-2,utf8_decode('DEPARTAMENTO DE TITULACIÓN'),0,0,'R');
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
class Ti_oficio_mencion_honorificaController extends Controller
{
    public function index($id_fecha_jurado_alumn){
        $registro_fecha=DB::selectOne('SELECT ti_fecha_jurado_alumn.*, ti_horarios_dias.horario_dia, ti_horarios_dias.hora  FROM
        ti_fecha_jurado_alumn,ti_horarios_dias WHERE ti_fecha_jurado_alumn.id_horarios_dias = ti_horarios_dias.id_horarios_dias 
        and ti_fecha_jurado_alumn.id_fecha_jurado_alumn='.$id_fecha_jurado_alumn.'');



        $fecha_registro_oficio=$registro_fecha->fecha_mencion_honorifica;

        $num1=date("j",strtotime($fecha_registro_oficio ));
        $ano1=date("Y", strtotime($fecha_registro_oficio ));
        $mes1= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes1=$mes1[(date('m', strtotime($fecha_registro_oficio ))*1)-1];
        $fecha_registro_oficio = $num1. ' de '.$mes1.' de '.$ano1;

        $numero_oficio=$registro_fecha->mencion_honorifica;

        $datos_alumnos=DB::selectOne('SELECT * FROM `ti_reg_datos_alum` WHERE `id_alumno` = '.$registro_fecha->id_alumno.'');
        $curp=$datos_alumnos->curp_al;
        $genero=substr($curp, 10,1);
        if($genero == "H"){
            $del="DEL";
            $el="el";
        }else{
            $del="DE LA";
            $el="la";
        }
        $alumno=DB::selectOne('SELECT ti_reg_datos_alum.*,gnral_carreras.nombre carrera 
FROM ti_reg_datos_alum,gnral_carreras WHERE ti_reg_datos_alum.id_carrera = gnral_carreras.id_carrera 
                                        and  ti_reg_datos_alum.id_alumno ='.$registro_fecha->id_alumno.'');
       $cuenta=$alumno->no_cuenta;

        $promedio=$alumno->promedio_general_tesvb ;
        $nombre_alumno=$alumno->nombre_al." ".$alumno->apaterno." ".$alumno->amaterno;

        $jefe_titulacion=$datos_alumnos->nombre_jefe_titulacion ;
        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');

        $pdf = new PDF($orientation = 'P', $unit = 'mm', $format = 'Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(20, 15, 20);
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0,0,0);

        $pdf->SetFillColor(166,166,166);
        $pdf->SetFont('Arial','B','8');
        $pdf->Ln(5);
        $pdf->Cell(190,5,utf8_decode($etiqueta->descripcion),0,1,'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial','','10');
        $pdf->Cell(170,5,utf8_decode("Valle de Bravo, México;"),0,1,'R');
        $pdf->Cell(170,5,utf8_decode("a ".$fecha_registro_oficio),0,1,'R');
        $pdf->SetFont('Arial','B','10');
        $pdf->Cell(170,5,utf8_decode("Oficio No. 210C1901020201L-".$numero_oficio."/".$ano1),0,1,'R');

        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(170,5,utf8_decode("INTEGRANTES DEL JURADO ".$del),0,1,'');
        $pdf->Cell(170,5,utf8_decode("C. ".$nombre_alumno),0,1,'');
        $pdf->Cell(170,5,utf8_decode("PRESENTE:"),0,1,'');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','12');
        $pdf->MultiCell(170,5,utf8_decode("Sirva la presente para enviar un cordial saludo y al mismo tiempo informar que ".$el." C. ".$nombre_alumno." con promedio general de ".$promedio." puntos en escala de 0 a 100, cumple con la primer condicionante para ser merecedor de la MENCIÓN HONORIFICA, siendo el jurado quien tenga el veredicto sobre el otorgamiento de esta, evaluando las dos condiciones restantes que solicita el Reglamento de Titulación Integral del Tecnológico de Estudios Superiores de Valle de Bravo."));
        $pdf->Ln(5);
        $pdf->Cell(170,5,utf8_decode("II. Presentar y defender su proyecto con un desempeño excelente"),0,1,'');
        $pdf->Ln(5);
        $pdf->Cell(170,5,utf8_decode("III. Se acuerde por unanimidad de votos "),0,1,'');
        $pdf->Ln(5);
        $pdf->Cell(170,5,utf8_decode("Sin más por el momento, quedo de ustedes."),0,1,'');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(170,5,utf8_decode("ATENTAMENTE"),0,1,'C');
        $pdf->Ln(15);
        $pdf->Cell(170,5,utf8_decode($jefe_titulacion),0,1,'C');
        $pdf->Cell(170,5,utf8_decode("JEFE(A) DEL DEPARTAMENTO DE TITULACIÓN"),0,1,'C');
        $pdf->SetFont('Arial','','7');
        $pdf->Cell(170,5,utf8_decode("C. c. p. - Archivo"),0,1,'L');
        $pdf->Cell(170,5,utf8_decode("TSGB"),0,1,'L');
        $modo="I";
        $nom="mencion_honorifica_".$cuenta."_".$alumno->nombre_al."_".$alumno->apaterno."_".$alumno->amaterno.".pdf";

        $pdf->Output($nom,$modo);
        exit();
    }
}
