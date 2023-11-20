<?php

namespace App\Http\Controllers;

use App\Tutorias_Canalizacion;
use App\Alumnos;
use App\Tutorias_asigna_tutor;
use App\Tutorias_areas_canalizacion;
use App\Carreras;
use App\Gnral_personales;
use App\Semestres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Times','B',8);
        // Page number
        $this->Cell(0,10,utf8_decode('Página '.$this->PageNo()),0,0,'C');
    }
}

class Tutorias_PdfCitController extends Controller
{
    public function pdf_cita(Request $request)
    {
        $c = DB::select('SELECT exp_asigna_generacion.grupo,gnral_alumnos.id_alumno,UPPER(gnral_alumnos.nombre) as nombre,
            UPPER(gnral_alumnos.apaterno) as apaterno,UPPER(gnral_alumnos.amaterno) as amaterno,gnral_carreras.nombre as carrera,gnral_semestres.descripcion,gnral_personales.nombre as nombre_tut,
            DATE_FORMAT(canalizacion.fecha_canalizacion,"%d-%m-%Y")as fecha_canalizacion,canalizacion.observaciones,
            canalizacion.hora,canalizacion.aspectos_sociologicos1,canalizacion.aspectos_sociologicos2,
            canalizacion.aspectos_sociologicos3,canalizacion.aspectos_academicos1,canalizacion.aspectos_academicos2,
            canalizacion.aspectos_academicos3,canalizacion.otros,canalizacion.status,canalizacion.desc_area,canalizacion.desc_subarea
            FROM exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,gnral_carreras,
            gnral_semestres,gnral_personales,exp_asigna_tutor,canalizacion
            WHERE exp_asigna_generacion.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
            AND gnral_alumnos.id_alumno=exp_asigna_alumnos.id_alumno
            AND gnral_alumnos.id_carrera=gnral_carreras.id_carrera
            AND gnral_alumnos.id_semestre=gnral_semestres.id_semestre
            AND gnral_personales.id_personal=exp_asigna_tutor.id_personal
            AND exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
            AND exp_asigna_alumnos.id_alumno=canalizacion.id_alumno
            AND exp_asigna_alumnos.deleted_at is null
            AND exp_asigna_generacion.deleted_at is null
            AND exp_asigna_tutor.deleted_at is null
            AND exp_asigna_alumnos.id_alumno='.$request->id_alumno);
        $etiqueta=DB::table('etiqueta')
            ->where('id_etiqueta','=',1)
            ->select('etiqueta.descripcion')
            ->get();
        $etiqueta=$etiqueta[0]->descripcion;

        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->ln(10);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode($etiqueta), 0, 1, "C", "true");
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO"), 0, 1, "C", "true");
        $pdf->ln();
        $pdf->SetFillColor(97, 182, 35);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("DATOS DEL ESTUDIANTE"), 0, 1, "C", "true");
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(115, 5, utf8_decode("CARRERA:  "). utf8_decode($c[0]->carrera), 1, 0, "L", "true");
        $pdf->Cell(30, 5, utf8_decode("SEMESTRE:  "). utf8_decode($c[0]->descripcion), 1, 0, "C", "true");
        $pdf->Cell(45, 5, utf8_decode("FECHA CITA:  "). utf8_decode($c[0]->fecha_canalizacion), 1, 0, "C", "true");
        $pdf->ln();
        $pdf->Cell(115, 5, utf8_decode("ESTUDIANTE:  "). utf8_decode(mb_strtoupper($c[0]->apaterno)) . " " . utf8_decode(mb_strtoupper($c[0]->amaterno)) . " " .utf8_decode(mb_strtoupper($c[0]->nombre)), 1, 0, "L", "true");
        $pdf->Cell(30, 5, utf8_decode("GRUPO:  "). utf8_decode($c[0]->grupo), 1, 0, "C", "true");
        $pdf->ln();
        $pdf->Cell(115, 5, utf8_decode("TUTOR:  "). utf8_decode($c[0]->nombre_tut), 1, 0, "L", "true");
        $pdf->Cell(30, 5, utf8_decode("HORA:  "). utf8_decode($c[0]->hora), 1, 0, "C", "true");
        $pdf->SetFillColor(97, 182, 35);
        $pdf->ln();
        $pdf->Cell(190, 5, utf8_decode("OBSERVACIONES"), 1, 0, "C", "true");
        $pdf->ln();
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(95, 5, utf8_decode("Aspectos Sociológicos"), 1, 0, "C", "true");
        $pdf->ln();
        $pdf->Cell(90, 5, utf8_decode("Indisciplina:  "), 1, 0, "L", "true");
        if($c[0]->aspectos_sociologicos1=="Si"){
            $pdf->Cell(5, 5, utf8_decode("*"), 1, 0, "C", "true");
        }
        else{
            $pdf->Cell(5, 5, utf8_decode(""), 1, 0, "C", "true");
        }
        $pdf->ln();
        $pdf->Cell(90, 5, utf8_decode("Problemas de integración:  "), 1, 0, "L", "true");
        if($c[0]->aspectos_sociologicos2=="Si"){
            $pdf->Cell(5, 5, utf8_decode("*"), 1, 0, "C", "true");
        }
        else{
            $pdf->Cell(5, 5, utf8_decode(""), 1, 0, "C", "true");
        }
        $pdf->ln();
        $pdf->Cell(90, 5, utf8_decode("Problemas familiares:  "), 1, 0, "L", "true");
        if($c[0]->aspectos_sociologicos3=="Si"){
            $pdf->Cell(5, 5, utf8_decode("*"), 1, 0, "C", "true");
        }
        else{
            $pdf->Cell(5, 5, utf8_decode(""), 1, 0, "C", "true");
        }
        $pdf->ln();
        $pdf->Cell(95, 5, utf8_decode("Aspectos Académicos"), 1, 0, "C", "true");
        $pdf->ln();
        $pdf->Cell(90, 5, utf8_decode("Dificultades de concentración:  "), 1, 0, "L", "true");
        if($c[0]->aspectos_academicos1=="Si"){
            $pdf->Cell(5, 5, utf8_decode("*"), 1, 0, "C", "true");
        }
        else{
            $pdf->Cell(5, 5, utf8_decode(""), 1, 0, "C", "true");
        }
        $pdf->ln();
        $pdf->Cell(90, 5, utf8_decode("Falta de motivación académica:  "), 1, 0, "L", "true");
        if($c[0]->aspectos_academicos2=="Si"){
            $pdf->Cell(5, 5, utf8_decode("*"), 1, 0, "C", "true");
        }
        else{
            $pdf->Cell(5, 5, utf8_decode(""), 1, 0, "C", "true");
        }
        $pdf->ln();
        $pdf->Cell(90, 5, utf8_decode("Bajo rendimiento académico:  "), 1, 0, "L", "true");
        if($c[0]->aspectos_academicos3=="Si"){
            $pdf->Cell(5, 5, utf8_decode("*"), 1, 0, "C", "true");
        }
        else{
            $pdf->Cell(5, 5, utf8_decode(""), 1, 0, "C", "true");
        }
        $pdf->SetFillColor(97, 182, 35);
        $pdf->ln();
        $pdf->Cell(190, 5, utf8_decode("OBSERVACIONES GENERALES"), 1, 0, "C", "true");
        $pdf->ln();
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(190, 18, utf8_decode($c[0]->observaciones), 1, 0, "L", "true");
        $pdf->SetFillColor(97, 182, 35);
        $pdf->ln();
        $pdf->Cell(190, 5, utf8_decode("OTROS"), 1, 0, "C", "true");
        $pdf->ln();
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(190, 18, utf8_decode($c[0]->otros), 1, 0, "L", "true");
        $pdf->ln();
        $pdf->Cell(63, 5, utf8_decode("Estatus:  "). utf8_decode($c[0]->status), 1, 0, "L", "true");
        $pdf->Cell(63, 5, utf8_decode("Canalizado en:  "). utf8_decode($c[0]->desc_area), 1, 0, "L", "true");
        $pdf->Cell(63, 5, utf8_decode("Subárea:  "). utf8_decode($c[0]->desc_subarea), 1, 0, "L", "true");
        $pdf->Output();
        exit();
    }
}
