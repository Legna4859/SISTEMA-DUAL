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
            $this->Image('img/logo3.PNG', 120, 5, 80);
            $this->Image('img/residencia/log_estado.jpg', 20, 5, 50);
            $this->SetTextColor(128,128,128);
            $this->SetFont('Arial', 'B', '7');
            $this->Cell(190, 4, utf8_decode('RESIDENCIA PROFESIONAL'), 0, 0, 'C');
            $this->Ln();
            $this->Cell(190, 4, utf8_decode('FORMATO DE ANTEPROYECTO DE RESIDENCIA PROFESIONAL'), 0, 0, 'C');
           $this->SetDrawColor(72, 207, 47);
           $this->Line(10,35,195,35);
           $this->Ln(10);

    }
    //PIE DE PAGINA
    function Footer()
    {
        $this->SetY(-30);


        $this->Image('img/pie/logos_iso.jpg',40,253,43);
        // $this->Image('img/sgc.PNG',40,240,20);
        // $this->Image('img/tutorias/cir.jpg',89,239,20);
        //  $this->Image('img/sga.PNG',65,240,20);
        $this->SetFont('Arial','B',7);
        $this->Ln(5);
        $this->Cell(50);
        $this->Cell(145,-2,utf8_decode('FO-TESVB-90 V.0 23/03/2018'),0,0,'R');
        $this->Ln(3);
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
        $this->Cell(145,-2,utf8_decode('DEPARTAMENTO DE SERVICIO SOCIAL Y RESIDENCIA PROFESIONAL'),0,0,'R');
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
        $this->Cell(173,4,utf8_decode('     Tels.:(726)26 6 52 00, 26 6 51 87 EXT. 144      servicio.social@vbravo.tecnm.mx'),0,0,'L',true);
        $this->Ln(10);
        $this->Image('img/logos/Mesquina.jpg',2,254,30);


    }
}
class Resi_pdf_dictamen_anteproyectoController extends Controller
{
    public function index(){
        //CARRERA
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $anteproyectos=DB::selectOne('SELECT resi_anteproyecto.*,resi_proyecto.nom_proyecto,resi_proyecto.id_tipo_proyecto FROM resi_anteproyecto,resi_proyecto 
WHERE resi_proyecto.id_proyecto=resi_anteproyecto.id_proyecto and resi_anteproyecto.id_alumno='.$datosalumno->id_alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');

       //dd($anteproyectos);


      //nombre del proyecto
      $nombre_proyecto=mb_eregi_replace("[\n|\r|\n\r]",'',$anteproyectos->nom_proyecto);
      //dd($nombre_proyecto);
      $contar_nombre_proyecto=strlen($nombre_proyecto);
      $dividir_nombre=$contar_nombre_proyecto/60;
      $redondear_nombre=ceil($dividir_nombre);
      $redondear_nombre=$redondear_nombre*5;
      //////////
        /// empresa
        $empresa=DB::selectOne('select resi_proy_empresa.*,resi_empresa.* from resi_proy_empresa,resi_empresa where resi_proy_empresa.id_empresa=resi_empresa.id_empresa and resi_proy_empresa.id_anteproyecto='.$anteproyectos->id_anteproyecto.'');
       //dd($empresa);
        $nombre_empresa=mb_eregi_replace("[\n|\r|\n\r]",'',$empresa->nombre);
        $domicilio_empresa=mb_eregi_replace("[\n|\r|\n\r]",'',$empresa->domicilio);
        $telefono=mb_eregi_replace("[\n|\r|\n\r]",'',$empresa->tel_empresa);
        $correo_electronico=mb_eregi_replace("[\n|\r|\n\r]",'',$empresa->correo);
        $director_general=mb_eregi_replace("[\n|\r|\n\r]",'',$empresa->dir_gral);
        $asesor_externo=mb_eregi_replace("[\n|\r|\n\r]",'',$empresa->asesor);
        $puesto_asesor=mb_eregi_replace("[\n|\r|\n\r]",'',$empresa->puesto);
        $informacion=$empresa->informacion_empresa;
//dd($domicilio_empresa);


        $nombre_alumno='C.'.$datosalumno->nombre.' '.$datosalumno->apaterno.' '.$datosalumno->amaterno;
       // dd($datosalumno);
       $id_carrera=$datosalumno->id_carrera;
       $carrera=DB::selectOne('SELECT * FROM gnral_carreras WHERE id_carrera ='.$id_carrera.'');
        $carrera=$carrera->nombre;

        $pdf=new PDF($orientation='P',$unit='mm',$format='Letter');

        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(10, 25 , 10);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetLineWidth(0.2);
        $pdf->SetFont('Arial','B',11);
        $pdf->SetTextColor(1,1,1);
        $pdf->Ln(25);
        $pdf->Cell(190,5,"PROYECTO DE RESIDENCIA PROFESIONAL",0,0,'C',FALSE);
        $pdf->Ln(15);
        $pdf->Cell(190,5,"CARRERA: ",0,0,'C',FALSE);
        $pdf->Ln(15);
        $pdf->Cell(190,5,utf8_decode($carrera),0,0,'C',FALSE);
        $pdf->SetFont('Arial','',11);
        $pdf->Ln(10);
        $pdf->Cell(190,5,"TEMA: ",0,0,'C',FALSE);
        $pdf->Ln(10);
        $pdf->MultiCell(175, 5, utf8_decode($nombre_proyecto), 0, 'C', 0);
        $pdf->Ln(15);
        $pdf->Cell(190,5,"ELABORADO POR: ",0,0,'C',FALSE);
        $pdf->Ln(10);
        $pdf->Cell(190,5,utf8_decode($nombre_alumno),0,0,'C',FALSE);
        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(30);

        $fechas = date("Y-m-d");

        $num=date("j",strtotime($fechas));
        $ano=date("Y", strtotime($fechas));
        $mes= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes=$mes[(date('m', strtotime($fechas))*1)-1];
        $fech= $num. ' de '.$mes.' del '.$ano;

        $pdf->Cell(175,5,utf8_decode("Valle de Bravo, Estado de México;  ".$fech),0,0,'R',FALSE);
        $pdf->Image('img/residencia/firmas.PNG' , 20 ,200,170, 35,'PNG', '');
        $pdf->AddPage();
        $pdf->Ln(5);
        $pdf->SetTextColor(128,128,128);
        $pdf->SetFont('Arial','B',7);
        ///nombre del proyecto
        $txt=$nombre_proyecto;
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
            if($wdth >= 130){
                $height++;
                $wdth = 0;
            }
        }
        $contar_linea_nombre=$height*5;
        $pdf->SetFillColor(211,211,211);
        $pdf->Cell(55,($contar_linea_nombre),"Nombre del Proyecto: ",1,0,'L',true);
        $pdf->MultiCell(130, 5,utf8_decode($nombre_proyecto), 1);

     ///nombre de la empresa
        $txt=$nombre_empresa;
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
            if($wdth >= 130){
                $height++;
                $wdth = 0;
            }
        }
        ///dd($height);
        $pdf->Ln(10);
        $pdf->Cell(130,5,"Datos de la Empresa: ",0,1);

        $contar_linea_nombre_empresa=$height*5;
        $pdf->SetFillColor(211,211,211);
        $pdf->Cell(55,($contar_linea_nombre_empresa),"Empresa: ",1,0,'L',true);
        $pdf->MultiCell(130,5,utf8_decode($nombre_empresa),1);
        ///domicilio de la empresa
        $txt=$domicilio_empresa;
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
            if($wdth >= 130){
                $height++;
                $wdth = 0;
            }
        }
        $contar_linea_domicilio_empresa=$height*5;
        $pdf->SetFillColor(211,211,211);
        $pdf->Cell(55,($contar_linea_domicilio_empresa),"Domicilio: ",1,0,'L',true);
        $pdf->MultiCell(130,5,utf8_decode($domicilio_empresa),1);
        $pdf->Ln(10);
        $pdf->Cell(55,5,"Telefono: ",1,0,'L');
        $pdf->Cell(130,5,utf8_decode($telefono),1,1,'L');
        $pdf->Cell(55,5,utf8_decode("Coreo electrónico: "),1,0,'L');
        $pdf->Cell(130,5,utf8_decode($correo_electronico),1,1,'L');
        $pdf->Cell(55,5,utf8_decode("Gerente General: "),1,0,'L');
        $pdf->Cell(130,5,utf8_decode($director_general),1,1,'L');
        $pdf->Cell(55,5,utf8_decode("Asesor Externo: "),1,0,'L');
        $pdf->Cell(130,5,utf8_decode($asesor_externo),1,1,'L');
        $pdf->Cell(55,5,utf8_decode("Puesto: "),1,0,'L');
        $pdf->Cell(130,5,utf8_decode($puesto_asesor),1,1,'L');

        ///domicilio de la empresa
        $txt=$informacion;
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
            if($wdth >= 130){
                $height++;
                $wdth = 0;
            }
        }
        $contar_linea_informacion_empresa=$height*5;
        $pdf->Cell(55,($contar_linea_informacion_empresa),utf8_decode("Información sobre la empresa o institución: "),1,0,'L');
        $pdf->MultiCell(130,5,utf8_decode($informacion),0);
        $pdf->Ln(10);
        $pdf->Cell(135,5,"Necesidades de Residencias: ",0,0,'L');
        $pdf->Cell(30,5,"No de alumnos: ",1,0,'C');
        $pdf->Cell(20,5,"1",1,1,'C');
        $pdf->Cell(75,5,"Perfil: ",1,0,'C');
        $pdf->Cell(110,5,"Nombre del alumno: ",1,1,'C');
        $pdf->Cell(75,5,utf8_decode($carrera),1,0,'C');
        $pdf->Cell(110,5,utf8_decode($nombre_alumno),1,1,'C');
        $pdf->AddPage();
        $id_anteproyecto=$anteproyectos->id_anteproyecto;
        $objetivos=DB::selectOne('SELECT * FROM resi_objetivos WHERE id_anteproyecto = '.$id_anteproyecto.'');
        $objetivo_general=$objetivos->obj_general;
        $objetivo_especifico=$objetivos->obj_especifico;
        $alcances=DB::selectOne('SELECT * FROM resi_alcances WHERE id_anteproyecto = '.$id_anteproyecto.'');
        $alcance=$alcances->alcances;
        $delimitacion=$alcances->limitaciones;
        $justificacion=DB::selectOne('SELECT * FROM resi_justificacion WHERE id_anteproyecto = '.$id_anteproyecto.'');
        $justificacion=$justificacion->justificacion;
        $marco_teorico=DB::selectOne('SELECT * FROM resi_marco_teorico WHERE id_anteproyecto = '.$id_anteproyecto.'');
        $marco_teorico=$marco_teorico->marco_teorico;

        $pdf->Ln(5);
        $pdf->Cell(135,5,utf8_decode("DESCRIPCIÓN DEL PROYECTO"),0,1,'L');

        $pdf->Cell(185,5,utf8_decode("Objetivos:"),0,1,'L');
        $pdf->Cell(185,7,utf8_decode("General"),1,1,'C',true);
        $pdf->MultiCell(185,5,utf8_decode($objetivo_general),0);
        $pdf->Ln(5);
        $pdf->Cell(185,7,utf8_decode("Especificos"),1,1,'C',true);
        $pdf->MultiCell(185,5,utf8_decode($objetivo_especifico),0);
        $pdf->Ln(5);
        $pdf->Cell(185,7,utf8_decode("Alcance del proyecto"),1,1,'C',true);
        $pdf->MultiCell(185,5,utf8_decode($alcance),0);
        $pdf->Ln(5);
        $pdf->Cell(185,7,utf8_decode("Limitaciones del proyecto"),1,1,'C',true);
        $pdf->MultiCell(185,5,utf8_decode($delimitacion),0);
        $pdf->Ln(5);
        $pdf->Cell(185,7,utf8_decode("Justificación"),1,1,'C',true);
        $pdf->MultiCell(185,5,utf8_decode($justificacion),0);
        $pdf->Ln(5);
        $pdf->Cell(185,7,utf8_decode("Marco teórico"),1,1,'C',true);
        $pdf->MultiCell(185,5,utf8_decode($marco_teorico),0);
        $pdf->Ln(5);
        $pdf->Cell(185,5,utf8_decode("Descripción detallada de las actividades"),0,1,'L');
        $pdf->Ln(0);
        $pdf->Cell(10,5,utf8_decode("No "),1,0,'L',true);
        $pdf->Cell(30,5,"Fecha de inicio",1,0,'C',true);
        $pdf->Cell(30,5,"Fecha de termino",1,0,'C',true);
        $pdf->Cell(115,5,"Actividad",1,1,'C',true);


        $cronogramas=DB::select('SELECT * FROM resi_cronograma WHERE id_anteproyecto = '.$id_anteproyecto.' ORDER BY resi_cronograma.no_semana ASC');
      // dd($cronogramas);
        foreach ($cronogramas as $cronograma){
            $actividad=mb_eregi_replace("[\n|\r|\n\r]",'',$cronograma->actividad);
            $txt=$actividad;
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
                if($wdth >= 115){
                    $height++;
                    $wdth = 0;
                }
            }
            $contar_linea_actividad=$height*5;
            $pdf->Cell(10,($contar_linea_actividad),utf8_decode($cronograma->no_semana),1,0,'L');
            $pdf->Cell(30,($contar_linea_actividad),utf8_decode($cronograma->f_inicio),1,0,'L');
            $pdf->Cell(30,($contar_linea_actividad),utf8_decode($cronograma->f_termino),1,0,'L');

            $pdf->MultiCell(115,5,utf8_decode($cronograma->actividad),1);

        }
        $pdf->Output();

        exit();
    }
}
