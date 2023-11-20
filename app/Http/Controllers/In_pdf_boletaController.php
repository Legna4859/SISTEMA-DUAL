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
        $this->SetFont('Arial','',8);
        $this->Ln(0);
        
        $this->Image('img/ingles/coordinacion_ingles.png',75,6,135);

        $this->Ln(35);

    }

    //PIE DE PAGINA
    function Footer()
    {
        $this->SetY(-20);
        $this->SetFont('Arial', '', 5.5);
    }

}


class In_pdf_boletaController extends Controller
{
    public function index ($id_alumno)
    {
        $periodo_ingles=Session::get('periodo_ingles');
        $resultado_promedio = 0;
        $alumno = DB::selectOne('SELECT * FROM `gnral_alumnos` WHERE id_alumno = '.$id_alumno.'');
        //dd($alumno);
        $nombre_carrera = DB::selectOne('SELECT * FROM `gnral_carreras` WHERE gnral_carreras.id_carrera = '.$alumno->id_carrera.'');
        $periodo = DB::selectOne('SELECT * FROM in_periodos WHERE id_periodo_ingles='.$periodo_ingles.'');
        $today = date("d-m-Y");
        $nivel = DB::selectOne('SELECT in_niveles_ingles.descripcion, in_carga_academica_ingles.id_grupo 
            FROM in_niveles_ingles, in_carga_academica_ingles WHERE in_carga_academica_ingles.id_nivel = in_niveles_ingles.id_niveles_ingles
            AND in_carga_academica_ingles.id_alumno = '.$id_alumno.' 
            AND in_carga_academica_ingles.id_periodo_ingles = '.$periodo_ingles.'');
         $ver_estado_cal = 
                DB::select('SELECT in_evaluar_calificacion.* 
                    FROM in_evaluar_calificacion, in_carga_academica_ingles 
                    WHERE in_carga_academica_ingles.id_alumno = '.$id_alumno.' 
                    AND in_carga_academica_ingles.id_carga_ingles = in_evaluar_calificacion.id_carga_ingles 
                    AND in_carga_academica_ingles.id_periodo_ingles = '.$periodo_ingles.'');  
        $tipo_curso = DB::selectOne('SELECT eva_tipo_curso.nombre_curso from
                 in_carga_academica_ingles,eva_tipo_curso
                where in_carga_academica_ingles.estado_nivel=eva_tipo_curso.id_tipo_curso 
                and in_carga_academica_ingles.id_alumno=' .$alumno->id_alumno . ' 
                and in_carga_academica_ingles.id_periodo_ingles=' .$periodo_ingles. '') ;        

        $pdf=new PDF($orientation='L',$unit='mm',$format='Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(20, 25 , 20);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();
        $pdf->Ln(1);
        $pdf->SetFillColor(166,166,166);
        $pdf->SetFont('Arial','B','10');
        $pdf->Cell(230,-12,utf8_decode('TecNM-SEV-DVIA-PCLE-12/17-TESVB-63'),0,0,'R');
        $pdf->Ln(1);
        $pdf->Cell(230,5, utf8_decode('NOMBRE:'.$alumno->nombre.' '.$alumno->apaterno.' '.$alumno->amaterno), 1, 1, 'L');
        $pdf->Cell(50,5, utf8_decode('Nº DE CTA.:'.$alumno->cuenta), 1, 0, 'L');
        $pdf->Cell(180,5, utf8_decode('PROGRAMA ACADÉMICO:'.$nombre_carrera->nombre), 1, 1, 'L');
        $pdf->Cell(115,5, utf8_decode('PERIODO: '.$periodo->periodo_ingles), 1, 0, 'L');
        $pdf->Cell(115,5, utf8_decode('FECHA: '.$today), 1, 1, 'L');
        $pdf->Cell(115,5, utf8_decode('NIVEL: '.$nivel->descripcion), 1, 0, 'L');
        $pdf->Cell(115,5, utf8_decode('GRUPO: '.$nivel->id_grupo), 1, 1, 'L');
        $pdf->Cell(115,5,utf8_decode('STATUS DEL USUARIO:'),1,0,'C',true);
        $pdf->Cell(115,5,utf8_decode($tipo_curso->nombre_curso),1,1,'L');
        $pdf->Ln(5);
        $pdf->Cell(115,5, utf8_decode('SKILLS'), 1, 0, 'C');
        $pdf->Cell(115,5, utf8_decode('GRADE'), 1, 1, 'C');

        foreach ($ver_estado_cal as $ver_estado_calicacion) 
        {
            $resultado_promedio = $resultado_promedio + $ver_estado_calicacion->calificacion;
           if ($ver_estado_calicacion->id_unidad == 1) 
            {
                $pdf->Cell(115,5, utf8_decode('SPEAKING'),1,0,'R');
                 if ($ver_estado_calicacion->calificacion<80) 
            {
               $pdf->Cell(115,5, utf8_decode(''.$ver_estado_calicacion->calificacion),1,1,'C');
            }
            
            else 
            {
                $pdf->Cell(115,5, utf8_decode(''.$ver_estado_calicacion->calificacion),1,1,'C'); 
            }
            
            }
           
            if ($ver_estado_calicacion->id_unidad == 2) 
            {
              $pdf->Cell(115,5, utf8_decode('WRITING'),1,0,'R');
            if ($ver_estado_calicacion->calificacion<80) 
            {
               $pdf->Cell(115,5, utf8_decode(''.$ver_estado_calicacion->calificacion),1,1,'C');
            }
            
            else 
            {
                $pdf->Cell(115,5, utf8_decode(''.$ver_estado_calicacion->calificacion),1,1,'C'); 
            }
            
            }
            if ($ver_estado_calicacion->id_unidad == 3) 
            {
                $pdf->Cell(115,5, utf8_decode('READING'),1,0,'R');
                if ($ver_estado_calicacion->calificacion<80) 
            {
               $pdf->Cell(115,5, utf8_decode(''.$ver_estado_calicacion->calificacion),1,1,'C');
            }
            
            else 
            {
                $pdf->Cell(115,5, utf8_decode(''.$ver_estado_calicacion->calificacion),1,1,'C'); 
            }
            }
            if ($ver_estado_calicacion->id_unidad == 4) 
            {
                $pdf->Cell(115,5, utf8_decode('LISTENING'),1,0,'R');

                if ($ver_estado_calicacion->calificacion<80) 
            {
               $pdf->Cell(115,5, utf8_decode(''.$ver_estado_calicacion->calificacion),1,1,'C');
            }
            
            else 
            {
                $pdf->Cell(115,5, utf8_decode(''.$ver_estado_calicacion->calificacion),1,1,'C'); 
            }
            }
            
        }
        $pdf->Cell(115,5, utf8_decode('PROMEDIO GENERAL'),1,0,'R');
        $pdf->Cell(115,5, utf8_decode(round($resultado_promedio/4)),1,1,'C');

        $pdf->SetFont('Arial','B',14);
        $pdf->Text(15,180,utf8_decode('¡¡¡Este documento tiene validez unicamente para trámites dentro de la Coordinación de Lenguas Extranjeras'));
        $pdf->Text(75,185,utf8_decode('del Tecnológico De Estudios Superiores de Valle de Bravo!!!'));

        $pdf->Output();

        exit();
    }
}
