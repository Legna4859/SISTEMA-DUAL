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
        $this->Image('img/logo3.PNG', 190, 15, 85);
        $this->Image('img/gem.png',7,10,32);
        $this->Ln(10);
    }
    //PIE DE PAGINA
    function Footer()
    {

        $this->SetY(-25);
        $this->SetFont('Arial','',8);
        // $this->Image('img/sgc.PNG',40,183,20);
        $this->Image('img/pie/logos_iso.jpg',35,183,55);
        //  $this->Image('img/sga.PNG',65,183,20);
        $this->Cell(100);
        $this->Cell(167,-2,utf8_decode('FO-TESVB-39  V.1  14-08-2019'),0,0,'R');
        $this->Ln(3);
        $this->Cell(100);
        $this->Cell(167,-2,utf8_decode('SECRETARÍA DE EDUCACIÓN'),0,0,'R');
        $this->Ln(3);
        $this->Cell(100);
        $this->Cell(167,-2,utf8_decode('SUBSECRETARÍA DE EDUCACIÓN SUPERIOR Y NORMAL'),0,0,'R');
        $this->Ln(3);
        $this->Cell(100);
        $this->Cell(167,-2,utf8_decode('TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO'),0,0,'R');
        $this->Ln(3);
        $this->Cell(100);
        $this->Cell(167,-2,utf8_decode('SUBDIRECCIÓN DE SERVICIOS ESCOLARES'),0,0,'R');
        $this->Cell(280);
        $this->SetMargins(0,0,0);
        $this->Ln(0);
        $this->SetXY(30,204);
        $this->SetFillColor(120,120,120);
        $this->Cell(20,10,'',0,0,'',TRUE);
        $this->SetTextColor(255,255,255);
        $this->Cell(297,10,utf8_decode('Km. 30 de la Carretera Federal Monumento - Valle de Bravo, Ejido de San Antonio de la Laguna,'),0,0,'L',TRUE);
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(160,10,utf8_decode(' Valle de Bravo, Estado de México, C.P. 51200.    Tels.: (726)26 6 52 00, 26 6 50 77,26 6 51 87 Ext 115                             sub.escolares@vbravo.tecnm.mx'),0,0,'L');

        $this->Image('img/logos/Mesquina.jpg',0,190,30);
    }

}


class Dual_PDF_Carga_Academica extends Controller
{
    public function index()
    {
        $id_usuario = Session::get('usuario_alumno');
        $periodo=Session::get('periodo_actual');

        $pdf=new PDF($orientation='L',$unit='mm',$format='Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:

        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');
        $pdf->SetMargins(10, 20 , 0);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();
        $pdf->SetFont('Arial','','11');
        $pdf->Cell(80);
        $pdf->Cell(100,10,utf8_decode($etiqueta->descripcion),0,1,'C');
        $pdf->Ln(1);
        $pdf->SetFont('Arial','B',13);
        $pdf->Cell(80);
        $pdf->Cell(100,5,utf8_decode('Carga Académica'),0,1,'C');
        $pdf->Ln(8);

        $pdf->SetFont('Arial','B',10);

        $pdf->SetDrawColor(0,0,0);
        $pdf->SetLineWidth(0.5);
        $pdf->SetFillColor(166,166,166);


        $datosalumno=DB::selectOne('select * FROM `gnral_alumnos` WHERE id_usuario='.$id_usuario.'');
        $id_usuario=$datosalumno->id_alumno;
        $datosalumno=DB::selectOne('select * FROM `gnral_alumnos` WHERE id_alumno='.$id_usuario.'');
        $carreralumno=DB::selectOne('select gnral_carreras.nombre from gnral_carreras where id_carrera='.$datosalumno->id_carrera.'');
        $periodoc=DB::selectOne('select gnral_periodos.periodo from gnral_periodos where id_periodo='.$periodo.'');
        $pdf->Cell(31,5,"CICLO ESCOLAR",1,'R',1,true);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(60,5,$periodoc->periodo,1);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(50,5,utf8_decode("PROGRAMA ACADÉMICO"),1,'R',0,true);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(120,5,utf8_decode($carreralumno->nombre),1);
        $pdf->Ln();
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(31,5,"No. DE CUENTA ",1,'R',0,true);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(60,5,$datosalumno->cuenta,1);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(50,5,"NOMBRE DEL ESTUDIANTE",1,'R',0,true);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(120,5,utf8_decode($datosalumno->nombre." ".$datosalumno->apaterno." ".$datosalumno->amaterno),1);
        $pdf->SetFont('Arial','B',10);
        $pdf->Ln(10);
        /////////////////////////////////////////////////datos
        $pdf->SetLineWidth(0.3);
        $pdf->SetY(70); /* Inicio */
        $pdf->MultiCell(30,5,utf8_decode("CLAVE DE LA MATERIA"),1,'L',true);
        $pdf->SetXY(40,70);
        $pdf->Cell(130,10,"NOMBRE DE LA MATERIA",1,0,'C',true);
        $pdf->Cell(24,10,"CREDITOS",1,0,'C',true);
        $pdf->SetXY(194,70);
        $pdf->MultiCell(31,5,utf8_decode("STATUS DE LA MATERIA"),1,'C',true);
        $pdf->SetXY(225,70);
        $pdf->Cell(25,10,"TIPO CURSO",1,0,'C',true);
        $pdf->Cell(20,10,"GRUPO",1,0,'C',true);

        //////////////////////////////////////////////////////
        //   $pdf->Ln();

        ////////////////////////////////////////consulta


        $consulta=DB::select('select eva_carga_academica.id_carga_academica,gnral_materias.id_materia,gnral_materias.clave,gnral_materias.nombre,gnral_materias.id_semestre,gnral_materias.creditos,eva_status_materia.nombre_status,eva_tipo_curso.nombre_curso,eva_carga_academica.grupo
                                from
                                gnral_materias,eva_status_materia,eva_tipo_curso,gnral_grupos,eva_carga_academica,gnral_periodos,gnral_alumnos
                                where eva_carga_academica.id_materia=gnral_materias.id_materia
                                and eva_carga_academica.id_status_materia=eva_status_materia.id_status_materia
                                and eva_carga_academica.id_tipo_curso=eva_tipo_curso.id_tipo_curso
                                and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
                                and eva_carga_academica.grupo=gnral_grupos.id_grupo
                                and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                                and gnral_periodos.id_periodo='.$periodo.'
                                and eva_carga_academica.id_alumno='.$id_usuario.'');
        //dd($consulta);

        $suma=0;
        $suma_materias=0;
        $mater=0;
        foreach ($consulta as $cons){
            $mater ++;
            if($cons->id_materia != 2258) {
                $suma = $suma + $cons->creditos;
                $suma_materias++;
            }
        }
        /*
          $suma=DB::selectOne('select sum(gnral_materias.creditos)suma
                              from gnral_materias,eva_status_materia,eva_tipo_curso,gnral_grupos,eva_carga_academica,gnral_periodos,gnral_alumnos
                              where eva_carga_academica.id_materia=gnral_materias.id_materia
                              and eva_carga_academica.id_status_materia=eva_status_materia.id_status_materia
                              and eva_carga_academica.id_tipo_curso=eva_tipo_curso.id_tipo_curso
                              and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
                              and eva_carga_academica.grupo=gnral_grupos.id_grupo
                              and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                              and gnral_periodos.id_periodo='.$periodo.'
                              and eva_carga_academica.id_alumno='.$id_usuario.'');

          $suma=$suma->suma;

  */
        $pdf->SetFont('Arial','',9);
        $uno=80;

        foreach ($consulta as $consulta)
        {
            $txt=$consulta->nombre;
            $height = 1;
            $strlen = strlen($txt);
            $wdth = 0;
            for ($i = 0; $i <= $strlen; $i++) {
                $char = substr($txt, $i, 1);
                $wdth += $pdf->GetStringWidth($char);
                if($char == "\n"){
                    $height++;
                    $wdth = 0;
                }
                if($wdth >= 132){
                    $height++;
                    $wdth = 0;
                }
            }
            $contar_linea_nombre=$height*5;
            $pdf->SetY($uno);
            $pdf->Cell(30,($contar_linea_nombre),utf8_decode($consulta->clave),1,0,'C');
            $pdf->SetXY(40,$uno);
            $pdf->MultiCell(130,5,utf8_decode($consulta->nombre),1, 'L');
            $pdf->SetXY(170,$uno);
            if($consulta->id_materia == 2258){
                $pdf->Cell(24, ($contar_linea_nombre), utf8_decode(""), 1, 0, 'C');
            }else {
                $pdf->Cell(24, ($contar_linea_nombre), utf8_decode($consulta->creditos), 1, 0, 'C');
            }
            $pdf->Cell(31,($contar_linea_nombre),utf8_decode($consulta->nombre_status),1,0,'C');
            $pdf->Cell(25,($contar_linea_nombre),utf8_decode($consulta->nombre_curso),1,0,'C');
            if($consulta->id_materia == 2258){
                $pdf->Cell(20, ($contar_linea_nombre), utf8_decode(" "), 1, 1, 'C');
            }else {
                $pdf->Cell(20, ($contar_linea_nombre), utf8_decode($consulta->id_semestre . "0" . $consulta->grupo), 1, 1, 'C');
            }
            $uno+=$contar_linea_nombre;
        }



        $pdf->Cell(55,5,"",0);
        $pdf->Cell(105,5,"TOTAL DE CREDITOS",0,'R',0,false);
        $pdf->Cell(24,5,$suma,1,0,'C');

        $pdf->SetFillColor(230,230,230);
        $pdf->Rect(40,158, 100,25,"DF");
        $pdf->Line(60, 175, 120, 175);
        $pdf->Rect(145,158, 100,25,"DF");
        $pdf->Line(165, 175, 225, 175);

        $pdf->Text(82,180,"ESTUDIANTE");

        $pdf->Text(160,180,utf8_decode("SUBDIRECCIÓN DE SERVICIOS ESCOLARES"));

        $pdf->SetFont('Arial','B',10);
        $pdf->Text(186,162,"AUTORIZO");
        $pdf->Text(83,162,"ELABORO");
        $pdf->Output();
        exit();
    }
    public function create()
    {

    }
    public function store(Request $request)
    {

    }
    public function show($id)
    {

    }
    public function edit()
    {


    }
    public function update(Request $request, $id)
    {

    }
    public function destroy($id)
    {

    }


}
