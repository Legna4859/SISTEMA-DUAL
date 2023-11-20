<?php
namespace App\Http\Controllers;
use Anouar\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Codedge\Fpdf\Fpdf\FPDF as FPDF;


use Session;
//use App\MakeFont as makefont;

class PDF extends Fpdf
    {
        //require("makefont/makefont.php");
        //CABECERA DE LA PAGINA

        function Header()
        {
            $this->Image('img/edom.png',20,15,50);
            $this->Image('img/logo3.PNG',115,15,80);
            $this->Ln(10);
        }

        //PIE DE PAGINA 
        function Footer()
        {
            $this->SetY(-20);
            $this->SetFont('Arial', '', 8);
            // $this->Image('img/sgc.PNG', 40, 183, 20);
            $this->Image('img/pie/logos_iso.jpg',35,245,55);
            //$this->Image('img/sga.PNG', 65, 183, 20);
            // $this->Cell(100);
            //$this->Cell(167, -2, utf8_decode('FO-TESVB-39  V.0  23-03-2018'), 0, 0, 'R');
            $this->Ln(1);
            $this->Cell(100);
            $this->Cell(0, -2, utf8_decode('SECRETARÍA DE EDUCACIÓN'), 0, 0, 'R');
            $this->Ln(3);
            $this->Cell(100);
            $this->Cell(0, -2, utf8_decode('SUBSECRETARÍA DE EDUCACIÓN SUPERIOR Y NORMAL'), 0, 0, 'R');
            $this->Cell(300);
            $this->Ln(3);
            $this->Cell(0, -2, utf8_decode('TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO'), 0, 0, 'R');
            $this->Cell(300);
            $this->SetMargins(0, 0, 0);
            $this->Ln(1);
            $this->SetFont('Arial', '', 5.5);
            $this->SetXY(30, 267);
            $this->SetFillColor(120, 120, 120);
            $this->Cell(20, 10, '', 0, 0, '', TRUE);
            $this->SetTextColor(255, 255, 255);
            $this->Cell(297, 10, utf8_decode('KM. 30 DE LA CARRETERA FEDERAL MONUMENTO-VALLE DE BRAVO, EJIDO DE SAN ANTONIO DE LA LAGUNA'), 0, 0, 'L', TRUE);
            $this->Ln(3);
            $this->Cell(50);
            $this->Cell(160, 10, utf8_decode('VALLE DE BRAVO ESTADO DE MÉXICO C.P.51200     TEL: 01 726 2 62 20 97'), 0, 0, 'L');
            $this->Image('img/logos/Mesquina.jpg', 0, 253, 30);

            /* $this->SetY(-25);
             $this->SetFont('Arial','',6);
             $this->Cell(100);
             $this->Image('img/logome.png',0,238,215);
            $this->Image('img/sgc.PNG',35,251,13);
             $this->Image('img/sga.PNG',50,251,13);
             $this->Cell(100);
             $this->Cell(90,-2,utf8_decode('SECRETARÍA DE EDUCACIÓN'),0,0,'R');
             $this->Ln(3);
             $this->Cell(100);
             $this->Cell(90,-2,utf8_decode('SUBSECRETARÍA DE EDUCACIÓN SUPERIOR Y NORMAL'),0,0,'R');
             $this->Ln(3);
             $this->Cell(100);
             $this->Cell(90,-2,utf8_decode('TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO'),0,0,'R');
             $this->Ln(4);
             //$this->Cell(100);
             //$this->Cell(80,-2,utf8_decode('INGENIERIA EN SISTEMAS COMPUTACIONALES'),0,0,'R');
             //$this->SetMargins(20, 25 , 20);
             $this->SetMargins(0,0,0);
             $this->Ln(1);
             $this->SetFillColor(166,166,166);
             $this->Cell(220,10,utf8_decode('KM. 30 DE LA CARRETERA FEDERAL MONUMENTO-VALLE DE BRAVO, EJIDO DE SAN ANTONIO DE LA LAGUNA'),0,0,'C',TRUE);
             $this->Ln(3);
             $this->Cell(60);
             $this->Cell(90,10,utf8_decode('VALLE DE BRAVO ESTADO DE MÉXICO C.P.51200     TEL: 01 726 2 62 20 97'),0,0,'C');*/
        }
}
class TodasConstancias extends Controller
{

    public function index()
    {
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
    public function constancias()
    {
        $usuario = Session::get('usuario_alumno');
        $carrera = Session::get('carrera');   
        $periodo=Session::get('periodo_actual');

        $personaless=DB::select('select promedios.descripcion,promedios.creditos,promedios.docente,promedios.titulo,
                                        promedios.cuenta,promedios.nombre,promedios.apaterno,promedios.promedio,
                                        promedios.amaterno,promedios.periodo from( select actividades_complementarias.descripcion,actividades_complementarias.creditos,gnral_personales.nombre docente,abreviaciones.titulo,
                                        gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,ROUND(AVG(actcomple_evaluaciones.calificacion)) promedio,
                                        gnral_alumnos.amaterno,gnral_periodos.periodo from actividades_complementarias,actcomple_docente_actividad,actcomple_registro_alumnos,actcomple_evidencias_alumno,actcomple_evaluaciones,
                                        gnral_personales,gnral_alumnos,actcomple_jefaturas,gnral_carreras,gnral_periodos,abreviaciones,abreviaciones_prof
                                        where actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                        and actcomple_registro_alumnos.id_docente_actividad=actcomple_docente_actividad.id_docente_actividad
                                        and actcomple_registro_alumnos.id_registro_alumno=actcomple_evidencias_alumno.id_registro_alumno
                                        and actcomple_evidencias_alumno.id_evidencia_alumno=actcomple_evaluaciones.id_evidencia_alumno
                                        and actcomple_docente_actividad.id_personal=gnral_personales.id_personal
                                        and actividades_complementarias.id_jefatura=actcomple_jefaturas.id_jefatura
                                        and actcomple_jefaturas.id_carrera=gnral_carreras.id_carrera
                                        and gnral_carreras.id_carrera='.$carrera.'
                                        and abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion
                                        and abreviaciones_prof.id_personal=gnral_personales.id_personal
                                        and actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta
                                        and gnral_periodos.id_periodo=actcomple_registro_alumnos.id_periodo
                                        and gnral_periodos.id_periodo='.$periodo.'
                                        and actcomple_evaluaciones.estado=1
                                        group by descripcion,periodo,nombre,apaterno,amaterno,cuenta,creditos,docente,titulo,promedio) as promedios where promedio>=70');

  //dd($personaless);

            $personall=DB::selectOne('select gnral_personales.id_personal from gnral_personales,users
                                        where gnral_personales.tipo_usuario=users.id
                                        and gnral_personales.tipo_usuario='.$usuario.'');
            $persona=$personall->id_personal;
//dd($persona);
                
            //echo ($personaless[$i]->cuenta);

        $etiqueta=DB::selectOne('SELECT etiqueta.descripcion from etiqueta WHERE id_etiqueta=1');
        $etiqueta=$etiqueta->descripcion;

            $pdf=new PDF($orientation='P',$unit='mm',$format='Letter');

            for ($i=0; $i<count($personaless);$i++)
            {
            

           // $pdf->SetAutoPageBreak(true,25);
            $pdf->AddPage();
            $pdf->SetMargins(20, 25 , 20);

            $pdf->SetXY(30,30);
            $pdf->SetFont('Arial','','11');
            $pdf->Cell(80);
            $pdf->Cell(18,10,utf8_decode($etiqueta),0,0,'C');
            $pdf->Ln(20);
            $pdf->Cell(80);
            $pdf->Cell(20,10,utf8_decode('Constancia de Acreditación de Actividad Complementaria'),0,0,'C');
            $pdf->Ln(15);
            $pdf->Cell(80,20,utf8_decode('L. EN C. RÓMULO ESQUIVEL REYES'),0,0,'');
            $pdf->Ln(5);
            $pdf->Cell(80,20,utf8_decode('SUBDIRECTOR DE SERVICIOS ESCOLARES'),0,0,'');
            $pdf->Ln(5);
            $pdf->Cell(80,20,utf8_decode('P R E S E N T E'),0,0,'');
            $pdf->Ln(30);
            
            $jefes=DB::selectOne('select gnral_personales.nombre
                                        from abreviaciones,abreviaciones_prof,gnral_personales 
                                        where abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion 
                                        and abreviaciones_prof.id_personal=gnral_personales.id_personal 
                                        and gnral_personales.id_personal='.$persona.'');
            $nombre_jefe=($jefes->nombre);

            $abreviacion_profesor=DB::selectOne('select abreviaciones.titulo,gnral_personales.nombre
                                        from abreviaciones,abreviaciones_prof,gnral_personales 
                                        where abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion 
                                        and abreviaciones_prof.id_personal=gnral_personales.id_personal 
                                        and gnral_personales.id_personal='.$persona.'');
            $abreviacion=($abreviacion_profesor->titulo);


            $carreras=DB::selectOne('select gnral_carreras.nombre 
                                    FROM gnral_carreras,gnral_jefes_periodos
                                    where gnral_carreras.id_carrera=gnral_jefes_periodos.id_carrera
                                    and gnral_carreras.id_carrera='.$carrera.'');
            $carrera_nombre=($carreras->nombre);


            $actividad=($personaless[$i]->descripcion);
            $periodo=($personaless[$i]->periodo);
            $nombre=($personaless[$i]->nombre);
            $ap=($personaless[$i]->apaterno);
            $am=($personaless[$i]->amaterno);
            $cuenta=($personaless[$i]->cuenta);
            $creditos=($personaless[$i]->creditos);
            $docente=($personaless[$i]->docente);
            $titulo=($personaless[$i]->titulo);
            $promedio=($personaless[$i]->promedio);

            if($promedio>=70 && $promedio<76)
            {
                $cuantitativa='REGULAR';
            }
            if($promedio>=76 && $promedio<81)
            {
                $cuantitativa='BIEN';
            }
            if($promedio>=81 && $promedio<91)
            {
                $cuantitativa='MUY BIEN';
            }
            if($promedio>=91 && $promedio<101)
            {
                $cuantitativa='EXCELENTE';
            }

            $dia=date('d');
            setlocale(LC_ALL,"spanish");
            $mes=strftime("%B");
            $año=date('Y');
            $encargadop=utf8_decode('PROFESOR RESPONSABLE DE EVALUAR LA ACTIVIDAD COMPLEMENTARIA');
            $jefe_carrera=utf8_decode($carrera_nombre);
            $texto = utf8_decode('El (la) que suscribe '.$abreviacion.' '.$nombre_jefe.', Jefe de División de la Carrera de '.$carrera_nombre.', por este medio me permito hacer de su conocimiento que el (la) estudiante  '.$nombre.' '.$ap.' '.$am.' con Número de Cuenta '.$cuenta.' ha cumplido su actividad complementaria '.$actividad.', con un nivel de desempeño '.$cuantitativa.'  y un valor numérico de '.$promedio.' durante el periodo escolar '.$periodo.' con un valor curricular de '.$creditos.' créditos.');
            $docente_encargado=$titulo.' '.$docente;
            $jefe=$abreviacion.' '.$nombre_jefe;

            $pdf->MultiCell(175,5,$texto);
            $pdf->Ln(12);
            $pdf->Cell(80,10,utf8_decode('Se extiende la presente en la Ciudad Típica de Valle de Bravo a los '.$dia.' días de '.$mes.' de '.$año.'.'),0,0,'');
            $pdf->Ln(25);
            $pdf->Cell(60);
            $pdf->Cell(60,10,utf8_decode('A T E N T A M E N T E'),0,0,'C');
            $pdf->Ln(25);
            $pdf->SetXY(10,-70); 
            $pdf->MultiCell(100,10,utf8_decode($jefe),0,'C',false);
            $pdf->SetXY(10,-60); 
            $pdf->MultiCell(90,5,(utf8_decode('JEFE DE DIVISIÓN DE ').$jefe_carrera.''),0,'C',false);
            $pdf->SetXY(110,-70);           
            $pdf->MultiCell(100,10,utf8_decode($docente_encargado),0,'C',false);
            $pdf->SetXY(110,-60); 
            $pdf->MultiCell(100,5,$encargadop,0,'C',false);
            //$pdf->AddPage();

                               

        } 
        $pdf->Output();
        exit();  

    }
    public function update(Request $request, $id)
    {
        
    }
    public function destroy($id)
    {
        
    }


}

