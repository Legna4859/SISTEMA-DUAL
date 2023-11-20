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
        $this->Image('img/logo3.PNG', 125, 10, 70);
        $this->Image('img/logos/ArmasBN.png',20,10,50);

        $this->Image('img/logos/Captura.PNG',80,10,35);
        $this->Ln(10);
    }
    //PIE DE PAGINA
    function Footer()
    {

        $this->SetY(-35);
        $this->SetFont('Arial','',8);
        //$this->Image('img/sgc.PNG',40,240,20);
        $this->Image('img/pie/logos_iso.jpg',40,240,60);
       // $this->Image('img/sga.PNG',65,240,20);

        $this->Ln(3);
        $this->SetFont('Arial','B',8);
        $this->Cell(50);
        $this->Cell(130,-2,utf8_decode('SECRETARÍA DE EDUCACIÓN'),0,0,'R');
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(130,-2,utf8_decode('SUBSECRETARÍA DE EDUCACIÓN SUPERIOR Y NORMAL'),0,0,'R');
        $this->Ln(3);
        $this->SetFont('Arial','',8);
        $this->Cell(50);
        $this->Cell(130,-2,utf8_decode('TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO'),0,0,'R');
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(130,-2,utf8_decode('DEPARTAMENTO DE TITULACIÓN'),0,0,'R');
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
        $this->Cell(165,4,utf8_decode('     Tels.:(726) 266 51 87 Ext,: 117      titulacion@vbravo.tecnm.mx'),0,0,'L',true);

        $this->Image('img/logos/Mesquina.jpg',0,240,40);
    }

}
class Ti_pdf_oficio_recursosController extends Controller
{
    public function index($id_alumno){
        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');
        $oficio_recursos=DB::selectOne('SELECT * FROM `ti_oficio_recursos` WHERE `id_alumno` = '.$id_alumno.'');
        $numero_oficio_recursos=$oficio_recursos->numero_oficio_recursos;
        $fecha_titulacion=DB::selectOne('SELECT ti_fecha_jurado_alumn.*, ti_horarios_dias.horario_dia, ti_horarios_dias.hora  FROM
        ti_fecha_jurado_alumn,ti_horarios_dias WHERE ti_fecha_jurado_alumn.id_horarios_dias = ti_horarios_dias.id_horarios_dias 
        and ti_fecha_jurado_alumn.id_alumno ='.$id_alumno.'');

        $hora_titulacion=$fecha_titulacion->hora;
        $fecha_titulacion1=$fecha_titulacion->fecha_titulacion;
        $num1=date("j",strtotime($fecha_titulacion1 ));
        $ano1=date("Y", strtotime($fecha_titulacion1 ));

        $mes1= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes1=$mes1[(date('m', strtotime($fecha_titulacion1 ))*1)-1];
        $fecha_titulacion1 = $num1. ' de '.$mes1.' de '.$ano1.' a las '.$hora_titulacion;





        $dia_titulacion=  substr($fecha_titulacion->fecha_titulacion, 0, 2);
        $mes_titulacion=  substr($fecha_titulacion->fecha_titulacion, 3, 2);
        $year=  substr($fecha_titulacion->fecha_titulacion, 6, 4);


        if($mes_titulacion == 1){
            $mes_titulacion="enero";
        }
        if($mes_titulacion == 2){
            $mes_titulacion="febrero";
        }
        if($mes_titulacion == 3){
            $mes_titulacion="marzo";
        }
        if($mes_titulacion == 4){
            $mes_titulacion="abril";
        }
        if($mes_titulacion == 5){
            $mes_titulacion="mayo";
        }
        if($mes_titulacion == 6){
            $mes_titulacion="junio";
        }
        if($mes_titulacion == 7){
            $mes_titulacion="julio";
        }
        if($mes_titulacion == 8){
            $mes_titulacion="agosto";
        }
        if($mes_titulacion == 9){
            $mes_titulacion="septiembre";
        }
        if($mes_titulacion == 10){
            $mes_titulacion="octubre";
        }
        if($mes_titulacion == 11){
            $mes_titulacion="noviembre";
        }
        if($mes_titulacion == 12){
            $mes_titulacion="diciembre";
        }
        $dato_presidente=DB::selectOne('SELECT gnral_personales.nombre,gnral_personales.cedula, ti_jurado_alumno.*, abreviaciones.titulo  
    FROM ti_jurado_alumno, gnral_personales,abreviaciones_prof, abreviaciones WHERE ti_jurado_alumno.id_alumno = '.$id_alumno.'
        AND ti_jurado_alumno.id_tipo_jurado = 1 and gnral_personales.id_personal= ti_jurado_alumno.id_personal 
                                                                                and abreviaciones_prof.id_personal = gnral_personales.id_personal 
                                                                                and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion');
        $nombre_presidente=$dato_presidente->titulo." ".$dato_presidente->nombre;

        $dato_secretario = DB::selectOne('SELECT gnral_personales.nombre,gnral_personales.cedula, ti_jurado_alumno.*, abreviaciones.titulo  
    FROM ti_jurado_alumno, gnral_personales,abreviaciones_prof, abreviaciones WHERE ti_jurado_alumno.id_alumno = '.$id_alumno.'
        AND ti_jurado_alumno.id_tipo_jurado = 2 and gnral_personales.id_personal= ti_jurado_alumno.id_personal 
                                                                                and abreviaciones_prof.id_personal = gnral_personales.id_personal 
                                                                                and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion');
        $nombre_secretario=$dato_secretario->titulo." ".$dato_secretario->nombre;

        $dato_vocal = DB::selectOne('SELECT gnral_personales.nombre,gnral_personales.cedula, ti_jurado_alumno.*, abreviaciones.titulo  
    FROM ti_jurado_alumno, gnral_personales,abreviaciones_prof, abreviaciones WHERE ti_jurado_alumno.id_alumno = '.$id_alumno.'
        AND ti_jurado_alumno.id_tipo_jurado = 3 and gnral_personales.id_personal= ti_jurado_alumno.id_personal 
                                                                                and abreviaciones_prof.id_personal = gnral_personales.id_personal 
                                                                                and abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion');
        $nombre_vocal=$dato_vocal->titulo." ".$dato_vocal->nombre;

        $datos_alumno=DB::selectOne('SELECT ti_reg_datos_alum.*,ti_opciones_titulacion.opcion_titulacion, gnral_carreras.nombre carrera,
       ti_tipo_titulo_obtenido.tipo_titulo from ti_reg_datos_alum,ti_opciones_titulacion,ti_tipo_titulo_obtenido, gnral_carreras
where ti_reg_datos_alum.id_opcion_titulacion = ti_opciones_titulacion.id_opcion_titulacion and 
      ti_reg_datos_alum.id_carrera = gnral_carreras.id_carrera and 
      ti_reg_datos_alum.id_carrera=ti_tipo_titulo_obtenido.id_carrera and ti_reg_datos_alum.id_alumno='.$id_alumno.'');

        $nombre_alumno=$datos_alumno->nombre_al." ".$datos_alumno->apaterno." ".$datos_alumno->amaterno;
        $opcion_titulacion=$datos_alumno->opcion_titulacion;
        $titulo_obtenido=$datos_alumno->tipo_titulo;
        $carrera=$datos_alumno->carrera;

        $acta_titulacion=DB::selectOne('SELECT * FROM `ti_acta_titulaciones` WHERE `id_alumno` ='.$id_alumno.'');
        $numero_acta=$acta_titulacion->numero_acta_titulacion;
        $numero_libro=$acta_titulacion->numero_libro_acta_titulacion;
        $foja_acta_titulacion=$acta_titulacion->foja_acta_titulacion;

        $reg_al=DB::selectOne('SELECT * FROM `ti_datos_alumno_reg_dep` WHERE `id_alumno` ='.$id_alumno.'');
        $id_sexo=$reg_al->id_sexo;
        if($id_sexo == 1){
         $argumento="del alumno";
            $egre="egresado";
        }else{
            $argumento="de la alumna";
            $egre="egresada";
        }




        $jefe_titulacion=$datos_alumno->nombre_jefe_titulacion;

        $pdf = new PDF($orientation = 'P', $unit = 'mm', $format = 'Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(25, 15, 10);
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0,0,0);

        $pdf->SetFillColor(166,166,166);
        $pdf->SetFont('Arial','B','9');
        $pdf->Ln(8);
        $pdf->Cell(150,5,utf8_decode($etiqueta->descripcion),0,1,'C');
        $pdf->Ln(8);
        $pdf->SetFont('Arial','','10');
        $pdf->Cell(160,5,utf8_decode("Valle de bravo, México; "),0,1,'R');
        $pdf->Cell(160,5,utf8_decode("a ".$dia_titulacion." de ".$mes_titulacion." de ".$year),0,1,'R');
        $pdf->SetFont('Arial','B','10');
        $pdf->Cell(160,5,utf8_decode("Oficio No. 210C1901020201L-".$numero_oficio_recursos."/".$year),0,1,'R');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(160,5,utf8_decode("DOCTORA EN EDUCACIÓN"),0,1,'');
        $pdf->Cell(160,5,utf8_decode("ANDREA CRUZ MONDRAGÓN"),0,1,'');
        $pdf->Cell(160,5,utf8_decode("DIRECTORA DE ADMINISTRACIÓN Y FINANZAS"),0,1,'');
        $pdf->Cell(160,5,utf8_decode("PRESENTE"),0,1,'');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','12');
        $pdf->MultiCell(160,5,utf8_decode("Por este medio me permito informarle que el día de hoy se llevó a cabo el Protocolo de Titulación ".$argumento." ".$nombre_alumno.",  ".$egre." de la carrera de ".$carrera.". El acto protocolario quedo registrado en el Libro de Actas de Titulación número ".$numero_libro.", foja ".$foja_acta_titulacion." con el acta número ".$numero_acta.". Por lo tanto, solicito a usted de la manera más atenta, realizar el pago al Jurado que participo en Acto Recepcional, el dia ".$fecha_titulacion1 ),0,'J');
        $pdf->Ln(10);
        $pdf->Cell(160,5,utf8_decode("El jurado estuvo integrado de la siguiente forma:"),0,1,'');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','12');
        $pdf->Cell(50,5,utf8_decode("Presidente:"),0,0,'');
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(110,5,utf8_decode($nombre_presidente),0,1,'');
        $pdf->SetFont('Arial','','12');
        $pdf->Cell(50,5,utf8_decode("Secretario:"),0,0,'');
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(110,5,utf8_decode($nombre_secretario),0,1,'');
        $pdf->SetFont('Arial','','12');
        $pdf->Cell(50,5,utf8_decode("Vocal:"),0,0,'');
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(110,5,utf8_decode($nombre_vocal),0,1,'');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','12');
        $pdf->Cell(160,5,utf8_decode("Sin otro particular por el momento, me despido de usted."),0,1,'');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(160,5,utf8_decode("ATENTAMENTE"),0,1,'C');
        $pdf->Ln(15);
        $pdf->Cell(40,5,utf8_decode(""),0,0,'');
        $pdf->Cell(80,5,utf8_decode(""),"B",1,'');
        $pdf->Cell(40,5,utf8_decode(""),0,0,'');
        $alumno=DB::selectOne('SELECT ti_reg_datos_alum.*,gnral_carreras.nombre carrera FROM ti_reg_datos_alum,gnral_carreras WHERE ti_reg_datos_alum.id_carrera = gnral_carreras.id_carrera and  ti_reg_datos_alum.id_alumno ='.$id_alumno.'');
        $jefe_titulacion=$alumno->nombre_jefe_titulacion;
        $pdf->Cell(80,5,utf8_decode($jefe_titulacion),0,1,'C');
        $pdf->Cell(40,5,utf8_decode(""),0,0,'');

        $pdf->Cell(80,5,utf8_decode("JEFE(A) DEL DEPARTAMENTO DE TITULACIÓN"),0,1,'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','7');
        $pdf->Cell(160,5,utf8_decode("c.c.p L.C. Esther Silverio Zaráte.- Jefa del Departamento de Administración de Personal del TESVB."),0,1,'');
        $pdf->Cell(160,5,utf8_decode("c.c.p T.S.U. en C. Laura Angelica Garcia Garcia.- Jefa de Departamento de Recursos Financieros del TESVB."),0,1,'');
        $pdf->Cell(160,5,utf8_decode("Archivo"),0,1,'');
        $pdf->Cell(160,5,utf8_decode("TSGB"),0,1,'');

        $pdf->Output();
        exit();
    }
}
