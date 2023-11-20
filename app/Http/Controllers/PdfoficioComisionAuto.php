<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
class PDF extends FPDF
{

    //CABECERA DE LA PAGINA
    function Header()
    {
        if (count($this->pages) === 1) {
            $this->Image('img/logo3.PNG', 120, 5, 80);
            $this->Image('img/edom.png', 20, 5, 50);
            $this->Ln();
        }
    }
    //PIE DE PAGINA
    function Footer()
    {
        if (count($this->pages) === 1) {
            $this->SetY(-35);
            $this->SetFont('Arial','',8);
            $this->Image('img/pie/logos_iso.jpg',40,237,60);
            // $this->Image('img/sgc.PNG',40,240,20);
            // $this->Image('img/tutorias/cir.jpg',89,239,20);
            //  $this->Image('img/sga.PNG',65,240,20);
            $this->Cell(50);
            $this->Cell(145,-2,utf8_decode(''),0,0,'R');
            $this->Ln(3);
            $this->SetFont('Arial','B',8);

            $this->Ln(5);
            $this->Cell(50);
            $this->Cell(135,-2,utf8_decode('SUBSECRETARÍA DE EDUCACIÓN SUPERIOR Y NORMAL'),0,0,'R');
            $this->Ln(3);
            $this->Cell(50);
            $this->Cell(135,-2,utf8_decode('TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO'),0,0,'R');
            $this->Ln(3);
            $this->Cell(50);
            $this->Cell(135,-2,utf8_decode('DEPARTAMENTO DE ADMINISTRACIÓN DE PERSONAL'),0,0,'R');
            $this->Ln(0);
            $this->SetXY(40,260);
            $this->SetFillColor(120,120,120);
            $this->SetTextColor(255,255,255);
            $this->SetFont('Arial','B',8);
            $this->Cell(165,6,utf8_decode('      Km. 30 de la Carretera Federal Monumento - Valle de Bravo, Ejido de San Antonio de la Laguna,'),0,0,'L',TRUE);
            $this->Ln(5);
            $this->Cell(20);
            $this->SetFont('Arial','B',8);
            $this->Cell(165,4,utf8_decode('      Valle de Bravo, Estado de México, C.P. 51200.'),0,0,'L',TRUE);
            $this->Ln(3);
            $this->Cell(20);
            $this->SetFont('Arial','',8);
            $this->Cell(165,4,utf8_decode('      Tels.:(726)266 51 87 Ext 141      personal@vbravo.tecnm.mx'),0,0,'L',true);

            $this->Image('img/logos/Mesquina.jpg',0,240,40);
        }
    }

}

class PdfoficioComisionAuto extends Controller
{
    public function index($id_oficio)
    {
        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');
        $jefe_division=session()->has('jefe_division')?session()->has('jefe_division'):false;
        $jefe_personal=session()->has('personal')?session()->has('personal'):false;
        $carrera = Session::get('carrera');
        $id_usuario = Session::get('usuario_alumno');
        $id_periodo = Session::get('periodotrabaja');
        $pdf=new PDF($orientation='P',$unit='mm',$format='Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(20, 25 , 20);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetLineWidth(0.2);
        $pdf->SetFont('Arial','','8');
        $pdf->Cell(40);
        $pdf->Cell(100,5,utf8_decode($etiqueta->descripcion),0,0,'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','11');
        $pdf->Cell(80);
        $pdf->Cell(20,5,utf8_decode('OFICIO DE COMISIÓN'),0,0,'C');
        $pdf->Ln(1);
        $pdf->SetFont('Arial','','8');
        $pdf->Cell(130);
        $pdf->Cell(20,4,utf8_decode('Valle de Bravo, Estado de México;'),0,0,'L');
        $oficios=DB::selectOne('SELECT oc_oficio.id_oficio,oc_oficio_personal.no_oficio numero,oc_oficio.desc_comision,
oc_oficio.fecha_salida,oc_oficio.fecha_regreso,oc_oficio.hora_s,oc_oficio.hora_r,oc_oficio_personal.viaticos 
from oc_oficio,oc_oficio_personal WHERE oc_oficio.id_oficio=oc_oficio_personal.id_oficio and oc_oficio_personal.id_oficio_personal='.$id_oficio.'');
        $numero=($oficios->numero);
        $contar_estado=DB::selectOne('SELECT COUNT(id_depend_domicilio) dep FROM oc_depend_domicilio WHERE id_oficio ='.$oficios->id_oficio.'');
        $contar_estado=$contar_estado->dep;
        $dependencias=DB::select('SELECT oc_depend_domicilio.*,gnral_municipios.nombre_municipio,gnral_estados.nombre_estado,gnral_estados.id_estado 
       FROM oc_depend_domicilio,gnral_municipios,gnral_estados 
WHERE oc_depend_domicilio.id_municipio=gnral_municipios.id_municipio 
and gnral_municipios.id_estado=gnral_estados.id_estado and oc_depend_domicilio.id_oficio = '.$oficios->id_oficio.' ORDER BY id_depend_domicilio ASC');
        /////////////////////****un estado
        if($contar_estado ==1)
        {
            $municipio=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
            $estado=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_estado, MB_CASE_TITLE), "UTF-8");
            if($dependencias[0]->id_estado==9)
            {
                $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio.', '.$estado.'.');

                $ciudad=('la '.$estado.'.');
            }
            else{
                $ciudad=($municipio.', Estado de '.$estado.'.');
                $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio.', Estado de '.$estado.'.');

            }

        }
        ///////////////////////////////////////////////////*** dos estados++++++++++++++
        if($contar_estado ==2)
        {
            if($dependencias[0]->id_estado == $dependencias[1]->id_estado ){

                if( $dependencias[0]->id_municipio == $dependencias[1]->id_municipio){

                    $municipio=mb_convert_encoding(mb_convert_case($dependencias[1]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                    $estado=mb_convert_encoding(mb_convert_case($dependencias[1]->nombre_estado, MB_CASE_TITLE), "UTF-8");
                    if($dependencias[0]->id_estado==9)
                    {
                        $ciudad=('la '.$estado.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio.', '.$estado.'.');

                    }
                    else{
                        $ciudad=($municipio.', Estado de '.$estado.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio.', Estado de'.$estado.'.');

                    }

                }
                else{

                    $municipio1=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                    $municipio2=mb_convert_encoding(mb_convert_case($dependencias[1]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                    $municipio=($municipio1.' y '.$municipio2);
                    $estado=mb_convert_encoding(mb_convert_case($dependencias[1]->nombre_estado, MB_CASE_TITLE), "UTF-8");


                    if($dependencias[0]->id_estado==9)
                    {
                        $ciudad=('la '.$estado.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio1.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio2.', '.$estado.'.');

                    }
                    else{
                        $ciudad=($municipio.', Estado de '.$estado.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio1.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio2.', Estado de '.$estado.'.');

                    }
                }
            }
            else{
                $municipio1=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                $estado1=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_estado, MB_CASE_TITLE), "UTF-8");
                $municipio2=mb_convert_encoding(mb_convert_case($dependencias[1]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                $estado2=mb_convert_encoding(mb_convert_case($dependencias[1]->nombre_estado, MB_CASE_TITLE), "UTF-8");

                if($dependencias[0]->id_estado==9 and $dependencias[1]->id_estado != 9)
                {
                    $ciudad=('la '.$estado1.' y en '.$municipio2.', Estado de '.$estado2.'.');
                    $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio1.', '.$estado1.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio2.', Estado de '.$estado2.'.');

                }
                elseif($dependencias[1]->id_estado==9 and $dependencias[0]->id_estado != 9){
                    $ciudad=('la '.$estado2.' y en '.$municipio1.', Estado de '.$estado1.'.');
                    $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio1.', Estado de '.$estado1.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio2.', '.$estado2.'.');

                }
                else{
                    $ciudad=($municipio1.', Estado de '.$estado1.', '.$municipio2.', Estado de '.$estado2.'.');
                    $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio1.', Estado de '.$estado1.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio2.', Estado de '.$estado2.'.');

                }

            }
        }
        ////////////////////////////////////////////***estado 3
        if($contar_estado ==3)
        {
            if($dependencias[0]->id_estado == $dependencias[1]->id_estado and  $dependencias[0]->id_estado == $dependencias[2]->id_estado  )
            {
                if( $dependencias[0]->id_municipio == $dependencias[1]->id_municipio and $dependencias[0]->id_municipio == $dependencias[2]->id_municipio){
                    $municipio=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                    $estado=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_estado, MB_CASE_TITLE), "UTF-8");
                    if($dependencias[0]->id_estado==9)
                    {
                        $ciudad=('la '.$estado.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio.', '.$estado.'.');

                    }
                    else{
                        $ciudad=($municipio.', Estado de '.$estado.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio.', Estado de '.$estado.'.');

                    }

                }
                elseif ($dependencias[0]->id_municipio == $dependencias[1]->id_municipio and $dependencias[0]->id_municipio != $dependencias[2]->id_municipio){

                    $municipio=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                    $estado=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_estado, MB_CASE_TITLE), "UTF-8");
                    $municipio3=mb_convert_encoding(mb_convert_case($dependencias[2]->nombre_municipio, MB_CASE_TITLE), "UTF-8");

                    if($dependencias[0]->id_estado==9 )
                    {
                        $ciudad=('la '.$estado.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.', '.$municipio.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio3.', Estado de '.$estado.'.');

                    }

                    else{
                        $ciudad=($municipio.' y '.$municipio3.', Estado de '.$estado.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio3.', Estado de '.$estado.'.');

                    }
                }
                elseif ($dependencias[0]->id_municipio == $dependencias[2]->id_municipio and $dependencias[0]->id_municipio != $dependencias[1]->id_municipio){
                    $municipio=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                    $estado=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_estado, MB_CASE_TITLE), "UTF-8");
                    $municipio3=mb_convert_encoding(mb_convert_case($dependencias[1]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                    if($dependencias[0]->id_estado==9  )
                    {
                        $ciudad=('la '.$estado.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio3.', '.$estado.'.');

                    }

                    else{
                        $ciudad=($municipio.' y '.$municipio3.', Estado de '.$estado.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio3.', Estado de '.$estado.'.');

                    }
                }
                elseif ($dependencias[1]->id_municipio == $dependencias[2]->id_municipio and $dependencias[1]->id_municipio != $dependencias[0]->id_municipio){
                    $municipio=mb_convert_encoding(mb_convert_case($dependencias[1]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                    $estado=mb_convert_encoding(mb_convert_case($dependencias[1]->nombre_estado, MB_CASE_TITLE), "UTF-8");
                    $municipio3=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                    if($dependencias[1]->id_estado==9  )
                    {
                        $ciudad=('la '.$estado.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.', '.$municipio.', '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio3.', '.$estado.'.');

                    }

                    else{
                        $ciudad=($municipio.' y '.$municipio3.', Estado de '.$estado.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio.', '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio3.', Estado de '.$estado.'.');

                    }

                }
                else{
                    $municipio=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                    $municipio2=mb_convert_encoding(mb_convert_case($dependencias[1]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                    $municipio3=mb_convert_encoding(mb_convert_case($dependencias[2]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                    $estado=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_estado, MB_CASE_TITLE), "UTF-8");
                    if($dependencias[0]->id_estado==9  )
                    {
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio2.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio3.', '.$estado.'.');


                    }
                    else{
                        $ciudad=($municipio.', '.$municipio2.' y '.$municipio3.', Estado de '.$estado.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio2.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio3.', Estado de '.$estado.'.');

                    }

                }

            }

            elseif($dependencias[0]->id_estado == $dependencias[1]->id_estado and  $dependencias[0]->id_estado != $dependencias[2]->id_estado  )
            {
                $estado=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_estado, MB_CASE_TITLE), "UTF-8");
                $estado3=mb_convert_encoding(mb_convert_case($dependencias[2]->nombre_estado, MB_CASE_TITLE), "UTF-8");

                if($dependencias[0]->id_municipio == $dependencias[1]->id_municipio){
                    $municipio=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                    $municipio3=mb_convert_encoding(mb_convert_case($dependencias[2]->nombre_municipio, MB_CASE_TITLE), "UTF-8");

                    if($dependencias[0]->id_estado==9 and $dependencias[2]->id_estado !=9 )
                    {
                        $ciudad=('la '.$estado.'y '.$municipio3.', Estado de '.$estado3.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio.', '.$estado.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio3.', Estado de '.$estado3.'.');

                    }
                    elseif($dependencias[2]->id_estado==9 and $dependencias[0]->id_estado !=9 ){
                        $ciudad=('la '.$estado3.'y '.$municipio.', Estado de '.$estado.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio.', Estado de '.$estado.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio3.', '.$estado3.'.');


                    }
                    else{
                        $ciudad=($municipio.', Estado de '.$estado.' y '.$municipio3.', Estado de '.$estado3.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio.', Estado de '.$estado.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio3.', Estado de '.$estado3.'.');

                    }
                }
                else{
                    $municipio=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                    $municipio2=mb_convert_encoding(mb_convert_case($dependencias[1]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                    $municipio3=mb_convert_encoding(mb_convert_case($dependencias[2]->nombre_municipio, MB_CASE_TITLE), "UTF-8");

                    if($dependencias[0]->id_estado==9 and $dependencias[2]->id_estado !=9 )
                    {
                        $ciudad=('la '.$estado.'y '.$municipio3.', Estado de '.$estado3.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio2.', '.$estado.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio3.', Estado de'.$estado3.'.');

                    }
                    elseif($dependencias[2]->id_estado==9 and $dependencias[0]->id_estado !=9 ){
                        $ciudad=('la '.$estado3.', '.$municipio.' y '.$municipio2.', Estado de '.$estado.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio2.', Estado de '.$estado.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio3.', '.$estado3.'.');


                    }
                    else{
                        $ciudad=($municipio.','.$municipio2.', Estado de '.$estado.' y '.$municipio3.', Estado de '.$estado3.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio2.', Estado de '.$estado.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio3.', Estado de '.$estado3.'.');

                    }

                }


            }
            elseif($dependencias[0]->id_estado == $dependencias[2]->id_estado and  $dependencias[0]->id_estado != $dependencias[1]->id_estado  )
            {

                $estado=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_estado, MB_CASE_TITLE), "UTF-8");
                $estado3=mb_convert_encoding(mb_convert_case($dependencias[1]->nombre_estado, MB_CASE_TITLE), "UTF-8");

                if($dependencias[0]->id_municipio == $dependencias[2]->id_municipio){
                    $municipio=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                    $municipio3=mb_convert_encoding(mb_convert_case($dependencias[1]->nombre_municipio, MB_CASE_TITLE), "UTF-8");

                    if($dependencias[0]->id_estado==9 and $dependencias[1]->id_estado !=9 )
                    {
                        $ciudad=('la '.$estado.'y '.$municipio3.', Estado de '.$estado3.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio.', '.$estado.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio3.', Estado de '.$estado3.'.');

                    }
                    elseif($dependencias[1]->id_estado==9 and $dependencias[0]->id_estado !=9 ){
                        $ciudad=('la '.$estado3.'y '.$municipio.', Estado de '.$estado.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio.', Estado de '.$estado.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio3.', '.$estado3.'.');


                    }
                    else{
                        $ciudad=($municipio.', Estado de '.$estado.' y '.$municipio3.', Estado de '.$estado3.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio.', Estado de '.$estado.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio3.', Estado de '.$estado3.'.');

                    }
                }
                else{
                    $municipio=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                    $municipio2=mb_convert_encoding(mb_convert_case($dependencias[2]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                    $municipio3=mb_convert_encoding(mb_convert_case($dependencias[1]->nombre_municipio, MB_CASE_TITLE), "UTF-8");

                    if($dependencias[0]->id_estado==9 and $dependencias[1]->id_estado !=9 )
                    {
                        $ciudad=('la '.$estado.'y '.$municipio3.', Estado de '.$estado3.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio2.', '.$estado.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio3.', Estado de '.$estado3.'.');

                    }
                    elseif($dependencias[1]->id_estado==9 and $dependencias[0]->id_estado !=9 ){
                        $ciudad=('la '.$estado3.', '.$municipio.' y '.$municipio2.', Estado de '.$estado.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio2.', Estado de '.$estado.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio3.', '.$estado3.'.');

                    }
                    else{
                        $ciudad=($municipio.', '.$municipio2.', Estado de '.$estado.' y '.$municipio3.', Estado de '.$estado3.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio2.', Estado de '.$estado.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio3.', Estado de '.$estado3.'.');

                    }

                }

            }
            elseif($dependencias[1]->id_estado == $dependencias[2]->id_estado and  $dependencias[1]->id_estado != $dependencias[0]->id_estado  )
            {


                $estado=mb_convert_encoding(mb_convert_case($dependencias[1]->nombre_estado, MB_CASE_TITLE), "UTF-8");
                $estado3=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_estado, MB_CASE_TITLE), "UTF-8");

                if($dependencias[1]->id_municipio == $dependencias[2]->id_municipio){
                    $municipio=mb_convert_encoding(mb_convert_case($dependencias[1]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                    $municipio3=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_municipio, MB_CASE_TITLE), "UTF-8");


                    if($dependencias[1]->id_estado==9 and $dependencias[0]->id_estado !=9 )
                    {
                        $ciudad=('la '.$estado.' y '.$municipio3.', Estado de '.$estado3.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio.', '.$estado.', '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio3.', Estado de '.$estado3.'.');

                    }
                    elseif($dependencias[0]->id_estado==9 and $dependencias[1]->id_estado !=9 ){
                        $ciudad=('la '.$estado3.' y '.$municipio.', Estado de '.$estado.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio.', Estado de '.$estado.', '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio3.', '.$estado3.'.');


                    }
                    else{
                        $ciudad=($municipio.', Estado de '.$estado.' y '.$municipio3.', Estado de '.$estado3.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio.', Estado de '.$estado.', '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio3.', Estado de '.$estado3.'.');

                    }
                }
                else{
                    $municipio=mb_convert_encoding(mb_convert_case($dependencias[1]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                    $municipio2=mb_convert_encoding(mb_convert_case($dependencias[2]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                    $municipio3=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_municipio, MB_CASE_TITLE), "UTF-8");

                    if($dependencias[1]->id_estado==9 and $dependencias[0]->id_estado !=9 )
                    {
                        $ciudad=('la '.$estado.'y '.$municipio3.', Estado de '.$estado3.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio2.', '.$estado.', '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio3.', Estado de '.$estado3.'.');

                    }
                    elseif($dependencias[1]->id_estado==9 and $dependencias[0]->id_estado !=9 ){
                        $ciudad=('la '.$estado3.', '.$municipio.' y '.$municipio2.', Estado de '.$estado.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio2.', Estado de '.$estado.', '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio3.', '.$estado3.'.');


                    }
                    else{
                        $ciudad=($municipio.', '.$municipio2.', Estado de '.$estado.' y '.$municipio3.', Estado de '.$estado3.'.');
                        $descripcion=($oficios->desc_comision.' '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio2.', Estado de '.$estado.', '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio3.', Estado de '.$estado3.'.');

                    }

                }
            }
            else{
                $municipio=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                $estado=mb_convert_encoding(mb_convert_case($dependencias[0]->nombre_estado, MB_CASE_TITLE), "UTF-8");
                $municipio2=mb_convert_encoding(mb_convert_case($dependencias[1]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                $estado2=mb_convert_encoding(mb_convert_case($dependencias[1]->nombre_estado, MB_CASE_TITLE), "UTF-8");
                $municipio3=mb_convert_encoding(mb_convert_case($dependencias[2]->nombre_municipio, MB_CASE_TITLE), "UTF-8");
                $estado3=mb_convert_encoding(mb_convert_case($dependencias[2]->nombre_estado, MB_CASE_TITLE), "UTF-8");
                if($dependencias[0]->id_estado==9 and $dependencias[1]->id_estado !=9  and $dependencias[2]->id_estado !=9)
                {
                    $ciudad=('la '.$estado.','.$municipio2.', Estado de '.$estado2.' y '.$municipio3.', Estado de '.$estado3.'.');
                    $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio.', '.$estado.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio2.', Estado de '.$estado2.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio3.', Estado de '.$estado3.'.');

                }
                elseif($dependencias[1]->id_estado==9 and $dependencias[2]->id_estado !=9  and $dependencias[0]->id_estado !=9)
                {
                    $ciudad=('la '.$estado2.','.$municipio.', Estado de '.$estado.' y '.$municipio3.', Estado de '.$estado3.'.');
                    $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio.', Estado de '.$estado.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio2.', '.$estado2.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio3.', Estado de '.$estado3.'.');

                }
                elseif($dependencias[2]->id_estado==9 and $dependencias[0]->id_estado !=9  and $dependencias[1]->id_estado !=9)
                {
                    $ciudad=('la '.$estado3.','.$municipio.', Estado de '.$estado.' y '.$municipio3.', Estado de '.$estado3.'.');
                    $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio.', Estado de '.$estado.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio2.', Estado de '.$estado2.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio3.', '.$estado3.'.');

                }
                else{
                    $ciudad=($municipio.', Estado de '.$estado.','.$municipio2.', Estado de '.$estado2.' y '.$municipio3.', Estado de '.$estado3.'.');
                    $descripcion=($oficios->desc_comision.' '.$dependencias[0]->dependencia.' ubicado(a) '.$dependencias[0]->domicilio.' '.$municipio.', Estado de '.$estado.', '.$dependencias[1]->dependencia.' ubicado(a) '.$dependencias[1]->domicilio.' '.$municipio2.', Estado de '.$estado2.', '.$dependencias[2]->dependencia.' ubicado(a) '.$dependencias[2]->domicilio.' '.$municipio3.', Estado de '.$estado3.'.');


                }
            }

        }
        ////////............estado 4
        if($contar_estado ==4)
        {
            if($dependencias[0]->id_estado == $dependencias[1]->id_estado and  $dependencias[0]->id_estado == $dependencias[2]->id_estado and  $dependencias[0]->id_estado == $dependencias[3]->id_estado  )
            {

            }

        }

        $fechasalida=($oficios->fecha_salida);
        $fecharegreso=($oficios->fecha_regreso);
          $horasalida=($oficios->hora_s);
        $horaregreso=($oficios->hora_r);
        $pdf->Ln(4);
        $pdf->SetFont('Arial','','8');
        $pdf->Cell(147);
        $pdf->Cell(28,4,utf8_decode('No. de Oficio '.$numero),0,0,'R');
        //fecha
        $fechas = date("Y-m-d");

        $num=date("j",strtotime($fechas));
        $ano=date("Y", strtotime($fechas));
        $mes= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes=$mes[(date('m', strtotime($fechas))*1)-1];
        $fech= $num. ' de '.$mes.' del '.$ano;
        $pdf->Ln(4);
        $pdf->SetFont('Arial','','8');
        $pdf->Cell(145);
        $pdf->Cell(30,4,utf8_decode($fech),0,0,'R');
        $consulta=DB::selectOne('SELECT COUNT( gnral_jefes_periodos.id_personal)num FROM gnral_personales,gnral_jefes_periodos,gnral_carreras,gnral_periodos,oc_oficio_personal WHERE gnral_personales.id_personal=gnral_jefes_periodos.id_personal AND gnral_carreras.id_carrera=gnral_jefes_periodos.id_carrera and gnral_periodos.id_periodo=gnral_jefes_periodos.id_periodo AND gnral_jefes_periodos.id_periodo='.$id_periodo.' and oc_oficio_personal.id_personal=gnral_personales.id_personal and oc_oficio_personal.id_oficio_personal='.$id_oficio.'');
        $cons=($consulta->num);

        if ($cons == 0 || $cons == 2) {
            $jefe_p=DB::selectOne('SELECT COUNT(oc_oficio_personal.id_personal)num FROM gnral_unidad_personal,oc_oficio_personal WHERE oc_oficio_personal.id_personal=gnral_unidad_personal.id_personal and oc_oficio_personal.id_oficio_personal='.$id_oficio.'');
            $jefe_p=$jefe_p->num;
            if ($jefe_p == 1)
            {
                $personal = DB::selectOne('select gnral_personales.nombre nombre,gnral_unidad_administrativa.jefe_descripcion departamento,abreviaciones.titulo profesion FROM gnral_personales,gnral_unidad_personal,gnral_unidad_administrativa,abreviaciones_prof,abreviaciones,oc_oficio_personal where abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion AND abreviaciones_prof.id_personal=gnral_personales.id_personal and gnral_personales.id_personal=oc_oficio_personal.id_personal and oc_oficio_personal.id_personal=gnral_unidad_personal.id_personal and gnral_unidad_personal.id_unidad_admin=gnral_unidad_administrativa.id_unidad_admin and oc_oficio_personal.id_oficio_personal='.$id_oficio.'');
                $nombre = ($personal->nombre);
                $perfil = ($personal->profesion);
                $cargo = ($personal->departamento);
                $pdf->Ln(5);
                $pdf->SetFont('Arial', 'B', '9');
                $pdf->Cell(80, 5, utf8_decode($perfil.' '.$nombre), 0, 0, '');
                // $pdf->Ln(5);
                // $pdf->Cell(80, 20, utf8_decode($nombre), 0, 0, '');
                $pdf->Ln(5);
                $pdf->Cell(80, 5, utf8_decode($cargo), 0, 0, '');
            }
            if($jefe_p == 0) {
                $personal = DB::selectOne('select gnral_personales.nombre nombre,gnral_cargos.cargo,abreviaciones.titulo profesion FROM gnral_personales,gnral_cargos,gnral_perfiles,oc_oficio,abreviaciones_prof,abreviaciones,oc_oficio_personal where abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion AND abreviaciones_prof.id_personal=gnral_personales.id_personal and gnral_personales.id_personal=oc_oficio_personal.id_personal and gnral_personales.id_perfil=gnral_perfiles.id_perfil and gnral_personales.id_cargo=gnral_cargos.id_cargo and oc_oficio.id_oficio = oc_oficio_personal.id_oficio and oc_oficio_personal.id_oficio_personal=' . $id_oficio . '');
                $nombre = ($personal->nombre);
                $perfil = ($personal->profesion);
                $cargo = ($personal->cargo);
                $pdf->Ln(5);
                $pdf->SetFont('Arial', 'B', '9');
                $pdf->Cell(80, 5, utf8_decode($perfil.' '.$nombre), 0, 0, '');
                // $pdf->Ln(5);
                // $pdf->Cell(80, 20, utf8_decode($nombre), 0, 0, '');
                $pdf->Ln(5);
                $pdf->Cell(80, 5, utf8_decode($cargo), 0, 0, '');
            }
        }
        if ($cons == 1) {
            $personal = DB::selectOne('SELECT gnral_personales.nombre,gnral_carreras.nombre carrera,abreviaciones.titulo profesion,gnral_personales.id_personal FROM gnral_personales,gnral_jefes_periodos,gnral_carreras,gnral_periodos,oc_oficio_personal,abreviaciones_prof,abreviaciones WHERE gnral_personales.id_personal=gnral_jefes_periodos.id_personal AND gnral_carreras.id_carrera=gnral_jefes_periodos.id_carrera and gnral_periodos.id_periodo=gnral_jefes_periodos.id_periodo AND gnral_jefes_periodos.id_periodo='.$id_periodo.' and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion AND abreviaciones_prof.id_personal=gnral_personales.id_personal and gnral_personales.id_personal=oc_oficio_personal.id_personal and oc_oficio_personal.id_oficio_personal=' . $id_oficio . '');
            $nombre = ($personal->nombre);
            $perfil = ($personal->profesion);
            if($personal->id_personal == 341){
                $cargo = ('JEFA DEL DEPARTAMENTO DE '.$personal->carrera.' Y A DISTANCIA');
            }else{

                $cargo = ('JEFE DE DIVISION DE '.$personal->carrera);
            }
            $pdf->Ln(5);
            $pdf->SetFont('Arial', 'B', '9');
            $pdf->Cell(80, 5, utf8_decode($perfil.' '.$nombre), 0, 0, '');
            //$pdf->Ln(5);
            // $pdf->Cell(80, 20, utf8_decode($nombre), 0, 0, '');
            $pdf->Ln(5);
            $pdf->Cell(80, 5, utf8_decode($cargo), 0, 0, '');
        }
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', '9');
        $pdf->Cell(80, 5, utf8_decode('DEL TECNOLÓGICO DE ESTUDIOS'), 0, 0, '');
        $pdf->Ln(5);
        $pdf->Cell(80, 5, utf8_decode('SUPERIORES DE VALLE DE BRAVO'), 0, 0, '');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','','10');
        $pdf->Cell(80,10,utf8_decode('Me permito informarle  que ha sido comisionado (a) para:'),0,0,'');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','','10');
        $pdf->MultiCell(175,5,utf8_decode($descripcion));
        ///lugar de salida y de regreso
        $lugarsalida=DB::selectOne('SELECT oc_lugar.descripcion from oc_oficio,oc_lugar,oc_oficio_personal WHERE oc_lugar.id_lugar= oc_oficio.id_lugar_salida and oc_oficio.id_oficio=oc_oficio_personal.id_oficio and oc_oficio_personal.id_oficio_personal='.$id_oficio.'');
        $salida=($lugarsalida->descripcion);
        $lugaregreso=DB::selectOne('SELECT oc_lugar.descripcion from oc_oficio,oc_lugar,oc_oficio_personal WHERE oc_lugar.id_lugar= oc_oficio.id_lugar_entrada and oc_oficio.id_oficio=oc_oficio_personal.id_oficio and oc_oficio_personal.id_oficio_personal='.$id_oficio.'');
        $regreso=($lugaregreso->descripcion);
        $auto=DB::selectOne('select oc_vehiculo.modelo,oc_vehiculo.placas,oc_oficio_vehiculo.licencia from oc_vehiculo,oc_oficio_vehiculo,oc_oficio_personal WHERE oc_vehiculo.id_vehiculo=oc_oficio_vehiculo.id_vehiculo and oc_oficio_vehiculo.id_oficio_personal=oc_oficio_personal.id_oficio_personal and oc_oficio_personal.id_oficio_personal='.$id_oficio.'');
        $modelo=$auto->modelo;
        $placas=$auto->placas;
        $licencia=$auto->licencia;
        ///////////////////////
        if($fechasalida == $fecharegreso) {
            $num1 = date("j", strtotime($fechasalida));
            $mes1 = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
            $mes1 = $mes1[(date('m', strtotime($fechasalida)) * 1) - 1];
            $fech1 = $num1 . ' de ' . $mes1 . ' del año en curso';
            $pdf->Ln(5);
            $pdf->SetFont('Arial', '', '10');
            $pdf->MultiCell(175, 5,utf8_decode('Lo antes mencionado se llevará a cabo el '.$fech1.', en '.$ciudad));

        }
        else{
        $num1 = date("j", strtotime($fechasalida));
        $mes1 = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
        $mes11 = $mes1[(date('m', strtotime($fechasalida)) * 1) - 1];
        $fech1 = $num1 . ' de ' . $mes11;
        $num2 = date("j", strtotime($fecharegreso));
        $mes2 = $mes1[(date('m', strtotime($fecharegreso)) * 1) - 1];
        $fech2 = $num2 . ' de ' . $mes2 . ' del año en curso';
            $pdf->Ln(5);
            $pdf->SetFont('Arial', '', '10');
            $pdf->MultiCell(175, 5,utf8_decode('Lo antes mencionado se llevará a cabo el '.$fech1.' al '.$fech2.' , en '.$ciudad));
    }
            $pdf->Ln(5);
            $pdf->SetFont('Arial', 'B', '9');
            $pdf->Cell(175, 5,utf8_decode('ASIGNACIÓN DE TARJETA DE COMBUSTIBLE'),1,0,'C');
            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', '9');
            $pdf->Cell(30, 5,utf8_decode('No. de Licencia'),1,0,'C');
            $pdf->Cell(40, 5,utf8_decode('No. de Placas'),1,0,'C');
            $pdf->Cell(45, 5,utf8_decode('Concepto'),1,0,'C');
            $pdf->Cell(60, 5,utf8_decode('Firma de quien entrega el tarjeta'),1,0,'C');
            $pdf->Ln();
            $pdf->Cell(30,5,utf8_decode(''),'LTR',0,'L',0);
            $pdf->Cell(40,5,utf8_decode(''),'LTR',0,'C',0);
            $pdf->Cell(45,5,utf8_decode('ASIGNACIÓN A VEHICULO'),'LTR',0,'C',0);
            $pdf->Cell(60,5,utf8_decode(''),'LTR',0,'C',0);
            $pdf->Ln();
            $pdf->Cell(30,5,$licencia,'LBR',0,'C',0);
            $pdf->Cell(40,5,$placas,'LBR',0,'C',0);
            $pdf->Cell(45,5,$modelo,'LBR',0,'C',0);
            $pdf->Cell(60,5,'','LBR',0,'L',0);
            $pdf->Ln();
            $pdf->SetFont('Arial', '', '10');
            $pdf->MultiCell(175, 5,utf8_decode('Con horario de salida del '.$salida. ' a las '.$horasalida.' horas y regreso al '.$regreso.' a las '.$horaregreso.' horas aproximadamente.'));



        if($salida == 'TESVB' && $regreso == 'TESVB'){
            $jef=DB::selectOne('SELECT count(oc_oficio_personal.id_personal) contar from oc_oficio_personal,gnral_unidad_personal where oc_oficio_personal.id_personal=gnral_unidad_personal.id_personal and oc_oficio_personal.id_oficio_personal='.$id_oficio.'');
            if($jef->contar ==0) {
                $pdf->Ln(5);
                $pdf->SetFont('Arial', '', '10');
                $pdf->MultiCell(175, 5, utf8_decode('Asimismo, se le informa que deberá realizar sus registros en el reloj checador al momento de salir de comisión y al regresar de la misma, independientemente de los registros del horario oficial de labores.'));
            }
        }

        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', '10');
        $pdf->MultiCell(175, 5,utf8_decode('Sin otro particular por el momento, quedo de usted.'));
        $jefes= DB::selectOne('select count(oc_oficio_personal.id_oficio_personal) personas,gnral_personales.id_personal from oc_oficio_personal,gnral_personales,gnral_unidad_personal where oc_oficio_personal.id_personal=gnral_personales.id_personal and gnral_personales.id_personal = gnral_unidad_personal.id_personal and gnral_personales.tipo_usuario='.$id_usuario.' and oc_oficio_personal.id_oficio_personal='.$id_oficio.'');
        $jefess=$jefes->personas;
        $financiero= DB::selectOne('SELECT abreviaciones.titulo,gnral_personales.nombre,gnral_unidad_administrativa.jefe_descripcion from abreviaciones_prof,abreviaciones,gnral_personales,gnral_unidad_personal,gnral_unidad_administrativa WHERE abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion and abreviaciones_prof.id_personal=gnral_personales.id_personal and gnral_personales.id_personal=gnral_unidad_personal.id_personal and gnral_unidad_administrativa.id_unidad_admin=gnral_unidad_personal.id_unidad_admin and gnral_unidad_administrativa.id_unidad_admin=22');
        $titulo_fin=$financiero->titulo;
        $nom_fin=$financiero->nombre;
        $jefe_fin=$financiero->jefe_descripcion;
        if($jefess == 1){
            $id_personas=$jefes->id_personal;
            $adcripcion= DB::selectOne('select gnral_unidad_personal.id_unidad_admin FROM gnral_unidad_personal, adscripcion_personal WHERE gnral_unidad_personal.id_unidad_persona=adscripcion_personal.id_unidad_persona and adscripcion_personal.id_personal='.$id_personas.'');
            $adcripcion=$adcripcion->id_unidad_admin;

            $usuario1 = DB::selectOne('select gnral_personales.nombre, abreviaciones.titulo from gnral_personales,abreviaciones_prof,abreviaciones,gnral_unidad_personal where abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and abreviaciones_prof.id_personal=gnral_personales.id_personal and gnral_unidad_personal.id_personal=gnral_personales.id_personal and gnral_unidad_personal.id_unidad_admin=' . $adcripcion . '');

            $nombres = $usuario1->nombre;
            $titulo = $usuario1->titulo;
            if ($adcripcion == 22 ) {

                $adcripcion = DB::selectOne('SELECT gnral_unidad_administrativa.jefe_descripcion nombre from gnral_unidad_administrativa  WHERE gnral_unidad_administrativa.id_unidad_admin= ' . $adcripcion . '');
                $adcripcion = $adcripcion->nombre;
                $pdf->Ln(10);
                $pdf->SetFont('Arial', 'B', '8');
                $pdf->Cell(60, 10, utf8_decode('FIRMA DE AUTORIZACIÓN'), 0, 0, 'C');
                $pdf->Cell(40);
                $pdf->SetFont('Arial', '', '8');
                $pdf->Cell(15, 10, utf8_decode(''), 0, 0, 'L');
                $pdf->Ln(15);
                $pdf->SetFont('Arial', 'B', '8');
                $pdf->Cell(60, 4, utf8_decode($titulo . ' ' . $nombres), 0, 0, 'C');

                $pdf->Cell(40);
                $pdf->MultiCell(60, 4, utf8_decode('Fecha, Hora y Firma de Recepcion del servidor Publico Comisionado'), 0, 'C', 0);
                $pdf->Ln(0);
                $pdf->SetFont('Arial', 'B', '8');
                $pdf->MultiCell(60, 4, utf8_decode($adcripcion), 0, 'C', 0);


            } else {
                $finanzas= DB::selectOne('SELECT gnral_unidad_personal.id_unidad_admin from gnral_unidad_personal,gnral_personales where gnral_unidad_personal.id_personal=gnral_personales.id_personal and gnral_personales.tipo_usuario='.$id_usuario.'');
                $finanzas=$finanzas->id_unidad_admin;
                $adcripcion = DB::selectOne('SELECT gnral_unidad_administrativa.jefe_descripcion nombre from gnral_unidad_administrativa  WHERE gnral_unidad_administrativa.id_unidad_admin= ' . $adcripcion . '');
                $adcripcion = $adcripcion->nombre;
                if($finanzas == 22)
                {


                    $pdf->Ln(10);
                    $pdf->SetFont('Arial', 'B', '8');
                    $pdf->Cell(60, 10, utf8_decode('FIRMA DE AUTORIZACIÓN'), 0, 0, 'C');
                    $pdf->Cell(40);
                    $pdf->SetFont('Arial', '', '8');
                    $pdf->Cell(15, 10, utf8_decode(''), 0, 0, 'L');
                    $pdf->Ln(15);
                    $pdf->SetFont('Arial', 'B', '8');
                    $pdf->Cell(60, 4, utf8_decode($titulo . ' ' . $nombres), 0, 0, 'C');

                    $pdf->Cell(40);
                    $pdf->MultiCell(60, 4, utf8_decode('Fecha, Hora y Firma de Recepcion del servidor Publico Comisionado'), 0, 'C', 0);
                    $pdf->Ln(0);
                    $pdf->SetFont('Arial', 'B', '8');
                    $pdf->MultiCell(60, 4, utf8_decode($adcripcion), 0, 'C', 0);

                }
                else {

                    if($id_personas == 139 ||  $id_personas == 276 || $id_personas == 203 || $id_personas == 212 || $id_personas == 215 ){
                        $pdf->Ln(10);
                        $pdf->SetFont('Arial', 'B', '8');
                        $pdf->Cell(60, 10, utf8_decode('FIRMA DE AUTORIZACIÓN'), 0, 0, 'C');
                        $pdf->Cell(40);
                        $pdf->SetFont('Arial', '', '8');
                        $pdf->Cell(15, 10, utf8_decode(''), 0, 0, 'L');
                        $pdf->Ln(15);
                        $pdf->SetFont('Arial', 'B', '8');
                        $pdf->Cell(60, 4, utf8_decode($titulo . ' ' . $nombres), 0, 0, 'C');

                        $pdf->Cell(40);
                        $pdf->MultiCell(60, 4, utf8_decode('Fecha, Hora y Firma de Recepcion del servidor Publico Comisionado'), 0, 'C', 0);
                        $pdf->Ln(0);
                        $pdf->SetFont('Arial', 'B', '8');
                        $pdf->MultiCell(60, 4, utf8_decode($adcripcion), 0, 'C', 0);
                    }
                    else {


                        $pdf->Ln(10);
                        $pdf->SetFont('Arial', 'B', '8');
                        $pdf->Cell(45, 10, utf8_decode('A T E N T A M E N T E'), 0, 0, 'L');
                        $pdf->Cell(40);
                        $pdf->SetFont('Arial', '', '8');
                        $pdf->Cell(15, 10, utf8_decode('FIRMA DE AUTORIZACIÓN'), 0, 0, 'L');
                        $pdf->Ln(15);
                        $pdf->SetFont('Arial', 'B', '8');
                        $pdf->Cell(45, 4, utf8_decode($titulo_fin . ' ' . $nom_fin));
                        $pdf->Cell(40);
                        $pdf->Cell(15, 5, utf8_decode($titulo . ' ' . $nombres), 0, 0, 'L');
                        $pdf->Ln(5);
                        $pdf->SetFont('Arial', 'B', '8');
                        $pdf->Cell(45, 4, utf8_decode($jefe_fin));
                        $pdf->Cell(40);
                        $pdf->MultiCell(90, 4, utf8_decode($adcripcion), 0, 'L', 0);
                        $pdf->Ln(15);
                        $pdf->Cell(85);
                        $pdf->SetFont('Arial', 'B', '8');
                        $pdf->Cell(15, 10, utf8_decode('Fecha, Hora y Firma de Recepcion del servidor Publico'), 0, 0, 'L');
                        $pdf->Ln(5);
                        $pdf->Cell(115);
                        $pdf->SetFont('Arial', 'B', '8');
                        $pdf->Cell(15, 10, utf8_decode('Comisionado'), 0, 0, 'C');
                    }
                }
            }

        }
        if($jefess == 0) {
            $chofer=DB::selectOne('SELECT COUNT(oc_oficio_personal.id_personal) chofer FROM oc_oficio_personal WHERE   oc_oficio_personal.id_oficio_personal='.$id_oficio.' and   oc_oficio_personal.id_personal=270');
            $chofer=$chofer->chofer;
            $chofer1=DB::selectOne('SELECT COUNT(oc_oficio_personal.id_personal) chofer FROM oc_oficio_personal WHERE   oc_oficio_personal.id_oficio_personal='.$id_oficio.' and   oc_oficio_personal.id_personal=277');
            $chofer1=$chofer1->chofer;
            if ($chofer == 1 || $chofer1 == 1){
                $departamento = DB::selectOne('SELECT gnral_unidad_administrativa.jefe_descripcion nombre from gnral_unidad_administrativa  WHERE gnral_unidad_administrativa.id_unidad_admin=25');
                $departamento = $departamento->nombre;
                $recursos= DB::selectOne('SELECT gnral_personales.nombre,abreviaciones.titulo FROM gnral_unidad_personal,gnral_personales,abreviaciones_prof,abreviaciones WHERE gnral_unidad_personal.id_personal=gnral_personales.id_personal and gnral_personales.id_personal=abreviaciones_prof.id_personal and abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion and gnral_unidad_personal.id_unidad_admin=25');
                $titulo=$recursos->titulo;
                $nombres=$recursos->nombre;
                $pdf->Ln(10);
                $pdf->SetFont('Arial', 'B', '8');
                $pdf->Cell(45, 10, utf8_decode('A T E N T A M E N T E'), 0, 0, 'L');
                $pdf->Cell(40);
                $pdf->SetFont('Arial', '', '8');
                $pdf->Cell(15, 10, utf8_decode('FIRMA DE AUTORIZACIÓN'), 0, 0, 'L');
                $pdf->Ln(15);
                $pdf->SetFont('Arial', 'B', '8');
                $pdf->Cell(45, 4, utf8_decode($titulo_fin . ' ' . $nom_fin));
                $pdf->Cell(40);
                $pdf->Cell(15, 5, utf8_decode($titulo . ' ' . $nombres), 0, 0, 'L');
                $pdf->Ln(5);
                $pdf->SetFont('Arial', 'B', '8');
                $pdf->Cell(45, 4, utf8_decode($jefe_fin));
                $pdf->Cell(40);
                $pdf->MultiCell(90, 4, utf8_decode($departamento), 0, 'L', 0);
                $pdf->Ln(15);
                $pdf->Cell(85);
                $pdf->SetFont('Arial', 'B', '8');
                $pdf->Cell(15, 10, utf8_decode('Fecha, Hora y Firma de Recepcion del servidor Publico'), 0, 0, 'L');
                $pdf->Ln(5);
                $pdf->Cell(115);
                $pdf->SetFont('Arial', 'B', '8');
                $pdf->Cell(15, 10, utf8_decode('Comisionado'), 0, 0, 'C');
            }
            else {
                $departamento = DB::selectOne('SELECT gnral_unidad_personal.id_unidad_admin from gnral_personales,gnral_unidad_personal WHERE gnral_personales.id_personal =gnral_unidad_personal.id_personal and gnral_personales.tipo_usuario=' . $id_usuario . '');
                $departamento = $departamento->id_unidad_admin;

                $usuario = DB::selectOne('select gnral_personales.nombre, abreviaciones.titulo from gnral_personales,abreviaciones_prof,abreviaciones,gnral_unidad_personal where abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and abreviaciones_prof.id_personal=gnral_personales.id_personal and gnral_unidad_personal.id_personal=gnral_personales.id_personal and gnral_unidad_personal.id_unidad_admin=' . $departamento . '');

                $nombres = $usuario->nombre;
                $titulo = $usuario->titulo;
                if ($departamento == 22) {

                    $departamento = DB::selectOne('SELECT gnral_unidad_administrativa.jefe_descripcion nombre from gnral_unidad_administrativa  WHERE gnral_unidad_administrativa.id_unidad_admin= ' . $departamento . '');
                    $departamento = $departamento->nombre;
                    $pdf->Ln(10);
                    $pdf->SetFont('Arial', 'B', '8');
                    $pdf->Cell(60, 10, utf8_decode('FIRMA DE AUTORIZACIÓN'), 0, 0, 'C');
                    $pdf->Cell(40);
                    $pdf->SetFont('Arial', '', '8');
                    $pdf->Cell(15, 10, utf8_decode(''), 0, 0, 'L');
                    $pdf->Ln(15);
                    $pdf->SetFont('Arial', 'B', '8');
                    $pdf->Cell(60, 4, utf8_decode($titulo . ' ' . $nombres), 0, 0, 'C');

                    $pdf->Cell(40);
                    $pdf->MultiCell(60, 4, utf8_decode('Fecha, Hora y Firma de Recepcion del servidor Publico Comisionado'), 0, 'C', 0);
                    $pdf->Ln(0);
                    $pdf->SetFont('Arial', 'B', '8');
                    $pdf->MultiCell(60, 4, utf8_decode($departamento), 0, 'C', 0);


                } else {
                    $personal = DB::selectOne('select gnral_personales.id_personal FROM gnral_personales,oc_oficio_personal where oc_oficio_personal.id_personal=gnral_personales.id_personal and oc_oficio_personal.id_oficio_personal=' . $id_oficio . '');
                    if ($personal->id_personal == 212) {
                        $departamento = DB::selectOne('SELECT gnral_unidad_administrativa.jefe_descripcion nombre from gnral_unidad_administrativa  WHERE gnral_unidad_administrativa.id_unidad_admin= ' . $departamento . '');
                        $departamento = $departamento->nombre;
                        $pdf->Ln(10);
                        $pdf->SetFont('Arial', 'B', '8');
                        $pdf->Cell(60, 10, utf8_decode('FIRMA DE AUTORIZACIÓN'), 0, 0, 'C');
                        $pdf->Cell(40);
                        $pdf->SetFont('Arial', '', '8');
                        $pdf->Cell(15, 10, utf8_decode(''), 0, 0, 'L');
                        $pdf->Ln(15);
                        $pdf->SetFont('Arial', 'B', '8');
                        $pdf->Cell(60, 4, utf8_decode($titulo . ' ' . $nombres), 0, 0, 'C');

                        $pdf->Cell(40);
                        $pdf->MultiCell(60, 4, utf8_decode('Fecha, Hora y Firma de Recepcion del servidor Publico Comisionado'), 0, 'C', 0);
                        $pdf->Ln(0);
                        $pdf->SetFont('Arial', 'B', '8');
                        $pdf->MultiCell(60, 4, utf8_decode($departamento), 0, 'C', 0);

                    } else {
                        $departamento = DB::selectOne('SELECT gnral_unidad_administrativa.jefe_descripcion nombre from gnral_unidad_administrativa  WHERE gnral_unidad_administrativa.id_unidad_admin= ' . $departamento . '');
                        $departamento = $departamento->nombre;
                        if($personal->id_personal == 139 ||  $personal->id_personal == 276 || $personal->id_personal == 203 || $personal->id_personal == 212 || $personal->id_personal == 215 ){
                            $pdf->Ln(10);
                            $pdf->SetFont('Arial', 'B', '8');
                            $pdf->Cell(60, 10, utf8_decode('FIRMA DE AUTORIZACIÓN'), 0, 0, 'C');
                            $pdf->Cell(40);
                            $pdf->SetFont('Arial', '', '8');
                            $pdf->Cell(15, 10, utf8_decode(''), 0, 0, 'L');
                            $pdf->Ln(15);
                            $pdf->SetFont('Arial', 'B', '8');
                            $pdf->Cell(60, 4, utf8_decode($titulo . ' ' . $nombres), 0, 0, 'C');

                            $pdf->Cell(40);
                            $pdf->MultiCell(60, 4, utf8_decode('Fecha, Hora y Firma de Recepcion del servidor Publico Comisionado'), 0, 'C', 0);
                            $pdf->Ln(0);
                            $pdf->SetFont('Arial', 'B', '8');
                            $pdf->MultiCell(60, 4, utf8_decode($departamento), 0, 'C', 0);
                        }
                        else {


                            $pdf->Ln(10);
                            $pdf->SetFont('Arial', 'B', '8');
                            $pdf->Cell(45, 10, utf8_decode('A T E N T A M E N T E'), 0, 0, 'L');
                            $pdf->Cell(40);
                            $pdf->SetFont('Arial', '', '8');
                            $pdf->Cell(15, 10, utf8_decode('FIRMA DE AUTORIZACIÓN'), 0, 0, 'L');
                            $pdf->Ln(15);
                            $pdf->SetFont('Arial', 'B', '8');
                            $pdf->Cell(45, 4, utf8_decode($titulo_fin . ' ' . $nom_fin));
                            $pdf->Cell(40);
                            $pdf->Cell(15, 5, utf8_decode($titulo . ' ' . $nombres), 0, 0, 'L');
                            $pdf->Ln(5);
                            $pdf->SetFont('Arial', 'B', '8');
                            $pdf->Cell(45, 4, utf8_decode($jefe_fin));
                            $pdf->Cell(40);
                            $pdf->MultiCell(90, 4, utf8_decode($departamento), 0, 'L', 0);
                            $pdf->Ln(15);
                            $pdf->Cell(85);
                            $pdf->SetFont('Arial', 'B', '8');
                            $pdf->Cell(15, 10, utf8_decode('Fecha, Hora y Firma de Recepcion del servidor Publico'), 0, 0, 'L');
                            $pdf->Ln(5);
                            $pdf->Cell(115);
                            $pdf->SetFont('Arial', 'B', '8');
                            $pdf->Cell(15, 10, utf8_decode('Comisionado'), 0, 0, 'C');
                        }
                    }
                }
            }

            }

        $pdf->Output();
        exit();
    }
}
