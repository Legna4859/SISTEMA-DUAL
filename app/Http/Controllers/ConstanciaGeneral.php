<?php

namespace App\Http\Controllers;

//use Anouar\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use Illuminate\Support\Facades\DB;
use Session;


class PDF extends Fpdf
	{
		//CABECERA DE LA PAGINA
		function Header()
		{
			$this->Image('img/gobi.png',132,10,29);
            $this->Image('img/edom.png',20,15,50);
            $this->Image('img/tes.png',163,15,40);
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
		}
	}


class ConstanciaGeneral extends Controller
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
	public function edit($cuenta)
	{
		
        $usuario = Session::get('usuario_alumno');
        $carrera = Session::get('carrera');   
        $periodo=Session::get('periodo_actual');


        $personall=DB::selectOne('select gnral_personales.id_personal from gnral_personales,users
                                    where gnral_personales.tipo_usuario=users.id
                                    and gnral_personales.tipo_usuario='.$usuario.'');
        $persona=$personall->id_personal;
        $etiqueta=DB::selectOne('SELECT etiqueta.descripcion from etiqueta WHERE id_etiqueta=1');
        $etiqueta=$etiqueta->descripcion;
    	
		$pdf=new PDF($orientation='P',$unit='mm',$format='Letter');
		#Establecemos los márgenes izquierda, arriba y derecha:
		$pdf->SetMargins(20, 25 , 20);
		$pdf->SetAutoPageBreak(true,25);
		$pdf->AddPage();
		$pdf->SetDrawColor(164,164,164);
		$pdf->SetLineWidth(1.0);
		$pdf->Line(162, 10, 162, 32);


		$pdf->SetFont('Arial','','11');
		$pdf->Cell(80);
        $pdf->Cell(20,10,utf8_decode($etiqueta),0,0,'C');
		$pdf->Ln(25);
		$pdf->Cell(80,20,utf8_decode('L. EN C. RÓMULO ESQUIVEL REYES'),0,0,'');
		$pdf->Ln(5);
		$pdf->Cell(80,20,utf8_decode('SUBDIRECTOR DE SERVICIOS ESCOLARES'),0,0,'');
		$pdf->Ln(5);
		$pdf->Cell(80,20,utf8_decode('P R E S E N T E'),0,0,'');
		$pdf->Ln(30);

////////////////////////////////////CONSULTAS///////////////
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

        $datos_consultas=DB::selectOne('select gnral_alumnos.cuenta, gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno, SUM(creditos_finales.creditos) creditos,ROUND(AVG(creditos_finales.promedio)) promedio 
                                    FROM gnral_alumnos,actcomple_registro_alumnos,creditos_finales,gnral_periodos 
                                    WHERE gnral_alumnos.cuenta=actcomple_registro_alumnos.cuenta 
                                    and gnral_periodos.id_periodo=actcomple_registro_alumnos.id_periodo 
                                    and actcomple_registro_alumnos.id_registro_alumno=creditos_finales.id_registro_alumno
                                    and gnral_alumnos.cuenta='.$cuenta.' 
                                    and gnral_periodos.id_periodo='.$periodo.' 
                                    group by gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno');
        $cuenta=($datos_consultas->cuenta);
        $nombre=($datos_consultas->nombre);
        $ap=($datos_consultas->apaterno);
        $am=($datos_consultas->amaterno);
        $creditos=($datos_consultas->creditos);
        $promedio=($datos_consultas->promedio);

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

        $jefe=$abreviacion.' '.$nombre_jefe;

        if($carrera==9)
        {
            $encarga="JEFE DEL DEPARTAMENTO DE ";
        }
        else
        {
            $encarga="JEFE DE DIVISIÓN DE LA CARRERA DE ";
        }

		$dia=date('d');
		setlocale(LC_ALL,"spanish");
		$mes=strftime("%B");
		$año=date('Y');
		$encargadop=utf8_decode('Profesor Responsable de Evaluar la Actividad Complementaria');

if($carrera==9)
        {
            $texto = utf8_decode('El (la) que suscribe '.$abreviacion.' '.$nombre_jefe.', Jefe del Departamento de '.$carrera_nombre.', por este medio me permito hacer de su conocimiento que el (la) estudiante  '.$nombre.' '.$ap.' '.$am.' con Número de Cuenta '.$cuenta.' ha ACREDITADO las Actividades Complementarias, con un nivel de desempeño '.$cuantitativa.'  y un valor numérico de '.$promedio.'  así como un valor curricular de '.$creditos.' créditos.');
        }
        else
        {
             $texto = utf8_decode('El (la) que suscribe '.$abreviacion.' '.$nombre_jefe.', Jefe de División de la Carrera de '.$carrera_nombre.', por este medio me permito hacer de su conocimiento que el (la) estudiante  '.$nombre.' '.$ap.' '.$am.' con Número de Cuenta '.$cuenta.' ha ACREDITADO las Actividades Complementarias, con un nivel de desempeño '.$cuantitativa.'  y un valor numérico de '.$promedio.'  así como un valor curricular de '.$creditos.' créditos.');
        }



		$pdf->MultiCell(175,5,$texto);
		$pdf->Ln(12);
		$pdf->Cell(80,10,utf8_decode('Se extiende la presente en la Ciudad Típica de Valle de Bravo a los '.$dia.' días de '.$mes.' de '.$año.'.'),0,0,'');
		$pdf->Ln(30);
		$pdf->Cell(60);
		$pdf->Cell(60,10,utf8_decode('A T E N T A M E N T E'),0,0,'C');
        $pdf->SetXY(65,-80); 
        $pdf->MultiCell(90,10,utf8_decode($jefe)); 
		$pdf->Ln(0.5);
		$pdf->Cell(60);
        $pdf->Cell(60,5,utf8_decode(''.utf8_decode($encarga).''.$carrera_nombre),0,0,'C');
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
