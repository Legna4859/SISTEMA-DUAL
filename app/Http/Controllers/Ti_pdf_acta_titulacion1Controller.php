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
        $this->Image('img/residencia/tesvb.jpg', 145, 10, 50);
        $this->Image('img/logos/ArmasBN.png',20,10,60);
        $this->Ln(10);
    }
    //PIE DE PAGINA
    function Footer()
    {


    }

}
class Ti_pdf_acta_titulacion1Controller extends Controller
{
    public function index($id_alumno){
        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');
        $fecha_titulacion=DB::selectOne('SELECT * FROM `ti_fecha_jurado_alumn` WHERE `id_alumno` ='.$id_alumno.'');

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

        $datos_alumno=DB::selectOne('SELECT ti_reg_datos_alum.*,ti_opciones_titulacion.opcion_titulacion,
       ti_tipo_titulo_obtenido.tipo_titulo from ti_reg_datos_alum,ti_opciones_titulacion,ti_tipo_titulo_obtenido
where ti_reg_datos_alum.id_opcion_titulacion = ti_opciones_titulacion.id_opcion_titulacion and 
      ti_reg_datos_alum.id_carrera=ti_tipo_titulo_obtenido.id_carrera and ti_reg_datos_alum.id_alumno='.$id_alumno.'');

        $nombre_alumno=$datos_alumno->nombre_al." ".$datos_alumno->apaterno." ".$datos_alumno->amaterno;
        $opcion_titulacion=$datos_alumno->opcion_titulacion;
        $titulo_obtenido=$datos_alumno->tipo_titulo;

        $acta_titulacion=DB::selectOne('SELECT * FROM `ti_acta_titulaciones` WHERE `id_alumno` ='.$id_alumno.'');
        $numero_acta=$acta_titulacion->numero_acta_titulacion;
        $numero_libro=$acta_titulacion->numero_libro_acta_titulacion;
        $foja_acta_titulacion=$acta_titulacion->foja_acta_titulacion;

        $director_general=$datos_alumno->nombre_director_general;
        $sexo_director_general=$datos_alumno->sexo_director_general;




        $pdf = new PDF($orientation = 'P', $unit = 'mm', $format = 'Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(45, 15, 10);
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0,0,0);

        $pdf->SetFillColor(166,166,166);
        $pdf->SetFont('Arial','B','12');
        $pdf->Ln(8);
        $pdf->Cell(150,5,utf8_decode("Acta No. ".$numero_acta),0,1,'R');
        $pdf->Ln(8);
        $pdf->Cell(150,5,utf8_decode("ACTA DE TITULACIÓN PROFESIONAL"),0,1,'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','10');
        $pdf->MultiCell(160,5,utf8_decode("En Valle de Bravo, Estado de México, siendo las _____ horas del día ".$dia_titulacion." del mes de ".$mes_titulacion." del año ".$year.", de conformidad con el Capitulo V Articulo 48 y 50 del Reglamento de Titulación Integral del Tecnológico de Estudios Superiores de Valle de Bravo, se reunieron en las Instalaciones del Tecnológico, los profesores que conforman el jurado siguiente:"));
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','10');
        $pdf->Cell(50,5,utf8_decode("Presidente:"),0,0,'');
        $pdf->SetFont('Arial','','10');
        $pdf->Cell(110,5,utf8_decode($nombre_presidente),0,1,'');
        $pdf->SetFont('Arial','B','10');
        $pdf->Cell(50,5,utf8_decode("Secretario:"),0,0,'');
        $pdf->SetFont('Arial','','10');
        $pdf->Cell(110,5,utf8_decode($nombre_secretario),0,1,'');
        $pdf->SetFont('Arial','B','10');
        $pdf->Cell(50,5,utf8_decode("Vocal:"),0,0,'');
        $pdf->SetFont('Arial','','10');
        $pdf->Cell(110,5,utf8_decode($nombre_vocal),0,1,'');
        $pdf->Ln(5);
        $pdf->MultiCell(160,5,utf8_decode("Este jurado conformado para sancionar el acto de recepción profesional del C. ".$nombre_alumno." quien de acuerdo al Capitulo IV Artículo 12, del citado Reglamento, comparece para obtener el Titulo de ".$titulo_obtenido." por la opción de Titulación Integral ".$opcion_titulacion."."));
        $pdf->Ln(5);
        $pdf->MultiCell(160,5,utf8_decode("Tomando en cuenta la presentación realizada por el sustentante, el jurado procedió a su análisis, acto seguido, el jurado acordó APROBAR  ____________________________________________ al sustentante, por lo que a continuación procedió a TOMARLE LA PROTESTA."));
        $pdf->Ln(5);
        $pdf->MultiCell(160,5,utf8_decode("Siendo las _____ horas del día ".$dia_titulacion." del mes de ".$mes_titulacion." del año ".$year." se concluyó con el levantamiento de la presente Acta, quedando asentada en el libro de actas de Titulación Profesional No. ".$numero_libro." foja ".$foja_acta_titulacion.", resguardado por el Departamento de Titulación del Tecnológico de Estudios Superiores de Valle de Bravo, misma que leída y aprobada, fue firmada por el jurado y por la C. Directora General del Tecnológico para los efectos legales procedentes."));
        $pdf->Ln(20);
        $pdf->Cell(50,5,utf8_decode("_________________________"),0,0,'');
        $pdf->Cell(5,5,utf8_decode(""),0,0,'');
        $pdf->Cell(50,5,utf8_decode("_________________________"),0,0,'');
        $pdf->Cell(5,5,utf8_decode(""),0,0,'');
        $pdf->Cell(50,5,utf8_decode("_________________________"),0,1,'');
        $y=$pdf->GetY();
        $x=$pdf->GetX();
        $pdf->SetXY($x,$y);
        $pdf->SetFont('Arial','B','10');
        $pdf->MultiCell(50, 5, utf8_decode($nombre_presidente),0,'C');
        $y1=$pdf->GetY();
        $pdf->SetXY($x+55,$y);
        $pdf->MultiCell(50, 5, utf8_decode($nombre_secretario),0,'C');
        $y2=$pdf->GetY();
        $pdf->SetXY($x+110,$y);
        $pdf->MultiCell(50, 5, utf8_decode($nombre_vocal),0,'C');
        $y3=$pdf->GetY();

        $x1=$pdf->GetX();
        $pdf->SetXY($x1,$y1);
        $pdf->Cell(50,5,utf8_decode("Céd. Prof: ".$dato_presidente->cedula),0,1,'C');
        $pdf->Cell(50,5,utf8_decode("Presidente"),0,0,'C');
        $x2=$pdf->GetX();
        $pdf->SetXY($x2,$y2);
        $pdf->Cell(5,5,utf8_decode(""),0,0,'');
        $pdf->Cell(50,5,utf8_decode("Céd. Prof: ".$dato_secretario->cedula),0,1,'C');
        $pdf->Cell(55,5,utf8_decode(""),0,0,'');
        $pdf->Cell(50,5,utf8_decode("Secretario"),0,0,'C');
        $x3=$pdf->GetX();
        $pdf->SetXY($x3,$y3);
        $pdf->Cell(5,5,utf8_decode(""),0,0,'');
        $pdf->Cell(50,5,utf8_decode("Céd. Prof: ".$dato_vocal->cedula),0,1,'C');
        $pdf->Cell(110,5,utf8_decode(""),0,0,'');
        $pdf->Cell(50,5,utf8_decode("Vocal"),0,1,'C');


        $pdf->Ln(15);
        $pdf->Cell(40,5,utf8_decode(""),0,0,'');
        $pdf->Cell(80,5,utf8_decode(""),"B",1,'');
        $pdf->Cell(40,5,utf8_decode(""),0,0,'');
        $pdf->Cell(80,5,utf8_decode("$director_general"),0,1,'C');
        $pdf->Cell(40,5,utf8_decode(""),0,0,'');
        if($sexo_director_general == 'M'){
            $pdf->Cell(80,5,utf8_decode("Director General"),0,1,'C');
        }else{
            $pdf->Cell(80,5,utf8_decode("Directora General"),0,1,'C');
        }

        $pdf->Image('img/ovalo.gif',8,66,36,54);

        $pdf->Output();
        exit();
    }
    public function acta_extención_examen($id_alumno){
        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');
        $fecha_titulacion=DB::selectOne('SELECT * FROM `ti_fecha_jurado_alumn` WHERE `id_alumno` ='.$id_alumno.'');

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

        $datos_alumno=DB::selectOne('SELECT ti_reg_datos_alum.*,ti_opciones_titulacion.opcion_titulacion,
       ti_tipo_titulo_obtenido.tipo_titulo from ti_reg_datos_alum,ti_opciones_titulacion,ti_tipo_titulo_obtenido
where ti_reg_datos_alum.id_opcion_titulacion = ti_opciones_titulacion.id_opcion_titulacion and 
      ti_reg_datos_alum.id_carrera=ti_tipo_titulo_obtenido.id_carrera and ti_reg_datos_alum.id_alumno='.$id_alumno.'');

        $nombre_alumno=$datos_alumno->nombre_al." ".$datos_alumno->apaterno." ".$datos_alumno->amaterno;
        $opcion_titulacion=$datos_alumno->opcion_titulacion;
        $titulo_obtenido=$datos_alumno->tipo_titulo;

        $acta_titulacion=DB::selectOne('SELECT * FROM `ti_acta_titulaciones` WHERE `id_alumno` ='.$id_alumno.'');
        $numero_acta=$acta_titulacion->numero_acta_titulacion;
        $numero_libro=$acta_titulacion->numero_libro_acta_titulacion;
        $foja_acta_titulacion=$acta_titulacion->foja_acta_titulacion;
        $hora_conformidad=$acta_titulacion->hora_conformidad_acta;
        $hora_levantamiento=$acta_titulacion->hora_levantamiento_acta;

        $reg_al=DB::selectOne('SELECT ti_datos_alumno_reg_dep.*, ti_decisiones_jurado.decision  
FROM ti_datos_alumno_reg_dep,ti_decisiones_jurado WHERE ti_datos_alumno_reg_dep.id_decision=ti_decisiones_jurado.id_decision 
                                                    and ti_datos_alumno_reg_dep.id_alumno='.$id_alumno.'');
        $id_sexo=$reg_al->id_sexo;
        if($id_sexo == 1){
            $argumento="del";
            $egre="egresado";
        }else{
            $argumento="de la";
            $egre="egresada";
        }
        $desicion_jurado=$reg_al->decision;
        $director_general=$datos_alumno->nombre_director_general;
        $sexo_director_general=$datos_alumno->sexo_director_general;

        $pdf = new PDF($orientation = 'P', $unit = 'mm', $format = 'Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(45, 15, 10);
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0,0,0);

        $pdf->SetFillColor(166,166,166);
        $pdf->SetFont('Arial','B','12');
        $pdf->Ln(8);
        $pdf->Cell(150,5,utf8_decode("Acta No. ".$numero_acta),0,1,'R');
        $pdf->Ln(7);
        $pdf->Cell(150,5,utf8_decode("ACTA DE EXENCIÓN DE EXAMEN PROFESIONAL"),0,1,'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','10');
        $pdf->MultiCell(160,5,utf8_decode("En Valle de Bravo, Estado de México, siendo las ".$hora_conformidad." horas del día ".$dia_titulacion." del mes de ".$mes_titulacion." del año ".$year.", de conformidad con el Capitulo V Articulo 48 y 50 del Reglamento de Titulación Integral del Tecnológico de Estudios Superiores de Valle de Bravo, se reunieron en las Instalaciones del Tecnológico, los profesores que conforman el jurado siguiente:"));
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','10');
        $pdf->Cell(40,5,utf8_decode("Presidente:"),0,0,'R');
        $pdf->Cell(120,5,utf8_decode($nombre_presidente),0,1,'');
        $pdf->Cell(40,5,utf8_decode("Secretario:"),0,0,'R');
        $pdf->Cell(120,5,utf8_decode($nombre_secretario),0,1,'');
        $pdf->Cell(40,5,utf8_decode("Vocal:"),0,0,'R');
        $pdf->Cell(120,5,utf8_decode($nombre_vocal),0,1,'');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','10');
        $pdf->MultiCell(160,5,utf8_decode("Este jurado conformado para sancionar el acto de recepción profesional ".$argumento." C. ".$nombre_alumno." quien de acuerdo al Capitulo IV Artículo 12, del citado Reglamento, comparece para obtener el Titulo de ".$titulo_obtenido." por la opción de Titulación Integral ".$opcion_titulacion."."));
        $pdf->Ln(5);
        $pdf->MultiCell(160,5,utf8_decode("Tomando en cuenta la presentación realizada por el sustentante, el jurado procedió a su análisis, acto seguido, el jurado acordó APROBAR ".$desicion_jurado." al sustentante, por lo que a continuación procedió a TOMARLE LA PROTESTA."));
        $pdf->Ln(5);
        $pdf->MultiCell(160,5,utf8_decode("Siendo las ".$hora_levantamiento." horas del día ".$dia_titulacion." del mes de ".$mes_titulacion." del año ".$year." se concluyó con el levantamiento de la presente Acta, quedando asentada en el libro de actas de Titulación Profesional No. ".$numero_libro." foja ".$foja_acta_titulacion.", resguardado por el Departamento de Titulación del Tecnológico de Estudios Superiores de Valle de Bravo, misma que leída y aprobada, fue firmada por el jurado y por la C. Directora General del Tecnológico para los efectos legales procedentes."));
        $pdf->Ln(20);
        $pdf->Cell(50,5,utf8_decode("_________________________"),0,0,'');
        $pdf->Cell(5,5,utf8_decode(""),0,0,'');
        $pdf->Cell(50,5,utf8_decode("_________________________"),0,0,'');
        $pdf->Cell(5,5,utf8_decode(""),0,0,'');
        $pdf->Cell(50,5,utf8_decode("_________________________"),0,1,'');
        $y=$pdf->GetY();
        $x=$pdf->GetX();
        $pdf->SetXY($x,$y);
        $pdf->SetFont('Arial','','10');
        $pdf->MultiCell(50, 5, utf8_decode($nombre_presidente),0,'C');
        $y1=$pdf->GetY();
        $pdf->SetXY($x+55,$y);
        $pdf->MultiCell(50, 5, utf8_decode($nombre_secretario),0,'C');
        $y2=$pdf->GetY();
        $pdf->SetXY($x+110,$y);
        $pdf->MultiCell(50, 5, utf8_decode($nombre_vocal),0,'C');
        $pdf->SetFont('Arial','B','10');
        $y3=$pdf->GetY();

        $x1=$pdf->GetX();
        $pdf->SetXY($x1,$y1);
        $pdf->SetFont('Arial','B','10');
        $pdf->Cell(50,5,utf8_decode("Céd. Prof: ".$dato_presidente->cedula),0,1,'C');
        $pdf->Cell(50,5,utf8_decode("Presidente"),0,0,'C');
        $x2=$pdf->GetX();
        $pdf->SetXY($x2,$y2);
        $pdf->Cell(5,5,utf8_decode(""),0,0,'');
        $pdf->Cell(50,5,utf8_decode("Céd. Prof: ".$dato_secretario->cedula),0,1,'C');
        $pdf->Cell(55,5,utf8_decode(""),0,0,'');
        $pdf->Cell(50,5,utf8_decode("Secretario"),0,0,'C');
        $x3=$pdf->GetX();
        $pdf->SetXY($x3,$y3);
        $pdf->Cell(5,5,utf8_decode(""),0,0,'');
        $pdf->Cell(50,5,utf8_decode("Céd. Prof: ".$dato_vocal->cedula),0,1,'C');
        $pdf->Cell(110,5,utf8_decode(""),0,0,'');
        $pdf->Cell(50,5,utf8_decode("Vocal"),0,1,'C');


        $pdf->Ln(15);
        $pdf->Cell(40,5,utf8_decode(""),0,0,'');
        $pdf->Cell(80,5,utf8_decode(""),"B",1,'');
        $pdf->Cell(40,5,utf8_decode(""),0,0,'');
        $pdf->Cell(80,5,utf8_decode("$director_general"),0,1,'C');
        $pdf->Cell(40,5,utf8_decode(""),0,0,'');
        if($sexo_director_general == 'M'){
            $pdf->Cell(80,5,utf8_decode("Director General"),0,1,'C');
        }else{
            $pdf->Cell(80,5,utf8_decode("Directora General"),0,1,'C');
        }


        $pdf->Image('img/ovalo.gif',8,66,36,54);

        $pdf->Output();
        exit();
    }
}
