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
      //  $this->Image('img/logo3.PNG', 120, 5, 80);
       // $this->Image('img/residencia/log_estado.jpg', 20, 5, 50);
       // $this->SetTextColor(128,128,128);
       // $this->SetFont('Arial', 'B', '7');
        $this->Ln(10);

    }
    //PIE DE PAGINA
    function Footer()
    {
        $this->SetY(-40);
       // $this->Image('img/residencia/of_aceptacion_informe.PNG',0,248,210,30);

    }
}
class Resioficio_aceptacion_externoController extends Controller
{
    public function oficioaceptacionexterno($id_anteproyecto){
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $alumno=DB::table('gnral_alumnos')
            ->where('gnral_alumnos.id_usuario','=',$id_usuario)
            ->select('gnral_alumnos.*')
            ->get();
        $id_carrera=$alumno[0]->id_carrera;
        $empresa=DB::table('resi_proy_empresa')
            ->join('resi_empresa','resi_empresa.id_empresa','=','resi_proy_empresa.id_empresa')
            ->where('resi_proy_empresa.id_anteproyecto','=',$id_anteproyecto)
            ->select('resi_proy_empresa.*','resi_empresa.dir_gral')
            ->get();
        $representante=$empresa[0]->dir_gral;
        $asesor_externo=$empresa[0]->asesor;
        $fecha_inicial=DB::table('resi_cronograma')
            ->where('resi_cronograma.id_anteproyecto','=',$id_anteproyecto)
            ->select(DB::raw('MIN(resi_cronograma.f_inicio) as fecha_inicial'))
            ->get();
        $fecha_inicial=$fecha_inicial[0]->fecha_inicial;
        $fecha_final=DB::table('resi_cronograma')
            ->where('resi_cronograma.id_anteproyecto','=',$id_anteproyecto)
            ->select(DB::raw('MAX(resi_cronograma.f_termino) as fecha_termino'))
            ->get();
        $fecha_final=$fecha_final[0]->fecha_termino;
        $jefe=DB::table('gnral_jefes_periodos')
            ->join('gnral_personales','gnral_jefes_periodos.id_personal','=','gnral_personales.id_personal')
            ->join('abreviaciones_prof','abreviaciones_prof.id_personal','=','gnral_personales.id_personal')
            ->join('abreviaciones','abreviaciones_prof.id_abreviacion','=','abreviaciones.id_abreviacion')
            ->join('gnral_carreras','gnral_carreras.id_carrera','=','gnral_jefes_periodos.id_carrera')
            ->where('gnral_jefes_periodos.id_carrera','=',$id_carrera)
            ->where('gnral_jefes_periodos.id_periodo','=',$periodo)
            ->where('gnral_jefes_periodos.tipo_cargo','=',1)
            ->select('gnral_personales.nombre','abreviaciones.titulo','gnral_carreras.nombre as carrera')
            ->get();

        $anteproyecto=DB::table('resi_proyecto')
            ->join('resi_anteproyecto','resi_proyecto.id_proyecto','=','resi_anteproyecto.id_proyecto')
            ->where('resi_anteproyecto.id_anteproyecto','=',$id_anteproyecto)
            ->select('resi_proyecto.nom_proyecto')
            ->get();

        $nombre_proyecto=mb_eregi_replace("[\n|\r|\n\r]",'',$anteproyecto[0]->nom_proyecto);
        $asesor=DB::table('resi_asesores')
            ->join('gnral_personales','resi_asesores.id_profesor','=','gnral_personales.id_personal')
            ->join('abreviaciones_prof','abreviaciones_prof.id_personal','=','gnral_personales.id_personal')
            ->join('abreviaciones','abreviaciones_prof.id_abreviacion','=','abreviaciones.id_abreviacion')
            ->where('resi_asesores.id_anteproyecto','=',$id_anteproyecto)
            ->select('gnral_personales.nombre','abreviaciones.titulo')
            ->get();
        $nombre_asesor=mb_strtoupper($asesor[0]->nombre,'utf-8');

        $etiqueta=DB::table('etiqueta')
            ->where('id_etiqueta','=',1)
            ->select('etiqueta.descripcion')
            ->get();
        $etiqueta=$etiqueta[0]->descripcion;


        $dat_alumnos="C. ".mb_strtoupper($alumno[0]->nombre,'utf-8')." ".mb_strtoupper($alumno[0]->apaterno,'utf-8')." ".mb_strtoupper($alumno[0]->amaterno,'utf-8');

        $promedio_general=DB::table('resi_promedio_general_residencia')
            ->where('id_anteproyecto','=',$id_anteproyecto)
            ->select('promedio_general')
            ->get();
        $promedio_general=$promedio_general[0]->promedio_general;


        $pdf=new PDF($orientation='P',$unit='mm',$format='Letter');

        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(10, 25 , 10);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();

        $fechas = date("Y-m-d");

        $num=date("j",strtotime($fechas));
        $ano=date("Y", strtotime($fechas));
        $mes= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes=$mes[(date('m', strtotime($fechas))*1)-1];

        ///fecha inicial
        $fecha1 = $fecha_inicial;

        $num1=date("j",strtotime($fecha1));
        $ano1=date("Y", strtotime($fecha1));
        $mes1= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes1=$mes1[(date('m', strtotime($fecha1))*1)-1];

////////////
        ///fecha final
        $fecha2 =$fecha_final;

        $num2=date("j",strtotime($fecha2));
        $ano2=date("Y", strtotime($fecha2));
        $mes2= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes2=$mes2[(date('m', strtotime($fecha2))*1)-1];
////////////
        $pdf->Ln(10);
        $pdf->SetTextColor(257,257,257);
        $pdf->SetFillColor(167,167,167);
        $pdf->SetFont('Arial','B',10);
        $pdf->SetX(80);
        $pdf->Cell(120,5,utf8_decode("OFICIO DE ACEPTACIÓN DE INFORME FINAL DE ASESOR EXTERNO"),0,0,'C',true);
        $pdf->Ln();
        $pdf->SetX(80);
        $pdf->SetTextColor(1,1,1);
        $pdf->SetFillColor(255,255,255);
        //$pdf->Cell(120,5,utf8_decode("FO-TESVB-94"),0,0,'R',true);
        $pdf->Ln(15);
        $pdf->SetFont('Arial','',11);
        $pdf->SetTextColor(1,1,1);
        $pdf->Cell(190,5,utf8_decode($jefe[0]->titulo.' '.$jefe[0]->nombre),0,0,'L',FALSE);
        $pdf->Ln(5);
        $pdf->Cell(190,5,utf8_decode("RESPONSABLE DE LA JEFATURA DE DIVISIÓN DE ".$jefe[0]->carrera),0,0,'L',FALSE);
        $pdf->Ln(5);
        $pdf->Cell(190,5,utf8_decode("TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO"),0,0,'L',FALSE);
        $pdf->Ln(5);
        $pdf->Cell(190,5,utf8_decode("P R E S E N T E"),0,0,'L',FALSE);
        $pdf->Ln(10);
        $pdf->SetFont('Arial','',12);
        $pdf->MultiCell(190,5,utf8_decode("Le Informo sobre los resultados y desempeño observados por el (la) ".$dat_alumnos." adscrito(a)  a  nuestra  empresa  en  el  periodo  comprendido del  ".$num1."   de  ".$mes1." de ".$ano1." al  ".$num2."  de  ".$mes2."   de ".$ano2.", en su carácter de Residente Profesional acumulando un total de   500   horas en el desarrollo del proyecto denominado: "));
        //$pdf->MultiCell(190,5,utf8_decode("Le Informo sobre los resultados y desempeño observados por el (la) C. ".$alumno." adscrito(a)  a  nuestra  empresa  en  el  periodo  comprendido del  1   de  Septiembre del 2015 al  15  de  Enero  de 2016, en su carácter de Residente Profesional acumulando un total de   500   horas en el desarrollo del proyecto denominado: "));
        $pdf->Ln(10);
        $pdf->MultiCell(190,5,utf8_decode($nombre_proyecto),0,'C');
        $pdf->Ln(11);
        $pdf->MultiCell(190,5,utf8_decode("En  México, a los ".$num." días del mes de ".$mes." del año ".$ano.", se extiende la presente para los fines que al (la) interesado(a)  convengan."));
        $pdf->SetXY(15,190);
        $pdf->Cell(70,5,utf8_decode('Vo. Bo.'),0,0,'C',FALSE);
        $pdf->SetXY(15,220);
        $pdf->SetFont('Arial','',9);
        $pdf->MultiCell(70,5,utf8_decode($representante),0,'C');
        $pdf->SetXY(15,230);
        $pdf->SetFont('Arial','',9);
        $pdf->MultiCell(70,5,utf8_decode(" Nombre y firma del Representante de la Empresa"),0,'C');
        $pdf->SetXY(15,190);
        $pdf->Cell(70,50,utf8_decode(''),1,1,'C',FALSE);

        $pdf->SetXY(85,190);
        $pdf->Cell(40,50,utf8_decode(''),1,1,'C',FALSE);
        $pdf->SetXY(85,235);
        $pdf->Cell(40,5,utf8_decode('Sello de la Empresa'),0,0,'C',FALSE);
        $pdf->SetXY(125,220);
        $pdf->MultiCell(70,5,utf8_decode($asesor_externo),0,'C');
        $pdf->SetXY(125,230);
        $pdf->MultiCell(70,5,utf8_decode("Nombre y firma del Asesor Externo"),0,'C');
        $pdf->SetXY(125,190);
        $pdf->Cell(70,50,utf8_decode(''),1,1,'C',FALSE);

        $pdf->Ln(0);
        $pdf->Cell(190,5,utf8_decode('NOTA: Firmar únicamente cuando se haya recibido el producto final de la residencia.'),0,0,'L',FALSE);

        $pdf->Output();

        exit();
    }
}
