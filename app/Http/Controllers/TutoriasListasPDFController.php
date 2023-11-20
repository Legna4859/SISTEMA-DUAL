<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Codedge\Fpdf\Fpdf\Fpdf;

use Session;
use PDF;
class TutoriasListasPDFController extends Controller
{
    public function index($id_asigna_tutor){
        $id_jefe_periodo=Session::get('id_jefe_periodo');
        $nombre_periodo=DB::selectOne('SELECT gnral_periodos.periodo, gnral_jefes_periodos.*, gnral_carreras.nombre carrera
      from gnral_periodos, gnral_jefes_periodos, gnral_carreras WHERE gnral_periodos.id_periodo = gnral_jefes_periodos.id_periodo 
      and gnral_jefes_periodos.id_jefe_periodo= '.$id_jefe_periodo.' and  gnral_carreras.id_carrera = gnral_jefes_periodos.id_carrera ');


        $estudiantes=DB::select('SELECT gnral_alumnos.id_alumno, gnral_alumnos.cuenta,
       gnral_alumnos.nombre, gnral_alumnos.apaterno, gnral_alumnos.amaterno FROM gnral_alumnos, 
       exp_asigna_generacion, exp_asigna_alumnos, exp_asigna_tutor where exp_asigna_tutor.id_asigna_tutor= '.$id_asigna_tutor.' and 
       exp_asigna_tutor.id_asigna_generacion = exp_asigna_generacion.id_asigna_generacion and
       exp_asigna_alumnos.id_asigna_generacion = exp_asigna_generacion.id_asigna_generacion and
       exp_asigna_alumnos.id_alumno = gnral_alumnos.id_alumno  
       ORDER BY `gnral_alumnos`.`apaterno` ASC, gnral_alumnos.amaterno ASC, gnral_alumnos.nombre');
        $datos_grupo=DB::selectOne('SELECT exp_asigna_tutor.*,gnral_personales.nombre,tu_grupo_semestre.id_grupo_semestre,tu_grupo_semestre.id_grupo_tutorias,
       exp_asigna_generacion.grupo, exp_generacion.generacion,tu_grupo_tutorias.descripcion grup from  tu_grupo_semestre,
       exp_asigna_tutor, gnral_personales, exp_asigna_generacion, exp_generacion,tu_grupo_tutorias where 
       exp_asigna_tutor.id_asigna_generacion = exp_asigna_generacion.id_asigna_generacion 
      and exp_asigna_tutor.id_personal = gnral_personales.id_personal and exp_asigna_generacion.id_generacion= exp_generacion.id_generacion and tu_grupo_semestre.id_grupo_tutorias = tu_grupo_tutorias.id_grupo_tutorias
      and tu_grupo_semestre.id_asigna_tutor = exp_asigna_tutor.id_asigna_tutor
      and exp_asigna_tutor.id_asigna_tutor='.$id_asigna_tutor.' ');
        $fechas = date("Y-m-d");

        $num=date("j",strtotime($fechas));
        $ano=date("Y", strtotime($fechas));
        $mes= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $mes=$mes[(date('m', strtotime($fechas))*1)-1];
        $fech= $num. ' de '.$mes.' del '.$ano;

        $pdf = PDF::loadView('tutorias.jefe.pdf_listas_asistenacia',compact('nombre_periodo','estudiantes','datos_grupo','fech'));
        return $pdf->stream('lista.pdf');

    }
}
