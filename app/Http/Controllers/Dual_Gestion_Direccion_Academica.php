<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class Dual_Gestion_Direccion_Academica extends Controller
{
    public function index()
    {
        $carreras = DB::table('gnral_carreras')
            ->where('id_carrera', '!=', 9)
            ->where('id_carrera', '!=', 11)
            ->where('id_carrera', '!=', 15)
            ->get();
        return view('duales.Gestion_Academica.carreras_duales',compact('carreras'));
    }
    public function ver_docentes_duales()
    {
        $id_carrera=Session::get('carrera');
        $id_periodo=Session::get('periodo_actual');
        $datos = DB::table('cal_duales_actuales')
            ->join('gnral_alumnos', 'gnral_alumnos.id_alumno', '=', 'cal_duales_actuales.id_alumno')
            ->join('gnral_personales', 'cal_duales_actuales.id_personal', '=', 'gnral_personales.id_personal')
            ->join('abreviaciones_prof', 'gnral_personales.id_personal', '=', 'abreviaciones_prof.id_personal')
            ->join('abreviaciones', 'abreviaciones_prof.id_abreviacion', '=', 'abreviaciones.id_abreviacion')
            ->select('gnral_personales.nombre as profesor', 'abreviaciones.titulo')
            ->distinct()
            ->where('cal_duales_actuales.id_periodo', $id_periodo)
            ->get();
        //dd($datos);

        //dd($datos_registros);
        return view('duales.Gestion_Academica.docentes_duales', compact('datos'));
    }
    public function ver_alumnos_duales()
    {
        $id_periodo = Session::get('periodo_actual');
        $alumnos = DB::select('SELECT gnral_alumnos.id_alumno,  gnral_alumnos.cuenta,  gnral_alumnos.nombre,  gnral_alumnos.apaterno,  gnral_alumnos.amaterno, MAX(cal_duales_actuales.id_duales_actuales) AS max_id_duales_actuales, MAX(IFNULL(eva_validacion_de_cargas.estado_validacion, 0)) AS max_estado_validacion
        FROM  gnral_alumnos
        JOIN cal_duales_actuales ON gnral_alumnos.id_alumno = cal_duales_actuales.id_alumno
        JOIN eva_carga_academica ON gnral_alumnos.id_alumno = eva_carga_academica.id_alumno
        JOIN gnral_materias ON eva_carga_academica.id_materia = gnral_materias.id_materia
        JOIN gnral_reticulas ON gnral_materias.id_reticula = gnral_reticulas.id_reticula
        LEFT JOIN eva_validacion_de_cargas ON eva_carga_academica.id_alumno = eva_validacion_de_cargas.id_alumno
        AND eva_validacion_de_cargas.id_periodo = eva_carga_academica.id_periodo 
        WHERE cal_duales_actuales.id_periodo = ' . $id_periodo . '  
        AND gnral_materias.id_semestre > 5  
        AND eva_carga_academica.id_status_materia = 1 
        AND eva_carga_academica.id_periodo = ' . $id_periodo . '
        AND eva_validacion_de_cargas.estado_validacion= 8
        GROUP BY gnral_alumnos.id_alumno, gnral_alumnos.cuenta, gnral_alumnos.nombre, gnral_alumnos.apaterno, gnral_alumnos.amaterno
        ORDER BY gnral_alumnos.apaterno, gnral_alumnos.amaterno, gnral_alumnos.nombre ASC');
        //dd($alumnos);
        return view('duales.Gestion_Academica.alumnos_duales',compact('alumnos'));
    }

}