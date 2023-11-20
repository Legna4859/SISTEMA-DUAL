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
        $this->Cell(110);
        $this->Cell(50,-12,utf8_decode('TecNM-SEV-DVIA-PCLE-12/17-TESVB-63'),0,0,'R');

        $this->Image('img/logos/ArmasBN.png',7,6,40);
        $this->Image('img/logos/Captura.PNG',55,5,30);
        $this->Image('img/residencia/logo_tec.PNG',203,6,60);
        $this->Ln(4);

    }
    //PIE DE PAGINA
    function Footer()
    {
        $this->SetY(-20);
        $this->SetFont('Arial','',5.5);
       // $this->Image('img/sgc.PNG',40,183,20);
        $this->Image('img/pie/logos_iso.jpg',35,183,55);
       // $this->Image('img/sga.PNG',65,183,20);
       // $this->Cell(100);
       // $this->Cell(167,-2,utf8_decode('FO-TESVB-39  V.0  23-03-2018'),0,0,'R');
        $this->Ln(3);
        $this->Cell(100);
        $this->Cell(167,-2,utf8_decode('SECRETARÍA DE EDUCACIÓN'),0,0,'R');
        $this->Ln(3);
        $this->Cell(100);
        $this->Cell(167,-2,utf8_decode('SUBSECRETARÍA DE EDUCACIÓN SUPERIOR Y NORMAL'),0,0,'R');
        $this->Cell(300);
        $this->SetMargins(0,0,0);
        $this->Ln(1);
        $this->SetXY(30,204);
        $this->SetFillColor(120,120,120);
        $this->Cell(20,10,'',0,0,'',TRUE);
        $this->SetTextColor(255,255,255);
        $this->Cell(297,10,utf8_decode('KM. 30 DE LA CARRETERA FEDERAL MONUMENTO-VALLE DE BRAVO, EJIDO DE SAN ANTONIO DE LA LAGUNA'),0,0,'L',TRUE);
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(160,10,utf8_decode('VALLE DE BRAVO ESTADO DE MÉXICO C.P.51200     TEL: 01 726 2 62 20 97'),0,0,'L');
        $this->Image('img/logos/Mesquina.jpg',0,190,30);
    }
}
class In_pdf_horarioinglesController extends Controller
{
    public function index($id_profesor){
        $periodo_ingles=Session::get('periodo_ingles');

        $per_ingles=DB::selectOne('SELECT * FROM in_periodos WHERE id_periodo_ingles = '.$periodo_ingles.'');
      //  dd($per_ingles);
        //horarios
        $sem78=DB::selectOne('SELECT COUNT(in_hrs_horas_profesor.id_semana) contar FROM in_hrs_horas_profesor where  id_profesor='.$id_profesor.' and id_periodo='.$periodo_ingles.' and id_semana in (1,16,31,46,61,76)');
        $sem89=DB::selectOne('SELECT COUNT(in_hrs_horas_profesor.id_semana) contar FROM in_hrs_horas_profesor where  id_profesor='.$id_profesor.' and id_periodo='.$periodo_ingles.' and id_semana in (2,17,32,47,62,77)');
        $sem910=DB::selectOne('SELECT COUNT(in_hrs_horas_profesor.id_semana) contar FROM in_hrs_horas_profesor where  id_profesor='.$id_profesor.' and id_periodo='.$periodo_ingles.' and id_semana in (3,18,33,48,63,78)');
        $sem1011=DB::selectOne('SELECT COUNT(in_hrs_horas_profesor.id_semana) contar FROM in_hrs_horas_profesor where  id_profesor='.$id_profesor.' and id_periodo='.$periodo_ingles.' and id_semana in (4,19,34,49,64,79)');
        $sem1112=DB::selectOne('SELECT COUNT(in_hrs_horas_profesor.id_semana) contar FROM in_hrs_horas_profesor where  id_profesor='.$id_profesor.' and id_periodo='.$periodo_ingles.' and id_semana in (5,20,35,50,65,80)');
        $sem1213=DB::selectOne('SELECT COUNT(in_hrs_horas_profesor.id_semana) contar FROM in_hrs_horas_profesor where  id_profesor='.$id_profesor.' and id_periodo='.$periodo_ingles.' and id_semana in (6,21,36,51,66,81)');
        $sem1314=DB::selectOne('SELECT COUNT(in_hrs_horas_profesor.id_semana) contar FROM in_hrs_horas_profesor where  id_profesor='.$id_profesor.' and id_periodo='.$periodo_ingles.' and id_semana in (7,22,37,52,67,82)');
        $sem1415=DB::selectOne('SELECT COUNT(in_hrs_horas_profesor.id_semana) contar FROM in_hrs_horas_profesor where  id_profesor='.$id_profesor.' and id_periodo='.$periodo_ingles.' and id_semana in (8,23,38,53,68,83)');
        $sem1516=DB::selectOne('SELECT COUNT(in_hrs_horas_profesor.id_semana) contar FROM in_hrs_horas_profesor where  id_profesor='.$id_profesor.' and id_periodo='.$periodo_ingles.' and id_semana in (9,24,39,54,69,84)');
        $sem1617=DB::selectOne('SELECT COUNT(in_hrs_horas_profesor.id_semana) contar FROM in_hrs_horas_profesor where  id_profesor='.$id_profesor.' and id_periodo='.$periodo_ingles.' and id_semana in (10,25,40,55,70,85)');
        $sem1718=DB::selectOne('SELECT COUNT(in_hrs_horas_profesor.id_semana) contar FROM in_hrs_horas_profesor where  id_profesor='.$id_profesor.' and id_periodo='.$periodo_ingles.' and id_semana in (11,26,41,56,71,86)');
        $sem1819=DB::selectOne('SELECT COUNT(in_hrs_horas_profesor.id_semana) contar FROM in_hrs_horas_profesor where  id_profesor='.$id_profesor.' and id_periodo='.$periodo_ingles.' and id_semana in (12,27,42,57,72,87)');
        $sem1920=DB::selectOne('SELECT COUNT(in_hrs_horas_profesor.id_semana) contar FROM in_hrs_horas_profesor where  id_profesor='.$id_profesor.' and id_periodo='.$periodo_ingles.' and id_semana in (13,28,43,58,73,88)');

        //
        $total_horas=DB::selectOne('SELECT count(in_hrs_horas_profesor.id_semana)total FROM in_hrs_horas_profesor where id_profesor='.$id_profesor.' and id_periodo='.$periodo_ingles.'');
        $total_horas=$total_horas->total;
        $horario_profesores=DB::select('SELECT in_hrs_horas_profesor.id_semana FROM in_hrs_horas_profesor where id_profesor='.$id_profesor.' and id_periodo='.$periodo_ingles.'');
       $nombre_profesor=DB::selectOne('SELECT * FROM in_profesores_ingles WHERE id_profesores ='.$id_profesor.' ');
       $nombre_profesor=$nombre_profesor->nombre.' '.$nombre_profesor->apellido_paterno.' '.$nombre_profesor->apellido_materno;
        $array_horario_ing=array();
        $array_semana=array();
        foreach($horario_profesores as $horario_profesor)
        {
            $horario_prof['id_semana']=$horario_profesor->id_semana;
            array_push($array_horario_ing,$horario_prof);
        }

        $sem=DB::select('select id_semana FROM hrs_semanas ');
        foreach($sem as $sem)
        {
            $semanas['id_semana']=$sem->id_semana;
            array_push($array_semana,$semanas);
        }

        $resultado_semana=array();
        foreach ($array_semana as $vehiculo) {
            $esta=false;
            foreach ($array_horario_ing as $vehiculo2) {
                if ($vehiculo['id_semana']==$vehiculo2['id_semana']) {
                    $esta=true;
                    break;
                } // esta es la que se me olvidaba
            }
            if (!$esta) $resultado_semana[]=$vehiculo;
        }
        $array_ingles=array();
        foreach ($resultado_semana as $resultado)
        {
            $array_ing['id_semana']= $resultado['id_semana'];
            $array_ing['nombre']="";
            $array_ing['nivel']="";
            $array_ing['id_nivel']="";
            $array_ing['id_grupo']="";
            $array_ing['grupo']="";
            $array_ing['registro']="";
            $array_ing['disponibilidad']=3;

            array_push($array_ingles,$array_ing);
        }
        $profesores_horario=DB::select('
SELECT in_hrs_horas_profesor.id_semana,in_profesores_ingles.*,in_grupo_ingles.descripcion grupo,
in_niveles_ingles.descripcion nivel,in_hrs_horas_profesor.id_hrs_horas_profesor,in_hrs_horas_profesor.id_grupo,in_hrs_horas_profesor.id_nivel
 FROM in_hrs_horas_profesor,in_profesores_ingles,in_niveles_ingles,in_grupo_ingles 
 where id_profesor='.$id_profesor.' and id_periodo='.$periodo_ingles.' 
 and in_hrs_horas_profesor.id_profesor=in_profesores_ingles.id_profesores
  and in_hrs_horas_profesor.id_grupo=in_grupo_ingles.id_grupo_ingles and 
  in_hrs_horas_profesor.id_nivel=in_niveles_ingles.id_niveles_ingles 
  ORDER BY in_hrs_horas_profesor.id_semana ASC');

        foreach ($profesores_horario as $profesor_hor)
        {
            $array_labor['id_semana']= $profesor_hor->id_semana;
            $array_labor['nombre']=$profesor_hor->nombre.' '.$profesor_hor->apellido_paterno.' '.$profesor_hor->apellido_materno;
            $array_labor['nivel']=$profesor_hor->nivel;
            $array_labor['id_nivel']=$profesor_hor->id_nivel;
            $array_labor['id_grupo']=$profesor_hor->id_grupo;
            $array_labor['grupo']="GRUPO ".$profesor_hor->grupo;
            $array_labor['registro']=$profesor_hor->id_hrs_horas_profesor;
            $array_labor['disponibilidad']=2;

            array_push($array_ingles,$array_labor);
        }
        foreach ($array_ingles as $key => $row) {
            $aux[$key] = $row['id_semana'];
        }
        array_multisort($aux, SORT_ASC, $array_ingles);
       // dd($array_ingles);
        $pdf=new PDF($orientation='L',$unit='mm',$format='Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(10, 20,5);
        $pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();
        $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');
        $pdf->SetFont('Arial','','6.7');
        $pdf->Cell(80);
        $pdf->Cell(100,4,utf8_decode($etiqueta->descripcion),0,0,'C');
        $pdf->Ln(3);
        $pdf->Cell(85);
        $pdf->SetFont('Arial','B','6.7');
        $pdf->Cell(100,3,utf8_decode('HORARIOS DE CLASES'),0,0,'C');
        $pdf->Ln(3);
        $pdf->SetFont('Arial','','6.7');
        $pdf->Cell(170,3,utf8_decode('FACILITADOR: '.$nombre_profesor),0,0,'L');
        $pdf->Ln(3);
        $pdf->Cell(256,3,utf8_decode('TRIMESTRE: '.$per_ingles->periodo_ingles),0,0,'R');
        $pdf->Ln(3);
        $pdf->Cell(256,3,utf8_decode('VIGENCIA DEL '.$per_ingles->fecha_inicio_ingles.' AL '.$per_ingles->fecha_final_ingles),0,0,'R');
        $pdf->Ln(3);
        $pdf->SetFont('Arial','','6.7');
        $pdf->Ln(0);
        $pdf->Cell(30,5,utf8_decode("Hora/ dia "),1,0,'L');
        $pdf->Cell(35,5,"Lunes",1,0,'C');
        $pdf->Cell(35,5,"Martes",1,0,'C');
        $pdf->Cell(35,5,utf8_decode("Miercoles"),1,0,'C');
        $pdf->Cell(35,5,"Jueves",1,0,'C');
        $pdf->Cell(35,5,"Viernes",1,0,'C');
        $pdf->Cell(35,5,"Sabado",1,0,'C');
        $pdf->Cell(15,5,"Totales",1,1,'C');
        ///////////tabla de  horas///////
       // dd($array_ingles);
      //  dd($array_ingles[0]['id_semana']);
        $pdf->SetFont('Arial','','6');
        $pdf->Cell(30,4,utf8_decode(" "),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[0]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[15]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[30]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[45]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[60]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[75]['nivel']),'LTR',0,'C');
        $pdf->Cell(15,4,utf8_decode(" "),'LTR',1,'C');

        $pdf->Cell(30,3,utf8_decode("07:00-08:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[0]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[15]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[30]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[45]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[60]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[75]['grupo']),'LBR',0,'C');
        $pdf->Cell(15,3,utf8_decode($sem78->contar),'LBR',1,'C');

        $pdf->Cell(30,4,utf8_decode(" "),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[1]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[16]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[31]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[46]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[61]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[76]['nivel']),'LTR',0,'C');
        $pdf->Cell(15,4,utf8_decode(" "),'LTR',1,'C');

        $pdf->Cell(30,3,utf8_decode("08:00-09:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[1]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[16]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[31]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[46]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[61]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[76]['grupo']),'LBR',0,'C');
        $pdf->Cell(15,3,utf8_decode($sem89->contar),'LBR',1,'C');

        $pdf->Cell(30,4,utf8_decode(""),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[2]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[17]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[32]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[47]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[62]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[77]['nivel']),'LTR',0,'C');
        $pdf->Cell(15,4,utf8_decode(" "),'LTR',1,'C');

        $pdf->Cell(30,3,utf8_decode("09:00-10:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[2]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[17]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[32]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[47]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[62]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[77]['grupo']),'LBR',0,'C');
        $pdf->Cell(15,3,utf8_decode( $sem910->contar),'LBR',1,'C');

        $pdf->Cell(30,4,utf8_decode(""),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[3]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[18]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[33]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[48]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[63]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[78]['nivel']),'LTR',0,'C');
        $pdf->Cell(15,4,utf8_decode(" "),'LTR',1,'C');

        $pdf->Cell(30,3,utf8_decode("10:00-11:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[3]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[18]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[33]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[48]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[63]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[78]['grupo']),'LBR',0,'C');
        $pdf->Cell(15,3,utf8_decode($sem1011->contar),'LBR',1,'C');

        $pdf->Cell(30,4,utf8_decode(""),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[4]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[19]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[34]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[49]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[64]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[79]['nivel']),'LTR',0,'C');
        $pdf->Cell(15,4,utf8_decode(" "),'LTR',1,'C');

        $pdf->Cell(30,3,utf8_decode("11:00-12:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[4]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[19]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[34]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[49]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[64]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[79]['grupo']),'LBR',0,'C');
        $pdf->Cell(15,3,utf8_decode($sem1112->contar),'LBR',1,'C');

        $pdf->Cell(30,4,utf8_decode(""),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[5]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[20]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[35]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[50]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[65]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[80]['nivel']),'LTR',0,'C');
        $pdf->Cell(15,4,utf8_decode(" "),'LTR',1,'C');

        $pdf->Cell(30,3,utf8_decode("12:00-13:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[5]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[20]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[35]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[50]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[65]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[80]['grupo']),'LBR',0,'C');
        $pdf->Cell(15,3,utf8_decode($sem1213->contar),'LBR',1,'C');

        $pdf->Cell(30,4,utf8_decode(""),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[6]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[21]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[36]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[51]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[66]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[81]['nivel']),'LTR',0,'C');
        $pdf->Cell(15,4,utf8_decode(" "),'LTR',1,'C');

        $pdf->Cell(30,3,utf8_decode("13:00-14:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[6]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[21]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[36]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[51]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[66]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[81]['grupo']),'LBR',0,'C');
        $pdf->Cell(15,3,utf8_decode($sem1314->contar),'LBR',1,'C');

        $pdf->Cell(30,4,utf8_decode(""),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[7]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[22]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[37]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[52]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[67]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[82]['nivel']),'LTR',0,'C');
        $pdf->Cell(15,4,utf8_decode(" "),'LTR',1,'C');

        $pdf->Cell(30,3,utf8_decode("14:00-15:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[7]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[22]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[37]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[52]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[67]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[82]['grupo']),'LBR',0,'C');
        $pdf->Cell(15,3,utf8_decode($sem1415->contar),'LBR',1,'C');

        $pdf->Cell(30,4,utf8_decode(""),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[8]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[23]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[38]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[53]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[68]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[83]['nivel']),'LTR',0,'C');
        $pdf->Cell(15,4,utf8_decode(" "),'LTR',1,'C');

        $pdf->Cell(30,3,utf8_decode("15:00-16:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[8]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[23]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[38]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[53]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[68]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[83]['grupo']),'LBR',0,'C');
        $pdf->Cell(15,3,utf8_decode($sem1516->contar),'LBR',1,'C');

        $pdf->Cell(30,4,utf8_decode(""),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[9]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[24]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[39]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[54]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[69]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[84]['nivel']),'LTR',0,'C');
        $pdf->Cell(15,4,utf8_decode(" "),'LTR',1,'C');

        $pdf->Cell(30,3,utf8_decode("16:00-17:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[9]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[24]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[39]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[54]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[69]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[84]['grupo']),'LBR',0,'C');
        $pdf->Cell(15,3,utf8_decode($sem1617->contar),'LBR',1,'C');

        $pdf->Cell(30,4,utf8_decode(""),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[10]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[25]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[40]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[55]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[70]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[85]['nivel']),'LTR',0,'C');
        $pdf->Cell(15,4,utf8_decode(" "),'LTR',1,'C');

        $pdf->Cell(30,3,utf8_decode("17:00-18:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[10]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[25]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[40]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[55]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[70]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[85]['grupo']),'LBR',0,'C');
        $pdf->Cell(15,3,utf8_decode($sem1718->contar),'LBR',1,'C');

        $pdf->Cell(30,4,utf8_decode(""),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[11]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[26]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[41]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[56]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[71]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[86]['nivel']),'LTR',0,'C');
        $pdf->Cell(15,4,utf8_decode(" "),'LTR',1,'C');

        $pdf->Cell(30,3,utf8_decode("18:00-19:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[11]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[26]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[41]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[56]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[71]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[86]['grupo']),'LBR',0,'C');
        $pdf->Cell(15,3,utf8_decode($sem1819->contar),'LBR',1,'C');

        $pdf->Cell(30,4,utf8_decode(""),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[12]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[27]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[42]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[57]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[72]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[87]['nivel']),'LTR',0,'C');
        $pdf->Cell(15,4,utf8_decode(" "),'LTR',1,'C');

        $pdf->Cell(30,3,utf8_decode("19:00-20:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[12]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[27]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[42]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[57]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[72]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[87]['grupo']),'LBR',0,'C');
        $pdf->Cell(15,3,utf8_decode($sem1920->contar),'LBR',1,'C');

        $pdf->Ln(5);
        $pdf->Cell(70,4,utf8_decode(""),0,0,'C');
        $pdf->Cell(35,4,utf8_decode("INGLES"),1,0,'C');
        $pdf->Cell(35,4,utf8_decode($total_horas),1,0,'C');
        $pdf->Cell(95,4,utf8_decode("ACEPTO DE CONFORMIDAD"),0,1,'R');
        $pdf->Cell(70,4,utf8_decode(""),0,0,'C');
        $pdf->Cell(35,4,utf8_decode("TOTAL"),1,0,'C');
        $pdf->Cell(35,4,utf8_decode($total_horas),1,1,'C');
        $pdf->Ln();
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Line(200,150,260,150);
        $pdf->Cell(180,4,utf8_decode(""),0,0,'R');
        $pdf->Cell(80,4,utf8_decode($nombre_profesor),0,1,'C');
        $pdf->Ln();
        $pdf->Cell(180,4,utf8_decode("AUTORIZÓ"),1,1,'C');
        $pdf->Cell(80,17,utf8_decode("JEFE DE DEPARTAMENTO DE  ACTIVIDADES CULTURALES Y DEPORTIVAS"),1,0,'C');
        $jefe_departamento=DB::selectOne('SELECT abreviaciones.titulo,gnral_personales.nombre from abreviaciones_prof,abreviaciones,gnral_unidad_personal,gnral_personales WHERE abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion and abreviaciones_prof.id_personal=gnral_personales.id_personal and gnral_unidad_personal.id_personal=gnral_personales.id_personal and gnral_unidad_personal.id_unidad_admin=19');
       $jefe_departamento_actividades=$jefe_departamento->titulo.' '.$jefe_departamento->nombre;
        $pdf->Cell(60,17,utf8_decode($jefe_departamento_actividades),1,0,'C');
        $pdf->Cell(40,17,utf8_decode(" "),1,1,'C');
        $pdf->Output();

        exit();
       // dd($id_profesor);

    }
}
