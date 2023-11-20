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
        $this->Image('img/residencia/logo_tec.PNG', 203, 6, 60);

        $this->Ln(4);

    }

    //PIE DE PAGINA
    function Footer()
    {
        $this->SetY(-20);
        $this->SetFont('Arial', '', 5.5);
       // $this->Image('img/sgc.PNG', 40, 183, 20);
        $this->Image('img/pie/logos_iso.jpg',35,183,55);
        //$this->Image('img/sga.PNG', 65, 183, 20);
        // $this->Cell(100);
        //$this->Cell(167, -2, utf8_decode('FO-TESVB-39  V.0  23-03-2018'), 0, 0, 'R');
        $this->Ln(3);
        $this->Cell(100);
        $this->Cell(160, -2, utf8_decode('SECRETARÍA DE EDUCACIÓN'), 0, 0, 'R');
        $this->Ln(3);
        $this->Cell(100);
        $this->Cell(160, -2, utf8_decode('SUBSECRETARÍA DE EDUCACIÓN SUPERIOR Y NORMAL'), 0, 0, 'R');
        $this->Cell(300);
        $this->SetMargins(0, 0, 0);
        $this->Ln(1);
        $this->SetXY(30, 204);
        $this->SetFillColor(120, 120, 120);
        $this->Cell(20, 10, '', 0, 0, '', TRUE);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(297, 10, utf8_decode('KM. 30 DE LA CARRETERA FEDERAL MONUMENTO-VALLE DE BRAVO, EJIDO DE SAN ANTONIO DE LA LAGUNA'), 0, 0, 'L', TRUE);
        $this->Ln(3);
        $this->Cell(50);
        $this->Cell(160, 10, utf8_decode('VALLE DE BRAVO ESTADO DE MÉXICO C.P.51200     TEL: 01 726 2 62 20 97'), 0, 0, 'L');
        $this->Image('img/logos/Mesquina.jpg', 0, 190, 30);
    }
}
class In_pdf_carga_inglesController extends Controller
{
    public function index($id_grupo,$id_nivel){
        $id_usuario = Session::get('usuario_alumno');
        $periodo_ingles=Session::get('periodo_ingles');
        $datosalumno = DB::table('gnral_alumnos')
            ->join('gnral_carreras', 'gnral_carreras.id_carrera', '=', 'gnral_alumnos.id_carrera')
            ->where('id_usuario', '=', $id_usuario)
            ->select('gnral_alumnos.*','gnral_carreras.nombre  as carrera')
            ->get();
        $nivel = DB::table('in_niveles_ingles')
            ->where('id_niveles_ingles', '=', $id_nivel)
            ->select('in_niveles_ingles.*')
            ->get();


        $nombre_alumno=mb_strtoupper($datosalumno[0]->apaterno,'utf-8')." ".mb_strtoupper($datosalumno[0]->amaterno,'utf-8')." ".mb_strtoupper($datosalumno[0]->nombre,'utf-8');

        $per_ingles=DB::selectOne('SELECT * FROM in_periodos WHERE id_periodo_ingles = '.$periodo_ingles.'');

        $horario_profesores=DB::select('SELECT * FROM in_hrs_horas_profesor WHERE id_grupo = '.$id_grupo.'
         AND id_nivel = '.$id_nivel.' AND id_periodo = '.$periodo_ingles.'');
        $grupo=DB::selectOne('SELECT * FROM `in_grupo_ingles` WHERE `id_grupo_ingles` = '.$id_grupo.'');
        $grupo=$grupo->descripcion;


        //dd($horario_profesores);
        $id_profesor=DB::selectOne('SELECT * FROM `in_hrs_ingles_profesor` WHERE `id_grupo` = '.$id_grupo.'
        AND `id_nivel` = '.$id_nivel.' AND `id_periodo` = '.$periodo_ingles.' ORDER BY `id_grupo` ASC');
        $id_profesor=$id_profesor->id_profesor;
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
            $array_ing['nivel']="";
            $array_ing['grupo']="";
            $array_ing['disponibilidad']=3;

            array_push($array_ingles,$array_ing);
        }
        $profesores_horario=DB::select('SELECT in_hrs_horas_profesor.id_semana,in_grupo_ingles.descripcion grupo,in_niveles_ingles.descripcion nivel 
FROM in_hrs_horas_profesor,in_grupo_ingles,in_niveles_ingles WHERE 
in_hrs_horas_profesor.id_grupo =in_grupo_ingles.id_grupo_ingles and
 in_hrs_horas_profesor.id_nivel=in_niveles_ingles.id_niveles_ingles AND 
 in_hrs_horas_profesor.id_nivel ='.$id_nivel.'  
AND in_hrs_horas_profesor.id_periodo = '.$periodo_ingles.' 
and in_hrs_horas_profesor.id_grupo='.$id_grupo.'
  ORDER BY in_hrs_horas_profesor.id_semana ASC');
        $tipo_curso = DB::selectOne('SELECT eva_tipo_curso.nombre_curso from
 in_carga_academica_ingles,eva_tipo_curso
where in_carga_academica_ingles.estado_nivel=eva_tipo_curso.id_tipo_curso 
and in_carga_academica_ingles.id_alumno=' .$datosalumno[0]->id_alumno . ' 
and in_carga_academica_ingles.id_periodo_ingles=' .$periodo_ingles. '') ;
///dd($tipo_curso);
        // dd($array_ingles);
//dd($id_nivel);
        foreach ($profesores_horario as $profesor_hor)
        {
            $array_labor['id_semana']= $profesor_hor->id_semana;
            $array_labor['nivel']="NIVEL ".$profesor_hor->nivel;
            $array_labor['grupo']="GRUPO ".$profesor_hor->grupo;
            $array_labor['disponibilidad']=2;

            array_push($array_ingles,$array_labor);
        }
        foreach ($array_ingles as $key => $row) {
            $aux[$key] = $row['id_semana'];
        }
        array_multisort($aux, SORT_ASC, $array_ingles);

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
        $pdf->Cell(100,5,utf8_decode('CARGA ACADÉMICA'),0,1,'C');
        $pdf->SetFillColor(166,166,166);
        $pdf->Ln(3);
        $pdf->SetFont('Arial','','6.7');
        $pdf->Cell(40,5,utf8_decode('PERIODO :'),1,0,'C',true);
        $pdf->Cell(40,5,utf8_decode($per_ingles->periodo_ingles),1,0,'L');
        $pdf->Cell(60,5,utf8_decode('PROGRAMA ACADÉMICO:'),1,0,'C',true);
        $pdf->Cell(100,5,utf8_decode($datosalumno[0]->carrera),1,1,'L');
        $pdf->Cell(40,5,utf8_decode('NÚMERO DE CUENTA:'),1,0,'C',true);
        $pdf->Cell(40,5,utf8_decode($datosalumno[0]->cuenta),1,0,'L');
        $pdf->Cell(60,5,utf8_decode('NOMBRE DEL USUARIO:'),1,0,'C',true);
        $pdf->Cell(100,5,utf8_decode($nombre_alumno),1,1,'L');
        $pdf->Cell(40,5,utf8_decode('GRUPO:'),1,0,'C',true);
        $pdf->Cell(40,5,utf8_decode($grupo),1,0,'L');
        $pdf->Cell(60,5,utf8_decode('FACILITADOR:'),1,0,'C',true);
        $pdf->Cell(100,5,utf8_decode($nombre_profesor),1,1,'L');
        $pdf->Cell(40,5,utf8_decode(' CLAVE DEL NIVEL:'),1,0,'C',true);
        $pdf->Cell(40,5,utf8_decode($nivel[0]->clave),1,0,'L');
        $pdf->Cell(40,5,utf8_decode('NIVEL:'),1,0,'C',true);
        $pdf->Cell(40,5,utf8_decode($nivel[0]->descripcion),1,0,'L');
        $pdf->Cell(40,5,utf8_decode('STATUS DEL USUARIO:'),1,0,'C',true);
        $pdf->Cell(40,5,utf8_decode($tipo_curso->nombre_curso),1,1,'L');
        $pdf->Ln(3);
        $pdf->SetFont('Arial','','6.7');
        $pdf->Ln(0);
        $pdf->Cell(30,5,utf8_decode("Hora/ dia "),1,0,'L');
        $pdf->Cell(35,5,"Lunes",1,0,'C');
        $pdf->Cell(35,5,"Martes",1,0,'C');
        $pdf->Cell(35,5,utf8_decode("Miércoles"),1,0,'C');
        $pdf->Cell(35,5,"Jueves",1,0,'C');
        $pdf->Cell(35,5,"Viernes",1,0,'C');
        $pdf->Cell(35,5,"Sabado",1,1,'C');

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
        $pdf->Cell(35,4,utf8_decode($array_ingles[75]['nivel']),'LTR',1,'C');


        $pdf->Cell(30,3,utf8_decode("07:00-08:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[0]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[15]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[30]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[45]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[60]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[75]['grupo']),'LBR',1,'C');


        $pdf->Cell(30,4,utf8_decode(" "),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[1]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[16]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[31]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[46]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[61]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[76]['nivel']),'LTR',1,'C');

        $pdf->Cell(30,3,utf8_decode("08:00-09:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[1]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[16]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[31]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[46]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[61]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[76]['grupo']),'LBR',1,'C');


        $pdf->Cell(30,4,utf8_decode(""),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[2]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[17]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[32]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[47]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[62]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[77]['nivel']),'LTR',1,'C');


        $pdf->Cell(30,3,utf8_decode("09:00-10:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[2]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[17]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[32]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[47]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[62]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[77]['grupo']),'LBR',1,'C');


        $pdf->Cell(30,4,utf8_decode(""),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[3]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[18]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[33]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[48]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[63]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[78]['nivel']),'LTR',1,'C');


        $pdf->Cell(30,3,utf8_decode("10:00-11:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[3]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[18]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[33]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[48]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[63]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[78]['grupo']),'LBR',1,'C');


        $pdf->Cell(30,4,utf8_decode(""),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[4]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[19]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[34]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[49]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[64]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[79]['nivel']),'LTR',1,'C');


        $pdf->Cell(30,3,utf8_decode("11:00-12:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[4]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[19]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[34]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[49]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[64]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[79]['grupo']),'LBR',1,'C');


        $pdf->Cell(30,4,utf8_decode(""),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[5]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[20]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[35]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[50]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[65]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[80]['nivel']),'LTR',1,'C');


        $pdf->Cell(30,3,utf8_decode("12:00-13:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[5]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[20]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[35]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[50]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[65]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[80]['grupo']),'LBR',1,'C');


        $pdf->Cell(30,4,utf8_decode(""),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[6]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[21]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[36]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[51]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[66]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[81]['nivel']),'LTR',1,'C');


        $pdf->Cell(30,3,utf8_decode("13:00-14:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[6]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[21]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[36]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[51]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[66]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[81]['grupo']),'LBR',1,'C');


        $pdf->Cell(30,4,utf8_decode(""),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[7]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[22]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[37]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[52]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[67]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[82]['nivel']),'LTR',1,'C');


        $pdf->Cell(30,3,utf8_decode("14:00-15:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[7]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[22]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[37]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[52]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[67]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[82]['grupo']),'LBR',1,'C');


        $pdf->Cell(30,4,utf8_decode(""),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[8]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[23]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[38]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[53]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[68]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[83]['nivel']),'LTR',1,'C');


        $pdf->Cell(30,3,utf8_decode("15:00-16:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[8]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[23]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[38]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[53]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[68]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[83]['grupo']),'LBR',1,'C');


        $pdf->Cell(30,4,utf8_decode(""),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[9]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[24]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[39]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[54]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[69]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[84]['nivel']),'LTR',1,'C');


        $pdf->Cell(30,3,utf8_decode("16:00-17:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[9]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[24]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[39]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[54]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[69]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[84]['grupo']),'LBR',1,'C');


        $pdf->Cell(30,4,utf8_decode(""),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[10]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[25]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[40]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[55]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[70]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[85]['nivel']),'LTR',1,'C');


        $pdf->Cell(30,3,utf8_decode("17:00-18:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[10]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[25]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[40]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[55]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[70]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[85]['grupo']),'LBR',1,'C');


        $pdf->Cell(30,4,utf8_decode(""),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[11]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[26]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[41]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[56]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[71]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[86]['nivel']),'LTR',1,'C');


        $pdf->Cell(30,3,utf8_decode("18:00-19:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[11]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[26]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[41]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[56]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[71]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[86]['grupo']),'LBR',1,'C');


        $pdf->Cell(30,4,utf8_decode(""),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[12]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[27]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[42]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[57]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[72]['nivel']),'LTR',0,'C');
        $pdf->Cell(35,4,utf8_decode($array_ingles[87]['nivel']),'LTR',1,'C');


        $pdf->Cell(30,3,utf8_decode("19:00-20:00"),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[12]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[27]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[42]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[57]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[72]['grupo']),'LBR',0,'C');
        $pdf->Cell(35,3,utf8_decode($array_ingles[87]['grupo']),'LBR',1,'C');



        $pdf->SetFillColor(230,230,230);
        $pdf->Rect(40,158, 98,25,"DF");
        $pdf->Line(60, 175, 120, 175);
        $pdf->Rect(145,158, 98,25,"DF");
        $pdf->Line(165, 175, 225, 175);

        $pdf->Text(82,180,"USUARIO");

        $pdf->Text(170,180,utf8_decode("COORDINACIÓN DE LENGUAS EXTRANJERAS"));

        $pdf->SetFont('Arial','B',10);
        $pdf->Text(186,162,"AUTORIZO");
        $pdf->Text(83,162,"ELABORO");
        $pdf->Output();

        exit();
    }
}
