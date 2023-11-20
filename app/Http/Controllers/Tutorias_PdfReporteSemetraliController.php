<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;

class PDF extends FPDF
{
//CABECERA DE LA PAGINA
    function Header()
    {
        $this->Image('img/tutorias/edomex.png',10,0,40,20);
        $this->Image('img/tutorias/TESVB.png',145,3,28,11);
        $this->Image('img/tutorias/edomex1.png',176,2,30,13);
        $this->Line(175,2.5,175,14);
    }
//PIE DE PAGINA
    function Footer()
    {
        $this->SetY(-48);
        $this->SetFont('Times','',8);
        $this->Image('img/abajosolo.png',0,263,217,34);
        $this->Image('img/ress.jpg',39,258,38,22);
        $this->Image('img/rep_semcar.png',110,258,100,20);
        $this->Ln(35);
        $this->SetTextColor(255,255,255);
        $this->Cell(43);
        $this->Cell(1,0,utf8_decode('Km. 30 de la Carretera Federal Monumento - Valle de Bravo, Ejido de San Antonio de la Laguna'),0,0,'L',"");
        $this->Ln(3);
        $this->Cell(43);
        $this->Cell(1,0,utf8_decode('C.P. 51200, Valle de Bravo, Estado de México.'),0,0,'L',"");
        $this->Ln(3);
        $this->Cell(43);
        $this->Cell(1,0,utf8_decode('Tels. : (726) 26 6 52 00,  26 6 51 87'),0,0,'L',"");
        $this->Ln(3);
    }
}

class Tutorias_PdfReporteSemetraliController extends Controller
{
    public function pdf_reporteseminstitucional()
    {
        $fecha = DB::select('select Date_format(now(),"%d/%m/%Y") as fecha');
        $id_periodo = Session::get('periodo_actual');
        $periodo = DB::selectOne('SELECT periodo from gnral_periodos where id_periodo=' . $id_periodo . '');
        $carreras = DB::select('SELECT car.id_carrera, car.nombre FROM gnral_carreras car

WHERE car.id_carrera NOT IN (9)
AND car.id_carrera NOT IN (11)
AND car.id_carrera NOT IN (15)');
        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->ln(10);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(255, 255, 255);
        $etiqueta = DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');
        $pdf->Cell(($pdf->GetPageWidth() - 15), 5, "" . utf8_decode($etiqueta->descripcion), 0, 1, "C", "true");
        $pdf->Cell(($pdf->GetPageWidth() - 15), 5, "" . utf8_decode("TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO"), 1, 1, "C", "true");
        $pdf->SetFillColor(97, 182, 35);
        $pdf->Cell(($pdf->GetPageWidth() - 15), 5, "" . utf8_decode("REPORTE SEMESTRAL DEL COORDINADOR INSTITUCIONAL DE TUTORÍAS"), 0, 1, "C", "true");
        $pdf->SetFillColor(255, 255, 255);
        $nombre_cordinador=DB::SelectOne('SELECT gnral_personales.id_personal,gnral_personales.nombre, 
        abreviaciones.titulo from abreviaciones, abreviaciones_prof, gnral_personales, 
        desarrollo_asigna_coordinador_general WHERE 
        abreviaciones.id_abreviacion = abreviaciones_prof.id_abreviacion and 
        abreviaciones_prof.id_personal = gnral_personales.id_personal and
         gnral_personales.id_personal = desarrollo_asigna_coordinador_general.id_personal');
        $pdf->Cell(140, 4, utf8_decode("Coordinador(a) de Institucional de Tutorías:  ") . utf8_decode($nombre_cordinador->titulo) . " "
            . utf8_decode($nombre_cordinador->nombre), 1, 0, "L", "true");
        $pdf->Cell(55, 4, utf8_decode("Periodo:  " . $periodo->periodo) . utf8_decode(""), 1, 0, "L", "true");
        $pdf->ln();
        $pdf->ln();
        $pdf->Cell(7, 12, utf8_decode("No"), 1, 0, "L", "true");
        $pdf->Cell(45, 12, utf8_decode("Nombre"), 1, 0, "C", "true");
        $pdf->Cell(18, 12, utf8_decode("Cant. Tutores"), 1, 0, "C", "true");
        $pdf->Cell(125, 4, utf8_decode("ESTUDIANTES ATENDIDOS"), 1, 0, "C", "true");
        $pdf->ln();
        $pdf->Cell(70, 4);
        $pdf->Cell(18, 4, utf8_decode("Tutoria"), 1, 0, "C", "true");
        $pdf->Cell(10, 4, utf8_decode("Con"), 0, 0, "C", "true");
        $pdf->Cell(20, 4, utf8_decode("En curso"), 1, 0, "C", "true");
        $pdf->Cell(35, 4, utf8_decode("Canalizados en el semestre"), 1, 0, "C", "true");
        $pdf->Cell(10, 4, utf8_decode("Baja"), 'LR', 0, "C", "true");
        $pdf->Cell(12, 4, utf8_decode("Matricula"), 'LR', 0, "C", "true");
        $pdf->Cell(20 , 4, ("Observaciones"), 'LR', 0, "C", "true");
        $pdf->ln();
        $pdf->Cell(70, 4);
        $pdf->Cell(10, 4, utf8_decode("Grupal"), 1, 0, "L", "true");
        $pdf->Cell(8, 4, utf8_decode("Indiv"), 1, 0, "L", "true");
        $pdf->Cell(10, 4, "Beca", 0, 0, "C");
        $pdf->Cell(10, 4, utf8_decode("Repet."), 1, 0, "L", "true");
        $pdf->Cell(10, 4, utf8_decode("Espec."), 1, 0, "L", "true");
        $pdf->Cell(11, 4, utf8_decode("Acad."), 1, 0, "L", "true");
        $pdf->Cell(11, 4, utf8_decode("Med."), 1, 0, "L", "true");
        $pdf->Cell(13, 4, utf8_decode("Psicol."), 1, 0, "L", "true");
        $pdf->Cell(10, 4, utf8_decode(""), 'LR', 0, "C", "true");
        $pdf->Cell(12, 4, utf8_decode(""), 'LR', 0, "C", "true");
        $pdf->Cell(20 , 4, (""), 'LR', 0, "C", "true");
        $pdf->ln();
        $pdf->SetDrawColor(010, 010, 010);
        $pdf->SetFont('Arial', 'B', 5);


        $grupalT = 0;
        $individualT = 0;
        $becaT = 0;
        $repeticionT = 0;
        $especialidadT = 0;
        $academicoT = 0;
        $medicoT = 0;
        $psicologicoT = 0;
        $bajaT = 0;
        $tutoresT = 0;
        $j=0;
        for ($h = 0; $h < count($carreras); $h++) {
            $arreglo = (array)$carreras[$h];
            $id_c = $arreglo["id_carrera"];

            $carrera = DB::table('gnral_carreras')
                ->select('nombre', 'id_carrera')
                ->where('id_carrera', '=', $id_c)
                ->get();
            
            $pdf->Cell(7, 4, utf8_decode("" . $h + 1) . utf8_decode(""), 1, 0, "L", "true");
            $pdf->Cell(45, 4, utf8_decode($carrera[0]->nombre), 1, 0, "L", "true");

            /*Totales*/
            $periodo = Session::get('periodo_actual');
            $id_usuario = Session::get('usuario_alumno');
            $ca = $id_c;

            $tutores = DB::SELECT('SELECT exp_asigna_t.id_asigna_generacion,tu_grupo_s.id_grupo_semestre,car.nombre carrera, car.id_carrera, tu_grupo_t.descripcion grupo, gnral_p.nombre nombre_tutor, gnral_p.tipo_usuario tipo FROM tu_grupo_tutorias tu_grupo_t
INNER JOIN tu_grupo_semestre tu_grupo_s
ON tu_grupo_s.id_grupo_tutorias = tu_grupo_t.id_grupo_tutorias
INNER JOIN exp_asigna_tutor exp_asigna_t
ON exp_asigna_t.id_asigna_tutor = tu_grupo_s.id_asigna_tutor
INNER JOIN gnral_personales gnral_p
ON gnral_p.id_personal = exp_asigna_t.id_personal
INNER JOIN gnral_jefes_periodos gnral_j
ON gnral_j.id_jefe_periodo = exp_asigna_t.id_jefe_periodo
INNER JOIN gnral_carreras car
ON car.id_carrera = gnral_j.id_carrera
WHERE gnral_j.id_periodo = ' . $periodo . ' AND car.id_carrera = ' . $ca . ' ');

            $grupal = 0;
            $individual = 0;
            $beca = 0;
            $repeticion = 0;
            $especialidad = 0;
            $academico = 0;
            $medico = 0;
            $psicologico = 0;
            $baja = 0;
            $tutoresT = $tutoresT + count($tutores);
            foreach($tutores as $tutor) {

                $tut_grupal = DB::select('SELECT COUNT(reporte_tutor.tutoria_grupal) as tutoria_grupal
FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
reporte_tutor
WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno
AND gnral_alumnos.cuenta=exp_generales.no_cuenta
AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
AND exp_asigna_tutor.deleted_at is null
AND exp_asigna_generacion.deleted_at is null
AND exp_asigna_alumnos.deleted_at is null
AND reporte_tutor.tutoria_grupal="Si"
AND reporte_tutor.id_asigna_generacion=' . $tutor->id_asigna_generacion);
                $grupal = $grupal + $tut_grupal[0]->tutoria_grupal;
                $grupalT += $tut_grupal[0]->tutoria_grupal;

                $tut_ind = DB::select('SELECT COUNT(reporte_tutor.tutoria_individual) as tutoria_individual
FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
reporte_tutor
WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno
AND gnral_alumnos.cuenta=exp_generales.no_cuenta
AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
AND exp_asigna_tutor.deleted_at is null
AND exp_asigna_generacion.deleted_at is null
AND exp_asigna_alumnos.deleted_at is null
AND reporte_tutor.tutoria_individual="Si"
AND reporte_tutor.id_asigna_generacion=' . $tutor->id_asigna_generacion);
                $individual = $individual + $tut_ind[0]->tutoria_individual;
                $individualT += $tut_ind[0]->tutoria_individual;

                $bec = DB::select('SELECT COUNT(reporte_tutor.beca) as beca
FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
reporte_tutor
WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno
AND gnral_alumnos.cuenta=exp_generales.no_cuenta
AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
AND exp_asigna_tutor.deleted_at is null
AND exp_asigna_generacion.deleted_at is null
AND exp_asigna_alumnos.deleted_at is null
AND reporte_tutor.beca=1
AND reporte_tutor.id_asigna_generacion=' . $tutor->id_asigna_generacion);
                $beca = $beca + $bec[0]->beca;
                $becaT += $bec[0]->beca;

                $rep = DB::select('SELECT COUNT(reporte_tutor.repeticion) as repeticion
FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
reporte_tutor
WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno
AND gnral_alumnos.cuenta=exp_generales.no_cuenta
AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
AND exp_asigna_tutor.deleted_at is null
AND exp_asigna_generacion.deleted_at is null
AND exp_asigna_alumnos.deleted_at is null
AND reporte_tutor.repeticion = 1
AND reporte_tutor.id_asigna_generacion=' . $tutor->id_asigna_generacion);
                $repeticion = $repeticion + $rep[0]->repeticion;
                $repeticionT += $rep[0]->repeticion;

                $esp = DB::select('SELECT COUNT(reporte_tutor.especial) as especial
FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
reporte_tutor
WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno
AND gnral_alumnos.cuenta=exp_generales.no_cuenta
AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
AND exp_asigna_tutor.deleted_at is null
AND exp_asigna_generacion.deleted_at is null
AND exp_asigna_alumnos.deleted_at is null
AND reporte_tutor.especial = 1
AND reporte_tutor.id_asigna_generacion=' . $tutor->id_asigna_generacion);
                $especialidad = $especialidad + $esp[0]->especial;
                $especialidadT += $esp[0]->especial;

                $acad = DB::select('SELECT COUNT(reporte_tutor.academico) as academico
FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
reporte_tutor
WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno
AND gnral_alumnos.cuenta=exp_generales.no_cuenta
AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
AND exp_asigna_tutor.deleted_at is null
AND exp_asigna_generacion.deleted_at is null
AND exp_asigna_alumnos.deleted_at is null
AND reporte_tutor.academico = "Si"
AND reporte_tutor.id_asigna_generacion=' . $tutor->id_asigna_generacion);
                $academico = $academico + $acad[0]->academico;
                $academicoT += $acad[0]->academico;

                $med = DB::select('SELECT COUNT(reporte_tutor.medico) as medico
FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
reporte_tutor
WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno
AND gnral_alumnos.cuenta=exp_generales.no_cuenta
AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
AND exp_asigna_tutor.deleted_at is null
AND exp_asigna_generacion.deleted_at is null
AND exp_asigna_alumnos.deleted_at is null
AND reporte_tutor.medico = "Si"
AND reporte_tutor.id_asigna_generacion=' . $tutor->id_asigna_generacion);
                $medico = $medico + $med[0]->medico;
                $medicoT += $med[0]->medico;

                $psi = DB::select('SELECT COUNT(reporte_tutor.psicologico) as psicologico
FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
reporte_tutor
WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno
AND gnral_alumnos.cuenta=exp_generales.no_cuenta
AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
AND exp_asigna_tutor.deleted_at is null
AND exp_asigna_generacion.deleted_at is null
AND exp_asigna_alumnos.deleted_at is null
AND reporte_tutor.psicologico = "Si"
AND reporte_tutor.id_asigna_generacion=' . $tutor->id_asigna_generacion);
                $psicologico = $psicologico + $psi[0]->psicologico;
                $psicologicoT += $psi[0]->psicologico;

                $baj = DB::select('SELECT COUNT(reporte_tutor.baja) as baja
FROM exp_asigna_tutor,exp_asigna_generacion,exp_asigna_alumnos,gnral_alumnos,exp_generales,exp_generacion,
reporte_tutor
WHERE exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno
AND gnral_alumnos.cuenta=exp_generales.no_cuenta
AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion
AND reporte_tutor.n_cuenta=gnral_alumnos.cuenta
AND exp_asigna_tutor.deleted_at is null
AND exp_asigna_generacion.deleted_at is null
AND exp_asigna_alumnos.deleted_at is null
AND reporte_tutor.baja > 1
AND reporte_tutor.id_asigna_generacion=' . $tutor->id_asigna_generacion);
                $baja = $baja + $baj[0]->baja;
                $bajaT += $baj[0]->baja;
            }
            $periodo_actual=Session::get('periodo_actual');

            $pdf->Cell(18, 4, count($tutores), 1, 0, "C");
            $pdf->Cell(10, 4, $grupal, 1, 0, "C");
            $pdf->Cell(8, 4, $individual, 1, 0, "C");
            $pdf->Cell(10, 4, utf8_decode($beca), 1, 0, "C");
            $pdf->Cell(10, 4, utf8_decode($repeticion), 1, 0, "C");
            $pdf->Cell(10, 4, $especialidad, 1, 0, "C");
            $pdf->Cell(11, 4, $academico, 1, 0, "C");
            $pdf->Cell(11, 4, $medico, 1, 0, "C");
            $pdf->Cell(13, 4, $psicologico, 1, 0, "C");
            $pdf->Cell(10, 4, $baja, 1, 0, "C");
            $pdf->Cell(12, 4, $grupal, 1, 0, "C");
        
            $observaci = DB::selectOne("SELECT COUNT(id_carrera) contar from rep_institucional where observaciones != '' AND id_periodo = $periodo_actual AND id_carrera = $id_c");
          
        $observaci = $observaci->contar;
        if($observaci == 0){
            $pdf->Cell(20, 4, "", 1, 1, "C");
        }else{
            $j++;
            $observacion = DB::selectOne("SELECT *from rep_institucional where observaciones != '' AND id_periodo = $periodo_actual AND id_carrera = $id_c");
            $pdf->Cell(20, 4,  utf8_decode("Nota ".$j) , 1, 1, "C");
        }   
        }
        $pdf->Cell(7, 4, "", 1, 0, "C", "true");
        $pdf->Cell(45, 4, utf8_decode("Total"), 1, 0, "L", "true");
        $pdf->Cell(18, 4, $tutoresT, 1, 0, "C");
        $pdf->Cell(10, 4, $grupalT, 1, 0, "C");
        $pdf->Cell(8, 4, $individualT, 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($becaT), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($repeticionT), 1, 0, "C");
        $pdf->Cell(10, 4, $especialidadT, 1, 0, "C");
        $pdf->Cell(11, 4, $academicoT, 1, 0, "C");
        $pdf->Cell(11, 4, $medicoT, 1, 0, "C");
        $pdf->Cell(13, 4, $psicologicoT, 1, 0, "C");
        $pdf->Cell(10, 4, $bajaT, 1, 0, "C");
        $pdf->Cell(12, 4, $grupalT, 1, 0, "C");
        $pdf->Cell(20, 4, "" , 1, 0, "C");
        $dat_carreras = array();
        
 
         $i=0;
         $pdf->ln(10);
         $pdf->Cell(20, 4, "OBSERVACIONES", 0, 0, "C");
         $pdf->ln(4);
         
       foreach($carreras as $carrera){
       
         
         $observacioness = DB::selectOne("SELECT COUNT(id_carrera) contar from rep_institucional where observaciones != '' and id_periodo = $periodo_actual AND id_carrera = $carrera->id_carrera");
       
         if($observacioness->contar == 0){
           
         }else{
            $i++;
             $observaciones = DB::selectOne('SELECT *from rep_institucional where id_periodo = '.$periodo_actual.' AND id_carrera = '.$carrera->id_carrera.'');
             $pdf->Cell(190, 4, utf8_decode("Nota ".$i.": ".$observaciones->observaciones), 1, 1, "L");
         }
        
       }
        
        
        /*Firmas*/
       

    
        
             /*foreach($dat_carreras as $carr){
          $pdf->Cell(190, 4, utf8_decode("Nota ".$carr['i'].": ".$carr['observacion']), 1, 1, "L");
        }*/


        $pdf->ln(5);
        $pdf->Cell(5, 4);
        $pdf->Cell(85, 4, utf8_decode("ELABORO"), 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(50, 4, "Vo. Bo", 0, 0, "C");
        $pdf->ln(15);
        $pdf->Cell(5, 4);
        $pdf->Cell(5, 4);
        $pdf->Cell(85, 4, "________________________________________________", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "________________________________________________", 0, 0, "C");
        $pdf->ln();
        $pdf->Cell(5, 4);
        $pdf->Cell(5, 4);
        $pdf->Cell(85, 4, utf8_decode($nombre_cordinador->titulo." ".$nombre_cordinador->nombre), 0, 0, "C");
        $pdf->Cell(5, 4);
        $jefe_desarrollo=DB::SelectOne('SELECT gnral_personales.id_personal,gnral_personales.nombre, abreviaciones.titulo 
       from abreviaciones, abreviaciones_prof, gnral_personales, gnral_unidad_personal 
       WHERE abreviaciones.id_abreviacion = abreviaciones_prof.id_abreviacion
        and abreviaciones_prof.id_personal = gnral_personales.id_personal 
        and gnral_personales.id_personal = gnral_unidad_personal.id_personal 
        and gnral_unidad_personal.id_unidad_admin =27'); 
       $pdf->Cell(45, 4, utf8_decode($jefe_desarrollo->titulo." ".$jefe_desarrollo->nombre), 0, 0, "C");
       $pdf->ln();
        $pdf->Cell(5, 4);
        $pdf->Cell(95, 4, "COORDINADOR(A) INSTITUCIONAL ", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(35, 4, utf8_decode("JEFE(A) DE DESARROLLO ACADEMICO"), 0, 0, "C");
        $pdf->ln();
        $pdf->Cell(45, 4, "", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(5, 4);
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "", 0, 0, "C");
        $pdf->ln(10);
        $pdf->Output();
        exit();
    }
}


