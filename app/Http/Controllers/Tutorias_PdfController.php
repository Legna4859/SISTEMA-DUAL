<?php
namespace App\Http\Controllers;
use App\Tutorias_Exp_antecedentes_academico;
use App\Tutorias_Exp_area_psicopedagogica;
use App\Tutorias_Exp_datos_familiare;
use App\Tutorias_Exp_formacion_integral;
use App\Tutorias_Exp_generale;
use App\Tutorias_Exp_habitos_estudio;

//use App\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;
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
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Times','B',8);
        // Page number
        $this->Cell(0,10,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'C');
    }

}

class Tutorias_PdfController extends Controller
{
    public function pdf_all()
    {
        $datos_alumno=DB::selectOne('SELECT gnral_alumnos.*,gnral_semestres.descripcion semestre from gnral_alumnos, gnral_semestres 
where gnral_alumnos.id_semestre = gnral_semestres.id_semestre and gnral_alumnos.id_alumno='.Session::get('id_alumno').'');
        $datosGenerales= Tutorias_Exp_generale::where('id_alumno',Session::get('id_alumno'))->get();
        $datosAntecedentes= Tutorias_Exp_antecedentes_academico::where('id_alumno',Session::get('id_alumno'))->get();
        $datosFamiliares= Tutorias_Exp_datos_familiare::where('id_alumno',Session::get('id_alumno'))->get();
        $datosHabitos=Tutorias_Exp_habitos_estudio::where('id_alumno',Session::get('id_alumno'))->get();
        $datosFormacion= Tutorias_Exp_formacion_integral::where('id_alumno',Session::get('id_alumno'))->get();
        $datosArea= Tutorias_Exp_area_psicopedagogica::where('id_alumno',Session::get('id_alumno'))->get();

        $datosArea->load("rendimientoescolar","dominioidioma","otroidioma","conocimientocompu","aptitudespecial",
            "comprension1","preparacion1","estrategiasaprendizaje","organizacionactividades","concentracion1","solucionproblemas",
            "condicionesambientales","busquedabibliografica","trabajoequipo");
        $datosFamiliares->load('vives','union','parentesco');
        $datosGenerales->load('turno1','carrera','grupo','semestre','civil');
        $datosHabitos->load('intelectual');


        $datosArea->load("rendimientoescolar","dominioidioma","otroidioma","conocimientocompu","aptitudespecial",
            "comprension1","preparacion1","estrategiasaprendizaje","organizacionactividades","concentracion1","solucionproblemas",
            "condicionesambientales","busquedabibliografica","trabajoequipo");
        $datosFamiliares->load('vives','union','parentesco');
        $datosGenerales->load('turno1','carrera','grupo','semestre','civil');
        $datosHabitos->load('intelectual');


        $pdf= new \Codedge\Fpdf\Fpdf\Fpdf();
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(130,130,130);

        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(($pdf->GetPageWidth()-20),11,"EXPEDIENTE DEL TUTORADO".utf8_decode(""),1,4,"C","true");

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(156,156,156);
        $pdf->Cell(($pdf->GetPageWidth()-20),8,"DATOS GENERALES".utf8_decode(""),1,4,"C","true");
        $pdf->SetDrawColor(010,010,010);
        $pdf->Rect(180, 10, 15, 15, 'DF');

        switch ($datosGenerales[0]->foto){
            case 'image/jpeg':
                $ext='.jpeg';
                break;
            case 'image/png':
                $ext='.png';
                break;
            case 'image/jpg':
                $ext='.jpg';
                break;
        }

        $pdf->Image('Fotografias/'.$datosGenerales[0]->no_cuenta.$ext,180,10,20,19);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->SetTextColor(010,010,010);
        $pdf->SetFillColor(204,204,204);
        $pdf->Cell(25,4,"Programa educativo: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(80,4,"". utf8_decode($datosGenerales[0]->carrera->nombre),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(20,4,"Periodo: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(35,4,"". utf8_decode(Session::get('nombre_periodo')),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(20,4,"Grupo: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosGenerales[0]->grupo->grupo),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(20,4,"Estudiante: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(85,4,"". utf8_decode($datosGenerales[0]->nombre),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(20,4,"Edad: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosGenerales[0]->edad),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(20,4,"Sexo: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(25,4,"". utf8_decode($datosGenerales[0]->sexo=="M"?'Masculino':'Femenino'),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(25,4,"Fecha de nacimiento: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(15,4,"". utf8_decode($datos_alumno->fecha_nac),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(25,4,"Lugar de nacimiento: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(70,4,"". utf8_decode($datosGenerales[0]->lugar_nacimientos),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(20,4,"Semestre: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(35,4,"". utf8_decode($datos_alumno->semestre),1,0,"C");
        $pdf->Ln(4);

        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(15,4,"Estado civil: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(13,4,"". utf8_decode($datosGenerales[0]->civil->desc_ec),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(15,4,"No. Hijos: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        if ($datosGenerales[0]->no_hijos==1)
        {
            $datosGenerales[0]->no_hijos='0';
        }
        if ($datosGenerales[0]->no_hijos==2)
        {
            $datosGenerales[0]->no_hijos='1';
        }
        if ($datosGenerales[0]->no_hijos==3)
        {
            $datosGenerales[0]->no_hijos='2';
        }
        if ($datosGenerales[0]->no_hijos==4)
        {
            $datosGenerales[0]->no_hijos='3';
        }
        if ($datosGenerales[0]->no_hijos==5)
        {
            $datosGenerales[0]->no_hijos='4 o más';
        }
        $pdf->Cell(13,4,"". utf8_decode($datosGenerales[0]->no_hijos),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(15,4,utf8_decode("Dirección: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(119,4,"". utf8_decode($datosGenerales[0]->direccion),1,0,"C");
        $pdf->Ln(4);

        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/2,4,"e-mail: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/2,4,"". utf8_decode($datosGenerales[0]->correo),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,"Tel. Casa: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,"". utf8_decode($datosGenerales[0]->tel_casa),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,"Celular: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,"". utf8_decode($datosGenerales[0]->cel),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,utf8_decode("Nivel socio-económico"). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,"". utf8_decode($datosGenerales[0]->nivel_economico),1,0,"C");
        $pdf->Ln(4);

        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(10,4,utf8_decode("¿Trabaja?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosGenerales[0]->trabaja==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(15,4,utf8_decode("Ocupación: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(110,4,"". utf8_decode($datosGenerales[0]->ocupacion),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(10,4,"Horario: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(35,4,"". utf8_decode($datosGenerales[0]->horario),1,0,"C");
        $pdf->Ln(4);

        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(15,4,"No.Cuenta: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(14,4,"". utf8_decode($datosGenerales[0]->no_cuenta),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(18,4,utf8_decode("¿Cuenta con beca?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosGenerales[0]->beca==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(20,4,utf8_decode("¿Qué tipo de beca?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        if ($datosGenerales[0]->id_expbeca==1)
        {
            $datosGenerales[0]->id_expbeca='Manutención Federal';
        }
        if ($datosGenerales[0]->id_expbeca==2)
        {
            $datosGenerales[0]->id_expbeca='Benito Juárez';
        }
        if ($datosGenerales[0]->id_expbeca==3)
        {
            $datosGenerales[0]->id_expbeca='Permanencia';
        }
        if ($datosGenerales[0]->id_expbeca==4)
        {
            $datosGenerales[0]->id_expbeca='Excelencia Académica';
        }
        $pdf->Cell(55,4,"". utf8_decode($datosGenerales[0]->id_expbeca),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(19,4,utf8_decode("Estado académico: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        if ($datosGenerales[0]->estado==1)
        {
            $datosGenerales[0]->estado='Regular';
        }
        if ($datosGenerales[0]->estado==2)
        {
            $datosGenerales[0]->estado='Irregular';
        }
        if ($datosGenerales[0]->estado==3)
        {
            $datosGenerales[0]->estado='Suspensión';
        }
        if ($datosGenerales[0]->estado==4)
        {
            $datosGenerales[0]->estado='Baja temporal';
        }
        if ($datosGenerales[0]->estado==5)
        {
            $datosGenerales[0]->estado='Baja definitiva';
        }
        $pdf->Cell(16,4,"". utf8_decode($datosGenerales[0]->estado),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(10,4,"Turno: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(13,4,"". utf8_decode($datosGenerales[0]->turno1->descripcion_turno),1,0,"C");
        $pdf->Ln(4);



        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFillColor(156,156,156);
        $pdf->Cell(($pdf->GetPageWidth()-20),8,utf8_decode("ANTECEDENTES ACADÉMICOS").utf8_decode(""),1,4,"C","true");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->SetTextColor(010,010,010);
        $pdf->SetFillColor(204,204,204);
        $pdf->Cell(25,4,"Tipo de bachillerato: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosAntecedentes[0]->id_bachillerato==1?'Tecnico':'General'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(22,4,"Otros estudios: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(25,4,"". utf8_decode($datosAntecedentes[0]->otros_estudios==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,utf8_decode("Años en que curso el bachillerato: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(18,4,"". utf8_decode($datosAntecedentes[0]->anos_curso_bachillerato>5?'Mas':$datosAntecedentes[0]->anos_curso_bachillerato),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(30,4,utf8_decode("Año de terminación: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(15,4,"". utf8_decode($datosAntecedentes[0]->ano_terminacion),1,0,"C");
        $pdf->Ln(4);

        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(24,4,utf8_decode("Escuela de procedencia: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(136,4,"". utf8_decode($datosAntecedentes[0]->escuela_procedente),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(17,4,"Promedio: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(13,4,"". utf8_decode($datosAntecedentes[0]->promedio),1,0,"C");
        $pdf->Ln(4);

        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(60,4,"Materias reprobadas en el bachillerato: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(130,4,"". utf8_decode($datosAntecedentes[0]->materias_reprobadas),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        /*dos*/
        $pdf->Cell(42,4,"Otro programa educativo iniciado: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosAntecedentes[0]->otra_carrera_ini==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(15,4,utf8_decode("Institución: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(91,4,"". utf8_decode($datosAntecedentes[0]->institucion),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(22,4,"Semestres cursados: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosAntecedentes[0]->semestres_cursados),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(30,4,utf8_decode("Interrupciones en los estudios: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosAntecedentes[0]->interrupciones_estudios==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(40,4,utf8_decode("Razones de la interrupción en los estudios: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(110,4,"". utf8_decode($datosAntecedentes[0]->razones_interrupcion),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(58,4,utf8_decode("¿Cuál fue la razón por la que decidio estudiar en el TESVB?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(132,4,"". utf8_decode($datosAntecedentes[0]->razon_descide_estudiar_tesvb),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/2,4,utf8_decode("¿Tienes información sobre el perfil profesional del programa educativo?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/2,4,"". utf8_decode($datosAntecedentes[0]->sabedel_perfil_profesional),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(60,4,utf8_decode("¿Tuviste opciones vocacionales por otros programas educativos?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(13,4,"". utf8_decode($datosAntecedentes[0]->otras_opciones_vocales==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(15,4,utf8_decode("¿Cuáles?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(102,4,"". utf8_decode($datosAntecedentes[0]->cuales_otras_opciones_vocales),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(50,4,utf8_decode("¿Te gusta el programa educativo elegido?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(13,4,"". utf8_decode($datosAntecedentes[0]->tegusta_carrera_elegida==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(15,4,utf8_decode("¿Por qué?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(112,4,"". utf8_decode($datosAntecedentes[0]->porque_carrera_elegida),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(50,4,utf8_decode("¿Suspensión después de terminar el bachillerato?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosAntecedentes[0]->suspension_estudios_bachillerato==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,utf8_decode("Razones de suspensión de estudios: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(95,4,"". utf8_decode($datosAntecedentes[0]->razones_suspension_estudios),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/2,4,utf8_decode("¿Te estimula tu familia en tus estudios?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/2,4,"". utf8_decode($datosAntecedentes[0]->teestimula_familia==1?'Si':'No'),1,0,"C");
        $pdf->Ln(4);


        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFillColor(156,156,156);
        $pdf->Cell(($pdf->GetPageWidth()-20),8,"DATOS FAMILIARES".utf8_decode(""),1,4,"C","true");
        $pdf->SetTextColor(010,010,010);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->SetFillColor(204,204,204);
        $pdf->Cell(40,4,"Nombre del padre: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(85,4,"". utf8_decode($datosFamiliares[0]->nombre_padre),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,"Edad: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(30,4,"". utf8_decode($datosFamiliares[0]->edad_padre),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(25,4,utf8_decode("Ocupación: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(60,4,"". utf8_decode($datosFamiliares[0]->ocupacion_padre),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(25,4,"Lugar de residencia: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(80,4,"". utf8_decode($datosFamiliares[0]->lugar_residencia_padre),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(40,4,"Nombre de la madre: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(85,4,"". utf8_decode($datosFamiliares[0]->nombre_madre),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,"Edad: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(30,4,"". utf8_decode($datosFamiliares[0]->edad_madre),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(25,4,utf8_decode("Ocupación: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(60,4,"". utf8_decode($datosFamiliares[0]->ocupacion_madre),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(25,4,"Lugar de residencia: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(80,4,"". utf8_decode($datosFamiliares[0]->lugar_residencia_madre),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(33,4,utf8_decode("Número de hermanos, incluyéndote: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(8,4,"". utf8_decode($datosFamiliares[0]->no_hermanos),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(33,4,"Lugar que ocupas entre ellos: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(8,4,"". utf8_decode($datosFamiliares[0]->lugar_ocupas),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(25,4,"Actualmente vives con: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(27,4,"". utf8_decode($datosFamiliares[0]->vives->desc_opc),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(45,4,utf8_decode("Número total de personas con las que vives: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(11,4,"". utf8_decode($datosFamiliares[0]->no_personas),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,"Perteneces a una etnia indigena: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,"". utf8_decode($datosFamiliares[0]->etnia_indigena==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,utf8_decode("¿Cuál etnia?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,"". utf8_decode($datosFamiliares[0]->cual_etnia),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,"Hablas una lengua indigena: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,"". utf8_decode($datosFamiliares[0]->hablas_lengua_indigena==1?'Si':'No'),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(40,4,utf8_decode("¿Quién sostiene económicamente tu hogar?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(90,4,"". utf8_decode($datosFamiliares[0]->sostiene_economia_hogar),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,utf8_decode("¿Cómo consideras a tu familia?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(25,4,"". utf8_decode($datosFamiliares[0]->union->desc_union),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(30,4,"Nombre del tutor: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(90,4,"". utf8_decode($datosFamiliares[0]->nombre_tutor),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(30,4,"Parentesco:  ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(40,4,"". utf8_decode($datosFamiliares[0]->parentesco->desc_parentesco),1,0,"C");
        $pdf->Ln(4);



        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFillColor(156,156,156);
        $pdf->Cell(($pdf->GetPageWidth()-20),8,utf8_decode("HABITOS DE ESTUDIO").utf8_decode(""),1,4,"C","true");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->SetTextColor(010,010,010);
        $pdf->SetFillColor(204,204,204);

        $pdf->Cell(($pdf->GetPageWidth()-20)/4,4,"Tiempo dedicado a estudiar diariamente fuera de clase: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/4,4,"". utf8_decode($datosHabitos[0]->tiempo_empleado_estudiar==3?'2 horas':'3 horas'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/4,4,utf8_decode("¿Cómo es tu forma de trabajo intelectual?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/4,4,"". utf8_decode($datosHabitos[0]->intelectual->desc_opc),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/2,4,utf8_decode("Tu forma de estudio más utlizada: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/2,4,"". utf8_decode($datosHabitos[0]->forma_estudio),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(50,4,utf8_decode("¿Cómo empleas tu tiempo libre?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(140,4,"". utf8_decode($datosHabitos[0]->tiempo_libre),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(55,4,"Asignaturas preferidas: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(135,4,"". utf8_decode($datosHabitos[0]->asignatura_preferida),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(40,4,utf8_decode("¿Por qué?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(150,4,"". utf8_decode($datosHabitos[0]->porque_asignatura),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(55,4,utf8_decode("Asignaturas que te han sido difíciles: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(135,4,"". utf8_decode($datosHabitos[0]->asignatura_dificil),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(40,4,utf8_decode("¿Por qué?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(150,4,"". utf8_decode($datosHabitos[0]->porque_asignatura_dificil),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(60,4,utf8_decode("¿Qué opinión tines de ti mismo como estudiante?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(130,4,"". utf8_decode($datosHabitos[0]->opinion_tu_mismo_estudiante),1,0,"C");
        $pdf->Ln(4);



        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFillColor(156,156,156);
        $pdf->Cell(($pdf->GetPageWidth()-20),8,utf8_decode("FORMACIÓN INTEGRAL/SALUD").utf8_decode(""),1,4,"C","true");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->SetTextColor(010,010,010);
        $pdf->SetFillColor(204,204,204);
        $pdf->Cell(50,4,utf8_decode("¿Practica regularmente algún deporte?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosFormacion[0]->practica_deporte==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(30,4,"Especifica el deporte: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(100,4,"". utf8_decode($datosFormacion[0]->especifica_deporte),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(50,4,utf8_decode("¿Practicas alguna actividad artística?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosFormacion[0]->practica_artistica==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(30,4,utf8_decode("Especifica la actividad artística: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(100,4,"". utf8_decode($datosFormacion[0]->especifica_artistica),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(50,4,"Tu pasatiempo favorito: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(140,4,"". utf8_decode($datosFormacion[0]->pasatiempo),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(45,4,utf8_decode("¿Participas en actividades culturales, sociales?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosFormacion[0]->actividades_culturales==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(45,4,utf8_decode("¿Cuáles actividades culturales o sociales?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(90,4,"". utf8_decode($datosFormacion[0]->cuales_act),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,utf8_decode("¿Cómo consideras tu estado de salud?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        if ($datosFormacion[0]->estado_salud==1)
        {
            $datosFormacion[0]->estado_salud='Excelente';
        }
        if ($datosFormacion[0]->estado_salud==2)
        {
            $datosFormacion[0]->estado_salud='Buena';
        }
        if ($datosFormacion[0]->estado_salud==3)
        {
            $datosFormacion[0]->estado_salud='Regular';
        }
        if ($datosFormacion[0]->estado_salud==4)
        {
            $datosFormacion[0]->estado_salud='Mala';
        }
        $pdf->Cell(15,4,"". utf8_decode($datosFormacion[0]->estado_salud),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,utf8_decode("¿Padeces alguna enfermedad crónica?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(15,4,"". utf8_decode($datosFormacion[0]->enfermedad_cronica==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,utf8_decode("Especificar enfermedad crónica: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(55,4,"". utf8_decode($datosFormacion[0]->especifica_enf_cron),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(45,4,utf8_decode("¿Tus padres padecen alguna enfermedad crónica?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosFormacion[0]->enf_cron_padre==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(45,4,utf8_decode("Especificar enfermedad crónica de los padres: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(90,4,"". utf8_decode($datosFormacion[0]->especifica_enf_cron_padres),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(50,4,utf8_decode("¿Te han realizado alguna cirugia: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosFormacion[0]->operacion==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(45,4,utf8_decode("Especificar la cirugía: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(85,4,"". utf8_decode($datosFormacion[0]->deque_operacion),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,utf8_decode("¿Padeces alguna enfermedad visual?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosFormacion[0]->enfer_visual==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(30,4,"Especificar enfermedad visual: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(75,4,"". utf8_decode($datosFormacion[0]->especifica_enf),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(30,4,utf8_decode("¿Usas lentes?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosFormacion[0]->usas_lentes==1?'Sí':'No'),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,utf8_decode("¿Tomas medicamento controlado?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(7,4,"". utf8_decode($datosFormacion[0]->medicamento_controlado==1?'Sí':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(25,4,"Especificar medicamento: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(79,4,"". utf8_decode($datosFormacion[0]->especifica_medicamento),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(15,4,"Estatura: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(7,4,"". utf8_decode($datosFormacion[0]->estatura),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(15,4,"Peso: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(7,4,"". utf8_decode($datosFormacion[0]->peso),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,utf8_decode("¿Has tenido algún acidente grave?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(7,4,"". utf8_decode($datosFormacion[0]->accidente_grave==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(20,4,"Relata brevemente: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(128,4,"". utf8_decode($datosFormacion[0]->relata_breve),1,0,"C");
        $pdf->Ln(4);



        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFillColor(156,156,156);
        $pdf->Cell(($pdf->GetPageWidth()-20),8,utf8_decode("ÁREA PSICOPEDAGÓGICA (CONOCIMIENTOS Y HABILIDADES)").utf8_decode(""),1,4,"C","true");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->SetTextColor(010,010,010);
        $pdf->SetFillColor(204,204,204);
        $pdf->Cell(25,4,"Rendimiento escolar: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosArea[0]->rendimientoescolar->desc_escala),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,"Dominio del propio idioma: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosArea[0]->dominioidioma==null?"":$datosArea[0]->dominioidioma->desc_escala),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(18,4,"Otro idioma: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosArea[0]->otroidioma->desc_escala),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(32,4,utf8_decode("Conocimientos de cómputo: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosArea[0]->conocimientocompu->desc_escala),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,"Aptitudes especiales: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosArea[0]->aptitudespecial==null?"":$datosArea[0]->aptitudespecial->desc_escala),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(45,4,utf8_decode("Comprensión y retención en clase: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosArea[0]->comprension1->desc_escala),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(50,4,utf8_decode("Preparación y presentación de examenes: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosArea[0]->preparacion1->desc_escala),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/4,4,utf8_decode("Aplicación de estrategias de aprendizaje y estudio: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/4,4,"". utf8_decode($datosArea[0]->estrategiasaprendizaje==null?"":$datosArea[0]->estrategiasaprendizaje->desc_escala),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/4,4,utf8_decode("Organización en las actividades de estudio: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/4,4,"". utf8_decode($datosArea[0]->organizacionactividades==null?"":$datosArea[0]->organizacionactividades->desc_escala),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(65,4,utf8_decode("Consentración durante el estudio: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(30,4,"". utf8_decode($datosArea[0]->concentracion1->desc_escala),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(65,4,utf8_decode("Solución de problemas y aprendizaje de las matemáticas: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(30,4,"". utf8_decode($datosArea[0]->solucionproblemas->desc_escala),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(45,4,"Condiciones ambientales durante el estudio: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosArea[0]->condicionesambientales==null?"":$datosArea[0]->condicionesambientales->desc_escala),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(50,4,utf8_decode("Búsqueda bibliografica e integración de información: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosArea[0]->busquedabibliografica->desc_escala),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,"Trabajo en equipo: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosArea[0]->trabajoequipo->desc_escala),1,0,"C");
        $pdf->Output();
        exit();
    }

    public function pdf_lista(Request $request)
    {
        $datos=DB::table('gnral_alumnos')
            ->join('exp_asigna_alumnos','exp_asigna_alumnos.id_alumno','=','gnral_alumnos.id_alumno')
            ->select('gnral_alumnos.*','exp_asigna_alumnos.estado','exp_asigna_alumnos.id_asigna_alumno')
            ->where('exp_asigna_alumnos.id_asigna_generacion', '=', $request->id_asigna_generacion)
            ->where('gnral_alumnos.id_carrera','=',$request->id_carrera)
            ->whereNull('exp_asigna_alumnos.deleted_at')
            ->orderBy('gnral_alumnos.apaterno')
            ->get();
        $carrera=DB::table('gnral_carreras')
            ->select('nombre')
            ->where('id_carrera', '=', $request->id_carrera)
            ->get();
        $profesor=DB::table('gnral_personales')
            ->select('gnral_personales.*')
            ->where('gnral_personales.tipo_usuario', '=', Auth::user()->id)
            ->get();

       

        //$pdf= new \Codedge\Fpdf\Fpdf\Fpdf();
        // $pdf->AddPage();
        $pdf=new PDF($orientation='P',$unit='mm',$format='Letter');
        #Establecemos los márgenes izquierda, arriba y derecha:
        $pdf->SetMargins(10, 19 , 10);
        //$pdf->SetAutoPageBreak(true,25);
        $pdf->AddPage();



        $pdf->SetFont('Times', 'B', 10);
        $pdf->SetFillColor(192,192,192);
        $pdf->Ln(1);
        $pdf->Cell(($pdf->GetPageWidth()-20),6,"LISTA DE ASISTENCIA".utf8_decode(""),0,4,"C","true");
        $pdf->Ln(1);
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(($pdf->GetPageWidth()-20),3,"PROGRAMA EDUCATIVO: ". utf8_decode(mb_strtoupper($carrera[0]->nombre)),0,0,"L");
        $pdf->Ln(3);
        $pdf->Cell(($pdf->GetPageWidth()-20)/3,3,"ASIGNATURA: ". utf8_decode("TUTORIAS"),0,0,"L");
        $pdf->Cell(($pdf->GetPageWidth()-20)/3,3,"". utf8_decode(""),0,0,"L");
        $pdf->SetFillColor(192,192,192);
        $pdf->Cell(($pdf->GetPageWidth()-151)/1,4,"".utf8_decode($request->generacion),0,1,"C","true");
        $pdf->Ln(0);
        $pdf->Cell(($pdf->GetPageWidth()-20)/2,3,"PROFESOR: ". utf8_decode(mb_strtoupper($profesor[0]->nombre)),0,0,"L");
        $pdf->Cell(($pdf->GetPageWidth()-20)/2,3,"PERIODO: ". utf8_decode(mb_strtoupper(Session::get('nombre_periodo'))),0,0,"R");


        $pdf->Ln(8);
        $pdf->SetFont('Times', 'B', 6);
        $np=0;
        $pdf->Cell(8,3.5,"NP".utf8_decode(mb_strtoupper("")),'LRT',0,"C","true");
        $pdf->Cell(12,3.5,"No.CTA". utf8_decode(mb_strtoupper("")),'LRT',0,"C","true");
        $pdf->Cell(55,3.5,"NOMBRE". utf8_decode(mb_strtoupper("")),'LRT',0,"C","true");
        $pdf->Cell(114.7,3.5,"MES DE:". utf8_decode(mb_strtoupper("________________________________________")),'LRT',1,"C","true");
        $pdf->Cell(8,3,"".utf8_decode(mb_strtoupper("")),'LR',0,"C","true");
        $pdf->Cell(12,3,"". utf8_decode(mb_strtoupper("")),'LR',0,"C","true");
        $pdf->Cell(55,3,"". utf8_decode(mb_strtoupper("")),'LR',0,"C","true");

        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("1")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("2")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("3")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("4")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("5")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("6")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("7")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("8")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("9")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("10")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("11")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("12")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("13")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("14")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("15")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("16")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("17")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("18")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("19")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("20")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("21")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("22")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("23")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("24")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("25")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("26")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("27")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("28")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("29")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("30")),'LRT',0,"C","true");
        $pdf->Cell(3.7,3,"". utf8_decode(mb_strtoupper("31")),'LRT',1,"C","true");

        foreach ($datos as $dat)
        {
            $pdf->Cell(8,5," ".utf8_decode(mb_strtoupper($np=0?$np=0:$np=$np+1)),1,0,"C");
            $pdf->Cell(12,5,"". utf8_decode(mb_strtoupper($dat->cuenta)),1,0,"C");
            $pdf->Cell(55,5,"". utf8_decode(mb_strtoupper($dat->apaterno." ".$dat->amaterno." ".$dat->nombre)),1,0,"L");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,0,"C");
            $pdf->Cell(3.7,5,"". utf8_decode(mb_strtoupper("")),1,1,"C");

        }

        //$pdf->Cell(0,100,utf8_decode('Página '.$pdf->PageNo()),0,0,'R');
        $pdf->Ln(10);
        $pdf->Cell(($pdf->GetPageWidth()),3,"". utf8_decode(mb_strtoupper("________________________________________________")),0,1,"C");
        $pdf->Cell(($pdf->GetPageWidth()),3,"". utf8_decode(mb_strtoupper($profesor[0]->nombre)),0,0,"C");

        // $pdf->Output();
        $pdf->AliasNbPages();
        $pdf->Output();
        exit();
        // exit();



    }

    public function pdf_alumno(Request $request)
    {
        $datos_alumno=DB::selectOne('SELECT gnral_alumnos.*,gnral_semestres.descripcion semestre from gnral_alumnos, gnral_semestres 
where gnral_alumnos.id_semestre = gnral_semestres.id_semestre and gnral_alumnos.id_alumno='.$request->id_alumno.'');
        $datosGenerales= Tutorias_Exp_generale::where('id_alumno',$request->id_alumno)->get();
        $datosAntecedentes= Tutorias_Exp_antecedentes_academico::where('id_alumno',$request->id_alumno)->get();
        $datosFamiliares= Tutorias_Exp_datos_familiare::where('id_alumno',$request->id_alumno)->get();
        $datosHabitos= Tutorias_Exp_habitos_estudio::where('id_alumno',$request->id_alumno)->get();
        $datosFormacion= Tutorias_Exp_formacion_integral::where('id_alumno',$request->id_alumno)->get();
        $datosArea= Tutorias_Exp_area_psicopedagogica::where('id_alumno',$request->id_alumno)->get();

        $datosArea->load("rendimientoescolar","dominioidioma","otroidioma","conocimientocompu","aptitudespecial",
            "comprension1","preparacion1","estrategiasaprendizaje","organizacionactividades","concentracion1","solucionproblemas",
            "condicionesambientales","busquedabibliografica","trabajoequipo");
        $datosFamiliares->load('vives','union','parentesco');
        $datosGenerales->load('turno1','carrera','grupo','semestre','civil');
        $datosHabitos->load('intelectual');
        $ext="";

        $pdf= new \Codedge\Fpdf\Fpdf\Fpdf();
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(130,130,130);

        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(($pdf->GetPageWidth()-20),11,"EXPEDIENTE DEL TUTORADO".utf8_decode(""),1,4,"C","true");

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(156,156,156);
        $pdf->Cell(($pdf->GetPageWidth()-20),8,"DATOS GENERALES".utf8_decode(""),1,4,"C","true");
        $pdf->SetDrawColor(010,010,010);
        $pdf->Rect(180, 10, 15, 15, 'DF');

        switch ($datosGenerales[0]->foto){
            case 'image/jpeg':
                $ext='.jpeg';
                break;
            case 'image/png':
                $ext='.png';
                break;
            case 'image/jpg':
                $ext='.jpg';
                break;
        }
        $pdf->Image('Fotografias/'.$datosGenerales[0]->no_cuenta.$ext,180,10,20,19);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->SetTextColor(010,010,010);
        $pdf->SetFillColor(204,204,204);
        $pdf->Cell(25,4,"Programa educativo: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(80,4,"". utf8_decode($datosGenerales[0]->carrera->nombre),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(20,4,"Periodo: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(35,4,"". utf8_decode(Session::get('nombre_periodo')),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(20,4,"Grupo: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosGenerales[0]->grupo->grupo),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(20,4,"Estudiante: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(85,4,"". utf8_decode($datosGenerales[0]->nombre),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(20,4,"Edad: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosGenerales[0]->edad),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(20,4,"Sexo: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(25,4,"". utf8_decode($datosGenerales[0]->sexo=="M"?'Masculino':'Femenino'),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(25,4,"Fecha de nacimiento: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(15,4,"". utf8_decode($datos_alumno->fecha_nac),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(25,4,"Lugar de nacimiento: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(70,4,"". utf8_decode($datosGenerales[0]->lugar_nacimientos),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(20,4,"Semestre: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(35,4,"". utf8_decode($datos_alumno->semestre),1,0,"C");
        $pdf->Ln(4);

        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(15,4,"Estado civil: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(13,4,"". utf8_decode($datosGenerales[0]->civil->desc_ec),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(15,4,"No. Hijos: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        /*uno*/
        if ($datosGenerales[0]->no_hijos==1)
        {
            $datosGenerales[0]->no_hijos='0';
        }
        if ($datosGenerales[0]->no_hijos==2)
        {
            $datosGenerales[0]->no_hijos='1';
        }
        if ($datosGenerales[0]->no_hijos==3)
        {
            $datosGenerales[0]->no_hijos='2';
        }
        if ($datosGenerales[0]->no_hijos==4)
        {
            $datosGenerales[0]->no_hijos='3';
        }
        if ($datosGenerales[0]->no_hijos==5)
        {
            $datosGenerales[0]->no_hijos='4 o más';
        }
        $pdf->Cell(13,4,"". utf8_decode($datosGenerales[0]->no_hijos),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(15,4,utf8_decode("Dirección: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(119,4,"". utf8_decode($datosGenerales[0]->direccion),1,0,"C");
        $pdf->Ln(4);

        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/2,4,"e-mail: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/2,4,"". utf8_decode($datosGenerales[0]->correo),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,"Tel. Casa: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,"". utf8_decode($datosGenerales[0]->tel_casa),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,"Celular: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,"". utf8_decode($datosGenerales[0]->cel),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,utf8_decode("Nivel socio-económico"). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,"". utf8_decode($datosGenerales[0]->nivel_economico),1,0,"C");
        $pdf->Ln(4);

        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(10,4,utf8_decode("¿Trabaja?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosGenerales[0]->trabaja==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(15,4,utf8_decode("Ocupación: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(110,4,"". utf8_decode($datosGenerales[0]->ocupacion),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(10,4,"Horario: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(35,4,"". utf8_decode($datosGenerales[0]->horario),1,0,"C");
        $pdf->Ln(4);

        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(15,4,"No.Cuenta: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(14,4,"". utf8_decode($datosGenerales[0]->no_cuenta),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(18,4,utf8_decode("¿Cuenta con beca?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosGenerales[0]->beca==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(20,4,utf8_decode("¿Qué tipo de beca?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        if ($datosGenerales[0]->id_expbeca==1)
        {
            $datosGenerales[0]->id_expbeca='Manutención Federal';
        }
        if ($datosGenerales[0]->id_expbeca==2)
        {
            $datosGenerales[0]->id_expbeca='Benito Juárez';
        }
        if ($datosGenerales[0]->id_expbeca==3)
        {
            $datosGenerales[0]->id_expbeca='Permanencia';
        }
        if ($datosGenerales[0]->id_expbeca==4)
        {
            $datosGenerales[0]->id_expbeca='Excelencia Académica';
        }
        $pdf->Cell(55,4,"". utf8_decode($datosGenerales[0]->id_expbeca),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(19,4,utf8_decode("Estado académico: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        if ($datosGenerales[0]->estado==1)
        {
            $datosGenerales[0]->estado='Regular';
        }
        if ($datosGenerales[0]->estado==2)
        {
            $datosGenerales[0]->estado='Irregular';
        }
        if ($datosGenerales[0]->estado==3)
        {
            $datosGenerales[0]->estado='Suspensión';
        }
        if ($datosGenerales[0]->estado==4)
        {
            $datosGenerales[0]->estado='Baja temporal';
        }
        if ($datosGenerales[0]->estado==5)
        {
            $datosGenerales[0]->estado='Baja definitiva';
        }
        $pdf->Cell(16,4,"". utf8_decode($datosGenerales[0]->estado),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(10,4,"Turno: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(13,4,"". utf8_decode($datosGenerales[0]->turno1->descripcion_turno),1,0,"C");
        $pdf->Ln(4);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFillColor(156,156,156);
        $pdf->Cell(($pdf->GetPageWidth()-20),8,utf8_decode("ANTECEDENTES ACADÉMICOS").utf8_decode(""),1,4,"C","true");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->SetTextColor(010,010,010);
        $pdf->SetFillColor(204,204,204);
        $pdf->Cell(25,4,"Tipo de bachillerato: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosAntecedentes[0]->id_bachillerato==1?'Tecnico':'General'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(22,4,"Otros estudios: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(25,4,"". utf8_decode($datosAntecedentes[0]->otros_estudios==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,utf8_decode("Años en que curso el bachillerato: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(18,4,"". utf8_decode($datosAntecedentes[0]->anos_curso_bachillerato>5?'Mas':$datosAntecedentes[0]->anos_curso_bachillerato),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(30,4,utf8_decode("Año de terminación: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(15,4,"". utf8_decode($datosAntecedentes[0]->ano_terminacion),1,0,"C");
        $pdf->Ln(4);

        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(24,4,utf8_decode("Escuela de procedencia: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(136,4,"". utf8_decode($datosAntecedentes[0]->escuela_procedente),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(17,4,"Promedio: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(13,4,"". utf8_decode($datosAntecedentes[0]->promedio),1,0,"C");
        $pdf->Ln(4);

        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(60,4,"Materias reprobadas en el bachillerato: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(130,4,"". utf8_decode($datosAntecedentes[0]->materias_reprobadas),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        /*uno*/
        $pdf->Cell(42,4,"Otro programa educativo iniciado: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosAntecedentes[0]->otra_carrera_ini==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(15,4,utf8_decode("Institución: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(91,4,"". utf8_decode($datosAntecedentes[0]->institucion),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(22,4,"Semestres cursados: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosAntecedentes[0]->semestres_cursados),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(30,4,utf8_decode("Interrupciones en los estudios: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosAntecedentes[0]->interrupciones_estudios==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(40,4,utf8_decode("Razones de la interrupción en los estudios: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(110,4,"". utf8_decode($datosAntecedentes[0]->razones_interrupcion),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(58,4,utf8_decode("¿Cuál fue la razón por la que decidio estudiar en el TESVB?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(132,4,"". utf8_decode($datosAntecedentes[0]->razon_descide_estudiar_tesvb),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/2,4,utf8_decode("¿Tienes información sobre el perfil profesional del programa educativo?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/2,4,"". utf8_decode($datosAntecedentes[0]->sabedel_perfil_profesional),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(60,4,utf8_decode("¿Tuviste opciones vocacionales por otros programas educativos?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(13,4,"". utf8_decode($datosAntecedentes[0]->otras_opciones_vocales==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(15,4,utf8_decode("¿Cuáles?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(102,4,"". utf8_decode($datosAntecedentes[0]->cuales_otras_opciones_vocales),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(50,4,utf8_decode("¿Te gusta el programa educativo elegido?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(13,4,"". utf8_decode($datosAntecedentes[0]->tegusta_carrera_elegida==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(15,4,utf8_decode("¿Por qué?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(112,4,"". utf8_decode($datosAntecedentes[0]->porque_carrera_elegida),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(50,4,utf8_decode("¿Suspensión después de terminar el bachillerato?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosAntecedentes[0]->suspension_estudios_bachillerato==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,utf8_decode("Razones de suspensión de estudios: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(95,4,"". utf8_decode($datosAntecedentes[0]->razones_suspension_estudios),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/2,4,utf8_decode("¿Te estimula tu familia en tus estudios?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/2,4,"". utf8_decode($datosAntecedentes[0]->teestimula_familia==1?'Si':'No'),1,0,"C");
        $pdf->Ln(4);


        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFillColor(156,156,156);
        $pdf->Cell(($pdf->GetPageWidth()-20),8,"DATOS FAMILIARES".utf8_decode(""),1,4,"C","true");
        $pdf->SetTextColor(010,010,010);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->SetFillColor(204,204,204);
        $pdf->Cell(40,4,"Nombre del padre: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(85,4,"". utf8_decode($datosFamiliares[0]->nombre_padre),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,"Edad: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(30,4,"". utf8_decode($datosFamiliares[0]->edad_padre),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(25,4,utf8_decode("Ocupación: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(60,4,"". utf8_decode($datosFamiliares[0]->ocupacion_padre),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(25,4,"Lugar de residencia: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(80,4,"". utf8_decode($datosFamiliares[0]->lugar_residencia_padre),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(40,4,"Nombre de la madre: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(85,4,"". utf8_decode($datosFamiliares[0]->nombre_madre),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,"Edad: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(30,4,"". utf8_decode($datosFamiliares[0]->edad_madre),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(25,4,utf8_decode("Ocupación: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(60,4,"". utf8_decode($datosFamiliares[0]->ocupacion_madre),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(25,4,"Lugar de residencia: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(80,4,"". utf8_decode($datosFamiliares[0]->lugar_residencia_madre),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(33,4,utf8_decode("Número de hermanos, incluyéndote: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(8,4,"". utf8_decode($datosFamiliares[0]->no_hermanos),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(33,4,"Lugar que ocupas entre ellos: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(8,4,"". utf8_decode($datosFamiliares[0]->lugar_ocupas),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(25,4,"Actualmente vives con: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(27,4,"". utf8_decode($datosFamiliares[0]->vives->desc_opc),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(45,4,utf8_decode("Número total de personas con las que vives: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(11,4,"". utf8_decode($datosFamiliares[0]->no_personas),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,"Perteneces a una etnia indigena: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,"". utf8_decode($datosFamiliares[0]->etnia_indigena==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,utf8_decode("¿Cuál etnia?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,"". utf8_decode($datosFamiliares[0]->cual_etnia),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,"Hablas una lengua indigena: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/6,4,"". utf8_decode($datosFamiliares[0]->hablas_lengua_indigena==1?'Si':'No'),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(40,4,utf8_decode("¿Quién sostiene económicamente tu hogar?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(90,4,"". utf8_decode($datosFamiliares[0]->sostiene_economia_hogar),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,utf8_decode("¿Cómo consideras a tu familia?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(25,4,"". utf8_decode($datosFamiliares[0]->union->desc_union),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(30,4,"Nombre del tutor: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(90,4,"". utf8_decode($datosFamiliares[0]->nombre_tutor),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(30,4,"Parentesco:  ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(40,4,"". utf8_decode($datosFamiliares[0]->parentesco->desc_parentesco),1,0,"C");
        $pdf->Ln(4);



        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFillColor(156,156,156);
        $pdf->Cell(($pdf->GetPageWidth()-20),8,utf8_decode("HABITOS DE ESTUDIO").utf8_decode(""),1,4,"C","true");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->SetTextColor(010,010,010);
        $pdf->SetFillColor(204,204,204);

        $pdf->Cell(($pdf->GetPageWidth()-20)/4,4,"Tiempo dedicado a estudiar diariamente fuera de clase: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/4,4,"". utf8_decode($datosHabitos[0]->tiempo_empleado_estudiar==3?'2 horas':'3 horas'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/4,4,utf8_decode("¿Cómo es tu forma de trabajo intelectual?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/4,4,"". utf8_decode($datosHabitos[0]->intelectual->desc_opc),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/2,4,utf8_decode("Tu forma de estudio más utlizada: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/2,4,"". utf8_decode($datosHabitos[0]->forma_estudio),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(50,4,utf8_decode("¿Cómo empleas tu tiempo libre?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(140,4,"". utf8_decode($datosHabitos[0]->tiempo_libre),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(55,4,"Asignaturas preferidas: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(135,4,"". utf8_decode($datosHabitos[0]->asignatura_preferida),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(40,4,utf8_decode("¿Por qué?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(150,4,"". utf8_decode($datosHabitos[0]->porque_asignatura),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(55,4,utf8_decode("Asignaturas que te han sido difíciles: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(135,4,"". utf8_decode($datosHabitos[0]->asignatura_dificil),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(40,4,utf8_decode("¿Por qué?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(150,4,"". utf8_decode($datosHabitos[0]->porque_asignatura_dificil),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(60,4,utf8_decode("¿Qué opinión tines de ti mismo como estudiante?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(130,4,"". utf8_decode($datosHabitos[0]->opinion_tu_mismo_estudiante),1,0,"C");
        $pdf->Ln(4);



        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFillColor(156,156,156);
        $pdf->Cell(($pdf->GetPageWidth()-20),8,utf8_decode("FORMACIÓN INTEGRAL/SALUD").utf8_decode(""),1,4,"C","true");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->SetTextColor(010,010,010);
        $pdf->SetFillColor(204,204,204);
        $pdf->Cell(50,4,utf8_decode("¿Practica regularmente algún deporte?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosFormacion[0]->practica_deporte==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(30,4,"Especifica el deporte: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(100,4,"". utf8_decode($datosFormacion[0]->especifica_deporte),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(50,4,utf8_decode("¿Practicas alguna actividad artística?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosFormacion[0]->practica_artistica==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(30,4,utf8_decode("Especifica la actividad artística: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(100,4,"". utf8_decode($datosFormacion[0]->especifica_artistica),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(50,4,"Tu pasatiempo favorito: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(140,4,"". utf8_decode($datosFormacion[0]->pasatiempo),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(45,4,utf8_decode("¿Participas en actividades culturales, sociales?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosFormacion[0]->actividades_culturales==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(45,4,utf8_decode("¿Cuáles actividades culturales o sociales?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(90,4,"". utf8_decode($datosFormacion[0]->cuales_act),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,utf8_decode("¿Cómo consideras tu estado de salud?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        if ($datosFormacion[0]->estado_salud==1)
        {
            $datosFormacion[0]->estado_salud='Excelente';
        }
        if ($datosFormacion[0]->estado_salud==2)
        {
            $datosFormacion[0]->estado_salud='Buena';
        }
        if ($datosFormacion[0]->estado_salud==3)
        {
            $datosFormacion[0]->estado_salud='Regular';
        }
        if ($datosFormacion[0]->estado_salud==4)
        {
            $datosFormacion[0]->estado_salud='Mala';
        }
        $pdf->Cell(15,4,"". utf8_decode($datosFormacion[0]->estado_salud),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,utf8_decode("¿Padeces alguna enfermedad crónica?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(15,4,"". utf8_decode($datosFormacion[0]->enfermedad_cronica==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,utf8_decode("Especificar enfermedad crónica: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(55,4,"". utf8_decode($datosFormacion[0]->especifica_enf_cron),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(45,4,utf8_decode("¿Tus padres padecen alguna enfermedad crónica?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosFormacion[0]->enf_cron_padre==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(45,4,utf8_decode("Especificar enfermedad crónica de los padres: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(90,4,"". utf8_decode($datosFormacion[0]->especifica_enf_cron_padres),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(50,4,utf8_decode("¿Te han realizado alguna cirugía: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosFormacion[0]->operacion==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(45,4,utf8_decode("Especificar la cirugía: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(85,4,"". utf8_decode($datosFormacion[0]->deque_operacion),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,utf8_decode("¿Padeces alguna enfermedad visual?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosFormacion[0]->enfer_visual==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(30,4,"Especificar enfermedad visual: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(75,4,"". utf8_decode($datosFormacion[0]->especifica_enf),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(30,4,utf8_decode("¿Usas lentes?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(10,4,"". utf8_decode($datosFormacion[0]->usas_lentes==1?'Sí':'No'),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,utf8_decode("¿Tomas medicamento controlado?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(7,4,"". utf8_decode($datosFormacion[0]->medicamento_controlado==1?'Sí':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(25,4,"Especificar medicamento: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(79,4,"". utf8_decode($datosFormacion[0]->especifica_medicamento),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(15,4,"Estatura: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(7,4,"". utf8_decode($datosFormacion[0]->estatura),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(15,4,"Peso: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(7,4,"". utf8_decode($datosFormacion[0]->peso),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,utf8_decode("¿Has tenido algún acidente grave?: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(7,4,"". utf8_decode($datosFormacion[0]->accidente_grave==1?'Si':'No'),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(20,4,"Relata brevemente: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(128,4,"". utf8_decode($datosFormacion[0]->relata_breve),1,0,"C");
        $pdf->Ln(4);



        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFillColor(156,156,156);
        $pdf->Cell(($pdf->GetPageWidth()-20),8,utf8_decode("ÁREA PSICOPEDAGÓGICA (CONOCIMIENTOS Y HABILIDADES)").utf8_decode(""),1,4,"C","true");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->SetTextColor(010,010,010);
        $pdf->SetFillColor(204,204,204);
        $pdf->Cell(25,4,"Rendimiento escolar: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosArea[0]->rendimientoescolar->desc_escala),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,"Dominio del propio idioma: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosArea[0]->dominioidioma==null?"":$datosArea[0]->dominioidioma->desc_escala),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(18,4,"Otro idioma: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosArea[0]->otroidioma->desc_escala),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(32,4,utf8_decode("Conocimientos de cómputo: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosArea[0]->conocimientocompu->desc_escala),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,"Aptitudes especiales: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosArea[0]->aptitudespecial==null?"":$datosArea[0]->aptitudespecial->desc_escala),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(45,4,utf8_decode("Comprensión y retención en clase: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosArea[0]->comprension1->desc_escala),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(50,4,utf8_decode("Preparación y presentación de examenes: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosArea[0]->preparacion1->desc_escala),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/4,4,utf8_decode("Aplicación de estrategias de aprendizaje y estudio: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/4,4,"". utf8_decode($datosArea[0]->estrategiasaprendizaje==null?"":$datosArea[0]->estrategiasaprendizaje->desc_escala),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/4,4,utf8_decode("Organización en las actividades de estudio: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(($pdf->GetPageWidth()-20)/4,4,"". utf8_decode($datosArea[0]->organizacionactividades==null?"":$datosArea[0]->organizacionactividades->desc_escala),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(65,4,utf8_decode("Consentración durante el estudio: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(30,4,"". utf8_decode($datosArea[0]->concentracion1->desc_escala),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(65,4,utf8_decode("Solución de problemas y aprendizaje de las matemáticas: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(30,4,"". utf8_decode($datosArea[0]->solucionproblemas->desc_escala),1,0,"C");
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(45,4,"Condiciones ambientales durante el estudio: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosArea[0]->condicionesambientales==null?"":$datosArea[0]->condicionesambientales->desc_escala),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(50,4,utf8_decode("Búsqueda bibliografica e integración de información: "). utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosArea[0]->busquedabibliografica->desc_escala),1,0,"C");
        $pdf->SetFont('Arial', 'B', 4.8);
        $pdf->Cell(35,4,"Trabajo en equipo: ". utf8_decode(""),1,0,"L","true");
        $pdf->SetFont('Arial', '', 4.8);
        $pdf->Cell(20,4,"". utf8_decode($datosArea[0]->trabajoequipo->desc_escala),1,0,"C");
        $pdf->Output();
        exit();
    }


}

