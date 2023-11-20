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
        $this->SetFont('Arial','',10);
        $this->Ln(0);
        $this->Image('img/logos/ArmasBN.png',15,5,60);
        $this->Image('img/logos/Captura.PNG',120,5,40);
        $this->Image('img/residencia/logo_tec.PNG', 190, 6, 60);

        $this->Ln(4);

    }

    //PIE DE PAGINA
    function Footer()
    {
        $this->SetY(-30);
        $this->SetFont('Arial', '', 5.5);
        $this->Image('img/sgc.PNG', 40, 178, 20);

        $this->Image('img/sga.PNG', 65, 178, 20);
        // $this->Cell(100);
        //$this->Cell(167, -2, utf8_decode('FO-TESVB-39  V.0  23-03-2018'), 0, 0, 'R');
        $this->Ln(0);
        $this->Cell(100);
        $this->Cell(160, -2, utf8_decode('FO-TESVB-13, V.3 04/11/2021'), 0, 0, 'R');
        $this->Ln(3);
        $this->Cell(100);
        $this->Cell(160, -2, utf8_decode('SECRETARÍA DE EDUCACIÓN'), 0, 0, 'R');
        $this->Ln(3);
        $this->Cell(100);
        $this->Cell(160, -2, utf8_decode('SUBSECRETARÍA DE EDUCACIÓN SUPERIOR Y NORMAL'), 0, 0, 'R');
        $this->Ln(3);
        $this->Cell(100);
        $this->Cell(160, -2, utf8_decode('TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO'), 0, 0, 'R');
        $this->Ln(3);
        $this->Cell(100);
        $this->Cell(160, -2, utf8_decode('DEPARTAMENTO DE RECURSOS MATERIALES Y SERVICIOS GENERALES'), 0, 0, 'R');


        $this->SetMargins(0, 0, 0);
        $this->Ln(4);
        $this->SetXY(30, 200);
        $this->SetFillColor(120, 120, 120);
        $this->Cell(20, 4, '', 0, 0, '', TRUE);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(220, 4, utf8_decode('KM. 30 DE LA CARRETERA FEDERAL MONUMENTO-VALLE DE BRAVO, EJIDO DE SAN ANTONIO DE LA LAGUNA'), 0, 1, 'L', TRUE);
        $this->Cell(30);
        $this->Cell(20, 4, '', 0, 0, '', TRUE);
        $this->Cell(220, 4, utf8_decode('VALLE DE BRAVO ESTADO DE MÉXICO C.P.51200     '), 0, 1, 'L',true);
        $this->Cell(30);
        $this->Cell(20, 6, '', 0, 0, '', TRUE);
        $this->Cell(220, 6, utf8_decode('Tels.: (726) 26 6 52 00,  26 6 51 87  Ext: 107              rec.materiales@vbravo.tecnm.mx'), 0, 1, 'L',true);

        $this->Image('img/logos/Mesquina.jpg', 0, 190, 30);
    }
}
class Pres_requisicionpdfControlller extends Controller
{
    public function index($id_actividades_req_ante){

        $requisiciones = DB::select('SELECT pres_actividades_req_ante.*,pres_mes.mes, pres_proyectos.nombre_proyecto,
       pres_metas.meta, pres_partida_pres.nombre_partida, pres_partida_pres.clave_presupuestal from pres_actividades_req_ante, pres_mes,pres_proyectos,pres_metas,pres_partida_pres  
       WHERE pres_actividades_req_ante.id_mes = pres_mes.id_mes and pres_proyectos.id_proyecto = pres_actividades_req_ante.id_proyecto
       and pres_actividades_req_ante.id_meta = pres_metas.id_meta and pres_actividades_req_ante.id_actividades_req_ante='.$id_actividades_req_ante.' and pres_actividades_req_ante.id_partida_pres = pres_partida_pres.id_partida_pres 
       ORDER BY `pres_mes`.`id_mes` ASC');



        $datos_jefe=DB::selectOne('SELECT abreviaciones.titulo, gnral_personales.nombre,
        gnral_unidad_administrativa.nom_departamento,pres_req_mat_ante.* from abreviaciones, abreviaciones_prof, gnral_personales,
        gnral_unidad_personal, gnral_unidad_administrativa, pres_req_mat_ante where
        abreviaciones.id_abreviacion = abreviaciones_prof.id_abreviacion and abreviaciones_prof.id_personal = gnral_personales.id_personal
        and gnral_personales.id_personal= gnral_unidad_personal.id_personal and gnral_unidad_personal.id_unidad_admin = gnral_unidad_administrativa.id_unidad_admin
        AND gnral_unidad_administrativa.id_unidad_admin = pres_req_mat_ante.id_unidad_admin
        and pres_req_mat_ante.id_req_mat_ante ='.$requisiciones[0]->id_req_mat_ante.'');
        //dd($datos_jefe);




        $requisiciones2=array();
        $total_req=0;
        foreach ($requisiciones as $requisicion){
            $req['id_actividades_req_ante']=$requisicion->id_actividades_req_ante;
            $req['id_req_mat_ante']=$requisicion->id_req_mat_ante;
            $req['id_partida_pres']=$requisicion->id_partida_pres;
            $req['nombre_partida']=$requisicion->clave_presupuestal.' '.$requisicion->nombre_partida;
            $req['id_mes']=$requisicion->id_mes;
            $req['id_proyecto']=$requisicion->id_proyecto;
            $req['id_meta']=$requisicion->id_meta;
            $req['numero_requisicion']=$requisicion->numero_requisicion;
            $req['justificacion']=$requisicion->justificacion;
            $req['id_autorizacion']=$requisicion->id_autorizacion;
            $req['comentario']=$requisicion->comentario;
            $req['requisicion_pdf']=$requisicion->requisicion_pdf;
            $req['anexo_1_pdf']=$requisicion->anexo_1_pdf;
            $req['oficio_suficiencia_presupuestal_pdf']=$requisicion->oficio_suficiencia_presupuestal_pdf;
            $req['id_estado_justificacion']=$requisicion->id_estado_justificacion;
            $req['justificacion_pdf']=$requisicion->justificacion_pdf;
            $req['cotizacion_pdf']=$requisicion->cotizacion_pdf;
            $req['fecha_reg']=$requisicion->fecha_reg;
            $req['fecha_mod']=$requisicion->fecha_mod;
            $req['mes']=$requisicion->mes;
            $req['nombre_proyecto']=$requisicion->nombre_proyecto;
            $req['meta']=$requisicion->meta;
            $bienes=array();
            $bienes_servicios=DB::select('SELECT * FROM `pres_reg_material_req_ante` 
             WHERE `id_actividades_req_ante` = '.$requisicion->id_actividades_req_ante.'');
            foreach ( $bienes_servicios as $servicio) {
                $serv['id_reg_material_ant']=$servicio->id_reg_material_ant;
                $serv['descripcion']=$servicio->descripcion;
                $serv['unidad_medida']=$servicio->unidad_medida;
                $serv['cantidad']=$servicio->cantidad;
                $serv['precio_unitario']=$servicio->precio_unitario;
                $serv['importe']=$servicio->importe;
                $total_req=$total_req+$servicio->importe;

                array_push($bienes, $serv);
            }
            $req['servicios']=$bienes;
            array_push($requisiciones2, $req);
        }
     // dd($requisiciones2);



        $pdf=new PDF($orientation='L',$unit='mm',$format='Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(10, 30,5);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();
        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');
        $pdf->SetFont('Arial','','10');
        $pdf->Cell(260,4,utf8_decode($etiqueta->descripcion),0,0,'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B','11');
        $pdf->Cell(260,5,utf8_decode("Requisición de Materiales"),0,1,'C');
        $y33=$pdf->GetY();
        $pdf->SetFont('Arial','B','9');
        $pdf->Cell(50,5,utf8_decode("ÁREA DE SOLICITANTE: "),1,0,'');
        $pdf->Cell(150,5,utf8_decode($datos_jefe->nom_departamento),1,1,'C');
        $pdf->Cell(50,5,utf8_decode("PARTIDA PRESUPUESTAL: "),1,0,'');
        $pdf->Cell(150,5,utf8_decode($requisiciones[0]->clave_presupuestal." ".$requisiciones[0]->nombre_partida),1,1,'C');
        $pdf->Cell(50,5,utf8_decode("MES Y AÑO DE ADQUISICIÓN: "),1,0,'');
        $pdf->Cell(150,5,utf8_decode($requisiciones[0]->mes." DEL ".$datos_jefe->year_requisicion),1,1,'C');
        $pdf->Cell(50,5,utf8_decode("PROYECTO: "),1,0,'');
        $pdf->Cell(150,5,utf8_decode($requisiciones[0]->nombre_proyecto),1,1,'C');
        $y=$pdf->GetY();
        $x=$pdf->GetX();
        $pdf->Cell(50,5,utf8_decode(""),0,0,'');
        $pdf->SetFont('Arial','B','9');
        $pdf->MultiCell(150,5,utf8_decode($requisiciones[0]->meta),1);
        $y1=$pdf->GetY();
        $x1=$pdf->GetX();
        $y2=$y1-$y;
        $pdf->SetXY($x,$y);
        $pdf->Cell(50,$y2,utf8_decode("META: "),1,1,'');
        $y3=$pdf->GetY();
        $yy1=$y3-$y33;
        $pdf->SetXY(212,$y33);
        $pdf->Cell(55,$yy1,utf8_decode(""),1,0,'');
        $pdf->SetXY(212,$y33);
        $pdf->Cell(55,10,utf8_decode("REQUISICIÓN NO."),0,1,'C');
        $pdf->Cell(202,10,utf8_decode(""),0,0,'');
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(55,10,utf8_decode("R/__/__/TESVB"),0,1,'C');
        $pdf->SetXY($x1,$y1);
        $pdf->Ln(3);
        $pdf->SetFont('Arial','B','8');
        $pdf->Cell(10,4,utf8_decode(""),'TRL',0,'C');
        $pdf->Cell(155,4,utf8_decode(""),'TRL',0,'C');
        $pdf->Cell(20,4,utf8_decode("UNIDAD DE"),'TRL',0,'C');
        $pdf->Cell(20,4,utf8_decode(""),'TRL',0,'C');
        $pdf->Cell(32,4,utf8_decode("PRECIO UNITARIO DE"),'TRL',0,'C');
        $pdf->Cell(20,4,utf8_decode(""),'TRL',1,'C');
        $pdf->Cell(10,3,utf8_decode("N.P."),'RL',0,'C');
        $pdf->Cell(155,3,utf8_decode("DESCRIPCIÓN"),'RL',0,'C');
        $pdf->Cell(20,3,utf8_decode("MEDIDA"),'RL',0,'C');
        $pdf->Cell(20,3,utf8_decode("CANTIDAD"),'RL',0,'C');
        $pdf->Cell(32,3,utf8_decode("REFERENCIA CON IVA"),'RL',0,'C');
        $pdf->Cell(20,3,utf8_decode("IMPORTE"),'RL',1,'C');
        $pdf->Cell(10,3,utf8_decode(""),'BRL',0,'C');
        $pdf->Cell(155,3,utf8_decode(""),'BRL',0,'C');
        $pdf->Cell(20,3,utf8_decode(""),'BRL',0,'C');
        $pdf->Cell(20,3,utf8_decode(""),'BRL',0,'C');
        $pdf->Cell(32,3,utf8_decode("INCLUIDO"),'BRL',0,'C');
        $pdf->Cell(20,3,utf8_decode(""),'BRL',1,'C');
        $yw1=$pdf->GetY();
        $xw1=$pdf->GetX();

        $i=0;
        //dd($requisiciones2);
        $pdf->SetFont('Arial','','8');

        foreach ($requisiciones2 as $req) {
            foreach ($req['servicios'] as $servicio) {
                $i++;
                $pdf->Cell(10, 10, utf8_decode($i), 1, 0, 'C');
                $pdf->Cell(155, 10, utf8_decode(""), 1, 0, 'C');
                $pdf->Cell(20, 10, utf8_decode($servicio['unidad_medida']), 1, 0, 'C');
                $pdf->Cell(20, 10, utf8_decode($servicio['cantidad']), 1, 0, 'C');
                $pdf->Cell(32, 10, utf8_decode(number_format($servicio['precio_unitario'],2)), 1, 0, 'R');
                $pdf->Cell(20, 10, utf8_decode(number_format($servicio['importe'],2)), 1, 1, 'R');
            }
        }

        $pdf->SetXY($xw1,$yw1);
        foreach ($requisiciones2 as $req) {
            foreach ($req['servicios'] as $servicio) {
                $pdf->Cell(10, 10, "", 0, 0, 'C');
                $pdf->MultiCell(155, 5, utf8_decode($servicio['descripcion']), 0,'J');
                $xw1=$xw1;
                $yw1=$yw1+10;
                $pdf->SetXY($xw1,$yw1);
            }
        }
        $y1=$pdf->GetY();
        $x1=$pdf->GetX();

        $pdf->SetFont('Arial','B','8');
        $pdf->Cell(205,4,utf8_decode("JUSTIFICACIÓN:"),'TRL',1,'');

        $pdf->SetFont('Arial','','8');
        $pdf->MultiCell(205,4,utf8_decode($requisiciones[0]->justificacion),'BRL',1);
        $y2=$pdf->GetY();
        $y11=$y2-$y1;
        $pdf->SetXY(215,$y1);
        $pdf->SetFont('Arial','B','12');
        $pdf->Cell(32, $y11, utf8_decode("TOTAL"), 1, 0, 'C');
        $pdf->SetFont('Arial','B','8');
        $pdf->Cell(20, $y11, utf8_decode(number_format($total_req,2)), 1, 1, 'R');
        $y2=$pdf->GetY();
        $x2=$pdf->GetX();
        $pdf->Ln(2);
        $pdf->Cell(86,30, utf8_decode(""), 1, 0, 'C');
        $pdf->Cell(85,30, utf8_decode(""), 1, 0, 'C');
        $pdf->Cell(86,30, utf8_decode(""), 1, 0, 'C');
        $pdf->SetXY($x2,$y2);
        $pdf->Cell(86,5, utf8_decode("ÁREA SOLICITANTE"), 1, 0, 'C');
        $pdf->Cell(85,30, utf8_decode("RECIBIÓ"), 1, 0, 'C');
        $pdf->Cell(86,30, utf8_decode("AUTORIZÓ"), 1, 1, 'C');
        $pdf->Ln(4);
        $pdf->Cell(86,5, utf8_decode("------------------------"), 1, 0, 'C');



        $pdf->Output();

        exit();

    }
}
