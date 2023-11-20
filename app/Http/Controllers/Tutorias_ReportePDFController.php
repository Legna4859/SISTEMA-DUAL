<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use App\Tutorias_Reporte_tutor;
use Illuminate\Support\Facades\DB;
class PDF extends FPDF
{
    function Header()
    {
        $this->Image('img/edomex.png',10,0,40,20);
        $this->Image('img/TESVB.png',145,3,28,11);
        $this->Image('img/edomex1.png',176,2,30,13);
        $this->Line(175,2.5,175,14);
    }
    function Footer()
    {
        $this->Image('img/pie.png', 0, $this->GetY(), 210,30);
    }
}
class Tutorias_ReportePDFController extends Controller
{
     public function reporte_pdf()
     {
         $pr = Auth::user()->email;
         $fecha = DB::select('select Date_format(now(),"%d/%m/%Y") as fecha');
         /////////////Encabezado
         $tabla = DB::table('exp_generacion')
             ->join('exp_asigna_generacion', 'exp_asigna_generacion.id_generacion', '=', 'exp_generacion.id_generacion')
             ->join('exp_asigna_alumnos', 'exp_asigna_alumnos.id_asigna_generacion', '=', 'exp_asigna_generacion.id_asigna_generacion')
             ->join('gnral_alumnos', 'gnral_alumnos.id_alumno', '=', 'exp_asigna_alumnos.id_alumno')
             ->join('gnral_carreras', 'gnral_carreras.id_carrera', '=', 'gnral_alumnos.id_carrera')
             ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_generacion', '=', 'exp_asigna_generacion.id_asigna_generacion')
             ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
             ->join('gnral_jefes_periodos', 'gnral_jefes_periodos.id_jefe_periodo', '=', 'exp_asigna_tutor.id_jefe_periodo')
             ->join('gnral_periodos', 'gnral_periodos.id_periodo', '=', 'gnral_jefes_periodos.id_periodo')
             ->join('users', 'users.email', '=', 'gnral_personales.correo')
             ->where('users.email', '=', $pr)
             ->whereNull('exp_asigna_generacion.deleted_at')
             ->whereNull('exp_asigna_tutor.deleted_at')
             ->whereNull('exp_asigna_alumnos.deleted_at')
             ->where('exp_asigna_alumnos.estado','=',1)
             ->where('exp_generacion.generacion','=',2016)
             ->groupBy('exp_generacion.generacion')
             ->select('exp_generacion.generacion', 'gnral_personales.nombre', 'gnral_periodos.periodo', 'gnral_carreras.nombre as carr')
             ->get();
         /// contenido de la tabla
         $consulta = DB::table('reporte_tutor')
             ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
             ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
             ->join('users', 'users.email', '=', 'gnral_personales.correo')
             ->where('users.email', '=', $pr)
             ->where('reporte_tutor.generacion', '=', 2016)
             ->whereNull('exp_asigna_tutor.deleted_at')
             ->select('gnral_personales.nombre', 'reporte_tutor.n_cuenta', 'reporte_tutor.alumno', 'reporte_tutor.appaterno',
                 'reporte_tutor.apmaterno', 'reporte_tutor.tutoria_grupal',
                 'reporte_tutor.tutoria_individual', 'reporte_tutor.beca', 'reporte_tutor.repeticion',
                 'reporte_tutor.especial', 'reporte_tutor.academico', 'reporte_tutor.medico',
                 'reporte_tutor.psicologico', 'reporte_tutor.baja', 'reporte_tutor.observaciones')
             ->get();
         /////////////////
         $totales1 = DB::table('reporte_tutor')
             ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
             ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
             ->join('users', 'users.email', '=', 'gnral_personales.correo')
             ->where('users.email', '=', $pr)
             ->where('reporte_tutor.generacion', '=', 2016)
             ->whereNull('exp_asigna_tutor.deleted_at')
             ->select(DB::raw("count(reporte_tutor.tutoria_grupal) AS grupal"))
             ->get();
         $totales2 = DB::table('reporte_tutor')
             ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
             ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
             ->join('users', 'users.email', '=', 'gnral_personales.correo')
             ->where('users.email', '=', $pr)
             ->where('reporte_tutor.generacion', '=', 2016)
             ->whereNull('exp_asigna_tutor.deleted_at')
             ->select(DB::raw("count(reporte_tutor.tutoria_individual) AS individual"))
             ->get();
         $totales3 = DB::table('reporte_tutor')
             ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
             ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
             ->join('users', 'users.email', '=', 'gnral_personales.correo')
             ->where('users.email', '=', $pr)
             ->where('reporte_tutor.generacion', '=', 2016)
             ->whereNull('exp_asigna_tutor.deleted_at')
             ->select(DB::raw("count(reporte_tutor.beca) AS beca"))
             ->get();
         $totales4 = DB::table('reporte_tutor')
             ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
             ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
             ->join('users', 'users.email', '=', 'gnral_personales.correo')
             ->where('users.email', '=', $pr)
             ->where('reporte_tutor.generacion', '=', 2016)
             ->whereNull('exp_asigna_tutor.deleted_at')
             ->select(DB::raw("count(reporte_tutor.repeticion) AS repe"))
             ->get();
         $totales5 = DB::table('reporte_tutor')
             ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
             ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
             ->join('users', 'users.email', '=', 'gnral_personales.correo')
             ->where('users.email', '=', $pr)
             ->where('reporte_tutor.generacion', '=', 2016)
             ->whereNull('exp_asigna_tutor.deleted_at')
             ->select(DB::raw("count(reporte_tutor.especial) AS espe"))
             ->get();
         $totales6 = DB::table('reporte_tutor')
             ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
             ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
             ->join('users', 'users.email', '=', 'gnral_personales.correo')
             ->where('users.email', '=', $pr)
             ->where('reporte_tutor.generacion', '=', 2016)
             ->whereNull('exp_asigna_tutor.deleted_at')
             ->select(DB::raw("count(reporte_tutor.academico) AS aca"))
             ->get();
         $totales7 = DB::table('reporte_tutor')
             ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
             ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
             ->join('users', 'users.email', '=', 'gnral_personales.correo')
             ->where('users.email', '=', $pr)
             ->where('reporte_tutor.generacion', '=', 2016)
             ->whereNull('exp_asigna_tutor.deleted_at')
             ->select(DB::raw("count(reporte_tutor.medico) AS med"))
             ->get();
         $totales8 = DB::table('reporte_tutor')
             ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
             ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
             ->join('users', 'users.email', '=', 'gnral_personales.correo')
             ->where('users.email', '=', $pr)
             ->where('reporte_tutor.generacion', '=', 2016)
             ->whereNull('exp_asigna_tutor.deleted_at')
             ->select(DB::raw("count(reporte_tutor.psicologico) AS ps"))
             ->get();
         $totales9 = DB::table('reporte_tutor')
             ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
             ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
             ->join('users', 'users.email', '=', 'gnral_personales.correo')
             ->where('users.email', '=', $pr)
             ->where('reporte_tutor.generacion', '=', 2016)
             ->whereNull('exp_asigna_tutor.deleted_at')
             ->select(DB::raw("count(reporte_tutor.baja) AS baja"))
             ->get();
         $pdf = new PDF();
         $pdf->AddPage();
         $pdf->ln(10);
         $pdf->SetFont('Arial', 'B', 7);
         $pdf->SetFillColor(255, 255, 255);
         $etiqueta=DB::table('etiqueta')
             ->where('id_etiqueta','=',1)
             ->select('etiqueta.descripcion')
             ->get();
         $etiqueta=$etiqueta[0]->descripcion;
         $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode($etiqueta), 0, 1, "C", "true");
         $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO"), 0, 1, "C", "true");
         $pdf->SetFillColor(97, 182, 35);
         $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("REPORTE SEMESTRAL DE TUTOR"), 0, 1, "C", "true");
         $pdf->SetFillColor(255, 255, 255);
         $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "Tutor:  " . utf8_decode($tabla[0]->nombre), 1, 1, "L", "true");

         $pdf->Cell(88, 4, utf8_decode("Programa educativo:  ") . utf8_decode($tabla[0]->carr), 1, 0, "L", "true");
         $pdf->Cell(17, 4, utf8_decode("Grupo:  ") . utf8_decode("2016"), 1, 0, "L", "true");
         $pdf->Cell(56, 4, utf8_decode("Periodo:  ") . utf8_decode($tabla[0]->periodo), 1, 0, "L", "true");
         $pdf->Cell(29, 4, utf8_decode("Fecha:  ") . utf8_decode($fecha[0]->fecha), 1, 0, "L", "true");
         $pdf->ln();
         $pdf->ln();
         $pdf->Cell(15, 12, utf8_decode("No.Cuenta"), 1, 0, "L", "true");
         $pdf->Cell(45, 12, utf8_decode("Nombre"), 1, 0, "C", "true");
         $pdf->Cell(130, 4, utf8_decode("ESTUDIANTES ATENDIDOS"), 1, 0, "C", "true");
         $pdf->ln();
         $pdf->Cell(60, 4);
         $pdf->Cell(20, 4, utf8_decode("Tutoria"), 1, 0, "C", "true");
         $pdf->Cell(10, 4, utf8_decode("Beca"), 1, 0, "C", "true");
         $pdf->Cell(20, 4, utf8_decode("En curso"), 1, 0, "C", "true");
         $pdf->Cell(35, 4, utf8_decode("Canalizados en el semestre"), 1, 0, "C", "true");
         $pdf->Cell(10, 4, utf8_decode("Baja"), 1, 0, "C", "true");
         $pdf->Cell(35, 4, ("Observaciones"), 1, 0, "C");
         $pdf->ln();
         $pdf->Cell(60, 4);
         $pdf->Cell(10, 4, utf8_decode("Grupal"), 1, 0, "L", "true");
         $pdf->Cell(10, 4, utf8_decode("Indiv"), 1, 0, "L", "true");
         $pdf->Cell(10, 4, "", 0, 0);
         $pdf->Cell(10, 4, utf8_decode("Repet"), 1, 0, "L", "true");
         $pdf->Cell(10, 4, utf8_decode("Espec"), 1, 0, "L", "true");
         $pdf->Cell(11, 4, utf8_decode("Acad"), 1, 0, "L", "true");
         $pdf->Cell(11, 4, utf8_decode("Médico"), 1, 0, "L", "true");
         $pdf->Cell(13, 4, utf8_decode("Psicol"), 1, 0, "L", "true");
         $pdf->Cell(10, 4);
         $pdf->Cell(35, 4, "", 1, 0);
         $pdf->ln();
         $pdf->SetDrawColor(010, 010, 010);
         //tabla
         $pdf->SetFont('Arial', 'B', 5);
         if(count($consulta)==0){}
         else{
             for ($i = 0; $i < count($consulta); $i++) {
                 $pdf->Cell(15, 4, "" . utf8_decode($consulta[$i]->n_cuenta), 1, 0, "C");
                 $pdf->SetFont('Arial', 'B', 5);
                 $pdf->Cell(45, 4, utf8_decode(mb_strtoupper($consulta[$i]->appaterno)) . " " . utf8_decode(mb_strtoupper($consulta[$i]->apmaterno)) . " " .utf8_decode(mb_strtoupper($consulta[$i]->alumno)), 1, 0, "L", "true");
                 $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->tutoria_grupal), 1, 0, "C");
                 $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->tutoria_individual), 1, 0, "C");
                 $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->beca), 1, 0, "C");
                 $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->repeticion), 1, 0, "C");
                 $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->especial), 1, 0, "C");
                 $pdf->Cell(11, 4, "" . utf8_decode($consulta[$i]->academico), 1, 0, "C");
                 $pdf->Cell(11, 4, "" . utf8_decode($consulta[$i]->medico), 1, 0, "C");
                 $pdf->Cell(13, 4, "" . utf8_decode($consulta[$i]->psicologico), 1, 0, "C");
                 $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->baja), 1, 0, "C");
                 $pdf->Cell(35, 4, "" . utf8_decode($consulta[$i]->observaciones), 1, 0, "C");
                 $pdf->ln();
             }
         }
         $pdf->Cell(15, 4);
         $pdf->Cell(45, 4, "Total", 1, 0, "R");
         $pdf->Cell(10, 4, utf8_decode($totales1[0]->grupal), 1, 0, "C");
         $pdf->Cell(10, 4, utf8_decode($totales2[0]->individual), 1, 0, "C");
         $pdf->Cell(10, 4, utf8_decode($totales3[0]->beca), 1, 0, "C");
         $pdf->Cell(10, 4, utf8_decode($totales4[0]->repe), 1, 0, "C");
         $pdf->Cell(10, 4, utf8_decode($totales5[0]->espe), 1, 0, "C");
         $pdf->Cell(11, 4, utf8_decode($totales6[0]->aca), 1, 0, "C");
         $pdf->Cell(11, 4, utf8_decode($totales7[0]->med), 1, 0, "C");
         $pdf->Cell(13, 4, utf8_decode($totales8[0]->ps), 1, 0, "C");
         $pdf->Cell(10, 4, utf8_decode($totales9[0]->baja), 1, 0, "C");
         $pdf->ln(20);
         if(count($consulta)==0){$pdf->Cell(45, 4, utf8_decode(""), 0, 0, "C");}
         else{$pdf->Cell(45, 4, utf8_decode($consulta[0]->nombre), 0, 0, "C");}
         $pdf->Cell(5, 4);
         $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
         $pdf->Cell(5, 4);
         $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
         $pdf->Cell(5, 4);
         $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
         $pdf->ln();
         $pdf->Cell(45, 4, "TUTOR", 0, 0, "C");
         $pdf->Cell(5, 4);
         $pdf->Cell(45, 4, utf8_decode("COORDINADOR(A) DE TUTORÍAS CARRERA"), 0, 0, "C");
         $pdf->Cell(5, 4);
         $pdf->Cell(45, 4, utf8_decode("JEFE DE DIVISIÓN DE CARRERA"), 0, 0, "C");
         $pdf->Cell(5, 4);
         $pdf->Cell(45, 4, "COORDINADOR INSTITUCIONAL", 0, 0, "C");
         $pdf->ln(19);
         $pdf->Output();
         exit();
     }
     public function reporte_pdf2()
    {
        $pr = Auth::user()->email;
        $fecha = DB::select('select Date_format(now(),"%d/%m/%Y") as fecha');
        /////////////Encabezado
        $tabla = DB::table('exp_generacion')
            ->join('exp_asigna_generacion', 'exp_asigna_generacion.id_generacion', '=', 'exp_generacion.id_generacion')
            ->join('exp_asigna_alumnos', 'exp_asigna_alumnos.id_asigna_generacion', '=', 'exp_asigna_generacion.id_asigna_generacion')
            ->join('gnral_alumnos', 'gnral_alumnos.id_alumno', '=', 'exp_asigna_alumnos.id_alumno')
            ->join('gnral_carreras', 'gnral_carreras.id_carrera', '=', 'gnral_alumnos.id_carrera')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_generacion', '=', 'exp_asigna_generacion.id_asigna_generacion')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('gnral_jefes_periodos', 'gnral_jefes_periodos.id_jefe_periodo', '=', 'exp_asigna_tutor.id_jefe_periodo')
            ->join('gnral_periodos', 'gnral_periodos.id_periodo', '=', 'gnral_jefes_periodos.id_periodo')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->whereNull('exp_asigna_generacion.deleted_at')
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->whereNull('exp_asigna_alumnos.deleted_at')
            ->where('exp_asigna_alumnos.estado','=',1)
            ->where('exp_generacion.generacion','=',2017)
            ->groupBy('exp_generacion.generacion')
            ->select('exp_generacion.generacion', 'gnral_personales.nombre', 'gnral_periodos.periodo', 'gnral_carreras.nombre as carr')
            ->get();
        /// contenido de la tabla
        $consulta = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2017)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select('gnral_personales.nombre', 'reporte_tutor.n_cuenta', 'reporte_tutor.alumno', 'reporte_tutor.appaterno',
                'reporte_tutor.apmaterno', 'reporte_tutor.tutoria_grupal',
                'reporte_tutor.tutoria_individual', 'reporte_tutor.beca', 'reporte_tutor.repeticion',
                'reporte_tutor.especial', 'reporte_tutor.academico', 'reporte_tutor.medico',
                'reporte_tutor.psicologico', 'reporte_tutor.baja', 'reporte_tutor.observaciones')
            ->get();
        /////////////////
        $totales1 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2017)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.tutoria_grupal) AS grupal"))
            ->get();
        $totales2 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2017)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.tutoria_individual) AS individual"))
            ->get();
        $totales3 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2017)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.beca) AS beca"))
            ->get();
        $totales4 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2017)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.repeticion) AS repe"))
            ->get();
        $totales5 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2017)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.especial) AS espe"))
            ->get();
        $totales6 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2017)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.academico) AS aca"))
            ->get();
        $totales7 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2017)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.medico) AS med"))
            ->get();
        $totales8 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2017)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.psicologico) AS ps"))
            ->get();
        $totales9 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2017)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.baja) AS baja"))
            ->get();
        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->ln(10);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("2020.''Año de Laura Méndez de Cuenca; emblema de la mujer Mexiquense''"), 0, 1, "C", "true");
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO"), 0, 1, "C", "true");
        $pdf->SetFillColor(97, 182, 35);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("REPORTE SEMESTRAL DE TUTOR"), 0, 1, "C", "true");
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "Tutor:  " . utf8_decode($tabla[0]->nombre), 1, 1, "L", "true");

        $pdf->Cell(88, 4, utf8_decode("Programa educativo:  ") . utf8_decode($tabla[0]->carr), 1, 0, "L", "true");
        $pdf->Cell(17, 4, utf8_decode("Grupo:  ") . utf8_decode("2017"), 1, 0, "L", "true");
        $pdf->Cell(56, 4, utf8_decode("Periodo:  ") . utf8_decode($tabla[0]->periodo), 1, 0, "L", "true");
        $pdf->Cell(29, 4, utf8_decode("Fecha:  ") . utf8_decode($fecha[0]->fecha), 1, 0, "L", "true");
        $pdf->ln();
        $pdf->ln();
        $pdf->Cell(15, 12, utf8_decode("No.Cuenta"), 1, 0, "L", "true");
        $pdf->Cell(45, 12, utf8_decode("Nombre"), 1, 0, "C", "true");
        $pdf->Cell(130, 4, utf8_decode("ESTUDIANTES ATENDIDOS"), 1, 0, "C", "true");
        $pdf->ln();
        $pdf->Cell(60, 4);
        $pdf->Cell(20, 4, utf8_decode("Tutoria"), 1, 0, "C", "true");
        $pdf->Cell(10, 4, utf8_decode("Beca"), 1, 0, "C", "true");
        $pdf->Cell(20, 4, utf8_decode("En curso"), 1, 0, "C", "true");
        $pdf->Cell(35, 4, utf8_decode("Canalizados en el semestre"), 1, 0, "C", "true");
        $pdf->Cell(10, 4, utf8_decode("Baja"), 1, 0, "C", "true");
        $pdf->Cell(35, 4, ("Observaciones"), 1, 0, "C");
        $pdf->ln();
        $pdf->Cell(60, 4);
        $pdf->Cell(10, 4, utf8_decode("Grupal"), 1, 0, "L", "true");
        $pdf->Cell(10, 4, utf8_decode("Indiv"), 1, 0, "L", "true");
        $pdf->Cell(10, 4, "", 0, 0);
        $pdf->Cell(10, 4, utf8_decode("Repet"), 1, 0, "L", "true");
        $pdf->Cell(10, 4, utf8_decode("Espec"), 1, 0, "L", "true");
        $pdf->Cell(11, 4, utf8_decode("Acad"), 1, 0, "L", "true");
        $pdf->Cell(11, 4, utf8_decode("Médico"), 1, 0, "L", "true");
        $pdf->Cell(13, 4, utf8_decode("Psicol"), 1, 0, "L", "true");
        $pdf->Cell(10, 4);
        $pdf->Cell(35, 4, "", 1, 0);
        $pdf->ln();
        $pdf->SetDrawColor(010, 010, 010);
        //tabla
        $pdf->SetFont('Arial', 'B', 5);
        if(count($consulta)==0){}
        else{
            for ($i = 0; $i < count($consulta); $i++) {
                $pdf->Cell(15, 4, "" . utf8_decode($consulta[$i]->n_cuenta), 1, 0, "C");
                $pdf->SetFont('Arial', 'B', 5);
                $pdf->Cell(45, 4, utf8_decode(mb_strtoupper($consulta[$i]->appaterno)) . " " . utf8_decode(mb_strtoupper($consulta[$i]->apmaterno)) . " " .utf8_decode(mb_strtoupper($consulta[$i]->alumno)), 1, 0, "L", "true");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->tutoria_grupal), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->tutoria_individual), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->beca), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->repeticion), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->especial), 1, 0, "C");
                $pdf->Cell(11, 4, "" . utf8_decode($consulta[$i]->academico), 1, 0, "C");
                $pdf->Cell(11, 4, "" . utf8_decode($consulta[$i]->medico), 1, 0, "C");
                $pdf->Cell(13, 4, "" . utf8_decode($consulta[$i]->psicologico), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->baja), 1, 0, "C");
                $pdf->Cell(35, 4, "" . utf8_decode($consulta[$i]->observaciones), 1, 0, "C");
                $pdf->ln();
            }
        }
        $pdf->Cell(15, 4);
        $pdf->Cell(45, 4, "Total", 1, 0, "R");
        $pdf->Cell(10, 4, utf8_decode($totales1[0]->grupal), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales2[0]->individual), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales3[0]->beca), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales4[0]->repe), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales5[0]->espe), 1, 0, "C");
        $pdf->Cell(11, 4, utf8_decode($totales6[0]->aca), 1, 0, "C");
        $pdf->Cell(11, 4, utf8_decode($totales7[0]->med), 1, 0, "C");
        $pdf->Cell(13, 4, utf8_decode($totales8[0]->ps), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales9[0]->baja), 1, 0, "C");
        $pdf->ln(20);
        if(count($consulta)==0){$pdf->Cell(45, 4, utf8_decode(""), 0, 0, "C");}
        else{$pdf->Cell(45, 4, utf8_decode($consulta[0]->nombre), 0, 0, "C");}
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
        $pdf->ln();
        $pdf->Cell(45, 4, "TUTOR", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, utf8_decode("COORDINADOR(A) DE TUTORÍAS CARRERA"), 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, utf8_decode("JEFE DE DIVISIÓN DE CARRERA"), 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "COORDINADOR INSTITUCIONAL", 0, 0, "C");
        $pdf->ln(19);
        $pdf->Output();
        exit();
    }
     public function reporte_pdf3()
    {
        $pr = Auth::user()->email;
        $fecha = DB::select('select Date_format(now(),"%d/%m/%Y") as fecha');
        /////////////Encabezado
        $tabla = DB::table('exp_generacion')
            ->join('exp_asigna_generacion', 'exp_asigna_generacion.id_generacion', '=', 'exp_generacion.id_generacion')
            ->join('exp_asigna_alumnos', 'exp_asigna_alumnos.id_asigna_generacion', '=', 'exp_asigna_generacion.id_asigna_generacion')
            ->join('gnral_alumnos', 'gnral_alumnos.id_alumno', '=', 'exp_asigna_alumnos.id_alumno')
            ->join('gnral_carreras', 'gnral_carreras.id_carrera', '=', 'gnral_alumnos.id_carrera')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_generacion', '=', 'exp_asigna_generacion.id_asigna_generacion')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('gnral_jefes_periodos', 'gnral_jefes_periodos.id_jefe_periodo', '=', 'exp_asigna_tutor.id_jefe_periodo')
            ->join('gnral_periodos', 'gnral_periodos.id_periodo', '=', 'gnral_jefes_periodos.id_periodo')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->whereNull('exp_asigna_generacion.deleted_at')
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->whereNull('exp_asigna_alumnos.deleted_at')
            ->where('exp_asigna_alumnos.estado','=',1)
            ->where('exp_generacion.generacion','=',2018)
            ->groupBy('exp_generacion.generacion')
            ->select('exp_generacion.generacion', 'gnral_personales.nombre', 'gnral_periodos.periodo', 'gnral_carreras.nombre as carr')
            ->get();
        /// contenido de la tabla
        $consulta = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2018)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select('gnral_personales.nombre', 'reporte_tutor.n_cuenta', 'reporte_tutor.alumno', 'reporte_tutor.appaterno',
                'reporte_tutor.apmaterno', 'reporte_tutor.tutoria_grupal',
                'reporte_tutor.tutoria_individual', 'reporte_tutor.beca', 'reporte_tutor.repeticion',
                'reporte_tutor.especial', 'reporte_tutor.academico', 'reporte_tutor.medico',
                'reporte_tutor.psicologico', 'reporte_tutor.baja', 'reporte_tutor.observaciones')
            ->get();
        /////////////////
        $totales1 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2018)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.tutoria_grupal) AS grupal"))
            ->get();
        $totales2 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2018)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.tutoria_individual) AS individual"))
            ->get();
        $totales3 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2018)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.beca) AS beca"))
            ->get();
        $totales4 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2018)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.repeticion) AS repe"))
            ->get();
        $totales5 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2018)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.especial) AS espe"))
            ->get();
        $totales6 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2018)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.academico) AS aca"))
            ->get();
        $totales7 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2018)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.medico) AS med"))
            ->get();
        $totales8 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2018)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.psicologico) AS ps"))
            ->get();
        $totales9 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2018)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.baja) AS baja"))
            ->get();
        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->ln(10);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("2020.''Año de Laura Méndez de Cuenca; emblema de la mujer Mexiquense''"), 0, 1, "C", "true");
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO"), 0, 1, "C", "true");
        $pdf->SetFillColor(97, 182, 35);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("REPORTE SEMESTRAL DE TUTOR"), 0, 1, "C", "true");
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "Tutor:  " . utf8_decode($tabla[0]->nombre), 1, 1, "L", "true");

        $pdf->Cell(88, 4, utf8_decode("Programa educativo:  ") . utf8_decode($tabla[0]->carr), 1, 0, "L", "true");
        $pdf->Cell(17, 4, utf8_decode("Grupo:  ") . utf8_decode("2018"), 1, 0, "L", "true");
        $pdf->Cell(56, 4, utf8_decode("Periodo:  ") . utf8_decode($tabla[0]->periodo), 1, 0, "L", "true");
        $pdf->Cell(29, 4, utf8_decode("Fecha:  ") . utf8_decode($fecha[0]->fecha), 1, 0, "L", "true");
        $pdf->ln();
        $pdf->ln();
        $pdf->Cell(15, 12, utf8_decode("No.Cuenta"), 1, 0, "L", "true");
        $pdf->Cell(45, 12, utf8_decode("Nombre"), 1, 0, "C", "true");
        $pdf->Cell(130, 4, utf8_decode("ESTUDIANTES ATENDIDOS"), 1, 0, "C", "true");
        $pdf->ln();
        $pdf->Cell(60, 4);
        $pdf->Cell(20, 4, utf8_decode("Tutoria"), 1, 0, "C", "true");
        $pdf->Cell(10, 4, utf8_decode("Beca"), 1, 0, "C", "true");
        $pdf->Cell(20, 4, utf8_decode("En curso"), 1, 0, "C", "true");
        $pdf->Cell(35, 4, utf8_decode("Canalizados en el semestre"), 1, 0, "C", "true");
        $pdf->Cell(10, 4, utf8_decode("Baja"), 1, 0, "C", "true");
        $pdf->Cell(35, 4, ("Observaciones"), 1, 0, "C");
        $pdf->ln();
        $pdf->Cell(60, 4);
        $pdf->Cell(10, 4, utf8_decode("Grupal"), 1, 0, "L", "true");
        $pdf->Cell(10, 4, utf8_decode("Indiv"), 1, 0, "L", "true");
        $pdf->Cell(10, 4, "", 0, 0);
        $pdf->Cell(10, 4, utf8_decode("Repet"), 1, 0, "L", "true");
        $pdf->Cell(10, 4, utf8_decode("Espec"), 1, 0, "L", "true");
        $pdf->Cell(11, 4, utf8_decode("Acad"), 1, 0, "L", "true");
        $pdf->Cell(11, 4, utf8_decode("Médico"), 1, 0, "L", "true");
        $pdf->Cell(13, 4, utf8_decode("Psicol"), 1, 0, "L", "true");
        $pdf->Cell(10, 4);
        $pdf->Cell(35, 4, "", 1, 0);
        $pdf->ln();
        $pdf->SetDrawColor(010, 010, 010);
        //tabla
        $pdf->SetFont('Arial', 'B', 5);
        if(count($consulta)==0){}
        else{
            for ($i = 0; $i < count($consulta); $i++) {
                $pdf->Cell(15, 4, "" . utf8_decode($consulta[$i]->n_cuenta), 1, 0, "C");
                $pdf->SetFont('Arial', 'B', 5);
                $pdf->Cell(45, 4, utf8_decode(mb_strtoupper($consulta[$i]->appaterno)) . " " . utf8_decode(mb_strtoupper($consulta[$i]->apmaterno)) . " " .utf8_decode(mb_strtoupper($consulta[$i]->alumno)), 1, 0, "L", "true");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->tutoria_grupal), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->tutoria_individual), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->beca), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->repeticion), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->especial), 1, 0, "C");
                $pdf->Cell(11, 4, "" . utf8_decode($consulta[$i]->academico), 1, 0, "C");
                $pdf->Cell(11, 4, "" . utf8_decode($consulta[$i]->medico), 1, 0, "C");
                $pdf->Cell(13, 4, "" . utf8_decode($consulta[$i]->psicologico), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->baja), 1, 0, "C");
                $pdf->Cell(35, 4, "" . utf8_decode($consulta[$i]->observaciones), 1, 0, "C");
                $pdf->ln();
            }
        }
        $pdf->Cell(15, 4);
        $pdf->Cell(45, 4, "Total", 1, 0, "R");
        $pdf->Cell(10, 4, utf8_decode($totales1[0]->grupal), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales2[0]->individual), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales3[0]->beca), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales4[0]->repe), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales5[0]->espe), 1, 0, "C");
        $pdf->Cell(11, 4, utf8_decode($totales6[0]->aca), 1, 0, "C");
        $pdf->Cell(11, 4, utf8_decode($totales7[0]->med), 1, 0, "C");
        $pdf->Cell(13, 4, utf8_decode($totales8[0]->ps), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales9[0]->baja), 1, 0, "C");
        $pdf->ln(20);
        if(count($consulta)==0){$pdf->Cell(45, 4, utf8_decode(""), 0, 0, "C");}
        else{$pdf->Cell(45, 4, utf8_decode($consulta[0]->nombre), 0, 0, "C");}
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
        $pdf->ln();
        $pdf->Cell(45, 4, "TUTOR", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, utf8_decode("COORDINADOR(A) DE TUTORÍAS CARRERA"), 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, utf8_decode("JEFE DE DIVISIÓN DE CARRERA"), 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "COORDINADOR INSTITUCIONAL", 0, 0, "C");
        $pdf->ln(19);
        $pdf->Output();
        exit();
    }
     public function reporte_pdf4()
    {
        $pr = Auth::user()->email;
        $fecha = DB::select('select Date_format(now(),"%d/%m/%Y") as fecha');
        /////////////Encabezado
        $tabla = DB::table('exp_generacion')
            ->join('exp_asigna_generacion', 'exp_asigna_generacion.id_generacion', '=', 'exp_generacion.id_generacion')
            ->join('exp_asigna_alumnos', 'exp_asigna_alumnos.id_asigna_generacion', '=', 'exp_asigna_generacion.id_asigna_generacion')
            ->join('gnral_alumnos', 'gnral_alumnos.id_alumno', '=', 'exp_asigna_alumnos.id_alumno')
            ->join('gnral_carreras', 'gnral_carreras.id_carrera', '=', 'gnral_alumnos.id_carrera')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_generacion', '=', 'exp_asigna_generacion.id_asigna_generacion')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('gnral_jefes_periodos', 'gnral_jefes_periodos.id_jefe_periodo', '=', 'exp_asigna_tutor.id_jefe_periodo')
            ->join('gnral_periodos', 'gnral_periodos.id_periodo', '=', 'gnral_jefes_periodos.id_periodo')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->whereNull('exp_asigna_generacion.deleted_at')
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->whereNull('exp_asigna_alumnos.deleted_at')
            ->where('exp_asigna_alumnos.estado','=',1)
            ->where('exp_generacion.generacion','=',2019)
            ->groupBy('exp_generacion.generacion')
            ->select('exp_generacion.generacion', 'gnral_personales.nombre', 'gnral_periodos.periodo', 'gnral_carreras.nombre as carr')
            ->get();
        /// contenido de la tabla
        $consulta = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2019)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select('gnral_personales.nombre', 'reporte_tutor.n_cuenta', 'reporte_tutor.alumno', 'reporte_tutor.appaterno',
                'reporte_tutor.apmaterno', 'reporte_tutor.tutoria_grupal',
                'reporte_tutor.tutoria_individual', 'reporte_tutor.beca', 'reporte_tutor.repeticion',
                'reporte_tutor.especial', 'reporte_tutor.academico', 'reporte_tutor.medico',
                'reporte_tutor.psicologico', 'reporte_tutor.baja', 'reporte_tutor.observaciones')
            ->get();
        /////////////////
        $totales1 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2019)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.tutoria_grupal) AS grupal"))
            ->get();
        $totales2 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2019)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.tutoria_individual) AS individual"))
            ->get();
        $totales3 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2019)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.beca) AS beca"))
            ->get();
        $totales4 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2019)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.repeticion) AS repe"))
            ->get();
        $totales5 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2019)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.especial) AS espe"))
            ->get();
        $totales6 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2019)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.academico) AS aca"))
            ->get();
        $totales7 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2019)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.medico) AS med"))
            ->get();
        $totales8 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2019)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.psicologico) AS ps"))
            ->get();
        $totales9 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2019)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.baja) AS baja"))
            ->get();
        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->ln(10);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("2020.''Año de Laura Méndez de Cuenca; emblema de la mujer Mexiquense''"), 0, 1, "C", "true");
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO"), 0, 1, "C", "true");
        $pdf->SetFillColor(97, 182, 35);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("REPORTE SEMESTRAL DE TUTOR"), 0, 1, "C", "true");
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "Tutor:  " . utf8_decode($tabla[0]->nombre), 1, 1, "L", "true");

        $pdf->Cell(88, 4, utf8_decode("Programa educativo:  ") . utf8_decode($tabla[0]->carr), 1, 0, "L", "true");
        $pdf->Cell(17, 4, utf8_decode("Grupo:  ") . utf8_decode("2019"), 1, 0, "L", "true");
        $pdf->Cell(56, 4, utf8_decode("Periodo:  ") . utf8_decode($tabla[0]->periodo), 1, 0, "L", "true");
        $pdf->Cell(29, 4, utf8_decode("Fecha:  ") . utf8_decode($fecha[0]->fecha), 1, 0, "L", "true");
        $pdf->ln();
        $pdf->ln();
        $pdf->Cell(15, 12, utf8_decode("No.Cuenta"), 1, 0, "L", "true");
        $pdf->Cell(45, 12, utf8_decode("Nombre"), 1, 0, "C", "true");
        $pdf->Cell(130, 4, utf8_decode("ESTUDIANTES ATENDIDOS"), 1, 0, "C", "true");
        $pdf->ln();
        $pdf->Cell(60, 4);
        $pdf->Cell(20, 4, utf8_decode("Tutoria"), 1, 0, "C", "true");
        $pdf->Cell(10, 4, utf8_decode("Beca"), 1, 0, "C", "true");
        $pdf->Cell(20, 4, utf8_decode("En curso"), 1, 0, "C", "true");
        $pdf->Cell(35, 4, utf8_decode("Canalizados en el semestre"), 1, 0, "C", "true");
        $pdf->Cell(10, 4, utf8_decode("Baja"), 1, 0, "C", "true");
        $pdf->Cell(35, 4, ("Observaciones"), 1, 0, "C");
        $pdf->ln();
        $pdf->Cell(60, 4);
        $pdf->Cell(10, 4, utf8_decode("Grupal"), 1, 0, "L", "true");
        $pdf->Cell(10, 4, utf8_decode("Indiv"), 1, 0, "L", "true");
        $pdf->Cell(10, 4, "", 0, 0);
        $pdf->Cell(10, 4, utf8_decode("Repet"), 1, 0, "L", "true");
        $pdf->Cell(10, 4, utf8_decode("Espec"), 1, 0, "L", "true");
        $pdf->Cell(11, 4, utf8_decode("Acad"), 1, 0, "L", "true");
        $pdf->Cell(11, 4, utf8_decode("Médico"), 1, 0, "L", "true");
        $pdf->Cell(13, 4, utf8_decode("Psicol"), 1, 0, "L", "true");
        $pdf->Cell(10, 4);
        $pdf->Cell(35, 4, "", 1, 0);
        $pdf->ln();
        $pdf->SetDrawColor(010, 010, 010);
        //tabla
        $pdf->SetFont('Arial', 'B', 5);
        if(count($consulta)==0){}
        else{
            for ($i = 0; $i < count($consulta); $i++) {
                $pdf->Cell(15, 4, "" . utf8_decode($consulta[$i]->n_cuenta), 1, 0, "C");
                $pdf->SetFont('Arial', 'B', 5);
                $pdf->Cell(45, 4, utf8_decode(mb_strtoupper($consulta[$i]->appaterno)) . " " . utf8_decode(mb_strtoupper($consulta[$i]->apmaterno)) . " " .utf8_decode(mb_strtoupper($consulta[$i]->alumno)), 1, 0, "L", "true");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->tutoria_grupal), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->tutoria_individual), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->beca), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->repeticion), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->especial), 1, 0, "C");
                $pdf->Cell(11, 4, "" . utf8_decode($consulta[$i]->academico), 1, 0, "C");
                $pdf->Cell(11, 4, "" . utf8_decode($consulta[$i]->medico), 1, 0, "C");
                $pdf->Cell(13, 4, "" . utf8_decode($consulta[$i]->psicologico), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->baja), 1, 0, "C");
                $pdf->Cell(35, 4, "" . utf8_decode($consulta[$i]->observaciones), 1, 0, "C");
                $pdf->ln();
            }
        }
        $pdf->Cell(15, 4);
        $pdf->Cell(45, 4, "Total", 1, 0, "R");
        $pdf->Cell(10, 4, utf8_decode($totales1[0]->grupal), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales2[0]->individual), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales3[0]->beca), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales4[0]->repe), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales5[0]->espe), 1, 0, "C");
        $pdf->Cell(11, 4, utf8_decode($totales6[0]->aca), 1, 0, "C");
        $pdf->Cell(11, 4, utf8_decode($totales7[0]->med), 1, 0, "C");
        $pdf->Cell(13, 4, utf8_decode($totales8[0]->ps), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales9[0]->baja), 1, 0, "C");
        $pdf->ln(20);
        if(count($consulta)==0){$pdf->Cell(45, 4, utf8_decode(""), 0, 0, "C");}
        else{$pdf->Cell(45, 4, utf8_decode($consulta[0]->nombre), 0, 0, "C");}
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
        $pdf->ln();
        $pdf->Cell(45, 4, "TUTOR", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, utf8_decode("COORDINADOR(A) DE TUTORÍAS CARRERA"), 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, utf8_decode("JEFE DE DIVISIÓN DE CARRERA"), 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "COORDINADOR INSTITUCIONAL", 0, 0, "C");
        $pdf->ln(19);
        $pdf->Output();
        exit();
    }
     public function reporte_pdf5()
    {
        $pr = Auth::user()->email;
        $fecha = DB::select('select Date_format(now(),"%d/%m/%Y") as fecha');
        /////////////Encabezado
        $tabla = DB::table('exp_generacion')
            ->join('exp_asigna_generacion', 'exp_asigna_generacion.id_generacion', '=', 'exp_generacion.id_generacion')
            ->join('exp_asigna_alumnos', 'exp_asigna_alumnos.id_asigna_generacion', '=', 'exp_asigna_generacion.id_asigna_generacion')
            ->join('gnral_alumnos', 'gnral_alumnos.id_alumno', '=', 'exp_asigna_alumnos.id_alumno')
            ->join('gnral_carreras', 'gnral_carreras.id_carrera', '=', 'gnral_alumnos.id_carrera')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_generacion', '=', 'exp_asigna_generacion.id_asigna_generacion')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('gnral_jefes_periodos', 'gnral_jefes_periodos.id_jefe_periodo', '=', 'exp_asigna_tutor.id_jefe_periodo')
            ->join('gnral_periodos', 'gnral_periodos.id_periodo', '=', 'gnral_jefes_periodos.id_periodo')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->whereNull('exp_asigna_generacion.deleted_at')
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->whereNull('exp_asigna_alumnos.deleted_at')
            ->where('exp_asigna_alumnos.estado','=',1)
            ->where('exp_generacion.generacion','=',2020)
            ->groupBy('exp_generacion.generacion')
            ->select('exp_generacion.generacion', 'gnral_personales.nombre', 'gnral_periodos.periodo', 'gnral_carreras.nombre as carr')
            ->get();
        /// contenido de la tabla
        $consulta = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2020)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select('gnral_personales.nombre', 'reporte_tutor.n_cuenta', 'reporte_tutor.alumno', 'reporte_tutor.appaterno',
                'reporte_tutor.apmaterno', 'reporte_tutor.tutoria_grupal',
                'reporte_tutor.tutoria_individual', 'reporte_tutor.beca', 'reporte_tutor.repeticion',
                'reporte_tutor.especial', 'reporte_tutor.academico', 'reporte_tutor.medico',
                'reporte_tutor.psicologico', 'reporte_tutor.baja', 'reporte_tutor.observaciones')
            ->get();
        /////////////////
        $totales1 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2020)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.tutoria_grupal) AS grupal"))
            ->get();
        $totales2 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2020)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.tutoria_individual) AS individual"))
            ->get();
        $totales3 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2020)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.beca) AS beca"))
            ->get();
        $totales4 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2020)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.repeticion) AS repe"))
            ->get();
        $totales5 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2020)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.especial) AS espe"))
            ->get();
        $totales6 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2020)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.academico) AS aca"))
            ->get();
        $totales7 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2020)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.medico) AS med"))
            ->get();
        $totales8 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2020)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.psicologico) AS ps"))
            ->get();
        $totales9 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2020)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.baja) AS baja"))
            ->get();
        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->ln(10);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("2020.''Año de Laura Méndez de Cuenca; emblema de la mujer Mexiquense''"), 0, 1, "C", "true");
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO"), 0, 1, "C", "true");
        $pdf->SetFillColor(97, 182, 35);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("REPORTE SEMESTRAL DE TUTOR"), 0, 1, "C", "true");
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "Tutor:  " . utf8_decode($tabla[0]->nombre), 1, 1, "L", "true");

        $pdf->Cell(88, 4, utf8_decode("Programa educativo:  ") . utf8_decode($tabla[0]->carr), 1, 0, "L", "true");
        $pdf->Cell(17, 4, utf8_decode("Grupo:  ") . utf8_decode("2020"), 1, 0, "L", "true");
        $pdf->Cell(56, 4, utf8_decode("Periodo:  ") . utf8_decode($tabla[0]->periodo), 1, 0, "L", "true");
        $pdf->Cell(29, 4, utf8_decode("Fecha:  ") . utf8_decode($fecha[0]->fecha), 1, 0, "L", "true");
        $pdf->ln();
        $pdf->ln();
        $pdf->Cell(15, 12, utf8_decode("No.Cuenta"), 1, 0, "L", "true");
        $pdf->Cell(45, 12, utf8_decode("Nombre"), 1, 0, "C", "true");
        $pdf->Cell(130, 4, utf8_decode("ESTUDIANTES ATENDIDOS"), 1, 0, "C", "true");
        $pdf->ln();
        $pdf->Cell(60, 4);
        $pdf->Cell(20, 4, utf8_decode("Tutoria"), 1, 0, "C", "true");
        $pdf->Cell(10, 4, utf8_decode("Beca"), 1, 0, "C", "true");
        $pdf->Cell(20, 4, utf8_decode("En curso"), 1, 0, "C", "true");
        $pdf->Cell(35, 4, utf8_decode("Canalizados en el semestre"), 1, 0, "C", "true");
        $pdf->Cell(10, 4, utf8_decode("Baja"), 1, 0, "C", "true");
        $pdf->Cell(35, 4, ("Observaciones"), 1, 0, "C");
        $pdf->ln();
        $pdf->Cell(60, 4);
        $pdf->Cell(10, 4, utf8_decode("Grupal"), 1, 0, "L", "true");
        $pdf->Cell(10, 4, utf8_decode("Indiv"), 1, 0, "L", "true");
        $pdf->Cell(10, 4, "", 0, 0);
        $pdf->Cell(10, 4, utf8_decode("Repet"), 1, 0, "L", "true");
        $pdf->Cell(10, 4, utf8_decode("Espec"), 1, 0, "L", "true");
        $pdf->Cell(11, 4, utf8_decode("Acad"), 1, 0, "L", "true");
        $pdf->Cell(11, 4, utf8_decode("Médico"), 1, 0, "L", "true");
        $pdf->Cell(13, 4, utf8_decode("Psicol"), 1, 0, "L", "true");
        $pdf->Cell(10, 4);
        $pdf->Cell(35, 4, "", 1, 0);
        $pdf->ln();
        $pdf->SetDrawColor(010, 010, 010);
        //tabla
        $pdf->SetFont('Arial', 'B', 5);
        if(count($consulta)==0){}
        else{
            for ($i = 0; $i < count($consulta); $i++) {
                $pdf->Cell(15, 4, "" . utf8_decode($consulta[$i]->n_cuenta), 1, 0, "C");
                $pdf->SetFont('Arial', 'B', 5);
                $pdf->Cell(45, 4, utf8_decode(mb_strtoupper($consulta[$i]->appaterno)) . " " . utf8_decode(mb_strtoupper($consulta[$i]->apmaterno)) . " " .utf8_decode(mb_strtoupper($consulta[$i]->alumno)), 1, 0, "L", "true");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->tutoria_grupal), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->tutoria_individual), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->beca), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->repeticion), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->especial), 1, 0, "C");
                $pdf->Cell(11, 4, "" . utf8_decode($consulta[$i]->academico), 1, 0, "C");
                $pdf->Cell(11, 4, "" . utf8_decode($consulta[$i]->medico), 1, 0, "C");
                $pdf->Cell(13, 4, "" . utf8_decode($consulta[$i]->psicologico), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->baja), 1, 0, "C");
                $pdf->Cell(35, 4, "" . utf8_decode($consulta[$i]->observaciones), 1, 0, "C");
                $pdf->ln();
            }
        }
        $pdf->Cell(15, 4);
        $pdf->Cell(45, 4, "Total", 1, 0, "R");
        $pdf->Cell(10, 4, utf8_decode($totales1[0]->grupal), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales2[0]->individual), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales3[0]->beca), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales4[0]->repe), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales5[0]->espe), 1, 0, "C");
        $pdf->Cell(11, 4, utf8_decode($totales6[0]->aca), 1, 0, "C");
        $pdf->Cell(11, 4, utf8_decode($totales7[0]->med), 1, 0, "C");
        $pdf->Cell(13, 4, utf8_decode($totales8[0]->ps), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales9[0]->baja), 1, 0, "C");
        $pdf->ln(20);
        if(count($consulta)==0){$pdf->Cell(45, 4, utf8_decode(""), 0, 0, "C");}
        else{$pdf->Cell(45, 4, utf8_decode($consulta[0]->nombre), 0, 0, "C");}
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
        $pdf->ln();
        $pdf->Cell(45, 4, "TUTOR", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, utf8_decode("COORDINADOR(A) DE TUTORÍAS CARRERA"), 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, utf8_decode("JEFE DE DIVISIÓN DE CARRERA"), 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "COORDINADOR INSTITUCIONAL", 0, 0, "C");
        $pdf->ln(19);
        $pdf->Output();
        exit();
    }
     public function reporte_pdf6()
    {
        $pr = Auth::user()->email;
        $fecha = DB::select('select Date_format(now(),"%d/%m/%Y") as fecha');
        /////////////Encabezado
        $tabla = DB::table('exp_generacion')
            ->join('exp_asigna_generacion', 'exp_asigna_generacion.id_generacion', '=', 'exp_generacion.id_generacion')
            ->join('exp_asigna_alumnos', 'exp_asigna_alumnos.id_asigna_generacion', '=', 'exp_asigna_generacion.id_asigna_generacion')
            ->join('gnral_alumnos', 'gnral_alumnos.id_alumno', '=', 'exp_asigna_alumnos.id_alumno')
            ->join('gnral_carreras', 'gnral_carreras.id_carrera', '=', 'gnral_alumnos.id_carrera')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_generacion', '=', 'exp_asigna_generacion.id_asigna_generacion')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('gnral_jefes_periodos', 'gnral_jefes_periodos.id_jefe_periodo', '=', 'exp_asigna_tutor.id_jefe_periodo')
            ->join('gnral_periodos', 'gnral_periodos.id_periodo', '=', 'gnral_jefes_periodos.id_periodo')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->whereNull('exp_asigna_generacion.deleted_at')
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->whereNull('exp_asigna_alumnos.deleted_at')
            ->where('exp_asigna_alumnos.estado','=',1)
            ->where('exp_generacion.generacion','=',2021)
            ->groupBy('exp_generacion.generacion')
            ->select('exp_generacion.generacion', 'gnral_personales.nombre', 'gnral_periodos.periodo', 'gnral_carreras.nombre as carr')
            ->get();
        /// contenido de la tabla
        $consulta = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2021)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select('gnral_personales.nombre', 'reporte_tutor.n_cuenta', 'reporte_tutor.alumno', 'reporte_tutor.appaterno',
                'reporte_tutor.apmaterno', 'reporte_tutor.tutoria_grupal',
                'reporte_tutor.tutoria_individual', 'reporte_tutor.beca', 'reporte_tutor.repeticion',
                'reporte_tutor.especial', 'reporte_tutor.academico', 'reporte_tutor.medico',
                'reporte_tutor.psicologico', 'reporte_tutor.baja', 'reporte_tutor.observaciones')
            ->get();
        /////////////////
        $totales1 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2021)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.tutoria_grupal) AS grupal"))
            ->get();
        $totales2 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2021)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.tutoria_individual) AS individual"))
            ->get();
        $totales3 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2021)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.beca) AS beca"))
            ->get();
        $totales4 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2021)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.repeticion) AS repe"))
            ->get();
        $totales5 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2021)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.especial) AS espe"))
            ->get();
        $totales6 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2021)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.academico) AS aca"))
            ->get();
        $totales7 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2021)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.medico) AS med"))
            ->get();
        $totales8 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2021)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.psicologico) AS ps"))
            ->get();
        $totales9 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2021)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.baja) AS baja"))
            ->get();
        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->ln(10);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("2020.''Año de Laura Méndez de Cuenca; emblema de la mujer Mexiquense''"), 0, 1, "C", "true");
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO"), 0, 1, "C", "true");
        $pdf->SetFillColor(97, 182, 35);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("REPORTE SEMESTRAL DE TUTOR"), 0, 1, "C", "true");
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "Tutor:  " . utf8_decode($tabla[0]->nombre), 1, 1, "L", "true");

        $pdf->Cell(88, 4, utf8_decode("Programa educativo:  ") . utf8_decode($tabla[0]->carr), 1, 0, "L", "true");
        $pdf->Cell(17, 4, utf8_decode("Grupo:  ") . utf8_decode("2021"), 1, 0, "L", "true");
        $pdf->Cell(56, 4, utf8_decode("Periodo:  ") . utf8_decode($tabla[0]->periodo), 1, 0, "L", "true");
        $pdf->Cell(29, 4, utf8_decode("Fecha:  ") . utf8_decode($fecha[0]->fecha), 1, 0, "L", "true");
        $pdf->ln();
        $pdf->ln();
        $pdf->Cell(15, 12, utf8_decode("No.Cuenta"), 1, 0, "L", "true");
        $pdf->Cell(45, 12, utf8_decode("Nombre"), 1, 0, "C", "true");
        $pdf->Cell(130, 4, utf8_decode("ESTUDIANTES ATENDIDOS"), 1, 0, "C", "true");
        $pdf->ln();
        $pdf->Cell(60, 4);
        $pdf->Cell(20, 4, utf8_decode("Tutoria"), 1, 0, "C", "true");
        $pdf->Cell(10, 4, utf8_decode("Beca"), 1, 0, "C", "true");
        $pdf->Cell(20, 4, utf8_decode("En curso"), 1, 0, "C", "true");
        $pdf->Cell(35, 4, utf8_decode("Canalizados en el semestre"), 1, 0, "C", "true");
        $pdf->Cell(10, 4, utf8_decode("Baja"), 1, 0, "C", "true");
        $pdf->Cell(35, 4, ("Observaciones"), 1, 0, "C");
        $pdf->ln();
        $pdf->Cell(60, 4);
        $pdf->Cell(10, 4, utf8_decode("Grupal"), 1, 0, "L", "true");
        $pdf->Cell(10, 4, utf8_decode("Indiv"), 1, 0, "L", "true");
        $pdf->Cell(10, 4, "", 0, 0);
        $pdf->Cell(10, 4, utf8_decode("Repet"), 1, 0, "L", "true");
        $pdf->Cell(10, 4, utf8_decode("Espec"), 1, 0, "L", "true");
        $pdf->Cell(11, 4, utf8_decode("Acad"), 1, 0, "L", "true");
        $pdf->Cell(11, 4, utf8_decode("Médico"), 1, 0, "L", "true");
        $pdf->Cell(13, 4, utf8_decode("Psicol"), 1, 0, "L", "true");
        $pdf->Cell(10, 4);
        $pdf->Cell(35, 4, "", 1, 0);
        $pdf->ln();
        $pdf->SetDrawColor(010, 010, 010);
        //tabla
        $pdf->SetFont('Arial', 'B', 5);
        if(count($consulta)==0){}
        else{
            for ($i = 0; $i < count($consulta); $i++) {
                $pdf->Cell(15, 4, "" . utf8_decode($consulta[$i]->n_cuenta), 1, 0, "C");
                $pdf->SetFont('Arial', 'B', 5);
                $pdf->Cell(45, 4, utf8_decode(mb_strtoupper($consulta[$i]->appaterno)) . " " . utf8_decode(mb_strtoupper($consulta[$i]->apmaterno)) . " " .utf8_decode(mb_strtoupper($consulta[$i]->alumno)), 1, 0, "L", "true");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->tutoria_grupal), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->tutoria_individual), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->beca), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->repeticion), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->especial), 1, 0, "C");
                $pdf->Cell(11, 4, "" . utf8_decode($consulta[$i]->academico), 1, 0, "C");
                $pdf->Cell(11, 4, "" . utf8_decode($consulta[$i]->medico), 1, 0, "C");
                $pdf->Cell(13, 4, "" . utf8_decode($consulta[$i]->psicologico), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->baja), 1, 0, "C");
                $pdf->Cell(35, 4, "" . utf8_decode($consulta[$i]->observaciones), 1, 0, "C");
                $pdf->ln();
            }
        }
        $pdf->Cell(15, 4);
        $pdf->Cell(45, 4, "Total", 1, 0, "R");
        $pdf->Cell(10, 4, utf8_decode($totales1[0]->grupal), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales2[0]->individual), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales3[0]->beca), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales4[0]->repe), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales5[0]->espe), 1, 0, "C");
        $pdf->Cell(11, 4, utf8_decode($totales6[0]->aca), 1, 0, "C");
        $pdf->Cell(11, 4, utf8_decode($totales7[0]->med), 1, 0, "C");
        $pdf->Cell(13, 4, utf8_decode($totales8[0]->ps), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales9[0]->baja), 1, 0, "C");
        $pdf->ln(20);
        if(count($consulta)==0){$pdf->Cell(45, 4, utf8_decode(""), 0, 0, "C");}
        else{$pdf->Cell(45, 4, utf8_decode($consulta[0]->nombre), 0, 0, "C");}
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
        $pdf->ln();
        $pdf->Cell(45, 4, "TUTOR", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, utf8_decode("COORDINADOR(A) DE TUTORÍAS CARRERA"), 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, utf8_decode("JEFE DE DIVISIÓN DE CARRERA"), 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "COORDINADOR INSTITUCIONAL", 0, 0, "C");
        $pdf->ln(19);
        $pdf->Output();
        exit();
    }
     public function reporte_pdf7()
    {
        $pr = Auth::user()->email;
        $fecha = DB::select('select Date_format(now(),"%d/%m/%Y") as fecha');
        /////////////Encabezado
        $tabla = DB::table('exp_generacion')
            ->join('exp_asigna_generacion', 'exp_asigna_generacion.id_generacion', '=', 'exp_generacion.id_generacion')
            ->join('exp_asigna_alumnos', 'exp_asigna_alumnos.id_asigna_generacion', '=', 'exp_asigna_generacion.id_asigna_generacion')
            ->join('gnral_alumnos', 'gnral_alumnos.id_alumno', '=', 'exp_asigna_alumnos.id_alumno')
            ->join('gnral_carreras', 'gnral_carreras.id_carrera', '=', 'gnral_alumnos.id_carrera')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_generacion', '=', 'exp_asigna_generacion.id_asigna_generacion')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('gnral_jefes_periodos', 'gnral_jefes_periodos.id_jefe_periodo', '=', 'exp_asigna_tutor.id_jefe_periodo')
            ->join('gnral_periodos', 'gnral_periodos.id_periodo', '=', 'gnral_jefes_periodos.id_periodo')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->whereNull('exp_asigna_generacion.deleted_at')
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->whereNull('exp_asigna_alumnos.deleted_at')
            ->where('exp_asigna_alumnos.estado','=',1)
            ->where('exp_generacion.generacion','=',2022)
            ->groupBy('exp_generacion.generacion')
            ->select('exp_generacion.generacion', 'gnral_personales.nombre', 'gnral_periodos.periodo', 'gnral_carreras.nombre as carr')
            ->get();
        /// contenido de la tabla
        $consulta = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2022)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select('gnral_personales.nombre', 'reporte_tutor.n_cuenta', 'reporte_tutor.alumno', 'reporte_tutor.appaterno',
                'reporte_tutor.apmaterno', 'reporte_tutor.tutoria_grupal',
                'reporte_tutor.tutoria_individual', 'reporte_tutor.beca', 'reporte_tutor.repeticion',
                'reporte_tutor.especial', 'reporte_tutor.academico', 'reporte_tutor.medico',
                'reporte_tutor.psicologico', 'reporte_tutor.baja', 'reporte_tutor.observaciones')
            ->get();
        /////////////////
        $totales1 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2022)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.tutoria_grupal) AS grupal"))
            ->get();
        $totales2 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2022)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.tutoria_individual) AS individual"))
            ->get();
        $totales3 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2022)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.beca) AS beca"))
            ->get();
        $totales4 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2022)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.repeticion) AS repe"))
            ->get();
        $totales5 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2022)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.especial) AS espe"))
            ->get();
        $totales6 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2022)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.academico) AS aca"))
            ->get();
        $totales7 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2022)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.medico) AS med"))
            ->get();
        $totales8 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2022)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.psicologico) AS ps"))
            ->get();
        $totales9 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2022)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.baja) AS baja"))
            ->get();
        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->ln(10);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("2020.''Año de Laura Méndez de Cuenca; emblema de la mujer Mexiquense''"), 0, 1, "C", "true");
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO"), 0, 1, "C", "true");
        $pdf->SetFillColor(97, 182, 35);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("REPORTE SEMESTRAL DE TUTOR"), 0, 1, "C", "true");
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "Tutor:  " . utf8_decode($tabla[0]->nombre), 1, 1, "L", "true");

        $pdf->Cell(88, 4, utf8_decode("Programa educativo:  ") . utf8_decode($tabla[0]->carr), 1, 0, "L", "true");
        $pdf->Cell(17, 4, utf8_decode("Grupo:  ") . utf8_decode("2022"), 1, 0, "L", "true");
        $pdf->Cell(56, 4, utf8_decode("Periodo:  ") . utf8_decode($tabla[0]->periodo), 1, 0, "L", "true");
        $pdf->Cell(29, 4, utf8_decode("Fecha:  ") . utf8_decode($fecha[0]->fecha), 1, 0, "L", "true");
        $pdf->ln();
        $pdf->ln();
        $pdf->Cell(15, 12, utf8_decode("No.Cuenta"), 1, 0, "L", "true");
        $pdf->Cell(45, 12, utf8_decode("Nombre"), 1, 0, "C", "true");
        $pdf->Cell(130, 4, utf8_decode("ESTUDIANTES ATENDIDOS"), 1, 0, "C", "true");
        $pdf->ln();
        $pdf->Cell(60, 4);
        $pdf->Cell(20, 4, utf8_decode("Tutoria"), 1, 0, "C", "true");
        $pdf->Cell(10, 4, utf8_decode("Beca"), 1, 0, "C", "true");
        $pdf->Cell(20, 4, utf8_decode("En curso"), 1, 0, "C", "true");
        $pdf->Cell(35, 4, utf8_decode("Canalizados en el semestre"), 1, 0, "C", "true");
        $pdf->Cell(10, 4, utf8_decode("Baja"), 1, 0, "C", "true");
        $pdf->Cell(35, 4, ("Observaciones"), 1, 0, "C");
        $pdf->ln();
        $pdf->Cell(60, 4);
        $pdf->Cell(10, 4, utf8_decode("Grupal"), 1, 0, "L", "true");
        $pdf->Cell(10, 4, utf8_decode("Indiv"), 1, 0, "L", "true");
        $pdf->Cell(10, 4, "", 0, 0);
        $pdf->Cell(10, 4, utf8_decode("Repet"), 1, 0, "L", "true");
        $pdf->Cell(10, 4, utf8_decode("Espec"), 1, 0, "L", "true");
        $pdf->Cell(11, 4, utf8_decode("Acad"), 1, 0, "L", "true");
        $pdf->Cell(11, 4, utf8_decode("Médico"), 1, 0, "L", "true");
        $pdf->Cell(13, 4, utf8_decode("Psicol"), 1, 0, "L", "true");
        $pdf->Cell(10, 4);
        $pdf->Cell(35, 4, "", 1, 0);
        $pdf->ln();
        $pdf->SetDrawColor(010, 010, 010);
        //tabla
        $pdf->SetFont('Arial', 'B', 5);
        if(count($consulta)==0){}
        else{
            for ($i = 0; $i < count($consulta); $i++) {
                $pdf->Cell(15, 4, "" . utf8_decode($consulta[$i]->n_cuenta), 1, 0, "C");
                $pdf->SetFont('Arial', 'B', 5);
                $pdf->Cell(45, 4, utf8_decode(mb_strtoupper($consulta[$i]->appaterno)) . " " . utf8_decode(mb_strtoupper($consulta[$i]->apmaterno)) . " " .utf8_decode(mb_strtoupper($consulta[$i]->alumno)), 1, 0, "L", "true");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->tutoria_grupal), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->tutoria_individual), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->beca), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->repeticion), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->especial), 1, 0, "C");
                $pdf->Cell(11, 4, "" . utf8_decode($consulta[$i]->academico), 1, 0, "C");
                $pdf->Cell(11, 4, "" . utf8_decode($consulta[$i]->medico), 1, 0, "C");
                $pdf->Cell(13, 4, "" . utf8_decode($consulta[$i]->psicologico), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->baja), 1, 0, "C");
                $pdf->Cell(35, 4, "" . utf8_decode($consulta[$i]->observaciones), 1, 0, "C");
                $pdf->ln();
            }
        }
        $pdf->Cell(15, 4);
        $pdf->Cell(45, 4, "Total", 1, 0, "R");
        $pdf->Cell(10, 4, utf8_decode($totales1[0]->grupal), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales2[0]->individual), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales3[0]->beca), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales4[0]->repe), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales5[0]->espe), 1, 0, "C");
        $pdf->Cell(11, 4, utf8_decode($totales6[0]->aca), 1, 0, "C");
        $pdf->Cell(11, 4, utf8_decode($totales7[0]->med), 1, 0, "C");
        $pdf->Cell(13, 4, utf8_decode($totales8[0]->ps), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales9[0]->baja), 1, 0, "C");
        $pdf->ln(20);
        if(count($consulta)==0){$pdf->Cell(45, 4, utf8_decode(""), 0, 0, "C");}
        else{$pdf->Cell(45, 4, utf8_decode($consulta[0]->nombre), 0, 0, "C");}
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
        $pdf->ln();
        $pdf->Cell(45, 4, "TUTOR", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, utf8_decode("COORDINADOR(A) DE TUTORÍAS CARRERA"), 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, utf8_decode("JEFE DE DIVISIÓN DE CARRERA"), 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "COORDINADOR INSTITUCIONAL", 0, 0, "C");
        $pdf->ln(19);
        $pdf->Output();
        exit();
    }
     public function reporte_pdf8()
    {
        $pr = Auth::user()->email;
        $fecha = DB::select('select Date_format(now(),"%d/%m/%Y") as fecha');
        /////////////Encabezado
        $tabla = DB::table('exp_generacion')
            ->join('exp_asigna_generacion', 'exp_asigna_generacion.id_generacion', '=', 'exp_generacion.id_generacion')
            ->join('exp_asigna_alumnos', 'exp_asigna_alumnos.id_asigna_generacion', '=', 'exp_asigna_generacion.id_asigna_generacion')
            ->join('gnral_alumnos', 'gnral_alumnos.id_alumno', '=', 'exp_asigna_alumnos.id_alumno')
            ->join('gnral_carreras', 'gnral_carreras.id_carrera', '=', 'gnral_alumnos.id_carrera')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_generacion', '=', 'exp_asigna_generacion.id_asigna_generacion')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('gnral_jefes_periodos', 'gnral_jefes_periodos.id_jefe_periodo', '=', 'exp_asigna_tutor.id_jefe_periodo')
            ->join('gnral_periodos', 'gnral_periodos.id_periodo', '=', 'gnral_jefes_periodos.id_periodo')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->whereNull('exp_asigna_generacion.deleted_at')
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->whereNull('exp_asigna_alumnos.deleted_at')
            ->where('exp_asigna_alumnos.estado','=',1)
            ->where('exp_generacion.generacion','=',2023)
            ->groupBy('exp_generacion.generacion')
            ->select('exp_generacion.generacion', 'gnral_personales.nombre', 'gnral_periodos.periodo', 'gnral_carreras.nombre as carr')
            ->get();
        /// contenido de la tabla
        $consulta = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2023)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select('gnral_personales.nombre', 'reporte_tutor.n_cuenta', 'reporte_tutor.alumno', 'reporte_tutor.appaterno',
                'reporte_tutor.apmaterno', 'reporte_tutor.tutoria_grupal',
                'reporte_tutor.tutoria_individual', 'reporte_tutor.beca', 'reporte_tutor.repeticion',
                'reporte_tutor.especial', 'reporte_tutor.academico', 'reporte_tutor.medico',
                'reporte_tutor.psicologico', 'reporte_tutor.baja', 'reporte_tutor.observaciones')
            ->get();
        /////////////////
        $totales1 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2023)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.tutoria_grupal) AS grupal"))
            ->get();
        $totales2 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2023)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.tutoria_individual) AS individual"))
            ->get();
        $totales3 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2023)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.beca) AS beca"))
            ->get();
        $totales4 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2023)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.repeticion) AS repe"))
            ->get();
        $totales5 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2023)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.especial) AS espe"))
            ->get();
        $totales6 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2023)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.academico) AS aca"))
            ->get();
        $totales7 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2023)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.medico) AS med"))
            ->get();
        $totales8 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2023)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.psicologico) AS ps"))
            ->get();
        $totales9 = DB::table('reporte_tutor')
            ->join('exp_asigna_tutor', 'exp_asigna_tutor.id_asigna_tutor', '=', 'reporte_tutor.id_asigna_tutor')
            ->join('gnral_personales', 'gnral_personales.id_personal', '=', 'exp_asigna_tutor.id_personal')
            ->join('users', 'users.email', '=', 'gnral_personales.correo')
            ->where('users.email', '=', $pr)
            ->where('reporte_tutor.generacion', '=', 2023)
            ->whereNull('exp_asigna_tutor.deleted_at')
            ->select(DB::raw("count(reporte_tutor.baja) AS baja"))
            ->get();
        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->ln(10);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("2020.''Año de Laura Méndez de Cuenca; emblema de la mujer Mexiquense''"), 0, 1, "C", "true");
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("TECNOLÓGICO DE ESTUDIOS SUPERIORES DE VALLE DE BRAVO"), 0, 1, "C", "true");
        $pdf->SetFillColor(97, 182, 35);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "" . utf8_decode("REPORTE SEMESTRAL DE TUTOR"), 0, 1, "C", "true");
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(($pdf->GetPageWidth() - 20), 5, "Tutor:  " . utf8_decode($tabla[0]->nombre), 1, 1, "L", "true");

        $pdf->Cell(88, 4, utf8_decode("Programa educativo:  ") . utf8_decode($tabla[0]->carr), 1, 0, "L", "true");
        $pdf->Cell(17, 4, utf8_decode("Grupo:  ") . utf8_decode("2023"), 1, 0, "L", "true");
        $pdf->Cell(56, 4, utf8_decode("Periodo:  ") . utf8_decode($tabla[0]->periodo), 1, 0, "L", "true");
        $pdf->Cell(29, 4, utf8_decode("Fecha:  ") . utf8_decode($fecha[0]->fecha), 1, 0, "L", "true");
        $pdf->ln();
        $pdf->ln();
        $pdf->Cell(15, 12, utf8_decode("No.Cuenta"), 1, 0, "L", "true");
        $pdf->Cell(45, 12, utf8_decode("Nombre"), 1, 0, "C", "true");
        $pdf->Cell(130, 4, utf8_decode("ESTUDIANTES ATENDIDOS"), 1, 0, "C", "true");
        $pdf->ln();
        $pdf->Cell(60, 4);
        $pdf->Cell(20, 4, utf8_decode("Tutoria"), 1, 0, "C", "true");
        $pdf->Cell(10, 4, utf8_decode("Beca"), 1, 0, "C", "true");
        $pdf->Cell(20, 4, utf8_decode("En curso"), 1, 0, "C", "true");
        $pdf->Cell(35, 4, utf8_decode("Canalizados en el semestre"), 1, 0, "C", "true");
        $pdf->Cell(10, 4, utf8_decode("Baja"), 1, 0, "C", "true");
        $pdf->Cell(35, 4, ("Observaciones"), 1, 0, "C");
        $pdf->ln();
        $pdf->Cell(60, 4);
        $pdf->Cell(10, 4, utf8_decode("Grupal"), 1, 0, "L", "true");
        $pdf->Cell(10, 4, utf8_decode("Indiv"), 1, 0, "L", "true");
        $pdf->Cell(10, 4, "", 0, 0);
        $pdf->Cell(10, 4, utf8_decode("Repet"), 1, 0, "L", "true");
        $pdf->Cell(10, 4, utf8_decode("Espec"), 1, 0, "L", "true");
        $pdf->Cell(11, 4, utf8_decode("Acad"), 1, 0, "L", "true");
        $pdf->Cell(11, 4, utf8_decode("Médico"), 1, 0, "L", "true");
        $pdf->Cell(13, 4, utf8_decode("Psicol"), 1, 0, "L", "true");
        $pdf->Cell(10, 4);
        $pdf->Cell(35, 4, "", 1, 0);
        $pdf->ln();
        $pdf->SetDrawColor(010, 010, 010);
        //tabla
        $pdf->SetFont('Arial', 'B', 5);
        if(count($consulta)==0){}
        else{
            for ($i = 0; $i < count($consulta); $i++) {
                $pdf->Cell(15, 4, "" . utf8_decode($consulta[$i]->n_cuenta), 1, 0, "C");
                $pdf->SetFont('Arial', 'B', 5);
                $pdf->Cell(45, 4, utf8_decode(mb_strtoupper($consulta[$i]->appaterno)) . " " . utf8_decode(mb_strtoupper($consulta[$i]->apmaterno)) . " " .utf8_decode(mb_strtoupper($consulta[$i]->alumno)), 1, 0, "L", "true");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->tutoria_grupal), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->tutoria_individual), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->beca), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->repeticion), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->especial), 1, 0, "C");
                $pdf->Cell(11, 4, "" . utf8_decode($consulta[$i]->academico), 1, 0, "C");
                $pdf->Cell(11, 4, "" . utf8_decode($consulta[$i]->medico), 1, 0, "C");
                $pdf->Cell(13, 4, "" . utf8_decode($consulta[$i]->psicologico), 1, 0, "C");
                $pdf->Cell(10, 4, "" . utf8_decode($consulta[$i]->baja), 1, 0, "C");
                $pdf->Cell(35, 4, "" . utf8_decode($consulta[$i]->observaciones), 1, 0, "C");
                $pdf->ln();
            }
        }
        $pdf->Cell(15, 4);
        $pdf->Cell(45, 4, "Total", 1, 0, "R");
        $pdf->Cell(10, 4, utf8_decode($totales1[0]->grupal), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales2[0]->individual), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales3[0]->beca), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales4[0]->repe), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales5[0]->espe), 1, 0, "C");
        $pdf->Cell(11, 4, utf8_decode($totales6[0]->aca), 1, 0, "C");
        $pdf->Cell(11, 4, utf8_decode($totales7[0]->med), 1, 0, "C");
        $pdf->Cell(13, 4, utf8_decode($totales8[0]->ps), 1, 0, "C");
        $pdf->Cell(10, 4, utf8_decode($totales9[0]->baja), 1, 0, "C");
        $pdf->ln(20);
        if(count($consulta)==0){$pdf->Cell(45, 4, utf8_decode(""), 0, 0, "C");}
        else{$pdf->Cell(45, 4, utf8_decode($consulta[0]->nombre), 0, 0, "C");}
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "Nombre", 0, 0, "C");
        $pdf->ln();
        $pdf->Cell(45, 4, "TUTOR", 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, utf8_decode("COORDINADOR(A) DE TUTORÍAS CARRERA"), 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, utf8_decode("JEFE DE DIVISIÓN DE CARRERA"), 0, 0, "C");
        $pdf->Cell(5, 4);
        $pdf->Cell(45, 4, "COORDINADOR INSTITUCIONAL", 0, 0, "C");
        $pdf->ln(19);
        $pdf->Output();
        exit();
    }
}



