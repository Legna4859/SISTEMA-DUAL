<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Auth;

use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
class PDF extends FPDF
{
    //CABECERA DE LA PAGINA
    function Header()
    {
        $this->Image('img/tutorias/edomex.png',10,0,40,20);
        $this->Image('img/tutorias/tecnm.jpg',81,3,30,12);
        $this->Image('img/tutorias/TESVB.png',145,3,28,11);
        $this->Image('img/tutorias/edomex1.png',176,2,30,13);
        $this->Line(175,2.5,175,14);
        $this->SetFont('Times', '', 8);
        $etiqueta=DB::table('etiqueta')
            ->where('id_etiqueta','=',1)
            ->select('etiqueta.descripcion')
            ->get();
        $etiqueta=$etiqueta[0]->descripcion;
        $this->Cell(175,6,utf8_decode($etiqueta),0,4,"C");


    }

    //PIE DE PAGINA
    function Footer()
    {
        $this->SetY(-22);
        $this->SetFont('Arial','B',7);
        $this->Image('img/pie/logos_iso.jpg',40,247,49);
        $this->Ln(1);
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
        $this->Cell(145,-2,utf8_decode('DEPARTAMENTO DE DESARROLLO ACADEMICO'),0,0,'R');
        $this->Cell(280);
        $this->Ln(0);
        $this->SetXY(32,268);
        $this->SetFillColor(120,120,120);
        $this->SetTextColor(255,255,255);
        $this->SetFont('Arial','B',8);
        $this->Cell(173,4,utf8_decode('      Km. 30 de la Carretera Federal Monumento - Valle de Bravo, Ejido de San Antonio de la Laguna,'),0,0,'L',TRUE);
        $this->Ln(3);
        $this->Cell(22);
        $this->SetFont('Arial','B',8);
        $this->Cell(173,4,utf8_decode('      Valle de Bravo, Estado de México, C.P. 51200.'),0,0,'L',TRUE);
        $this->Ln(3);
        $this->Cell(22);
        $this->SetFont('Arial','',8);
        $this->Cell(173,4,utf8_decode('     Tels.:(726)26 6 52 00, 26 6 51 87      des.academico@vbravo.tecnm.mx'),0,0,'L',true);
        $this->Ln(10);
        $this->Image('img/logos/Mesquina.jpg',0,251,34);
    }


}
class Tutorias_PlaneacionPDFController extends Controller
{
    public function index(Request $request)
    {
        return view('profesor.index');
    }

    public function pdf_planeacion(Request $request)
    {




        $carrera=DB::table('gnral_carreras')
            ->select('nombre')
            ->where('id_carrera', '=', $request->id_carrera)
            ->get();
        $profesor=DB::select('SELECT abreviaciones.titulo, gnral_personales.nombre 
                                FROM gnral_personales,abreviaciones,abreviaciones_prof
                                WHERE gnral_personales.id_personal=abreviaciones_prof.id_personal
                                AND abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion
                                AND gnral_personales.tipo_usuario ='.Auth::user()->id);

        $coorcarrera=DB::select('SELECT abreviaciones.titulo,gnral_personales.nombre 
                                        FROM gnral_personales, exp_asigna_coordinador, gnral_jefes_periodos, gnral_carreras,
                                             abreviaciones,abreviaciones_prof
                                        WHERE gnral_personales.id_personal=abreviaciones_prof.id_personal
                                         AND abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion
                                         AND exp_asigna_coordinador.id_personal=gnral_personales.id_personal
                                         AND exp_asigna_coordinador.id_jefe_periodo=gnral_jefes_periodos.id_jefe_periodo
                                         AND gnral_jefes_periodos.id_carrera=gnral_carreras.id_carrera
                                         AND exp_asigna_coordinador.deleted_at is null
                                         AND gnral_jefes_periodos.id_carrera= '.$request->id_carrera.'
                                        AND  gnral_jefes_periodos.id_periodo='.Session::get('periodo_actual'));
        // dd($coorcarrera);

        $jefedivision=DB::select('SELECT gnral_personales.nombre,abreviaciones.titulo FROM gnral_personales, exp_asigna_coordinador, 
                                    gnral_jefes_periodos, gnral_carreras,abreviaciones_prof,abreviaciones
                                        WHERE gnral_jefes_periodos.id_personal=gnral_personales.id_personal
                                        and gnral_jefes_periodos.id_jefe_periodo=exp_asigna_coordinador.id_jefe_periodo
                                        and gnral_jefes_periodos.id_carrera=gnral_carreras.id_carrera
                                        and abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion
                                        and gnral_personales.id_personal=abreviaciones_prof.id_personal
                                        and exp_asigna_coordinador.deleted_at is null
                                        AND gnral_jefes_periodos.id_carrera='.$request->id_carrera);

        $desarrollo=DB::select('SELECT abreviaciones.titulo,gnral_personales.nombre FROM 
                                        gnral_personales, gnral_departamentos, abreviaciones, abreviaciones_prof
                                        WHERE gnral_departamentos.id_departamento=4
                                        AND gnral_personales.id_departamento=gnral_departamentos.id_departamento
                                        AND abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion
                                        AND abreviaciones_prof.id_personal=gnral_personales.id_personal');
/*
        $consulta=DB::select('SELECT plan_actividades.desc_actividad,plan_actividades.objetivo_actividad,plan_actividades.fi_actividad,
                    plan_actividades.ff_actividad, plan_asigna_planeacion_tutor.estrategia,plan_asigna_planeacion_tutor.id_asigna_planeacion_tutor, exp_asigna_tutor.id_asigna_tutor, exp_asigna_tutor.id_asigna_generacion
                    FROM plan_actividades, plan_asigna_planeacion_tutor,plan_asigna_planeacion_actividad,exp_asigna_generacion,exp_asigna_tutor
                    WHERE plan_asigna_planeacion_actividad.id_plan_actividad=plan_actividades.id_plan_actividad
                   
                    AND plan_asigna_planeacion_tutor.id_asigna_planeacion_actividad=plan_asigna_planeacion_actividad.id_asigna_planeacion_actividad
                   
                    AND exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
                    AND exp_asigna_tutor.id_asigna_generacion=plan_asigna_planeacion_tutor.id_asigna_generacion
                    AND exp_asigna_tutor.deleted_at IS null
                    AND exp_asigna_tutor.id_asigna_generacion='.$request->id_asigna_generacion.'
                    AND plan_actividades.deleted_at IS null');

*/
        $perio=DB::select('SELECT periodo from gnral_periodos where id_periodo='.Session::get('periodo_actual').'');
        $consulta=DB::select('SELECT plan_actividades.desc_actividad,plan_actividades.objetivo_actividad,
       plan_actividades.fi_actividad, plan_actividades.ff_actividad, plan_asigna_planeacion_tutor.estrategia,
       plan_asigna_planeacion_tutor.id_asigna_planeacion_tutor, exp_asigna_tutor.id_asigna_tutor, 
       exp_asigna_tutor.id_asigna_generacion FROM plan_actividades, plan_asigna_planeacion_tutor,
                                                  exp_asigna_generacion,exp_asigna_tutor WHERE
        plan_asigna_planeacion_tutor.id_plan_actividad=plan_actividades.id_plan_actividad AND 
        exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion AND
            exp_asigna_tutor.id_asigna_generacion=plan_asigna_planeacion_tutor.id_asigna_generacion
            AND exp_asigna_tutor.deleted_at IS null AND exp_asigna_tutor.id_asigna_generacion='.$request->id_asigna_generacion.'
            AND plan_actividades.deleted_at IS null and plan_asigna_planeacion_tutor.boton=1 ORDER by plan_actividades.fi_actividad asc,plan_actividades.ff_actividad asc');

        //$pdf= new \Codedge\Fpdf\Fpdf\Fpdf();
        // $pdf->AddPage();

        $pdf=new PDF($orientation='P',$unit='mm',$format='Letter');
        $pdfaux=new PDF($orientation='P',$unit='mm',$format='Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(10, 25 , 10);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();

        //SetFont('Helvetica','I',13);

        $pdf->SetFont('Times', 'B', 10);
        $pdf->SetFillColor(192,192,192);
        $pdf->Ln(1);
        $pdf->Cell(($pdf->GetPageWidth()-20),6,"".utf8_decode("PLAN DE ACCIÓN TUTORIAL"),0,4,"C","true");
        $pdf->Ln(1);
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(($pdf->GetPageWidth()-20),3,"CARRERA:  ". utf8_decode(mb_strtoupper($carrera[0]->nombre)),0,0,"L");
        $pdf->Ln(3);
        $pdf->Cell(($pdf->GetPageWidth()-20)/3,3,"COORDINADOR:  ".utf8_decode(mb_strtoupper($coorcarrera[0]->titulo))." "
            . utf8_decode(mb_strtoupper($coorcarrera[0]->nombre)),0,0,"L");
        $pdf->Cell(($pdf->GetPageWidth()-20)/3,3,"". utf8_decode(""),0,0,"L");
        $pdf->SetFillColor(192,192,192);
        $pdf->Cell(($pdf->GetPageWidth()-151)/1,4,"".utf8_decode($request->generacion),0,1,"C","true");
        $pdf->Ln(0);


        $pdf->Cell(($pdf->GetPageWidth()-20)/2,3,"TUTOR:  ". utf8_decode(mb_strtoupper($profesor[0]->titulo))." "
            . utf8_decode(mb_strtoupper($profesor[0]->nombre)),0,0,"L");
        $pdf->Cell(($pdf->GetPageWidth()-20)/2,3,"PERIODO: ". utf8_decode(mb_strtoupper($perio[0]->periodo)),0,0,"C");
        $pdf->ln(7);
        $np=0;
        $pdf->SetFont('Times', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode("FECHA"), 1, 0, "C", "true");
        $pdf->Cell(10, 4, utf8_decode("SESIÓN"), "LTR", 0, "C", "true");
        $pdf->Cell(40, 4, utf8_decode("ACTIVIDADES"), "LTR", 0, "C", "true");
        $pdf->Cell(60, 4, utf8_decode("OBJETIVO"), "LTR", 0, "C", "true");
        $pdf->Cell(60, 4, utf8_decode("ESTRATEGIAS"), "LTR", 0, "C", "true");
        $pdf->ln(4);

        $pdf->Cell(15, 4, utf8_decode("INICIO"), 1, 0, "C", "true");
        $pdf->Cell(15, 4, utf8_decode("FIN"), 1, 0, "C", "true");
        $pdf->Cell(10, 4, utf8_decode(""), "LRB", 0, "C", "true");
        $pdf->Cell(40, 4, utf8_decode(""), "LRB", 0, "C", "true");
        $pdf->Cell(60, 4, utf8_decode(""), "LRB", 0, "C", "true");
        $pdf->Cell(60, 4, utf8_decode(""), "LRB", 0, "C", "true");
        $star=$pdf->GetX();
        $current_x=$pdf->GetX();
        $current_y=$pdf->GetY();

        $pdf->ln();
        foreach ($consulta as $dat)
        {

            $x = (int)($pdf->GetStringWidth(utf8_decode(mb_strtoupper($dat->desc_actividad))) / 40) + 2;
            $y = (int)($pdf->GetStringWidth(utf8_decode(mb_strtoupper($dat->objetivo_actividad))) / 60) + 2;
            $z = (int)($pdf->GetStringWidth(utf8_decode(mb_strtoupper($dat->estrategia))) / 60) + 2;

            $height = max($x, $y, $z) * 5;


            $pdf->SetFont('Times', 'B', 7);

            $pdf->Cell(15, $height, "" . utf8_decode(mb_strtoupper($dat->fi_actividad)), 1, 0, "C");
            $pdf->Cell(15, $height, "" . utf8_decode(mb_strtoupper($dat->ff_actividad)), 1, 0, "C");

            //valor de celda
            // $long=$pdf->GetStringWidth(utf8_decode(mb_strtoupper($dat->objetivo_actividad)));

            $pdf->Cell(10, $height, " " . utf8_decode(mb_strtoupper($np = 0 ? $np = 0 : $np = $np + 1)), 1, 0, "C");
            $x = $pdf->GetX();
            $y = $pdf->GetY();

            $pdf->Cell(40, $height, " ", 1, 0, "C");
            $pdf->SetXY($x, $y);
            $pdf->MultiCell(40, 4, "" . utf8_decode(mb_strtoupper($dat->desc_actividad)), 0, "L");
            $pdf->SetXY($x + 40, $y);
            $pdf->Cell(60, $height, " ", 1, 0, "C");
            $pdf->SetXY($x + 40, $y);
            $pdf->MultiCell(60, 4, "" . utf8_decode(mb_strtoupper($dat->objetivo_actividad)), 0, "L");
            $pdf->SetXY($x + 100, $y);
            $pdf->Cell(60, $height, " ", 1, 0, "C");
            $pdf->SetXY($x + 100, $y);

            $pdf->MultiCell(60, 4, "" . utf8_decode(mb_strtoupper($dat->estrategia)), 0, "L");
            // $pdf->ln();
            $pdf->SetXY(10, $y + $height);


            // $pdf->MultiCell(60,4,"". utf8_decode(mb_strtoupper($dat->objetivo_actividad)),0,"L");

            //dd($pdf->GetStringWidth(utf8_decode(mb_strtoupper($dat->objetivo_actividad))));
            // $pdf->MultiCell(60,4,"". utf8_decode(mb_strtoupper($dat->estrategia)),1,"L");
        }


        //$pdf->Cell(0,100,utf8_decode('Página '.$pdf->PageNo()),0,0,'R');
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Ln(30);
        $y=$pdf->GetY();

        $pdf->SetXY(10,$y);

        $pdf->Cell(($pdf->GetPageWidth()/2-20),7,"". utf8_decode(mb_strtoupper($jefedivision[0]->titulo))." ".
            utf8_decode(mb_strtoupper($jefedivision[0]->nombre)),0,0,"C");
        $pdf->Cell(($pdf->GetPageWidth()/2-20),6,"". utf8_decode(mb_strtoupper($desarrollo[0]->titulo))." ".
            utf8_decode(mb_strtoupper($desarrollo[0]->nombre)),0,1,"C");
        $pdf->Cell(($pdf->GetPageWidth()/2-20),3,"". utf8_decode(mb_strtoupper("___________________________________")),0,0,"C");
        $pdf->Cell(($pdf->GetPageWidth()/2-20),3,"". utf8_decode(mb_strtoupper("___________________________________")),0,1,"C");
        $pdf->Cell(($pdf->GetPageWidth()/2-20),3,"".utf8_decode("JEFE(A) DE DIVISIÓN  DE "),0,0,"C");
        $jefe_academico=DB::selectOne('SELECT * FROM `gnral_unidad_administrativa` WHERE `id_unidad_admin` = 27 ');
        $pdf->Cell(($pdf->GetPageWidth())/2-20,3,"".utf8_decode($jefe_academico->jefe_descripcion),0,1,"C");

        $pdf->Cell(($pdf->GetPageWidth()/2-20),3,"".utf8_decode($carrera[0]->nombre),0,1,"C");


        // $pdf->Output();
        $pdf->AliasNbPages();
        $pdf->Output();
        exit();

    }

}



