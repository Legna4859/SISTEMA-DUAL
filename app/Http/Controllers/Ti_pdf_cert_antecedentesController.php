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
        $this->Image('img/logo3.PNG', 125, 5, 70);
        $this->Ln(10);
    }

    //PIE DE PAGINA
    function Footer()
    {

        $this->SetY(-30);
        $this->SetFont('Arial','',8);
        //$this->Image('img/sgc.PNG',40,240,20);
        $this->Image('img/pie/logos_iso.jpg',38,240,55);
       // $this->Image('img/sga.PNG',65,240,20);

        $this->Ln(3);
        $this->SetFont('Arial','B',8);
        $this->Cell(50);
        $this->Cell(140,-2,utf8_decode('SECRETARÍA DE EDUCACIÓN'),0,0,'R');
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(140,-2,utf8_decode('SUBSECRETARÍA DE EDUCACIÓN SUPERIOR Y NORMAL'),0,0,'R');
        $this->Ln(3);
        $this->SetFont('Arial','',8);
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
        $this->Cell(165,4,utf8_decode('     Tels.:(726) 266 51 87 Ext,: 117      titulacion@vbravo.tecnm.mx'),0,0,'L',true);

        $this->Image('img/logos/Mesquina.jpg',0,240,40);
    }

}
class Ti_pdf_cert_antecedentesController extends Controller
{
    public function index($id_alumno)
    {
        $datos_alumnos=DB::selectOne('SELECT ti_datos_alumno_reg_dep.*, ti_clave_carrera.clave,
       ti_nacionalidad.nacionalidad, ti_genero.genero, ti_sexo.sexo, ti_preparatatoria.preparatoria,   ti_entidades_federativas.nom_entidad,
       ti_numeros_titulos.abreviatura_folio_titulo, ti_tipo_titulo_obtenido.tipo_titulo, ti_decisiones_jurado.decision,
       ti_fundamento_legal_s_s.fundamento_legal, ti_autorizacion_reconocimiento.autorizacion_reconocimiento,
       ti_reg_datos_alum.fecha_ingreso_preparatoria,ti_reg_datos_alum.fecha_egreso_preparatoria,
        ti_reg_datos_alum.fecha_ingreso_tesvb,ti_reg_datos_alum.fecha_egreso_tesvb,ti_reg_datos_alum.id_nacionalidad,
ti_descuentos_alum.id_preparatoria,ti_reg_datos_alum.mencion_honorifica

FROM ti_datos_alumno_reg_dep,ti_clave_carrera, ti_nacionalidad, ti_genero, ti_sexo,ti_preparatatoria,ti_entidades_federativas, 
     ti_tipo_titulo_obtenido, ti_numeros_titulos,ti_autorizacion_reconocimiento, ti_fundamento_legal_s_s, ti_reg_datos_alum,ti_decisiones_jurado,ti_descuentos_alum
     WHERE ti_reg_datos_alum.id_carrera= ti_clave_carrera.id_carrera and  ti_reg_datos_alum.id_nacionalidad = ti_nacionalidad.id_nacionalidad and
ti_datos_alumno_reg_dep.id_genero = ti_genero.id_genero and ti_datos_alumno_reg_dep.id_sexo = ti_sexo.id_sexo 
and ti_descuentos_alum.id_preparatoria = ti_preparatatoria.id_preparatoria and
                ti_preparatatoria.id_entidad_federativa = ti_entidades_federativas.id_entidad_federativa  and
                ti_datos_alumno_reg_dep.id_numero_titulo =ti_numeros_titulos.id_numero_titulo and
ti_datos_alumno_reg_dep.id_tipo_titulo = ti_tipo_titulo_obtenido.id_tipo_titulo and 
    ti_datos_alumno_reg_dep.id_decision = ti_decisiones_jurado.id_decision and 
    ti_fundamento_legal_s_s.id_fundamento_legal = ti_datos_alumno_reg_dep.id_fundamento_legal AND
    ti_reg_datos_alum.id_alumno=ti_datos_alumno_reg_dep.id_alumno and 
     ti_reg_datos_alum.id_alumno=ti_descuentos_alum.id_alumno  and 
    ti_autorizacion_reconocimiento.id_autorizacion_reconocimiento =ti_datos_alumno_reg_dep.id_autorizacion_reconocimiento
    and      ti_datos_alumno_reg_dep.id_alumno ='.$id_alumno.'');

        $registro_datos=DB::selectOne('SELECT ti_reg_datos_alum.*,ti_tipo_estudiante.tipo_estudiante,
       gnral_carreras.nombre as carrera,gnral_estados.nombre_estado,ti_opciones_titulacion.opcion_titulacion 
FROM ti_reg_datos_alum,ti_tipo_estudiante,gnral_carreras,gnral_estados, ti_opciones_titulacion 
where ti_reg_datos_alum.id_tipo_estudiante= ti_tipo_estudiante.id_tipo_estudiante
  and ti_reg_datos_alum.id_carrera = gnral_carreras.id_carrera  and
gnral_estados.id_estado= ti_reg_datos_alum.entidad_federativa 
  and ti_reg_datos_alum.id_opcion_titulacion = ti_opciones_titulacion.id_opcion_titulacion and 
ti_reg_datos_alum.id_alumno='.$id_alumno.'');
        $subdirector_escolares=$registro_datos->nombre_subdirector_servicios;
        $jefe_titulacion=$registro_datos->nombre_jefe_titulacion;

        $fecha_titulacion=DB::selectOne('SELECT * FROM `ti_fecha_jurado_alumn` WHERE `id_alumno` ='.$id_alumno.'');

        $dia_titulacion=  substr($fecha_titulacion->fecha_titulacion, 0, 2);
        $mes_titulacion=  substr($fecha_titulacion->fecha_titulacion, 3, 2);
        $year=  substr($fecha_titulacion->fecha_titulacion, 6, 4);

        $fecha_ingreso_preparatoria=substr($datos_alumnos->fecha_ingreso_preparatoria, 0, 4);
        $fecha_egreso_preparatoria=substr($datos_alumnos->fecha_egreso_preparatoria, 0, 4);
        $fecha_ingreso_tesvb=substr($datos_alumnos->fecha_ingreso_tesvb, 0, 4);
        $fecha_egreso_tesvb=substr($datos_alumnos->fecha_egreso_tesvb, 0, 4);
        $numero_foja_titulo=$datos_alumnos->numero_foja_titulo;
        $numero_libro_titulo=$datos_alumnos->numero_libro_titulo;


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
        $nombre_alumno=$registro_datos->nombre_al." ".$registro_datos->apaterno." ".$registro_datos->amaterno;
        $opcion_titulacion=$registro_datos->opcion_titulacion;
        $titulo_obtenido=$datos_alumnos->tipo_titulo;
        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');
        $pdf = new PDF($orientation = 'P', $unit = 'mm', $format = 'Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(15, 10, 10);
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0,0,0);

        $pdf->SetFillColor(166,166,166);
        $pdf->SetFont('Arial','B','8');
        $pdf->Ln(2);
        $pdf->Cell(150,5,utf8_decode($etiqueta->descripcion),0,1,'C');
        $pdf->Ln(2);
        $pdf->SetFont('Arial','B','8');
        $pdf->Cell(180,5,utf8_decode("CERTIFICACIÓN DE ANTECEDENTES ACADÉMICOS"),0,1,'');
        $pdf->Ln(2);
        $pdf->SetFont('Arial','','8');
        $pdf->Cell(180,5,utf8_decode("A continuación, se certifican los estudios de "),0,1,'');
        $pdf->Cell(30,5,utf8_decode("Nombre: "),0,0,'');
        $pdf->Cell(140,5,utf8_decode($nombre_alumno),0,1,'');
        $pdf->Cell(30,5,utf8_decode("Nacionalidad: "),0,0,'');
        $pdf->Cell(140,5,utf8_decode($datos_alumnos->nacionalidad),0,1,'');
        $pdf->Cell(30,5,utf8_decode("Titulo: "),0,0,'');
        $pdf->Cell(140,5,utf8_decode($titulo_obtenido),0,1,'');
        $pdf->Cell(30,5,utf8_decode("CURP: "),0,0,'');
        $pdf->Cell(140,5,utf8_decode($registro_datos->curp_al),0,1,'');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','8');
        $pdf->Cell(150,5,utf8_decode("Estudios de Bachillerato"),0,1,'');
        $pdf->SetFont('Arial','','8');
        $y=$pdf->GetY();
        $x=$pdf->GetX();
        $pdf->Cell(20,5,utf8_decode("Institución: "),0,0,'');
        $pdf->MultiCell(125,5,utf8_decode($datos_alumnos->preparatoria),0,'');
        $yi=$pdf->GetY();
        $pdf->SetXY(160,$y);
        $pdf->Cell(15,5,utf8_decode("Periodo "),0,0,'');
        $pdf->Cell(20,5,utf8_decode($fecha_ingreso_preparatoria." - ".$fecha_egreso_preparatoria),0,1,'C');
        $pdf->SetXY($x,$yi);
        $pdf->Cell(30,5,utf8_decode("Entidad Federativa: "),0,0,'');
        $pdf->Cell(140,5,utf8_decode($datos_alumnos->nom_entidad),0,1,'');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','8');
        $pdf->Cell(150,5,utf8_decode("Estudios Profesionales"),0,1,'');

        $pdf->SetFont('Arial','','8');
        $pdf->Cell(20,5,utf8_decode("Institución: "),0,0,'');
        $pdf->Cell(125,5,utf8_decode("Tecnológico de Estudios Superiores de Valle de Bravo"),0,0,'');
        $pdf->Cell(15,5,utf8_decode("Periodo "),0,0,'');
        $pdf->Cell(20,5,utf8_decode($fecha_ingreso_tesvb." - ".$fecha_egreso_tesvb),0,1,'C');
        $pdf->Cell(20,5,utf8_decode("Carrera: "),0,0,'');
        $pdf->Cell(140,5,utf8_decode($registro_datos->carrera),0,1,'');
        $pdf->Cell(30,5,utf8_decode("Entidad Federativa: "),0,0,'');
        $pdf->Cell(140,5,utf8_decode("MÉXICO"),0,1,'');
        $pdf->Ln(5);
        $pdf->Cell(40,5,utf8_decode("Opción de Titulación: "),0,0,'');
        $pdf->Cell(105,5,utf8_decode("$registro_datos->opcion_titulacion"),0,0,'');
        $pdf->Cell(15,5,utf8_decode("Fecha: "),0,0,'');
        $pdf->Cell(20,5,utf8_decode($mes_titulacion." ".$dia_titulacion.", ".$year),0,1,'C');
        $pdf->MultiCell(180,5,utf8_decode('Cumplió con el Servicio Social, conforme al Articulo 55 de la Ley Reglamentaria del Articulo 5° Constitucional, relativo al ejercicio de las profesiones en el Distrito Federal y al Articulo 85 del Reglamento de la Ley Reglamentaria del Articulo 5° Constitucional.'),0,'J');
        $pdf->Ln(5);
        $pdf->Cell(180,5,utf8_decode("Valle de Bravo, Estado de México, a ".$dia_titulacion." de ".$mes_titulacion." de ".$year),0,1,'');
        $pdf->Ln(5);
        $pdf->Cell(180,5,utf8_decode("Subdirección de Servicios Escolares"),0,1,'');
        $pdf->Ln(10);
        $pdf->Cell(10,5,utf8_decode(""),0,0,'');
        $pdf->Cell(170,5,utf8_decode($subdirector_escolares),0,1,'');
        $pdf->Ln(5);
        $pdf->Cell(80,5,utf8_decode("Registrado en el Departamento de Titulación"),0,1,'C');
        $pdf->Cell(80,5,utf8_decode("en la foja 0".$numero_foja_titulo."FTE del libro 0".$numero_libro_titulo." el día "),0,1,'C');
        $pdf->Cell(80,5,utf8_decode($dia_titulacion." de ".$mes_titulacion." de ".$year),0,1,'C');
        $pdf->Ln(10);
        $pdf->Cell(80,5,utf8_decode($jefe_titulacion),0,1,'C');
        $y3=$pdf->GetY();
        $pdf->SetFont('Arial','B','8');
        $pdf->Cell(80,5,utf8_decode(""),0,0,'C');
        $pdf->MultiCell(110,5,utf8_decode('Firmo de conformidad y acepto los datos plasmados en este documento como verdaderos y correctos; acepto en el entendido que serán los datos que aparecerán en el Título profesional que emite esta institución y que estoy consciente que toda corrección u omisión implican tramites y gastos administrativos los cuales asumiré. '),0,'J');
        $pdf->Ln(2);
        $pdf->Cell(80,5,utf8_decode(""),0,0,'C');
        $pdf->Cell(110,5,utf8_decode("Nombre y Firma del egresado Titulado"),0,1,'');
        $pdf->Ln(6);
        $pdf->Cell(80,5,utf8_decode(""),0,0,'C');
        $pdf->Cell(110,5,utf8_decode("_________________________________________"),0,1,'');
        $pdf->Cell(80,5,utf8_decode(""),0,0,'C');
        $pdf->Cell(110,5,utf8_decode("Fecha: ______________________"),0,1,'');
        $pdf->SetXY(95,$y3);
        $pdf->Cell(110,50,utf8_decode(""),1,0,'C');
        $pdf->Output();
        exit();
    }
}
