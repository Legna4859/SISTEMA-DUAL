<?php

namespace App\Http\Controllers;

use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
class PDF extends FPDF
{

    //CABECERA DE LA PAGINA
    function Header()
    {
        $this->Image('img/logo3.PNG', 115, 10, 80);
        $this->Image('img/logos/ArmasBN.png',20,10,60);
        $this->Ln(10);
    }
    //PIE DE PAGINA
    function Footer()
    {

        $this->SetY(-35);
        $this->SetFont('Arial','',8);
        $this->Image('img/pie/logos_iso.jpg',40,240,60);
        //$this->Image('img/sgc.PNG',40,240,20);

       // $this->Image('img/sga.PNG',65,240,20);
        $this->Cell(50);
        $this->Cell(145,-2,utf8_decode('FO-TESVB-49 V.3 30/06/2022'),0,0,'R');
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
        $this->Cell(145,-2,utf8_decode('DEPARTAMENTO DE TITULACIÓN'),0,0,'R');
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
class Ti_requisitos_pdfController extends Controller
{

    public function index($id_alumno){
        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');

        $alumno=DB::selectOne('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
       gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_carreras.id_carrera, gnral_carreras.nombre carrera 
       from gnral_alumnos, gnral_carreras where gnral_alumnos.id_carrera=gnral_carreras.id_carrera and gnral_alumnos.id_alumno='.$id_alumno.'');

         $nombre_alumno=mb_strtoupper($alumno->apaterno,'utf-8')." ".mb_strtoupper($alumno->amaterno,'utf-8')." ".mb_strtoupper($alumno->nombre,'utf-8');
         $cuenta=$alumno->cuenta;
         $carrera=$alumno->carrera;
         $registro_descuento=DB::selectOne('SELECT ti_descuentos_alum.*,ti_tipos_desc.tipo_desc 
         from ti_descuentos_alum,ti_tipos_desc where ti_descuentos_alum.id_tipo_desc=ti_tipos_desc.id_tipo_desc 
                                        and ti_descuentos_alum.id_alumno='.$id_alumno.'');


         $telefono=$registro_descuento->telefono;
         $fecha_tramite=$registro_descuento->fecha_registro;
         $id_tipo_descuento=$registro_descuento->id_tipo_desc;
         if($id_tipo_descuento == 3){
             $estado_donacion=0; //no
             $tipo_desc=$registro_descuento->tipo_desc;
         }else{
             $estado_donacion=1; // si
             $tipo_desc=$registro_descuento->tipo_desc;
         }
         $registro_requisitos=DB::selectOne('SELECT ti_requisitos_titulacion.*, ti_opciones_titulacion.opcion_titulacion,ti_evi_opc_titulacion.*
from ti_requisitos_titulacion,ti_opciones_titulacion,ti_evi_opc_titulacion 
WHERE ti_requisitos_titulacion.id_opcion_titulacion = ti_opciones_titulacion.id_opcion_titulacion 
  and ti_opciones_titulacion.id_tipo_evidencia=ti_evi_opc_titulacion.id_evi_opc_ti 
  and ti_requisitos_titulacion.id_alumno='.$id_alumno.'');
       // dd($registro_requisitos);

        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` where id_alumno='.$id_alumno.' ');
        $cuenta=$alumno->cuenta;
        $id_carrera=$alumno->id_carrera;
        if($id_carrera == 14){
            $sem_cero= substr($cuenta, 0, 2);
            if($sem_cero == "SC"){
                $year_cuenta= substr($cuenta, 2, 4);

            }else{
                $year_cuenta= substr($cuenta, 0, 4);
            }
        }else{
            $year_cuenta= substr($cuenta, 0, 4);
        }
        if($year_cuenta < 2010){
            $estado_contancia=1;
            $estado_acta_residencia =$registro_requisitos->estado_acta_residencia;
        }else{
            $estado_contancia=2;
            $estado_acta_residencia=0;

        }

        if($year_cuenta < 2010 || $id_carrera == 6 || $id_carrera == 8){
            $estado_egel=0;
            $estado_reporte_result_egel=0;
              }else{
            $estado_egel=1;
            $estado_reporte_result_egel = $registro_requisitos->estado_reporte_result_egel;
             }


         $correo_electronico=$registro_requisitos->correo_electronico;
         $estado_acta_nac =$registro_requisitos->estado_acta_nac;
        $estado_curp =$registro_requisitos->estado_curp;
        $estado_certificado_prep =$registro_requisitos->estado_certificado_prep;
        $estado_certificado_tesvb =$registro_requisitos->estado_certificado_tesvb;
        $estado_constancia_ss =$registro_requisitos->estado_constancia_ss;


        if($estado_contancia == 1)
        {
          $estado_ingles=DB::selectOne('SELECT COUNT(id_alumno) contar FROM in_certificado_acreditacion WHERE id_alumno = '.$id_alumno.' and enviado=1 ');
          $estado_ingles=$estado_ingles->contar;
          if($estado_ingles > 0){
              $estado_constacia_ingles=1;
          }else{
              $estado_constacia_ingles=0;
          }
        }
        if($estado_contancia == 2)
        {
            $estado_constacia_ingles=$registro_requisitos->estado_certificado_acred_ingles;

        }


          $id_opcion_titulacion=$registro_requisitos->id_opcion_titulacion;
        if($id_opcion_titulacion == 7){
            $ceneval=1;
        }else{
            $ceneval=0;
        }

        $evi_constancia_adeudo=$registro_requisitos->evi_constancia_adeudo;
        $opcion_titulacion=$registro_requisitos->opcion_titulacion;
        $id_evi_opc_ti=$registro_requisitos->id_evi_opc_ti;
        if($id_evi_opc_ti == 1){
            $evidencia_titulacion=0;
            $estado_opcion_titulacion=0;
        }else{
            $evidencia_titulacion=1;
            $estado_opcion_titulacion=$registro_requisitos->estado_opcion_titulacion;
        }
        $estado_pago_titulo=$registro_requisitos->estado_pago_titulo;
        $estado_pago_contancia=$registro_requisitos->estado_pago_contancia;
        $estado_pago_derecho_ti=$registro_requisitos->estado_pago_derecho_ti;
        $estado_pago_integrante_jurado=$registro_requisitos->estado_pago_integrante_jurado;

        $pdf = new PDF($orientation = 'P', $unit = 'mm', $format = 'Letter');

        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(10, 15, 10);
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0,0,0);

        $pdf->SetFillColor(166,166,166);
        $pdf->SetFont('Arial','B','8');
        $pdf->Ln(5);
        $pdf->Cell(190,5,utf8_decode($etiqueta->descripcion),0,1,'C');
        $pdf->SetFont('Arial','B','11');
        $pdf->Cell(190,5,utf8_decode("REQUISITOS PARA TRÁMITE DE TITULACIÓN"),0,1,'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','','9');
        $pdf->Cell(17,4,utf8_decode("NOMBRE:"),0,0,'',0);
        $pdf->Cell(173,4,utf8_decode($nombre_alumno),'B',1,'',0);

        $pdf->Cell(22,4,utf8_decode("NO. CUENTA:"),0,0,'',0);
        $pdf->Cell(47,4,utf8_decode($cuenta),'B',0,'',0);
        $pdf->Cell(41,4,utf8_decode("PROGRAMA DE ESTUDIO:"),0,0,'',0);
        $pdf->Cell(80,4,utf8_decode($carrera),'B',1,'',0);

        $pdf->Cell(20,5,utf8_decode("TELÉFONO:"),0,0,'',0);
        $pdf->Cell(44,5,utf8_decode($telefono),'B',0,'',0);
        $pdf->Cell(13,5,utf8_decode("E-MAIL:"),0,0,'',0);
        $pdf->Cell(113,5,utf8_decode($correo_electronico),'B',1,'',0);

        $pdf->Cell(48,5,utf8_decode("FECHA DE INICIO DE TRAMITE:"),0,0,'',0);
        $pdf->Cell(20,5,utf8_decode($fecha_tramite),'B',0,'',0);
        $pdf->Cell(40,5,utf8_decode("OPCIÓN DE TITULACIÓN:"),0,0,'',0);
        $pdf->Cell(83,5,utf8_decode($opcion_titulacion),'B',1,'',0);

        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','10');
        $pdf->Cell(190,4,utf8_decode("DOCUMENTOS  REQUERIDOS "),0,1,'C');
        $pdf->Ln(3);
        $pdf->SetFont('Arial','','9');
        $pdf->Cell(120,4,utf8_decode("ACTA DE NACIMIENTO (2 copias)"),0,0,'R');
        if($estado_acta_nac ==  1){
            $pdf->Cell(30,4,utf8_decode(" SI "),1,0,'C');
        }else{
            $pdf->Cell(30,4,utf8_decode(" NO "),1,0,'C');
        }

        $pdf->Cell(40,4,utf8_decode(" "),1,1,'C');

        $pdf->Cell(120,4,utf8_decode("CURP (2 copias)"),0,0,'R');
        if($estado_curp ==  1){
            $pdf->Cell(30,4,utf8_decode(" SI "),1,0,'C');
        }else{
            $pdf->Cell(30,4,utf8_decode(" NO "),1,0,'C');
        }
        $pdf->Cell(40,4,utf8_decode(" "),1,1,'C');

        $pdf->Cell(120,4,utf8_decode("CERTIFICADO DE PREPARATORIA LEGALIZADO (2 copias)"),0,0,'R');
        if($estado_certificado_prep ==  1){
            $pdf->Cell(30,4,utf8_decode(" SI "),1,0,'C');
        }else{
            $pdf->Cell(30,4,utf8_decode(" NO "),1,0,'C');
        }
        $pdf->Cell(40,4,utf8_decode(" "),1,1,'C');

        $pdf->Cell(120,4,utf8_decode("CERTIFICADO DEL TESVB (2 copias)"),0,0,'R');
        if($estado_certificado_tesvb ==  1){
            $pdf->Cell(30,4,utf8_decode(" SI "),1,0,'C');
        }else{
            $pdf->Cell(30,4,utf8_decode(" NO "),1,0,'C');
        }
        $pdf->Cell(40,4,utf8_decode(" "),1,1,'C');

        $pdf->Cell(120,4,utf8_decode("CONSTANCIA DE LIBERACIÓN DEL SERVICIO SOCIAL (2 copias)"),0,0,'R');
        if($estado_constancia_ss ==  1){
            $pdf->Cell(30,4,utf8_decode(" SI "),1,0,'C');
        }else{
            $pdf->Cell(30,4,utf8_decode(" NO "),1,0,'C');
        }
        $pdf->Cell(40,4,utf8_decode(" "),1,1,'C');

        $pdf->Cell(120,4,utf8_decode("CONSTANCIA DE ACREDITACIÓN DEL IDIOMA INGLES EMITIDA POR EL"),0,0,'R');

            $pdf->Cell(30,4,utf8_decode(" SI "),'LTR',0,'C');

        $pdf->Cell(40,4,utf8_decode(" "),'LTR',1,'C');
        $pdf->Cell(120,4,utf8_decode(" TESVB (1 copia)"),0,0,'R');
        $pdf->Cell(30,4,utf8_decode(" "),'LBR',0,'C');
        $pdf->Cell(40,4,utf8_decode(" "),'LBR',1,'C');

        $pdf->Cell(120,4,utf8_decode("REPORTE INDIVIDUAL DE RESULTADOS DEL EGEL(CENEVAL) "),0,0,'R');
        if($estado_egel ==  1){
            if($estado_reporte_result_egel == 1){
                $pdf->Cell(30, 4, utf8_decode(" SI "), 1, 0, 'C');
            }else {
                $pdf->Cell(30, 4, utf8_decode(" SI "), 1, 0, 'C');
            }
        }else{
            $pdf->Cell(30,4,utf8_decode("NO"),1,0,'C');
        }
        $pdf->Cell(40,4,utf8_decode(" "),1,1,'C');

        $pdf->Cell(120,4,utf8_decode("TESTIMONIO DEL EXAMEN EGEL* (1 copia)"),0,0,'R');
        if($ceneval == 1){
            if($estado_opcion_titulacion ==1){
                $pdf->Cell(30,4,utf8_decode(" SI "),1,0,'C');
            }else{
                $pdf->Cell(30,4,utf8_decode(" SI"),1,0,'C');
            }

        }else{
            $pdf->Cell(30,4,utf8_decode(" NO "),1,0,'C');
        }
        $pdf->Cell(40,4,utf8_decode(" "),1,1,'C');

        $pdf->Cell(120,4,utf8_decode("CONSTANCIA DE NO ADEUDO REQUISITADA"),0,0,'R');
        if($evi_constancia_adeudo == 1){
            $pdf->Cell(30,4,utf8_decode(" SI "),1,0,'C');
        }else{
            $pdf->Cell(30,4,utf8_decode(" NO "),1,0,'C');
        }

        $pdf->Cell(40,4,utf8_decode(" "),1,1,'C');

        $pdf->Cell(120,4,utf8_decode("CARATULA DEL PROYECTO FINAL, CONSTANCIA DE VIABILIDAD"),0,0,'R');

        if( $id_opcion_titulacion == 8 || $id_opcion_titulacion == 7){
           $pdf->Cell(30,4,utf8_decode(" NO "),"LTR",0,'C');
       }else{
           if($estado_opcion_titulacion == 1){
               $pdf->Cell(30,4,utf8_decode(" SI "),"LTR",0,'C');
           }else{
               $pdf->Cell(30,4,utf8_decode(" SI"),"LTR",0,'C');
           }
       }
        $pdf->Cell(40,4,utf8_decode(" "),"LTR",1,'C');
        $pdf->Cell(120,4,utf8_decode("O CONSTANCIA DE PROGRAMA DUAL(original)"),0,0,'R');
        $pdf->Cell(30,4,utf8_decode(" "),"LBR",0,'C');
        $pdf->Cell(40,4,utf8_decode(" "),"LBR",1,'C');


        $pdf->Cell(120,4,utf8_decode("ACTA DE RESIDENCIA PROFESIONAL (solo egresados anteriores a 2010)"),0,0,'R');
        $pdf->Cell(30,4,utf8_decode(" NO"),1,0,'C');
        $pdf->Cell(40,4,utf8_decode(" "),1,1,'C');

       /*  if($estado_contancia == 1){
             $pdf->Cell(120,4,utf8_decode("ACTA DE RESIDENCIA PROFESIONAL(solo egresados anteriores a 2010)"),0,0,'R');
            if($estado_acta_residencia ==1){
                $pdf->Cell(30,4,utf8_decode(" SI "),1,0,'C');
            }else{
                $pdf->Cell(30,4,utf8_decode(" SI "),1,0,'C');
            }

             $pdf->Cell(40,4,utf8_decode(" "),1,1,'C');
         }
        else{
            $pdf->Cell(120,4,utf8_decode("ACTA DE RESIDENCIA PROFESIONAL(solo egresados anteriores a 2010)"),0,0,'R');
            $pdf->Cell(30,4,utf8_decode("NO "),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(" "),1,1,'C');
        }
       */



        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','10');
        $pdf->Cell(190,4,utf8_decode("PAGOS"),0,1,'C');
        $pdf->SetFont('Arial','','9');
        $pdf->Cell(120,4,utf8_decode("REGISTRO DE TÍTULO PROFESIONAL DE LICENCIATURA CON TIMBRE"),0,0,'R');
       if($estado_pago_titulo == 1){
           $pdf->Cell(30,4,utf8_decode(" SI "),'LTR',0,'C');
       }else{
           $pdf->Cell(30,4,utf8_decode(" NO "),'LTR',0,'C');
       }

        $pdf->Cell(40,4,utf8_decode(" "),'LTR',1,'C');
        $pdf->Cell(120,4,utf8_decode(" HOLOGRAMA"),0,0,'R');
        $pdf->Cell(30,4,utf8_decode(" "),'LBR',0,'C');
        $pdf->Cell(40,4,utf8_decode(" "),'LBR',1,'C');

        $pdf->Cell(120,4,utf8_decode("CONSTANCIA DE NO ADEUDO"),0,0,'R');
        if($estado_pago_contancia == 1){
            $pdf->Cell(30,4,utf8_decode(" SI "),1,0,'C');
        }else{
            $pdf->Cell(30,4,utf8_decode(" NO "),1,0,'C');
        }

        $pdf->Cell(40,4,utf8_decode(" "),1,1,'C');

        $pdf->Cell(120,4,utf8_decode("DERECHO DE TITULACIÓN"),0,0,'R');
        if($estado_pago_derecho_ti == 1){
            $pdf->Cell(30,4,utf8_decode(" SI "),1,0,'C');
        }else{
            $pdf->Cell(30,4,utf8_decode(" NO "),1,0,'C');
        }
        $pdf->Cell(40,4,utf8_decode(" "),1,1,'C');

        $pdf->Cell(120,4,utf8_decode("INTEGRANTES A JURADO"),0,0,'R');
        if($estado_pago_integrante_jurado == 1){
            $pdf->Cell(30,4,utf8_decode(" SI "),1,0,'C');
        }else{
            $pdf->Cell(30,4,utf8_decode(" NO "),1,0,'C');
        }
        $pdf->Cell(40,4,utf8_decode(" "),1,1,'C');
        $pdf->Cell(120,4,utf8_decode("PAGO POR CONCEPTO DE AUTENTICACIÓN DE TÍTULOS PROFESIONALES"),0,0,'R');

        $pdf->Cell(30,4,utf8_decode(" SI "),'LTR',0,'C');

        $pdf->Cell(40,4,utf8_decode(" "),'LTR',1,'C');
        $pdf->Cell(120,4,utf8_decode(" DIPLOMAS O GRADOS ACADÉMICOS ELECTRÓNICOS"),0,0,'R');
        $pdf->Cell(30,4,utf8_decode(" "),'LBR',0,'C');
        $pdf->Cell(40,4,utf8_decode(" "),'LBR',1,'C');

        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','10');
        $pdf->Cell(190,4,utf8_decode("FOTOGRAFÍAS"),0,1,'C');
        $pdf->SetFont('Arial','','9');

        $pdf->Cell(120,4,utf8_decode("OVALO CREDENCIAL(6 tantos)"),0,0,'R');
        $pdf->Cell(30,4,utf8_decode(" "),1,0,'C');
        $pdf->Cell(40,4,utf8_decode(" "),1,1,'C');

        $pdf->Cell(120,4,utf8_decode("OVALO TITULO(4 tantos)"),0,0,'R');
        $pdf->Cell(30,4,utf8_decode(" "),1,0,'C');
        $pdf->Cell(40,4,utf8_decode(" "),1,1,'C');
        $pdf->Cell(120,4,utf8_decode("Donación  2010 y posteriores libros, equipo o "),0,0,'R');
        if($estado_donacion ==0){
            $pdf->Cell(30,4,utf8_decode(" NO "),'LTR',0,'C');
        }else{
            $pdf->Cell(30,4,utf8_decode(" SI "),'LTR',0,'C');
        }

        $pdf->Cell(40,4,utf8_decode(""),'LTR',1,'C');
        $pdf->Cell(120,4,utf8_decode("material didáctico"),0,0,'R');
        $pdf->Cell(30,4,utf8_decode(" "),'LBR',0,'C');
        $pdf->Cell(40,4,utf8_decode(" "),'LBR',1,'C');

        $pdf->Cell(120,4,utf8_decode("Descuento"),0,0,'R');
            $pdf->Cell(30,4,utf8_decode($tipo_desc),1,0,'C');

        $pdf->Cell(40,4,utf8_decode(" "),1,1,'C');

        $pdf->SetFont('Arial','','7');
        $pdf->Cell(190,4,utf8_decode("NOTA: La documentación debera presentarse completa en original."),0,1,'C');
        $pdf->Cell(190,4,utf8_decode("*Aplica a los candidatos a Titulación por la opción VII Otros (Examen Ceneval)."),0,1,'C');
        $pdf->SetFont('Arial','','9');
        $pdf->Ln(2);
        $pdf->Cell(95,4,utf8_decode("NOMBRE Y FIRMA DE QUIEN RECIBE"),0,0,'C');
        $pdf->Cell(95,4,utf8_decode("FIRMA DEL EGRESADO/A"),0,1,'C');
        $pdf->Ln(20);
        $pdf->SetFont('Arial','','9');
        $pdf->Cell(75,4,utf8_decode("SELLO"),0,1,'R');
        $pdf->SetFont('Arial','','7');
        $pdf->MultiCell(190,4,utf8_decode("BAJO PROTESTA DE DECIR VERDAD MANIFIESTO QUE LOS DATOS ANTES REFERIDOS SON CORRECTOS Y QUE ESTOY DE ACUERDO EN AJUSTARME A LOS PROCEDIMIENTOS FIJADOS POR LA INSTITUCIÓN DE CONFORMIDAD CON LA OPCIÓN SOLICITADA."),'J');


        $pdf->Output();
        exit();
    }
}
