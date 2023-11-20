<?php

namespace App\Http\Controllers;

use App\Alumnos;
use App\calEvaluaciones;
use App\calPeriodos;
use App\CargaAcademica;
use App\Gnral_Materias;
use App\Gnral_Personales;
use App\Periodos;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\DB;
use Session;
use PDF;

class PDFlistasController extends Controller
{
    public function generaListas($id_docente,$id_materia,$id_grupo,$unidades)
    {
        //dd($id_docente,$id_materia,$id_grupo,$unidades);
        $mat = DB::selectOne('SELECT  gnral_materias.*,gnral_reticulas.id_reticula,gnral_reticulas.clave clave_rec,gnral_reticulas.id_carrera 
FROM gnral_materias,gnral_reticulas WHERE id_materia = '.$id_materia.' and gnral_reticulas.id_reticula=gnral_materias.id_reticula');
        $grupo = $mat->id_semestre.'0'.$id_grupo ;
        $carrera= DB::selectOne('SELECT gnral_carreras.nombre from gnral_carreras,gnral_reticulas,gnral_materias WHERE gnral_carreras.id_carrera=gnral_reticulas.id_carrera and gnral_reticulas.id_reticula=gnral_materias.id_reticula and gnral_materias.id_materia= '.$id_materia.'');
        $nom_carrera=$carrera->nombre;
        $profesor=DB::selectOne('SELECT abreviaciones.titulo,gnral_personales.nombre from 
                                                        gnral_personales,abreviaciones_prof,abreviaciones 
                                                    WHERE gnral_personales.id_personal=abreviaciones_prof.id_personal 
                                                      and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion and gnral_personales.id_personal='.$id_docente.'');
        $periodo=Session::get('periodo_actual');
			$esc_alumno=false;
			$periodoAct=DB::select("select periodo from gnral_periodos where id_periodo=".$periodo."");
			$periodoAct=$periodoAct[0]->periodo;

        $alumnos=DB::select('select gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre, gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.id_carrera,eva_carga_academica.id_carga_academica,
 gnral_materias.clave,gnral_materias.nombre materia,gnral_materias.unidades,eva_tipo_curso.nombre_curso,eva_validacion_de_cargas.estado_validacion
                from gnral_alumnos,gnral_materias,eva_carga_academica, gnral_periodos,eva_tipo_curso,eva_validacion_de_cargas
                where gnral_periodos.id_periodo='.$periodo.'
                and gnral_materias.id_materia='.$id_materia.'
                and eva_carga_academica.grupo='.$id_grupo.'
                and eva_carga_academica.id_status_materia=1
                and eva_carga_academica.id_materia=gnral_materias.id_materia
                and eva_tipo_curso.id_tipo_curso=eva_carga_academica.id_tipo_curso
                and eva_carga_academica.id_periodo=gnral_periodos.id_periodo
				and eva_carga_academica.id_alumno=gnral_alumnos.id_alumno
                and eva_validacion_de_cargas.id_alumno=eva_carga_academica.id_alumno 
                and eva_validacion_de_cargas.estado_validacion in (2,9)
                and eva_validacion_de_cargas.id_periodo= eva_validacion_de_cargas.id_periodo
                and eva_validacion_de_cargas.id_periodo=gnral_periodos.id_periodo
                ORDER BY gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.nombre');
        //dd($alumnos);
			$array_alumnos=array();
			$num_alumnos=0;
			foreach ($alumnos as $alumno)
			{
			    if($alumno->id_carrera == $mat->id_carrera){
                    $dat_alumnos['carrera']=1;
                }
			    else{
                    $dat_alumnos['carrera']=2;
                }
					$num_alumnos++;
					$dat_alumnos['np']=$num_alumnos;
					$dat_alumnos['id_alumno']=$alumno->id_alumno;
					$dat_alumnos['id_carga_academica']=$alumno->id_carga_academica;
					$dat_alumnos['cuenta']=$alumno->cuenta;
					$dat_alumnos['estado_validacion']=$alumno->estado_validacion;
					$dat_alumnos['nombre']=mb_strtoupper($alumno->apaterno ,'utf-8')." ".mb_strtoupper($alumno->amaterno,'utf-8')." ".mb_strtoupper($alumno->nombre,'utf-8');
					$dat_alumnos['curso']=$alumno->nombre_curso;
					array_push($array_alumnos,$dat_alumnos);
			}
			//dd($array_alumnos);
			$pdf = PDF::loadView('docentes.genera_listas',compact('periodoAct','grupo','mat','nom_carrera','profesor','periodo'),['alumnos'=>$array_alumnos]);
			return $pdf->stream('lista.pdf');
		}
    public function reporteDocente($id_docente, $id_materia, $id_grupo)
    {

        $periodo = Periodos::find(Session::get('periodo_actual'));
        $materia = Gnral_Materias::find($id_materia);
        $docente = Gnral_Personales::find($id_docente);
//dd($periodo);
        $datos = $this->getDatos($id_docente, $id_materia, $id_grupo, $periodo->id_periodo, $materia->unidades);
        /// dd($materia);
        // dd($docente);
        //270 with fpdf
        $pdf = new FPDF($orientation = 'L', $unit = 'mm', $format = 'Letter');
        $pdf->SetTitle(utf8_decode('Análisis de reprobacíon por unidad de '.$materia->nombre.": ".utf8_decode($materia->id_semestre . '0' . $id_grupo)));
        $pdf->SetMargins(5, 20, 0);
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', '14');
        $pdf->Cell(270, 7, utf8_decode('Reporte de Seguimiento Académico'), 1, 0, 'C');
        $pdf->ln();
        $pdf->Cell(270, 7, utf8_decode('Análisis de reprobacíon por unidad de '.$materia->nombre), 1, 0, 'C');
        $pdf->ln();
        $pdf->Cell(80, 7, utf8_decode('Docente:'), 1, 0, 'L');
        $pdf->Cell(190, 7, utf8_decode($docente->nombre), 1, 0, 'L');
        $pdf->ln();
        $pdf->Cell(67.5, 7, utf8_decode('Grupo'), 1, 0, 'L');
        $pdf->Cell(67.5, 7, utf8_decode($materia->id_semestre . '0' . $id_grupo), 1, 0, 'L');
        $pdf->Cell(45, 7, utf8_decode('Periodo:'), 1, 0, 'L');
        $pdf->Cell(90, 7, utf8_decode($periodo->periodo), 1, 0, 'L');
        $pdf->ln();
        $pdf->Cell(80, 7, utf8_decode('Nombres'), 1, 0, 'L');
        $withCell = 80 / $materia->unidades;

        for ($i = 0; $i < $materia->unidades; $i++)
            $pdf->Cell($withCell, 7, utf8_decode("U" . ($i + 1)), 1, 0, 'L');
        $pdf->Cell(40, 7, utf8_decode('% reprobación'), 1, 0, 'L');
        $pdf->Cell(70, 7, utf8_decode('Observaciones'), 1, 0, 'L');
        $pdf->ln();
        $pdf->SetFont('Arial', '', '11');
        foreach ($datos as $dato) {
            $heightAux=$pdf->GetMultiCellHeight(70,7,utf8_decode($dato->observaciones),1,'J');
            //$heightCell=(integer)($pdf->GetStringWidth($dato->observaciones)/70);
            //$heightCell=($heightCell==0?$heightCell+1:$heightCell+2)*7;
            $pdf->Cell(80, $heightAux, utf8_decode($dato->nombre), 1, 0, 'L');
            $uni_evaluadas = 0;
            foreach ($dato->evaluaciones as $evaluacion) {
                $uni_evaluadas++;
                $pdf->Cell($withCell, $heightAux, utf8_decode($evaluacion->calificacion < 70 ? "N.A" : $evaluacion->calificacion), 1, 0, 'C');
            }
            for ($i = 0; $i < $materia->unidades - $uni_evaluadas; $i++)
                $pdf->Cell($withCell, $heightAux, "", 1, 0, 'L');
            $pdf->Cell(40, $heightAux, $dato->indice . "%", 1, 0, 'C');
            $pdf->MultiCell(70, 7, utf8_decode($dato->observaciones), 1, 'J', 0);
           // $pdf->ln();
        }
        $pdf->Cell(80, 7, utf8_decode("Inidice de reprobación por unidad"), 1, 0, 'L');
        $indices = $this->getIndices($id_materia, $id_grupo, $periodo->id_periodo);

        for ($i = 0; $i < $indices->count(); $i++)
            $pdf->Cell($withCell, 7, $indices[$i] . "%", 1, 0, 'C');

        $pdf->ln();
        $pdf->SetFont('Arial', 'B', '12');
        $pdf->Cell(70, 7, utf8_decode("Acciones preventivas:"), 0, 0, 'L');
        $pdf->SetFont('Arial', '', '11');
        $pdf->ln();
        $acciones = $this->getAcciones($id_materia, $id_grupo, $periodo->id_periodo);
        foreach ($acciones as $accion) {
            $pdf->Cell(70, 7, utf8_decode($accion->acciones_preventivas), 0, 0, 'L');
            $pdf->ln();
        }
        $pdf->Output();
        exit();
    }
    public function reporteCanalizacion($id_docente, $id_materia, $id_grupo)
    {

        $periodo = Periodos::find(Session::get('periodo_actual'));
        $materia = Gnral_Materias::find($id_materia);
        $docente = Gnral_Personales::find($id_docente);

        $datos = $this->getDatos($id_docente, $id_materia, $id_grupo, $periodo->id_periodo, $materia->unidades);
        $datos=$datos->reject(function($row){
            return $row->indice<40;
        });
        /// dd($materia);
        // dd($docente);
        //270 with fpdf
        $pdf = new FPDF($orientation = 'L', $unit = 'mm', $format = 'Letter');
        $pdf->SetTitle("Reporte");
        $pdf->SetMargins(5, 20, 0);
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', '14');
        $pdf->Cell(270, 7, utf8_decode('Reporte de alto indice de reprobación mensual'), 1, 0, 'C');
        $pdf->ln();
        $pdf->Cell(270, 7, utf8_decode('Análisis de reprobacíon por unidad de '.$materia->nombre), 1, 0, 'C');
        $pdf->ln();
        $pdf->Cell(80, 7, utf8_decode('Docente:'), 1, 0, 'L');
        $pdf->Cell(190, 7, utf8_decode($docente->nombre), 1, 0, 'L');
        $pdf->ln();
        $pdf->Cell(135, 7, utf8_decode('Grupo: ').utf8_decode($materia->id_semestre . '0' . $id_grupo), 1, 0, 'L');
       // $pdf->Cell(67.5, 7, , 1, 0, 'L');
        $pdf->Cell(135, 7, utf8_decode('Periodo: '.$periodo->periodo), 1, 0, 'L');
        //$pdf->Cell(85, 7, utf8_decode(), 1, 0, 'L');
        $pdf->ln();
        $pdf->Cell(70, 7, utf8_decode('Nombres'), 1, 0, 'L');
        $withCell = 80 / $materia->unidades;
        for ($i = 0; $i < $materia->unidades; $i++)
            $pdf->Cell($withCell, 7, utf8_decode("U" . ($i + 1)), 1, 0, 'L');
        $pdf->Cell(10, 7, utf8_decode('%'), 1, 0, 'L');
        $pdf->Cell(40, 7, utf8_decode("Canalización"), 1, 0, 'L');
        $pdf->Cell(70, 7, utf8_decode('Observaciones'), 1, 0, 'L');
        $pdf->ln();
        $pdf->SetFont('Arial', '', '11');
        foreach ($datos as $dato) {
            $heightAux=$pdf->GetMultiCellHeight(70,7,utf8_decode($dato->observaciones),1,'J');
            $heightAux2=$pdf->GetMultiCellHeight(40,7,utf8_decode($dato->canalizaciones),1,'J');

            $pdf->Cell(70, $heightAux, utf8_decode($dato->nombre), 1, 0, 'L');
            $uni_evaluadas = 0;
            foreach ($dato->evaluaciones as $evaluacion) {
                $uni_evaluadas++;
                $pdf->Cell($withCell, $heightAux, utf8_decode($evaluacion->calificacion < 70 ? "N.A" : $evaluacion->calificacion), 1, 0, 'C');
            }
            for ($i = 0; $i < $materia->unidades - $uni_evaluadas; $i++)
                $pdf->Cell($withCell, $heightAux, "", 1, 0, 'L');
            $pdf->Cell(10, $heightAux, $dato->indice . "%", 1, 0, 'C');
            $x=$pdf->GetX();
            $y=$pdf->GetY();
            $pdf->MultiCell(40, $heightAux/($heightAux2/7), utf8_decode($dato->canalizaciones), 1,  'L');
            $pdf->SetXY($x+40,$y);
            $pdf->MultiCell(70, 7, utf8_decode($dato->observaciones), 1, 'L');
        }
        $pdf->Cell(70, 7, utf8_decode("Inidice de reprobación por unidad"), 1, 0, 'L');
        $indices = $this->getIndices($id_materia, $id_grupo, $periodo->id_periodo);

        for ($i = 0; $i < $indices->count(); $i++)
            $pdf->Cell($withCell, 7, $indices[$i] . "%", 1, 0, 'C');

        $pdf->ln();
        $pdf->SetFont('Arial', 'B', '12');
        $pdf->Cell(70, 7, utf8_decode("Acciones preventivas:"), 0, 0, 'L');
        $pdf->SetFont('Arial', '', '11');
        $pdf->ln();
        $acciones = $this->getAcciones($id_materia, $id_grupo, $periodo->id_periodo);
        foreach ($acciones as $accion) {
            $pdf->Cell(70, 7, utf8_decode($accion->acciones_preventivas), 0, 0, 'L');
            $pdf->ln();
        }
        $pdf->Output();
        exit();
    }
    public function reporteTutor($id_docente, $id_materia, $id_grupo)
    {

        $periodo = Periodos::find(Session::get('periodo_actual'));
        $materia = Gnral_Materias::find($id_materia);
        $docente = Gnral_Personales::find($id_docente);

        $datos = $this->getIndiceTutor();
        /// dd($materia);
        // dd($docente);
        //270 with fpdf
        $pdf = new FPDF($orientation = 'L', $unit = 'mm', $format = 'Letter');
        $pdf->SetTitle("Reporte");
        $pdf->SetMargins(5, 20, 0);
        $pdf->SetAutoPageBreak(true, 25);
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', '14');
        $pdf->Cell(270, 7, utf8_decode('Reporte de canalización'), 1, 0, 'C');
        $pdf->ln();

        $pdf->Cell(80, 7, utf8_decode('Docente:'), 1, 0, 'L');
        $pdf->Cell(190, 7, utf8_decode($docente->nombre), 1, 0, 'L');
        $pdf->ln();
        $pdf->Cell(67.5, 7, utf8_decode('Grupo'), 1, 0, 'L');
        $pdf->Cell(67.5, 7, utf8_decode($materia->id_semestre . '0' . $id_grupo), 1, 0, 'L');
        $pdf->Cell(50, 7, utf8_decode('Periodo:'), 1, 0, 'L');
        $pdf->Cell(85, 7, utf8_decode($periodo->periodo), 1, 0, 'L');
        $pdf->ln();
        $pdf->ln();

        foreach ($datos as $dato) {
            $pdf->SetFont('Arial', '', '13');
            $pdf->Cell(270, 7, utf8_decode('Nombre: '.$dato->nombre), 1, 0, 'C');
            $pdf->ln();
            $pdf->cell(70, 7, utf8_decode('Asignatura'), 1, 0, 'C');
            $pdf->cell(32, 7, utf8_decode('% reprobación'), 1, 0, 'C');
            $pdf->cell(80, 7, utf8_decode('Canalización'), 1, 0, 'C');
            $pdf->cell(88, 7, utf8_decode('Observaciones'), 1, 0, 'C');
            $pdf->SetFont('Arial', '', '11');
            $pdf->ln();
            foreach ($dato->materias as $materia) {

                $x=$pdf->GetX();
                $y=$pdf->GetY();
                $pdf->MultiCell(70, 7, utf8_decode($materia->nombre), 1, 'C');
                $y=$pdf->GetY()-$y;
                $pdf->setXY($x+70,($pdf->GetY()-$y));
                $pdf->cell(32, $y,utf8_decode($materia->indice), 1,  0,'C');
                $pdf->cell(80, $y,utf8_decode($materia->canalizaciones), 1,  0,'C');
                $pdf->cell(88, $y,utf8_decode($materia->observaciones), 1,  0,'C');
            }
            $pdf->ln();
            $pdf->ln();

        }

        $pdf->Output();
        exit();
    }

    private function getAcciones($id_materia, $id_grupo, $periodo)
    {

        return calPeriodos::whereIdMateria($id_materia)->whereEvaluada(1)
            ->where("acciones_preventivas", "!=", "")
            ->whereIdGrupo($id_grupo)
            ->whereIdPeriodos($periodo)
            ->select("acciones_preventivas")->get();

    }

    private function getIndices($id_materia, $id_grupo, $periodo)
    {
        return calPeriodos::whereIdMateria($id_materia)
            ->whereIdGrupo($id_grupo)
            ->whereEvaluada(1)
            ->whereIdPeriodos($periodo)->get()->map(function ($row) use ($id_grupo, $id_materia, $periodo) {
                $indice = round((calEvaluaciones::join("eva_carga_academica", "cal_evaluaciones.id_carga_academica", "eva_carga_academica.id_carga_academica")
                        ->whereIdMateria($id_materia)
                        ->whereIdPeriodo($periodo)
                        ->where("calificacion", "<", 70)
                        ->whereGrupo($id_grupo)
                        ->whereIdUnidad($row->id_unidad)->count() / calEvaluaciones::join("eva_carga_academica", "cal_evaluaciones.id_carga_academica", "eva_carga_academica.id_carga_academica")
                        ->whereIdMateria($id_materia)
                        ->whereIdPeriodo($periodo)
                        ->whereGrupo($id_grupo)
                        ->whereIdUnidad($row->id_unidad)->count() * 100));
                return $indice;
            });
    }
    private function getDatos($id_docente, $id_materia, $id_grupo, $periodo, $unidades)
    {

        $datos = CargaAcademica::join("gnral_alumnos", "eva_carga_academica.id_alumno", "gnral_alumnos.id_alumno")
            ->join("cal_evaluaciones", "cal_evaluaciones.id_carga_academica", "eva_carga_academica.id_carga_academica")
            ->where("cal_evaluaciones.calificacion", "<", 70)
            ->whereIdMateria($id_materia)
            ->where("eva_carga_academica.grupo", $id_grupo)
            ->whereIdPeriodo($periodo)
            ->select(DB::raw("CONCAT(gnral_alumnos.apaterno,' ',gnral_alumnos.amaterno,' ',gnral_alumnos.nombre) AS nombre"), "gnral_alumnos.id_alumno", "eva_carga_academica.id_carga_academica")
            ->groupBy("cuenta")
            ->orderBy("nombre")
            ->get();
        $datos->map(function ($row) use($unidades) {
            $row["evaluaciones"] = calEvaluaciones::whereIdCargaAcademica($row->id_carga_academica)
                ->select("calificacion")
                ->orderBy("id_unidad", "ASC")->get();
            $row["observaciones"] = calEvaluaciones::whereIdCargaAcademica($row->id_carga_academica)
                ->where("calificacion", "<", "70")
                ->select("observaciones")
                ->groupBy("observaciones")->get("observaciones")->implode("observaciones", ", ");
            $row["indice"] = round((calEvaluaciones::whereIdCargaAcademica($row->id_carga_academica)
                    ->where("calificacion", "<", 70)
                    ->count() / $unidades * 100));
            $row["canalizaciones"]=calEvaluaciones::join("cal_canalizacion","cal_canalizacion.id","cal_evaluaciones.id_canalizacion")
                ->whereNotNull("cal_evaluaciones.id_canalizacion")
                ->whereIdCargaAcademica($row->id_carga_academica)
                ->groupBy("cal_canalizacion.id")->get()->implode("descripcion",", ");

            return $row;

        });


        return $datos;
    }

    private function getIndiceTutor(){

        $datos=Alumnos::join("eva_carga_academica", "eva_carga_academica.id_alumno","gnral_alumnos.id_alumno")
            ->join("cal_evaluaciones","cal_evaluaciones.id_carga_academica","eva_carga_academica.id_carga_academica")
            ->where("cal_evaluaciones.calificacion","<",70)
            ->whereNotNull("cal_evaluaciones.id_canalizacion")///filtro para solo los canalizados
            ->where("gnral_alumnos.id_carrera",2)
            ->whereIdPeriodo(21)
            ->where("gnral_alumnos.id_semestre",8)
            ->where("gnral_alumnos.grupo",1)
            ->select(DB::raw("CONCAT(gnral_alumnos.apaterno,' ',gnral_alumnos.amaterno,' ',gnral_alumnos.nombre) AS nombre"),"gnral_alumnos.id_alumno")
            ->groupBy("nombre")
            ->orderBy("nombre")
            ->get();
        $datos->map(function ($row){
            $row["materias"]=CargaAcademica::join("gnral_materias","gnral_materias.id_materia","eva_carga_academica.id_materia")
                ->join("cal_evaluaciones","cal_evaluaciones.id_carga_academica","eva_carga_academica.id_carga_academica")
                ->where("cal_evaluaciones.calificacion","<",70)
                ->where("eva_carga_academica.id_alumno",$row->id_alumno)
                ->where("eva_carga_academica.id_periodo",21)
                ->select("gnral_materias.unidades","gnral_materias.nombre","eva_carga_academica.id_carga_academica")
                ->groupBy("nombre")
                ->get();
            $row["materias"]->map(function($dat){
                $dat["indice"]=(int)(calEvaluaciones::whereIdCargaAcademica($dat->id_carga_academica)
                        ->where("calificacion","<",70)
                        ->count()/$dat->unidades*100);
                $dat["observaciones"]=calEvaluaciones::whereIdCargaAcademica($dat->id_carga_academica)
                    ->where("calificacion","<","70")
                    ->select("observaciones")
                    ->groupBy("observaciones")->get("observaciones")->implode("observaciones",", ");
                $dat["canalizaciones"]=calEvaluaciones::join("cal_canalizacion","cal_canalizacion.id","cal_evaluaciones.id_canalizacion")
                    ->whereNotNull("cal_evaluaciones.id_canalizacion")
                    ->whereIdCargaAcademica($dat->id_carga_academica)
                    ->groupBy("cal_canalizacion.id")->get()->implode("descripcion",", ");

                return $dat;
            });
            return $row;
        });

        return $datos;
    }
}
