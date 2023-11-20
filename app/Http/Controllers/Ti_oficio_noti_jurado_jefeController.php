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
        //$this->Image('img/sgc.PNG',40,240,20);
       // $this->Image('img/tutorias/cir.jpg',89,239,20);
       // $this->Image('img/sga.PNG',65,240,20);
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
class Ti_oficio_noti_jurado_jefeController extends Controller
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
        $fecha_oficio_noti_jurado_jefe =$registro_fecha->fecha_oficio_noti_jurado_jefe ;
        $fecha_titulacion=$registro_fecha->fecha_titulacion;
        $num1=date("j",strtotime($fecha_titulacion ));
        $ano1=date("Y", strtotime($fecha_titulacion ));
        $mes1= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes1=$mes1[(date('m', strtotime($fecha_titulacion ))*1)-1];
        $fecha_titulacion = $num1. ' de '.$mes1.' de '.$ano1;



        $num=date("j",strtotime($fecha_oficio_noti_jurado_jefe ));
        $ano=date("Y", strtotime($fecha_oficio_noti_jurado_jefe ));
        $mes= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes=$mes[(date('m', strtotime($fecha_oficio_noti_jurado_jefe ))*1)-1];
        $fecha_oficio_noti_jurado_jefe = $num. ' de '.$mes.' de '.$ano;
        $numero_oficio=$registro_fecha->oficio_noti_jurado_jefe;
        $dia_titulacion=$registro_fecha->fecha_titulacion;
        $hora_titulacion=$registro_fecha->hora;

        $presidente=DB::selectOne('SELECT ti_jurado_alumno.*,gnral_personales.nombre,abreviaciones.titulo,gnral_personales.cedula
FROM ti_jurado_alumno,gnral_personales,abreviaciones_prof, abreviaciones 
WHERE ti_jurado_alumno.id_alumno = '.$registro_fecha->id_alumno.' AND ti_jurado_alumno.id_tipo_jurado = 1 
  and ti_jurado_alumno.id_personal=gnral_personales.id_personal 
  and abreviaciones_prof.id_personal=gnral_personales.id_personal 
  and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion ');

        $presidente="Presidente: ".$presidente->titulo." ".$presidente->nombre."  Céd. Prof.: ".$presidente->cedula;

        $secretario=DB::selectOne('SELECT ti_jurado_alumno.*,gnral_personales.nombre,abreviaciones.titulo,gnral_personales.cedula
FROM ti_jurado_alumno,gnral_personales,abreviaciones_prof, abreviaciones 
WHERE ti_jurado_alumno.id_alumno = '.$registro_fecha->id_alumno.' AND ti_jurado_alumno.id_tipo_jurado = 2
  and ti_jurado_alumno.id_personal=gnral_personales.id_personal 
  and abreviaciones_prof.id_personal=gnral_personales.id_personal 
  and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion ');

        $secretario="Secretario: ".$secretario->titulo." ".$secretario->nombre."  Céd. Prof.: ".$secretario->cedula;

        $vocal=DB::selectOne('SELECT ti_jurado_alumno.*,gnral_personales.nombre,abreviaciones.titulo,gnral_personales.cedula
FROM ti_jurado_alumno,gnral_personales,abreviaciones_prof, abreviaciones 
WHERE ti_jurado_alumno.id_alumno = '.$registro_fecha->id_alumno.' AND ti_jurado_alumno.id_tipo_jurado = 3
  and ti_jurado_alumno.id_personal=gnral_personales.id_personal 
  and abreviaciones_prof.id_personal=gnral_personales.id_personal 
  and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion ');

        $vocal="Vocal: ".$vocal->titulo." ".$vocal->nombre."  Céd. Prof.: ".$vocal->cedula;

        $suplente=DB::selectOne('SELECT ti_jurado_alumno.*,gnral_personales.nombre,abreviaciones.titulo,gnral_personales.cedula
FROM ti_jurado_alumno,gnral_personales,abreviaciones_prof, abreviaciones 
WHERE ti_jurado_alumno.id_alumno = '.$registro_fecha->id_alumno.' AND ti_jurado_alumno.id_tipo_jurado = 4
  and ti_jurado_alumno.id_personal=gnral_personales.id_personal 
  and abreviaciones_prof.id_personal=gnral_personales.id_personal 
  and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion ');

        $suplente="Suplente: ".$suplente->titulo." ".$suplente->nombre."  Céd. Prof.: ".$suplente->cedula;




        $jefe_titulacion=$datos_alumnos->nombre_jefe_titulacion ;
        $alumno=DB::selectOne('SELECT ti_reg_datos_alum.*,gnral_carreras.nombre carrera 
FROM ti_reg_datos_alum,gnral_carreras WHERE ti_reg_datos_alum.id_carrera = gnral_carreras.id_carrera 
                                        and  ti_reg_datos_alum.id_alumno ='.$registro_fecha->id_alumno.'');
        $nombre_alumno=$alumno->nombre_al." ".$alumno->apaterno." ".$alumno->amaterno;
        $carrera=$alumno->carrera;
        $cuenta=$alumno->no_cuenta;
        $opcion_titulacion=DB::selectOne('SELECT * FROM `ti_opciones_titulacion` WHERE `id_opcion_titulacion` ='.$alumno->id_opcion_titulacion.'');
        $opcion_titulacion=$opcion_titulacion->opcion_titulacion;


        $jefe_division=$datos_alumnos->nombre_jefe_division;
        $nombre_proyecto=$alumno->nom_proyecto;


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
        $pdf->SetFont('Arial','','10');
        $pdf->Cell(190,5,utf8_decode("Valle de Bravo, México;"),0,1,'R');
        $pdf->Cell(190,5,utf8_decode("a ".$fecha_oficio_noti_jurado_jefe),0,1,'R');
        $pdf->SetFont('Arial','B','10');
        $pdf->Cell(190,5,utf8_decode("Oficio No. 210C1901020201L-".$numero_oficio."/".$ano1),0,1,'R');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','10');
        $pdf->Cell(190,5,utf8_decode($jefe_division),0,1,'');
        $pdf->Cell(190,5,utf8_decode("JEFE(A) DE DIVISIÓN DE  LA ".$carrera),0,1,'');
        $pdf->Cell(190,5,utf8_decode("PRESENTE:"),0,1,'');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','10');

        $pdf->MultiCell(190,5,utf8_decode("Sea este el conducto para informarle la designación de las o los docentes que conformarán el Jurado que sancionará la presentación protocolaria ".$del." C. ".$nombre_alumno." con No. de control ".$cuenta.", mismo que tendrá verificativo el día ".$fecha_titulacion." a las ".$hora_titulacion." Por la opción ".$opcion_titulacion." en la de esta Institución."));
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','10');
        $pdf->Cell(20,5,utf8_decode(""),0,0,'C');
        $pdf->Cell(170,5,utf8_decode($presidente),0,1,'l');
        $pdf->Cell(20,5,utf8_decode(""),0,0,'C');
        $pdf->Cell(170,5,utf8_decode($secretario),0,1,'L');
        $pdf->Cell(20,5,utf8_decode(""),0,0,'C');
        $pdf->Cell(170,5,utf8_decode($vocal),0,1,'L');
        $pdf->Cell(20,5,utf8_decode(""),0,0,'C');
        $pdf->Cell(170,5,utf8_decode($suplente),0,1,'L');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','10');
        $pdf->MultiCell(190,5,utf8_decode("Por lo anterior solicito usted muy atentamente sirva informar a los docentes antes mencionados de la designación que han sido objeto y de igual manera se solicite pasar a este departamento por las actas de titulación correspondientes, no olvidando que el correcto uso y requisitado de los mismos es responsabilidad del jurado. Una vez terminado el acto protocolario regresar las actas a este departamento; acto seguido pasar el jurado y el candidato a firmar los documentos correspondientes al Departamento de Titulación."),0,'J');
        $pdf->MultiCell(190,5,utf8_decode("Es importante hacerles mención que para que un docente del TESVB sea jurado, debe tener al menos un año de experiencia docente o profesional y debe entregar al Departamento de Titulación copia del titulo Profesional, copia de la Cedula Profesional y Curriculum vitae."));
        $pdf->MultiCell(190,5,utf8_decode("La vestimenta del jurado para el acto protocolario debe ser formal."));
        $pdf->SetFont('Arial','B','10');
        $pdf->MultiCell(190,5,utf8_decode("Para realizar un cambio de sinodal se debe informar por escrito al Departamento de Titulación con 3 días de anticipación mediante el documento de comisión u oficio del jefe de división y oficio del docente justificando su inasistencia y la solicitud del cambio de integrante de jurado."));
        $pdf->SetFont('Arial','','10');
        $pdf->MultiCell(190,5,utf8_decode("Sin más por el momento, me despido de Usted no sin antes enviarle un cordial saludo."));
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','10');
        $pdf->Cell(190,5,utf8_decode("ATENTAMENTE"),0,1,'C');
        $pdf->Ln(15);
        $pdf->Cell(190,5,utf8_decode($jefe_titulacion),0,1,'C');
        $pdf->Cell(190,5,utf8_decode("JEFE(A) DEL DEPARTAMENTO DE TITULACIÓN"),0,1,'C');
        $pdf->SetFont('Arial','','7');
        $pdf->Cell(190,5,utf8_decode("C. c. p. - Archivo"),0,1,'L');
        $pdf->Cell(190,5,utf8_decode("TSGB"),0,1,'L');
        $modo="I";
        $nom="oficio_notificacion_jurado_jefe_division_".$cuenta."_".$alumno->nombre_al."_".$alumno->apaterno."_".$alumno->amaterno.".pdf";

        $pdf->Output($nom,$modo);
        exit();
    }
}
