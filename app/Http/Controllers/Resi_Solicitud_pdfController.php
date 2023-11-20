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
        //$this->Image('img/tutorias/cir.jpg',89,239,20);
        // $this->Image('img/sga.PNG',65,240,20);
        $this->Cell(50);
        $this->Cell(145,-2,utf8_decode('FO-TESVB-89   V.0    23/03/2018'),0,0,'R');
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
        $this->Cell(145,-2,utf8_decode('DEPARTAMENTO DE SERVICIO SOCIAL Y RESIDENCIA PROFESIONAL '),0,0,'R');
        $this->Cell(280);
        $this->SetMargins(0,0,0);
        $this->Ln(0);
        $this->SetXY(40,262);
        $this->SetFillColor(120,120,120);
        $this->SetTextColor(255,255,255);
        $this->SetFont('Arial','B',8);
        $this->Cell(165,4,utf8_decode('      Km. 30 de la Carretera Federal Monumento-Valle de Bravo, Ejido de San Antonio de la Laguna '),0,0,'L',TRUE);
        $this->Ln(3);
        $this->Cell(40);
        $this->SetFont('Arial','B',8);
        $this->Cell(165,4,utf8_decode('      C.P. 51200, Valle de Bravo, Estado de México.'),0,0,'L',TRUE);
        $this->Ln(3);
        $this->Cell(40);
        $this->SetFont('Arial','',8);
        $this->Cell(165,4,utf8_decode('     Tels.: (726) 266 52 00, 266 51 87. Ext.:144   servicio.social@vbravo.tecnm.mx'),0,0,'L',true);

        $this->Image('img/logos/Mesquina.jpg',0,240,40);

    }
}

class Resi_Solicitud_pdfController extends Controller
{
    public function index($id_anteproyecto){
        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');

        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $id_alumno=$datosalumno->id_alumno;
        // dd($id_alumno);
        $id_carrera=$datosalumno->id_carrera;

        $datos_jefe=DB::selectOne('SELECT abreviaciones.titulo, gnral_personales.nombre, gnral_carreras.nombre carrera 
        from abreviaciones, abreviaciones_prof, gnral_personales, gnral_carreras, gnral_jefes_periodos 
        where abreviaciones.id_abreviacion = abreviaciones_prof.id_abreviacion and 
        abreviaciones_prof.id_personal = gnral_personales.id_personal and
        gnral_personales.id_personal = gnral_jefes_periodos.id_personal and 
        gnral_jefes_periodos.id_carrera = gnral_carreras.id_carrera and gnral_jefes_periodos.id_carrera = '.$id_carrera.'
           and gnral_jefes_periodos.id_periodo = '.$periodo.' ');
         //dd($datos_jefe);

        $periodo_seguimiento= $periodo+1;
        $nombre_periodo_seguimiento=DB::selectOne('SELECT * FROM `gnral_periodos` WHERE `id_periodo` ='.$periodo_seguimiento.' ');

        $opciones_proyecto =DB::select('SELECT * FROM `resi_opcion_proy_soli` ORDER BY `resi_opcion_proy_soli`.`nombre_opcion` ASC');

        $anteproyecto=DB::selectOne('select resi_anteproyecto.id_anteproyecto from resi_anteproyecto where resi_anteproyecto.id_alumno='.$id_alumno.' and resi_anteproyecto.id_periodo='.$periodo.' ');

        $datos_empresa=DB::selectOne('SELECT resi_proy_empresa.*,resi_giro.descripcion giro, resi_sector.descripcion sector,
        resi_empresa.nombre, resi_empresa.domicilio,resi_empresa.tel_empresa, resi_empresa.correo,resi_empresa.dir_gral, 
        resi_proyecto.nom_proyecto from resi_proy_empresa, resi_empresa, resi_giro, resi_sector, resi_proyecto, resi_anteproyecto
        where resi_proy_empresa.id_empresa = resi_empresa.id_empresa and resi_proy_empresa.id_giro = resi_giro.id_giro and
        resi_proy_empresa.id_sector = resi_sector.id_sector and resi_proyecto.id_proyecto = resi_anteproyecto.id_proyecto and 
        resi_proy_empresa.id_anteproyecto = resi_anteproyecto.id_anteproyecto and resi_anteproyecto.id_anteproyecto ='.$id_anteproyecto.' ');

         //dd($datos_empresa);
        $nombre_preyecto= $datos_empresa->nom_proyecto;
        $nombre_proyecto2=mb_eregi_replace("[\n|\r|\n\r]",'',$nombre_preyecto);


            $reg_solicitud = DB::selectOne('SELECT * FROM `resi_reg_solicitud` WHERE `id_anteproyecto` ='.$id_anteproyecto.'');


//dd($reg_solicitud);

        $datos_alumn = DB::selectOne('SELECT gnral_alumnos.*, gnral_municipios.nombre_municipio,
       gnral_seguro_social.descripcion seguro_social, users.email,gnral_carreras.nombre carrera from gnral_alumnos, gnral_municipios, gnral_seguro_social, users, gnral_carreras
       where gnral_alumnos.id_municipio = gnral_municipios.id_municipio and gnral_alumnos.id_seguro_social = gnral_seguro_social.id_seguro_social 
       and gnral_alumnos.id_carrera = gnral_carreras.id_carrera
       and gnral_alumnos.id_usuario = users.id and gnral_alumnos.id_alumno ='.$id_alumno.' ');

        $domicilio_empresa=mb_eregi_replace("[\n|\r|\n\r]",'',$datos_empresa->domicilio);

        $fecha = date("d-m-Y");

        $pdf = new PDF($orientation = 'P', $unit = 'mm', $format = 'Letter');


        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(10, 15, 10);
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0,0,0);

        $pdf->SetFillColor(166,166,166);
        $pdf->SetFont('Arial','B','8');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(190,5,utf8_decode("RESIDENCIA PROFESIONAL"),0,1,'C');
        $pdf->Cell(190,5,utf8_decode("SOLICITUD PARA RESIDENCIA PROFESIONAL"),0,1,'C');
        $pdf ->SetDrawColor(17, 122, 101);
        $pdf ->SetLineWidth(0.5);
        $pdf ->Line(10,40,200,40);
        $pdf->Ln(2);
        $pdf ->SetDrawColor(0, 0, 0);
        $pdf ->SetLineWidth(0.1);
        $pdf->SetFont('Arial','','8');
        $pdf->Cell(100,5,utf8_decode("LUGAR: VALLE DE BRAVO, ESTADO DE MÉXICO"),"LT",0,'L');
        $pdf->Cell(90,5,utf8_decode("FECHA: ".$fecha),"T",1,'L');
        $nombre_jefe = mb_strtoupper($datos_jefe->titulo." ".$datos_jefe->nombre);
        $jefe_carrera = mb_strtoupper($datos_jefe->carrera);
        $pdf->Cell(100,5,utf8_decode($nombre_jefe),"L",1,'L');
        $pdf->Cell(100,5,utf8_decode("JEFE(A) DE DIVISIÓN DE LA CARRERA DE ".$jefe_carrera),"L",1,'L');
        $pdf->Cell(100,5,utf8_decode("PRESENTE"),"L",1,'L');
        $pdf ->SetDrawColor(17, 122, 101);
        $pdf ->SetLineWidth(0.5);
        $pdf ->Line(50,60,200,60);
        $pdf->SetFont('Arial','','9');
        $y=$pdf->GetY();
        $x=$pdf->GetX();
        $pdf->Cell(42,4,utf8_decode("NOMBRE DEL PROYECTO: "),0,1,'L');
        $pdf->SetXY($x+42,$y);
        $pdf->MultiCell(148,4,utf8_decode($nombre_proyecto2),0,'J',0,false);
        $pdf->SetFont('Arial','','8');
        $pdf->Cell(42,4,utf8_decode("OPCIÓN ELEGIDA: "),0,1,'L');
        $pdf->Cell(20,4,utf8_decode(""),0,0,'L');
        $pdf ->SetDrawColor(0, 0, 0);
        $pdf ->SetLineWidth(0.1);
        if($reg_solicitud->id_opcion_proyecto == 1)
        {
            $pdf->Cell(50,4,utf8_decode("BANCO DE PROYECTOS"),0,0,'R');
            $pdf->Cell(5,4,utf8_decode("X"),1,0,'C');
        }else{
            $pdf->Cell(50,4,utf8_decode("BANCO DE PROYECTOS"),0,0,'R');
            $pdf->Cell(5,4,utf8_decode(" "),1,0,'C');
        }
        if($reg_solicitud->id_opcion_proyecto == 2)
        {
            $pdf->Cell(50,4,utf8_decode("PROPUESTA PROPIA"),0,0,'R');
            $pdf->Cell(5,4,utf8_decode("X"),1,0,'C');
        }else{
            $pdf->Cell(50,4,utf8_decode("PROPUESTA PROPIA"),0,0,'R');
            $pdf->Cell(5,4,utf8_decode(" "),1,0,'C');
        }
        if($reg_solicitud->id_opcion_proyecto == 3)
        {
            $pdf->Cell(50,4,utf8_decode("TRABAJADOR"),0,0,'R');
            $pdf->Cell(5,4,utf8_decode("X"),1,1,'C');
        }else{
            $pdf->Cell(50,4,utf8_decode("TRABAJADOR"),0,0,'R');
            $pdf->Cell(5,4,utf8_decode(" "),1,1,'C');
        }
        $pdf->Cell(100,4,utf8_decode("PERIODO PROYECTADO:   ".$nombre_periodo_seguimiento->periodo),0,0,'L');
        $pdf->Cell(100,4,utf8_decode("NÚMERO DE RESIDENTES:   1"),0,1,'L');
        $y=$pdf->GetY();
        $x=$pdf->GetX();
        $pdf->SetDrawColor(17, 122, 101);
        $pdf->SetLineWidth(0.5);
        $pdf->Line(10,$y+2,200,$y+2);
        $pdf->SetXY($x,$y+2);
        $pdf->SetFont('Arial','B','9');
        $pdf->Cell(50,4,utf8_decode("DATOS DE LA EMPRESA"),0,1,'L');
        $pdf->SetDrawColor(17, 122, 101);
        $pdf->SetLineWidth(0.5);
        $pdf->Line(10,$y+7,200,$y+7);
        $pdf->SetFont('Arial','','8');
        $y=$pdf->GetY();
        $x=$pdf->GetX();
        $pdf->SetXY($x,$y+2);
        $pdf->Cell(15,4,utf8_decode("NOMBRE: "),0,0,'L');
        $pdf->SetXY($x+15,$y+2);
        $nombre_empresa = mb_strtoupper($datos_empresa->nombre);
        $pdf->MultiCell(175,4,utf8_decode($nombre_empresa),0,'J',0,false);
        $pdf ->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0);
        $pdf->Cell(15,4,utf8_decode("GIRO: "),0,0,'L');
        if($datos_empresa->id_giro == 1)
        {
            $pdf->Cell(35,4,utf8_decode("GIRO INDUSTRIAL"),0,0,'R');
            $pdf->Cell(5,4,utf8_decode("X"),1,0,'C',false);
        }else{
            $pdf->Cell(35,4,utf8_decode("GIRO INDUSTRIAL"),0,0,'R');
            $pdf->Cell(5,4,utf8_decode(" "),1,0,'C',false);
        }
        if($datos_empresa->id_giro == 2)
        {
            $pdf->Cell(35,4,utf8_decode("GIRO DE SERVICIO"),0,0,'R');
            $pdf->Cell(5,4,utf8_decode("X"),1,0,'C',false);
        }else{
            $pdf->Cell(35,4,utf8_decode("GIRO DE SERVICIO"),0,0,'R');
            $pdf->Cell(5,4,utf8_decode(" "),1,0,'C',false);
        }
        if($datos_empresa->id_giro == 3)
        {
            $pdf->Cell(35,4,utf8_decode("GIRO COMERCIAL"),0,0,'R');
            $pdf->Cell(5,4,utf8_decode("X"),1,1,'C',false);
        }else{
            $pdf->Cell(35,4,utf8_decode("GIRO COMERCIAL"),0,0,'R');
            $pdf->Cell(5,4,utf8_decode(" "),1,1,'C',false);
        }
        $pdf->Ln(1);
        $pdf->Cell(15,4,utf8_decode("SECTOR: "),0,0,'L');
        if($datos_empresa->id_sector == 1)
        {
            $pdf->Cell(35,4,utf8_decode("SECTOR PÚBLICO"),0,0,'R');
            $pdf->Cell(5,4,utf8_decode("X"),1,0,'C',false);
        }else{
            $pdf->Cell(35,4,utf8_decode("SECTOR PÚBLICO"),0,0,'R');
            $pdf->Cell(5,4,utf8_decode(" "),1,0,'C',false);
        }
        if($datos_empresa->id_sector == 2)
        {
            $pdf->Cell(35,4,utf8_decode("SECTOR PRIVADO"),0,0,'R');
            $pdf->Cell(5,4,utf8_decode("X"),1,0,'C',false);
        }else{
            $pdf->Cell(35,4,utf8_decode("SECTOR PRIVADO"),0,0,'R');
            $pdf->Cell(5,4,utf8_decode(" "),1,0,'C',false);
        }
        if($datos_empresa->id_sector == 3)
        {
            $pdf->Cell(35,4,utf8_decode("SECTOR SOCIAL"),0,0,'R');
            $pdf->Cell(5,4,utf8_decode("X"),1,0,'C',false);
        }else{
            $pdf->Cell(35,4,utf8_decode("SECTOR SOCIAL"),0,0,'R');
            $pdf->Cell(5,4,utf8_decode(" "),1,0,'C',false);
        }
        $pdf->Cell(35,4,utf8_decode("R.F.C.: ".$reg_solicitud->rfc_empresa),0,1,'R');
        $pdf->Cell(20,4,utf8_decode("DOMICILIO: "),0,0,'L');
        $y=$pdf->GetY();
        $x=$pdf->GetX();
        $pdf->SetXY($x,$y);
        $domicilio_empresa = mb_strtoupper($domicilio_empresa);
        $pdf->MultiCell(148,4,utf8_decode($domicilio_empresa),0,'J',0,false);
        $pdf->Cell(20,4,utf8_decode("COLONIA: "),0,0,'L');
        $colonia_empresa = mb_strtoupper($reg_solicitud->colonia_empresa);
        $pdf->Cell(100,4,utf8_decode($colonia_empresa),0,0,'L');
        $pdf->Cell(10,4,utf8_decode("C.P.: "),0,0,'L');
        $codigo_postal_empresa = mb_strtoupper($reg_solicitud->codigo_postal_empresa);
        $pdf->Cell(50,4,utf8_decode($codigo_postal_empresa),0,1,'L');
        $pdf->Cell(20,4,utf8_decode("CIUDAD: "),0,0,'L');
        $ciudad_municipio_empresa = mb_strtoupper($reg_solicitud->ciudad_municipio_empresa);
        $pdf->Cell(100,4,utf8_decode($ciudad_municipio_empresa),0,0,'L');
        $pdf->Cell(40,4,utf8_decode("TELÉFONO(NO CELULAR) : "),0,0,'L');
        $pdf->Cell(40,4,utf8_decode($reg_solicitud->telefono_empresa),0,1,'L');
        $pdf->Cell(100,4,utf8_decode("MISIÓN DE LA EMPRESA : "),0,1,'L');
        $mision_empresa = mb_strtoupper($reg_solicitud->mision_empresa);
        $pdf->MultiCell(190,4,utf8_decode($mision_empresa),0,'J',0,false);
        $y=$pdf->GetY();
        //$x=$pdf->GetX();
        $pdf->SetFont('Arial','','7');
        $pdf->Line(10,$y,200,$y);
        $pdf->Cell(100,4,utf8_decode("NOMBRE DEL TITULAR DE LA"),0,1,'L');
        //$pdf->Cell(100,4,utf8_decode("DE LA"),0,1,'L');
        $pdf->Cell(30,4,utf8_decode("EMPRESA/INSTITUCIÓN: "),0,0,'L');
        $dir_gral = mb_strtoupper($datos_empresa->dir_gral);
        $pdf->Cell(80,4,utf8_decode($dir_gral),0,0,'L');
        $puesto_titular_empresa = mb_strtoupper($reg_solicitud->puesto_titular_empresa);
        $pdf->Cell(80,4,utf8_decode("PUESTO: ".$puesto_titular_empresa),0,1,'L');
        $pdf->Cell(100,4,utf8_decode("NOMBRE DEL ASESOR"),0,1,'L');
        $pdf->Cell(30,4,utf8_decode("EXTERNO: "),0,0,'L');
        $asesor = mb_strtoupper($datos_empresa->asesor);
        $pdf->Cell(80,4,utf8_decode($asesor),0,0,'L');
        $puesto = mb_strtoupper($datos_empresa->puesto);
        $pdf->Cell(13,4,utf8_decode("PUESTO: "),0,0,'L');
        $y=$pdf->GetY();
        $x=$pdf->GetX();
        $pdf->SetXY($x,$y);
        $pdf->MultiCell(67,4,utf8_decode($puesto),0,'J',0,false);

        $y=$pdf->GetY();
        //$x=$pdf->GetX();
        $pdf->SetDrawColor(17, 122, 101);
        $pdf->SetLineWidth(0.5);
        $pdf->Line(10,$y,200,$y);
        $pdf->SetFont('Arial','B','8');
        $pdf->Cell(100,5,utf8_decode("DATOS DEL RESIDENTE:"),0,1,'L');
        $y=$pdf->GetY();
        //$x=$pdf->GetX();
        $pdf->SetDrawColor(17, 122, 101);
        $pdf->SetLineWidth(0.5);
        $pdf->Line(10,$y,200,$y);

        $pdf ->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0);
        $pdf->SetFont('Arial','','7');
        $pdf->Cell(20,4,utf8_decode("NOMBRE: "),0,0,'L');
        $nombre_estudiante = mb_strtoupper($datos_alumn->nombre." ".$datos_alumn->apaterno." ".$datos_alumn->amaterno);
        $pdf->Cell(170,4,utf8_decode($nombre_estudiante),0,1,'L');
        $nombre_carrera = mb_strtoupper($datos_alumn->carrera);
        $pdf->Cell(20,4,utf8_decode("CARRERA: "),0,0,'L');
        $pdf->Cell(90,4,utf8_decode($nombre_carrera),0,0,'L');
        $pdf->Cell(22,4,utf8_decode("NO. DE CUENTA:"),0,0,'L');
        $cuenta= mb_strtoupper($datos_alumn->cuenta);
        $pdf->Cell(58,4,utf8_decode($cuenta),0,1,'L');
        $pdf->Cell(20,4,utf8_decode("DOMICILIO: "),0,0,'L');
        $domiclio_estudiante= mb_strtoupper($reg_solicitud->domiclio_estudiante);
        $pdf->Cell(170,4,utf8_decode($domiclio_estudiante),0,1,'L');
        $pdf->Cell(20,4,utf8_decode("E-MAIL: "),0,0,'L');
        $pdf->Cell(90,4,utf8_decode($datos_alumn->email),0,0,'L');
        $pdf->Cell(45,4,utf8_decode("PARA SEGURIDAD SOCIAL ACUDIR:"),0,0,'L');
        $seguro_social= mb_strtoupper($datos_alumn->seguro_social);
        $pdf->Cell(58,4,utf8_decode($seguro_social),0,1,'L');
        $pdf->Cell(20,4,utf8_decode(" "),0,0,'L');
        $pdf->Cell(90,4,utf8_decode(""),0,0,'L');
        $pdf->Cell(45,4,utf8_decode(""),0,0,'L');
        $no_seguro_estudiante= mb_strtoupper($reg_solicitud->no_seguro_estudiante);
        $pdf->Cell(35,4,utf8_decode("NO.".$no_seguro_estudiante),"B",1,'L');
        $pdf->Cell(20,4,utf8_decode("CIUDAD: "),0,0,'L');
        $nombre_municipio= mb_strtoupper($datos_alumn->nombre_municipio);
        $pdf->Cell(90,4,utf8_decode($nombre_municipio),0,0,'L');
        $pdf->Cell(15,4,utf8_decode("TELEFONO: "),0,0,'L');
        $pdf->Cell(50,4,utf8_decode($reg_solicitud->telefono_estudiante),0,1,'L');
        $y=$pdf->GetY();
        //$x=$pdf->GetX();
        $pdf->SetDrawColor(17, 122, 101);
        $pdf->SetLineWidth(0.5);
        $pdf->Line(10,$y,200,$y);
        $pdf->Ln(10);
        $y=$pdf->GetY();
        //$x=$pdf->GetX();
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0);
        $pdf->Cell(65,4,utf8_decode(""),0,0,'L');
        $nombre_estudiante = mb_strtoupper($datos_alumn->nombre." ".$datos_alumn->apaterno." ".$datos_alumn->amaterno);
        $pdf->Cell(60,4,utf8_decode($nombre_estudiante),"B",1,'C');
        $pdf->Cell(65,4,utf8_decode(""),0,0,'L');
        $pdf->Cell(60,4,utf8_decode("NOMBRE Y FIRMA DEL ESTUDIANTE"),0,1,'C');




        $pdf->Output();
        exit();
    }
}
