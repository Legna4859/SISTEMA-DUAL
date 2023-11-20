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

            $this->Image('img/logo3.PNG', 145, 5, 60);
            $this->Image('img/residencia/log_estado.jpg', 10, 5, 30);
            $this->SetTextColor(0, 0, 0);
            $this->SetFont('Arial', 'B', '7');
            $this->Cell(190, 3, utf8_decode('RESIDENCIA PROFESIONAL'), 0, 1, 'C');
            $this->Cell(190, 3, utf8_decode('FORMATO DE SEGUIMIENTO'), 0, 0, 'C');
            $this->SetDrawColor(0, 0, 0);
            $this->Line(10, 27, 205, 27);
            $this->Ln(8);


    }
    //PIE DE PAGINA
    function Footer()
    {
        $this->SetY(-40);


        $this->Image('img/pie/logos_iso.jpg', 40, 255, 40);
        // $this->Image('img/sgc.PNG',40,240,20);
        // $this->Image('img/tutorias/cir.jpg',89,239,20);
        //  $this->Image('img/sga.PNG',65,240,20);
        $this->SetFont('Arial', 'B', 7);
        $this->Ln(18);
        $this->Cell(50);
        $this->Cell(145, -2, utf8_decode('FO-TESVB-91 V.0 23/03/2018'), 0, 0, 'R');
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(145, -2, utf8_decode('SECRETARÍA DE EDUCACIÓN'), 0, 0, 'R');
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(145, -2, utf8_decode('SUBSECRETARÍA DE EDUCACIÓN SUPERIOR Y NORMAL'), 0, 0, 'R');
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(145, -2, utf8_decode('TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO'), 0, 0, 'R');
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(145, -2, utf8_decode('DEPARTAMENTO DE SERVICIO SOCIAL Y RESIDENCIA PROFESIONAL'), 0, 0, 'R');
        $this->Cell(280);
        $this->Ln(0);
        $this->SetXY(38, 270);
        $this->SetFillColor(120, 120, 120);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(167, 4, utf8_decode('      Km. 30 de la Carretera Federal Monumento - Valle de Bravo, Ejido de San Antonio de la Laguna,'), 0, 0, 'L', TRUE);
        $this->Ln(3);
        $this->Cell(28);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(167, 4, utf8_decode('      Valle de Bravo, Estado de México, C.P. 51200.'), 0, 0, 'L', TRUE);
        $this->Ln(3);
        $this->Cell(28);
        $this->SetFont('Arial', '', 8);
        $this->Cell(167, 3, utf8_decode('     Tels.:(726)26 6 52 00, 26 6 51 87 EXT. 144      servicio.social@vbravo.tecnm.mx'), 0, 0, 'L', true);

        $this->Image('img/logos/Mesquina.jpg', 4, 251, 35);
    }
}
class Resi_pdf_reportes_residenciaController extends Controller
{
    public function index($id_anteproyecto,$numero){
        $datos=DB::selectOne('SELECT gnral_carreras.nombre carrera,gnral_alumnos.nombre,gnral_alumnos.apaterno,
gnral_alumnos.amaterno,resi_proyecto.nom_proyecto, resi_empresa.nombre empresa from gnral_carreras,gnral_alumnos,
resi_anteproyecto,resi_proy_empresa,resi_empresa,resi_proyecto where gnral_carreras.id_carrera=gnral_alumnos.id_carrera 
and gnral_alumnos.id_alumno=resi_anteproyecto.id_alumno and resi_anteproyecto.id_anteproyecto=resi_proy_empresa.id_anteproyecto 
and resi_proy_empresa.id_empresa=resi_empresa.id_empresa
 and resi_anteproyecto.id_anteproyecto='.$id_anteproyecto.' and resi_anteproyecto.id_proyecto=resi_proyecto.id_proyecto');
      $carrera=mb_strtoupper ($datos->carrera);
      $nombre=mb_strtoupper ($datos->nombre.' '.$datos->apaterno.' '.$datos->amaterno);
      $nombre_proyecto=$datos->nom_proyecto;
      $nombre_proyecto=mb_eregi_replace("[\n|\r|\n\r]",'',$nombre_proyecto);
      $nombre_proyecto = mb_strtoupper ($nombre_proyecto);
      $empresa=mb_strtoupper($datos->empresa);
      $empresa=mb_eregi_replace("[\n|\r|\n\r]",'',$empresa);

      $nombre_asesor=DB::selectOne('SELECT abreviaciones.titulo,gnral_personales.nombre  
FROM resi_asesores,gnral_personales,abreviaciones_prof,abreviaciones WHERE 
resi_asesores.id_profesor =gnral_personales.id_personal and abreviaciones_prof.id_personal=gnral_personales.id_personal and
 abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and resi_asesores.id_anteproyecto='.$id_anteproyecto.'');
     $nombre_asesor=mb_strtoupper ($nombre_asesor->titulo.' '.$nombre_asesor->nombre);
$fechas=DB::selectOne('SELECT MIN(resi_cronograma.f_inicio) fecha_inicial,max(resi_cronograma.f_termino) fecha_final 
FROM `resi_cronograma` WHERE `id_anteproyecto` = '.$id_anteproyecto.' ORDER BY `resi_cronograma`.`f_inicio` DESC');
$fecha_inicial= date("d-m-Y",strtotime($fechas->fecha_inicial));
    $fecha_final= date("d-m-Y",strtotime($fechas->fecha_final));
        $pdf=new PDF($orientation='P',$unit='mm',$format='Letter');


        if($numero == 4)
        {
            $semana1=1;
            $semana2=2;
            $semana3=3;
            $semana4=4;

        }
        if($numero== 8){
            $semana1=5;
            $semana2=6;
            $semana3=7;
            $semana4=8;
        }
        if($numero== 12){
            $semana1=9;
            $semana2=10;
            $semana3=11;
            $semana4=12;
        }
        if($numero== 16){
            $semana1=13;
            $semana2=14;
            $semana3=15;
            $semana4=16;
        }

        $cronograma=DB::selectOne('SELECT * FROM `resi_cronograma` WHERE `no_semana` = '.$semana1.' AND `id_anteproyecto` = '.$id_anteproyecto.' ORDER BY `no_semana` ASC');
        $fecha1=date("d-m-Y",strtotime($cronograma->f_inicio));
        $fecha2=date("d-m-Y",strtotime($cronograma->f_termino));
        $actividad=mb_eregi_replace("[\n|\r|\n\r]",'',$cronograma->actividad);
        $comentarios=DB::selectOne('SELECT * FROM `resi_promedio_rubros` WHERE `id_semana` = '.$semana1.' AND `id_anteproyecto` ='.$id_anteproyecto.'');
        $observaciones=$comentarios->observaciones;
        $observaciones=mb_eregi_replace("[\n|\r|\n\r]",'',$observaciones);
        $pendientes=$comentarios->pendientes;
        $pendientes=mb_eregi_replace("[\n|\r|\n\r]",'',$pendientes);
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(10, 20 , 10);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetLineWidth(0.2);
        $pdf->SetFont('Arial','',7);
        $pdf->SetTextColor(1,1,1);
        $pdf->Ln(1);
        $pdf->Cell(195,4,utf8_decode("CARRERA: ".$carrera),1,1,'L',FALSE);
        $pdf->Cell(43,4,"NOMBRE DEL ASESOR ",1,0,'L',FALSE);
        $pdf->Cell(23,4,"INTERNO ",1,0,'L',FALSE);
        $pdf->Cell(5,4,"X",1,0,'C',FALSE);
        $pdf->Cell(23,4,"EXTERNO ",1,0,'L',FALSE);
        $pdf->Cell(5,4," ",1,0,'C',FALSE);
        $pdf->Cell(96,4,utf8_decode($nombre_asesor),1,1,'L',FALSE);
        $pdf->Cell(195,4,utf8_decode("NOMBRE DEL ESTUDIANTE: ".$nombre),1,1,'L',FALSE);
        $pdf->MultiCell(195,4,utf8_decode("NOMBRE DEL PROYECTO: ".$nombre_proyecto),1);
        $pdf->MultiCell(195,4,utf8_decode("NOMBRE DE LA EMPRESA: ".$empresa),1);
        $pdf->Cell(97,4,"FECHA INICIO: ".$fecha_inicial,1,0,'L',FALSE);
        $pdf->Cell(98,4,"FECHA TERMINO: ".$fecha_final,1,1,'L',FALSE);
        $pdf->Cell(195,4," ",1,1,'L',FALSE);
        $pdf->SetY(64);
        $pdf->Cell(16,4,"SEMANA",1,0,'C',FALSE);
        $pdf->Cell(45,4,"PUNTO EVALUAR",1,0,'C',FALSE);
        $pdf->Cell(54,4,"AVANCES DEL PROYECTO",1,0,'C',FALSE);
        $pdf->Cell(40,4,"OBSERVACIONES",1,0,'C',FALSE);
        $pdf->Cell(40,4,"PENDIENTES",1,1,'C',FALSE);
        $pdf->SetY(68); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,35,'','LR',0,'C');
        $pdf->SetY(100); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,5,$semana1,'LR',0,'C');
        $pdf->SetY(103); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,5,$fecha1,'LR',0,'C');
        $pdf->SetY(108); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,5,'a','LR',0,'C');
        $pdf->SetY(113); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,5,$fecha2,'LR',0,'C');
        $pdf->SetY(108); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,35,'','LBR',0,'C');
        $pdf->SetXY(26, 68); /* Set 20 Eje Y */
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(35,13,'Actitud',1,0,'C');
        $pdf->SetXY(26, 81); /* Set 20 Eje Y */
        $pdf->Cell(35,14,'Responsabilidad',1,1,'C');
        $pdf->SetXY(26, 95);
        $pdf->Cell(35,5,'Capacidad de solucionar','LTR',0,'C');
        $pdf->SetXY(26, 100);
        $pdf->Cell(35,5,'problemas','LR',0,'C');
        $pdf->SetXY(26, 105);
        $pdf->Cell(35,6,'','LBR',0,'C');
        $pdf->SetXY(26, 111);
        $pdf->Cell(35,5,utf8_decode('Aplicación de los'),'LTR',0,'C');
        $pdf->SetXY(26, 116);
        $pdf->Cell(35,5,utf8_decode('conocimientos teóricos'),'LR',0,'C');
        $pdf->SetXY(26, 121);
        $pdf->Cell(35,5,utf8_decode('en la practica'),'LR',0,'C');
        $pdf->SetXY(26, 126);
        $pdf->Cell(35,1,'','LBR',0,'C');
        $pdf->SetXY(26, 127);
        $pdf->Cell(35,5,utf8_decode('Calidad del contenido'),'LTR',0,'C');
        $pdf->SetXY(26, 132);
        $pdf->Cell(35,5,utf8_decode('de los avances del'),'LR',0,'C');
        $pdf->SetXY(26, 137);
        $pdf->Cell(35,5,utf8_decode('informe'),'LR',0,'C');

        $rubro_actitud=DB::selectOne('SELECT * FROM `resi_rubro_actitud` WHERE `id_anteproyecto` = '.$id_anteproyecto.' AND `semana` = '.$semana1.'');
        $rubro_actitud=$rubro_actitud->calificacion;
        if($rubro_actitud < 70)
        {
            $rubro_actitud="N.A.";
        }
        else{
            $rubro_actitud=$rubro_actitud;
        }
        $rubro_aplicacion=DB::selectOne('SELECT * FROM `resi_rubro_aplicacion` WHERE `id_anteproyecto` = '.$id_anteproyecto.' AND `semana` = '.$semana1.'');
        $rubro_aplicacion=$rubro_aplicacion->calificacion;
        if($rubro_aplicacion < 70)
        {
            $rubro_aplicacion="N.A.";
        }
        else{
            $rubro_aplicacion=$rubro_aplicacion;
        }
        $rubro_calidad=DB::selectOne('SELECT * FROM `resi_rubro_calidad` WHERE `id_anteproyecto` = '.$id_anteproyecto.' AND `semana` = '.$semana1.'');
        $rubro_calidad=$rubro_calidad->calificacion;
        if($rubro_calidad < 70)
        {
            $rubro_calidad="N.A.";
        }
        else{
            $rubro_calidad=$rubro_calidad;
        }
        $rubro_capacidad=DB::selectOne('SELECT * FROM `resi_rubro_capacidad` WHERE `id_anteproyecto` = '.$id_anteproyecto.' AND `semana` = '.$semana1.'');
        $rubro_capacidad=$rubro_capacidad->calificacion;
        if($rubro_capacidad < 70)
        {
            $rubro_capacidad="N.A.";
        }
        else{
            $rubro_capacidad=$rubro_capacidad;
        }
        $rubro_responsabilidad=DB::selectOne('SELECT * FROM `resi_rubro_responsabilidad` WHERE `id_anteproyecto` = '.$id_anteproyecto.' AND `semana` = '.$semana1.'');
        $rubro_responsabilidad=$rubro_responsabilidad->calificacion;
        if($rubro_responsabilidad < 70)
        {
            $rubro_responsabilidad="N.A.";
        }
        else{
            $rubro_responsabilidad=$rubro_responsabilidad;
        }



        $pdf->SetXY(26,142);
        $pdf->Cell(35,1,'','LBR',0,'C');
        $pdf->SetXY(61, 68);
        $pdf->Cell(10,13,$rubro_actitud,1,0,'C');
        $pdf->SetXY(61, 81);
        $pdf->Cell(10,14,$rubro_responsabilidad,1,0,'C');
        $pdf->SetXY(61, 95);
        $pdf->Cell(10,16,$rubro_capacidad,1,0,'C');
        $pdf->SetXY(61, 111);
        $pdf->Cell(10,16,$rubro_aplicacion,1,0,'C');
        $pdf->SetXY(61, 127);
        $pdf->Cell(10,16,$rubro_calidad,1,0,'C');
        $pdf->SetXY(71,68);
        $pdf->Cell(54,75,'',1,0,'C');
        $pdf->SetXY(71,68);
        $pdf->MultiCell(54,4,utf8_decode($actividad),0);
        $pdf->SetXY(125,68);
        $pdf->Cell(40,75,'',1,0,'C');
        $pdf->SetXY(125,68);
        $pdf->MultiCell(40,4,utf8_decode($observaciones),0);
        $pdf->SetXY(165,68);
        $pdf->Cell(40,75,'',1,0,'C');
        $pdf->SetXY(165,68);
        $pdf->MultiCell(40,4,utf8_decode($pendientes),0);

        $cronograma=DB::selectOne('SELECT * FROM `resi_cronograma` WHERE `no_semana` = '.$semana2.' AND `id_anteproyecto` = '.$id_anteproyecto.' ORDER BY `no_semana` ASC');
        $fecha1=date("d-m-Y",strtotime($cronograma->f_inicio));
        $fecha2=date("d-m-Y",strtotime($cronograma->f_termino));
        $actividad=mb_eregi_replace("[\n|\r|\n\r]",'',$cronograma->actividad);
        $comentarios=DB::selectOne('SELECT * FROM `resi_promedio_rubros` WHERE `id_semana` = '.$semana2.' AND `id_anteproyecto` ='.$id_anteproyecto.'');
        $observaciones=$comentarios->observaciones;
        $observaciones=mb_eregi_replace("[\n|\r|\n\r]",'',$observaciones);
        $pendientes=$comentarios->pendientes;
        $pendientes=mb_eregi_replace("[\n|\r|\n\r]",'',$pendientes);

        $pdf->SetY(146);
        $pdf->Cell(16,4,"SEMANA",1,0,'C',FALSE);
        $pdf->Cell(45,4,"PUNTO EVALUAR",1,0,'C',FALSE);
        $pdf->Cell(54,4,"AVANCES DEL PROYECTO",1,0,'C',FALSE);
        $pdf->Cell(40,4,"OBSERVACIONES",1,0,'C',FALSE);
        $pdf->Cell(40,4,"PENDIENTES",1,1,'C',FALSE);
        $pdf->SetY(150); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,35,'','LR',0,'C');
        $pdf->SetY(185); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,5,$semana2,'LR',0,'C');
        $pdf->SetY(190); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,5,$fecha1,'LR',0,'C');
        $pdf->SetY(195); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,5,'a','LR',0,'C');
        $pdf->SetY(200); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,5,$fecha2,'LR',0,'C');
        $pdf->SetY(195); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,35,'','LBR',0,'C');
        $pdf->SetXY(26, 150); /* Set 20 Eje Y */
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(35,16,'Actitud',1,0,'C');
        $pdf->SetXY(26, 166); /* Set 20 Eje Y */
        $pdf->Cell(35,16,'Responsabilidad',1,1,'C');
        $pdf->SetXY(26, 182);
        $pdf->Cell(35,5,'Capacidad de solucionar','LTR',0,'C');
        $pdf->SetXY(26,187);
        $pdf->Cell(35,5,'problemas','LR',0,'C');
        $pdf->SetXY(26,192);
        $pdf->Cell(35,6,'','LBR',0,'C');
        $pdf->SetXY(26, 198);
        $pdf->Cell(35,5,utf8_decode('Aplicación de los'),'LTR',0,'C');
        $pdf->SetXY(26, 203);
        $pdf->Cell(35,5,utf8_decode('conocimientos teóricos'),'LR',0,'C');
        $pdf->SetXY(26, 208);
        $pdf->Cell(35,5,utf8_decode('en la practica'),'LR',0,'C');
        $pdf->SetXY(26, 213);
        $pdf->Cell(35,1,'','LBR',0,'C');
        $pdf->SetXY(26, 214);
        $pdf->Cell(35,5,utf8_decode('Calidad del contenido'),'LTR',0,'C');
        $pdf->SetXY(26, 219);
        $pdf->Cell(35,5,utf8_decode('de los avances del'),'LR',0,'C');
        $pdf->SetXY(26, 224);
        $pdf->Cell(35,5,utf8_decode('informe'),'LR',0,'C');
        $pdf->SetXY(26,229);
        $pdf->Cell(35,1,'','LBR',0,'C');

        $rubro_actitud=DB::selectOne('SELECT * FROM `resi_rubro_actitud` WHERE `id_anteproyecto` = '.$id_anteproyecto.' AND `semana` = '.$semana2.'');
        $rubro_actitud=$rubro_actitud->calificacion;
        if($rubro_actitud < 70)
        {
            $rubro_actitud="N.A.";
        }
        else{
            $rubro_actitud=$rubro_actitud;
        }
        $rubro_aplicacion=DB::selectOne('SELECT * FROM `resi_rubro_aplicacion` WHERE `id_anteproyecto` = '.$id_anteproyecto.' AND `semana` = '.$semana2.'');
        $rubro_aplicacion=$rubro_aplicacion->calificacion;
        if($rubro_aplicacion < 70)
        {
            $rubro_aplicacion="N.A.";
        }
        else{
            $rubro_aplicacion=$rubro_aplicacion;
        }
        $rubro_calidad=DB::selectOne('SELECT * FROM `resi_rubro_calidad` WHERE `id_anteproyecto` = '.$id_anteproyecto.' AND `semana` = '.$semana2.'');
        $rubro_calidad=$rubro_calidad->calificacion;
        if($rubro_calidad < 70)
        {
            $rubro_calidad="N.A.";
        }
        else{
            $rubro_calidad=$rubro_calidad;
        }
        $rubro_capacidad=DB::selectOne('SELECT * FROM `resi_rubro_capacidad` WHERE `id_anteproyecto` = '.$id_anteproyecto.' AND `semana` = '.$semana2.'');
        $rubro_capacidad=$rubro_capacidad->calificacion;
        if($rubro_capacidad < 70)
        {
            $rubro_capacidad="N.A.";
        }
        else{
            $rubro_capacidad=$rubro_capacidad;
        }
        $rubro_responsabilidad=DB::selectOne('SELECT * FROM `resi_rubro_responsabilidad` WHERE `id_anteproyecto` = '.$id_anteproyecto.' AND `semana` = '.$semana2.'');
        $rubro_responsabilidad=$rubro_responsabilidad->calificacion;
        if($rubro_responsabilidad < 70)
        {
            $rubro_responsabilidad="N.A.";
        }
        else{
            $rubro_responsabilidad=$rubro_responsabilidad;
        }
        $pdf->SetXY(61, 150);
        $pdf->Cell(10,16,$rubro_actitud,1,0,'C');
        $pdf->SetXY(61, 166);
        $pdf->Cell(10,16,$rubro_responsabilidad,1,0,'C');
        $pdf->SetXY(61, 182);
        $pdf->Cell(10,16,$rubro_capacidad,1,0,'C');
        $pdf->SetXY(61, 198);
        $pdf->Cell(10,16, $rubro_aplicacion,1,0,'C');
        $pdf->SetXY(61, 214);
        $pdf->Cell(10,16,$rubro_calidad,1,0,'C');
        $pdf->SetXY(71,150);
        $pdf->Cell(54,80,'',1,0,'C');
        $pdf->SetXY(71,150);
        $pdf->MultiCell(54,4,utf8_decode($actividad),0);
        $pdf->SetXY(125,150);
        $pdf->Cell(40,80,'',1,0,'C');
        $pdf->SetXY(125,150);
        $pdf->MultiCell(40,4,utf8_decode($observaciones),0);
        $pdf->SetXY(165,150);
        $pdf->Cell(40,80,'',1,0,'C');
        $pdf->SetXY(165,150);
        $pdf->MultiCell(40,4,utf8_decode($pendientes),0);
       // $pdf->Image('img/residencia/FAI.jpg', 40,231, 35);
        //$pdf->Image('img/residencia/asesor.JPG', 130,231, 35);


        $pdf->AddPage();
        $cronograma=DB::selectOne('SELECT * FROM `resi_cronograma` WHERE `no_semana` = '.$semana3.' AND `id_anteproyecto` = '.$id_anteproyecto.' ORDER BY `no_semana` ASC');
        $fecha1=date("d-m-Y",strtotime($cronograma->f_inicio));
        $fecha2=date("d-m-Y",strtotime($cronograma->f_termino));
        $actividad=mb_eregi_replace("[\n|\r|\n\r]",'',$cronograma->actividad);
        $comentarios=DB::selectOne('SELECT * FROM `resi_promedio_rubros` WHERE `id_semana` = '.$semana3.' AND `id_anteproyecto` ='.$id_anteproyecto.'');
        $observaciones=$comentarios->observaciones;
        $observaciones=mb_eregi_replace("[\n|\r|\n\r]",'',$observaciones);
        $pendientes=$comentarios->pendientes;
        $pendientes=mb_eregi_replace("[\n|\r|\n\r]",'',$pendientes);
        $pdf->SetFont('Arial','',7);
        $pdf->SetTextColor(1,1,1);
        $pdf->Ln(1);
        $pdf->Cell(195,4,utf8_decode("CARRERA: ".$carrera),1,1,'L',FALSE);
        $pdf->Cell(43,4,"NOMBRE DEL ASESOR ",1,0,'L',FALSE);
        $pdf->Cell(23,4,"INTERNO ",1,0,'L',FALSE);
        $pdf->Cell(5,4,"X",1,0,'C',FALSE);
        $pdf->Cell(23,4,"EXTERNO ",1,0,'L',FALSE);
        $pdf->Cell(5,4," ",1,0,'C',FALSE);
        $pdf->Cell(96,4,utf8_decode($nombre_asesor),1,1,'L',FALSE);
        $pdf->Cell(195,4,utf8_decode("NOMBRE DEL ESTUDIANTE: ".$nombre),1,1,'L',FALSE);
        $pdf->MultiCell(195,4,utf8_decode("NOMBRE DEL PROYECTO: ".$nombre_proyecto),1);
        $pdf->MultiCell(195,4,utf8_decode("NOMBRE DE LA EMPRESA: ".$empresa),1);
        $pdf->Cell(97,4,"FECHA INICIO: ".$fecha_inicial,1,0,'L',FALSE);
        $pdf->Cell(98,4,"FECHA TERMINO: ".$fecha_final,1,1,'L',FALSE);
        $pdf->Cell(195,4," ",1,1,'L',FALSE);
        $pdf->SetY(64);
        $pdf->Cell(16,4,"SEMANA",1,0,'C',FALSE);
        $pdf->Cell(45,4,"PUNTO EVALUAR",1,0,'C',FALSE);
        $pdf->Cell(54,4,"AVANCES DEL PROYECTO",1,0,'C',FALSE);
        $pdf->Cell(40,4,"OBSERVACIONES",1,0,'C',FALSE);
        $pdf->Cell(40,4,"PENDIENTES",1,1,'C',FALSE);
        $pdf->SetY(68); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,35,'','LR',0,'C');
        $pdf->SetY(100); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,5,$semana3,'LR',0,'C');
        $pdf->SetY(103); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,5,$fecha1,'LR',0,'C');
        $pdf->SetY(108); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,5,'a','LR',0,'C');
        $pdf->SetY(113); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,5,$fecha2,'LR',0,'C');
        $pdf->SetY(108); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,35,'','LBR',0,'C');
        $pdf->SetXY(26, 68); /* Set 20 Eje Y */
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(35,13,'Actitud',1,0,'C');
        $pdf->SetXY(26, 81); /* Set 20 Eje Y */
        $pdf->Cell(35,14,'Responsabilidad',1,1,'C');
        $pdf->SetXY(26, 95);
        $pdf->Cell(35,5,'Capacidad de solucionar','LTR',0,'C');
        $pdf->SetXY(26, 100);
        $pdf->Cell(35,5,'problemas','LR',0,'C');
        $pdf->SetXY(26, 105);
        $pdf->Cell(35,6,'','LBR',0,'C');
        $pdf->SetXY(26, 111);
        $pdf->Cell(35,5,utf8_decode('Aplicación de los'),'LTR',0,'C');
        $pdf->SetXY(26, 116);
        $pdf->Cell(35,5,utf8_decode('conocimientos teóricos'),'LR',0,'C');
        $pdf->SetXY(26, 121);
        $pdf->Cell(35,5,utf8_decode('en la practica'),'LR',0,'C');
        $pdf->SetXY(26, 126);
        $pdf->Cell(35,1,'','LBR',0,'C');
        $pdf->SetXY(26, 127);
        $pdf->Cell(35,5,utf8_decode('Calidad del contenido'),'LTR',0,'C');
        $pdf->SetXY(26, 132);
        $pdf->Cell(35,5,utf8_decode('de los avances del'),'LR',0,'C');
        $pdf->SetXY(26, 137);
        $pdf->Cell(35,5,utf8_decode('informe'),'LR',0,'C');
        $pdf->SetXY(26,142);
        $pdf->Cell(35,1,'','LBR',0,'C');
        $rubro_actitud=DB::selectOne('SELECT * FROM `resi_rubro_actitud` WHERE `id_anteproyecto` = '.$id_anteproyecto.' AND `semana` = '.$semana3.'');
        $rubro_actitud=$rubro_actitud->calificacion;
        if($rubro_actitud < 70)
        {
            $rubro_actitud="N.A.";
        }
        else{
            $rubro_actitud=$rubro_actitud;
        }
        $rubro_aplicacion=DB::selectOne('SELECT * FROM `resi_rubro_aplicacion` WHERE `id_anteproyecto` = '.$id_anteproyecto.' AND `semana` = '.$semana3.'');
        $rubro_aplicacion=$rubro_aplicacion->calificacion;
        if($rubro_aplicacion < 70)
        {
            $rubro_aplicacion="N.A.";
        }
        else{
            $rubro_aplicacion=$rubro_aplicacion;
        }
        $rubro_calidad=DB::selectOne('SELECT * FROM `resi_rubro_calidad` WHERE `id_anteproyecto` = '.$id_anteproyecto.' AND `semana` = '.$semana3.'');
        $rubro_calidad=$rubro_calidad->calificacion;
        if($rubro_calidad < 70)
        {
            $rubro_calidad="N.A.";
        }
        else{
            $rubro_calidad=$rubro_calidad;
        }
        $rubro_capacidad=DB::selectOne('SELECT * FROM `resi_rubro_capacidad` WHERE `id_anteproyecto` = '.$id_anteproyecto.' AND `semana` = '.$semana3.'');
        $rubro_capacidad=$rubro_capacidad->calificacion;
        if($rubro_capacidad < 70)
        {
            $rubro_capacidad="N.A.";
        }
        else{
            $rubro_capacidad=$rubro_capacidad;
        }
        $rubro_responsabilidad=DB::selectOne('SELECT * FROM `resi_rubro_responsabilidad` WHERE `id_anteproyecto` = '.$id_anteproyecto.' AND `semana` = '.$semana3.'');
        $rubro_responsabilidad=$rubro_responsabilidad->calificacion;
        if($rubro_responsabilidad < 70)
        {
            $rubro_responsabilidad="N.A.";
        }
        else{
            $rubro_responsabilidad=$rubro_responsabilidad;
        }
        $pdf->SetXY(61, 68);
        $pdf->Cell(10,13,$rubro_actitud,1,0,'C');
        $pdf->SetXY(61, 81);
        $pdf->Cell(10,14,$rubro_responsabilidad,1,0,'C');
        $pdf->SetXY(61, 95);
        $pdf->Cell(10,16, $rubro_capacidad,1,0,'C');
        $pdf->SetXY(61, 111);
        $pdf->Cell(10,16,$rubro_aplicacion,1,0,'C');
        $pdf->SetXY(61, 127);
        $pdf->Cell(10,16,$rubro_calidad,1,0,'C');
        $pdf->SetXY(71,68);
        $pdf->Cell(54,75,'',1,0,'C');
        $pdf->SetXY(71,68);
        $pdf->MultiCell(54,4,utf8_decode($actividad),0);
        $pdf->SetXY(125,68);
        $pdf->Cell(40,75,'',1,0,'C');
        $pdf->SetXY(125,68);
        $pdf->MultiCell(40,4,utf8_decode($observaciones),0);
        $pdf->SetXY(165,68);
        $pdf->Cell(40,75,'',1,0,'C');
        $pdf->SetXY(165,68);
        $pdf->MultiCell(40,4,utf8_decode($pendientes),0);

        $cronograma=DB::selectOne('SELECT * FROM `resi_cronograma` WHERE `no_semana` = '.$semana4.' AND `id_anteproyecto` = '.$id_anteproyecto.' ORDER BY `no_semana` ASC');
        $fecha1=date("d-m-Y",strtotime($cronograma->f_inicio));
        $fecha2=date("d-m-Y",strtotime($cronograma->f_termino));
        $actividad=mb_eregi_replace("[\n|\r|\n\r]",'',$cronograma->actividad);
        $comentarios=DB::selectOne('SELECT * FROM `resi_promedio_rubros` WHERE `id_semana` = '.$semana4.' AND `id_anteproyecto` ='.$id_anteproyecto.'');
        $observaciones=$comentarios->observaciones;
        $observaciones=mb_eregi_replace("[\n|\r|\n\r]",'',$observaciones);
        $pendientes=$comentarios->pendientes;
        $pendientes=mb_eregi_replace("[\n|\r|\n\r]",'',$pendientes);
        $pdf->SetY(146);
        $pdf->Cell(16,4,"SEMANA",1,0,'C',FALSE);
        $pdf->Cell(45,4,"PUNTO EVALUAR",1,0,'C',FALSE);
        $pdf->Cell(54,4,"AVANCES DEL PROYECTO",1,0,'C',FALSE);
        $pdf->Cell(40,4,"OBSERVACIONES",1,0,'C',FALSE);
        $pdf->Cell(40,4,"PENDIENTES",1,1,'C',FALSE);
        $pdf->SetY(150); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,35,'','LR',0,'C');
        $pdf->SetY(185); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,5,$semana4,'LR',0,'C');
        $pdf->SetY(190); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,5,$fecha1,'LR',0,'C');
        $pdf->SetY(195); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,5,'a','LR',0,'C');
        $pdf->SetY(200); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,5,$fecha2,'LR',0,'C');
        $pdf->SetY(195); /* Inicio */
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(16,35,'','LBR',0,'C');
        $pdf->SetXY(26, 150); /* Set 20 Eje Y */
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(35,16,'Actitud',1,0,'C');
        $pdf->SetXY(26, 166); /* Set 20 Eje Y */
        $pdf->Cell(35,16,'Responsabilidad',1,1,'C');
        $pdf->SetXY(26, 182);
        $pdf->Cell(35,5,'Capacidad de solucionar','LTR',0,'C');
        $pdf->SetXY(26,187);
        $pdf->Cell(35,5,'problemas','LR',0,'C');
        $pdf->SetXY(26,192);
        $pdf->Cell(35,6,'','LBR',0,'C');
        $pdf->SetXY(26, 198);
        $pdf->Cell(35,5,utf8_decode('Aplicación de los'),'LTR',0,'C');
        $pdf->SetXY(26, 203);
        $pdf->Cell(35,5,utf8_decode('conocimientos teóricos'),'LR',0,'C');
        $pdf->SetXY(26, 208);
        $pdf->Cell(35,5,utf8_decode('en la practica'),'LR',0,'C');
        $pdf->SetXY(26, 213);
        $pdf->Cell(35,1,'','LBR',0,'C');
        $pdf->SetXY(26, 214);
        $pdf->Cell(35,5,utf8_decode('Calidad del contenido'),'LTR',0,'C');
        $pdf->SetXY(26, 219);
        $pdf->Cell(35,5,utf8_decode('de los avances del'),'LR',0,'C');
        $pdf->SetXY(26, 224);
        $pdf->Cell(35,5,utf8_decode('informe'),'LR',0,'C');
        $pdf->SetXY(26,229);
        $pdf->Cell(35,1,'','LBR',0,'C');

        $rubro_actitud=DB::selectOne('SELECT * FROM `resi_rubro_actitud` WHERE `id_anteproyecto` = '.$id_anteproyecto.' AND `semana` = '.$semana4.'');
        $rubro_actitud=$rubro_actitud->calificacion;
        if($rubro_actitud < 70)
        {
            $rubro_actitud="N.A.";
        }
        else{
            $rubro_actitud=$rubro_actitud;
        }
        $rubro_aplicacion=DB::selectOne('SELECT * FROM `resi_rubro_aplicacion` WHERE `id_anteproyecto` = '.$id_anteproyecto.' AND `semana` = '.$semana4.'');
        $rubro_aplicacion=$rubro_aplicacion->calificacion;
        if($rubro_aplicacion < 70)
        {
            $rubro_aplicacion="N.A.";
        }
        else{
            $rubro_aplicacion=$rubro_aplicacion;
        }
        $rubro_calidad=DB::selectOne('SELECT * FROM `resi_rubro_calidad` WHERE `id_anteproyecto` = '.$id_anteproyecto.' AND `semana` = '.$semana4.'');
        $rubro_calidad=$rubro_calidad->calificacion;
        if($rubro_calidad < 70)
        {
            $rubro_calidad="N.A.";
        }
        else{
            $rubro_calidad=$rubro_calidad;
        }
        $rubro_capacidad=DB::selectOne('SELECT * FROM `resi_rubro_capacidad` WHERE `id_anteproyecto` = '.$id_anteproyecto.' AND `semana` = '.$semana4.'');
        $rubro_capacidad=$rubro_capacidad->calificacion;
        if($rubro_capacidad < 70)
        {
            $rubro_capacidad="N.A.";
        }
        else{
            $rubro_capacidad=$rubro_capacidad;
        }
        $rubro_responsabilidad=DB::selectOne('SELECT * FROM `resi_rubro_responsabilidad` WHERE `id_anteproyecto` = '.$id_anteproyecto.' AND `semana` = '.$semana4.'');
        $rubro_responsabilidad=$rubro_responsabilidad->calificacion;
        if($rubro_responsabilidad < 70)
        {
            $rubro_responsabilidad="N.A.";
        }
        else{
            $rubro_responsabilidad=$rubro_responsabilidad;
        }
        $pdf->SetXY(61, 150);
        $pdf->Cell(10,16,$rubro_actitud,1,0,'C');
        $pdf->SetXY(61, 166);
        $pdf->Cell(10,16,$rubro_responsabilidad,1,0,'C');
        $pdf->SetXY(61, 182);
        $pdf->Cell(10,16,$rubro_capacidad,1,0,'C');
        $pdf->SetXY(61, 198);
        $pdf->Cell(10,16,$rubro_aplicacion,1,0,'C');
        $pdf->SetXY(61, 214);
        $pdf->Cell(10,16,$rubro_calidad,1,0,'C');
        $pdf->SetXY(71,150);
        $pdf->Cell(54,80,'',1,0,'C');
        $pdf->SetXY(71,150);
        $pdf->MultiCell(54,4,utf8_decode($actividad),0);
        $pdf->SetXY(125,150);
        $pdf->Cell(40,80,'',1,0,'C');
        $pdf->SetXY(125,150);
        $pdf->MultiCell(40,4,utf8_decode($observaciones),0);
        $pdf->SetXY(165,150);
        $pdf->Cell(40,80,'',1,0,'C');
        $pdf->SetXY(165,150);
        $pdf->MultiCell(40,4,utf8_decode($pendientes),0);
        $pdf->Image('img/residencia/FAI.jpg', 40,231, 35);
        $pdf->Image('img/residencia/asesor.JPG', 130,231, 35);


        $pdf->Output();
    }
}
