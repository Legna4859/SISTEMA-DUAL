<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;


class PDF extends FPDF
{
    //CABECERA DE LA PAGINA
    function Header()
    {
        $this->Image('img/tutorias/edomex.png',10,0,40,20);
        $this->Image('img/tutorias/TESVB.png',145,3,28,11);
        $this->Image('img/tutorias/edomex1.png',176,2,30,13);
        $this->Line(175,2.5,175,14);
    }
    //PIE DE PAGINA
    function Footer()
    {
        $this->SetY(-27);
        $this->SetFont('Arial','',8);
        $this->Image('img/pie/logos_iso.jpg',40,262,60);
        //$this->Image('img/sgc.PNG',40,240,20);

        // $this->Image('img/sga.PNG',65,240,20);
        $this->Cell(50);
        $this->Cell(145,-2,utf8_decode('FO-TESVB-109 V.1 03/04/2019'),0,0,'R');
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
        $this->Cell(145,-2,utf8_decode('DEPARTAMENTO DE DESAROLLO ACADÉMICO'),0,0,'R');
        $this->Cell(280);
        $this->SetMargins(0,0,0);
        $this->Ln(0);
        $this->SetXY(40,284);
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
        $this->Cell(165,4,utf8_decode('     Tels.:(726)26 6 52 00, 26 6 51 87'),0,0,'L',true);

        $this->Image('img/logos/Mesquina.jpg',0,262,40);
    }
}

class Tutorias_PdfReporteSemestralController extends Controller
{
    public function pdf_reportesem(Request $request)
    {

        $fecha = DB::select('select Date_format(now(),"%d/%m/%Y") as fecha');

        $titulo = DB::select('SELECT exp_asigna_tutor.id_asigna_generacion,abreviaciones.titulo,gnral_personales.nombre,
                             exp_asigna_generacion.grupo,exp_generacion.generacion
                             FROM exp_asigna_tutor,gnral_personales,exp_asigna_generacion,exp_generacion,exp_asigna_alumnos,
                             abreviaciones_prof,abreviaciones
                             WHERE exp_asigna_tutor.id_personal=gnral_personales.id_personal
                             AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                             AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
                             AND exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
                             AND exp_asigna_generacion.id_generacion=exp_generacion.id_generacion
                             AND exp_asigna_alumnos.deleted_at is null
                             AND exp_asigna_tutor.deleted_at is null
                             AND exp_asigna_generacion.deleted_at is null
                             AND abreviaciones.id_abreviacion= abreviaciones_prof.id_abreviacion
                             AND abreviaciones_prof.id_personal=gnral_personales.id_personal
                             AND exp_asigna_tutor.id_asigna_generacion='.$request->id_asigna_generacion.'
                             GROUP BY (exp_asigna_tutor.id_asigna_generacion)');
        $id_periodo = Session::get('periodo_actual');
        $periodo=DB::selectOne('SELECT periodo from gnral_periodos where id_periodo='.$id_periodo.'');

        $carrera=DB::table('gnral_carreras')
            ->select('nombre','id_carrera')
            ->where('id_carrera', '=', $request->id_carrera)
            ->get();
       $jefe_periodo=DB::selectOne('SELECT * FROM `gnral_jefes_periodos` 
WHERE `id_carrera` = '.$carrera[0]->id_carrera.' AND `id_periodo` = '.$id_periodo.' ');
       $cargo=DB::selectOne('SELECT gnral_unidad_administrativa.jefe_descripcion  FROM gnral_unidad_personal,gnral_unidad_administrativa WHERE gnral_unidad_personal.id_personal = '.$jefe_periodo->id_personal.'
                                                                                                              and gnral_unidad_personal.id_unidad_admin=gnral_unidad_administrativa.id_unidad_admin');
        $cargo=$cargo->jefe_descripcion;
        $consulta=DB::select('SELECT reporte_tutor.* 
                              FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
                                   reporte_tutor 
                              WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno 
                              AND gnral_alumnos.cuenta=exp_generales.no_cuenta
                              AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                              AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                              AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
                              AND exp_asigna_tutor.deleted_at is null 
                              AND exp_asigna_generacion.deleted_at is null 
                              AND exp_asigna_alumnos.deleted_at is null 
                              AND reporte_tutor.id_asigna_generacion='.$request->id_asigna_generacion.'
                              ORDER BY(reporte_tutor.n_cuenta)');

        $jefedivision=DB::select('SELECT abreviaciones.titulo,gnral_personales.nombre FROM gnral_personales, exp_asigna_coordinador, 
                                  gnral_jefes_periodos, gnral_carreras,abreviaciones,abreviaciones_prof
                                  WHERE gnral_jefes_periodos.id_personal=gnral_personales.id_personal
                                  AND gnral_jefes_periodos.id_jefe_periodo=exp_asigna_coordinador.id_jefe_periodo
                                  AND gnral_jefes_periodos.id_carrera=gnral_carreras.id_carrera
                                  AND exp_asigna_coordinador.deleted_at is null
                                  AND abreviaciones.id_abreviacion= abreviaciones_prof.id_abreviacion
                                  AND abreviaciones_prof.id_personal=gnral_personales.id_personal
                                  AND gnral_jefes_periodos.id_carrera='.$request->id_carrera.'
                                   AND gnral_jefes_periodos.id_periodo='.$id_periodo.'
                                 ');

        $coorcarrera=DB::select('SELECT abreviaciones.titulo,gnral_personales.nombre 
                                 FROM gnral_personales, exp_asigna_coordinador, gnral_jefes_periodos, gnral_carreras
                                 ,abreviaciones,abreviaciones_prof
                                 WHERE exp_asigna_coordinador.id_personal=gnral_personales.id_personal
                                 AND exp_asigna_coordinador.id_jefe_periodo=gnral_jefes_periodos.id_jefe_periodo
                                 AND gnral_jefes_periodos.id_carrera=gnral_carreras.id_carrera
                                 AND exp_asigna_coordinador.deleted_at is null
                                 AND abreviaciones.id_abreviacion= abreviaciones_prof.id_abreviacion
                                 AND abreviaciones_prof.id_personal=gnral_personales.id_personal
                                 AND gnral_jefes_periodos.id_carrera='.$request->id_carrera.'
                                 AND gnral_jefes_periodos.id_periodo='.$id_periodo.'
                                 ');


        $coorinst=DB::select('SELECT abreviaciones.titulo,gnral_personales.nombre 
                              FROM gnral_personales,desarrollo_asigna_coordinador_general,abreviaciones,abreviaciones_prof
                              WHERE gnral_personales.id_personal=desarrollo_asigna_coordinador_general.id_personal
                              AND abreviaciones.id_abreviacion= abreviaciones_prof.id_abreviacion
                              AND abreviaciones_prof.id_personal=gnral_personales.id_personal
                              AND desarrollo_asigna_coordinador_general.deleted_at is null ');

        $tut_grupal=DB::select('SELECT COUNT(reporte_tutor.tutoria_grupal) as tutoria_grupal
                              FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
                                   reporte_tutor 
                              WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno 
                              AND gnral_alumnos.cuenta=exp_generales.no_cuenta
                              AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                              AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                              AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
                              AND exp_asigna_tutor.deleted_at is null 
                              AND exp_asigna_generacion.deleted_at is null 
                              AND exp_asigna_alumnos.deleted_at is null 
                              AND reporte_tutor.tutoria_grupal="Si"
                              AND reporte_tutor.id_asigna_generacion='.$request->id_asigna_generacion);

        $tut_ind=DB::select('SELECT COUNT(reporte_tutor.tutoria_individual) as tutoria_individual
                              FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
                                   reporte_tutor 
                              WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno 
                              AND gnral_alumnos.cuenta=exp_generales.no_cuenta
                              AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                              AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                              AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
                              AND exp_asigna_tutor.deleted_at is null 
                              AND exp_asigna_generacion.deleted_at is null 
                              AND exp_asigna_alumnos.deleted_at is null 
                              AND reporte_tutor.tutoria_individual="Si"
                              AND reporte_tutor.id_asigna_generacion='.$request->id_asigna_generacion);

        $bec=DB::select('SELECT COUNT(reporte_tutor.beca) as beca
                              FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
                                   reporte_tutor 
                              WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno 
                              AND gnral_alumnos.cuenta=exp_generales.no_cuenta
                              AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                              AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                              AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
                              AND exp_asigna_tutor.deleted_at is null 
                              AND exp_asigna_generacion.deleted_at is null 
                              AND exp_asigna_alumnos.deleted_at is null 
                              AND reporte_tutor.beca=1
                              AND reporte_tutor.id_asigna_generacion='.$request->id_asigna_generacion);

        $rep=DB::select('SELECT COUNT(reporte_tutor.repeticion) as repeticion
                              FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
                                   reporte_tutor 
                              WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno 
                              AND gnral_alumnos.cuenta=exp_generales.no_cuenta
                              AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                              AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                              AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
                              AND exp_asigna_tutor.deleted_at is null 
                              AND exp_asigna_generacion.deleted_at is null 
                              AND exp_asigna_alumnos.deleted_at is null 
                              AND reporte_tutor.repeticion = 1
                              AND reporte_tutor.id_asigna_generacion='.$request->id_asigna_generacion);

        $esp=DB::select('SELECT COUNT(reporte_tutor.especial) as especial
                              FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
                                   reporte_tutor 
                              WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno 
                              AND gnral_alumnos.cuenta=exp_generales.no_cuenta
                              AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                              AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                              AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
                              AND exp_asigna_tutor.deleted_at is null 
                              AND exp_asigna_generacion.deleted_at is null 
                              AND exp_asigna_alumnos.deleted_at is null 
                              AND reporte_tutor.especial = 1
                              AND reporte_tutor.id_asigna_generacion='.$request->id_asigna_generacion);

        $acad=DB::select('SELECT COUNT(reporte_tutor.academico) as academico
                              FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
                                   reporte_tutor 
                              WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno 
                              AND gnral_alumnos.cuenta=exp_generales.no_cuenta
                              AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                              AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                              AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
                              AND exp_asigna_tutor.deleted_at is null 
                              AND exp_asigna_generacion.deleted_at is null 
                              AND exp_asigna_alumnos.deleted_at is null 
                              AND reporte_tutor.academico = "Si"
                              AND reporte_tutor.id_asigna_generacion='.$request->id_asigna_generacion);

        $med=DB::select('SELECT COUNT(reporte_tutor.medico) as medico
                              FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
                                   reporte_tutor 
                              WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno 
                              AND gnral_alumnos.cuenta=exp_generales.no_cuenta
                              AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                              AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                              AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
                              AND exp_asigna_tutor.deleted_at is null 
                              AND exp_asigna_generacion.deleted_at is null 
                              AND exp_asigna_alumnos.deleted_at is null 
                              AND reporte_tutor.medico = "Si"
                              AND reporte_tutor.id_asigna_generacion='.$request->id_asigna_generacion);

        $psi=DB::select('SELECT COUNT(reporte_tutor.psicologico) as psicologico
                              FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
                                   reporte_tutor 
                              WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno 
                              AND gnral_alumnos.cuenta=exp_generales.no_cuenta
                              AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                              AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                              AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
                              AND exp_asigna_tutor.deleted_at is null 
                              AND exp_asigna_generacion.deleted_at is null 
                              AND exp_asigna_alumnos.deleted_at is null 
                              AND reporte_tutor.psicologico = "Si"
                              AND reporte_tutor.id_asigna_generacion='.$request->id_asigna_generacion);

        $baj=DB::select('SELECT COUNT(reporte_tutor.baja) as baja
                              FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
                                   reporte_tutor 
                              WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion 
                              AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno 
                              AND gnral_alumnos.cuenta=exp_generales.no_cuenta
                              AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
                              AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                              AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
                              AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
                              AND exp_asigna_tutor.deleted_at is null 
                              AND exp_asigna_generacion.deleted_at is null 
                              AND exp_asigna_alumnos.deleted_at is null 
                              AND reporte_tutor.baja > 1
                              AND reporte_tutor.id_asigna_generacion='.$request->id_asigna_generacion);

        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->ln(10);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(255, 255, 255);
        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode($etiqueta->descripcion), 0, 1, "C", "true");
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO"), 1, 1, "C", "true");
        $pdf->SetFillColor(97, 182, 35);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("REPORTE SEMESTRAL DE TUTOR"), 0, 1, "C", "true");
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(190, 4, utf8_decode("Nombre del Tutor (a):  ") .utf8_decode($titulo[0]->titulo)." "
            .utf8_decode($titulo[0]->nombre), 1, 0, "L", "true");
        $pdf->ln();
        $pdf->Cell(100, 4, utf8_decode("Programa Educativo:  ") . utf8_decode($carrera[0]->nombre), 1, 0, "L", "true");
        $pdf->Cell(15, 4, utf8_decode("Grupo:  ") . utf8_decode($titulo[0]->grupo), 1, 0, "L", "true");
        $pdf->Cell(48, 4, utf8_decode("Periodo:  ".$periodo->periodo) . utf8_decode(""), 1, 0, "L", "true");
        $pdf->Cell(27, 4, utf8_decode("Fecha:  ") . utf8_decode($fecha[0]->fecha), 1, 0, "L", "true");
        $pdf->ln();
        $pdf->ln();
        $pdf->Cell(7, 12, utf8_decode("No"), 1, 0, "L", "true");
        $pdf->Cell(15, 12, utf8_decode("No.Cuenta"), 1, 0, "L", "true");
        $pdf->Cell(45, 12, utf8_decode("Nombre"), 1, 0, "C", "true");
        $pdf->Cell(123, 4, utf8_decode("ESTUDIANTES ATENDIDOS"), 1, 0, "C", "true");
        $pdf->ln();
        $pdf->Cell(67, 4);
        $pdf->Cell(18, 4, utf8_decode("Tutoria"), 1, 0, "C", "true");
        $pdf->Cell(10, 4, utf8_decode("Con"), 0, 0, "C", "true");
        $pdf->Cell(20, 4, utf8_decode("En curso"), 1, 0, "C", "true");
        $pdf->Cell(35, 4, utf8_decode("Canalizados en el semestre"), 1, 0, "C", "true");
        $pdf->Cell(10, 4, utf8_decode("Baja"), 1, 0, "C", "true");
        $pdf->Cell(30, 4, ("Observaciones"), 1, 0, "C");
        $pdf->ln();
        $pdf->Cell(67, 4);
        $pdf->Cell(10, 4, utf8_decode("Grupal"), 1, 0, "L", "true");
        $pdf->Cell(8, 4, utf8_decode("Indiv"), 1, 0, "L", "true");
        $pdf->Cell(10, 4, "Beca", 0, 0,"C");
        $pdf->Cell(10, 4, utf8_decode("Repet."), 1, 0, "L", "true");
        $pdf->Cell(10, 4, utf8_decode("Espec."), 1, 0, "L", "true");
        $pdf->Cell(11, 4, utf8_decode("Acad."), 1, 0, "L", "true");
        $pdf->Cell(11, 4, utf8_decode("Med."), 1, 0, "L", "true");
        $pdf->Cell(13, 4, utf8_decode("Psicol."), 1, 0, "L", "true");
        $pdf->Cell(10, 4);
        $pdf->Cell(30, 4, "", 1, 0);
        $pdf->ln();
        $pdf->SetDrawColor(010, 010, 010);
        $pdf->SetFont('Arial', 'B', 5);
        for ($i = 0; $i < count($consulta); $i++) {
            $pdf->Cell(7, 4, "" . utf8_decode($i+1), 1, 0, "C");
            $pdf->Cell(15, 4, "" . utf8_decode($consulta[$i]->n_cuenta), 1, 0, "C");
            $pdf->SetFont('Arial', 'B', 5);
            $pdf->Cell(45, 4, utf8_decode(mb_strtoupper($consulta[$i]->appaterno)) . " " . utf8_decode(mb_strtoupper($consulta[$i]->apmaterno)) . " " .utf8_decode(mb_strtoupper($consulta[$i]->alumno)), 1, 0, "L", "true");
            $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->tutoria_grupal), 1, 0, "C");
            $pdf->Cell(8, 4, "" . utf8_decode($consulta[$i]->tutoria_individual), 1, 0, "C");
            if($consulta[$i]->beca==1){
                $pdf->Cell(10, 4, "" . utf8_decode("Si"), 1, 0, "C");
            }
            else{
                $pdf->Cell(10, 4, "" . utf8_decode("No"), 1, 0, "C");
            }

            if($consulta[$i]->repeticion==1){
                $pdf->Cell(10, 4, "" . utf8_decode("Si"), 1, 0, "C");
            }
            else{
                $pdf->Cell(10, 4, "" . utf8_decode("No"), 1, 0, "C");
            }

            if($consulta[$i]->especial==1){
                $pdf->Cell(10, 4, "" . utf8_decode("Si"), 1, 0, "C");
            }
            else{
                $pdf->Cell(10, 4, "" . utf8_decode("No"), 1, 0, "C");
            }

            $pdf->Cell(11, 4, "" . utf8_decode($consulta[$i]->academico), 1, 0, "C");
            $pdf->Cell(11, 4, "" . utf8_decode($consulta[$i]->medico), 1, 0, "C");
            $pdf->Cell(13, 4, "" . utf8_decode($consulta[$i]->psicologico), 1, 0, "C");
            if($consulta[$i]->baja == 1){
                $pdf->Cell(10, 4, "" . utf8_decode("No"), 1, 0, "C");
            }
            if ($consulta[$i]->baja == 2){
                $pdf->Cell(10, 4, "" . utf8_decode("Temporal"), 1, 0, "C");
            }
            if($consulta[$i]->baja == 3){
                $pdf->Cell(10, 4, "" . utf8_decode("Definitiva"), 1, 0, "C");
            }
            $pdf->Cell(30, 4, "" . utf8_decode($consulta[$i]->observaciones), 1, 0, "C");
            $pdf->ln();
        }
        /*Totales*/
        $pdf->Cell(22, 4);
        $pdf->Cell(45, 4, "TOTAL", 1, 0, "L");
        $pdf->Cell(10, 4, utf8_decode($tut_grupal[0]->tutoria_grupal), 1, 0, "C");
        $pdf->Cell(8, 4,  utf8_decode($tut_ind[0]->tutoria_individual), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($bec[0]->beca), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($rep[0]->repeticion), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($esp[0]->especial), 1, 0, "C");
        $pdf->Cell(11, 4, utf8_decode($acad[0]->academico), 1, 0, "C");
        $pdf->Cell(11, 4, utf8_decode($med[0]->medico), 1, 0, "C");
        $pdf->Cell(13, 4, utf8_decode($psi[0]->psicologico), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($baj[0]->baja), 1, 0, "C");
        /*Firmas*/
        $pdf->ln(10);
        $pdf->Cell(45, 4, utf8_decode("ELABORÓ"), 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, utf8_decode("REVISÓ"), 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "Vo. Bo",0,0,"C");
        $pdf->Cell(45, 4, "Vo. Bo", 0, 0, "C");
        $pdf->ln(15);
        $pdf->Cell(45, 4, "________________________________________________", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "________________________________________________", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "________________________________________________", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "________________________________________________", 0, 0, "C");
        $pdf->ln();
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4,utf8_decode($titulo[0]->titulo)." ".utf8_decode($titulo[0]->nombre), 0, 0, "L");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4,utf8_decode($coorcarrera[0]->titulo)." ".utf8_decode($coorcarrera[0]->nombre), 0, 0, "L");
        $pdf->Cell(7, 4);
        $pdf->Cell(45, 4,utf8_decode($jefedivision[0]->titulo)." ".utf8_decode($jefedivision[0]->nombre), 0, 0, "L");
        $pdf->Cell(2, 4);
        $pdf->Cell(45, 4,utf8_decode($coorinst[0]->titulo)." ".utf8_decode($coorinst[0]->nombre), 0, 0, "L");
        $pdf->ln();
        $pdf->Cell(45, 4, "TUTOR", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, utf8_decode("COORDINADOR(A) DE TUTORÍAS CARRERA"), 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, utf8_decode( "JEFE(A) DE DIVISIÓN DE"), 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "COORDINADOR INSTITUCIONAL", 0, 0, "C");
        $pdf->ln();
        $pdf->Cell(45, 4, "", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, utf8_decode(""), 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, utf8_decode($carrera[0]->nombre), 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "", 0, 0, "C");
        $pdf->ln(10);
        $pdf->Output();
        exit();
    }
}