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
        $this->Image('img/logo3.PNG', 125, 10, 70);
        $this->Image('img/logos/ArmasBN.png',20,10,50);
        $this->Image('img/tutorias/tecnm.jpg',80,10,30);
        $this->Ln(10);
    }
    //PIE DE PAGINA
    function Footer()
    {

        $this->SetY(-35);
        $this->SetFont('Arial','',8);
        //$this->Image('img/sgc.PNG',40,240,20);
        $this->Image('img/pie/logos_iso.jpg',40,240,60);
       // $this->Image('img/tutorias/cir.jpg',90,240,20);
       // $this->Image('img/sga.PNG',65,240,20);
        $this->Cell(50);
        $this->Cell(145,-2,utf8_decode(''),0,0,'R');
        $this->Ln(3);
        $this->SetFont('Arial','B',8);
        $this->Cell(50);
        $this->Cell(140,-2,utf8_decode('SECRETARÍA DE EDUCACIÓN'),0,0,'R');
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(140,-2,utf8_decode('SUBSECRETARÍA DE EDUCACIÓN SUPERIOR Y NORMAL'),0,0,'R');
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(140,-2,utf8_decode('TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO'),0,0,'R');
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(140,-2,utf8_decode('DEPARTAMENTO DE TITULACIÓN'),0,0,'R');
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
        $this->Cell(165,4,utf8_decode('     Tels.:(726)26 6 52 00, 26 6 50 77,26 6 51 87 Ext 117      titulacion@vbravo.tecnm.mx'),0,0,'L',true);

        $this->Image('img/logos/Mesquina.jpg',0,240,40);
    }

}
class Ti_pdf_relacion_actasController extends Controller
{
    public function index($id_relacion_acta_titulacion){

        $consultar_reg=DB::selectOne("SELECT * FROM `ti_relacion_actas_titulacion` WHERE `id_relacion_acta_titulacion` =$id_relacion_acta_titulacion");
      $fecha=$consultar_reg->fecha;
      $numero_oficio=$consultar_reg->numero_oficio;
        $alumnos=DB::select("SELECT ti_reg_datos_alum.id_alumno, 
       ti_reg_datos_alum.no_cuenta, ti_fecha_jurado_alumn.fecha_titulacion, 
       ti_reg_datos_alum.nombre_al, ti_reg_datos_alum.apaterno, ti_reg_datos_alum.amaterno,
       gnral_carreras.nombre carrera,gnral_carreras.id_carrera, ti_datos_alumno_reg_dep.id_numero_titulo 
from ti_reg_datos_alum, ti_fecha_jurado_alumn, ti_datos_alumno_reg_dep, gnral_carreras 
WHERE ti_reg_datos_alum.id_alumno = ti_fecha_jurado_alumn.id_alumno 
  and ti_fecha_jurado_alumn.id_alumno = ti_datos_alumno_reg_dep.id_alumno 
  and ti_fecha_jurado_alumn.fecha_titulacion ='$fecha' and 
      ti_reg_datos_alum.id_carrera = gnral_carreras.id_carrera and
      ti_datos_alumno_reg_dep.id_autorizacion = 4  ");




        $dia_titulacion=  substr($fecha, 0, 2);
        $mes_titulacion=  substr($fecha, 3, 2);

        $year=  substr($fecha, 6, 4);
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
        $fecha_solicitada=$dia_titulacion." de ".$mes_titulacion." de ".$year;

        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');

        $pdf = new PDF($orientation = 'P', $unit = 'mm', $format = 'Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0,0,0);

        $pdf->SetFillColor(166,166,166);
        $pdf->SetFont('Arial','B','8');
        $pdf->Ln(5);
        $pdf->Cell(190,5,utf8_decode($etiqueta->descripcion),0,1,'C');
        $pdf->Ln(0);

        $pdf->SetFont('Arial','','10');
        $pdf->Cell(100,5,utf8_decode(""),0,0,'R');
        $pdf->Cell(70,5,utf8_decode("Valle de Bravo, México;"),0,1,'R');
        $pdf->Cell(100,5,utf8_decode(""),0,0,'R');
        $pdf->Cell(70,5,utf8_decode("a ".$fecha_solicitada),0,1,'R');
        $pdf->SetFont('Arial','B','10');
        $pdf->Cell(100,5,utf8_decode(""),0,0,'R');
        $pdf->Cell(70,5,utf8_decode("Oficio No. 210C1901020201L- ".$numero_oficio."/".$year),0,1,'R');

        $pdf->Ln(0);
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(10,5,utf8_decode(""),0,0,'C');
        $pdf->Cell(170,5,utf8_decode("L. C. MA. ESTHER RODRÍGUEZ GÓMEZ"),0,1,'');
        $pdf->Cell(10,5,utf8_decode(""),0,0,'C');
        $pdf->Cell(170,5,utf8_decode("DIRECTORA GENERAL DEL TECNOLOGICO"),0,1,'');
        $pdf->Cell(10,5,utf8_decode(""),0,0,'C');
        $pdf->Cell(170,5,utf8_decode("DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO"),0,1,'');
        $pdf->Cell(10,5,utf8_decode(""),0,0,'C');
        $pdf->Cell(170,5,utf8_decode("PRESENTE:"),0,1,'');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','11');
        $pdf->Cell(10,5,utf8_decode(""),0,0,'C');
        $pdf->MultiCell(160,5,utf8_decode("Se adjunta al presente la relación y las actas de titulación, elaboradas por el departamento de Titulación, revisadas por la Subdirección de Servicios Escolares y autorizadas por la Dirección Académica del Tecnológico de Estudios Superiores de Valle de Bravo, se envían a Usted para solicitar su firma en dicho documentos oficiales."));
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(170,5,utf8_decode("RELACIÓN DE ACTAS DE TITULACIÓN"),0,1,'C');
        $pdf->SetFont('Arial','B','8');
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(30,4,utf8_decode("NÚMERO CUENTA"),'LTR',0,'C',true);
        $pdf->Cell(50,4,utf8_decode("CARRERA"),'LTR',0,'C',true);
        $pdf->Cell(70,4,utf8_decode("NOMBRE DEL EGRESADO"),'LTR',0,'C',true);
        $pdf->Cell(35,4,utf8_decode("FECHA TIT"),'LTR',1,'C',true);
        $pdf->Cell(30,4,utf8_decode(""),'LBR',0,'C',true);
        $pdf->Cell(50,4,utf8_decode(""),'LBR',0,'C',true);
        $pdf->Cell(70,4,utf8_decode("TITULADO"),'LBR',0,'C',true);
        $pdf->Cell(35,4,utf8_decode(""),'LBR',1,'C',true);
        $pdf->SetFont('Arial','B','7');
        $pdf->SetTextColor(0,0,0);
        $contar_alumno=0;
        foreach ($alumnos as $alumno){
            $contar_alumno++;
            if($alumno->id_carrera == 2){
                $pdf->Cell(30,4,utf8_decode($alumno->no_cuenta),'LTR',0,'');
                $pdf->Cell(50,4,utf8_decode("INGENIERIA EN SISTEMAS"),'LTR',0,'C');
                $pdf->Cell(70,4,utf8_decode($alumno->nombre_al." ".$alumno->apaterno." ".$alumno->amaterno),'LTR',0,'');
                $pdf->Cell(35,4,utf8_decode($fecha_solicitada),'LTR',1,'');
                $pdf->Cell(30,4,utf8_decode(""),'LBR',0,'');
                $pdf->Cell(50,4,utf8_decode("COMPUTACIONALES"),'LBR',0,'C');
                $pdf->Cell(70,4,utf8_decode(""),'LBR',0,'');
                $pdf->Cell(35,4,utf8_decode(""),'LBR',1,'');
            }else{
                $pdf->Cell(30,4,utf8_decode($alumno->no_cuenta),'LTR',0,'');
                $pdf->Cell(50,4,utf8_decode($alumno->carrera),'LTR',0,'C');
                $pdf->Cell(70,4,utf8_decode($alumno->nombre_al." ".$alumno->apaterno." ".$alumno->amaterno),'LTR',0,'');
                $pdf->Cell(35,4,utf8_decode($fecha_solicitada),'LTR',1,'');
                $pdf->Cell(30,4,utf8_decode(""),'LBR',0,'');
                $pdf->Cell(50,4,utf8_decode(""),'LBR',0,'C');
                $pdf->Cell(70,4,utf8_decode(""),'LBR',0,'');
                $pdf->Cell(35,4,utf8_decode(""),'LBR',1,'');
            }



        }
        $pdf->Cell(30,4,utf8_decode(""),1,0,'');
        $pdf->Cell(50,4,utf8_decode($contar_alumno),1,0,'C');
        $pdf->Cell(70,4,utf8_decode($contar_alumno),1,0,'C');
        $pdf->Cell(35,4,utf8_decode(""),1,1,'');

        $pdf->SetFont('Arial','','11');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(170,4,utf8_decode("Sin otro particular por el momento, quedamos de Usted."),0,1,'');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','11');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(170,4,utf8_decode("ATENTAMENTE"),0,1,'C');
        $pdf->Ln(5);
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("L. A. Tania Sarahi Garcia Benitez"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("L. C. Rómulo Esquivel Reyes"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("Dr. Lázaro Abner Hernández"),0,1,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode(""),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode(""),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("Reyes"),0,1,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("Jefa del Departamento de"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("Subdirector de Servicios"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode(""),0,1,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("Titulación"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("Escolares"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("Director Académico"),0,1,'C');
        $pdf->Ln(5);
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("ELABORÓ"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("REVISÓ"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("AUTORIZÓ"),0,1,'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','8');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(10,4,utf8_decode("C.C.P.- Dr. Lázaro Abner Hernández Reyes-Director Académico."),0,1,'');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(10,4,utf8_decode("C.C.P.- L.C. Rómulo Esquivel Reyes-Subdirector de Servicios Escolares."),0,1,'');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(10,4,utf8_decode("C.C.P.- Archivo"),0,1,'');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(10,4,utf8_decode("TSGB"),0,1,'');
        $modo="I";
        $nom="Relacion_actas_titulacion_".$fecha.".pdf";

        $pdf->Output($nom,$modo);
        exit();
    }
    public function pdf_relacion_titulos($id_relacion_titulo){
        $consultar_reg=DB::selectOne("SELECT * FROM `ti_relacion_titulos` WHERE `id_relacion_titulo` = $id_relacion_titulo");
        $fecha=$consultar_reg->fecha;
        $numero_oficio=$consultar_reg->numero_oficio;
        $alumnos=DB::select("SELECT ti_reg_datos_alum.id_alumno, 
       ti_reg_datos_alum.no_cuenta, ti_fecha_jurado_alumn.fecha_titulacion, 
       ti_reg_datos_alum.nombre_al, ti_reg_datos_alum.apaterno, ti_reg_datos_alum.amaterno,
       gnral_carreras.nombre carrera,gnral_carreras.id_carrera, ti_datos_alumno_reg_dep.id_numero_titulo,
       ti_numeros_titulos.abreviatura_folio_titulo
from ti_reg_datos_alum, ti_fecha_jurado_alumn, ti_datos_alumno_reg_dep, gnral_carreras,
ti_numeros_titulos
WHERE ti_reg_datos_alum.id_alumno = ti_fecha_jurado_alumn.id_alumno 
  and ti_fecha_jurado_alumn.id_alumno = ti_datos_alumno_reg_dep.id_alumno 
  and ti_fecha_jurado_alumn.fecha_titulacion ='$fecha' and 
      ti_reg_datos_alum.id_carrera = gnral_carreras.id_carrera and
      ti_datos_alumno_reg_dep.id_autorizacion = 4 and 
      ti_numeros_titulos.id_numero_titulo = ti_datos_alumno_reg_dep.id_numero_titulo ");




        $dia_titulacion=  substr($fecha, 0, 2);
        $mes_titulacion=  substr($fecha, 3, 2);

        $year=  substr($fecha, 6, 4);
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
        $fecha_solicitada=$dia_titulacion." de ".$mes_titulacion." de ".$year;

        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');

        $pdf = new PDF($orientation = 'P', $unit = 'mm', $format = 'Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0,0,0);

        $pdf->SetFillColor(166,166,166);
        $pdf->SetFont('Arial','B','8');
        $pdf->Ln(5);
        $pdf->Cell(190,5,utf8_decode($etiqueta->descripcion),0,1,'C');
        $pdf->Ln(0);

        $pdf->SetFont('Arial','','10');
        $pdf->Cell(100,5,utf8_decode(""),0,0,'R');
        $pdf->Cell(70,5,utf8_decode("Valle de Bravo, México;"),0,1,'R');
        $pdf->Cell(100,5,utf8_decode(""),0,0,'R');
        $pdf->Cell(70,5,utf8_decode("a ".$fecha_solicitada),0,1,'R');
        $pdf->SetFont('Arial','B','10');
        $pdf->Cell(100,5,utf8_decode(""),0,0,'R');
        $pdf->Cell(70,5,utf8_decode("Oficio No. 210C1901020201L-".$numero_oficio."/".$year),0,1,'R');

        $pdf->Ln(0);
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(170,5,utf8_decode("L. C. MA. ESTHER RODRÍGUEZ GÓMEZ"),0,1,'');
        $pdf->Cell(170,5,utf8_decode("DIRECTORA GENERAL DEL TECNOLOGICO"),0,1,'');
        $pdf->Cell(170,5,utf8_decode("DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO"),0,1,'');
        $pdf->Cell(170,5,utf8_decode("PRESENTE:"),0,1,'');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','11');
        $pdf->MultiCell(190,5,utf8_decode("Se adjunta al presente la relación y títulos profesionales de las diferentes carreras, los que fueron expedidos por la Subdirección de Servicios Escolares a través de su Departamento de Titulación, una vez que para su expedición se cumplierón todo los requisitos académicos y administrativos establecidos por la Normatividad del TESVB. Lo anterior para solicitar la firma de dichos documentos."));
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(190,5,utf8_decode("RELACIÓN DE TÍTULOS"),0,1,'C');
        $pdf->SetFont('Arial','B','8');
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(50,4,utf8_decode("CARRERA"),1,0,'C',true);
        $pdf->Cell(70,4,utf8_decode("NOMBRE DEL EGRESADO TITULADO"),1,0,'C',true);
        $pdf->Cell(35,4,utf8_decode("FOLIO DEL TÍTULO"),1,0,'C',true);
        $pdf->Cell(35,4,utf8_decode("FECHA TIT"),1,1,'C',true);
        $pdf->SetFont('Arial','B','7');
        $pdf->SetTextColor(0,0,0);
        $contar_alumno=0;
        foreach ($alumnos as $alumno){
            $contar_alumno++;
            if($alumno->id_carrera == 2){
                $pdf->Cell(50,4,utf8_decode("INGENIERIA EN SISTEMAS"),'LTR',0,'C');
                $pdf->Cell(70,4,utf8_decode($alumno->nombre_al." ".$alumno->apaterno." ".$alumno->amaterno),'LTR',0,'');
                $pdf->Cell(35,4,utf8_decode($alumno->abreviatura_folio_titulo),'LTR',0,'');
                $pdf->Cell(35,4,utf8_decode($fecha_solicitada),'LTR',1,'');

                $pdf->Cell(50,4,utf8_decode("COMPUTACIONALES"),'LBR',0,'C');
                $pdf->Cell(70,4,utf8_decode(""),'LBR',0,'');
                $pdf->Cell(35,4,utf8_decode(""),'LBR',0,'');
                $pdf->Cell(35,4,utf8_decode(""),'LBR',1,'');
            }else{
                $pdf->Cell(50,4,utf8_decode($alumno->carrera),'LTR',0,'C');
                $pdf->Cell(70,4,utf8_decode($alumno->nombre_al." ".$alumno->apaterno." ".$alumno->amaterno),'LTR',0,'');
                $pdf->Cell(35,4,utf8_decode($alumno->abreviatura_folio_titulo),'LTR',0,'');
                $pdf->Cell(35,4,utf8_decode($fecha_solicitada),'LTR',1,'');
                $pdf->Cell(50,4,utf8_decode(""),'LBR',0,'C');
                $pdf->Cell(70,4,utf8_decode(""),'LBR',0,'');
                $pdf->Cell(35,4,utf8_decode(""),'LBR',0,'');
                $pdf->Cell(35,4,utf8_decode(""),'LBR',1,'');
            }



        }
        $pdf->Cell(50,4,utf8_decode($contar_alumno),1,0,'C');
        $pdf->Cell(70,4,utf8_decode($contar_alumno),1,0,'C');
        $pdf->Cell(35,4,utf8_decode(""),1,0,'');
        $pdf->Cell(35,4,utf8_decode(""),1,1,'');

        $pdf->SetFont('Arial','','11');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(170,4,utf8_decode("Sin otro particular por el momento, quedamos de Usted."),0,1,'');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','11');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(170,4,utf8_decode("ATENTAMENTE"),0,1,'C');
        $pdf->Ln(10);
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("L. A. Tania Sarahi Garcia Benitez"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("L. C. Rómulo Esquivel Reyes"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("Dr. Lázaro Abner Hernández"),0,1,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode(""),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode(""),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("Reyes"),0,1,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("Jefa del Departamento de"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("Subdirector de Servicios"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode(""),0,1,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("Titulación"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("Escolares"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("Director Académico"),0,1,'C');
        $pdf->Ln(5);
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("ELABORÓ"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("REVISÓ"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("AUTORIZÓ"),0,1,'C');
        $pdf->Ln(2);
        $pdf->SetFont('Arial','','8');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(10,4,utf8_decode("C.C.P.- Dr. Lázaro Abner Hernández Reyes-Director Académico."),0,1,'');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(10,4,utf8_decode("C.C.P.- L.C. Rómulo Esquivel Reyes-Subdirector de Servicios Escolares."),0,1,'');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(10,4,utf8_decode("C.C.P.- Archivo"),0,1,'');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(10,4,utf8_decode("TSGB"),0,1,'');
        $modo="I";
        $nom="Relacion_actas_titulacion_".$fecha.".pdf";

        $pdf->Output($nom,$modo);
        exit();
    }
    public function relacion_pdf_mencion_honorifica($id_relacion_mencion_honorifica){
        $consultar_reg=DB::selectOne("SELECT * FROM `ti_relacion_mencion_honorifica` WHERE `id_relacion_mencion_honorifica` =  '$id_relacion_mencion_honorifica'");
        $fecha=$consultar_reg->fecha;
        $numero_oficio=$consultar_reg->numero_oficio;
        $alumnos=DB::select("SELECT ti_reg_datos_alum.id_alumno, ti_reg_datos_alum.no_cuenta,
       ti_fecha_jurado_alumn.fecha_titulacion, ti_reg_datos_alum.nombre_al, ti_reg_datos_alum.apaterno,
       ti_reg_datos_alum.amaterno, gnral_carreras.nombre carrera, ti_datos_alumno_reg_dep.id_numero_titulo, 
       ti_mencion_honorifica.no_registro, ti_mencion_honorifica.libro_registro 
from ti_reg_datos_alum, ti_fecha_jurado_alumn, ti_datos_alumno_reg_dep, gnral_carreras, ti_mencion_honorifica
WHERE ti_reg_datos_alum.id_alumno = ti_fecha_jurado_alumn.id_alumno and
      ti_fecha_jurado_alumn.id_alumno = ti_datos_alumno_reg_dep.id_alumno and 
      ti_fecha_jurado_alumn.fecha_titulacion ='$fecha'
  and ti_reg_datos_alum.id_carrera = gnral_carreras.id_carrera 
  and ti_datos_alumno_reg_dep.id_autorizacion = 4 and 
      ti_reg_datos_alum.mencion_honorifica =1 and
      ti_mencion_honorifica.id_alumno = ti_reg_datos_alum.id_alumno  ");

        if($consultar_reg == null){
            $estado_reg=0;
        }else{
            $estado_reg=1;
        }

        $dia_titulacion=  substr($fecha, 0, 2);
        $mes_titulacion=  substr($fecha, 3, 2);

        $year=  substr($fecha, 6, 4);
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
        $fecha_solicitada=$dia_titulacion." de ".$mes_titulacion." de ".$year;

        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');

        $pdf = new PDF($orientation = 'P', $unit = 'mm', $format = 'Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0,0,0);

        $pdf->SetFillColor(166,166,166);
        $pdf->SetFont('Arial','B','8');
        $pdf->Ln(5);
        $pdf->Cell(190,5,utf8_decode($etiqueta->descripcion),0,1,'C');
        $pdf->Ln(0);

        $pdf->SetFont('Arial','','10');
        $pdf->Cell(100,5,utf8_decode(""),0,0,'R');
        $pdf->Cell(70,5,utf8_decode("Valle de Bravo, México;"),0,1,'R');
        $pdf->Cell(100,5,utf8_decode(""),0,0,'R');
        $pdf->Cell(70,5,utf8_decode("a ".$fecha_solicitada),0,1,'R');
        $pdf->SetFont('Arial','B','10');
        $pdf->Cell(100,5,utf8_decode(""),0,0,'R');
        $pdf->Cell(70,5,utf8_decode("Oficio No. 210C1901020201L-".$numero_oficio."/".$year),0,1,'R');

        $pdf->Ln(0);
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(170,5,utf8_decode("L. C. MA. ESTHER RODRÍGUEZ GÓMEZ"),0,1,'');
        $pdf->Cell(170,5,utf8_decode("DIRECTORA GENERAL DEL TECNOLOGICO"),0,1,'');
        $pdf->Cell(170,5,utf8_decode("DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO"),0,1,'');
        $pdf->Cell(170,5,utf8_decode("PRESENTE:"),0,1,'');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','11');
        $pdf->MultiCell(190,5,utf8_decode("Se adjunta al presente la relación y las menciones honoríficas, elaboradas por el departamento de Titulación, revisadas por la Subdirección de Servicios Escolares y autorizadas por la Dirección Académica del Tecnológico de Estudios Superiores de Valle de Bravo, se envían a Usted para solicitar su firma en dichos documentos oficiales."));
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(190,5,utf8_decode("RELACIÓN DE MENCIÓN HONORÍFICA"),0,1,'C');
        $pdf->SetFont('Arial','B','11');
        $pdf->SetTextColor(255,255,255);
        $x=$pdf->GetX();
        $y=$pdf->GetY();
        $pdf->MultiCell(70,9,utf8_decode("NOMBRE DEL EGRESADO TITULADO"),1,'C',true);
        $pdf->SetXY(85,$y);
        $pdf->Cell(35,18,utf8_decode("FECHA TIT"),1,0,'C',true);
        $pdf->SetXY(120,$y);
        $pdf->MultiCell(50,9,utf8_decode("NO. DE REGISTRO DE MENCIÓN HONORIFICA"),1,'C',true);
        $pdf->SetXY(170,$y);
        $pdf->MultiCell(35,6,utf8_decode("LIBRO DE REG. MENCIÓN HONORIFICA"),1,'C',true);
        $pdf->SetFont('Arial','B','8');
        $pdf->SetTextColor(0,0,0);


        $ano1=date("Y", strtotime($fecha_solicitada ));
        $contar_alumno=0;
        foreach ($alumnos as $alumno){
            $contar_alumno++;

                $pdf->Cell(70,5,utf8_decode($alumno->nombre_al." ".$alumno->apaterno." ".$alumno->amaterno),1,0,'');
                $pdf->Cell(35,5,utf8_decode($fecha_solicitada),1,0,'');
                $pdf->Cell(50,5,utf8_decode("MH-".$alumno->no_registro."-".$year."-TESVB"),1,0,'');
                $pdf->Cell(35,5,utf8_decode($alumno->libro_registro),1,1,'');

        }
        $pdf->Cell(70,5,utf8_decode($contar_alumno),1,0,'R');
        $pdf->Cell(35,5,utf8_decode(""),1,0,'');
        $pdf->Cell(50,5,utf8_decode($contar_alumno),1,0,'R');
        $pdf->Cell(35,5,utf8_decode(""),1,1,'');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','11');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(170,4,utf8_decode("Sin otro particular por el momento, quedamos de Usted."),0,1,'');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','11');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(170,4,utf8_decode("ATENTAMENTE"),0,1,'C');
        $pdf->Ln(10);
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("L. A. Tania Sarahi Garcia Benitez"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("L. C. Rómulo Esquivel Reyes"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("Dr. Lázaro Abner Hernández"),0,1,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode(""),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode(""),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("Reyes"),0,1,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("Jefa del Departamento de"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("Subdirector de Servicios"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode(""),0,1,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("Titulación"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("Escolares"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("Director Académico"),0,1,'C');
        $pdf->Ln(5);
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("ELABORÓ"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("REVISÓ"),0,0,'C');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(50,4,utf8_decode("AUTORIZÓ"),0,1,'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','8');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(10,4,utf8_decode("C.C.P.- Dr. Lázaro Abner Hernández Reyes-Director Académico."),0,1,'');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(10,4,utf8_decode("C.C.P.- L.C. Rómulo Esquivel Reyes-Subdirector de Servicios Escolares."),0,1,'');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(10,4,utf8_decode("C.C.P.- Archivo"),0,1,'');
        $pdf->Cell(10,4,utf8_decode(""),0,0,'');
        $pdf->Cell(10,4,utf8_decode("TSGB"),0,1,'');

        $modo="I";
        $nom="Relacion_mencion_honorifica_".$fecha.".pdf";

        $pdf->Output($nom,$modo);
        exit();
    }
}
